<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل الدخول — Wayzon</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    body { overflow: hidden; }
    .auth-layout { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
    .auth-brand { background: var(--bg-secondary); border-inline-end: 1px solid var(--border); display: flex; flex-direction: column; justify-content: space-between; padding: 48px; position: relative; overflow: hidden; }
    .brand-bg { position: absolute; inset: 0; background: radial-gradient(ellipse 80% 60% at 20% 20%, rgba(99,102,241,0.15) 0%, transparent 60%), radial-gradient(ellipse 60% 60% at 80% 80%, rgba(139,92,246,0.1) 0%, transparent 60%); pointer-events: none; }
    .brand-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 48px 48px; pointer-events: none; }
    .brand-top { position: relative; }
    .brand-middle { position: relative; flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .brand-heading { font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 900; line-height: 1.2; margin-bottom: 16px; color: var(--text-1); }
    .brand-sub { font-size: 1rem; color: var(--text-2); line-height: 1.7; max-width: 380px; }
    .brand-features { margin-top: 40px; display: flex; flex-direction: column; gap: 14px; }
    .brand-feat { display: flex; align-items: center; gap: 12px; font-size: 0.9rem; color: var(--text-2); }
    .brand-feat-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.2); display: flex; align-items: center; justify-content: center; font-size: 0.875rem; flex-shrink: 0; }
    .brand-testimonial { position: relative; background: rgba(255,255,255,0.04); border: 1px solid var(--border-strong); border-radius: var(--r-lg); padding: 20px 24px; margin-top: 40px; }
    .brand-testimonial p { font-size: 0.875rem; color: var(--text-2); line-height: 1.7; margin-bottom: 14px; }
    .brand-testimonial p::before { content: '"'; color: var(--primary-light); font-size: 1.25rem; }
    .brand-testimonial p::after  { content: '"'; color: var(--primary-light); font-size: 1.25rem; }
    .brand-test-author { display: flex; align-items: center; gap: 10px; }
    .test-ava { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: 800; color: #fff; }
    .test-name { font-size: 0.875rem; font-weight: 700; color: var(--text-1); }
    .test-role { font-size: 0.75rem; color: var(--text-3); }
    .brand-bottom { position: relative; }
    .brand-stats-row { display: flex; gap: 28px; }
    .brand-stat-num { font-size: 1.375rem; font-weight: 900; color: var(--text-1); }
    .brand-stat-num span { color: var(--primary-light); }
    .brand-stat-lbl { font-size: 0.75rem; color: var(--text-3); }
    .auth-form-panel { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 56px; background: var(--bg-primary); overflow-y: auto; max-height: 100vh; }
    .auth-form-inner { width: 100%; max-width: 420px; }
    .auth-form-header { margin-bottom: 36px; text-align: center; }
    .auth-form-header h1 { font-size: 1.75rem; font-weight: 800; color: var(--text-1); margin-bottom: 8px; }
    .auth-form-header p { font-size: 0.9rem; color: var(--text-2); }
    .auth-form-header a { color: var(--primary-light); font-weight: 600; }
    .auth-form { display: flex; flex-direction: column; gap: 16px; }
    .input-icon-wrap { position: relative; }
    .input-icon-wrap .form-control { padding-inline-end: 44px; }
    .input-suffix { position: absolute; inset-inline-end: 14px; top: 50%; transform: translateY(-50%); font-size: 1rem; color: var(--text-3); cursor: pointer; }
    .form-row-inline { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .checkbox-label { display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: var(--text-2); cursor: pointer; }
    .checkbox-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--primary); cursor: pointer; }
    .forgot-link { font-size: 0.875rem; color: var(--primary-light); font-weight: 600; }
    .auth-submit { width: 100%; justify-content: center; padding: 13px; font-size: 0.9375rem; border-radius: var(--r); }
    .auth-note { margin-top: 20px; font-size: 0.8rem; color: var(--text-3); text-align: center; line-height: 1.6; }
    .auth-bottom-link { margin-top: 28px; text-align: center; font-size: 0.9rem; color: var(--text-2); }
    .auth-bottom-link a { color: var(--primary-light); font-weight: 700; }
    .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--r); font-size: 0.875rem; margin-bottom: 20px; }
    .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }
    @media (max-width: 900px) { body { overflow: auto; } .auth-layout { grid-template-columns: 1fr; } .auth-brand { display: none; } .auth-form-panel { padding: 48px 28px; max-height: none; } }
  </style>
</head>
<body>
<div class="auth-layout">

  <div class="auth-brand">
    <div class="brand-bg"></div>
    <div class="brand-grid"></div>
    <div class="brand-top">
      <a href="/" class="logo">
        <img src="/logo.png" alt="Wayzon" class="logo-img" />
        Wayzon
      </a>
    </div>
    <div class="brand-middle">
      <h2 class="brand-heading">أهلاً بعودتك! 👋<br><span class="gradient-text">متجرك ينتظرك</span></h2>
      <p class="brand-sub">سجّل دخولك للوصول إلى لوحة تحكم متجرك، تقاريرك، وأدوات الأتمتة الذكية.</p>
      <div class="brand-features">
        <div class="brand-feat"><div class="brand-feat-icon">📊</div> تقارير مبيعاتك لحظة بلحظة</div>
        <div class="brand-feat"><div class="brand-feat-icon">💬</div> رسائل واتساب للعملاء تلقائياً</div>
        <div class="brand-feat"><div class="brand-feat-icon">⚡</div> أتمتة الطلبات والشحن فوراً</div>
      </div>
      <div class="brand-testimonial">
        <p>Wayzon غيّر طريقة إدارتي للمتجر. الأتمتة وفّرت عليّ ساعات يومياً</p>
        <div class="brand-test-author">
          <div class="test-ava">أ</div>
          <div><div class="test-name">أحمد الشمري</div><div class="test-role">صاحب متجر — الرياض</div></div>
          <div style="margin-inline-start: auto; color: #fbbf24; font-size: 0.8rem;">★★★★★</div>
        </div>
      </div>
    </div>
    <div class="brand-bottom">
      <div class="brand-stats-row">
        <div><div class="brand-stat-num"><span>+</span>500</div><div class="brand-stat-lbl">متجر نشط</div></div>
        <div><div class="brand-stat-num">98<span>%</span></div><div class="brand-stat-lbl">رضا العملاء</div></div>
        <div><div class="brand-stat-num"><span>×</span>3</div><div class="brand-stat-lbl">نمو المبيعات</div></div>
      </div>
    </div>
  </div>

  <div class="auth-form-panel">
    <div class="auth-form-inner">
      <div class="auth-form-header">
        <h1>تسجيل الدخول</h1>
        <p>ليس لديك حساب؟ <a href="{{ route('register') }}">أنشئ حساباً مجاناً</a></p>
      </div>

      @if ($errors->any())
        <div class="alert alert-error">
          <span>⚠️</span>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form class="auth-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="email">البريد الإلكتروني</label>
          <div class="input-icon-wrap">
            <input type="email" id="email" name="email" class="form-control" placeholder="you@store.sa" value="{{ old('email') }}" autocomplete="email" required />
            <span class="input-suffix">✉️</span>
          </div>
        </div>

        <div class="form-group">
          <label for="password">كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" autocomplete="current-password" required />
            <span class="input-suffix" id="passToggle" onclick="togglePass('password','passToggle')" title="إظهار">👁</span>
          </div>
        </div>

        <div class="form-row-inline">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" checked />
            تذكرني
          </label>
          <a href="#" class="forgot-link">نسيت كلمة المرور؟</a>
        </div>

        <button type="submit" class="btn btn-primary auth-submit" id="loginBtn">
          تسجيل الدخول
        </button>
      </form>

      <p class="auth-note">
        بتسجيل دخولك فأنت توافق على
        <a href="#">شروط الاستخدام</a> و
        <a href="#">سياسة الخصوصية</a>
      </p>

      <div class="auth-bottom-link">
        حساب جديد؟ <a href="{{ route('register') }}">سجّل مجاناً ←</a>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePass(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const btn   = document.getElementById(toggleId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    btn.textContent = input.type === 'password' ? '👁' : '🙈';
  }
</script>
</body>
</html>
