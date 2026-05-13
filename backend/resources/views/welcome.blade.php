<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>وايزون Wayzon - بوت واتساب AI لمتاجر سلة</title>
  <meta name="description" content="وايزون Wayzon بوت واتساب ذكي لمتاجر سلة — رد تلقائي على العملاء، تتبع الطلبات، وبحث المنتجات بالذكاء الاصطناعي. جرب مجاناً الآن!" />
  <meta name="keywords" content="بوت واتساب, سلة, واتساب AI, أتمتة متجر, Wayzon, وايزون, بوت سلة, واتساب ذكي, ردود تلقائية" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://wayzon.online/" />
  <link rel="icon" type="image/jpeg" href="/fav.jpeg" />
  <link rel="apple-touch-icon" href="/fav.jpeg" />

  <!-- Open Graph (مشاركة على السوشيال ميديا) -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://wayzon.online/" />
  <meta property="og:title" content="وايزون Wayzon - بوت واتساب AI لمتاجر سلة" />
  <meta property="og:description" content="بوت واتساب ذكي لمتاجر سلة — رد تلقائي على العملاء، تتبع الطلبات، وبحث المنتجات بالذكاء الاصطناعي." />
  <meta property="og:locale" content="ar_SA" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="وايزون Wayzon - بوت واتساب AI لمتاجر سلة" />
  <meta name="twitter:description" content="بوت واتساب ذكي لمتاجر سلة — رد تلقائي على العملاء، تتبع الطلبات، وبحث المنتجات." />

  <!-- Schema.org structured data -->
  <script type="application/ld+json">
  @verbatim
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "وايزون Wayzon",
    "url": "https://wayzon.online",
    "description": "بوت واتساب ذكي لمتاجر سلة",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "offers": {
      "@type": "Offer",
      "price": "0",
      "priceCurrency": "SAR"
    },
    "inLanguage": "ar"
  }
  @endverbatim
  </script>
  <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Tajawal:wght@300;400;500;700;800;900&display=swap');

:root {
  --bg-primary:    #050509;
  --bg-secondary:  #0c0e1a;
  --bg-card:       #111827;
  --bg-card-2:     #161d2e;
  --border:        rgba(255,255,255,0.07);
  --border-strong: rgba(255,255,255,0.12);
  --primary:       #6366f1;
  --primary-dark:  #4f46e5;
  --primary-light: #818cf8;
  --primary-glow:  rgba(99,102,241,0.25);
  --secondary:     #8b5cf6;
  --accent:        #06b6d4;
  --text-1:        #f1f5f9;
  --text-2:        #94a3b8;
  --text-3:        #475569;
  --success:       #10b981;
  --warning:       #f59e0b;
  --danger:        #ef4444;
  --r:             12px;
  --r-lg:          18px;
  --r-xl:          24px;
  --shadow:        0 8px 32px rgba(0,0,0,0.5);
  --shadow-primary:0 8px 32px rgba(99,102,241,0.3);
  --transition:    all 0.25s cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; font-size: 16px; }
body { font-family: 'Tajawal', 'Inter', sans-serif; background: var(--bg-primary); color: var(--text-1); direction: rtl; line-height: 1.6; overflow-x: hidden; -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }
ul { list-style: none; }
button { cursor: pointer; border: none; outline: none; font-family: inherit; }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--bg-primary); }
::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

.btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 24px; border-radius: var(--r); font-size: 0.9375rem; font-weight: 600; transition: var(--transition); white-space: nowrap; }
.btn-primary { background: var(--primary); color: #fff; box-shadow: 0 0 0 0 var(--primary-glow); }
.btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 20px var(--primary-glow); }
.btn-secondary { background: rgba(255,255,255,0.06); color: var(--text-1); border: 1px solid var(--border-strong); }
.btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: var(--primary); transform: translateY(-1px); }
.btn-outline { background: transparent; color: var(--primary-light); border: 1px solid var(--primary); }
.btn-outline:hover { background: var(--primary-glow); transform: translateY(-1px); }
.btn-ghost { background: transparent; color: var(--text-2); padding: 8px 16px; }
.btn-ghost:hover { color: var(--text-1); background: rgba(255,255,255,0.05); }
.btn-lg { padding: 14px 32px; font-size: 1rem; border-radius: var(--r-lg); }
.btn-sm { padding: 7px 16px; font-size: 0.85rem; }

.badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 99px; font-size: 0.8125rem; font-weight: 600; }
.badge-primary { background: rgba(99,102,241,0.15); color: var(--primary-light); border: 1px solid rgba(99,102,241,0.25); }
.badge-success { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }

.card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 24px; transition: var(--transition); }
.card:hover { border-color: var(--border-strong); box-shadow: var(--shadow); }
.card-glow:hover { border-color: rgba(99,102,241,0.35); box-shadow: 0 0 0 1px rgba(99,102,241,0.1), var(--shadow); }

.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.section { padding: 96px 0; }
.section-sm { padding: 64px 0; }

.section-tag { display: inline-flex; align-items: center; gap: 8px; padding: 5px 14px; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2); border-radius: 99px; font-size: 0.8125rem; font-weight: 600; color: var(--primary-light); margin-bottom: 20px; }
.section-title { font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 800; line-height: 1.2; color: var(--text-1); margin-bottom: 16px; }
.section-subtitle { font-size: 1.0625rem; color: var(--text-2); max-width: 560px; line-height: 1.7; }
.text-center { text-align: center; }
.text-center .section-subtitle { margin: 0 auto; }
.gradient-text { background: linear-gradient(135deg, var(--primary-light), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

.navbar { position: fixed; top: 0; inset-inline: 0; z-index: 1000; padding: 0 24px; height: 68px; display: flex; align-items: center; border-bottom: 1px solid transparent; transition: var(--transition); }
.navbar.scrolled { background: rgba(5,5,9,0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-color: var(--border); }
.navbar-inner { max-width: 1200px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 32px; }
.logo { display: flex; align-items: center; gap: 10px; font-size: 1.375rem; font-weight: 800; color: var(--text-1); }
.logo-img { width: 36px; height: 36px; object-fit: contain; border-radius: 10px; }
.nav-links { display: flex; align-items: center; gap: 4px; }
.nav-links a { padding: 6px 14px; border-radius: 8px; font-size: 0.9rem; font-weight: 500; color: var(--text-2); transition: var(--transition); }
.nav-links a:hover { color: var(--text-1); background: rgba(255,255,255,0.05); }
.nav-cta { display: flex; align-items: center; gap: 10px; }
.nav-mobile-toggle { display: none; flex-direction: column; gap: 5px; padding: 8px; background: transparent; cursor: pointer; }
.nav-mobile-toggle span { width: 22px; height: 2px; background: var(--text-2); border-radius: 1px; transition: var(--transition); display: block; }

.hero { min-height: 100vh; display: flex; align-items: center; padding-top: 68px; position: relative; overflow: hidden; }
.hero-bg { position: absolute; inset: 0; background: radial-gradient(ellipse 80% 60% at 50% -20%, rgba(99,102,241,0.18) 0%, transparent 70%), radial-gradient(ellipse 60% 40% at 90% 50%, rgba(139,92,246,0.1) 0%, transparent 60%), radial-gradient(ellipse 60% 40% at 10% 80%, rgba(6,182,212,0.07) 0%, transparent 60%); pointer-events: none; }
.hero-grid-lines { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px); background-size: 60px 60px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); pointer-events: none; }
.hero-content { position: relative; z-index: 1; max-width: 780px; margin: 0 auto; text-align: center; padding: 80px 0; }
.hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; padding: 5px 16px 5px 8px; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2); border-radius: 99px; font-size: 0.8125rem; font-weight: 600; color: var(--primary-light); margin-bottom: 28px; cursor: pointer; transition: var(--transition); }
.hero-eyebrow:hover { background: rgba(99,102,241,0.18); }
.hero-eyebrow .dot { width: 6px; height: 6px; background: var(--primary); border-radius: 50%; animation: pulse-glow 2s ease-in-out infinite; }
.hero-title { font-size: clamp(2.2rem, 6vw, 4rem); font-weight: 900; line-height: 1.1; color: var(--text-1); margin-bottom: 24px; letter-spacing: -0.02em; }
.hero-title .line2 { background: linear-gradient(135deg, #818cf8 0%, #a78bfa 50%, #38bdf8 100%); background-size: 200% 200%; animation: gradientShift 4s ease infinite; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.hero-subtitle { font-size: 1.125rem; color: var(--text-2); line-height: 1.75; margin-bottom: 40px; max-width: 560px; margin-inline: auto; }
.hero-actions { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 56px; }
.hero-social-proof { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; font-size: 0.875rem; color: var(--text-3); }
.hero-avatars { display: flex; }
.hero-avatars span { width: 30px; height: 30px; border-radius: 50%; border: 2px solid var(--bg-primary); background: linear-gradient(135deg, var(--primary), var(--secondary)); margin-inline-start: -8px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; color: #fff; }
.hero-avatars span:first-child { margin-inline-start: 0; }
.stars { color: #fbbf24; letter-spacing: 1px; }

.hero-mockup { position: relative; max-width: 900px; margin: 0 auto; animation: fadeInUp 0.8s ease 0.3s both; }
.mockup-browser { background: var(--bg-card); border: 1px solid var(--border-strong); border-radius: var(--r-xl); overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.05); }
.mockup-bar { height: 44px; background: var(--bg-card-2); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 16px; gap: 8px; }
.mockup-dot { width: 12px; height: 12px; border-radius: 50%; }
.mockup-dot.red { background: #ef4444; }
.mockup-dot.yellow { background: #f59e0b; }
.mockup-dot.green { background: #10b981; }
.mockup-url { flex: 1; max-width: 280px; margin: 0 auto; height: 24px; background: rgba(255,255,255,0.05); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: var(--text-3); }
.mockup-body { padding: 24px; display: grid; grid-template-columns: 200px 1fr; gap: 16px; min-height: 320px; }
.mockup-sidebar { background: rgba(0,0,0,0.2); border-radius: 10px; padding: 12px; display: flex; flex-direction: column; gap: 4px; }
.mockup-nav-item { height: 32px; border-radius: 6px; display: flex; align-items: center; padding: 0 10px; gap: 8px; font-size: 0.75rem; color: var(--text-3); }
.mockup-nav-item.active { background: rgba(99,102,241,0.2); color: var(--primary-light); }
.mockup-nav-item .icon { width: 14px; height: 14px; border-radius: 3px; background: currentColor; opacity: 0.5; }
.mockup-content { display: flex; flex-direction: column; gap: 12px; }
.mockup-stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.mockup-stat { background: rgba(255,255,255,0.04); border: 1px solid var(--border); border-radius: 8px; padding: 12px; }
.mockup-stat-label { width: 60%; height: 6px; background: rgba(255,255,255,0.08); border-radius: 3px; margin-bottom: 8px; }
.mockup-stat-value { width: 40%; height: 18px; background: rgba(99,102,241,0.3); border-radius: 4px; }
.mockup-chart { background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 8px; padding: 12px; height: 120px; display: flex; align-items: flex-end; gap: 6px; }
.mockup-bar-item { flex: 1; border-radius: 4px 4px 0 0; background: linear-gradient(180deg, var(--primary) 0%, rgba(99,102,241,0.3) 100%); }
.mockup-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.mockup-mini-card { background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 8px; padding: 12px; height: 60px; }
.mockup-glow { position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%); width: 80%; height: 80px; background: var(--primary); filter: blur(60px); opacity: 0.15; pointer-events: none; }

.logos-strip { padding: 40px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.logos-label { text-align: center; font-size: 0.8125rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; margin-bottom: 24px; }
.logos-row { display: flex; align-items: center; justify-content: center; gap: 40px; flex-wrap: wrap; }
.logo-pill { display: flex; align-items: center; gap: 8px; padding: 8px 20px; background: rgba(255,255,255,0.04); border: 1px solid var(--border); border-radius: 99px; font-size: 0.875rem; font-weight: 700; color: var(--text-3); transition: var(--transition); }
.logo-pill:hover { color: var(--text-2); border-color: var(--border-strong); }
.logo-pill span { font-size: 1.1rem; }

.features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.feature-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 28px; transition: var(--transition); position: relative; overflow: hidden; }
.feature-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, var(--primary-glow) 0%, transparent 60%); opacity: 0; transition: var(--transition); }
.feature-card:hover::before { opacity: 1; }
.feature-card:hover { border-color: rgba(99,102,241,0.3); transform: translateY(-3px); box-shadow: var(--shadow); }
.feature-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 18px; position: relative; }
.fi-indigo { background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.25); }
.fi-purple { background: rgba(139,92,246,0.15); border: 1px solid rgba(139,92,246,0.25); }
.fi-cyan   { background: rgba(6,182,212,0.15);  border: 1px solid rgba(6,182,212,0.25); }
.fi-green  { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.25); }
.fi-orange { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.25); }
.fi-pink   { background: rgba(236,72,153,0.15); border: 1px solid rgba(236,72,153,0.25); }
.feature-card h3 { font-size: 1.0625rem; font-weight: 700; color: var(--text-1); margin-bottom: 10px; position: relative; }
.feature-card p { font-size: 0.9rem; color: var(--text-2); line-height: 1.7; position: relative; }
.feature-card-big { grid-column: span 2; }

.how-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; position: relative; margin-top: 56px; }
.how-steps::before { content: ''; position: absolute; top: 40px; inset-inline: 10%; height: 1px; background: linear-gradient(to left, transparent, var(--primary), transparent); }
.how-step { text-align: center; position: relative; }
.how-step-num { width: 80px; height: 80px; border-radius: 20px; background: var(--bg-card); border: 1px solid var(--border-strong); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2rem; position: relative; transition: var(--transition); }
.how-step:hover .how-step-num { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99,102,241,0.1); }
.step-badge { position: absolute; top: -8px; inset-inline-end: -8px; width: 22px; height: 22px; background: var(--primary); border-radius: 50%; border: 2px solid var(--bg-primary); display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: 800; color: #fff; }
.how-step h3 { font-size: 1rem; font-weight: 700; color: var(--text-1); margin-bottom: 8px; }
.how-step p { font-size: 0.875rem; color: var(--text-2); line-height: 1.6; }

.stats-section { background: var(--bg-secondary); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; }
.stat-item { padding: 48px 32px; text-align: center; border-inline-start: 1px solid var(--border); }
.stat-item:first-child { border-inline-start: none; }
.stat-num { font-size: 2.5rem; font-weight: 900; color: var(--text-1); line-height: 1; margin-bottom: 8px; }
.stat-num span { color: var(--primary-light); }
.stat-label { font-size: 0.9rem; color: var(--text-2); font-weight: 500; }

.testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 56px; }
.testimonial-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 28px; transition: var(--transition); }
.testimonial-card:hover { border-color: var(--border-strong); transform: translateY(-3px); box-shadow: var(--shadow); }
.testimonial-stars { color: #fbbf24; margin-bottom: 16px; font-size: 0.875rem; }
.testimonial-text { font-size: 0.9375rem; color: var(--text-2); line-height: 1.75; margin-bottom: 24px; }
.testimonial-author { display: flex; align-items: center; gap: 12px; }
.author-avatar { width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 800; color: #fff; flex-shrink: 0; }
.author-name { font-size: 0.9375rem; font-weight: 700; color: var(--text-1); }
.author-title { font-size: 0.8125rem; color: var(--text-3); }

.cta-section { text-align: center; padding: 96px 0; }
.cta-box { background: linear-gradient(135deg, rgba(99,102,241,0.12) 0%, rgba(139,92,246,0.08) 100%); border: 1px solid rgba(99,102,241,0.2); border-radius: 28px; padding: 72px 48px; position: relative; overflow: hidden; }
.cta-box::before { content: ''; position: absolute; top: -60px; left: 50%; transform: translateX(-50%); width: 300px; height: 300px; background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%); pointer-events: none; }
.cta-box h2 { font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 900; color: var(--text-1); margin-bottom: 16px; position: relative; }
.cta-box p { font-size: 1.0625rem; color: var(--text-2); max-width: 480px; margin: 0 auto 36px; line-height: 1.7; position: relative; }
.cta-actions { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; position: relative; }
.cta-note { margin-top: 16px; font-size: 0.8125rem; color: var(--text-3); position: relative; }

.footer { background: var(--bg-secondary); border-top: 1px solid var(--border); padding: 64px 0 32px; }
.footer-grid { display: grid; grid-template-columns: 1.5fr repeat(3, 1fr); gap: 48px; margin-bottom: 48px; }
.footer-brand p { color: var(--text-2); font-size: 0.9rem; line-height: 1.7; margin-top: 12px; max-width: 260px; }
.footer-col h4 { font-size: 0.875rem; font-weight: 700; color: var(--text-1); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em; }
.footer-col ul { display: flex; flex-direction: column; gap: 10px; }
.footer-col ul a { color: var(--text-2); font-size: 0.9rem; transition: var(--transition); }
.footer-col ul a:hover { color: var(--primary-light); }
.footer-bottom { border-top: 1px solid var(--border); padding-top: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
.footer-bottom p { color: var(--text-3); font-size: 0.875rem; }
.footer-social { display: flex; gap: 12px; }
.footer-social a { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-2); font-size: 0.9rem; transition: var(--transition); }
.footer-social a:hover { background: var(--primary-glow); border-color: var(--primary); color: var(--primary-light); }

.mobile-menu { position: absolute; top: 68px; inset-inline: 0; background: rgba(5,5,9,0.97); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); padding: 12px 16px 20px; transform: translateY(-8px); opacity: 0; pointer-events: none; transition: opacity 0.22s ease, transform 0.22s ease; z-index: 999; }
.mobile-menu.open { transform: translateY(0); opacity: 1; pointer-events: all; }
.mobile-menu-inner { display: flex; flex-direction: column; gap: 4px; }
.mobile-nav-link { display: block; padding: 12px 16px; border-radius: 10px; font-size: 1rem; font-weight: 600; color: var(--text-2); transition: var(--transition); }
.mobile-nav-link:hover { background: rgba(255,255,255,0.06); color: var(--text-1); }
.mobile-menu-divider { height: 1px; background: var(--border); margin: 8px 0; }
.mobile-overlay { display: none; position: fixed; inset: 0; z-index: 998; background: rgba(0,0,0,0.4); }
.mobile-overlay.open { display: block; }
.nav-mobile-toggle span { transition: transform 0.2s ease, opacity 0.2s ease; }
.nav-mobile-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nav-mobile-toggle.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.nav-mobile-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes pulse-glow { 0%,100% { box-shadow: 0 0 0 0 var(--primary-glow); } 50% { box-shadow: 0 0 0 12px transparent; } }
@keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
.animate-fadeInUp { animation: fadeInUp 0.6s ease both; }

@media (max-width: 1024px) {
  .features-grid { grid-template-columns: repeat(2, 1fr); }
  .feature-card-big { grid-column: span 1; }
  .how-steps { grid-template-columns: repeat(2, 1fr); }
  .how-steps::before { display: none; }
  .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .stat-item { border-bottom: 1px solid var(--border); }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .section { padding: 64px 0; }
  .navbar-inner .nav-links, .navbar-inner .nav-cta .btn:not(.btn-primary) { display: none; }
  .nav-mobile-toggle { display: flex; }
  .features-grid { grid-template-columns: 1fr; }
  .how-steps { grid-template-columns: 1fr; }
  .testimonials-grid { grid-template-columns: 1fr; }
  .stats-grid { grid-template-columns: 1fr 1fr; }
  .mockup-body { grid-template-columns: 1fr; }
  .mockup-sidebar { display: none; }
  .mockup-stat-row { grid-template-columns: repeat(2, 1fr); }
  .hero-content { padding: 48px 0; }
  .cta-box { padding: 48px 24px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  #pricing-grid { grid-template-columns: 1fr !important; max-width: 400px !important; }
  .pe .pc.feat { transform: none; }
  .pe .faq-grid { grid-template-columns: 1fr; }
  .pe .pricing-wrap { padding: 0 20px 60px; }
  .pe .compare-wrap { padding: 56px 20px; }
  .pe .faq-wrap { padding: 56px 20px; }
  .pe .cta-wrap { padding: 20px 20px 60px; }
  .hero-title { font-size: clamp(2rem, 8vw, 3rem) !important; }
  .container { padding: 0 16px; }
  .section-title { font-size: clamp(1.5rem, 6vw, 2rem); }
  .logos-strip > div { gap: 24px; flex-wrap: wrap; justify-content: center; }
}
  /* ── Pricing Embed CSS ── */
  .pe { --bg2:#161b24;--bg3:#1c2233;--border:rgba(255,255,255,0.07);--border2:rgba(255,255,255,0.14);--t1:#f0f4ff;--t2:#94a3b8;--t3:#5a6480;--primary:#6366f1;--pglow:rgba(99,102,241,0.28);--green:#10b981;--gbg:rgba(16,185,129,0.12);--purple:#8b5cf6;--r:12px;--r2:20px;--tr:all 0.2s ease; }
  .pe .tag{display:inline-flex;align-items:center;gap:6px;background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.25);border-radius:99px;padding:5px 14px;font-size:0.78rem;font-weight:700;color:#a5b4fc;margin-bottom:20px;}
  .pe .grad{background:linear-gradient(135deg,#a5b4fc,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
  .pe .billing-pill{display:inline-flex;background:var(--bg2);border:1px solid var(--border);border-radius:99px;padding:5px;gap:3px;}
  .pe .bp-btn{padding:8px 22px;border-radius:99px;font-size:0.8375rem;font-weight:700;font-family:inherit;cursor:pointer;border:none;color:var(--t2);background:transparent;transition:var(--tr);position:relative;}
  .pe .bp-btn.active{background:var(--primary);color:#fff;box-shadow:0 3px 12px var(--pglow);}
  .pe .save-pill{position:absolute;top:-18px;left:50%;transform:translateX(-50%);background:var(--green);color:#fff;font-size:0.6rem;font-weight:800;padding:2px 8px;border-radius:99px;white-space:nowrap;pointer-events:none;}
  .pe .pricing-wrap{padding:0 40px 80px;}
  .pe .pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;max-width:1060px;margin:0 auto;align-items:start;}
  .pe .pc{background:var(--bg2);border:1px solid var(--border);border-radius:var(--r2);padding:32px 28px;position:relative;transition:var(--tr);}
  .pe .pc:hover{border-color:var(--border2);transform:translateY(-4px);box-shadow:0 16px 48px rgba(0,0,0,0.4);}
  .pe .pc.feat{background:#12183a;border:2px solid var(--primary);box-shadow:0 0 0 4px rgba(99,102,241,0.09),0 20px 60px rgba(99,102,241,0.22);transform:translateY(-8px);z-index:2;}
  .pe .pc.feat:hover{transform:translateY(-14px);}
  .pe .pop-badge{position:absolute;top:-15px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--primary),var(--purple));color:#fff;font-size:0.73rem;font-weight:800;padding:5px 20px;border-radius:99px;white-space:nowrap;box-shadow:0 4px 14px var(--pglow);}
  .pe .pc-eyebrow{font-size:0.68rem;font-weight:800;text-transform:uppercase;letter-spacing:0.12em;color:var(--t3);margin-bottom:10px;}
  .pe .pc.feat .pc-eyebrow{color:#a5b4fc;}
  .pe .pc-name{font-size:1.25rem;font-weight:900;color:var(--t1);margin-bottom:14px;}
  .pe .pc-price{display:flex;align-items:flex-end;gap:5px;margin-bottom:8px;}
  .pe .pc-currency{font-size:1.1rem;font-weight:700;color:var(--t2);padding-bottom:8px;}
  .pe .pc-num{font-size:3.4rem;font-weight:900;color:var(--t1);line-height:1;transition:all 0.3s ease;}
  .pe .pc.feat .pc-num{background:linear-gradient(135deg,#fff,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
  .pe .pc-period{font-size:0.8rem;color:var(--t3);padding-bottom:8px;}
  .pe .pc-desc{font-size:0.8375rem;color:var(--t2);line-height:1.65;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--border);min-height:56px;}
  .pe .pc.feat .pc-desc{border-bottom-color:rgba(99,102,241,0.2);}
  .pe .pc-cta{width:100%;justify-content:center;margin-bottom:24px;display:inline-flex;align-items:center;gap:6px;padding:13px 26px;border-radius:14px;font-size:0.9375rem;font-weight:700;font-family:inherit;cursor:pointer;border:none;transition:var(--tr);white-space:nowrap;}
  .pe .pc-cta-current{width:100%;padding:12px;border-radius:12px;font-size:0.875rem;font-weight:700;cursor:default;border:1px solid rgba(99,102,241,0.25);background:rgba(99,102,241,0.08);color:#a5b4fc;margin-bottom:24px;text-align:center;}
  .pe .pc-section-label{font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:var(--t3);margin-bottom:10px;}
  .pe .feat-list{display:flex;flex-direction:column;gap:11px;}
  .pe .feat-row{display:flex;align-items:flex-start;gap:10px;font-size:0.8375rem;}
  .pe .feat-icon{width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;font-size:0.6rem;font-weight:900;}
  .pe .fi-yes{background:var(--gbg);color:var(--green);}
  .pe .fi-feat{background:rgba(99,102,241,0.2);color:#a5b4fc;}
  .pe .fi-no{background:rgba(255,255,255,0.04);color:var(--t3);}
  .pe .feat-text{color:var(--t2);line-height:1.4;}
  .pe .feat-text.dim{color:var(--t3);text-decoration:line-through;}
  .pe .trust-bar{display:flex;justify-content:center;gap:28px;flex-wrap:wrap;margin:32px auto 0;max-width:700px;font-size:0.8125rem;color:var(--t3);font-weight:600;}
  .pe .trust-bar span{display:flex;align-items:center;gap:6px;}
  .pe .compare-wrap{background:var(--bg2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:72px 40px;}
  .pe .section-center{text-align:center;margin-bottom:40px;}
  .pe .section-center h2{font-size:1.75rem;font-weight:900;color:var(--t1);margin-top:10px;}
  .pe .compare-table-wrap{max-width:860px;margin:0 auto;overflow-x:auto;}
  .pe .cmp{width:100%;border-collapse:collapse;min-width:540px;}
  .pe .cmp thead th{padding:14px 18px;font-size:0.8375rem;font-weight:800;color:var(--t1);border-bottom:1px solid var(--border);background:rgba(255,255,255,0.02);}
  .pe .cmp thead th:first-child{text-align:right;font-weight:700;color:var(--t2);}
  .pe .cmp thead .th-feat{background:rgba(99,102,241,0.06);color:#a5b4fc;border-bottom-color:rgba(99,102,241,0.25);}
  .pe .cmp .sec-row td{padding:10px 18px 6px;font-size:0.67rem;font-weight:800;text-transform:uppercase;letter-spacing:0.09em;color:var(--t3);border-top:1px solid var(--border);background:rgba(255,255,255,0.01);}
  .pe .cmp tbody td{padding:13px 18px;font-size:0.8375rem;color:var(--t2);border-bottom:1px solid rgba(255,255,255,0.04);text-align:center;}
  .pe .cmp tbody td:first-child{text-align:right;}
  .pe .cmp tbody tr:last-child td{border-bottom:none;}
  .pe .cmp tbody tr:hover td{background:rgba(255,255,255,0.02);}
  .pe .td-feat{background:rgba(99,102,241,0.04);}
  .pe .cmp .yes{color:var(--green);font-size:1rem;font-weight:900;}
  .pe .cmp .no{color:var(--t3);font-size:1.1rem;}
  .pe .faq-wrap{padding:72px 40px;max-width:860px;margin:0 auto;}
  .pe .faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:36px;}
  .pe .faq-item{background:var(--bg2);border:1px solid var(--border);border-radius:var(--r);padding:20px 22px;cursor:pointer;transition:var(--tr);}
  .pe .faq-item:hover{border-color:var(--border2);}
  .pe .faq-item.open{border-color:rgba(99,102,241,0.35);}
  .pe .faq-q{display:flex;justify-content:space-between;align-items:center;gap:14px;font-size:0.8875rem;font-weight:700;color:var(--t1);}
  .pe .faq-icon{width:22px;height:22px;border-radius:6px;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;font-size:0.8rem;flex-shrink:0;transition:var(--tr);}
  .pe .faq-item.open .faq-icon{transform:rotate(45deg);background:rgba(99,102,241,0.2);color:#a5b4fc;}
  .pe .faq-a{font-size:0.825rem;color:var(--t2);line-height:1.7;margin-top:12px;display:none;}
  .pe .faq-item.open .faq-a{display:block;}
  .pe .cta-wrap{padding:40px 40px 80px;}
  .pe .pe-cta-box{max-width:860px;margin:0 auto;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(139,92,246,0.07));border:1px solid rgba(99,102,241,0.22);border-radius:24px;padding:64px 48px;text-align:center;position:relative;overflow:hidden;}
  .pe .pe-cta-box h2{font-size:1.75rem;font-weight:900;color:var(--t1);margin-bottom:12px;}
  .pe .pe-cta-box p{font-size:0.9375rem;color:var(--t2);margin-bottom:28px;line-height:1.7;}
  .pe .pe-btn-primary{display:inline-flex;align-items:center;gap:6px;padding:13px 26px;border-radius:14px;font-size:0.9375rem;font-weight:700;font-family:inherit;cursor:pointer;border:none;background:var(--primary);color:#fff;box-shadow:0 4px 16px var(--pglow);transition:var(--tr);}
  .pe .pe-btn-primary:hover{background:#5254d4;transform:translateY(-1px);}
  @media(max-width:1024px){.pe .pricing-grid{grid-template-columns:1fr;max-width:440px;margin-inline:auto;}.pe .pc.feat{transform:none;}.pe .faq-grid{grid-template-columns:1fr;}}
  </style>
</head>
<body>

  <nav class="navbar" id="navbar">
    <div class="navbar-inner">
      <a href="{{ route('home') }}" class="logo">
        <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">W</div>
        Wayzon
      </a>
      <div class="nav-links">
        <a href="#features">المميزات</a>
        <a href="#how">كيف يعمل</a>
        <a href="#pricing">الأسعار</a>
        <a href="#testimonials">آراء العملاء</a>
      </div>
      <div class="nav-cta">
        <a href="{{ route('login') }}" class="btn btn-ghost">تسجيل الدخول</a>
        <a href="{{ route('register') }}" class="btn btn-primary">ابدأ مجاناً ←</a>
      </div>
      <button class="nav-mobile-toggle" id="mobileToggle" aria-label="القائمة">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <div class="mobile-menu-inner">
        <a href="#features"     class="mobile-nav-link" onclick="closeMobileMenu()">المميزات</a>
        <a href="#how"          class="mobile-nav-link" onclick="closeMobileMenu()">كيف يعمل</a>
        <a href="#pricing"      class="mobile-nav-link" onclick="closeMobileMenu()">الأسعار</a>
        <a href="#testimonials" class="mobile-nav-link" onclick="closeMobileMenu()">آراء العملاء</a>
        <div class="mobile-menu-divider"></div>
        <a href="{{ route('login') }}"    class="mobile-nav-link" onclick="closeMobileMenu()">تسجيل الدخول</a>
        <a href="{{ route('register') }}" class="btn btn-primary w-full" style="justify-content:center;margin-top:4px;" onclick="closeMobileMenu()">ابدأ مجاناً ←</a>
      </div>
    </div>
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid-lines"></div>
    <div class="container">
      <div class="hero-content animate-fadeInUp">
        <div class="hero-eyebrow">
          <span class="dot"></span>
          الآن متوفر على سلة Apps
          <span style="font-size:0.75rem;opacity:0.7;">←</span>
        </div>
        <h1 class="hero-title">
          أتمتة متجرك على سلة<br>
          <span class="line2">بذكاء وسرعة</span>
        </h1>
        <p class="hero-subtitle">
          Wayzon منصة SaaS متخصصة لأصحاب متاجر سلة — أدِر طلباتك، تواصل مع عملاءك عبر واتساب،
          وحلّل مبيعاتك كلها من مكان واحد.
        </p>
        <div class="hero-actions">
          <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            ابدأ تجربتك المجانية
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">تسجيل الدخول</a>
        </div>
        <div class="hero-social-proof">
          <div class="hero-avatars">
            <span>أ</span><span>م</span><span>ف</span><span>س</span><span>خ</span>
          </div>
          <span>+500 متجر نشط</span>
          <span>•</span>
          <span class="stars">★★★★★</span>
          <span>4.9/5 تقييم</span>
        </div>
      </div>

      <div class="hero-mockup" style="margin-top:0;">
        <div class="mockup-browser">
          <div class="mockup-bar">
            <div class="mockup-dot red"></div>
            <div class="mockup-dot yellow"></div>
            <div class="mockup-dot green"></div>
            <div class="mockup-url">app.wayzon.sa/dashboard</div>
          </div>
          <div class="mockup-body">
            <div class="mockup-sidebar">
              <div class="mockup-nav-item active"><div class="icon"></div> لوحة التحكم</div>
              <div class="mockup-nav-item"><div class="icon"></div> الطلبات</div>
              <div class="mockup-nav-item"><div class="icon"></div> العملاء</div>
              <div class="mockup-nav-item"><div class="icon"></div> التقارير</div>
              <div class="mockup-nav-item"><div class="icon"></div> واتساب</div>
              <div class="mockup-nav-item"><div class="icon"></div> الإعدادات</div>
            </div>
            <div class="mockup-content">
              <div class="mockup-stat-row">
                <div class="mockup-stat"><div class="mockup-stat-label"></div><div class="mockup-stat-value"></div></div>
                <div class="mockup-stat"><div class="mockup-stat-label"></div><div class="mockup-stat-value" style="background:rgba(16,185,129,0.3)"></div></div>
                <div class="mockup-stat"><div class="mockup-stat-label"></div><div class="mockup-stat-value" style="background:rgba(6,182,212,0.3)"></div></div>
              </div>
              <div class="mockup-chart">
                <div class="mockup-bar-item" style="height:40%"></div>
                <div class="mockup-bar-item" style="height:65%"></div>
                <div class="mockup-bar-item" style="height:50%"></div>
                <div class="mockup-bar-item" style="height:80%"></div>
                <div class="mockup-bar-item" style="height:60%"></div>
                <div class="mockup-bar-item" style="height:90%"></div>
                <div class="mockup-bar-item" style="height:70%"></div>
                <div class="mockup-bar-item" style="height:85%"></div>
              </div>
              <div class="mockup-row">
                <div class="mockup-mini-card"></div>
                <div class="mockup-mini-card"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="mockup-glow"></div>
      </div>
    </div>
  </section>

  <!-- LOGOS -->
  <div class="logos-strip">
    <div class="container">
      <p class="logos-label">يثق بنا أصحاب المتاجر في المملكة والخليج</p>
      <div class="logos-row">
        <div class="logo-pill"><span>🛍️</span> متجر الخليج</div>
        <div class="logo-pill"><span>👗</span> فاشون ستور</div>
        <div class="logo-pill"><span>💻</span> تقنية شوب</div>
        <div class="logo-pill"><span>🌿</span> طبيعتي ستور</div>
        <div class="logo-pill"><span>🎮</span> جيمرز مول</div>
        <div class="logo-pill"><span>📱</span> موبايل بلس</div>
      </div>
    </div>
  </div>

  <!-- FEATURES -->
  <section class="section" id="features">
    <div class="container">
      <div class="text-center" style="margin-bottom:56px;">
        <div class="section-tag">✦ المميزات</div>
        <h2 class="section-title">كل ما تحتاجه لمتجرك<br><span class="gradient-text">في مكان واحد</span></h2>
        <p class="section-subtitle">من إدارة الطلبات إلى التسويق الآلي، Wayzon يغطي كل جانب من جوانب متجرك الإلكتروني.</p>
      </div>
      <div class="features-grid">
        <div class="feature-card feature-card-big card-glow">
          <div class="feature-icon fi-indigo">🤖</div>
          <h3>بوت واتساب ذكي</h3>
          <p>تواصل تلقائي مع عملاءك عبر واتساب — تأكيد الطلبات، تتبع الشحن، والرد على الأسئلة الشائعة كلها بشكل آلي دون أي تدخل منك. وفّر وقتك وحسّن تجربة العملاء في نفس الوقت.</p>
          <div style="margin-top:20px;display:flex;gap:8px;flex-wrap:wrap;">
            <span class="badge badge-success">تلقائي 100%</span>
            <span class="badge badge-primary">ذكاء اصطناعي</span>
          </div>
        </div>
        <div class="feature-card card-glow">
          <div class="feature-icon fi-purple">📊</div>
          <h3>تقارير وتحليلات متقدمة</h3>
          <p>تتبع مبيعاتك ونموك بتقارير بصرية مفصّلة. اعرف أفضل منتجاتك وأوقات ذروة المبيعات.</p>
        </div>
        <div class="feature-card card-glow">
          <div class="feature-icon fi-cyan">⚡</div>
          <h3>أتمتة الطلبات</h3>
          <p>معالجة تلقائية للطلبات من اللحظة التي يؤكدها العميل حتى وصولها لباب منزله.</p>
        </div>
        <div class="feature-card card-glow">
          <div class="feature-icon fi-green">💬</div>
          <h3>إدارة العملاء CRM</h3>
          <p>قاعدة بيانات متكاملة لعملاءك مع تاريخ المشتريات والتواصل لبناء علاقات أقوى.</p>
        </div>
        <div class="feature-card card-glow">
          <div class="feature-icon fi-orange">🎯</div>
          <h3>حملات تسويقية</h3>
          <p>أرسل حملات واتساب مخصصة لشرائح محددة من عملاءك لزيادة المبيعات.</p>
        </div>
        <div class="feature-card card-glow">
          <div class="feature-icon fi-pink">🔗</div>
          <h3>تكامل سلة API</h3>
          <p>ربط فوري وتلقائي مع متجرك على سلة. لا حاجة لأي إعدادات معقدة.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <div class="stats-section section-sm">
    <div class="container">
      <div class="stats-grid">
        <div class="stat-item"><div class="stat-num"><span>+</span>500</div><div class="stat-label">متجر نشط</div></div>
        <div class="stat-item"><div class="stat-num"><span>+</span>50K</div><div class="stat-label">طلب معالَج شهرياً</div></div>
        <div class="stat-item"><div class="stat-num">98<span>%</span></div><div class="stat-label">نسبة رضا العملاء</div></div>
        <div class="stat-item"><div class="stat-num"><span>×</span>3</div><div class="stat-label">متوسط نمو المبيعات</div></div>
      </div>
    </div>
  </div>

  <!-- HOW IT WORKS -->
  <section class="section" id="how">
    <div class="container">
      <div class="text-center">
        <div class="section-tag">⚙️ كيف يعمل</div>
        <h2 class="section-title">ابدأ خلال <span class="gradient-text">5 دقائق فقط</span></h2>
        <p class="section-subtitle">عملية بسيطة من 4 خطوات وأنت جاهز للعمل</p>
      </div>
      <div class="how-steps">
        <div class="how-step"><div class="how-step-num">🔌<span class="step-badge">1</span></div><h3>ربط المتجر</h3><p>أدخل بيانات متجرك على سلة وسيتم الربط التلقائي في ثوانٍ</p></div>
        <div class="how-step"><div class="how-step-num">⚙️<span class="step-badge">2</span></div><h3>ضبط الإعدادات</h3><p>اختر الخدمات التي تريدها وخصّص رسائل واتساب حسب علامتك التجارية</p></div>
        <div class="how-step"><div class="how-step-num">🚀<span class="step-badge">3</span></div><h3>التشغيل الفوري</h3><p>شغّل الأتمتة بنقرة واحدة وابدأ بتلقي الطلبات فوراً</p></div>
        <div class="how-step"><div class="how-step-num">📈<span class="step-badge">4</span></div><h3>تتبع النمو</h3><p>راقب مبيعاتك وتفاعل العملاء من لوحة تحكم شاملة</p></div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="section" id="testimonials" style="padding-top:0;">
    <div class="container">
      <div class="text-center">
        <div class="section-tag">⭐ آراء العملاء</div>
        <h2 class="section-title">ماذا يقول <span class="gradient-text">أصحاب المتاجر</span></h2>
        <p class="section-subtitle">تجارب حقيقية من متاجر نجحت مع Wayzon</p>
      </div>
      <div class="testimonials-grid">
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Wayzon غيّر طريقة إدارتي للمتجر كلياً. الأتمتة وفّرت عليّ ساعات يومياً، والعملاء مبسوطين من سرعة الردود."</p>
          <div class="testimonial-author"><div class="author-avatar">أ</div><div><div class="author-name">أحمد الشمري</div><div class="author-title">صاحب متجر إلكتروني — الرياض</div></div></div>
        </div>
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"التقارير التفصيلية ساعدتني أفهم عملاءي أكثر وأركز على المنتجات الأعلى مبيعاً. مبيعاتي زادت 40% خلال شهرين."</p>
          <div class="testimonial-author"><div class="author-avatar" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div><div><div class="author-name">سارة القحطاني</div><div class="author-title">متجر عبايات — جدة</div></div></div>
        </div>
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"بوت الواتساب أفضل شيء! العملاء يسألون وهم يردون تلقائياً. الدعم الفني سريع ومتجاوب."</p>
          <div class="testimonial-author"><div class="author-avatar" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">خ</div><div><div class="author-name">خالد العتيبي</div><div class="author-title">متجر إلكترونيات — الدمام</div></div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRICING -->
  <section class="section" id="pricing" style="padding-top:0;">
    <div class="pe">

      <!-- Hero / billing toggle -->
      <div style="text-align:center;padding:0 40px 48px;">
        <div class="section-tag" style="margin-bottom:16px;">💎 الأسعار</div>
        <h2 class="section-title">اختر الباقة <span class="gradient-text">المناسبة لمتجرك</span></h2>
        <p class="section-subtitle" style="margin-bottom:28px;">ابدأ بالباقة الأساسية وطوّر متجرك. لا عقود مُلزمة، يمكنك الترقية أو الإلغاء في أي وقت.</p>
        <div class="pe billing-pill">
          <button class="pe bp-btn active" id="btnMonthly" onclick="setBilling('monthly')">شهري</button>
          <button class="pe bp-btn" id="btnYearly" onclick="setBilling('yearly')" style="position:relative;">
            سنوي
            <span class="pe save-pill">وفّر 20%</span>
          </button>
        </div>
      </div>

      <!-- Pricing cards -->
      <div class="pe pricing-wrap">
        <div class="pe pricing-grid">

          <!-- BASIC -->
          <div class="pe pc">
            <div class="pe pc-eyebrow">الباقة الأساسية</div>
            <div class="pe pc-name">🚀 الأساسية</div>
            <div class="pe pc-price">
              <span class="pe pc-currency">ر.س</span>
              <span class="pe pc-num" id="pn-basic">55</span>
              <span class="pe pc-period" id="pp-basic">/ شهر</span>
            </div>
            <p class="pe pc-desc">مثالية للمتاجر الناشئة التي تبدأ رحلتها مع الأتمتة</p>
            <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="pe btn btn-secondary pc-cta" style="width:100%;justify-content:center;padding:12px;margin-bottom:24px;display:flex;">ابدأ الآن</a>
            <div class="pe pc-section-label">ما يشمله</div>
            <ul class="pe feat-list">
              <li class="pe feat-row"><span class="pe feat-icon fi-yes">✓</span><span class="pe feat-text">ربط مع سلة (الطلبات + الحالات)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-yes">✓</span><span class="pe feat-text">إرسال رسائل تلقائية للعملاء</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-yes">✓</span><span class="pe feat-text">تخصيص نصوص الرسائل</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-yes">✓</span><span class="pe feat-text">جدولة الرسائل (مثلاً بعد التسليم)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-yes">✓</span><span class="pe feat-text">لوحة تحكم بسيطة لإدارة الرسائل</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">ردود ذكية بالذكاء الاصطناعي</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">تدريب بيانات المتجر</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">سيناريوهات الرد (Flows)</span></li>
            </ul>
          </div>

          <!-- SMART (featured) -->
          <div class="pe pc feat">
            <span class="pe pop-badge">⭐ الأكثر طلباً</span>
            <div class="pe pc-eyebrow">الباقة الذكية</div>
            <div class="pe pc-name">🧠 الذكية</div>
            <div class="pe pc-price">
              <span class="pe pc-currency" style="color:#c4b5fd;">ر.س</span>
              <span class="pe pc-num" id="pn-smart">99</span>
              <span class="pe pc-period" id="pp-smart" style="color:#8b7fc7;">/ شهر</span>
            </div>
            <p class="pe pc-desc" style="color:#c4b5fd;">للمتاجر التي تريد ردوداً ذكية وتجربة عملاء استثنائية</p>
            <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="pe btn btn-primary pc-cta" style="width:100%;justify-content:center;padding:12px;margin-bottom:24px;display:flex;background:linear-gradient(135deg,var(--primary),var(--secondary));box-shadow:0 6px 24px var(--primary-glow);">اشترك الآن ←</a>
            <div class="pe pc-section-label" style="color:#8b7fc7;">كل شيء في الأساسية +</div>
            <ul class="pe feat-list">
              <li class="pe feat-row"><span class="pe feat-icon fi-feat">✦</span><span class="pe feat-text" style="color:#c4b5fd;">ردود ذكية باستخدام OpenAI</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-feat">✦</span><span class="pe feat-text" style="color:#c4b5fd;">الرد التلقائي على استفسارات العملاء</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-feat">✦</span><span class="pe feat-text" style="color:#c4b5fd;">تخصيص أسلوب الرد (رسمي / ودي / مختصر)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-feat">✦</span><span class="pe feat-text" style="color:#c4b5fd;">تدريب الردود (إضافة معلومات المتجر)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-feat">✦</span><span class="pe feat-text" style="color:#c4b5fd;">تحسين الردود حسب الرسائل</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">سيناريوهات الرد (Flows)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">تحليل متقدم للرسائل</span></li>
              <li class="pe feat-row"><span class="pe feat-icon fi-no">—</span><span class="pe feat-text dim">أولوية في الأداء</span></li>
            </ul>
          </div>

          <!-- PRO -->
          <div class="pe pc" style="border-color:rgba(168,85,247,0.3);background:linear-gradient(160deg,#181e30,#1c2233);overflow:hidden;">
            <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,#6366f1,#8b5cf6,#ec4899);"></div>
            <div class="pe pc-eyebrow">الباقة الاحترافية</div>
            <div class="pe pc-name">🏆 الاحترافية</div>
            <div class="pe pc-price">
              <span class="pe pc-currency" style="color:#d8b4fe;">ر.س</span>
              <span class="pe pc-num" id="pn-pro" style="background:linear-gradient(135deg,#d8b4fe,#f0abfc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">139</span>
              <span class="pe pc-period" id="pp-pro">/ شهر</span>
            </div>
            <p class="pe pc-desc">للمتاجر الجادة التي تريد التحكم الكامل والأداء المتميز</p>
            <a href="https://apps.salla.sa/ar/app/1819242470" target="_blank" class="pe btn pc-cta" style="width:100%;justify-content:center;padding:12px;margin-bottom:24px;display:flex;background:linear-gradient(135deg,#7c3aed,#a855f7);color:#fff;box-shadow:0 4px 20px rgba(139,92,246,0.35);">اشترك الآن ←</a>
            <div class="pe pc-section-label" style="color:#d8b4fe;">كل شيء في الذكية +</div>
            <ul class="pe feat-list">
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">تحكم كامل في سيناريوهات الرد (Flows)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">تخصيص ردود حسب حالة الطلب</span></li>
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">تحليل بسيط للرسائل (عدد / تفاعل)</span></li>
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">دعم إعدادات متقدمة للذكاء الاصطناعي</span></li>
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">أولوية في الأداء والردود</span></li>
              <li class="pe feat-row"><span class="pe feat-icon" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span><span class="pe feat-text">تحديثات مستقبلية وميزات جديدة</span></li>
            </ul>
          </div>

        </div>

        <!-- Trust bar -->
        <div class="pe trust-bar">
          <span>🔒 دفع آمن ومشفّر</span>
          <span>📅 إلغاء في أي وقت</span>
          <span>💳 بدون رسوم خفية</span>
          <span>🎁 7 أيام تجربة مجانية</span>
        </div>
      </div>

      <!-- Compare table -->
      <div class="pe compare-wrap">
        <div class="pe section-center">
          <div class="section-tag">⚖️ مقارنة</div>
          <h2 style="font-size:1.75rem;font-weight:900;margin-top:10px;letter-spacing:-0.02em;">مقارنة تفصيلية بين الباقات</h2>
        </div>
        <div class="pe compare-table-wrap">
          <table class="pe cmp">
            <thead>
              <tr>
                <th style="text-align:right;color:var(--text-2);font-weight:600;width:42%;">الميزة</th>
                <th>🚀 الأساسية<br><span style="font-size:0.68rem;font-weight:400;color:var(--text-3);">55 ر.س/شهر</span></th>
                <th class="pe th-feat">🧠 الذكية<br><span style="font-size:0.68rem;font-weight:400;color:#8b7fc7;">99 ر.س/شهر</span></th>
                <th>🏆 الاحترافية<br><span style="font-size:0.68rem;font-weight:400;color:var(--text-3);">139 ر.س/شهر</span></th>
              </tr>
            </thead>
            <tbody>
              <tr class="pe sec-row"><td colspan="4">الأساسيات</td></tr>
              <tr><td>ربط مع سلة</td><td><span class="pe yes">✓</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>رسائل تلقائية للعملاء</td><td><span class="pe yes">✓</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>تخصيص نصوص الرسائل</td><td><span class="pe yes">✓</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>جدولة الرسائل</td><td><span class="pe yes">✓</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>لوحة تحكم الرسائل</td><td><span class="pe yes">✓</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr class="pe sec-row"><td colspan="4">الذكاء الاصطناعي</td></tr>
              <tr><td>ردود ذكية (OpenAI)</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>الرد التلقائي على الاستفسارات</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>تخصيص أسلوب الرد</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>تدريب بيانات المتجر</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe yes">✓</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr class="pe sec-row"><td colspan="4">الميزات المتقدمة</td></tr>
              <tr><td>سيناريوهات الرد (Flows)</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe no">—</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>تحليل الرسائل والتفاعل</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe no">—</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>أولوية في الأداء والردود</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe no">—</span></td><td><span class="pe yes">✓</span></td></tr>
              <tr><td>تحديثات مستقبلية</td><td><span class="pe no">—</span></td><td class="pe td-feat"><span class="pe no">—</span></td><td><span class="pe yes">✓</span></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- FAQ -->
      <div class="pe faq-wrap">
        <div class="pe section-center">
          <div class="section-tag">❓ أسئلة شائعة</div>
          <h2 style="font-size:1.75rem;font-weight:900;margin-top:10px;letter-spacing:-0.02em;">الأسئلة الأكثر <span class="gradient-text">تكراراً</span></h2>
        </div>
        <div class="pe faq-grid">
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">هل يمكنني تغيير الباقة لاحقاً؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">نعم، يمكنك الترقية أو التخفيض في أي وقت. عند الترقية في منتصف الشهر ستحصل على الفرق بالتناسب. الإلغاء يصبح فعالاً في نهاية الدورة الحالية.</div>
          </div>
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">هل التجربة تحتاج بطاقة ائتمان؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">لا! يمكنك البدء بالتجربة المجانية 7 أيام دون إدخال أي بيانات دفع. فقط أنشئ حسابك وابدأ فوراً.</div>
          </div>
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">كيف يعمل الربط مع سلة؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">الربط تلقائي ويستغرق أقل من دقيقتين. تدخل بيانات متجرك على سلة وسيتصل Wayzon بمتجرك ويستورد كل الطلبات والمنتجات تلقائياً.</div>
          </div>
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">هل بياناتي وبيانات عملاءي آمنة؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">بالتأكيد. نستخدم تشفير SSL/TLS لجميع الاتصالات وخوادمنا في مراكز بيانات معتمدة. لا نشارك بياناتك مع أي طرف ثالث.</div>
          </div>
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">ما هي طرق الدفع المتاحة؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">نقبل بطاقات Visa وMastercard والدفع عبر مدى، وكذلك Apple Pay وSTC Pay.</div>
          </div>
          <div class="pe faq-item" onclick="toggleFaq(this)">
            <div class="pe faq-q">هل الذكاء الاصطناعي يتعلم من متجري؟<span class="pe faq-icon">+</span></div>
            <div class="pe faq-a">في الباقة الذكية والاحترافية، تستطيع تدريب البوت بمعلومات متجرك (أوقات العمل، سياسة الشحن، المنتجات) ليرد بشكل دقيق ومخصص.</div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-box">
        <div class="section-tag" style="margin-bottom:20px;">🎉 ابدأ الآن</div>
        <h2>جاهز تطوّر متجرك؟</h2>
        <p>انضم لأكثر من 500 متجر ناجح يستخدم Wayzon يومياً. تجربة مجانية 3 أيام بدون بطاقة ائتمان.</p>
        <div class="cta-actions">
          <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            ابدأ مجاناً الآن
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">تسجيل الدخول</a>
        </div>
        <p class="cta-note">✓ 3 أيام مجاناً &nbsp;•&nbsp; ✓ بدون بطاقة ائتمان &nbsp;•&nbsp; ✓ إلغاء في أي وقت</p>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="logo">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;">W</div>
            Wayzon
          </div>
          <p>منصة SaaS متخصصة لأصحاب متاجر سلة. أتمتة، تحليلات، وتواصل ذكي مع العملاء.</p>
          <div class="footer-social" style="margin-top:20px;">
            <a href="#" title="تويتر">𝕏</a>
            <a href="#" title="واتساب">W</a>
            <a href="#" title="انستقرام">ig</a>
            <a href="#" title="لينكدإن">in</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>المنتج</h4>
          <ul>
            <li><a href="#features">المميزات</a></li>
            <li><a href="#pricing">الأسعار</a></li>
            <li><a href="{{ route('login') }}">لوحة التحكم</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>الشركة</h4>
          <ul>
            <li><a href="#">من نحن</a></li>
            <li><a href="#">المدونة</a></li>
            <li><a href="#">شراكات</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>الدعم</h4>
          <ul>
            <li><a href="mailto:support@wayzon.sa">تواصل معنا</a></li>
            <li><a href="{{ route('privacy') }}">سياسة الخصوصية</a></li>
            <li><a href="{{ route('terms') }}">الشروط والأحكام</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© {{ date('Y') }} Wayzon. جميع الحقوق محفوظة.</p>
        <p>صناعة سعودية ❤️</p>
      </div>
    </div>
  </footer>

  <script>
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 20); });

    const mobileToggle  = document.getElementById('mobileToggle');
    const mobileMenu    = document.getElementById('mobileMenu');
    const mobileOverlay = document.getElementById('mobileOverlay');
    function openMobileMenu()  { mobileToggle.classList.add('open'); mobileMenu.classList.add('open'); mobileOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeMobileMenu() { mobileToggle.classList.remove('open'); mobileMenu.classList.remove('open'); mobileOverlay.classList.remove('open'); document.body.style.overflow = ''; }
    mobileToggle.addEventListener('click', () => mobileMenu.classList.contains('open') ? closeMobileMenu() : openMobileMenu());

    const counters = document.querySelectorAll('.stat-num');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const text = el.textContent;
          const num = parseInt(text.replace(/\D/g, ''));
          let current = 0;
          const step = num / (1500 / 16);
          const timer = setInterval(() => {
            current = Math.min(current + step, num);
            const d = Math.floor(current);
            el.textContent = (text.startsWith('+') ? '+' : (text.startsWith('×') ? '×' : '')) + d + (text.endsWith('%') ? '%' : '');
            if (current >= num) clearInterval(timer);
          }, 16);
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));

    // Billing toggle
    let _yearly = false;
    const _p = { basic: 55, smart: 99, pro: 139 };
    function setBilling(mode) {
      _yearly = mode === 'yearly';
      document.getElementById('btnMonthly').classList.toggle('active', !_yearly);
      document.getElementById('btnYearly').classList.toggle('active', _yearly);
      const disc = _yearly ? 0.8 : 1;
      const period = _yearly ? '/ سنة' : '/ شهر';
      ['basic', 'smart', 'pro'].forEach(k => {
        const el = document.getElementById('pn-' + k);
        const pel = document.getElementById('pp-' + k);
        if (!el) return;
        const target = _yearly ? Math.round(_p[k] * 12 * disc) : _p[k];
        animateNum(el, parseInt(el.textContent) || 0, target);
        if (pel) pel.textContent = period;
      });
    }
    function animateNum(el, from, to) {
      const dur = 380; let start = null;
      function step(ts) {
        if (!start) start = ts;
        const prog = Math.min((ts - start) / dur, 1);
        const ease = 1 - Math.pow(1 - prog, 3);
        el.textContent = Math.round(from + (to - from) * ease);
        if (prog < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    }

    // FAQ toggle
    function toggleFaq(el) {
      const wasOpen = el.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!wasOpen) el.classList.add('open');
    }
  </script>
</body>
</html>
