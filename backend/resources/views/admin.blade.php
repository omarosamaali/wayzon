<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>لوحة الأدمن — Wayzon</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0d1117; --bg2: #161b24; --bg3: #1c2233;
      --border: rgba(255,255,255,0.07); --border2: rgba(255,255,255,0.14);
      --primary: #6366f1; --pglow: rgba(99,102,241,0.25);
      --green: #10b981; --red: #ef4444; --yellow: #f59e0b;
      --t1: #f0f4ff; --t2: #94a3b8; --t3: #5a6480;
      --r: 10px;
    }
    body { font-family: 'Tajawal', sans-serif; background: var(--bg); color: var(--t1); min-height: 100vh; }
    a { text-decoration: none; color: inherit; }

    /* Topbar */
    .topbar { background: var(--bg2); border-bottom: 1px solid var(--border); padding: 0 32px; height: 60px; display: flex; align-items: center; justify-content: space-between; gap: 16px; position: sticky; top: 0; z-index: 100; }
    .brand { font-size: 1rem; font-weight: 900; display: flex; align-items: center; gap: 10px; }
    .brand-icon { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--primary), #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
    .admin-badge { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); color: #fbbf24; font-size: 0.7rem; font-weight: 800; padding: 3px 10px; border-radius: 99px; }
    .top-actions { display: flex; gap: 10px; align-items: center; }

    /* Container */
    .container { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }

    /* Stats row */
    .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 28px; }
    .stat-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--r); padding: 18px 20px; }
    .stat-val { font-size: 1.8rem; font-weight: 900; color: var(--t1); line-height: 1; }
    .stat-lbl { font-size: 0.78rem; color: var(--t2); margin-top: 6px; }

    /* Search */
    .search-bar { display: flex; gap: 10px; margin-bottom: 20px; }
    .search-input { flex: 1; background: var(--bg2); border: 1px solid var(--border); border-radius: var(--r); padding: 10px 16px; color: var(--t1); font-family: inherit; font-size: 0.9rem; outline: none; }
    .search-input:focus { border-color: var(--primary); }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--r); font-size: 0.85rem; font-weight: 700; font-family: inherit; cursor: pointer; border: none; transition: all 0.2s; white-space: nowrap; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #5254d4; }
    .btn-ghost { background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: var(--t2); }
    .btn-ghost:hover { background: rgba(255,255,255,0.09); color: var(--t1); }
    .btn-sm { padding: 6px 12px; font-size: 0.78rem; }
    .btn-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
    .btn-danger:hover { background: rgba(239,68,68,0.25); }
    .btn-green { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
    .btn-green:hover { background: rgba(16,185,129,0.25); }

    /* Table */
    .table-wrap { background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 12px 16px; font-size: 0.75rem; font-weight: 800; color: var(--t3); text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.02); text-align: right; }
    tbody td { padding: 14px 16px; font-size: 0.85rem; color: var(--t2); border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: rgba(255,255,255,0.02); }
    .td-main { color: var(--t1); font-weight: 600; }

    /* Plan badge */
    .plan-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 99px; font-size: 0.72rem; font-weight: 800; }
    .plan-basic  { background: rgba(99,102,241,0.12); color: #a5b4fc; }
    .plan-smart  { background: rgba(139,92,246,0.12); color: #c4b5fd; }
    .plan-pro    { background: rgba(168,85,247,0.12); color: #d8b4fe; }
    .plan-none   { background: rgba(100,116,139,0.12); color: #94a3b8; }

    /* Plan select form */
    .plan-form { display: flex; gap: 6px; align-items: center; }
    .plan-select { background: var(--bg3); border: 1px solid var(--border); border-radius: 8px; color: var(--t1); padding: 5px 10px; font-family: inherit; font-size: 0.78rem; outline: none; cursor: pointer; }
    .plan-select:focus { border-color: var(--primary); }

    /* Impersonate banner */
    .imp-banner { background: linear-gradient(135deg, rgba(245,158,11,0.15), rgba(239,68,68,0.1)); border: 1px solid rgba(245,158,11,0.3); border-radius: var(--r); padding: 12px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .imp-banner p { font-size: 0.875rem; color: #fbbf24; font-weight: 700; }

    /* Pagination */
    .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 24px; flex-wrap: wrap; }
    .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--border); background: var(--bg2); color: var(--t2); transition: all 0.2s; }
    .pagination a:hover { border-color: var(--primary); color: var(--primary); }
    .pagination .active span { background: var(--primary); border-color: var(--primary); color: #fff; }

    /* Alert */
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); border-radius: var(--r); padding: 12px 16px; color: #6ee7b7; font-size: 0.875rem; margin-bottom: 16px; }

    @media (max-width: 768px) {
      .stats-row { grid-template-columns: 1fr 1fr; }
      .container { padding: 16px 12px; }
      .topbar { padding: 0 16px; }
      table { min-width: 700px; }
      .table-wrap { overflow-x: auto; }
    }
  </style>
</head>
<body>

<nav class="topbar">
  <div class="brand">
    <div class="brand-icon">W</div>
    Wayzon
    <span class="admin-badge">⚡ أدمن</span>
  </div>
  <div class="top-actions">
    @if(session('impersonating_admin_id'))
      <form method="POST" action="{{ route('admin.stopImpersonate') }}">@csrf
        <button type="submit" class="btn btn-danger btn-sm">⬅️ رجوع للأدمن</button>
      </form>
    @endif
    <a href="{{ route('admin.botTraining') }}" class="btn btn-ghost btn-sm">🤖 تدريب البوت</a>
    <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">لوحة التحكم</a>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button class="btn btn-ghost btn-sm">خروج</button>
    </form>
  </div>
</nav>

<div class="container">

  @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
  @endif

  @if(session('impersonating_admin_id'))
    <div class="imp-banner">
      <p>⚠️ أنت تعمل كـ {{ Auth::user()->email }} — هذا وضع المحاكاة</p>
      <form method="POST" action="{{ route('admin.stopImpersonate') }}">@csrf
        <button type="submit" class="btn btn-danger btn-sm">إنهاء المحاكاة</button>
      </form>
    </div>
  @endif

  <!-- Stats -->
  @php
    $allUsers  = \App\Models\User::count();
    $basicC    = \App\Models\User::where('plan','basic')->count();
    $smartC    = \App\Models\User::where('plan','smart')->count();
    $proC      = \App\Models\User::where('plan','pro')->count();
  @endphp
  <div class="stats-row">
    <div class="stat-card"><div class="stat-val">{{ $allUsers }}</div><div class="stat-lbl">إجمالي المستخدمين</div></div>
    <div class="stat-card"><div class="stat-val" style="color:#a5b4fc;">{{ $basicC }}</div><div class="stat-lbl">🚀 الأساسية</div></div>
    <div class="stat-card"><div class="stat-val" style="color:#c4b5fd;">{{ $smartC }}</div><div class="stat-lbl">🧠 الذكية</div></div>
    <div class="stat-card"><div class="stat-val" style="color:#d8b4fe;">{{ $proC }}</div><div class="stat-lbl">🏆 الاحترافية</div></div>
  </div>

  <!-- Admin WhatsApp -->
  @if(!session('impersonating_admin_id'))
  <div id="adminWaCard" style="background:var(--bg2);border:1px solid var(--border2);border-radius:var(--r);padding:20px 24px;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
      <span style="font-size:1.4rem;">📲</span>
      <div style="flex:1;min-width:140px;">
        <div style="font-size:0.9rem;font-weight:800;color:var(--t1);">واتساب الأدمن</div>
        <div id="adminWaStatus" style="font-size:0.78rem;color:var(--t2);margin-top:3px;">جارٍ التحميل...</div>
      </div>
      <div style="display:flex;gap:8px;align-items:center;">
        <span id="adminWaDot" style="width:10px;height:10px;border-radius:50%;background:#64748b;display:inline-block;flex-shrink:0;"></span>
        <button id="adminWaConnectBtn" onclick="startAdminWa()" class="btn btn-primary btn-sm" style="display:none;">🔗 ربط</button>
        <button id="adminWaLogoutBtn" onclick="logoutAdminWa()" class="btn btn-danger btn-sm" style="display:none;">🔌 قطع</button>
      </div>
    </div>
    <div id="adminQrWrap" style="display:none;margin-top:16px;text-align:center;">
      <div style="font-size:0.78rem;color:#fbbf24;font-weight:700;margin-bottom:8px;">📱 افتح واتساب → الإعدادات → الأجهزة المرتبطة → امسح الكود</div>
      <img id="adminQrImg" src="" style="width:180px;height:180px;border-radius:10px;background:#fff;padding:6px;" />
    </div>
  </div>
  <script>
  (function(){
    const STATUS_URL = '{{ route("admin.wa.status") }}';
    const LOGOUT_URL = '{{ route("admin.wa.logout") }}';
    const CSRF = document.querySelector('meta[name=csrf-token]')?.content || '';
    let pollTimer = null;
    let initSince = null;

    async function pollAdminWa() {
      try {
        const r = await fetch(STATUS_URL);
        if (!r.ok) return;
        const d = await r.json();
        const dot     = document.getElementById('adminWaDot');
        const lbl     = document.getElementById('adminWaStatus');
        const qrW     = document.getElementById('adminQrWrap');
        const qrI     = document.getElementById('adminQrImg');
        const logB    = document.getElementById('adminWaLogoutBtn');
        const conB    = document.getElementById('adminWaConnectBtn');

        if (d.state === 'ready') {
          dot.style.background = '#10b981';
          lbl.textContent = '✅ متصل — البوت يعمل';
          qrW.style.display = 'none';
          logB.style.display = ''; conB.style.display = 'none';
          initSince = null;
        } else if (d.state === 'qr' && d.qr) {
          dot.style.background = '#f59e0b';
          lbl.textContent = '📷 امسح الكود بهاتفك';
          qrI.src = d.qr; qrW.style.display = '';
          logB.style.display = 'none'; conB.style.display = 'none';
          initSince = null;
        } else if (d.state === 'initializing') {
          dot.style.background = '#6366f1';
          lbl.textContent = '⏳ جارٍ التهيئة...';
          qrW.style.display = 'none';
          logB.style.display = 'none'; conB.style.display = 'none';
          if (!initSince) initSince = Date.now();
          // Auto-retry after 36s if still initializing
          if (Date.now() - initSince > 36000) { initSince = null; startAdminWa(); }
        } else {
          dot.style.background = '#ef4444';
          lbl.textContent = '❌ غير متصل';
          qrW.style.display = 'none';
          logB.style.display = 'none'; conB.style.display = '';
          initSince = null;
        }
      } catch(e) {}
    }

    window.startAdminWa = async function() {
      document.getElementById('adminWaStatus').textContent = '⏳ جارٍ الاتصال...';
      document.getElementById('adminWaConnectBtn').style.display = 'none';
      // logout first to reset, then status will auto-reconnect
      try { await fetch(LOGOUT_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF } }); } catch(e) {}
      setTimeout(pollAdminWa, 1500);
    };

    window.logoutAdminWa = async function() {
      if (!confirm('قطع اتصال واتساب الأدمن؟')) return;
      await fetch(LOGOUT_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF } });
      document.getElementById('adminWaLogoutBtn').style.display = 'none';
      document.getElementById('adminWaConnectBtn').style.display = '';
      document.getElementById('adminWaStatus').textContent = '❌ غير متصل';
    };

    pollAdminWa();
    pollTimer = setInterval(pollAdminWa, 3000);
  })();
  </script>
  @endif

  <!-- Search -->
  <form method="GET" action="{{ route('admin.index') }}" class="search-bar">
    <input type="text" name="q" value="{{ $q }}" class="search-input" placeholder="🔍 ابحث بالإيميل أو اسم المتجر أو الرابط..." />
    <button type="submit" class="btn btn-primary">بحث</button>
    @if($q) <a href="{{ route('admin.index') }}" class="btn btn-ghost">مسح</a> @endif
  </form>

  <!-- Table -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>الاسم / الإيميل</th>
          <th>المتجر</th>
          <th>الباقة</th>
          <th>تغيير الباقة</th>
          <th>حالة الاشتراك</th>
          <th>تاريخ التسجيل</th>
          <th>دخول</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td style="color:var(--t3);">{{ $u->id }}</td>
          <td>
            <div class="td-main">{{ $u->name }}</div>
            <div style="font-size:0.78rem;color:var(--t3);margin-top:2px;">{{ $u->email }}</div>
            @if($u->is_admin) <span style="font-size:0.65rem;background:rgba(245,158,11,0.15);color:#fbbf24;padding:2px 7px;border-radius:99px;font-weight:800;">أدمن</span> @endif
          </td>
          <td>
            @if($u->sallaStore)
              <div class="td-main">{{ $u->sallaStore->store_name ?? '—' }}</div>
              <div style="font-size:0.75rem;color:var(--t3);">{{ $u->sallaStore->store_url ?? '' }}</div>
            @else
              <span style="color:var(--t3);">لا يوجد</span>
            @endif
          </td>
          <td>
            @php $p = $u->plan ?? 'none'; @endphp
            <span class="plan-badge plan-{{ $p }}">{{ $u->planLabel() }}</span>
          </td>
          <td>
            <form method="POST" action="{{ route('admin.setPlan', $u) }}" class="plan-form">
              @csrf
              <select name="plan" class="plan-select">
                <option value="none"  @selected(!$u->plan)>بدون باقة</option>
                <option value="basic" @selected($u->plan==='basic')>🚀 الأساسية</option>
                <option value="smart" @selected($u->plan==='smart')>🧠 الذكية</option>
                <option value="pro"   @selected($u->plan==='pro')>🏆 الاحترافية</option>
              </select>
              <button type="submit" class="btn btn-green btn-sm">حفظ</button>
            </form>
            {{-- Per-user AI model --}}
            @php $userModel = $u->bot_config['ai_model_override'] ?? ''; @endphp
            <form method="POST" action="{{ route('admin.setUserModel', $u) }}" class="plan-form" style="margin-top:6px;">
              @csrf
              <select name="model" class="plan-select" style="font-size:0.72rem;">
                <option value=""            @selected(!$userModel)>🌐 النموذج العام</option>
                <option value="gpt-4o-mini" @selected($userModel==='gpt-4o-mini')>⚡ GPT-4o Mini</option>
                <option value="gpt-4o"      @selected($userModel==='gpt-4o')>🧠 GPT-4o</option>
                <option value="gpt-4-turbo" @selected($userModel==='gpt-4-turbo')>🚀 GPT-4 Turbo</option>
                <option value="o3-mini"     @selected($userModel==='o3-mini')>🔬 o3 Mini</option>
              </select>
              <button type="submit" class="btn btn-ghost btn-sm" style="font-size:0.72rem;">🤖</button>
            </form>
          </td>
          <td>
            @php
              $subActive   = $u->subscription_ends_at && $u->subscription_ends_at->isFuture();
              $trialActive = $u->trial_ends_at && $u->trial_ends_at->isFuture();
              $activeDate  = $subActive ? $u->subscription_ends_at : ($trialActive ? $u->trial_ends_at : null);
              $diffDays    = $activeDate ? now()->diffInDays($activeDate, false) : 0;
              $diffHrs     = $activeDate ? now()->diffInHours($activeDate, false) : 0;
            @endphp
            @if($subActive)
              <span style="color:#6ee7b7;font-size:0.78rem;font-weight:700;">✅ نشط</span><br>
              <span style="color:#64748b;font-size:0.72rem;">ينتهي: {{ $u->subscription_ends_at->format('Y/m/d') }}</span><br>
              <span style="color:#a5b4fc;font-size:0.72rem;">باقي: {{ $diffDays > 0 ? $diffDays.' يوم' : $diffHrs.' ساعة' }}</span>
            @elseif($trialActive)
              <span style="color:#fbbf24;font-size:0.78rem;font-weight:700;">⏳ تجربة</span><br>
              <span style="color:#a5b4fc;font-size:0.72rem;">باقي: {{ $diffDays > 0 ? $diffDays.' يوم' : $diffHrs.' ساعة' }}</span>
            @else
              <span style="color:#f87171;font-size:0.78rem;font-weight:700;">❌ منتهية</span>
            @endif
            <form method="POST" action="{{ route('admin.setTrial', $u) }}" style="display:flex;gap:4px;margin-top:5px;">
              @csrf
              <input type="number" name="days" value="30" min="1" max="365"
                     style="width:52px;background:var(--bg3);border:1px solid var(--border);border-radius:6px;color:var(--t1);padding:3px 6px;font-size:0.72rem;font-family:inherit;">
              <button type="submit" class="btn btn-green btn-sm" style="font-size:0.7rem;padding:3px 8px;">
                {{ ($subActive || $trialActive) ? 'تمديد' : 'تفعيل' }}
              </button>
            </form>
          </td>
          <td style="color:var(--t3);font-size:0.78rem;">{{ $u->created_at->format('Y/m/d') }}</td>
          <td>
            @if(!in_array($u->email, ['faisal@1212.com','omar@gmail.com']))
            <form method="POST" action="{{ route('admin.deleteUser', $u) }}"
                  onsubmit="return confirm('⚠️ حذف حساب {{ addslashes($u->email) }}؟\n\nهذا الإجراء لا يمكن التراجع عنه!')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" style="margin-bottom:4px;">🗑 حذف</button>
            </form>
            @endif
            @if(!$u->is_admin)
            <form method="POST" action="{{ route('admin.impersonate', $u) }}">
              @csrf
              <button type="submit" class="btn btn-ghost btn-sm">🔑 دخول</button>
            </form>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--t3);">لا توجد نتائج</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="pagination">
    {{ $users->appends(['q' => $q])->links('pagination::simple-bootstrap-4') }}
  </div>

</div>
</body>
</html>
