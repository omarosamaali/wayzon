import makeWASocket, {
    useMultiFileAuthState,
    DisconnectReason,
    fetchLatestBaileysVersion,
} from '@whiskeysockets/baileys';
import { Boom } from '@hapi/boom';
import QRCode from 'qrcode';
import express from 'express';
import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const app = express();
app.use(express.json());

const clients = {};
const clientStatus = {};
const pendingClients = new Map();
const reconnectAttempts = new Map();
const keepAliveIntervals = new Map();

function startKeepAlive(tenantId, sock) {
    if (keepAliveIntervals.has(tenantId)) clearInterval(keepAliveIntervals.get(tenantId));
    const iv = setInterval(() => {
        const status = clientStatus[tenantId];
        if (!status || status.state !== 'ready' || clients[tenantId] !== sock) {
            clearInterval(iv);
            keepAliveIntervals.delete(tenantId);
            return;
        }
        try {
            sock.sendPresenceUpdate('available').catch(() => {});
        } catch { /* ignore */ }
    }, 25_000);
    keepAliveIntervals.set(tenantId, iv);
}

// ── Config ──
const LARAVEL_URL     = process.env.LARAVEL_URL     || 'http://localhost:8000';
const INTERNAL_SECRET = process.env.INTERNAL_SECRET || 'wyns-internal-2024';
const OPENAI_API_KEY  = process.env.OPENAI_API_KEY  || '';

// ── Manual pause map: tenantId → Map<phone, expiryMs> ──
const manualPauseMap = new Map();

// ── Awaiting support reason: "tenantId:phone" → { supportPhone, timestamp } ──
const awaitingSupportReason = new Map();

// ── Track bot-sent message IDs to avoid self-triggering manual pause ──
const botSentIds = new Set();

// ── Track recent bot-send timestamps: "tenantId:phone" → ms ──
// Guards against race condition where messages.upsert fires before botSentIds.add()
const recentBotSendTs = new Map();

// ── Dedup: track processed message IDs to prevent double-handling
//    (messaging-history.set and messages.upsert can fire for the same msg)
const processedMsgIds = new Set();
setInterval(() => processedMsgIds.clear(), 5 * 60 * 1000);

function getManualPauses(tenantId) {
    if (!manualPauseMap.has(tenantId)) manualPauseMap.set(tenantId, new Map());
    return manualPauseMap.get(tenantId);
}

function isManuallyPaused(tenantId, phone) {
    const pauses = getManualPauses(tenantId);
    const expiry = pauses.get(phone);
    if (!expiry) return false;
    if (Date.now() > expiry) { pauses.delete(phone); return false; }
    return true;
}

function setPause(tenantId, phone, minutes) {
    getManualPauses(tenantId).set(phone, Date.now() + minutes * 60 * 1000);
    console.log(`[${tenantId}] bot paused for ${phone} — ${minutes} min`);
}

// ── Send helper: records timestamp + tracks ID to prevent false manual-pause triggers ──
async function sendBotMsg(sock, tenantId, phone, replyJid, text) {
    recentBotSendTs.set(`${tenantId}:${phone}`, Date.now());
    const sent = await sock.sendMessage(replyJid, { text });
    if (sent?.key?.id) {
        botSentIds.add(sent.key.id);
        setTimeout(() => botSentIds.delete(sent.key.id), 30000);
    }
    return sent;
}

// ── Conversation history: Map<"tenantId:phone", [{role, content}]> ──
const conversationHistory = new Map();

function getHistory(tenantId, phone) {
    const key = `${tenantId}:${phone}`;
    if (!conversationHistory.has(key)) conversationHistory.set(key, []);
    return conversationHistory.get(key);
}

function addToHistory(tenantId, phone, role, content) {
    const history = getHistory(tenantId, phone);
    history.push({ role, content });
    if (history.length > 8) history.splice(0, 2);
}

function clearHistory(tenantId, phone) {
    conversationHistory.delete(`${tenantId}:${phone}`);
}

// ── Bot config cache (per tenant, 5-min TTL) ──
const botConfigCache = new Map();

async function getBotConfig(tenantId) {
    const cached = botConfigCache.get(tenantId);
    if (cached && Date.now() - cached.ts < 5 * 60 * 1000) return cached.data;

    try {
        const res = await fetch(
            `${LARAVEL_URL}/internal/bot-config?tenant_id=${tenantId}`,
            { headers: { 'X-Internal-Secret': INTERNAL_SECRET } }
        );
        const json = await res.json();
        botConfigCache.set(tenantId, { ts: Date.now(), data: json });
        return json;
    } catch (e) {
        console.error('getBotConfig error', e.message);
        return {};
    }
}

// ── Build dynamic system prompt ──
function buildSystemPrompt(storeName, cfg) {
    const name = storeName || 'المتجر';
    const c = cfg?.config || {};

    let prompt = `أنت موظف خدمة عملاء لمتجر "${name}" على سلة — تتكلم بالعربية بلهجة سعودية مهذبة.
قواعد صارمة لا تُخالَف:
- ردودك قصيرة ومباشرة، بدون حشو أو مقدمات.
- أنت تتحدث عبر الواتساب مباشرةً — لا ترسل روابط wa.me أبداً ولا تطلب من العميل التواصل عبر الواتساب لأنه يتكلم معك فيه الآن.
- لا تُفصح عن أي بيانات تواصل (أرقام هواتف، إيميلات، روابط) لم تُذكر صراحةً في التدريب.
- إذا ذكر العميل رقم طلب ستجد معلوماته في الرسالة — استخدمها مباشرة.
- لا تسأل أكثر من سؤال واحد في الرسالة.
- إذا اهتم العميل بمنتج شجّعه بشكل طبيعي.
- إذا لم تعرف الجواب قل "سأحيل استفساركم للمختص وسيتواصل معك قريباً".`;

    const policies = [];

    // Comprehensive training (new single-field) takes priority
    if (c.store_training) {
        prompt += `\n\n--- معلومات المتجر (مُدرَّبة من التاجر) ---\n${c.store_training}\n⚠️ استخدم هذه المعلومات عند السؤال عنها — لا تخترع معلومات.`;
    } else {
        // Legacy separate fields
        if (c.store_desc) {
            prompt += `\n\nمعلومات المتجر:\n${c.store_desc}`;
        }
        if (c.work_hours)      policies.push(`⏰ أوقات العمل: ${c.work_hours}`);
        if (c.shipping_policy) policies.push(`🚚 سياسة الشحن: ${c.shipping_policy}`);
        if (c.return_policy)   policies.push(`🔄 سياسة الإرجاع: ${c.return_policy}`);
        if (c.payment_methods) policies.push(`💳 طرق الدفع: ${c.payment_methods}`);
        if (policies.length > 0) {
            prompt += `\n\n--- معلومات يجب استخدامها عند السؤال عنها ---\n${policies.join('\n')}\n⚠️ مهم: أجب بالمعلومات المذكورة أعلاه مباشرة — لا تخترع معلومات.`;
        }
    }
    if (c.faqs?.length) {
        prompt += `\n\nأسئلة شائعة مخصصة:`;
        c.faqs.forEach(f => {
            if (f.q && f.a) prompt += `\nسؤال: ${f.q}\nجواب: ${f.a}`;
        });
    }
    if (c.reply_with_name === false) {
        prompt += `\n\nلا تذكر اسم العميل في ردودك.`;
    }
    if (c.multi_lang === false) {
        prompt += `\n\nرد دائماً بالعربية بغض النظر عن لغة العميل.`;
    }

    return prompt;
}

// ── OpenAI call — always gpt-4o-mini for cost control ──
async function callOpenAI(messages) {
    if (!OPENAI_API_KEY) return null;
    try {
        const res = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${OPENAI_API_KEY}`,
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini',
                messages,
                max_tokens: 200,
                temperature: 0.7,
            }),
        });
        const data = await res.json();
        return data.choices?.[0]?.message?.content?.trim() || null;
    } catch (e) {
        console.error('OpenAI error', e.message);
        return null;
    }
}

// ── Order lookup ──
async function lookupOrder(tenantId, orderId) {
    try {
        const res = await fetch(
            `${LARAVEL_URL}/internal/order-status?tenant_id=${tenantId}&order_id=${encodeURIComponent(orderId)}`,
            { headers: { 'X-Internal-Secret': INTERNAL_SECRET } }
        );
        return await res.json();
    } catch (e) {
        console.error('lookupOrder error', e.message);
        return { found: false };
    }
}

// ── Product search ──
async function lookupProduct(tenantId, query, opts = {}) {
    try {
        const catalog = opts.catalog ? '&catalog=1' : '';
        const res = await fetch(
            `${LARAVEL_URL}/internal/product-search?tenant_id=${tenantId}&q=${encodeURIComponent(query)}${catalog}`,
            { headers: { 'X-Internal-Secret': INTERNAL_SECRET } }
        );
        return await res.json();
    } catch (e) {
        console.error('lookupProduct error', e.message);
        return { found: false };
    }
}

// ── Detect manual reply by merchant → pause bot for that contact ──
async function handleManualReply(tenantId, msg) {
    const jid = msg.key.remoteJid;
    if (!jid || jid.endsWith('@g.us') || jid.endsWith('@broadcast')) return;

    let phone;
    if (jid.endsWith('@lid')) {
        const altJid = msg.key.remoteJidAlt;
        if (!altJid || !altJid.includes('@s.whatsapp.net')) return;
        phone = altJid.replace('@s.whatsapp.net', '');
    } else {
        phone = jid.replace('@s.whatsapp.net', '');
    }

    // Guard against race condition: if bot sent to this number within last 3s, skip
    const tsKey = `${tenantId}:${phone}`;
    const lastBotSend = recentBotSendTs.get(tsKey) || 0;
    if (Date.now() - lastBotSend < 3000) {
        console.log(`[${tenantId}] handleManualReply skipped — bot sent to ${phone} recently`);
        return;
    }

    const botCfg = await getBotConfig(tenantId);
    const c = botCfg?.config || {};
    if (!c.stop_on_manual) return;
    const minutes = parseInt(c.manual_resume_after) || 30;
    setPause(tenantId, phone, minutes);
    console.log(`[${tenantId}] manual pause set for ${phone} — ${minutes} min`);
}

// ── Main message handler ──
async function handleIncomingMessage(tenantId, sock, msg) {
    const jid = msg.key.remoteJid;
    const isGroup = jid.endsWith('@g.us');
    if (isGroup || msg.key.fromMe) return;

    // WhatsApp @lid protocol: incoming messages arrive with @lid remoteJid
    // The actual sender phone is in remoteJidAlt
    let phone, replyJid;
    if (jid.endsWith('@lid')) {
        const altJid = msg.key.remoteJidAlt;
        if (!altJid || !altJid.includes('@s.whatsapp.net')) {
            console.log(`[${tenantId}] @lid msg skipped — no remoteJidAlt`);
            return;
        }
        phone = altJid.replace('@s.whatsapp.net', '');
        replyJid = altJid;
    } else {
        phone = jid.replace('@s.whatsapp.net', '');
        replyJid = jid;
    }

    const text  = (
        msg.message?.conversation ||
        msg.message?.extendedTextMessage?.text ||
        ''
    ).trim();

    if (!text) {
        const firstKey = msg.message ? Object.keys(msg.message)[0] : 'null';
        const protoType = msg.message?.protocolMessage?.type;
        const snippet = JSON.stringify(msg.message).substring(0, 150);
        console.log(`[${tenantId}] msg skipped - key=${firstKey} protoType=${protoType} data=${snippet}`);
        return;
    }

    console.log(`[${tenantId}] incoming from ${phone}: ${text}`);

    // ── Support reason pending: customer is replying with their support reason ──
    const awaitKey = `${tenantId}:${phone}`;
    if (awaitingSupportReason.has(awaitKey)) {
        const { supportPhone } = awaitingSupportReason.get(awaitKey);
        awaitingSupportReason.delete(awaitKey);

        // Forward to merchant's support number
        if (supportPhone && clients[tenantId]) {
            const supportJid = supportPhone + '@s.whatsapp.net';
            const notifyMsg = `🚨 *طلب دعم فني جديد*\n\n👤 العميل: +${phone}\n📱 الرقم: +${phone}\n📝 *السبب:*\n"${text}"`;
            try { await sock.sendMessage(supportJid, { text: notifyMsg }); } catch(e) { console.error(`[${tenantId}] support notify failed:`, e.message); }
        }

        // Confirm to customer
        const reply = 'تم تحويل طلبك للدعم الفني ✅\nالرجاء الانتظار وسيتم الرد عليك قريبًا.';
        await sendBotMsg(sock, tenantId, phone, replyJid, reply);

        // Pause AI for this chat (60 min default)
        setPause(tenantId, phone, 60);
        console.log(`[${tenantId}] support reason received from ${phone} — forwarded & paused`);
        return;
    }

    // Bot paused for this contact due to manual intervention
    if (isManuallyPaused(tenantId, phone)) {
        console.log(`[${tenantId}] bot paused for ${phone} — skipping`);
        return;
    }

    const botCfg = await getBotConfig(tenantId);
    const c = botCfg?.config || {};

    // ── 1. FAQ matching — no AI needed ──
    if (c.faqs?.length) {
        const lowerText = text.toLowerCase();
        for (const faq of c.faqs) {
            if (!faq.q || !faq.a) continue;
            const keywords = faq.q.toLowerCase().split(/\s+/).filter(w => w.length > 2);
            const matched = keywords.filter(k => lowerText.includes(k)).length;
            if (matched >= Math.min(2, keywords.length)) {
                console.log(`[${tenantId}] FAQ match → no AI`);
                await sendBotMsg(sock, tenantId, phone, replyJid, faq.a);
                addToHistory(tenantId, phone, 'user', text);
                addToHistory(tenantId, phone, 'assistant', faq.a);
                return;
            }
        }
    }

    // ── 2. Product search — skip if merchant has custom training (AI handles it) ──
    const productKeywords = ['سعر', 'بكم', 'بكام', 'منتج', 'متوفر', 'يتوفر', 'موجود', 'أسعار', 'اسعار', 'عندكم', 'عندك', 'تبيعون', 'تبيع', 'عرض', 'كتالوج', 'قائمة'];
    const isProductQuery  = productKeywords.some(k => text.includes(k));

    if (isProductQuery) {
        const searchTerm = text.replace(/[؟?!،,]/g, ' ').trim();
        const catalogOnly = searchTerm.length < 3 || /^(عندكم|وش|ايش|شنو|منتجات)/i.test(searchTerm.trim());
        const data = await lookupProduct(tenantId, searchTerm || text, { catalog: catalogOnly });
        if (data.found && data.products?.length) {
            let reply = 'هذي المنتجات المتاحة 👇\n\n';
            data.products.forEach((p, i) => {
                reply += `*${i + 1}. ${p.name}*\n`;
                if (p.price) reply += `السعر: ${p.price} ر.س\n`;
                if (p.unlimited) reply += 'المخزون: متوفر ✅\n';
                else if (p.in_stock) reply += (p.stock != null ? `المخزون: متوفر (${p.stock} قطعة) ✅\n` : 'المخزون: متوفر ✅\n');
                else reply += 'المخزون: غير متوفر ❌\n';
                reply += '\n';
            });
            reply = reply.trim();
            console.log(`[${tenantId}] PRODUCT direct reply → ${phone}`);
            await sendBotMsg(sock, tenantId, phone, replyJid, reply);
            addToHistory(tenantId, phone, 'user', text);
            addToHistory(tenantId, phone, 'assistant', reply);
            return;
        }
        // Product not found — fall through to AI
    }

    // ── 3. Order lookup — respond directly without AI ──
    const orderMatch = text.match(/\b\d{4,}\b/);
    const orderKeywords = ['طلب', 'اوردر', 'order', 'شحن', 'توصيل', 'وصل', 'وين', 'متى', 'تتبع'];
    const isOrderQuery = orderMatch || orderKeywords.some(k => text.includes(k));

    if (orderMatch) {
        const data = await lookupOrder(tenantId, orderMatch[0]);
        if (data.found) {
            const statusMap = {
                'in_progress': 'قيد التنفيذ 🔄', 'paid': 'تم الدفع ✅',
                'shipped': 'تم الشحن 🚚', 'delivering': 'في الطريق إليك 🛵',
                'out_for_delivery': 'في الطريق إليك 🛵', 'delivered': 'تم التوصيل ✅',
                'completed': 'تم التوصيل ✅',
                'canceled': 'ملغي ❌', 'returned': 'مسترجع 🔁',
                'pending_payment': 'بانتظار الدفع 💳',
            };
            const statusLabel = data.status_label || statusMap[data.status] || data.status;
            const totalNum = Number(data.total);
            const totalStr = Number.isFinite(totalNum) ? totalNum.toFixed(2).replace(/\.00$/, '') : String(data.total ?? '0');
            const reply = `مرحباً 👋\nطلبك رقم *#${data.order_id}*\nالحالة: ${statusLabel}\nالإجمالي: ${totalStr} ر.س`;
            console.log(`[${tenantId}] ORDER direct reply → ${phone}`);
            await sendBotMsg(sock, tenantId, phone, replyJid, reply);
            addToHistory(tenantId, phone, 'user', text);
            addToHistory(tenantId, phone, 'assistant', reply);
            return;
        } else {
            const reply = `ما لقيت طلب برقم ${orderMatch[0]} 🔍\nتأكد من الرقم أو أرسل لي رقم الطلب من رسالة التأكيد.`;
            await sendBotMsg(sock, tenantId, phone, replyJid, reply);
            addToHistory(tenantId, phone, 'user', text);
            addToHistory(tenantId, phone, 'assistant', reply);
            return;
        }
    }

    if (isOrderQuery && !orderMatch) {
        const reply = 'أرسل لي رقم طلبك وأخبرك بحالته فوراً 📦';
        await sendBotMsg(sock, tenantId, phone, replyJid, reply);
        addToHistory(tenantId, phone, 'user', text);
        addToHistory(tenantId, phone, 'assistant', reply);
        return;
    }

    // ── 3. Support transfer ──
    const supportKeywords = ['موظف', 'بشري', 'إنسان', 'انسان', 'دعم', 'مسؤول', 'حولني', 'تحويل', 'تكلم', 'اتصل', 'تواصل مع', 'مشكلة', 'مو فاهم', 'ما فهمت'];
    const isSupportRequest = supportKeywords.some(k => text.includes(k));
    if (isSupportRequest && c.support_phone) {
        awaitingSupportReason.set(`${tenantId}:${phone}`, { supportPhone: c.support_phone, timestamp: Date.now() });
        const reply = 'يبدو أنك تحتاج مساعدة من الدعم الفني 🙏\nاكتب سبب طلب الدعم باختصار وسيتم تحويلك فوراً.';
        await sendBotMsg(sock, tenantId, phone, replyJid, reply);
        addToHistory(tenantId, phone, 'user', text);
        addToHistory(tenantId, phone, 'assistant', reply);
        return;
    }

    // ── 4. AI for general questions only ──
    const activePlans = ['pro', 'growth', 'trial', 'smart', 'basic'];
    if (!activePlans.includes(botCfg.plan)) {
        console.log(`[${tenantId}] plan=${botCfg.plan} — AI skipped`);
        return;
    }

    addToHistory(tenantId, phone, 'user', text);
    const history = getHistory(tenantId, phone);

    let systemPrompt = buildSystemPrompt(botCfg.store_name, botCfg);
    if (botCfg.global_prompt) {
        systemPrompt = botCfg.global_prompt + '\n\n---\n\n' + systemPrompt;
    }
    const messages = [
        { role: 'system', content: systemPrompt },
        ...history,
    ];

    const aiReply = await callOpenAI(messages);

    if (!aiReply) {
        await sendBotMsg(sock, tenantId, phone, replyJid, 'أهلاً بك! 👋\nكيف أقدر أساعدك؟');
        return;
    }

    addToHistory(tenantId, phone, 'assistant', aiReply);
    console.log(`[${tenantId}] AI reply to ${phone}: ${aiReply.substring(0, 60)}`);
    const sent = await sendBotMsg(sock, tenantId, phone, replyJid, aiReply);
    console.log(`[${tenantId}] sent OK to ${phone}, msgId=${sent?.key?.id}`);
    if (sent?.key?.id) {
        // already tracked in sendBotMsg
    }
}

function authDir(tenantId) {
    return path.join(__dirname, '.auth', tenantId);
}

async function teardown(tenantId) {
    pendingClients.delete(tenantId);
    const sock = clients[tenantId];
    if (sock) {
        try {
            sock.end(new Boom('Session reset', { statusCode: DisconnectReason.loggedOut }));
        } catch {
            /* ignore */
        }
        delete clients[tenantId];
    }
    delete clientStatus[tenantId];
    const folder = authDir(tenantId);
    if (fs.existsSync(folder)) {
        fs.rmSync(folder, { recursive: true, force: true });
    }
}

function socketConfig(state, version, msgStore) {
    return {
        version,
        auth: state,
        syncFullHistory: false,
        shouldSyncHistoryMessage: () => false,
        getMessage: async (key) => {
            const stored = msgStore?.get(key.id);
            return stored || { conversation: '' };
        },
        markOnlineOnConnect: false,
        connectTimeoutMs: 60_000,
        qrTimeout: 60_000,
        defaultQueryTimeoutMs: 60_000,
        retryRequestDelayMs: 2_000,
        maxMsgRetryCount: 3,
    };
}

async function createSocket(tenantId, options = {}) {
    const pairingPhone = options.pairingPhone || null;

    const authFolder = authDir(tenantId);
    fs.mkdirSync(authFolder, { recursive: true });

    const { state, saveCreds } = await useMultiFileAuthState(authFolder);
    const { version } = await fetchLatestBaileysVersion();

    clientStatus[tenantId] = { state: 'initializing', qr: null, pairingCode: null };

    const msgStore = new Map();
    const sock = makeWASocket(socketConfig(state, version, msgStore));

    sock.ev.on('creds.update', saveCreds);

    const processedHistoryIds = new Set();

    sock.ev.on('messaging-history.set', async ({ messages: histMsgs }) => {
        const cutoff = Date.now() - 5 * 60 * 1000;
        const recent = (histMsgs || []).filter(m => {
            const t = (m.messageTimestamp || 0) * 1000;
            return t >= cutoff && !m.key.fromMe
                && !m.key.remoteJid?.endsWith('@lid')
                && !m.key.remoteJid?.endsWith('@g.us')
                && !processedHistoryIds.has(m.key.id)
                && !processedMsgIds.has(m.key.id);
        });
        for (const msg of recent) {
            processedHistoryIds.add(msg.key.id);
            processedMsgIds.add(msg.key.id);
            console.log(`[${tenantId}] history-msg from ${msg.key.remoteJid}`);
            await handleIncomingMessage(tenantId, sock, msg).catch(e =>
                console.error(`[${tenantId}] history handleIncomingMessage error`, e.message)
            );
        }
    });

    sock.ev.on('messages.upsert', async ({ messages, type }) => {
        for (const m of messages) { if (m.key?.id && m.message) msgStore.set(m.key.id, m.message); }
        // Debug: log ALL raw messages with full detail
        for (const m of messages) {
            const msgType = Object.keys(m.message || {})[0] || 'null';
            const participant = m.key.participant || '';
            console.log(`[${tenantId}] RAW upsertType=${type} jid=${m.key.remoteJid} fromMe=${m.key.fromMe} msgType=${msgType} participant=${participant} id=${m.key.id}`);
            // Log full content of @lid messages to understand what they carry
            if (m.key.remoteJid?.endsWith('@lid')) {
                console.log(`[${tenantId}] @lid CONTENT:`, JSON.stringify(m).substring(0, 400));
            }
        }
        // Filter only @broadcast
        const filtered = messages.filter(m => !m.key.remoteJid?.endsWith('@broadcast'));
        if (!filtered.length) return;
        for (const msg of filtered) {
            if (msg.key.fromMe) {
                if (!botSentIds.has(msg.key.id)) {
                    await handleManualReply(tenantId, msg).catch(() => {});
                }
            } else {
                if (processedMsgIds.has(msg.key.id)) continue;
                processedMsgIds.add(msg.key.id);
                await handleIncomingMessage(tenantId, sock, msg).catch(e =>
                    console.error(`[${tenantId}] handleIncomingMessage error`, e.message)
                );
            }
        }
    });

    // Log delivery/read receipts — proves messages ARE reaching WhatsApp even if bot doesn't see them
    sock.ev.on('message-receipt.update', (receipts) => {
        for (const r of receipts) {
            console.log(`[${tenantId}] RECEIPT jid=${r.key?.remoteJid} status=${r.receipt?.receiptTimestamp ? 'delivered' : 'read'}`);
        }
    });

    sock.ev.on('messages.update', (updates) => {
        for (const u of updates) {
            console.log(`[${tenantId}] MSG_UPDATE jid=${u.key?.remoteJid} fromMe=${u.key?.fromMe} status=${u.update?.status}`);
        }
    });

    let pairingRequested = false;

    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (pairingPhone && !pairingRequested && !!qr) {
            pairingRequested = true;
            try {
                const code = await sock.requestPairingCode(pairingPhone);
                clientStatus[tenantId] = {
                    state: 'pairing_code',
                    pairingCode: code,
                    qr: null,
                    hint: 'في الهاتف: الإعدادات ← الأجهزة المرتبطة ← ربط جهاز ← ربط بالرقم بدل الـ QR',
                };
                console.log(`[${tenantId}] Pairing code: ${code}`);
            } catch (err) {
                console.error(`[${tenantId}] requestPairingCode failed`, err);
                clientStatus[tenantId] = {
                    state: 'pairing_error',
                    error: err?.message || String(err),
                    qr: null,
                };
            }
        }

        if (!pairingPhone && qr) {
            const qrImage = await QRCode.toDataURL(qr);
            clientStatus[tenantId] = { state: 'qr', qr: qrImage };
            console.log(`[${tenantId}] QR ready`);
        }

        if (connection === 'open') {
            clientStatus[tenantId] = { state: 'ready', qr: null, pairingCode: null };
            reconnectAttempts.delete(tenantId);
            console.log(`[${tenantId}] WhatsApp connected`);
            startKeepAlive(tenantId, sock);
        }

        if (connection === 'close') {
            const statusCode = lastDisconnect?.error?.output?.statusCode;
            const shouldReconnect =
                statusCode !== DisconnectReason.loggedOut &&
                statusCode !== DisconnectReason.badSession;

            console.log(
                `[${tenantId}] close code=${statusCode} reconnect=${shouldReconnect}`,
                lastDisconnect?.error?.message ?? ''
            );

            delete clients[tenantId];
            clientStatus[tenantId] = { state: 'disconnected', qr: null, pairingCode: null };
            if (keepAliveIntervals.has(tenantId)) {
                clearInterval(keepAliveIntervals.get(tenantId));
                keepAliveIntervals.delete(tenantId);
            }

            if (shouldReconnect) {
                const attempts = (reconnectAttempts.get(tenantId) || 0) + 1;
                reconnectAttempts.set(tenantId, attempts);
                // Exponential backoff: 3s, 6s, 12s, 24s, max 60s
                const delay = Math.min(3000 * Math.pow(2, attempts - 1), 60000);
                console.log(`[${tenantId}] reconnecting in ${delay}ms (attempt ${attempts})`);
                setTimeout(() => {
                    pendingClients.delete(tenantId);
                    getClient(tenantId, {})
                        .then(() => reconnectAttempts.delete(tenantId))
                        .catch((e) => console.error(`[${tenantId}] reconnect failed`, e));
                }, delay);
            } else {
                reconnectAttempts.delete(tenantId);
                // Permanent disconnect — clean auth files so next visit gets a fresh QR
                const folder = authDir(tenantId);
                if (fs.existsSync(folder)) {
                    fs.rmSync(folder, { recursive: true, force: true });
                    console.log(`[${tenantId}] auth files cleaned after permanent disconnect`);
                }
                // Notify Laravel
                fetch(`${LARAVEL_URL}/internal/wa-disconnected`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-Internal-Secret': INTERNAL_SECRET },
                    body: JSON.stringify({ tenantId }),
                }).catch(() => {});
            }
        }
    });

    clients[tenantId] = sock;

    // Timeout: if no QR or connection within 30s, auto-teardown and restart fresh
    setTimeout(async () => {
        const s = clientStatus[tenantId];
        if (s && s.state === 'initializing') {
            console.log(`[${tenantId}] init timeout — auto-reset`);
            await teardown(tenantId);
            clientStatus[tenantId] = { state: 'disconnected', qr: null };
        }
    }, 30_000);

    return sock;
}

async function getClient(tenantId, options = {}) {
    if (clients[tenantId]) return clients[tenantId];
    if (pendingClients.has(tenantId)) return pendingClients.get(tenantId);

    const p = createSocket(tenantId, options);
    pendingClients.set(tenantId, p);
    try {
        return await p;
    } finally {
        pendingClients.delete(tenantId);
    }
}

// ── Routes ──

app.post('/debug/message', async (req, res) => {
    const { tenantId, phone, text } = req.body;
    const sock = clients[tenantId];
    if (!sock) return res.status(400).json({ error: 'client not found' });

    const fakeMsg = {
        key: { remoteJid: phone + '@s.whatsapp.net', fromMe: false },
        message: { conversation: text },
    };
    await handleIncomingMessage(tenantId, sock, fakeMsg).catch(e =>
        console.error('debug/message error', e.message)
    );
    res.json({ success: true });
});

app.post('/pairing/start', async (req, res) => {
    const { tenantId, phone } = req.body;
    const digits = String(phone || '').replace(/\D/g, '');
    if (!tenantId || digits.length < 10) {
        return res.status(400).json({ success: false, error: 'tenantId and phone required' });
    }
    try {
        await teardown(tenantId);
        await getClient(tenantId, { pairingPhone: digits });
        res.json({ success: true });
    } catch (e) {
        console.error('pairing/start', e);
        res.status(500).json({ success: false, error: e.message });
    }
});

app.get('/status/:tenantId', async (req, res) => {
    const { tenantId } = req.params;
    try {
        await getClient(tenantId);
        res.json(clientStatus[tenantId] || { state: 'initializing', qr: null });
    } catch (e) {
        console.error('status error', e);
        res.status(500).json({ state: 'error', qr: null, error: e.message });
    }
});

app.post('/send', async (req, res) => {
    const { tenantId, phone, message } = req.body;
    if (!tenantId || !phone || !message) {
        return res.status(400).json({ success: false, error: 'tenantId, phone, message required' });
    }
    const status = clientStatus[tenantId];
    if (!status || status.state !== 'ready') {
        return res.status(503).json({ success: false, error: 'WhatsApp not connected', state: status?.state });
    }
    try {
        const sock = clients[tenantId];
        const chatId = phone.replace(/[^0-9]/g, '') + '@s.whatsapp.net';
        await sock.sendMessage(chatId, { text: message });
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ success: false, error: err.message });
    }
});

// Called by Laravel after bot config is saved — clears the 5-min cache so next message picks up new config immediately
app.post('/cache/clear/:tenantId', (req, res) => {
    const { tenantId } = req.params;
    botConfigCache.delete(tenantId);
    console.log(`[${tenantId}] bot config cache cleared`);
    res.json({ success: true });
});

app.post('/logout/:tenantId', async (req, res) => {
    const { tenantId } = req.params;
    await teardown(tenantId);
    res.json({ success: true });
});

// ── Manual pause API ──
app.get('/manual-paused/:tenantId', (req, res) => {
    const pauses = getManualPauses(req.params.tenantId);
    const now = Date.now();
    const active = [];
    for (const [phone, expiry] of pauses) {
        if (expiry > now) {
            active.push({ phone, remainingMin: Math.ceil((expiry - now) / 60000) });
        } else {
            pauses.delete(phone);
        }
    }
    res.json({ pauses: active });
});

app.post('/manual-resume/:tenantId/:phone', (req, res) => {
    getManualPauses(req.params.tenantId).delete(req.params.phone);
    res.json({ success: true });
});

app.post('/manual-resume-all/:tenantId', (req, res) => {
    getManualPauses(req.params.tenantId).clear();
    res.json({ success: true });
});

app.post('/manual-pause/:tenantId', (req, res) => {
    const { phone, minutes } = req.body;
    if (!phone || !minutes) return res.status(400).json({ error: 'phone and minutes required' });
    setPause(req.params.tenantId, phone, parseInt(minutes));
    res.json({ success: true });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`WhatsApp service running on port ${PORT}`);
    // Auto-reconnect all tenants that have saved auth on startup
    const authBase = path.join(__dirname, '.auth');
    if (fs.existsSync(authBase)) {
        const tenants = fs.readdirSync(authBase).filter(f =>
            fs.statSync(path.join(authBase, f)).isDirectory()
        );
        for (const tenantId of tenants) {
            console.log(`[${tenantId}] auto-reconnecting on startup...`);
            getClient(tenantId, {}).catch(e =>
                console.error(`[${tenantId}] auto-reconnect failed`, e.message)
            );
        }
    }
});
