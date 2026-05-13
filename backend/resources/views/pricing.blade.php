<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Wayzon — اختر باقتك</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Tajawal', sans-serif;
      background: #0d1117;
      color: #f0f4ff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px 60px;
    }
    .topbar {
      width: 100%;
      max-width: 960px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 48px;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.1rem;
      font-weight: 900;
    }
    .brand-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
    }
    .logout-btn {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      color: #94a3b8;
      padding: 8px 18px;
      border-radius: 10px;
      font-family: inherit;
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
    }
    .logout-btn:hover { background: rgba(255,255,255,0.1); color: #f0f4ff; }

    .hero {
      text-align: center;
      margin-bottom: 40px;
    }
    .hero-badge {
      display: inline-block;
      background: rgba(239,68,68,0.12);
      border: 1px solid rgba(239,68,68,0.3);
      color: #fca5a5;
      font-size: 0.8rem;
      font-weight: 700;
      padding: 5px 16px;
      border-radius: 99px;
      margin-bottom: 16px;
    }
    .hero h1 {
      font-size: 2rem;
      font-weight: 900;
      margin-bottom: 10px;
    }
    .hero p {
      color: #94a3b8;
      font-size: 0.95rem;
      line-height: 1.7;
    }

    .plans-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      max-width: 960px;
      width: 100%;
    }
    .plan-card {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 18px;
      padding: 28px 24px;
      position: relative;
      transition: all .2s;
    }
    .plan-card:hover { border-color: rgba(255,255,255,0.15); transform: translateY(-3px); }
    .plan-card.feat {
      border: 2px solid #6366f1;
      background: #12183a;
      box-shadow: 0 0 0 4px rgba(99,102,241,0.09);
      transform: translateY(-6px);
    }
    .plan-card.feat:hover { transform: translateY(-10px); }
    .plan-badge {
      position: absolute;
      top: -13px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg,#6366f1,#8b5cf6);
      color: #fff;
      font-size: 0.7rem;
      font-weight: 800;
      padding: 4px 16px;
      border-radius: 99px;
      white-space: nowrap;
    }
    .plan-name { font-size: 1.1rem; font-weight: 900; margin-bottom: 6px; }
    .plan-price { font-size: 2.6rem; font-weight: 900; line-height: 1; margin: 12px 0 4px; }
    .plan-period { font-size: 0.78rem; color: #64748b; margin-bottom: 16px; }
    .plan-desc { font-size: 0.8rem; color: #94a3b8; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.07); min-height: 48px; }
    .plan-feat-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
    .plan-feat { display: flex; align-items: flex-start; gap: 8px; font-size: 0.8rem; color: #94a3b8; }
    .fi { width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: 900; flex-shrink: 0; margin-top: 2px; }
    .fi-y { background: rgba(16,185,129,0.15); color: #10b981; }
    .fi-n { background: rgba(255,255,255,0.04); color: #475569; }
    .fi-s { background: rgba(99,102,241,0.2); color: #a5b4fc; }
    .plan-btn {
      width: 100%;
      padding: 12px;
      border-radius: 12px;
      font-size: 0.875rem;
      font-weight: 800;
      font-family: inherit;
      cursor: pointer;
      border: none;
      transition: all .2s;
    }
    .plan-btn-upgrade { background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff; box-shadow: 0 4px 16px rgba(99,102,241,0.35); }
    .plan-btn-upgrade:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,0.45); }
    .plan-btn-pro { background: linear-gradient(135deg,#7c3aed,#a855f7); color: #fff; box-shadow: 0 4px 16px rgba(139,92,246,0.35); }

    @media(max-width: 768px) {
      .plans-grid { grid-template-columns: 1fr; max-width: 380px; }
      .plan-card.feat { transform: none; }
      .hero h1 { font-size: 1.5rem; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="brand">
      <div class="brand-icon">🤖</div>
      Wayzon
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">تسجيل خروج</button>
    </form>
  </div>

  <div class="hero">
    <div class="hero-badge">⚠️ اشتراكك غير مفعّل</div>
    <h1>اختر باقتك وابدأ الآن</h1>
    <p>للوصول إلى لوحة التحكم وربط متجرك يجب اختيار باقة مناسبة</p>
  </div>

  <div class="plans-grid">

    {{-- BASIC --}}
    <div class="plan-card">
      <div class="plan-name">🚀 الأساسية</div>
      <div class="plan-price" style="color:#f0f4ff;">55</div>
      <div class="plan-period">ر.س / شهر</div>
      <div class="plan-desc">مثالية للمتاجر الناشئة التي تبدأ رحلتها مع الأتمتة</div>
      <div class="plan-feat-list">
        <div class="plan-feat"><span class="fi fi-y">✓</span> ربط مع سلة (الطلبات + الحالات)</div>
        <div class="plan-feat"><span class="fi fi-y">✓</span> إرسال رسائل تلقائية للعملاء</div>
        <div class="plan-feat"><span class="fi fi-y">✓</span> تخصيص نصوص الرسائل</div>
        <div class="plan-feat"><span class="fi fi-y">✓</span> لوحة تحكم الرسائل</div>
        <div class="plan-feat"><span class="fi fi-n">—</span> ردود ذكية بالذكاء الاصطناعي</div>
        <div class="plan-feat"><span class="fi fi-n">—</span> سيناريوهات الرد (Flows)</div>
      </div>
      <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="plan-btn plan-btn-upgrade" style="background:rgba(255,255,255,0.07);color:#f0f4ff;box-shadow:none;display:block;text-align:center;text-decoration:none;">الاشتراك في هذه الخطة</a>
    </div>

    {{-- SMART --}}
    <div class="plan-card feat">
      <span class="plan-badge">⭐ الأكثر طلباً</span>
      <div class="plan-name" style="color:#a5b4fc;">🧠 الذكية</div>
      <div class="plan-price" style="background:linear-gradient(135deg,#fff,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">99</div>
      <div class="plan-period">ر.س / شهر</div>
      <div class="plan-desc" style="color:#c4b5fd;">للمتاجر التي تريد ردوداً ذكية وتجربة عملاء استثنائية</div>
      <div class="plan-feat-list">
        <div class="plan-feat"><span class="fi fi-y">✓</span> كل مميزات الأساسية</div>
        <div class="plan-feat"><span class="fi fi-s">✦</span> ردود ذكية باستخدام OpenAI</div>
        <div class="plan-feat"><span class="fi fi-s">✦</span> الرد التلقائي على الاستفسارات</div>
        <div class="plan-feat"><span class="fi fi-s">✦</span> تخصيص أسلوب الرد</div>
        <div class="plan-feat"><span class="fi fi-s">✦</span> تدريب بيانات المتجر</div>
        <div class="plan-feat"><span class="fi fi-n">—</span> سيناريوهات الرد (Flows)</div>
      </div>
      <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="plan-btn plan-btn-upgrade" style="display:block;text-align:center;text-decoration:none;">اشترك الآن ←</a>
    </div>

    {{-- PRO --}}
    <div class="plan-card" style="border-color:rgba(168,85,247,0.3);">
      <div class="plan-name">🏆 الاحترافية</div>
      <div class="plan-price" style="background:linear-gradient(135deg,#d8b4fe,#f0abfc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">139</div>
      <div class="plan-period">ر.س / شهر</div>
      <div class="plan-desc">للمتاجر الجادة التي تريد التحكم الكامل والأداء المتميز</div>
      <div class="plan-feat-list">
        <div class="plan-feat"><span class="fi fi-y">✓</span> كل مميزات الذكية</div>
        <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> سيناريوهات الرد (Flows)</div>
        <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> تحليل الرسائل والتفاعل</div>
        <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> أولوية في الأداء والردود</div>
        <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> تحديثات مستقبلية</div>
      </div>
      <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="plan-btn plan-btn-pro" style="display:block;text-align:center;text-decoration:none;">اشترك الآن ←</a>
    </div>

  </div>

</body>
</html>
