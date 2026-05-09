<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>واتساب — Wayzon</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:      #0d1117;
      --bg2:     #161b24;
      --bg3:     #1c2233;
      --border:  rgba(255,255,255,0.07);
      --border2: rgba(255,255,255,0.12);
      --t1: #f0f4ff; --t2: #94a3b8; --t3: #5a6480;
      --primary: #6366f1; --green: #10b981; --red: #ef4444; --amber: #f59e0b;
      --r: 10px; --r2: 14px;
    }
    body { font-family: 'Tajawal', sans-serif; background: var(--bg); color: var(--t1); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }

    .page { width: 100%; max-width: 520px; }

    .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--t3); font-size: 0.875rem; text-decoration: none; margin-bottom: 24px; transition: color 0.2s; }
    .back-link:hover { color: var(--t2); }

    .card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--r2); padding: 32px; }

    .card-header { text-align: center; margin-bottom: 28px; }
    .card-icon { font-size: 2.5rem; margin-bottom: 12px; }
    .card-header h1 { font-size: 1.5rem; font-weight: 800; color: var(--t1); margin-bottom: 6px; }
    .card-header p { font-size: 0.9rem; color: var(--t2); }

    /* Status badge */
    .status-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 700; margin-bottom: 24px; }
    .status-badge.connected   { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: var(--green); }
    .status-badge.disconnected{ background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.25);  color: var(--red); }
    .status-badge.waiting     { background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25); color: var(--amber); }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }

    /* QR box */
    .qr-box { background: #fff; border-radius: var(--r2); padding: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; width: 220px; height: 220px; }
    .qr-box img { width: 100%; height: 100%; object-fit: contain; }
    .qr-placeholder { display: flex; flex-direction: column; align-items: center; gap: 10px; color: #999; font-size: 0.8rem; }
    .qr-spinner { width: 36px; height: 36px; border: 3px solid #eee; border-top-color: var(--primary); border-radius: 50%; animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .qr-hint { text-align: center; font-size: 0.82rem; color: var(--t3); line-height: 1.6; margin-bottom: 24px; }

    /* Steps */
    .steps { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
    .step { display: flex; align-items: flex-start; gap: 12px; background: var(--bg3); border: 1px solid var(--border); border-radius: var(--r); padding: 12px 14px; }
    .step-num { width: 24px; height: 24px; border-radius: 50%; background: rgba(99,102,241,0.15); border: 1.5px solid rgba(99,102,241,0.3); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800; color: var(--primary); flex-shrink: 0; }
    .step-text { font-size: 0.85rem; color: var(--t2); line-height: 1.5; }

    /* Connected view */
    .connected-info { background: var(--bg3); border: 1px solid var(--border); border-radius: var(--r); padding: 18px; margin-bottom: 20px; }
    .connected-info .wa-number { display: flex; align-items: center; gap: 10px; font-size: 0.95rem; font-weight: 700; color: var(--t1); }

    /* Test send */
    .test-section { margin-top: 20px; }
    .test-section h3 { font-size: 0.9rem; font-weight: 700; color: var(--t2); margin-bottom: 12px; }
    .form-group { margin-bottom: 12px; }
    .form-group label { display: block; font-size: 0.8rem; color: var(--t3); margin-bottom: 6px; }
    .form-control { width: 100%; background: var(--bg3); border: 1px solid var(--border2); border-radius: var(--r); padding: 10px 14px; color: var(--t1); font-family: inherit; font-size: 0.875rem; outline: none; transition: border-color 0.2s; }
    .form-control:focus { border-color: var(--primary); }
    textarea.form-control { resize: vertical; min-height: 80px; }

    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border-radius: var(--r); font-family: inherit; font-size: 0.875rem; font-weight: 700; cursor: pointer; border: none; transition: opacity 0.2s; }
    .btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-primary { background: var(--primary); color: #fff; width: 100%; padding: 12px; }
    .btn-primary:hover:not(:disabled) { opacity: 0.85; }
    .btn-danger { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: var(--red); width: 100%; padding: 10px; margin-top: 10px; }
    .btn-danger:hover:not(:disabled) { background: rgba(239,68,68,0.2); }

    .alert { display: flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: var(--r); font-size: 0.85rem; margin-top: 12px; }
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: var(--green); }
    .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: var(--red); }
    .hidden { display: none; }
  </style>
</head>
<body>
<div class="page">

  <a href="{{ route('dashboard') }}" class="back-link">← العودة للوحة التحكم</a>

  <div class="card">
    <div class="card-header">
      <div class="card-icon">💬</div>
      <h1>ربط واتساب</h1>
      <p>اربط رقم واتساب التاجر لإرسال رسائل تلقائية</p>
    </div>

    <div style="text-align:center;">
      <div class="status-badge waiting" id="statusBadge">
        <div class="status-dot"></div>
        <span id="statusText">جارٍ التحقق...</span>
      </div>
    </div>

    <!-- Pairing by phone number (بديل الـ QR) -->
    <div id="pairingStart" style="margin-bottom: 20px; padding: 16px; background: var(--bg3); border: 1px solid var(--border); border-radius: var(--r);">
      <p style="font-size: 0.85rem; color: var(--t2); margin-bottom: 12px; line-height: 1.5;">
        إذا ظهر &quot;لم يتم ربط الجهاز&quot; عند مسح الـ QR، جرّب <strong>رمز الربط</strong> (نفس طريقة واتساب ويب بالرقم):
      </p>
      <div class="form-group" style="margin-bottom: 10px;">
        <label>رقم واتساب مع كود الدولة (بدون +)</label>
        <input type="text" id="pairingPhone" class="form-control" placeholder="966501234567" dir="ltr" autocomplete="tel" />
      </div>
      <button type="button" class="btn btn-primary" id="pairingBtn" onclick="requestPairingCode()">احصل على رمز الربط</button>
    </div>

    <div id="pairingView" class="hidden" style="text-align: center; margin-bottom: 24px;">
      <p style="font-size: 0.85rem; color: var(--t2); margin-bottom: 12px;" id="pairingHint"></p>
      <div style="font-size: 2rem; font-weight: 900; letter-spacing: 0.15em; color: var(--t1); font-family: ui-monospace, monospace;" id="pairingCodeDisplay"></div>
    </div>

    <!-- QR View -->
    <div id="qrView">
      <div class="qr-box" id="qrBox">
        <div class="qr-placeholder">
          <div class="qr-spinner"></div>
          <span>جارٍ التحميل...</span>
        </div>
      </div>

      <p class="qr-hint">امسح الـ QR بكاميرا هاتفك عبر تطبيق واتساب</p>
      <p class="qr-hint" style="font-size:0.78rem; color: var(--t3); margin-top: -12px;">
        إذا ظهر &quot;لم يتم ربط الجهاز&quot;: حدّث واتساب، جرّب شبكة أخرى أو عطّل VPN، واحذف أجهزة قديمة من
        <strong>الإعدادات ← الأجهزة المرتبطة</strong> ثم اضغط &quot;قطع الاتصال&quot; هنا وأعد المحاولة.
      </p>

      <div class="steps">
        <div class="step"><div class="step-num">1</div><div class="step-text">افتح واتساب على هاتفك</div></div>
        <div class="step"><div class="step-num">2</div><div class="step-text">اذهب إلى <strong>الإعدادات ← الأجهزة المرتبطة</strong></div></div>
        <div class="step"><div class="step-num">3</div><div class="step-text">اضغط <strong>ربط جهاز</strong> ثم امسح الـ QR</div></div>
      </div>
    </div>

    <!-- Connected View -->
    <div id="connectedView" class="hidden">
      <div class="connected-info">
        <div class="wa-number">
          <span>📱</span>
          <span id="connectedNumber">متصل بنجاح</span>
        </div>
      </div>

      <div class="test-section">
        <h3>إرسال رسالة تجريبية</h3>
        <div class="form-group">
          <label>رقم الجوال (مع كود الدولة)</label>
          <input type="tel" id="testPhone" class="form-control" placeholder="966501234567" dir="ltr" />
        </div>
        <div class="form-group">
          <label>الرسالة</label>
          <textarea id="testMessage" class="form-control" placeholder="مرحباً، هذه رسالة تجريبية من Wayzon">مرحباً! هذه رسالة تجريبية من نظام Wayzon ✅</textarea>
        </div>
        <button class="btn btn-primary" id="sendBtn" onclick="sendTest()">إرسال رسالة تجريبية</button>
        <div id="sendResult" class="hidden"></div>
      </div>

      <button class="btn btn-danger" onclick="disconnectWA()">قطع الاتصال</button>
    </div>

  </div>
</div>

<script>
  const STATUS_URL = '{{ route("whatsapp.status") }}';
  const SEND_URL   = '{{ route("whatsapp.send") }}';
  const LOGOUT_URL = '{{ route("whatsapp.logout") }}';
  const PAIRING_URL = '{{ route("whatsapp.pairing") }}';
  const CSRF       = '{{ csrf_token() }}';

  let pollInterval = null;
  let initializingSince = null;

  async function checkStatus() {
    try {
      const res  = await fetch(STATUS_URL);
      const data = await res.json();
      updateUI(data);
    } catch (e) {
      setStatus('disconnected', 'تعذر الاتصال بالخدمة');
    }
  }

  function formatPairingCode(code) {
    const s = String(code || '').replace(/\s/g, '');
    if (s.length === 8) return s.slice(0, 4) + '-' + s.slice(4);
    return s;
  }

  async function requestPairingCode() {
    const phone = document.getElementById('pairingPhone').value.trim();
    const btn = document.getElementById('pairingBtn');
    if (!phone || phone.replace(/\D/g, '').length < 10) {
      alert('أدخل الرقم مع كود الدولة (مثال: 966501234567)');
      return;
    }
    btn.disabled = true;
    btn.textContent = 'جارٍ التجهيز...';
    try {
      const res = await fetch(PAIRING_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ phone }),
      });
      const j = await res.json();
      if (!j.success) {
        alert(j.error || 'تعذر بدء رمز الربط');
      }
      await checkStatus();
    } catch (e) {
      alert('خطأ في الاتصال بالخادم');
    }
    btn.disabled = false;
    btn.textContent = 'احصل على رمز الربط';
  }

  function updateUI(data) {
    if (data.state === 'ready') {
      initializingSince = null;
      setStatus('connected', 'متصل ✓');
      document.getElementById('pairingView').classList.add('hidden');
      document.getElementById('qrView').classList.add('hidden');
      document.getElementById('connectedView').classList.remove('hidden');
      if (pollInterval) { clearInterval(pollInterval); pollInterval = null; }

    } else if (data.state === 'pairing_code' && data.pairingCode) {
      setStatus('waiting', 'أدخل الرمز في الهاتف');
      document.getElementById('qrView').classList.add('hidden');
      document.getElementById('connectedView').classList.add('hidden');
      document.getElementById('pairingView').classList.remove('hidden');
      document.getElementById('pairingCodeDisplay').textContent = formatPairingCode(data.pairingCode);
      document.getElementById('pairingHint').textContent = data.hint || 'افتح واتساب ← الإعدادات ← الأجهزة المرتبطة ← ربط جهاز ← ربط بالرقم';

    } else if (data.state === 'pairing_error') {
      setStatus('disconnected', 'فشل رمز الربط');
      document.getElementById('pairingView').classList.remove('hidden');
      document.getElementById('pairingCodeDisplay').textContent = '';
      document.getElementById('pairingHint').textContent = data.error || 'حاول مرة أخرى أو استخدم الـ QR';

    } else if (data.state === 'qr' && data.qr) {
      initializingSince = null;
      setStatus('waiting', 'في انتظار المسح');
      document.getElementById('pairingView').classList.add('hidden');
      document.getElementById('qrView').classList.remove('hidden');
      document.getElementById('connectedView').classList.add('hidden');
      document.getElementById('qrBox').innerHTML = `<img src="${data.qr}" alt="QR Code" />`;

    } else if (data.state === 'initializing') {
      if (!initializingSince) initializingSince = Date.now();
      // Auto-reset if stuck for more than 35 seconds
      if (Date.now() - initializingSince > 35000) {
        initializingSince = null;
        resetAndRetry();
        return;
      }
      setStatus('waiting', 'جارٍ التهيئة...');
      document.getElementById('qrBox').innerHTML = `
        <div class="qr-placeholder" style="gap:14px;">
          <div class="qr-spinner"></div>
          <span>جارٍ التحميل...</span>
          <button onclick="resetAndRetry()" style="background:transparent;border:1px solid #6366f1;color:#a5b4fc;border-radius:8px;padding:6px 14px;font-family:inherit;font-size:0.75rem;cursor:pointer;margin-top:4px;">إعادة تهيئة ↻</button>
        </div>`;

    } else if (data.state === 'timeout_error') {
      setStatus('disconnected', 'فشلت التهيئة');
      document.getElementById('pairingView').classList.add('hidden');
      document.getElementById('connectedView').classList.add('hidden');
      document.getElementById('qrView').classList.remove('hidden');
      document.getElementById('qrBox').innerHTML = `
        <div class="qr-placeholder" style="gap:14px;">
          <span style="font-size:2rem;">⏱️</span>
          <span style="color:#f59e0b;font-size:0.82rem;text-align:center;">انتهت مهلة التهيئة<br>اضغط لإعادة المحاولة</span>
          <button onclick="resetAndRetry()" style="background:var(--primary);color:#fff;border:none;border-radius:8px;padding:8px 18px;font-family:inherit;font-size:0.82rem;font-weight:700;cursor:pointer;">إعادة المحاولة ↻</button>
        </div>`;

    } else {
      // disconnected or unknown
      setStatus('disconnected', 'غير متصل');
      document.getElementById('pairingView').classList.add('hidden');
      document.getElementById('connectedView').classList.add('hidden');
      document.getElementById('qrView').classList.remove('hidden');
      document.getElementById('qrBox').innerHTML = `
        <div class="qr-placeholder" style="gap:14px;">
          <span style="font-size:2rem;">⚠️</span>
          <span style="color:#ef4444;font-size:0.82rem;">انقطع الاتصال بالخدمة</span>
          <button onclick="resetAndRetry()" style="background:var(--primary);color:#fff;border:none;border-radius:8px;padding:8px 18px;font-family:inherit;font-size:0.82rem;font-weight:700;cursor:pointer;">إعادة المحاولة</button>
        </div>`;
    }
  }

  function setStatus(cls, text) {
    const badge = document.getElementById('statusBadge');
    badge.className = `status-badge ${cls}`;
    document.getElementById('statusText').textContent = text;
  }

  async function sendTest() {
    const phone   = document.getElementById('testPhone').value.trim();
    const message = document.getElementById('testMessage').value.trim();
    const btn     = document.getElementById('sendBtn');
    const result  = document.getElementById('sendResult');

    if (!phone || !message) return;

    btn.disabled = true;
    btn.textContent = 'جارٍ الإرسال...';

    const res  = await fetch(SEND_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ phone, message })
    });
    const data = await res.json();

    result.className = data.success ? 'alert alert-success' : 'alert alert-error';
    result.textContent = data.success ? '✅ تم إرسال الرسالة بنجاح' : '❌ فشل الإرسال — تأكد من الرقم';
    result.classList.remove('hidden');

    btn.disabled = false;
    btn.textContent = 'إرسال رسالة تجريبية';
  }

  async function disconnectWA() {
    if (!confirm('هل تريد قطع الاتصال؟')) return;
    await fetch(LOGOUT_URL, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF }
    });
    location.reload();
  }

  async function retryConnection() {
    document.getElementById('qrBox').innerHTML = `
      <div class="qr-placeholder">
        <div class="qr-spinner"></div>
        <span>جارٍ إعادة الاتصال...</span>
      </div>`;
    setStatus('waiting', 'جارٍ إعادة الاتصال...');
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(checkStatus, 2000);
    await checkStatus();
  }

  async function resetAndRetry() {
    if (pollInterval) { clearInterval(pollInterval); pollInterval = null; }
    document.getElementById('qrBox').innerHTML = `
      <div class="qr-placeholder">
        <div class="qr-spinner"></div>
        <span>جارٍ مسح الجلسة القديمة...</span>
      </div>`;
    setStatus('waiting', 'جارٍ إعادة التهيئة...');
    // Logout and clean auth files
    await fetch(LOGOUT_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF } }).catch(() => {});
    // Wait 5 seconds for WhatsApp servers to release the session
    document.getElementById('qrBox').innerHTML = `
      <div class="qr-placeholder">
        <div class="qr-spinner"></div>
        <span>انتظر قليلاً...</span>
      </div>`;
    await new Promise(r => setTimeout(r, 5000));
    // Now start fresh
    await checkStatus();
    pollInterval = setInterval(checkStatus, 3000);
  }

  // Poll: every 2s while waiting for QR, every 5s once connected
  checkStatus();
  pollInterval = setInterval(async () => {
    await checkStatus();
  }, 3000);
</script>
</body>
</html>
