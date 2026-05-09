<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تعيين كلمة المرور — Wayzon</title>
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
    .auth-form { display: flex; flex-direction: column; gap: 16px; }
    .input-icon-wrap { position: relative; }
    .input-icon-wrap .form-control { padding-inline-end: 44px; }
    .input-suffix { position: absolute; inset-inline-end: 14px; top: 50%; transform: translateY(-50%); font-size: 1rem; color: var(--text-3); cursor: pointer; }
    .auth-submit { width: 100%; justify-content: center; padding: 13px; font-size: 0.9375rem; border-radius: var(--r); }
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
      <a href="/" class="logo">Wayzon</a>
    </div>
    <div class="brand-middle">
      <h2 class="brand-heading">🔐 تعيين كلمة المرور<br><span class="gradient-text">خطوة واحدة فقط</span></h2>
      <p class="brand-sub">اختر كلمة مرور آمنة للدخول إلى لوحة تحكم متجرك في أي وقت.</p>
      <div class="brand-features">
        <div class="brand-feat"><div class="brand-feat-icon">🔒</div> حساب محمي بكلمة مرور خاصة بك</div>
        <div class="brand-feat"><div class="brand-feat-icon">💬</div> إدارة بوت واتساب متجرك</div>
        <div class="brand-feat"><div class="brand-feat-icon">📦</div> متابعة طلبات سلة تلقائياً</div>
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
        <h1>تعيين كلمة المرور</h1>
        <p>أدخل كلمة مرور جديدة لحسابك على Wayzon</p>
      </div>

      @if ($errors->any())
        <div class="alert alert-error">
          <span>⚠️</span>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form class="auth-form" method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />

        <div class="form-group">
          <label for="email">البريد الإلكتروني</label>
          <input type="email" id="email" name="email" class="form-control" value="{{ $email }}" readonly />
        </div>

        <div class="form-group">
          <label for="password">كلمة المرور الجديدة</label>
          <div class="input-icon-wrap">
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" autocomplete="new-password" required />
            <span class="input-suffix" onclick="togglePass('password','t1')" id="t1">👁</span>
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">تأكيد كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" autocomplete="new-password" required />
            <span class="input-suffix" onclick="togglePass('password_confirmation','t2')" id="t2">👁</span>
          </div>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
          تعيين كلمة المرور والدخول
        </button>
      </form>
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
