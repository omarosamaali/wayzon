<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>شروط الاستخدام — Wayzon</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #050509; --bg2: #0c0e1a; --bg3: #111827;
      --border: rgba(255,255,255,0.07); --border2: rgba(255,255,255,0.12);
      --primary: #6366f1; --primary-light: #818cf8;
      --t1: #f1f5f9; --t2: #94a3b8; --t3: #475569;
    }
    body { font-family: 'Tajawal', sans-serif; background: var(--bg); color: var(--t1); line-height: 1.8; min-height: 100vh; }
    a { color: var(--primary-light); text-decoration: none; }
    a:hover { text-decoration: underline; }

    nav { background: rgba(5,5,9,0.9); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
    .logo { font-size: 1.25rem; font-weight: 800; color: var(--t1); }
    .logo span { color: var(--primary-light); }
    .nav-back { font-size: 0.875rem; color: var(--t2); display: flex; align-items: center; gap: 6px; transition: color 0.2s; }
    .nav-back:hover { color: var(--t1); text-decoration: none; }

    .hero-section { background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, transparent 60%); border-bottom: 1px solid var(--border); padding: 56px 24px; text-align: center; }
    .hero-section h1 { font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 900; margin-bottom: 12px; }
    .hero-section p { color: var(--t2); font-size: 0.9375rem; }

    .container { max-width: 780px; margin: 0 auto; padding: 48px 24px 80px; }

    .section { margin-bottom: 40px; }
    .section h2 { font-size: 1.25rem; font-weight: 800; color: var(--t1); margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
    .section p { color: var(--t2); font-size: 0.9375rem; margin-bottom: 12px; }
    .section ul { padding-right: 20px; color: var(--t2); font-size: 0.9375rem; }
    .section ul li { margin-bottom: 8px; list-style: disc; }

    .highlight-box { background: var(--bg3); border: 1px solid var(--border2); border-radius: 12px; padding: 20px 24px; margin-bottom: 12px; }
    .highlight-box p { margin: 0; }
    .warning-box { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2); border-radius: 12px; padding: 16px 20px; margin-bottom: 12px; color: #fbbf24; font-size: 0.9rem; }

    .contact-box { background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(139,92,246,0.05)); border: 1px solid rgba(99,102,241,0.2); border-radius: 14px; padding: 28px; text-align: center; margin-top: 48px; }
    .contact-box h3 { font-size: 1.1rem; font-weight: 800; margin-bottom: 8px; }
    .contact-box p { color: var(--t2); font-size: 0.9rem; margin-bottom: 16px; }
    .contact-box a.btn { display: inline-flex; align-items: center; gap: 8px; background: var(--primary); color: #fff; padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; }

    footer { text-align: center; padding: 24px; color: var(--t3); font-size: 0.8125rem; border-top: 1px solid var(--border); }
    footer a { color: var(--t3); }
    footer a:hover { color: var(--t2); }
  </style>
</head>
<body>

<nav>
  <div class="logo">Way<span>zon</span></div>
  <a href="{{ route('home') }}" class="nav-back">← العودة للرئيسية</a>
</nav>

<div class="hero-section">
  <h1>📄 شروط الاستخدام</h1>
  <p>آخر تحديث: {{ date('d/m/Y') }} — يُرجى قراءة هذه الشروط بعناية قبل استخدام المنصة</p>
</div>

<div class="container">

  <div class="section">
    <h2>📋 القبول بالشروط</h2>
    <p>باستخدامك لمنصة <strong>Wayzon</strong>، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي من هذه الشروط، يُرجى التوقف عن استخدام المنصة.</p>
  </div>

  <div class="section">
    <h2>🛍️ وصف الخدمة</h2>
    <p>Wayzon منصة SaaS تتيح لأصحاب متاجر سلة:</p>
    <ul>
      <li>ربط واتساب بالمتجر لإرسال إشعارات الطلبات تلقائياً</li>
      <li>تشغيل بوت ذكاء اصطناعي للرد على استفسارات العملاء</li>
      <li>تدريب البوت على معلومات المتجر والسياسات</li>
      <li>متابعة الطلبات والتقارير من لوحة تحكم مركزية</li>
    </ul>
  </div>

  <div class="section">
    <h2>✅ الاستخدام المقبول</h2>
    <ul>
      <li>استخدام المنصة لأغراض تجارية مشروعة فقط</li>
      <li>عدم إرسال رسائل مزعجة (Spam) أو محتوى مسيء عبر الخدمة</li>
      <li>الالتزام بسياسات استخدام واتساب وسلة</li>
      <li>عدم مشاركة بيانات الحساب مع أطراف غير مصرح لها</li>
      <li>الإفصاح لعملائك بأن الردود قد تكون آلية</li>
    </ul>
  </div>

  <div class="section">
    <h2>🚫 الاستخدام المحظور</h2>
    <div class="warning-box">
      ⚠️ يُحظر استخدام المنصة لأي غرض مخالف للأنظمة والقوانين السعودية أو سياسات واتساب وسلة.
    </div>
    <ul>
      <li>إرسال رسائل ترويجية غير مرغوب فيها</li>
      <li>انتهاك خصوصية العملاء أو جمع بياناتهم دون إذن</li>
      <li>استخدام الخدمة في أنشطة احتيالية أو مضللة</li>
      <li>محاولة اختراق أو تعطيل المنصة</li>
    </ul>
  </div>

  <div class="section">
    <h2>💳 الاشتراكات والمدفوعات</h2>
    <ul>
      <li>الاشتراكات تُدفع مسبقاً وتُجدَّد تلقائياً ما لم تُلغَ</li>
      <li>لا يوجد استرداد للرسوم المدفوعة بعد بدء الفترة</li>
      <li>يمكن ترقية الباقة في أي وقت والفرق يُحسب نسبياً</li>
      <li>عند تأخر الدفع، قد تُعلَّق الخدمة مؤقتاً</li>
      <li>المنصة تستخدم بوابة دفع سلة لمعالجة المدفوعات بأمان</li>
    </ul>
  </div>

  <div class="section">
    <h2>🔄 الفترة التجريبية</h2>
    <div class="highlight-box">
      <p>تتيح المنصة فترة تجريبية مجانية لمدة <strong>3 أيام</strong> تشمل كامل مميزات الباقة المختارة. لا يُطلب إدخال بيانات بطاقة لبدء التجربة.</p>
    </div>
  </div>

  <div class="section">
    <h2>⚖️ حدود المسؤولية</h2>
    <p>Wayzon غير مسؤولة عن:</p>
    <ul>
      <li>انقطاع خدمة واتساب أو سلة لأسباب خارجة عن إرادتنا</li>
      <li>محتوى الردود التي يولّدها الذكاء الاصطناعي — أنت مسؤول عن مراجعة بيانات التدريب</li>
      <li>الخسائر التجارية الناتجة عن توقف الخدمة المؤقت</li>
      <li>أي قرارات تتخذها بناءً على تقارير المنصة</li>
    </ul>
  </div>

  <div class="section">
    <h2>🔒 الملكية الفكرية</h2>
    <p>جميع حقوق المنصة (الكود، التصميم، العلامة التجارية) محفوظة لـ Wayzon. يحق لك استخدام المنصة وفق هذه الشروط فقط دون أي حق في نسخها أو توزيعها.</p>
  </div>

  <div class="section">
    <h2>📝 التعديلات على الشروط</h2>
    <p>نحتفظ بحق تعديل هذه الشروط في أي وقت. سنُخطرك عبر البريد الإلكتروني أو داخل المنصة قبل 7 أيام من تطبيق أي تغييرات جوهرية. استمرارك في الاستخدام بعد التعديل يُعدّ قبولاً للشروط الجديدة.</p>
  </div>

  <div class="section">
    <h2>🏛️ القانون المطبّق</h2>
    <p>تخضع هذه الشروط لأنظمة المملكة العربية السعودية، وأي نزاع يُحسم وفق الأنظمة السعودية المعمول بها.</p>
  </div>

  <div class="contact-box">
    <h3>لديك سؤال حول الشروط؟</h3>
    <p>فريقنا جاهز للإجابة على استفساراتك</p>
    <a href="mailto:support@wayzon.sa" class="btn">📧 تواصل معنا</a>
  </div>

</div>

<footer>
  <p>© {{ date('Y') }} Wayzon — جميع الحقوق محفوظة &nbsp;|&nbsp; <a href="{{ route('privacy') }}">سياسة الخصوصية</a></p>
</footer>

</body>
</html>
