<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>مرحباً بك في Wayzon</title>
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; padding: 0; background: #f0f4ff; font-family: Arial, Helvetica, sans-serif; }
    .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 40px rgba(99,102,241,0.12); }

    /* Header */
    .header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 48px 32px 40px; text-align: center; position: relative; }
    .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 16px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; }
    .logo { font-size: 2.2rem; font-weight: 900; color: #ffffff; letter-spacing: -1px; margin: 0; }
    .tagline { color: rgba(255,255,255,0.75); font-size: 0.88rem; margin-top: 6px; }

    /* Body */
    .body { padding: 40px 36px; }
    .greeting { font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0 0 8px; }
    .subtitle { color: #64748b; font-size: 0.95rem; line-height: 1.7; margin: 0 0 32px; }

    /* Success badge */
    .badge { display: inline-flex; align-items: center; gap: 8px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; font-size: 0.85rem; font-weight: 700; padding: 8px 16px; border-radius: 50px; margin-bottom: 28px; }

    /* Info card */
    .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 28px; }
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #e2e8f0; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { color: #94a3b8; font-size: 0.82rem; }
    .info-value { color: #1e293b; font-weight: 700; font-size: 0.9rem; direction: ltr; }

    /* Features */
    .features { margin-bottom: 32px; }
    .features-title { font-size: 0.88rem; font-weight: 700; color: #475569; margin-bottom: 12px; }
    .feature { display: flex; align-items: center; gap: 10px; padding: 6px 0; color: #475569; font-size: 0.88rem; }
    .feature-dot { width: 8px; height: 8px; background: #6366f1; border-radius: 50%; flex-shrink: 0; }

    /* CTA Button */
    .btn-wrap { text-align: center; margin: 8px 0 24px; }
    .btn { display: inline-block; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #ffffff !important; text-decoration: none; padding: 16px 48px; border-radius: 12px; font-size: 1rem; font-weight: 800; letter-spacing: 0.3px; box-shadow: 0 4px 16px rgba(99,102,241,0.35); }

    /* Set password link */
    .set-password { text-align: center; margin-bottom: 8px; }
    .set-password a { color: #6366f1; font-size: 0.85rem; text-decoration: none; font-weight: 600; }

    /* Note */
    .note { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 14px 18px; color: #92400e; font-size: 0.82rem; line-height: 1.6; margin-top: 24px; }

    /* Footer */
    .footer { background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
    .footer p { color: #94a3b8; font-size: 0.78rem; margin: 0; line-height: 1.8; }
    .footer strong { color: #6366f1; }
  </style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div class="logo">Wayzon</div>
    <div class="tagline">بوت واتساب ذكي لمتجرك على سلة</div>
  </div>

  <div class="body">
    <div class="badge">✅ تم ربط المتجر بنجاح</div>

    <h1 class="greeting">أهلاً {{ $user->name }} 👋</h1>
    <p class="subtitle">تم إنشاء حسابك على Wayzon وربط متجرك بسلة بنجاح. يمكنك الآن الوصول للوحة التحكم وتفعيل البوت الذكي لمتجرك.</p>

    <div class="info-card">
      <div class="info-row">
        <span class="info-label">البريد الإلكتروني</span>
        <span class="info-value">{{ $user->email }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">المتجر</span>
        <span class="info-value">{{ $user->name }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">الفترة التجريبية</span>
        <span class="info-value">3 أيام مجاناً</span>
      </div>
    </div>

    <div class="features">
      <div class="features-title">ماذا يقدم لك Wayzon؟</div>
      <div class="feature"><span class="feature-dot"></span> ردود تلقائية ذكية على رسائل واتساب</div>
      <div class="feature"><span class="feature-dot"></span> ربط مباشر مع طلبات سلة وحالاتها</div>
      <div class="feature"><span class="feature-dot"></span> تدريب البوت على معلومات متجرك</div>
      <div class="feature"><span class="feature-dot"></span> حملات رسائل جماعية للعملاء</div>
    </div>

    <div class="btn-wrap">
      <a href="{{ config('app.url') }}/dashboard" class="btn">الذهاب للوحة التحكم</a>
    </div>

    <div class="set-password">
      <a href="{{ $resetLink }}">تعيين كلمة مرور للحساب</a>
    </div>

    <div class="note">
      💡 <strong>ملاحظة:</strong> يمكنك الدخول للوحة التحكم مباشرة عبر تطبيق Wayzon في سلة، أو عبر الرابط أعلاه. لتعيين كلمة مرور خاصة، اضغط على رابط "تعيين كلمة مرور" أعلاه.
    </div>
  </div>

  <div class="footer">
    <p>
      <strong>Wayzon</strong> — بوت واتساب ذكي لمتاجر سلة<br>
      جميع الحقوق محفوظة &copy; {{ date('Y') }}<br>
      هذا البريد أُرسل تلقائياً عند تثبيت التطبيق من سلة
    </p>
  </div>

</div>
</body>
</html>
