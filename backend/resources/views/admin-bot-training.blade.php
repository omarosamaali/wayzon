<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تدريب البوت — Wayzon Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0d1117; --bg2: #161b24; --bg3: #1c2233;
      --border: rgba(255,255,255,0.07);
      --primary: #6366f1;
      --t1: #f0f4ff; --t2: #94a3b8; --t3: #5a6480;
      --green: #10b981; --r: 10px;
    }
    body { font-family: 'Tajawal', sans-serif; background: var(--bg); color: var(--t1); min-height: 100vh; }
    .topbar { background: var(--bg2); border-bottom: 1px solid var(--border); padding: 0 32px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
    .brand { font-size: 1rem; font-weight: 900; display: flex; align-items: center; gap: 10px; }
    .brand-icon { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--primary), #8b5cf6); display: flex; align-items: center; justify-content: center; }
    .container { max-width: 900px; margin: 0 auto; padding: 40px 24px; }
    h2 { font-size: 1.4rem; font-weight: 900; margin-bottom: 8px; }
    .subtitle { color: var(--t2); font-size: 0.875rem; margin-bottom: 28px; line-height: 1.6; }
    .card { background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; padding: 28px; }
    textarea { width: 100%; min-height: 420px; background: var(--bg3); border: 1px solid var(--border); border-radius: var(--r); color: var(--t1); font-family: 'Tajawal', sans-serif; font-size: 0.9rem; line-height: 1.7; padding: 16px; resize: vertical; outline: none; direction: rtl; }
    textarea:focus { border-color: var(--primary); }
    .actions { display: flex; gap: 10px; margin-top: 16px; align-items: center; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 22px; border-radius: var(--r); font-size: 0.875rem; font-weight: 700; font-family: inherit; cursor: pointer; border: none; transition: all 0.2s; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #5254d4; }
    .btn-ghost { background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: var(--t2); }
    .btn-ghost:hover { background: rgba(255,255,255,0.09); color: var(--t1); }
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); border-radius: var(--r); padding: 12px 16px; color: #6ee7b7; font-size: 0.875rem; margin-bottom: 20px; }
    .hint { font-size: 0.78rem; color: var(--t3); margin-top: 10px; line-height: 1.5; }
  </style>
</head>
<body>
<nav class="topbar">
  <div class="brand">
    <div class="brand-icon">W</div>
    Wayzon
    <span style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);color:#fbbf24;font-size:0.7rem;font-weight:800;padding:3px 10px;border-radius:99px;">⚡ أدمن</span>
  </div>
  <div style="display:flex;gap:10px;">
    <a href="{{ route('admin.index') }}" class="btn btn-ghost" style="padding:7px 14px;font-size:0.8rem;">← لوحة الأدمن</a>
  </div>
</nav>

<div class="container">
  <h2>🤖 تدريب البوت — Wayzon</h2>
  <p class="subtitle">هذا الـ System Prompt يُحمَّل لكل تاجر تلقائياً. استخدمه لتعريف البوت بـ Wayzon، أسلوب الرد، والأهداف العامة. التدريب الخاص بكل تاجر (معلومات متجره) يُضاف فوق هذا.</p>

  @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
  @endif

  {{-- AI Model Selector --}}
  <div class="card" style="margin-bottom:20px;">
    <div style="font-size:1rem;font-weight:800;margin-bottom:16px;">🧠 نموذج الذكاء الاصطناعي</div>
    <p style="font-size:0.82rem;color:#94a3b8;margin-bottom:16px;line-height:1.6;">النموذج المختار يُطبَّق على جميع التجار. كلما كان النموذج أقوى كلما كانت الردود أذكى (لكن أغلى تكلفةً).</p>
    <form method="POST" action="{{ route('admin.saveAiModel') }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
      @csrf
      <select name="model" style="background:#1c2233;border:1px solid rgba(255,255,255,0.12);border-radius:10px;color:#f0f4ff;padding:10px 16px;font-family:inherit;font-size:0.88rem;outline:none;cursor:pointer;min-width:240px;">
        <option value="gpt-4o-mini"  {{ $aiModel === 'gpt-4o-mini'  ? 'selected' : '' }}>⚡ GPT-4o Mini — سريع واقتصادي</option>
        <option value="gpt-4o"       {{ $aiModel === 'gpt-4o'       ? 'selected' : '' }}>🧠 GPT-4o — متوازن وقوي</option>
        <option value="gpt-4-turbo"  {{ $aiModel === 'gpt-4-turbo'  ? 'selected' : '' }}>🚀 GPT-4 Turbo — قوي جداً</option>
        <option value="o3-mini"      {{ $aiModel === 'o3-mini'      ? 'selected' : '' }}>🔬 o3 Mini — تفكير عميق</option>
      </select>
      <button type="submit" class="btn btn-primary">حفظ النموذج</button>
      <span style="font-size:0.78rem;color:#5a6480;">النموذج الحالي: <strong style="color:#a5b4fc;">{{ $aiModel }}</strong></span>
    </form>
  </div>

  {{-- Bot Training Prompt --}}
  <div class="card">
    <form method="POST" action="{{ route('admin.saveBotTraining') }}">
      @csrf
      <textarea name="prompt" placeholder="اكتب هنا تعليمات البوت العامة...&#10;&#10;مثال:&#10;أنت مساعد ذكي لمتجر على منصة سلة، اسمك وايزون...">{{ old('prompt', $prompt) }}</textarea>
      <p class="hint">💡 يمكنك استخدام متغيرات مثل {store_name} و {store_url} وسيتم استبدالها تلقائياً لكل تاجر.</p>
      <div class="actions">
        <button type="submit" class="btn btn-primary">💾 حفظ التدريب</button>
        <span style="font-size:0.78rem;color:var(--t3);">{{ strlen($prompt) }} حرف</span>
      </div>
    </form>
  </div>
</div>
</body>
</html>
