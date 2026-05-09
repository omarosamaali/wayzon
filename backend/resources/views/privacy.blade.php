<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>سياسة الخصوصية — Wayzon</title>
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
  <h1>🔒 سياسة الخصوصية</h1>
  <p>آخر تحديث: {{ date('d/m/Y') }} — نلتزم بحماية بياناتك وخصوصيتك</p>
</div>

<div class="container">

  <div class="section">
    <h2>📋 مقدمة</h2>
    <p>تُعدّ هذه السياسة جزءاً من اتفاقية الاستخدام بينك وبين منصة <strong>Wayzon</strong>. باستخدامك للمنصة، فإنك توافق على الشروط الواردة أدناه المتعلقة بجمع البيانات ومعالجتها وحمايتها.</p>
    <p>نحن ملتزمون بحماية خصوصيتك وعدم بيع بياناتك أو مشاركتها مع أطراف ثالثة لأغراض تجارية.</p>
  </div>

  <div class="section">
    <h2>📦 البيانات التي نجمعها</h2>
    <ul>
      <li><strong>بيانات الحساب:</strong> الاسم، البريد الإلكتروني، كلمة المرور (مشفّرة)</li>
      <li><strong>بيانات المتجر:</strong> معرّف متجر سلة، اسم المتجر، رمز الوصول OAuth</li>
      <li><strong>بيانات الطلبات:</strong> معلومات الطلبات الواردة من سلة عبر الـ Webhooks</li>
      <li><strong>بيانات التدريب:</strong> المعلومات التي تُدخلها في صفحة تدريب البوت</li>
      <li><strong>بيانات الاستخدام:</strong> سجلات الدخول والنشاط داخل المنصة</li>
    </ul>
  </div>

  <div class="section">
    <h2>🎯 كيف نستخدم بياناتك</h2>
    <ul>
      <li>تشغيل خدمة الرد التلقائي على واتساب</li>
      <li>ربط المتجر مع منصة سلة وإدارة الطلبات</li>
      <li>توليد ردود ذكية عبر الذكاء الاصطناعي بناءً على بيانات التدريب</li>
      <li>إرسال إشعارات الطلبات لعملاء المتجر عبر واتساب</li>
      <li>تحسين الخدمة وإصلاح الأخطاء التقنية</li>
    </ul>
  </div>

  <div class="section">
    <h2>🔐 أمان البيانات</h2>
    <div class="highlight-box">
      <p>نستخدم تشفير SSL/TLS لحماية البيانات أثناء النقل، ونخزّن كلمات المرور باستخدام خوارزميات التجزئة الآمنة (bcrypt). رموز الوصول الخاصة بسلة تُخزَّن مشفّرة ولا يمكن الاطلاع عليها.</p>
    </div>
    <ul>
      <li>لا نشارك بياناتك مع أطراف ثالثة إلا لتشغيل الخدمة (OpenAI, Salla)</li>
      <li>لا نبيع بياناتك لأي جهة إعلانية</li>
      <li>يمكنك طلب حذف بياناتك في أي وقت</li>
    </ul>
  </div>

  <div class="section">
    <h2>🤝 مشاركة البيانات مع أطراف ثالثة</h2>
    <p>نستخدم الخدمات التالية لتشغيل المنصة:</p>
    <ul>
      <li><strong>OpenAI:</strong> لتوليد الردود الذكية (رسائل الطلبات فقط، لا بيانات شخصية)</li>
      <li><strong>سلة (Salla):</strong> لجلب بيانات الطلبات والمتجر عبر OAuth</li>
      <li><strong>Hostinger:</strong> استضافة السيرفرات في بيئة آمنة</li>
    </ul>
  </div>

  <div class="section">
    <h2>📱 واتساب والرسائل</h2>
    <p>الاتصال بواتساب يتم عبر رقمك الشخصي أو رقم متجرك. نحن لا نخزّن محتوى المحادثات بشكل دائم — تُحفظ مؤقتاً في الذاكرة لمدة الجلسة فقط لتوفير سياق للردود.</p>
  </div>

  <div class="section">
    <h2>⏱️ مدة الاحتفاظ بالبيانات</h2>
    <ul>
      <li>بيانات الحساب: طالما حسابك نشط</li>
      <li>بيانات الطلبات: 12 شهراً</li>
      <li>سجلات النشاط: 30 يوماً</li>
      <li>عند إلغاء الاشتراك: حذف البيانات خلال 30 يوماً</li>
    </ul>
  </div>

  <div class="section">
    <h2>✅ حقوقك</h2>
    <ul>
      <li>الحق في الاطلاع على بياناتك</li>
      <li>الحق في تصحيح بياناتك</li>
      <li>الحق في حذف حسابك وبياناتك كاملاً</li>
      <li>الحق في الاعتراض على معالجة بياناتك</li>
    </ul>
  </div>

  <div class="contact-box">
    <h3>لديك استفسار حول خصوصيتك؟</h3>
    <p>نحن هنا للمساعدة — تواصل معنا وسنرد خلال 24 ساعة</p>
    <a href="mailto:support@wayzon.sa" class="btn">📧 تواصل معنا</a>
  </div>

</div>

<footer>
  <p>© {{ date('Y') }} Wayzon — جميع الحقوق محفوظة &nbsp;|&nbsp; <a href="{{ route('terms') }}">شروط الاستخدام</a></p>
</footer>

</body>
</html>
