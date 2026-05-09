<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>إنشاء حساب — Wayzon</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    body { overflow-x: hidden; }
    .auth-layout { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
    .auth-brand { background: var(--bg-secondary); border-inline-end: 1px solid var(--border); display: flex; flex-direction: column; justify-content: space-between; padding: 48px; position: relative; overflow: hidden; }
    .brand-bg { position: absolute; inset: 0; background: radial-gradient(ellipse 80% 60% at 20% 20%, rgba(99,102,241,0.15) 0%, transparent 60%), radial-gradient(ellipse 60% 60% at 80% 80%, rgba(139,92,246,0.1) 0%, transparent 60%); pointer-events: none; }
    .brand-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 48px 48px; pointer-events: none; }
    .brand-top { position: relative; }
    .brand-middle { position: relative; flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .brand-heading { font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 900; line-height: 1.2; margin-bottom: 16px; color: var(--text-1); }
    .brand-sub { font-size: 1rem; color: var(--text-2); line-height: 1.7; max-width: 380px; }
    .steps-list { margin-top: 36px; display: flex; flex-direction: column; gap: 20px; }
    .step-item { display: flex; align-items: flex-start; gap: 14px; }
    .step-num { width: 32px; height: 32px; border-radius: 50%; background: rgba(99,102,241,0.15); border: 1.5px solid rgba(99,102,241,0.3); display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: 800; color: var(--primary-light); flex-shrink: 0; }
    .step-text h4 { font-size: 0.9rem; font-weight: 700; color: var(--text-1); margin-bottom: 3px; }
    .step-text p  { font-size: 0.8rem; color: var(--text-3); }
    .promo-card { margin-top: 32px; background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.2); border-radius: var(--r-lg); padding: 20px 22px; }
    .promo-title { font-size: 0.9rem; font-weight: 700; color: var(--text-1); margin-bottom: 12px; }
    .promo-points { display: flex; flex-direction: column; gap: 8px; }
    .promo-point { font-size: 0.825rem; color: var(--text-2); display: flex; gap: 8px; }
    .promo-point span { color: var(--success, #10b981); font-weight: 700; }
    .brand-bottom { position: relative; }
    .trust-badges { display: flex; gap: 16px; flex-wrap: wrap; }
    .trust-item { font-size: 0.8rem; color: var(--text-3); }
    .auth-form-panel { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 56px; background: var(--bg-primary); overflow-y: auto; max-height: 100vh; }
    .auth-form-inner { width: 100%; max-width: 460px; }
    .form-progress { display: flex; align-items: center; gap: 8px; margin-bottom: 28px; }
    .progress-step { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: var(--text-3); }
    .progress-step.active { color: var(--primary-light); }
    .progress-dot { width: 20px; height: 20px; border-radius: 50%; background: rgba(255,255,255,0.07); border: 1.5px solid var(--border-strong); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: 800; }
    .progress-step.active .progress-dot { background: var(--primary); border-color: var(--primary); color: #fff; }
    .progress-line { flex: 1; height: 1px; background: var(--border); }
    .auth-form-header { margin-bottom: 28px; text-align: center; }
    .auth-form-header h1 { font-size: 1.75rem; font-weight: 800; color: var(--text-1); margin-bottom: 8px; }
    .auth-form-header p { font-size: 0.9rem; color: var(--text-2); }
    .auth-form-header a { color: var(--primary-light); font-weight: 600; }
    .auth-form { display: flex; flex-direction: column; gap: 14px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .input-icon-wrap { position: relative; }
    .input-icon-wrap .form-control { padding-inline-end: 44px; }
    .input-suffix { position: absolute; inset-inline-end: 14px; top: 50%; transform: translateY(-50%); font-size: 1rem; color: var(--text-3); cursor: pointer; }
    .password-strength { margin-top: 6px; }
    .strength-bar-bg { height: 3px; background: rgba(255,255,255,0.08); border-radius: 2px; overflow: hidden; }
    .strength-bar { height: 100%; border-radius: 2px; transition: width 0.3s, background 0.3s; width: 0%; }
    .strength-label { font-size: 0.7rem; color: var(--text-3); margin-top: 4px; }
    .plan-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .plan-option { position: relative; cursor: pointer; }
    .plan-option input { position: absolute; opacity: 0; width: 0; height: 0; }
    .plan-option-body { padding: 14px 16px; background: rgba(255,255,255,0.04); border: 1.5px solid var(--border-strong); border-radius: var(--r); transition: var(--transition); }
    .plan-option input:checked + .plan-option-body { border-color: var(--primary); background: rgba(99,102,241,0.1); }
    .plan-option-name { font-size: 0.875rem; font-weight: 700; color: var(--text-1); }
    .plan-option-price { font-size: 0.75rem; color: var(--text-2); margin-top: 3px; }
    .plan-check { position: absolute; top: 8px; inset-inline-end: 8px; width: 16px; height: 16px; border-radius: 50%; background: var(--primary); color: #fff; font-size: 0.5rem; display: none; align-items: center; justify-content: center; }
    .plan-option input:checked ~ .plan-check { display: flex; }
    .terms-check { display: flex; align-items: flex-start; gap: 10px; font-size: 0.8125rem; color: var(--text-2); cursor: pointer; line-height: 1.5; }
    .terms-check input { margin-top: 2px; width: 15px; height: 15px; accent-color: var(--primary); cursor: pointer; flex-shrink: 0; }
    .terms-check a { color: var(--primary-light); font-weight: 600; }
    .auth-submit { width: 100%; justify-content: center; padding: 13px; font-size: 0.9375rem; border-radius: var(--r); }
    .auth-bottom-link { margin-top: 24px; text-align: center; font-size: 0.9rem; color: var(--text-2); }
    .auth-bottom-link a { color: var(--primary-light); font-weight: 700; }
    .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--r); font-size: 0.875rem; margin-bottom: 16px; }
    .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }
    @media (max-width: 900px) { .auth-layout { grid-template-columns: 1fr; } .auth-brand { display: none; } .auth-form-panel { padding: 48px 28px; max-height: none; } }
    @media (max-width: 480px) { .auth-form-panel { padding: 36px 20px; } .form-row { grid-template-columns: 1fr; } }
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
      <h2 class="brand-heading">ابدأ رحلتك مع<br><span class="gradient-text">متجر أذكى</span></h2>
      <p class="brand-sub">أنشئ حسابك مجاناً وابدأ تجربة Wayzon الآن. لا حاجة لبطاقة ائتمان.</p>
      <div class="steps-list">
        <div class="step-item"><div class="step-num">1</div><div class="step-text"><h4>أنشئ حسابك</h4><p>سجّل ببياناتك الأساسية في أقل من دقيقة</p></div></div>
        <div class="step-item"><div class="step-num">2</div><div class="step-text"><h4>اربط متجرك على سلة</h4><p>ربط تلقائي وآمن مع متجرك خلال ثوانٍ</p></div></div>
        <div class="step-item"><div class="step-num">3</div><div class="step-text"><h4>شغّل الأتمتة</h4><p>فعّل البوت، والتقارير، وأدوات التسويق فوراً</p></div></div>
      </div>
      <div class="promo-card">
        <div class="promo-title">🎁 تجربة مجانية 14 يوم</div>
        <div class="promo-points">
          <div class="promo-point"><span>✓</span> وصول كامل لجميع مميزات برو</div>
          <div class="promo-point"><span>✓</span> بدون بطاقة ائتمان</div>
          <div class="promo-point"><span>✓</span> إلغاء في أي وقت</div>
          <div class="promo-point"><span>✓</span> دعم فني مجاني خلال التجربة</div>
        </div>
      </div>
    </div>
    <div class="brand-bottom">
      <div class="trust-badges">
        <div class="trust-item">🔒 SSL آمن</div>
        <div class="trust-item">🇸🇦 خوادم محلية</div>
        <div class="trust-item">✅ موثّق من سلة</div>
      </div>
    </div>
  </div>

  <div class="auth-form-panel">
    <div class="auth-form-inner">

      <div class="form-progress">
        <div class="progress-step active"><div class="progress-dot">1</div> بيانات الحساب</div>
        <div class="progress-line"></div>
        <div class="progress-step"><div class="progress-dot">2</div> المتجر</div>
        <div class="progress-line"></div>
        <div class="progress-step"><div class="progress-dot">3</div> الخطة</div>
      </div>

      <div class="auth-form-header">
        <h1>إنشاء حساب مجاني</h1>
        <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">سجّل دخولك</a></p>
      </div>

      @if ($errors->any())
        <div class="alert alert-error">
          <span>⚠️</span>
          <ul style="margin:0; padding-inline-start: 16px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form class="auth-form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-row">
          <div class="form-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="فيصل العمري" value="{{ old('name') }}" required />
          </div>
          <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <div class="input-icon-wrap">
              <input type="email" id="email" name="email" class="form-control" placeholder="you@store.sa" value="{{ old('email') }}" required />
              <span class="input-suffix">✉️</span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="password">كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" id="password" name="password" class="form-control" placeholder="8 أحرف على الأقل" required oninput="checkStrength(this.value)" />
            <span class="input-suffix" id="passToggle" onclick="togglePass('password','passToggle')">👁</span>
          </div>
          <div class="password-strength">
            <div class="strength-bar-bg"><div class="strength-bar" id="strengthBar"></div></div>
            <div class="strength-label" id="strengthLabel">أدخل كلمة المرور</div>
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">تأكيد كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required />
            <span class="input-suffix">🔒</span>
          </div>
        </div>

        <label class="terms-check">
          <input type="checkbox" required />
          أوافق على <a href="#">شروط الاستخدام</a> و<a href="#">سياسة الخصوصية</a> الخاصة بـ Wayzon
        </label>

        <button type="submit" class="btn btn-primary auth-submit">
          إنشاء الحساب مجاناً
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </form>

      <div class="auth-bottom-link">
        لديك حساب؟ <a href="{{ route('login') }}">سجّل دخولك ←</a>
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

  function checkStrength(val) {
    const bar   = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)        score++;
    if (/[A-Z]/.test(val))      score++;
    if (/[0-9]/.test(val))      score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
      { w: '0%',   bg: 'transparent', txt: 'أدخل كلمة المرور' },
      { w: '25%',  bg: '#ef4444',     txt: 'ضعيفة جداً' },
      { w: '50%',  bg: '#f59e0b',     txt: 'متوسطة' },
      { w: '75%',  bg: '#3b82f6',     txt: 'جيدة' },
      { w: '100%', bg: '#10b981',     txt: 'قوية جداً ✓' },
    ];
    const lvl = val.length === 0 ? 0 : Math.max(1, score);
    bar.style.width      = levels[lvl].w;
    bar.style.background = levels[lvl].bg;
    label.textContent    = levels[lvl].txt;
    label.style.color    = levels[lvl].bg === 'transparent' ? 'var(--text-3)' : levels[lvl].bg;
  }
</script>
</body>
</html>
