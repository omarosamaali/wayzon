<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Wayzon — لوحة التحكم</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --bg: #0d1117;
      --bg2: #161b24;
      --bg3: #1c2233;
      --bg4: #212840;
      --border: rgba(255, 255, 255, 0.07);
      --border2: rgba(255, 255, 255, 0.12);
      --t1: #f0f4ff;
      --t2: #94a3b8;
      --t3: #5a6480;
      --primary: #6366f1;
      --primary-glow: rgba(99, 102, 241, 0.25);
      --green: #10b981;
      --green-bg: rgba(16, 185, 129, 0.12);
      --amber: #f59e0b;
      --amber-bg: rgba(245, 158, 11, 0.12);
      --red: #ef4444;
      --red-bg: rgba(239, 68, 68, 0.12);
      --cyan: #06b6d4;
      --cyan-bg: rgba(6, 182, 212, 0.12);
      --purple: #8b5cf6;
      --r: 10px;
      --r2: 14px;
      --sidebar-w: 252px;
      --transition: all 0.18s ease;
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    body {
      font-family: 'Tajawal', sans-serif;
      background: var(--bg);
      color: var(--t1);
      min-height: 100vh;
      min-height: -webkit-fill-available;
      overflow: hidden;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--bg4);
      border-radius: 9px;
    }

    /* ═══════════════════════════════════════
   LAYOUT
═══════════════════════════════════════ */
    .layout {
      display: flex;
      height: 100vh;
      height: -webkit-fill-available;
    }

    /* ═══════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════ */
    .sidebar {
      width: var(--sidebar-w);
      flex-shrink: 0;
      background: var(--bg2);
      border-left: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
      position: relative;
      z-index: 100;
    }

    /* Brand */
    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 18px 20px 16px;
      border-bottom: 1px solid var(--border);
    }

    .brand-logo {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, var(--primary), #8b5cf6);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      font-weight: 900;
      color: #fff;
      box-shadow: 0 4px 12px var(--primary-glow);
    }

    .brand-name {
      font-size: 1.125rem;
      font-weight: 900;
      color: var(--t1);
      letter-spacing: -0.02em;
    }

    /* Store selector */
    .store-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 12px 12px 4px;
      padding: 10px 12px;
      background: rgba(99, 102, 241, 0.08);
      border: 1px solid rgba(99, 102, 241, 0.2);
      border-radius: var(--r);
      cursor: pointer;
      transition: var(--transition);
    }

    .store-btn:hover {
      background: rgba(99, 102, 241, 0.14);
    }

    .store-ava {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--primary), #8b5cf6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.875rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .store-info {
      flex: 1;
      min-width: 0;
    }

    .store-name {
      font-size: 0.8125rem;
      font-weight: 700;
      color: var(--t1);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .store-plan {
      font-size: 0.6875rem;
      color: #a5b4fc;
      font-weight: 600;
      margin-top: 1px;
    }

    .store-chevron {
      color: var(--t3);
      font-size: 0.7rem;
      flex-shrink: 0;
    }

    /* Nav */
    .nav {
      flex: 1;
      overflow-y: auto;
      padding: 8px 10px;
    }

    .nav-section {
      font-size: 0.65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--t3);
      padding: 14px 10px 5px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 9px 10px;
      border-radius: 8px;
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--t2);
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      user-select: none;
    }

    .nav-item:hover {
      background: rgba(255, 255, 255, 0.04);
      color: var(--t1);
    }

    .nav-item.active {
      background: rgba(99, 102, 241, 0.14);
      color: var(--t1);
      font-weight: 700;
    }

    .nav-item.active::before {
      content: '';
      position: absolute;
      right: 0;
      top: 22%;
      bottom: 22%;
      width: 3px;
      background: var(--primary);
      border-radius: 2px 0 0 2px;
    }

    .nav-icon {
      font-size: 1rem;
      width: 20px;
      text-align: center;
      flex-shrink: 0;
    }

    .nav-badge {
      margin-right: auto;
      min-width: 20px;
      height: 20px;
      border-radius: 99px;
      font-size: 0.6875rem;
      font-weight: 700;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 6px;
    }

    .nb-primary {
      background: var(--primary);
    }

    .nb-orange {
      background: var(--amber);
      color: #000;
    }

    .nb-green {
      background: var(--green);
    }

    /* Sidebar Footer */
    .sidebar-foot {
      padding: 10px 10px 14px;
      border-top: 1px solid var(--border);
    }

    .user-card {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 10px;
      border-radius: var(--r);
      cursor: pointer;
      transition: var(--transition);
    }

    .user-card:hover {
      background: rgba(255, 255, 255, 0.04);
    }

    .user-ava {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      background: linear-gradient(135deg, var(--cyan), var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.875rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .user-name {
      font-size: 0.875rem;
      font-weight: 700;
      color: var(--t1);
    }

    .user-email {
      font-size: 0.7rem;
      color: var(--t3);
      margin-top: 1px;
    }

    /* ═══════════════════════════════════════
   MAIN
═══════════════════════════════════════ */
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
      height: -webkit-fill-available;
      overflow: hidden;
      min-width: 0;
    }

    /* Topbar */
    .topbar {
      height: 58px;
      background: var(--bg2);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 24px;
      gap: 14px;
      flex-shrink: 0;
    }

    .topbar-title {
      font-size: 1rem;
      font-weight: 800;
      color: var(--t1);
      flex: 1;
    }

    .search-box {
      display: flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border);
      border-radius: var(--r);
      padding: 7px 14px;
      width: 220px;
      cursor: text;
      transition: var(--transition);
    }

    .search-box:hover {
      border-color: var(--border2);
    }

    .search-box span {
      font-size: 0.8rem;
      color: var(--t3);
    }

    .search-box kbd {
      margin-right: auto;
      font-size: 0.62rem;
      padding: 2px 5px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 4px;
      color: var(--t3);
      font-family: inherit;
    }

    .icon-btn {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      font-size: 1rem;
    }

    .icon-btn:hover {
      background: rgba(255, 255, 255, 0.08);
    }

    .notif-dot {
      position: absolute;
      top: 7px;
      left: 7px;
      width: 7px;
      height: 7px;
      background: var(--red);
      border-radius: 50%;
      border: 1.5px solid var(--bg2);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: var(--r);
      font-size: 0.8125rem;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      border: none;
      transition: var(--transition);
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
      box-shadow: 0 4px 12px var(--primary-glow);
    }

    .btn-primary:hover {
      background: #7c3aed;
      transform: translateY(-1px);
    }

    .btn-ghost {
      background: transparent;
      color: var(--t2);
      border: 1px solid var(--border);
    }

    .btn-ghost:hover {
      background: rgba(255, 255, 255, 0.05);
      color: var(--t1);
    }

    .btn-sm {
      padding: 5px 12px;
      font-size: 0.8rem;
    }

    /* Content */
    .content {
      flex: 1;
      overflow-y: auto;
      padding: 24px;
      background: var(--bg);
    }

    /* ── Pages ── */
    .page {
      display: none;
    }

    .page.active {
      display: block;
    }

    /* ═══════════════════════════════════════
   DASHBOARD PAGE
═══════════════════════════════════════ */
    .greeting {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }

    .greeting h2 {
      font-size: 1.3rem;
      font-weight: 900;
      color: var(--t1);
      margin-bottom: 3px;
    }

    .greeting p {
      font-size: 0.8125rem;
      color: var(--t2);
    }

    .greeting-actions {
      display: flex;
      gap: 8px;
    }

    /* Stats */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }

    .stat-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      padding: 18px 20px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .stat-card::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      opacity: 0.06;
      transform: translate(20px, -20px);
    }

    .stat-card.s-indigo::after {
      background: var(--primary);
    }

    .stat-card.s-green::after {
      background: var(--green);
    }

    .stat-card.s-cyan::after {
      background: var(--cyan);
    }

    .stat-card.s-amber::after {
      background: var(--amber);
    }

    .stat-card:hover {
      border-color: var(--border2);
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .stat-icon {
      width: 38px;
      height: 38px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      margin-bottom: 12px;
    }

    .si-indigo {
      background: rgba(99, 102, 241, 0.15);
    }

    .si-green {
      background: var(--green-bg);
    }

    .si-cyan {
      background: var(--cyan-bg);
    }

    .si-amber {
      background: var(--amber-bg);
    }

    .stat-val {
      font-size: 1.7rem;
      font-weight: 900;
      color: var(--t1);
      line-height: 1;
      margin-bottom: 3px;
    }

    .stat-lbl {
      font-size: 0.8rem;
      color: var(--t2);
      margin-bottom: 10px;
    }

    .stat-change {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 3px 7px;
      border-radius: 99px;
    }

    .ch-up {
      background: var(--green-bg);
      color: var(--green);
    }

    .ch-down {
      background: var(--red-bg);
      color: var(--red);
    }

    .stat-note {
      font-size: 0.68rem;
      color: var(--t3);
      margin-right: 5px;
    }

    /* Charts */
    .charts-row {
      display: grid;
      grid-template-columns: 1.7fr 1fr;
      gap: 14px;
      margin-bottom: 20px;
    }

    .chart-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      padding: 20px;
    }

    .chart-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 18px;
      flex-wrap: wrap;
    }

    .chart-title {
      font-size: 0.9375rem;
      font-weight: 800;
      color: var(--t1);
    }

    .chart-sub {
      font-size: 0.75rem;
      color: var(--t3);
      margin-top: 2px;
    }

    .chart-tabs {
      display: flex;
      gap: 3px;
    }

    .ctab {
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--t3);
      cursor: pointer;
      font-family: inherit;
      border: none;
      background: transparent;
      transition: var(--transition);
    }

    .ctab.active {
      background: rgba(99, 102, 241, 0.18);
      color: #a5b4fc;
    }

    .ctab:hover:not(.active) {
      color: var(--t2);
      background: rgba(255, 255, 255, 0.04);
    }

    canvas {
      max-height: 210px;
    }

    .legend {
      display: flex;
      gap: 14px;
      align-items: center;
    }

    .leg-item {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.72rem;
      color: var(--t2);
    }

    .leg-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
    }

    .donut-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .donut-center {
      position: absolute;
      text-align: center;
      pointer-events: none;
    }

    .donut-num {
      font-size: 1.3rem;
      font-weight: 900;
      color: var(--t1);
      line-height: 1;
    }

    .donut-lbl {
      font-size: 0.65rem;
      color: var(--t3);
    }

    .cat-list {
      margin-top: 14px;
      display: flex;
      flex-direction: column;
      gap: 9px;
    }

    .cat-item {
      display: flex;
      align-items: center;
      gap: 9px;
    }

    .cat-dot {
      width: 9px;
      height: 9px;
      border-radius: 3px;
      flex-shrink: 0;
    }

    .cat-name {
      font-size: 0.8rem;
      color: var(--t2);
      flex: 1;
    }

    .cat-bar-bg {
      flex: 1.5;
      height: 5px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 9px;
      overflow: hidden;
    }

    .cat-bar {
      height: 100%;
      border-radius: 9px;
      transition: width 0.5s ease;
    }

    .cat-pct {
      font-size: 0.72rem;
      font-weight: 800;
      color: var(--t1);
      min-width: 30px;
      text-align: left;
    }

    /* Bottom */
    .bottom-row {
      display: grid;
      grid-template-columns: 1.6fr 1fr;
      gap: 14px;
    }

    .panel {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      overflow: hidden;
    }

    .panel-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
    }

    .panel-title {
      font-size: 0.9375rem;
      font-weight: 800;
      color: var(--t1);
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      padding: 9px 14px;
      font-size: 0.7rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--t3);
      text-align: right;
      background: rgba(255, 255, 255, 0.02);
      border-bottom: 1px solid var(--border);
    }

    td {
      padding: 12px 14px;
      font-size: 0.8375rem;
      color: var(--t2);
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: rgba(255, 255, 255, 0.018);
    }

    .order-id {
      font-weight: 800;
      color: var(--t1);
      font-family: monospace;
      font-size: 0.78rem;
    }

    .cust-cell {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .cust-ava {
      width: 28px;
      height: 28px;
      border-radius: 7px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .amount {
      font-weight: 800;
      color: var(--t1);
    }

    /* Badges */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 3px 9px;
      border-radius: 99px;
      font-size: 0.72rem;
      font-weight: 700;
      white-space: nowrap;
    }

    .b-green {
      background: var(--green-bg);
      color: var(--green);
    }

    .b-amber {
      background: var(--amber-bg);
      color: var(--amber);
    }

    .b-red {
      background: var(--red-bg);
      color: var(--red);
    }

    .b-primary {
      background: rgba(99, 102, 241, 0.15);
      color: #a5b4fc;
    }

    .b-cyan {
      background: var(--cyan-bg);
      color: var(--cyan);
    }

    .b-purple {
      background: rgba(139, 92, 246, 0.15);
      color: var(--purple);
    }

    /* Activity */
    .activity-list {
      padding: 6px 0;
    }

    .act-item {
      display: flex;
      gap: 10px;
      padding: 11px 18px;
      transition: var(--transition);
    }

    .act-item:hover {
      background: rgba(255, 255, 255, 0.02);
    }

    .act-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.875rem;
      flex-shrink: 0;
    }

    .act-body {
      flex: 1;
      min-width: 0;
    }

    .act-msg {
      font-size: 0.8rem;
      color: var(--t2);
      line-height: 1.45;
    }

    .act-msg strong {
      color: var(--t1);
      font-weight: 700;
    }

    .act-time {
      font-size: 0.68rem;
      color: var(--t3);
      margin-top: 3px;
    }

    /* ═══════════════════════════════════════
   ORDERS PAGE
═══════════════════════════════════════ */
    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      gap: 12px;
      flex-wrap: wrap;
    }

    .page-h1 {
      font-size: 1.2rem;
      font-weight: 900;
      color: var(--t1);
    }

    .page-sub {
      font-size: 0.8rem;
      color: var(--t2);
      margin-top: 2px;
    }

    .filter-bar {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 16px;
      flex-wrap: wrap;
    }

    .filter-tab {
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--t2);
      cursor: pointer;
      border: 1px solid var(--border);
      background: transparent;
      font-family: inherit;
      transition: var(--transition);
    }

    .filter-tab.active {
      background: rgba(99, 102, 241, 0.14);
      border-color: rgba(99, 102, 241, 0.3);
      color: #a5b4fc;
    }

    .filter-tab:hover:not(.active) {
      background: rgba(255, 255, 255, 0.04);
      color: var(--t1);
    }

    .full-panel {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      overflow: hidden;
    }

    /* ═══════════════════════════════════════
   SHIPPING PAGE
═══════════════════════════════════════ */
    .shipping-cards {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }

    .ship-stat {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      padding: 18px 20px;
    }

    .ship-stat-val {
      font-size: 1.5rem;
      font-weight: 900;
      color: var(--t1);
      margin-bottom: 4px;
    }

    .ship-stat-lbl {
      font-size: 0.8rem;
      color: var(--t2);
    }

    .track-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      padding: 20px;
      margin-bottom: 14px;
    }

    .track-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
    }

    .track-steps {
      display: flex;
      align-items: center;
      gap: 0;
    }

    .track-step {
      display: flex;
      align-items: center;
      gap: 0;
      flex: 1;
    }

    .step-circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 700;
      flex-shrink: 0;
      border: 2px solid var(--border);
      background: var(--bg);
      color: var(--t3);
      transition: var(--transition);
    }

    .step-circle.done {
      background: var(--green);
      border-color: var(--green);
      color: #fff;
    }

    .step-circle.active {
      background: var(--primary);
      border-color: var(--primary);
      color: #fff;
      box-shadow: 0 0 0 4px var(--primary-glow);
    }

    .step-line {
      flex: 1;
      height: 2px;
      background: var(--border);
    }

    .step-line.done {
      background: var(--green);
    }

    .step-labels {
      display: flex;
      margin-top: 8px;
      gap: 0;
    }

    .step-lbl {
      flex: 1;
      text-align: center;
      font-size: 0.68rem;
      color: var(--t3);
    }

    .step-lbl.active {
      color: var(--t1);
      font-weight: 700;
    }

    .step-lbl.done {
      color: var(--green);
    }

    /* ═══════════════════════════════════════
   CUSTOMERS PAGE
═══════════════════════════════════════ */
    .customers-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }

    .cust-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      padding: 18px 20px;
      display: flex;
      align-items: center;
      gap: 14px;
      transition: var(--transition);
    }

    .cust-card:hover {
      border-color: var(--border2);
      transform: translateY(-1px);
    }

    .cust-card-ava {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .cust-card-info {
      flex: 1;
    }

    .cust-card-name {
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--t1);
      margin-bottom: 3px;
    }

    .cust-card-meta {
      font-size: 0.75rem;
      color: var(--t2);
    }

    .cust-card-stat {
      text-align: left;
    }

    .cust-card-orders {
      font-size: 1.1rem;
      font-weight: 900;
      color: var(--t1);
    }

    .cust-card-slbl {
      font-size: 0.65rem;
      color: var(--t3);
    }

    /* ═══════════════════════════════════════
   PRODUCTS PAGE
═══════════════════════════════════════ */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }

    .prod-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--r2);
      overflow: hidden;
      transition: var(--transition);
      cursor: pointer;
    }

    .prod-card:hover {
      border-color: var(--border2);
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .prod-img {
      height: 120px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
    }

    .prod-body {
      padding: 14px 14px 16px;
    }

    .prod-name {
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--t1);
      margin-bottom: 4px;
    }

    .prod-cat {
      font-size: 0.72rem;
      color: var(--t3);
      margin-bottom: 10px;
    }

    .prod-foot {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .prod-price {
      font-size: 0.9375rem;
      font-weight: 900;
      color: var(--primary);
    }

    .prod-stock {
      font-size: 0.72rem;
      font-weight: 700;
    }

    .prod-stock.low {
      color: var(--red);
    }

    .prod-stock.ok {
      color: var(--green);
    }

    /* ═══════════════════════════════════════
   REPORTS PAGE
═══════════════════════════════════════ */
    .reports-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 20px;
    }

    /* ═══════════════════════════════════════
   WHATSAPP PAGE
═══════════════════════════════════════ */
    .wa-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .wa-status-bar {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 12px 16px;
      background: var(--green-bg);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: var(--r);
      margin-bottom: 16px;
    }

    .wa-dot {
      width: 9px;
      height: 9px;
      border-radius: 50%;
      background: var(--green);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.4;
      }
    }

    .wa-status-txt {
      font-size: 0.8125rem;
      font-weight: 700;
      color: var(--green);
    }

    .wa-status-num {
      font-size: 0.75rem;
      color: var(--t2);
      margin-right: auto;
    }

    .wa-form-group {
      margin-bottom: 16px;
    }

    .wa-label {
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--t2);
      margin-bottom: 6px;
      display: block;
    }

    .wa-input {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: var(--r);
      color: var(--t1);
      font-family: inherit;
      font-size: 0.875rem;
      transition: var(--transition);
      outline: none;
    }

    .wa-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .wa-input::placeholder {
      color: var(--t3);
    }

    .wa-textarea {
      resize: vertical;
      min-height: 80px;
    }

    .wa-toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 11px 0;
      border-bottom: 1px solid var(--border);
    }

    .wa-toggle-row:last-child {
      border-bottom: none;
    }

    .wa-toggle-txt {
      font-size: 0.8375rem;
      color: var(--t1);
    }

    .wa-toggle-sub {
      font-size: 0.72rem;
      color: var(--t3);
      margin-top: 2px;
    }

    .toggle {
      width: 40px;
      height: 22px;
      border-radius: 11px;
      position: relative;
      cursor: pointer;
      flex-shrink: 0;
      transition: var(--transition);
    }

    .toggle.on {
      background: var(--green);
    }

    .toggle.off {
      background: var(--bg4);
    }

    .toggle-knob {
      position: absolute;
      top: 3px;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: #fff;
      transition: var(--transition);
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
    }

    .toggle.on .toggle-knob {
      right: 3px;
    }

    .toggle.off .toggle-knob {
      right: 21px;
    }

    .session-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 18px;
      border-bottom: 1px solid var(--border);
      transition: var(--transition);
    }

    .session-item:hover {
      background: rgba(255, 255, 255, 0.02);
    }

    .session-item:last-child {
      border-bottom: none;
    }

    .sess-ava {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .sess-name {
      font-size: 0.875rem;
      font-weight: 700;
      color: var(--t1);
    }

    .sess-last {
      font-size: 0.72rem;
      color: var(--t3);
      margin-top: 2px;
    }

    .sess-time {
      font-size: 0.7rem;
      color: var(--t3);
      margin-right: auto;
    }

    .sess-status {
      font-size: 0.7rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 99px;
    }

    .ss-active {
      background: var(--green-bg);
      color: var(--green);
    }

    .ss-idle {
      background: var(--amber-bg);
      color: var(--amber);
    }

    /* ═══════════════════════════════════════
   UTILITY
═══════════════════════════════════════ */
    .section-divider {
      height: 1px;
      background: var(--border);
      margin: 16px 0;
    }

    /* Tabs for section navigation */
    .tab-nav {
      display: flex;
      gap: 4px;
      border-bottom: 1px solid var(--border);
      margin-bottom: 20px;
    }

    .tab-nav-item {
      padding: 10px 16px;
      font-size: 0.8375rem;
      font-weight: 600;
      color: var(--t3);
      cursor: pointer;
      border-bottom: 2px solid transparent;
      margin-bottom: -1px;
      transition: var(--transition);
      font-family: inherit;
      background: none;
      border-top: none;
      border-left: none;
      border-right: none;
    }

    .tab-nav-item.active {
      color: var(--t1);
      border-bottom-color: var(--primary);
    }

    .tab-nav-item:hover:not(.active) {
      color: var(--t2);
    }

    /* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
    @media (max-width: 1280px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .charts-row {
        grid-template-columns: 1fr;
      }

      .bottom-row {
        grid-template-columns: 1fr;
      }

      .products-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 1024px) {
      .shipping-cards {
        grid-template-columns: 1fr 1fr;
      }

      .customers-grid {
        grid-template-columns: 1fr 1fr;
      }

      .wa-grid {
        grid-template-columns: 1fr;
      }

      .reports-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 900px) {
      body {
        overflow: auto;
      }

      .layout {
        flex-direction: column;
        height: auto;
        min-height: 100vh;
      }

      .main {
        height: auto;
        min-height: 100vh;
        overflow: visible;
        flex: 1;
      }

      .content {
        overflow: visible;
        height: auto;
        min-height: calc(100vh - 58px);
        padding-bottom: 40px;
      }

      .sidebar {
        position: fixed;
        right: -280px;
        top: 0;
        bottom: 0;
        z-index: 200;
        transition: right 0.22s ease;
        box-shadow: none;
      }

      .sidebar.open {
        right: 0;
        box-shadow: -8px 0 40px rgba(0, 0, 0, 0.6);
      }

      .mob-toggle {
        display: flex !important;
        position: relative;
        z-index: 210;
      }

      .mob-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 190;
      }

      .mob-overlay.open {
        display: block;
      }
    }

    @media (max-width: 600px) {
      .stats-grid {
        grid-template-columns: 1fr 1fr;
      }

      .content {
        padding: 12px;
      }

      .products-grid {
        grid-template-columns: 1fr 1fr;
      }

      .shipping-cards {
        grid-template-columns: 1fr;
      }

      .customers-grid {
        grid-template-columns: 1fr;
      }

      /* Topbar mobile */
      .search-box {
        display: none;
      }

      .topbar {
        padding: 0 12px;
        gap: 8px;
      }

      .topbar-title {
        font-size: 0.95rem;
      }

      .topbar > div:last-child {
        gap: 4px;
      }

      .topbar .btn-ghost {
        font-size: 0.75rem;
        padding: 5px 8px;
      }

      /* Greeting */
      .greeting {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
      }

      .greeting h2 {
        font-size: 1.1rem;
      }

      .greeting-actions {
        width: 100%;
        justify-content: flex-end;
      }

      /* Stat cards 2 columns */
      .stat-card {
        padding: 14px 16px;
      }

      .stat-val {
        font-size: 1.5rem;
      }

      /* Tables scroll */
      .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }

      /* Plans */
      .plans-grid {
        grid-template-columns: 1fr !important;
      }

      .plan-card.feat {
        transform: none !important;
      }

      /* WhatsApp & AI grids → single column */
      .wa-grid,
      [style*="grid-template-columns:1fr 1fr"],
      [style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
      }

      /* Page header wrap on mobile */
      .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }

      .page-header > div:last-child {
        width: 100%;
      }

      .page-header .btn {
        flex: 1;
      }

      /* Template tab nav scroll */
      .tab-nav {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 4px;
      }

      .tab-nav-item {
        white-space: nowrap;
        flex-shrink: 0;
      }

      /* Reports grid */
      .reports-grid {
        grid-template-columns: 1fr !important;
      }

      /* WA status bar */
      .wa-status-bar {
        flex-wrap: wrap;
        gap: 8px;
      }

      /* Full panel padding */
      .full-panel > div[style*="padding"] {
        padding: 12px 14px !important;
      }

      /* Billing toggle full width */
      .billing-toggle {
        width: 100%;
        justify-content: center;
      }

      /* Fix page visibility on mobile */
      .page.active {
        display: block !important;
        min-height: 200px;
      }

      /* AI/bot form full width */
      .full-panel {
        overflow: visible;
      }

      /* Topbar sticky on iOS */
      .topbar {
        position: sticky;
        top: 0;
        z-index: 150;
      }
    }

    @media (max-width: 380px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }

    .mob-toggle {
      display: none;
    }

    .logo-img {
  width: 36px;
  height: 36px;
  object-fit: contain;
  border-radius: 10px;
  filter: drop-shadow(0 4px 8px var(--primary-glow));
}
  </style>
</head>

<body>

  {{-- Trial banner: shown only during active trial (no paid plan yet) --}}
  @php
    $subActive   = Auth::user()->subscription_ends_at && Auth::user()->subscription_ends_at->isFuture();
    $trialActive = Auth::user()->trial_ends_at && Auth::user()->trial_ends_at->isFuture();
    $trialDays   = $trialActive ? Auth::user()->trial_ends_at->diffInDays(now()) : 0;
  @endphp
  @if(!$subActive && $trialActive)
  <div style="position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#1c2233;border:1px solid rgba(245,158,11,0.35);border-radius:12px;padding:12px 20px;z-index:999;display:flex;align-items:center;gap:12px;box-shadow:0 8px 32px rgba(0,0,0,0.4);white-space:nowrap;">
    <span style="font-size:0.85rem;color:#fbbf24;font-weight:700;">⏳ تجربة مجانية — باقي {{ $trialDays > 0 ? $trialDays.' يوم' : (Auth::user()->trial_ends_at->diffInHours(now()).' ساعة') }}</span>
    <button onclick="this.closest('[style*=fixed]').style.display='none';switchPageByName('plans')" style="padding:6px 14px;border-radius:8px;font-size:0.8rem;font-weight:800;font-family:inherit;cursor:pointer;border:none;background:#6366f1;color:#fff;">اشترك الآن</button>
  </div>
  @endif

  @if(Auth::user()->wa_disconnected)
  <div id="waDisconnectAlert" style="position:fixed;top:16px;left:50%;transform:translateX(-50%);background:#1c2233;border:1px solid rgba(239,68,68,0.4);border-radius:12px;padding:14px 20px;z-index:9998;display:flex;align-items:center;gap:14px;box-shadow:0 8px 32px rgba(0,0,0,0.5);max-width:520px;width:90%;">
    <span style="font-size:1.2rem;">⚠️</span>
    <div style="flex:1;">
      <div style="font-size:0.875rem;font-weight:800;color:#fca5a5;">انقطع اتصال الواتساب</div>
      <div style="font-size:0.78rem;color:#94a3b8;margin-top:2px;">تم قطع جلسة الواتساب الخاصة بك، يرجى إعادة الربط.</div>
    </div>
    <button onclick="document.getElementById('waDisconnectAlert').remove();window.location.href='/whatsapp';" style="padding:7px 14px;border-radius:8px;font-size:0.8rem;font-weight:800;font-family:inherit;cursor:pointer;border:none;background:#6366f1;color:#fff;white-space:nowrap;">إعادة الربط</button>
    <button onclick="document.getElementById('waDisconnectAlert').remove()" style="background:transparent;border:none;color:#64748b;cursor:pointer;font-size:1.1rem;padding:4px;">✕</button>
  </div>
  @endif

  <div id="mobOverlay" class="mob-overlay" onclick="closeSidebar()"></div>

  <div class="layout">

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <div class="brand-logo">
          <img src="logo.png" class="logo-img" alt="">
        </div>
        <span class="brand-name">Wayzon</span>
      </div>

      <div class="store-btn">
        <div class="store-ava">{{ mb_substr($store->store_name ?? auth()->user()->name ?? 'م', 0, 1) }}</div>
        <div class="store-info">
          <div class="store-name">{{ $store->store_name ?? auth()->user()->name }}</div>
          <div class="store-plan" style="color:{{ auth()->user()->planColor() }}">{{ auth()->user()->planLabel() }}</div>
        </div>
        <span class="store-chevron">▾</span>
      </div>

      <nav class="nav">
        <div class="nav-section">الرئيسية</div>
        <div class="nav-item active" data-page="dashboard" onclick="switchPage(this)">
          <span class="nav-icon">🏠</span> لوحة التحكم
        </div>

        <div class="nav-section">التشغيل</div>
        <div class="nav-item" data-page="orders" onclick="switchPage(this)">
          <span class="nav-icon">📦</span> الطلبات
        </div>
        <div class="nav-item" data-page="shipping" onclick="switchPage(this)">
          <span class="nav-icon">🚚</span> الشحن
        </div>
        <div class="nav-item" data-page="customers" onclick="switchPage(this)">
          <span class="nav-icon">👥</span> العملاء
        </div>
        <div class="nav-item" data-page="products" onclick="switchPage(this)">
          <span class="nav-icon">🛍️</span> المنتجات
        </div>

        <div class="nav-section">التحليل</div>
        <div class="nav-item" data-page="reports" onclick="switchPage(this)">
          <span class="nav-icon">📊</span> التقارير
        </div>

        <div class="nav-section">التسويق</div>
        <div class="nav-item" data-page="whatsapp" onclick="switchPage(this)">
          <span class="nav-icon">💬</span> واتساب
          <span class="nav-badge nb-primary" id="waNavBadge">جارٍ...</span>
        </div>
        <div class="nav-item" data-page="campaigns" onclick="switchPage(this)">
          <span class="nav-icon">📣</span> الحملات
        </div>
        <div class="nav-item" data-page="coupons" onclick="switchPage(this)">
          <span class="nav-icon">🏷️</span> الكوبونات
        </div>

        <div class="nav-section">إدارة السلة</div>
        <div class="nav-item" data-page="basket-orders" onclick="switchPage(this)">
          <span class="nav-icon">🛒</span> أوامر السلة
        </div>
        <div class="nav-item" data-page="order-ratings" onclick="switchPage(this)">
          <span class="nav-icon">⭐</span> طلب تقييم
        </div>
        <div class="nav-item" data-page="order-status" onclick="switchPage(this)">
          <span class="nav-icon">📊</span> حالات الطلب
        </div>

        <div class="nav-section">الذكاء الاصطناعي</div>
        <div class="nav-item" data-page="ai-training" onclick="switchPage(this)">
          <span class="nav-icon">🤖</span> تدريب الذكاء الاصطناعي
          <span class="nav-badge nb-green">نشط</span>
        </div>

        <div class="nav-section">الحساب</div>
        <div class="nav-item" data-page="templates" onclick="switchPage(this)">
          <span class="nav-icon">📋</span> إعدادات القوالب
        </div>
        <div class="nav-item" onclick="">
          <span class="nav-icon">🔌</span> التكاملات
        </div>
        <div class="nav-item" data-page="settings" onclick="switchPage(this)">
          <span class="nav-icon">⚙️</span> الإعدادات
        </div>
        <div class="nav-item" data-page="plans" onclick="switchPage(this)">
          <span class="nav-icon">💎</span> الخطط والأسعار
        </div>
      </nav>

      <div class="sidebar-foot">
        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;margin-bottom:8px;border-radius:10px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);color:#fbbf24;font-size:0.82rem;font-weight:800;text-decoration:none;">
          <span>⚡</span> لوحة الأدمن
        </a>
        @endif
        <div class="user-card">
          <div class="user-ava">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
          <div>
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-email">{{ auth()->user()->email }}</div>
          </div>
        </div>
      </div>
    </aside>

    <!-- ══ MAIN ══ -->
    <div class="main">
      <header class="topbar">
        <button class="icon-btn mob-toggle" id="mobToggle"
          onclick="toggleSidebar()" style="font-size:1.1rem;">☰</button>
        <h1 class="topbar-title" id="topbarTitle">لوحة التحكم</h1>
        <div class="search-box">
          <span>🔍</span>
          <span>بحث...</span>
          <kbd>⌘K</kbd>
        </div>
        <div style="display:flex;gap:8px;align-items:center;">
          <div class="icon-btn">🔔<span class="notif-dot"></span></div>
          <div class="icon-btn">✉️</div>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm">خروج</button>
          </form>
        </div>
      </header>

      <main class="content">

        <!-- ══════════════════ DASHBOARD ══════════════════ -->
        <div class="page active" id="page-dashboard">

          <div class="greeting">
            <div>
              <h2>صباح الخير، {{ Auth::user()->name }}! 👋</h2>
              <p>الجمعة، 11 أبريل 2025 — إليك ملخص متجرك اليوم</p>
            </div>
            <div class="greeting-actions">
              <button class="btn btn-ghost btn-sm">📥 تصدير</button>
              <button class="btn btn-primary btn-sm">+ طلب جديد</button>
            </div>
          </div>

          <!-- Stats -->
          <div class="stats-grid">
            <div class="stat-card s-indigo">
              <div class="stat-icon si-indigo">💰</div>
              <div class="stat-val">{{ number_format($monthlySales, 0) }}</div>
              <div class="stat-lbl">المبيعات هذا الشهر (ر.س)</div>
              <div style="display:flex;align-items:center;gap:5px;">
                <span class="stat-note">هذا الشهر</span>
              </div>
            </div>
            <div class="stat-card s-green">
              <div class="stat-icon si-green">📦</div>
              <div class="stat-val">{{ $monthlyOrders }}</div>
              <div class="stat-lbl">الطلبات هذا الشهر</div>
              <div style="display:flex;align-items:center;gap:5px;">
                <span class="stat-note">هذا الشهر</span>
              </div>
            </div>
            <div class="stat-card s-cyan">
              <div class="stat-icon si-cyan">👥</div>
              <div class="stat-val">{{ $totalCustomers }}</div>
              <div class="stat-lbl">إجمالي العملاء</div>
              <div style="display:flex;align-items:center;gap:5px;">
                <span class="stat-note">عملاء فريدين</span>
              </div>
            </div>
            <div class="stat-card s-amber">
              <div class="stat-icon si-amber">💬</div>
              <div class="stat-val">{{ $waSent }}</div>
              <div class="stat-lbl">رسائل واتساب أُرسلت</div>
              <div style="display:flex;align-items:center;gap:5px;">
                <span class="stat-note">إجمالي الرسائل</span>
              </div>
            </div>
          </div>

          <!-- Charts -->
          <div class="charts-row">
            <div class="chart-card">
              <div class="chart-top">
                <div>
                  <div class="chart-title">نمو المبيعات</div>
                  <div class="chart-sub">المبيعات اليومية لآخر 30 يوم</div>
                </div>
                <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                  <div class="legend">
                    <div class="leg-item">
                      <div class="leg-dot" style="background:#6366f1"></div>المبيعات
                    </div>
                    <div class="leg-item">
                      <div class="leg-dot" style="background:#10b981"></div>الطلبات
                    </div>
                  </div>
                  <div class="chart-tabs">
                    <button class="ctab">يوم</button>
                    <button class="ctab active">أسبوع</button>
                    <button class="ctab">شهر</button>
                  </div>
                </div>
              </div>
              <canvas id="salesChart"></canvas>
            </div>

            <div class="chart-card">
              <div class="chart-top">
                <div>
                  <div class="chart-title">فئات المنتجات</div>
                  <div class="chart-sub">توزيع المبيعات حسب الفئة</div>
                </div>
              </div>
              <div class="donut-wrap">
                <canvas id="categoryChart" style="max-height:150px;"></canvas>
                <div class="donut-center">
                  <div class="donut-num">348</div>
                  <div class="donut-lbl">طلب</div>
                </div>
              </div>
              <div class="cat-list">
                <div class="cat-item">
                  <div class="cat-dot" style="background:#6366f1"></div>
                  <span class="cat-name">ملابس</span>
                  <div class="cat-bar-bg">
                    <div class="cat-bar" style="width:42%;background:#6366f1"></div>
                  </div>
                  <span class="cat-pct">42%</span>
                </div>
                <div class="cat-item">
                  <div class="cat-dot" style="background:#10b981"></div>
                  <span class="cat-name">إكسسوارات</span>
                  <div class="cat-bar-bg">
                    <div class="cat-bar" style="width:28%;background:#10b981"></div>
                  </div>
                  <span class="cat-pct">28%</span>
                </div>
                <div class="cat-item">
                  <div class="cat-dot" style="background:#f59e0b"></div>
                  <span class="cat-name">أحذية</span>
                  <div class="cat-bar-bg">
                    <div class="cat-bar" style="width:18%;background:#f59e0b"></div>
                  </div>
                  <span class="cat-pct">18%</span>
                </div>
                <div class="cat-item">
                  <div class="cat-dot" style="background:#8b5cf6"></div>
                  <span class="cat-name">أخرى</span>
                  <div class="cat-bar-bg">
                    <div class="cat-bar" style="width:12%;background:#8b5cf6"></div>
                  </div>
                  <span class="cat-pct">12%</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom -->
          <div class="bottom-row">
            <div class="panel">
              <div class="panel-head">
                <span class="panel-title">📦 آخر الطلبات</span>
                <button class="btn btn-ghost btn-sm" onclick="switchPageByName('orders')">عرض الكل ←</button>
              </div>
              <table>
                <thead>
                  <tr>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
                    <th>المنتج</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                  @php
                    $initial = mb_substr($order->customer_name ?? 'ع', 0, 1);
                    $colors = ['linear-gradient(135deg,#6366f1,#8b5cf6)', 'linear-gradient(135deg,#06b6d4,#6366f1)', 'linear-gradient(135deg,#8b5cf6,#ec4899)', 'linear-gradient(135deg,#f59e0b,#ef4444)', 'linear-gradient(135deg,#10b981,#06b6d4)'];
                    $color = $colors[$loop->index % count($colors)];
                    $statusMap = [
                      'new'                => ['b-primary', '🆕 جديد'],
                      'in_progress'        => ['b-amber',   '🔄 قيد التنفيذ'],
                      'under_review'       => ['b-amber',   '⏳ بانتظار المراجعة'],
                      'pending_review'     => ['b-amber',   '⏳ بانتظار المراجعة'],
                      'pending_payment'    => ['b-amber',   '💳 بانتظار الدفع'],
                      'paid'               => ['b-primary', '✅ تم الدفع'],
                      'payment_confirmed'  => ['b-primary', '✅ تم الدفع'],
                      'shipped'            => ['b-amber',   '🚚 تم الشحن'],
                      'delivering'         => ['b-amber',   '🛵 جاري التوصيل'],
                      'out_for_delivery'   => ['b-amber',   '🛵 جاري التوصيل'],
                      'delivered'          => ['b-green',   '🎉 تم التوصيل'],
                      'canceled'           => ['b-red',     '❌ ملغي'],
                      'returned'           => ['b-red',     '🔁 مسترجع'],
                      'refunded'           => ['b-red',     '🔁 مسترجع'],
                      'under_return'       => ['b-amber',   '🔄 قيد الاسترجاع'],
                      'return_in_progress' => ['b-amber',   '🔄 قيد الاسترجاع'],
                      'pending_quote'      => ['b-primary', '📋 بانتظار عرض سعر'],
                      'pending_quotation'  => ['b-primary', '📋 بانتظار عرض سعر'],
                    ];
                    [$badgeClass, $badgeText] = $statusMap[$order->status] ?? ['b-primary', $order->status];
                    $orderNum = $order->reference_id ?: $order->salla_order_id;
                  @endphp
                  <tr>
                    <td><span class="order-id">#{{ $orderNum }}</span></td>
                    <td>
                      <div class="cust-cell">
                        <div class="cust-ava" style="background:{{ $color }}">{{ $initial }}</div>
                        {{ $order->customer_name ?? 'عميل' }}
                      </div>
                    </td>
                    <td>{{ $order->payment_method ?? '—' }}</td>
                    <td><span class="amount">{{ number_format($order->total, 0) }} ر.س</span></td>
                    <td><span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" style="text-align:center;color:var(--t3);padding:24px;">لا توجد طلبات بعد</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="panel">
              <div class="panel-head">
                <span class="panel-title">🔔 آخر التحديثات</span>
                <button class="btn btn-ghost btn-sm">الكل</button>
              </div>
              <div class="activity-list">
                <div class="act-item">
                  <div class="act-icon" style="background:var(--green-bg)">✅</div>
                  <div class="act-body">
                    <div class="act-msg">طلب <strong>#WZ-1094</strong> تم التسليم بنجاح</div>
                    <div class="act-time">منذ 5 دقائق</div>
                  </div>
                </div>
                <div class="act-item">
                  <div class="act-icon" style="background:rgba(99,102,241,0.15)">💬</div>
                  <div class="act-body">
                    <div class="act-msg">بوت واتساب أرسل تأكيد لـ <strong>سارة ع.</strong></div>
                    <div class="act-time">منذ 18 دقيقة</div>
                  </div>
                </div>
                <div class="act-item">
                  <div class="act-icon" style="background:var(--cyan-bg)">👤</div>
                  <div class="act-body">
                    <div class="act-msg">عميل جديد <strong>خالد ف.</strong> سجّل في المتجر</div>
                    <div class="act-time">منذ 32 دقيقة</div>
                  </div>
                </div>
                <div class="act-item">
                  <div class="act-icon" style="background:var(--amber-bg)">📣</div>
                  <div class="act-body">
                    <div class="act-msg">حملة "عروض الجمعة" أُرسلت لـ <strong>342 عميل</strong></div>
                    <div class="act-time">منذ ساعة</div>
                  </div>
                </div>
                <div class="act-item">
                  <div class="act-icon" style="background:var(--red-bg)">⚠️</div>
                  <div class="act-body">
                    <div class="act-msg">مخزون "حذاء رياضي" وصل للحد الأدنى <strong>(3 قطع)</strong></div>
                    <div class="act-time">منذ ساعتين</div>
                  </div>
                </div>
                <div class="act-item">
                  <div class="act-icon" style="background:var(--green-bg)">💰</div>
                  <div class="act-body">
                    <div class="act-msg">دفعة <strong>650 ر.س</strong> من منى ك.</div>
                    <div class="act-time">منذ 3 ساعات</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div><!-- /page-dashboard -->


        <!-- ══════════════════ ORDERS ══════════════════ -->
        <div class="page" id="page-orders">
          <div class="page-header">
            <div>
              <div class="page-h1">📦 الطلبات</div>
              <div class="page-sub">إجمالي {{ $orderCounts['all'] }} طلب</div>
            </div>
          </div>

          <div class="filter-bar">
            <button class="filter-tab active">الكل ({{ $orderCounts['all'] }})</button>
            <button class="filter-tab">جديد ({{ $orderCounts['new'] }})</button>
            <button class="filter-tab">قيد التوصيل ({{ $orderCounts['shipped'] }})</button>
            <button class="filter-tab">مكتمل ({{ $orderCounts['delivered'] }})</button>
            <button class="filter-tab">ملغي ({{ $orderCounts['canceled'] }})</button>
          </div>

          <div class="full-panel">
            <table>
              <thead>
                <tr>
                  <th>رقم الطلب</th>
                  <th>العميل</th>
                  <th>المبلغ</th>
                  <th>طريقة الدفع</th>
                  <th>تاريخ الطلب</th>
                  <th>الحالة</th>
                  <th>واتساب</th>
                </tr>
              </thead>
              <tbody>
                @forelse($allOrders as $order)
                @php
                  $initial = mb_substr($order->customer_name ?? 'ع', 0, 1);
                  $colors = ['linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#06b6d4,#6366f1)','linear-gradient(135deg,#8b5cf6,#ec4899)','linear-gradient(135deg,#f59e0b,#ef4444)','linear-gradient(135deg,#10b981,#06b6d4)'];
                  $color = $colors[$loop->index % count($colors)];
                  $statusMap = [
                    'new'                => ['b-primary', '🆕 جديد'],
                    'in_progress'        => ['b-amber',   '🔄 قيد التنفيذ'],
                    'under_review'       => ['b-amber',   '⏳ بانتظار المراجعة'],
                    'pending_review'     => ['b-amber',   '⏳ بانتظار المراجعة'],
                    'pending_payment'    => ['b-amber',   '💳 بانتظار الدفع'],
                    'paid'               => ['b-primary', '✅ تم الدفع'],
                    'payment_confirmed'  => ['b-primary', '✅ تم الدفع'],
                    'shipped'            => ['b-amber',   '🚚 تم الشحن'],
                    'delivering'         => ['b-amber',   '🛵 جاري التوصيل'],
                    'out_for_delivery'   => ['b-amber',   '🛵 جاري التوصيل'],
                    'delivered'          => ['b-green',   '🎉 تم التوصيل'],
                    'canceled'           => ['b-red',     '❌ ملغي'],
                    'returned'           => ['b-red',     '🔁 مسترجع'],
                    'refunded'           => ['b-red',     '🔁 مسترجع'],
                    'under_return'       => ['b-amber',   '🔄 قيد الاسترجاع'],
                    'return_in_progress' => ['b-amber',   '🔄 قيد الاسترجاع'],
                    'pending_quote'      => ['b-primary', '📋 بانتظار عرض سعر'],
                    'pending_quotation'  => ['b-primary', '📋 بانتظار عرض سعر'],
                  ];
                  [$badgeClass, $badgeText] = $statusMap[$order->status] ?? ['b-primary', $order->status];
                  $paymentMap = [
                    'cod'          => 'دفع عند التسليم',
                    'credit_card'  => 'بطاقة ائتمان',
                    'mada'         => 'مدى',
                    'apple_pay'    => 'Apple Pay',
                    'bank_transfer'=> 'تحويل بنكي',
                    'wallet'       => 'محفظة',
                    'tamara'       => 'تمارا',
                    'tabby'        => 'تابي',
                  ];
                  $paymentLabel = $paymentMap[$order->payment_method] ?? ($order->payment_method ?? '—');
                  $orderNum = $order->reference_id ?: $order->salla_order_id;
                @endphp
                <tr>
                  <td><span class="order-id">#{{ $orderNum }}</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:{{ $color }}">{{ $initial }}</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">{{ $order->customer_name ?? 'عميل' }}</div>
                        <div style="font-size:0.7rem;color:var(--t3);">{{ $order->customer_phone ?? '—' }}</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="amount">{{ number_format($order->total, 0) }} ر.س</span></td>
                  <td><span class="badge b-primary">{{ $paymentLabel }}</span></td>
                  <td style="font-size:0.78rem;">
                    {{ $order->created_at->format('d M Y') }}<br>
                    <span style="color:var(--t3);font-size:0.7rem;">{{ $order->created_at->format('h:i A') }}</span>
                  </td>
                  <td><span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></td>
                  <td>
                    @if($order->whatsapp_sent)
                      <span class="badge b-green">✓ أُرسل</span>
                    @else
                      <span class="badge b-red">✕ لم يُرسل</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" style="text-align:center;color:var(--t3);padding:32px;">لا توجد طلبات بعد</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            @if($allOrders->hasPages())
            <div style="display:flex;justify-content:center;gap:8px;padding:16px;">
              {{ $allOrders->links() }}
            </div>
            @endif
          </div>
        </div><!-- /page-orders -->


        <!-- ══════════════════ SHIPPING ══════════════════ -->
        <div class="page" id="page-shipping">
          <div class="page-header">
            <div>
              <div class="page-h1">🚚 الشحن والتوصيل</div>
              <div class="page-sub">متابعة كافة شحنات متجرك</div>
            </div>
            <button class="btn btn-primary btn-sm">+ شحنة جديدة</button>
          </div>

          <!-- Shipping stats -->
          <div class="shipping-cards">
            <div class="ship-stat" style="border-right:3px solid var(--amber);">
              <div class="ship-stat-val" style="color:var(--amber)">87</div>
              <div class="ship-stat-lbl">🚚 قيد التوصيل</div>
            </div>
            <div class="ship-stat" style="border-right:3px solid var(--green);">
              <div class="ship-stat-val" style="color:var(--green)">224</div>
              <div class="ship-stat-lbl">✅ مكتملة</div>
            </div>
            <div class="ship-stat" style="border-right:3px solid var(--red);">
              <div class="ship-stat-val" style="color:var(--red)">12</div>
              <div class="ship-stat-lbl">⚠️ مشكلة في التوصيل</div>
            </div>
          </div>

          <!-- Track card -->
          <div class="track-card">
            <div class="track-header">
              <div>
                <div style="font-size:0.9375rem;font-weight:800;color:var(--t1);">تتبع الشحنة #SHP-0447</div>
                <div style="font-size:0.78rem;color:var(--t3);margin-top:3px;">رقم التتبع: SA1234567890 — أرامكس</div>
              </div>
              <span class="badge b-amber">🚚 في الطريق</span>
            </div>
            <div class="track-steps">
              <div class="track-step">
                <div class="step-circle done">✓</div>
                <div class="step-line done"></div>
              </div>
              <div class="track-step">
                <div class="step-circle done">✓</div>
                <div class="step-line done"></div>
              </div>
              <div class="track-step">
                <div class="step-circle active">🚚</div>
                <div class="step-line"></div>
              </div>
              <div class="track-step" style="flex:0;">
                <div class="step-circle">📦</div>
              </div>
            </div>
            <div class="step-labels">
              <span class="step-lbl done">تأكيد الطلب</span>
              <span class="step-lbl done">جهّز للشحن</span>
              <span class="step-lbl active">في الطريق</span>
              <span class="step-lbl">تم التسليم</span>
            </div>
          </div>

          <!-- Shipping table -->
          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">جميع الشحنات</span>
              <button class="btn btn-ghost btn-sm">📥 تصدير</button>
            </div>
            <table>
              <thead>
                <tr>
                  <th>رقم الشحنة</th>
                  <th>العميل</th>
                  <th>العنوان</th>
                  <th>شركة الشحن</th>
                  <th>رقم التتبع</th>
                  <th>المبلغ</th>
                  <th>الحالة</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="order-id">#SHP-0447</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>سارة ع.
                    </div>
                  </td>
                  <td style="font-size:0.78rem;">الرياض، حي العليا<br><span style="color:var(--t3);">الشارع الرئيسي
                      45</span></td>
                  <td>أرامكس</td>
                  <td style="font-family:monospace;font-size:0.78rem;">SA1234567890</td>
                  <td><span class="amount">178 ر.س</span></td>
                  <td><span class="badge b-amber">🚚 في الطريق</span></td>
                </tr>
                <tr>
                  <td><span class="order-id">#SHP-0446</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>أحمد م.
                    </div>
                  </td>
                  <td style="font-size:0.78rem;">جدة، حي الزهراء<br><span style="color:var(--t3);">شارع التحلية
                      12</span></td>
                  <td>SMSA</td>
                  <td style="font-family:monospace;font-size:0.78rem;">JD9876543210</td>
                  <td><span class="amount">285 ر.س</span></td>
                  <td><span class="badge b-green">✓ تم التسليم</span></td>
                </tr>
                <tr>
                  <td><span class="order-id">#SHP-0445</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>منى ك.
                    </div>
                  </td>
                  <td style="font-size:0.78rem;">مكة المكرمة، العزيزية<br><span style="color:var(--t3);">طريق مكة قديم
                      8</span></td>
                  <td>درب</td>
                  <td style="font-family:monospace;font-size:0.78rem;">MK5551234000</td>
                  <td><span class="amount">650 ر.س</span></td>
                  <td><span class="badge b-green">✓ تم التسليم</span></td>
                </tr>
                <tr>
                  <td><span class="order-id">#SHP-0444</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">خ</div>خالد ف.
                    </div>
                  </td>
                  <td style="font-size:0.78rem;">الدمام، حي الفيصلية<br><span style="color:var(--t3);">شارع الملك فهد
                      3</span></td>
                  <td>أرامكس</td>
                  <td style="font-family:monospace;font-size:0.78rem;">DM1122334455</td>
                  <td><span class="amount">420 ر.س</span></td>
                  <td><span class="badge b-primary">📦 جهّز للشحن</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- /page-shipping -->


        <!-- ══════════════════ CUSTOMERS ══════════════════ -->
        <div class="page" id="page-customers">
          <div class="page-header">
            <div>
              <div class="page-h1">👥 العملاء</div>
              <div class="page-sub">1,204 عميل مسجل</div>
            </div>
            <button class="btn btn-primary btn-sm">+ إضافة عميل</button>
          </div>

          <!-- Top customers -->
          <div
            style="font-size:0.8rem;font-weight:800;color:var(--t3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">
            أفضل العملاء</div>
          <div class="customers-grid">
            <div class="cust-card">
              <div class="cust-card-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>
              <div class="cust-card-info">
                <div class="cust-card-name">منى كريم</div>
                <div class="cust-card-meta">+966504567890 · الرياض</div>
                <div style="margin-top:6px;"><span class="badge b-green">عميل VIP</span></div>
              </div>
              <div class="cust-card-stat">
                <div class="cust-card-orders">18</div>
                <div class="cust-card-slbl">طلب</div>
                <div style="font-size:0.75rem;font-weight:800;color:var(--primary);margin-top:4px;">3,420 ر.س</div>
              </div>
            </div>
            <div class="cust-card">
              <div class="cust-card-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>
              <div class="cust-card-info">
                <div class="cust-card-name">أحمد محمد</div>
                <div class="cust-card-meta">+966501234567 · جدة</div>
                <div style="margin-top:6px;"><span class="badge b-primary">دائم</span></div>
              </div>
              <div class="cust-card-stat">
                <div class="cust-card-orders">14</div>
                <div class="cust-card-slbl">طلب</div>
                <div style="font-size:0.75rem;font-weight:800;color:var(--primary);margin-top:4px;">2,840 ر.س</div>
              </div>
            </div>
            <div class="cust-card">
              <div class="cust-card-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>
              <div class="cust-card-info">
                <div class="cust-card-name">سارة العمر</div>
                <div class="cust-card-meta">+966502345678 · مكة</div>
                <div style="margin-top:6px;"><span class="badge b-cyan">نشط</span></div>
              </div>
              <div class="cust-card-stat">
                <div class="cust-card-orders">11</div>
                <div class="cust-card-slbl">طلب</div>
                <div style="font-size:0.75rem;font-weight:800;color:var(--primary);margin-top:4px;">1,960 ر.س</div>
              </div>
            </div>
          </div>

          <!-- All customers table -->
          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">جميع العملاء</span>
              <div style="display:flex;gap:8px;">
                <button class="btn btn-ghost btn-sm">🔍 بحث</button>
                <button class="btn btn-ghost btn-sm">📥 تصدير</button>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <th>العميل</th>
                  <th>رقم الجوال</th>
                  <th>المدينة</th>
                  <th>عدد الطلبات</th>
                  <th>إجمالي الشراء</th>
                  <th>آخر طلب</th>
                  <th>الحالة</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>
                      <div>
                        <div style="color:var(--t1);font-weight:700;font-size:0.83rem;">منى كريم</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-family:monospace;font-size:0.8rem;">+966504567890</td>
                  <td>الرياض</td>
                  <td style="font-weight:800;color:var(--t1);">18</td>
                  <td><span class="amount">3,420 ر.س</span></td>
                  <td style="font-size:0.78rem;">11 أبريل</td>
                  <td><span class="badge b-green">VIP</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>
                      <div>
                        <div style="color:var(--t1);font-weight:700;font-size:0.83rem;">أحمد محمد</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-family:monospace;font-size:0.8rem;">+966501234567</td>
                  <td>جدة</td>
                  <td style="font-weight:800;color:var(--t1);">14</td>
                  <td><span class="amount">2,840 ر.س</span></td>
                  <td style="font-size:0.78rem;">11 أبريل</td>
                  <td><span class="badge b-primary">دائم</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>
                      <div>
                        <div style="color:var(--t1);font-weight:700;font-size:0.83rem;">سارة العمر</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-family:monospace;font-size:0.8rem;">+966502345678</td>
                  <td>مكة</td>
                  <td style="font-weight:800;color:var(--t1);">11</td>
                  <td><span class="amount">1,960 ر.س</span></td>
                  <td style="font-size:0.78rem;">10 أبريل</td>
                  <td><span class="badge b-cyan">نشط</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">خ</div>
                      <div>
                        <div style="color:var(--t1);font-weight:700;font-size:0.83rem;">خالد الفارس</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-family:monospace;font-size:0.8rem;">+966503456789</td>
                  <td>الدمام</td>
                  <td style="font-weight:800;color:var(--t1);">7</td>
                  <td><span class="amount">1,120 ر.س</span></td>
                  <td style="font-size:0.78rem;">10 أبريل</td>
                  <td><span class="badge b-amber">جديد</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#10b981,#06b6d4)">ر</div>
                      <div>
                        <div style="color:var(--t1);font-weight:700;font-size:0.83rem;">ريم طارق</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-family:monospace;font-size:0.8rem;">+966505678901</td>
                  <td>المدينة</td>
                  <td style="font-weight:800;color:var(--t1);">3</td>
                  <td><span class="amount">590 ر.س</span></td>
                  <td style="font-size:0.78rem;">09 أبريل</td>
                  <td><span class="badge b-red">غير نشط</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- /page-customers -->


        <!-- ══════════════════ PRODUCTS ══════════════════ -->
        <div class="page" id="page-products">
          <div class="page-header">
            <div>
              <div class="page-h1">🛍️ المنتجات</div>
              <div class="page-sub">86 منتج نشط · يتجدد يومياً</div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="btn btn-ghost btn-sm">📥 استيراد</button>
              <button class="btn btn-primary btn-sm">+ منتج جديد</button>
            </div>
          </div>

          <div class="filter-bar">
            <button class="filter-tab active">الكل (86)</button>
            <button class="filter-tab">ملابس (36)</button>
            <button class="filter-tab">إكسسوارات (24)</button>
            <button class="filter-tab">أحذية (16)</button>
            <button class="filter-tab">مخزون منخفض (4)</button>
          </div>

          <div class="products-grid">
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(99,102,241,0.08);">👗</div>
              <div class="prod-body">
                <div class="prod-name">فستان سواريه</div>
                <div class="prod-cat">ملابس · M / L / XL</div>
                <div class="prod-foot">
                  <span class="prod-price">285 ر.س</span>
                  <span class="prod-stock ok">✓ 24 قطعة</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(16,185,129,0.08);">👝</div>
              <div class="prod-body">
                <div class="prod-name">حقيبة جلدية</div>
                <div class="prod-cat">إكسسوارات · أسود / بني</div>
                <div class="prod-foot">
                  <span class="prod-price">420 ر.س</span>
                  <span class="prod-stock ok">✓ 15 قطعة</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(245,158,11,0.08);">👟</div>
              <div class="prod-body">
                <div class="prod-name">حذاء رياضي</div>
                <div class="prod-cat">أحذية · 38-44</div>
                <div class="prod-foot">
                  <span class="prod-price">195 ر.س</span>
                  <span class="prod-stock low">⚠ 3 قطع فقط</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(139,92,246,0.08);">👘</div>
              <div class="prod-body">
                <div class="prod-name">طقم عباية</div>
                <div class="prod-cat">ملابس · S / M / L</div>
                <div class="prod-foot">
                  <span class="prod-price">650 ر.س</span>
                  <span class="prod-stock ok">✓ 18 قطعة</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(6,182,212,0.08);">👚</div>
              <div class="prod-body">
                <div class="prod-name">بلوزة كاجوال</div>
                <div class="prod-cat">ملابس · XS / S / M</div>
                <div class="prod-foot">
                  <span class="prod-price">89 ر.س</span>
                  <span class="prod-stock ok">✓ 42 قطعة</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(239,68,68,0.08);">💍</div>
              <div class="prod-body">
                <div class="prod-name">طقم إكسسوار ذهبي</div>
                <div class="prod-cat">إكسسوارات · واحد مقاس</div>
                <div class="prod-foot">
                  <span class="prod-price">320 ر.س</span>
                  <span class="prod-stock low">⚠ 2 قطعة فقط</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(16,185,129,0.08);">👒</div>
              <div class="prod-body">
                <div class="prod-name">قبعة صيفية</div>
                <div class="prod-cat">إكسسوارات · M / L</div>
                <div class="prod-foot">
                  <span class="prod-price">75 ر.س</span>
                  <span class="prod-stock ok">✓ 30 قطعة</span>
                </div>
              </div>
            </div>
            <div class="prod-card">
              <div class="prod-img" style="background:rgba(99,102,241,0.08);">👛</div>
              <div class="prod-body">
                <div class="prod-name">محفظة نسائية</div>
                <div class="prod-cat">إكسسوارات · وردي / بيج</div>
                <div class="prod-foot">
                  <span class="prod-price">140 ر.س</span>
                  <span class="prod-stock ok">✓ 20 قطعة</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /page-products -->


        <!-- ══════════════════ REPORTS ══════════════════ -->
        <div class="page" id="page-reports">
          <div class="page-header">
            <div>
              <div class="page-h1">📊 التقارير والإحصاءات</div>
              <div class="page-sub">تحليل أداء المتجر</div>
            </div>
            <button class="btn btn-ghost btn-sm">📥 تصدير التقرير</button>
          </div>

          <div class="reports-grid">
            <div class="chart-card">
              <div class="chart-top">
                <div>
                  <div class="chart-title">المبيعات الأسبوعية</div>
                  <div class="chart-sub">آخر 7 أسابيع</div>
                </div>
              </div>
              <canvas id="reportWeekly"></canvas>
            </div>
            <div class="chart-card">
              <div class="chart-top">
                <div>
                  <div class="chart-title">مصادر الطلبات</div>
                  <div class="chart-sub">القناة التسويقية</div>
                </div>
              </div>
              <canvas id="reportSource"></canvas>
            </div>
          </div>

          <div class="stats-grid" style="margin-top:0;">
            <div class="stat-card s-indigo">
              <div class="stat-icon si-indigo">📈</div>
              <div class="stat-val">23%</div>
              <div class="stat-lbl">نمو المبيعات أسبوعياً</div>
              <span class="stat-change ch-up">↑ أفضل أسبوع</span>
            </div>
            <div class="stat-card s-green">
              <div class="stat-icon si-green">🔄</div>
              <div class="stat-val">68%</div>
              <div class="stat-lbl">معدل عودة العملاء</div>
              <span class="stat-change ch-up">↑ جيد جداً</span>
            </div>
            <div class="stat-card s-cyan">
              <div class="stat-icon si-cyan">💸</div>
              <div class="stat-val">71 ر.س</div>
              <div class="stat-lbl">متوسط قيمة الطلب</div>
              <span class="stat-change ch-up">↑ 5.3%</span>
            </div>
            <div class="stat-card s-amber">
              <div class="stat-icon si-amber">🛒</div>
              <div class="stat-val">2.4%</div>
              <div class="stat-lbl">معدل التحويل</div>
              <span class="stat-change ch-down">↓ 0.2%</span>
            </div>
          </div>
        </div><!-- /page-reports -->


        <!-- ══════════════════ WHATSAPP ══════════════════ -->
        <div class="page" id="page-whatsapp">
          <div class="page-header">
            <div>
              <div class="page-h1">💬 واتساب</div>
              <div class="page-sub">ربط الواتساب وإدارة الجلسات والرسائل</div>
            </div>
            <a href="{{ route('whatsapp') }}" id="waConnectBtn" class="btn btn-primary btn-sm" style="display:none;">🔗 ربط جهاز</a>
          </div>

          <!-- Connection status (dynamic) -->
          <div class="wa-status-bar" id="waStatusBar">
            <div class="wa-dot" id="waStatusDot" style="background:var(--amber)"></div>
            <span class="wa-status-txt" id="waStatusTxt">جارٍ التحقق...</span>
            <span class="wa-status-num" id="waStatusNum"></span>
            <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;display:none;" id="waDisconnectBtn" onclick="dashboardDisconnectWA()">قطع الاتصال</button>
          </div>

          <div class="wa-grid">
            <!-- Left: placeholder (settings moved to page-templates) -->
            <div></div>

            <!-- Right: Sessions -->
            <div>
              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">🗂️ الجلسات النشطة</span>
                  <span class="badge b-green">12 نشط</span>
                </div>
                <div>
                  <div class="session-item">
                    <div class="sess-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>
                    <div>
                      <div class="sess-name">منى كريم</div>
                      <div class="sess-last">هل يوجد المقاس L؟</div>
                    </div>
                    <span class="sess-time">الآن</span>
                    <span class="sess-status ss-active">نشط</span>
                  </div>
                  <div class="session-item">
                    <div class="sess-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>
                    <div>
                      <div class="sess-name">أحمد محمد</div>
                      <div class="sess-last">متى يصل الطلب؟</div>
                    </div>
                    <span class="sess-time">دقيقتان</span>
                    <span class="sess-status ss-active">نشط</span>
                  </div>
                  <div class="session-item">
                    <div class="sess-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>
                    <div>
                      <div class="sess-name">سارة العمر</div>
                      <div class="sess-last">شكراً على المتابعة</div>
                    </div>
                    <span class="sess-time">15 د</span>
                    <span class="sess-status ss-idle">خامل</span>
                  </div>
                  <div class="session-item">
                    <div class="sess-ava" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">خ</div>
                    <div>
                      <div class="sess-name">خالد الفارس</div>
                      <div class="sess-last">أريد إلغاء الطلب</div>
                    </div>
                    <span class="sess-time">22 د</span>
                    <span class="sess-status ss-active">نشط</span>
                  </div>
                  <div class="session-item">
                    <div class="sess-ava" style="background:linear-gradient(135deg,#10b981,#06b6d4)">ر</div>
                    <div>
                      <div class="sess-name">ريم طارق</div>
                      <div class="sess-last">هل يوجد توصيل لـ MED؟</div>
                    </div>
                    <span class="sess-time">1 س</span>
                    <span class="sess-status ss-idle">خامل</span>
                  </div>
                </div>
              </div>

              <!-- Campaigns quick card -->
              <div class="full-panel" style="margin-top:14px;">
                <div class="panel-head">
                  <span class="panel-title">📣 الرسائل الجماعية</span>
                  <button class="btn btn-primary btn-sm" style="font-size:0.72rem;">+ إنشاء حملة</button>
                </div>
                <div style="padding:14px 18px;">
                  <div class="act-item" style="padding:8px 0;border-bottom:1px solid var(--border);">
                    <div class="act-icon" style="background:var(--green-bg)">✅</div>
                    <div class="act-body">
                      <div class="act-msg">حملة "عروض الجمعة" — <strong>342 عميل</strong></div>
                      <div class="act-time">مكتملة · منذ ساعة</div>
                    </div>
                  </div>
                  <div class="act-item" style="padding:8px 0;">
                    <div class="act-icon" style="background:var(--amber-bg)">⏳</div>
                    <div class="act-body">
                      <div class="act-msg">حملة "منتجات جديدة" — <strong>جدولة: غداً 9 ص</strong></div>
                      <div class="act-time">مجدولة</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /page-whatsapp -->


        <!-- ══════════════════ BASKET ORDERS ══════════════════ -->
        <div class="page" id="page-basket-orders">
          <div class="page-header">
            <div>
              <div class="page-h1">🛒 أوامر السلة</div>
              <div class="page-sub">إدارة طلبات السلة وإرسال الأوامر للعملاء</div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="btn btn-ghost btn-sm">📥 تصدير</button>
              <button class="btn btn-primary btn-sm">+ أمر جديد</button>
            </div>
          </div>

          <!-- Stats -->
          <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:20px;">
            <div class="stat-card s-indigo">
              <div class="stat-icon si-indigo">🛒</div>
              <div class="stat-val">8</div>
              <div class="stat-lbl">سلات نشطة</div>
              <span class="stat-change ch-up">↑ جديد اليوم</span>
            </div>
            <div class="stat-card s-amber">
              <div class="stat-icon si-amber">⏳</div>
              <div class="stat-val">23</div>
              <div class="stat-lbl">سلات متروكة</div>
              <span class="stat-change ch-down">↑ 3 اليوم</span>
            </div>
            <div class="stat-card s-green">
              <div class="stat-icon si-green">✅</div>
              <div class="stat-val">142</div>
              <div class="stat-lbl">تم تحويلها لطلبات</div>
              <span class="stat-change ch-up">↑ 18%</span>
            </div>
            <div class="stat-card s-cyan">
              <div class="stat-icon si-cyan">💰</div>
              <div class="stat-val">4,820</div>
              <div class="stat-lbl">قيمة السلات النشطة (ر.س)</div>
              <span class="stat-change ch-up">↑ 7.4%</span>
            </div>
          </div>

          <!-- Filter -->
          <div class="filter-bar">
            <button class="filter-tab active">الكل (173)</button>
            <button class="filter-tab">نشطة (8)</button>
            <button class="filter-tab">متروكة (23)</button>
            <button class="filter-tab">أُرسل تذكير (41)</button>
            <button class="filter-tab">تحولت لطلب (142) ✓</button>
          </div>

          <!-- Basket orders table -->
          <div class="full-panel">
            <table>
              <thead>
                <tr>
                  <th>رقم السلة</th>
                  <th>العميل</th>
                  <th>المنتجات</th>
                  <th>قيمة السلة</th>
                  <th>وقت الإنشاء</th>
                  <th>حالة السلة</th>
                  <th>إرسال أمر</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="order-id">#CART-081</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">منى كريم</div>
                        <div style="font-size:0.7rem;color:var(--t3);">+966504567890</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size:0.8rem;color:var(--t1);">فستان سواريه × 1</div>
                    <div style="font-size:0.72rem;color:var(--t3);">حقيبة جلدية × 1</div>
                  </td>
                  <td><span class="amount">705 ر.س</span></td>
                  <td style="font-size:0.78rem;">منذ 12 دقيقة</td>
                  <td><span class="badge b-primary">🛒 نشطة</span></td>
                  <td>
                    <div style="display:flex;gap:6px;">
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;"
                        onclick="sendOrder(this,'#CART-081')">📤 إرسال</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#CART-080</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">أحمد محمد</div>
                        <div style="font-size:0.7rem;color:var(--t3);">+966501234567</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size:0.8rem;color:var(--t1);">حذاء رياضي × 2</div>
                  </td>
                  <td><span class="amount">390 ر.س</span></td>
                  <td style="font-size:0.78rem;">منذ 34 دقيقة</td>
                  <td><span class="badge b-amber">⏳ متروكة</span></td>
                  <td>
                    <div style="display:flex;gap:6px;">
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;"
                        onclick="sendOrder(this,'#CART-080')">📤 إرسال</button>
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;color:var(--amber);">💬
                        تذكير</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#CART-079</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">سارة العمر</div>
                        <div style="font-size:0.7rem;color:var(--t3);">+966502345678</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size:0.8rem;color:var(--t1);">طقم عباية × 1</div>
                    <div style="font-size:0.72rem;color:var(--t3);">قبعة صيفية × 1</div>
                  </td>
                  <td><span class="amount">725 ر.س</span></td>
                  <td style="font-size:0.78rem;">منذ ساعتين</td>
                  <td><span class="badge b-amber">⏳ متروكة</span></td>
                  <td>
                    <div style="display:flex;gap:6px;">
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;"
                        onclick="sendOrder(this,'#CART-079')">📤 إرسال</button>
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;color:var(--amber);">💬
                        تذكير</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#CART-078</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">خ</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">خالد الفارس</div>
                        <div style="font-size:0.7rem;color:var(--t3);">+966503456789</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size:0.8rem;color:var(--t1);">بلوزة كاجوال × 3</div>
                  </td>
                  <td><span class="amount">267 ر.س</span></td>
                  <td style="font-size:0.78rem;">منذ 3 ساعات</td>
                  <td><span class="badge b-green">✓ تحول لطلب</span></td>
                  <td>
                    <span style="font-size:0.78rem;color:var(--green);">✓ #WZ-1092</span>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#CART-077</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#10b981,#06b6d4)">ر</div>
                      <div>
                        <div style="color:var(--t1);font-weight:600;font-size:0.83rem;">ريم طارق</div>
                        <div style="font-size:0.7rem;color:var(--t3);">+966505678901</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size:0.8rem;color:var(--t1);">محفظة نسائية × 1</div>
                    <div style="font-size:0.72rem;color:var(--t3);">طقم إكسسوار × 1</div>
                  </td>
                  <td><span class="amount">460 ر.س</span></td>
                  <td style="font-size:0.78rem;">منذ 4 ساعات</td>
                  <td><span class="badge b-cyan">📤 أُرسل تذكير</span></td>
                  <td>
                    <div style="display:flex;gap:6px;">
                      <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;"
                        onclick="sendOrder(this,'#CART-077')">📤 إرسال</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Quick send order modal-like panel -->
          <div id="orderSentAlert"
            style="display:none;position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#1a2535;border:1px solid var(--green);border-radius:12px;padding:14px 24px;z-index:999;display:none;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(0,0,0,0.5);">
            <span style="font-size:1.2rem;">✅</span>
            <span id="orderSentMsg" style="font-size:0.875rem;color:var(--t1);font-weight:700;"></span>
          </div>
        </div><!-- /page-basket-orders -->


        <!-- ══════════════════ ORDER RATINGS ══════════════════ -->
        <div class="page" id="page-order-ratings">
          <div class="page-header">
            <div>
              <div class="page-h1">⭐ طلب تقييم</div>
              <div class="page-sub">إرسال طلبات التقييم للعملاء بعد استلام الطلبات</div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="btn btn-ghost btn-sm">📥 تصدير</button>
              <button class="btn btn-primary btn-sm" onclick="sendRatingBlast()">📤 إرسال دفعي</button>
            </div>
          </div>

          <!-- Stats -->
          <div class="stats-grid" style="margin-bottom:20px;">
            <div class="stat-card s-green">
              <div class="stat-icon si-green">⭐</div>
              <div class="stat-val">4.8</div>
              <div class="stat-lbl">متوسط التقييم</div>
              <span class="stat-change ch-up">↑ ممتاز</span>
            </div>
            <div class="stat-card s-indigo">
              <div class="stat-icon si-indigo">📤</div>
              <div class="stat-val">186</div>
              <div class="stat-lbl">طلبات تقييم أُرسلت</div>
              <span class="stat-change ch-up">↑ هذا الشهر</span>
            </div>
            <div class="stat-card s-cyan">
              <div class="stat-icon si-cyan">💬</div>
              <div class="stat-val">124</div>
              <div class="stat-lbl">تقييمات مستلمة</div>
              <span class="stat-change ch-up">67% نسبة الرد</span>
            </div>
            <div class="stat-card s-amber">
              <div class="stat-icon si-amber">⏳</div>
              <div class="stat-val">62</div>
              <div class="stat-lbl">بانتظار التقييم</div>
              <span class="stat-change ch-down">لم يردوا بعد</span>
            </div>
          </div>

          <!-- Rating config card -->
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
            <div class="full-panel">
              <div class="panel-head"><span class="panel-title">⚙️ إعدادات الإرسال التلقائي</span></div>
              <div style="padding:18px 20px;">
                <div class="wa-toggle-row">
                  <div>
                    <div class="wa-toggle-txt">إرسال تلقائي بعد التسليم</div>
                    <div class="wa-toggle-sub">يُرسل طلب التقييم تلقائياً بعد تأكيد التسليم</div>
                  </div>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div class="wa-toggle-row">
                  <div>
                    <div class="wa-toggle-txt">إرسال مكافأة مع التقييم</div>
                    <div class="wa-toggle-sub">كوبون خصم 10% عند إتمام التقييم</div>
                  </div>
                  <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div class="wa-form-group" style="margin-top:14px;">
                  <label class="wa-label">⏱️ وقت الإرسال بعد التسليم</label>
                  <select class="wa-input">
                    <option>بعد 24 ساعة</option>
                    <option selected>بعد 3 أيام</option>
                    <option>بعد أسبوع</option>
                  </select>
                </div>
                <div class="wa-form-group">
                  <label class="wa-label">📝 نص رسالة التقييم</label>
                  <textarea class="wa-input wa-textarea">أهلاً @{{customer_name}} ⭐
وصل طلبك بنجاح! نتمنى رضاك.
يسعدنا لو شاركتنا رأيك:
@{{rating_link}}
شكراً لثقتك بنا 💙</textarea>
                </div>
                <button class="btn btn-primary" style="width:100%;" onclick="saveTemplates()">💾 حفظ الإعدادات</button>
              </div>
            </div>

            <div class="full-panel">
              <div class="panel-head"><span class="panel-title">📊 توزيع التقييمات</span></div>
              <div style="padding:18px 20px;">
                <div style="display:flex;flex-direction:column;gap:10px;">
                  <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:0.8rem;color:var(--t1);min-width:24px;">⭐5</span>
                    <div style="flex:1;height:8px;background:rgba(255,255,255,0.06);border-radius:9px;overflow:hidden;">
                      <div style="width:68%;height:100%;background:var(--green);border-radius:9px;"></div>
                    </div>
                    <span style="font-size:0.75rem;font-weight:800;color:var(--t1);min-width:32px;">68%</span>
                  </div>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:0.8rem;color:var(--t1);min-width:24px;">⭐4</span>
                    <div style="flex:1;height:8px;background:rgba(255,255,255,0.06);border-radius:9px;overflow:hidden;">
                      <div style="width:20%;height:100%;background:#10b981;border-radius:9px;"></div>
                    </div>
                    <span style="font-size:0.75rem;font-weight:800;color:var(--t1);min-width:32px;">20%</span>
                  </div>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:0.8rem;color:var(--t1);min-width:24px;">⭐3</span>
                    <div style="flex:1;height:8px;background:rgba(255,255,255,0.06);border-radius:9px;overflow:hidden;">
                      <div style="width:7%;height:100%;background:var(--amber);border-radius:9px;"></div>
                    </div>
                    <span style="font-size:0.75rem;font-weight:800;color:var(--t1);min-width:32px;">7%</span>
                  </div>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:0.8rem;color:var(--t1);min-width:24px;">⭐2</span>
                    <div style="flex:1;height:8px;background:rgba(255,255,255,0.06);border-radius:9px;overflow:hidden;">
                      <div style="width:3%;height:100%;background:var(--red);border-radius:9px;"></div>
                    </div>
                    <span style="font-size:0.75rem;font-weight:800;color:var(--t1);min-width:32px;">3%</span>
                  </div>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:0.8rem;color:var(--t1);min-width:24px;">⭐1</span>
                    <div style="flex:1;height:8px;background:rgba(255,255,255,0.06);border-radius:9px;overflow:hidden;">
                      <div style="width:2%;height:100%;background:var(--red);border-radius:9px;"></div>
                    </div>
                    <span style="font-size:0.75rem;font-weight:800;color:var(--t1);min-width:32px;">2%</span>
                  </div>
                </div>
                <div
                  style="margin-top:18px;padding:14px;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);border-radius:var(--r);text-align:center;">
                  <div style="font-size:2rem;font-weight:900;color:var(--t1);">4.8</div>
                  <div style="color:var(--green);font-size:0.875rem;font-weight:700;">⭐⭐⭐⭐⭐ ممتاز</div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-top:4px;">من 124 تقييم</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Ratings table -->
          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">📋 سجل طلبات التقييم</span>
              <div class="filter-bar" style="margin:0;gap:6px;">
                <button class="filter-tab active" style="padding:4px 10px;font-size:0.72rem;">الكل</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">✅ تم التقييم</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">⏳ بانتظار</button>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <th>رقم الطلب</th>
                  <th>العميل</th>
                  <th>المنتج</th>
                  <th>تاريخ الإرسال</th>
                  <th>التقييم</th>
                  <th>الحالة</th>
                  <th>إجراء</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="order-id">#WZ-1094</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>أحمد م.
                    </div>
                  </td>
                  <td>فستان سواريه</td>
                  <td style="font-size:0.78rem;">11 أبريل 2025</td>
                  <td><span style="color:var(--amber);font-size:1rem;">⭐⭐⭐⭐⭐</span></td>
                  <td><span class="badge b-green">✓ تم التقييم</span></td>
                  <td><button class="btn btn-ghost btn-sm" style="font-size:0.72rem;">عرض</button></td>
                </tr>
                <tr>
                  <td><span class="order-id">#WZ-1093</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>سارة ع.
                    </div>
                  </td>
                  <td>بلوزة كاجوال</td>
                  <td style="font-size:0.78rem;">10 أبريل 2025</td>
                  <td style="color:var(--t3);font-size:0.78rem;">—</td>
                  <td><span class="badge b-amber">⏳ بانتظار</span></td>
                  <td><button class="btn btn-ghost btn-sm" style="font-size:0.72rem;" onclick="resendRating(this)">📤
                      إعادة إرسال</button></td>
                </tr>
                <tr>
                  <td><span class="order-id">#WZ-1091</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">م</div>منى ك.
                    </div>
                  </td>
                  <td>طقم عباية</td>
                  <td style="font-size:0.78rem;">10 أبريل 2025</td>
                  <td><span style="color:var(--amber);font-size:1rem;">⭐⭐⭐⭐</span></td>
                  <td><span class="badge b-green">✓ تم التقييم</span></td>
                  <td><button class="btn btn-ghost btn-sm" style="font-size:0.72rem;">عرض</button></td>
                </tr>
                <tr>
                  <td><span class="order-id">#WZ-1089</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#10b981,#06b6d4)">ر</div>ريم ط.
                    </div>
                  </td>
                  <td>حذاء رياضي</td>
                  <td style="font-size:0.78rem;">09 أبريل 2025</td>
                  <td style="color:var(--t3);font-size:0.78rem;">—</td>
                  <td><span class="badge b-amber">⏳ بانتظار</span></td>
                  <td><button class="btn btn-ghost btn-sm" style="font-size:0.72rem;" onclick="resendRating(this)">📤
                      إعادة إرسال</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- /page-order-ratings -->


        <!-- ══════════════════ ORDER STATUS ══════════════════ -->
        <div class="page" id="page-order-status">
          <div class="page-header">
            <div>
              <div class="page-h1">📊 حالات الطلب للسلة</div>
              <div class="page-sub">متابعة جميع مراحل الطلبات من السلة حتى التسليم</div>
            </div>
            <button class="btn btn-ghost btn-sm">📥 تصدير</button>
          </div>

          <!-- Kanban-style status pipeline -->
          <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px;">

            <!-- New -->
            <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden;">
              <div
                style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.82rem;font-weight:800;color:var(--t1);">🆕 جديد</span>
                <span class="badge b-primary">12</span>
              </div>
              <div style="padding:10px;display:flex;flex-direction:column;gap:8px;">
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1095</div>
                  <div style="font-size:0.7rem;color:var(--t3);">خالد ف. · 320 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--t3);margin-top:4px;">منذ 5 دقائق</div>
                </div>
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1096</div>
                  <div style="font-size:0.7rem;color:var(--t3);">نورة س. · 180 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--t3);margin-top:4px;">منذ 12 دقيقة</div>
                </div>
                <div style="text-align:center;padding:6px;color:var(--t3);font-size:0.7rem;">+ 10 آخرين</div>
              </div>
            </div>

            <!-- Confirmed -->
            <div
              style="background:var(--bg2);border:1px solid rgba(99,102,241,0.3);border-radius:var(--r2);overflow:hidden;">
              <div
                style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.82rem;font-weight:800;color:var(--t1);">✅ مؤكد</span>
                <span class="badge b-primary">34</span>
              </div>
              <div style="padding:10px;display:flex;flex-direction:column;gap:8px;">
                <div style="background:var(--bg);border:1px solid rgba(99,102,241,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1092</div>
                  <div style="font-size:0.7rem;color:var(--t3);">خالد ف. · 420 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--primary);margin-top:4px;">تأكيد واتساب ✓</div>
                </div>
                <div style="background:var(--bg);border:1px solid rgba(99,102,241,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1091</div>
                  <div style="font-size:0.7rem;color:var(--t3);">منى ك. · 650 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--primary);margin-top:4px;">تأكيد واتساب ✓</div>
                </div>
                <div style="text-align:center;padding:6px;color:var(--t3);font-size:0.7rem;">+ 32 آخرين</div>
              </div>
            </div>

            <!-- Preparing -->
            <div
              style="background:var(--bg2);border:1px solid rgba(245,158,11,0.3);border-radius:var(--r2);overflow:hidden;">
              <div
                style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.82rem;font-weight:800;color:var(--t1);">📦 قيد التجهيز</span>
                <span class="badge b-amber">28</span>
              </div>
              <div style="padding:10px;display:flex;flex-direction:column;gap:8px;">
                <div style="background:var(--bg);border:1px solid rgba(245,158,11,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1088</div>
                  <div style="font-size:0.7rem;color:var(--t3);">سعود ك. · 540 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--amber);margin-top:4px;">جاري التعبئة</div>
                </div>
                <div style="background:var(--bg);border:1px solid rgba(245,158,11,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1087</div>
                  <div style="font-size:0.7rem;color:var(--t3);">لمى ع. · 210 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--amber);margin-top:4px;">جاري التعبئة</div>
                </div>
                <div style="text-align:center;padding:6px;color:var(--t3);font-size:0.7rem;">+ 26 آخرين</div>
              </div>
            </div>

            <!-- Shipping -->
            <div
              style="background:var(--bg2);border:1px solid rgba(6,182,212,0.3);border-radius:var(--r2);overflow:hidden;">
              <div
                style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.82rem;font-weight:800;color:var(--t1);">🚚 جاري التوصيل</span>
                <span class="badge b-cyan">87</span>
              </div>
              <div style="padding:10px;display:flex;flex-direction:column;gap:8px;">
                <div style="background:var(--bg);border:1px solid rgba(6,182,212,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1093</div>
                  <div style="font-size:0.7rem;color:var(--t3);">سارة ع. · 178 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--cyan);margin-top:4px;">أرامكس · SA123...</div>
                </div>
                <div style="background:var(--bg);border:1px solid rgba(6,182,212,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1085</div>
                  <div style="font-size:0.7rem;color:var(--t3);">فهد م. · 390 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--cyan);margin-top:4px;">SMSA · JD987...</div>
                </div>
                <div style="text-align:center;padding:6px;color:var(--t3);font-size:0.7rem;">+ 85 آخرين</div>
              </div>
            </div>

            <!-- Delivered -->
            <div
              style="background:var(--bg2);border:1px solid rgba(16,185,129,0.3);border-radius:var(--r2);overflow:hidden;">
              <div
                style="padding:12px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.82rem;font-weight:800;color:var(--t1);">✅ تم التسليم</span>
                <span class="badge b-green">224</span>
              </div>
              <div style="padding:10px;display:flex;flex-direction:column;gap:8px;">
                <div style="background:var(--bg);border:1px solid rgba(16,185,129,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1094</div>
                  <div style="font-size:0.7rem;color:var(--t3);">أحمد م. · 285 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--green);margin-top:4px;">⭐ قُيِّم 5/5</div>
                </div>
                <div style="background:var(--bg);border:1px solid rgba(16,185,129,0.2);border-radius:8px;padding:10px;">
                  <div style="font-size:0.78rem;font-weight:700;color:var(--t1);">#WZ-1091</div>
                  <div style="font-size:0.7rem;color:var(--t3);">منى ك. · 650 ر.س</div>
                  <div style="font-size:0.68rem;color:var(--green);margin-top:4px;">⭐ قُيِّم 4/5</div>
                </div>
                <div style="text-align:center;padding:6px;color:var(--t3);font-size:0.7rem;">+ 222 آخرين</div>
              </div>
            </div>

          </div>

          <!-- Full status table -->
          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">📋 جميع حالات الطلبات</span>
              <div class="filter-bar" style="margin:0;gap:6px;">
                <button class="filter-tab active" style="padding:4px 10px;font-size:0.72rem;">الكل (385)</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">🆕 جديد (12)</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">✅ مؤكد (34)</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">📦 تجهيز (28)</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">🚚 توصيل (87)</button>
                <button class="filter-tab" style="padding:4px 10px;font-size:0.72rem;">✅ مسلّم (224)</button>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <th>رقم الطلب</th>
                  <th>العميل</th>
                  <th>المنتجات</th>
                  <th>المبلغ</th>
                  <th>تاريخ الطلب</th>
                  <th>مرحلة الطلب</th>
                  <th>إشعار العميل</th>
                  <th>إجراء</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="order-id">#WZ-1096</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">ن</div>نورة س.
                    </div>
                  </td>
                  <td>بلوزة × 2</td>
                  <td><span class="amount">180 ر.س</span></td>
                  <td style="font-size:0.78rem;">الآن</td>
                  <td><span class="badge b-primary">🆕 جديد</span></td>
                  <td><span class="badge b-green" style="font-size:0.65rem;">✓ أُرسل تأكيد</span></td>
                  <td>
                    <select class="wa-input" style="padding:4px 8px;font-size:0.72rem;width:auto;"
                      onchange="updateOrderStatus(this)">
                      <option selected>🆕 جديد</option>
                      <option>✅ مؤكد</option>
                      <option>📦 قيد التجهيز</option>
                      <option>🚚 جاري التوصيل</option>
                      <option>✅ تم التسليم</option>
                      <option>❌ ملغي</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#WZ-1093</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#06b6d4,#6366f1)">س</div>سارة ع.
                    </div>
                  </td>
                  <td>بلوزة كاجوال × 2</td>
                  <td><span class="amount">178 ر.س</span></td>
                  <td style="font-size:0.78rem;">11 أبريل</td>
                  <td><span class="badge b-cyan">🚚 توصيل</span></td>
                  <td><span class="badge b-cyan" style="font-size:0.65rem;">✓ أُرسل تتبع</span></td>
                  <td>
                    <select class="wa-input" style="padding:4px 8px;font-size:0.72rem;width:auto;"
                      onchange="updateOrderStatus(this)">
                      <option>🆕 جديد</option>
                      <option>✅ مؤكد</option>
                      <option>📦 قيد التجهيز</option>
                      <option selected>🚚 جاري التوصيل</option>
                      <option>✅ تم التسليم</option>
                      <option>❌ ملغي</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><span class="order-id">#WZ-1094</span></td>
                  <td>
                    <div class="cust-cell">
                      <div class="cust-ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">أ</div>أحمد م.
                    </div>
                  </td>
                  <td>فستان سواريه</td>
                  <td><span class="amount">285 ر.س</span></td>
                  <td style="font-size:0.78rem;">11 أبريل</td>
                  <td><span class="badge b-green">✅ مسلّم</span></td>
                  <td><span class="badge b-green" style="font-size:0.65rem;">⭐ أُرسل تقييم</span></td>
                  <td>
                    <select class="wa-input" style="padding:4px 8px;font-size:0.72rem;width:auto;"
                      onchange="updateOrderStatus(this)">
                      <option>🆕 جديد</option>
                      <option>✅ مؤكد</option>
                      <option>📦 قيد التجهيز</option>
                      <option>🚚 جاري التوصيل</option>
                      <option selected>✅ تم التسليم</option>
                      <option>❌ ملغي</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- /page-order-status -->


        <!-- ══════════════════ AI TRAINING ══════════════════ -->
        <div class="page" id="page-ai-training">
          <div class="page-header">
            <div>
              <div class="page-h1">🤖 تدريب الذكاء الاصطناعي</div>
              <div class="page-sub">خصص ردود البوت وأضف بيانات تدريب لمتجرك</div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="btn btn-ghost btn-sm" onclick="testAI()">🧪 اختبار البوت</button>
              <button class="btn btn-primary btn-sm" onclick="saveAITraining()">💾 حفظ وتدريب</button>
            </div>
          </div>

          <!-- AI Status bar -->
          <div
            style="padding:14px 18px;background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:var(--r);margin-bottom:20px;display:flex;align-items:center;gap:14px;">
            <div
              style="width:40px;height:40px;border-radius:10px;background:rgba(99,102,241,0.2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">
              🤖</div>
            <div style="flex:1;">
              <div style="font-size:0.875rem;font-weight:800;color:var(--t1);">البوت نشط ومُدرَّب</div>
              <div style="font-size:0.75rem;color:var(--t2);margin-top:2px;">آخر تدريب: 10 أبريل 2025 · دقة الإجابة:
                <strong style="color:var(--green);">94%</strong></div>
            </div>
            <div style="display:flex;gap:8px;">
              <span class="badge b-green">● نشط</span>
              <span class="badge b-primary">GPT-4 Turbo</span>
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

            <!-- Left column -->
            <div style="display:flex;flex-direction:column;gap:14px;">

              <!-- System prompt — single comprehensive training field -->
              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">🧠 تدريب البوت الشامل</span></div>
                <div style="padding:18px 20px;">
                  <div style="background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:10px;padding:14px 16px;margin-bottom:16px;">
                    <div style="font-size:0.82rem;font-weight:800;color:#a5b4fc;margin-bottom:8px;">📌 كيف تدرّب البوت بشكل صحيح؟</div>
                    <div style="font-size:0.78rem;color:#94a3b8;line-height:1.8;">
                      اكتب في الحقل أدناه كل المعلومات التي تريد البوت أن يعرفها عن متجرك، مثل:<br>
                      <span style="color:#c4b5fd;">• اسم المتجر وما يبيعه</span><br>
                      <span style="color:#c4b5fd;">• أوقات العمل وطرق الدفع</span><br>
                      <span style="color:#c4b5fd;">• سياسة الشحن والإرجاع</span><br>
                      <span style="color:#c4b5fd;">• أسئلة يسألها العملاء وإجاباتها</span><br>
                      <span style="color:#c4b5fd;">• أي معلومات خاصة بمتجرك</span><br>
                      <span style="color:#6ee7b7;font-weight:700;">كلما كانت المعلومات أدق وأكثر تفصيلاً، كلما كان البوت أذكى في ردوده ✨</span>
                    </div>
                  </div>
                  <textarea id="ai_store_training" class="wa-input wa-textarea"
                    style="min-height:260px;line-height:1.8;font-size:0.85rem;"
                    placeholder="مثال:
متجر فاشون — متخصص في بيع الملابس والإكسسوارات النسائية.

أوقات العمل: الأحد إلى الخميس من 7 صباحاً حتى 9:30 مساءً.

الشحن والتوصيل: التوصيل خلال 2-4 أيام عمل داخل المملكة. شحن مجاني للطلبات فوق 200 ريال.

الإرجاع والاستبدال: يمكن إرجاع المنتج خلال 7 أيام من الاستلام بشرط أن يكون بحالته الأصلية.

طرق الدفع: تحويل بنكي، بطاقة مدى، Tabby (التقسيط).

أسئلة شائعة:
س: هل يوجد استلام من المتجر؟ ج: لا، التوصيل فقط.
س: هل الأسعار تشمل الضريبة؟ ج: نعم، جميع الأسعار شاملة ضريبة القيمة المضافة."></textarea>
                </div>
              </div>

              <!-- Behavior toggles -->
              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">⚙️ سلوك البوت</span></div>
                <div style="padding:14px 20px;">
                  <div class="wa-toggle-row">
                    <div>
                      <div class="wa-toggle-txt">الرد باسم العميل</div>
                      <div class="wa-toggle-sub">يذكر البوت اسم العميل في كل رد</div>
                    </div>
                    <div id="tog_reply_name" class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                      <div class="toggle-knob"></div>
                    </div>
                  </div>
                  <div class="wa-toggle-row">
                    <div>
                      <div class="wa-toggle-txt">إيقاف البوت عند تدخل يدوي</div>
                      <div class="wa-toggle-sub">يتوقف البوت عند رد التاجر يدوياً على عميل معين</div>
                    </div>
                    <div id="tog_stop_manual" class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                      <div class="toggle-knob"></div>
                    </div>
                  </div>
                  <div class="wa-toggle-row" id="manual_resume_row">
                    <div>
                      <div class="wa-toggle-txt">وقت استئناف البوت تلقائياً</div>
                      <div class="wa-toggle-sub">بعد انتهاء المدة يعود البوت للرد</div>
                    </div>
                    <select id="manual_resume_after" style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;color:var(--t1);padding:7px 12px;font-family:inherit;font-size:0.82rem;outline:none;cursor:pointer;">
                      <option value="5">5 دقائق</option>
                      <option value="20">20 دقيقة</option>
                      <option value="30" selected>30 دقيقة</option>
                      <option value="60">ساعة</option>
                      <option value="300">5 ساعات</option>
                      <option value="720">12 ساعة</option>
                      <option value="1440">24 ساعة</option>
                    </select>
                  </div>
                  {{-- Live paused contacts list --}}
                  <div id="manual_paused_section" style="background:rgba(245,158,11,0.07);border:1px solid rgba(245,158,11,0.2);border-radius:10px;padding:14px 16px;margin-top:6px;display:none;">
                    <div style="font-size:0.8rem;font-weight:800;color:#fbbf24;margin-bottom:10px;">⏸ البوت موقوف حالياً لهذه الأرقام:</div>
                    <div id="manual_paused_list" style="display:flex;flex-direction:column;gap:7px;"></div>
                    <button onclick="resumeAllManual()" style="margin-top:10px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#6ee7b7;padding:6px 14px;border-radius:8px;font-size:0.78rem;font-weight:700;font-family:inherit;cursor:pointer;">▶ استئناف الكل</button>
                  </div>
                  <div class="wa-toggle-row">
                    <div>
                      <div class="wa-toggle-txt">ربط المنتجات من المتجر <span class="badge b-primary"
                          style="font-size:0.6rem;">جديد</span></div>
                      <div class="wa-toggle-sub">البوت يرد بتفاصيل المنتجات مباشرة</div>
                    </div>
                    <div id="tog_link_products" class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                      <div class="toggle-knob"></div>
                    </div>
                  </div>
                  <div class="wa-toggle-row">
                    <div>
                      <div class="wa-toggle-txt">تحصين تعدد اللغات</div>
                      <div class="wa-toggle-sub">يرد البوت بنفس لغة العميل</div>
                    </div>
                    <div id="tog_multi_lang" class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                      <div class="toggle-knob"></div>
                    </div>
                  </div>
                  <div class="wa-form-group" style="margin-top:14px;">
                    <label class="wa-label">🔕 قائمة الأرقام المحظورة</label>
                    <input class="wa-input" placeholder="أضف الأرقام المحظورة..." />
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">📲 أرقام لإرسال الإشعارات إليها</label>
                    <input class="wa-input" placeholder="+966512345678, +966598765432" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Right column -->
            <div style="display:flex;flex-direction:column;gap:14px;">

              <!-- FAQ training -->
              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">❓ أسئلة وأجوبة مخصصة</span>
                  <button class="btn btn-ghost btn-sm" style="font-size:0.72rem;" onclick="addFAQ()">+ إضافة</button>
                </div>
                <div style="padding:14px 20px;" id="faqList">
                  <div class="faq-item"
                    style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;margin-bottom:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                      <div style="flex:1;">
                        <div class="wa-form-group" style="margin-bottom:8px;">
                          <label class="wa-label" style="font-size:0.7rem;">❓ السؤال</label>
                          <input class="wa-input" style="padding:6px 10px;" value="كيف أتتبع طلبي؟" />
                        </div>
                        <div class="wa-form-group" style="margin-bottom:0;">
                          <label class="wa-label" style="font-size:0.7rem;">💬 الجواب</label>
                          <textarea class="wa-input"
                            style="min-height:50px;padding:6px 10px;">يمكنك تتبع طلبك عبر الرابط الذي أُرسل لك على الواتساب عند شحن الطلب، أو تواصل معنا برقم الطلب وسنزودك بآخر تحديث.</textarea>
                        </div>
                      </div>
                      <button onclick="this.closest('.faq-item').remove()"
                        style="background:var(--red-bg);border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:4px 8px;color:var(--red);cursor:pointer;font-size:0.75rem;flex-shrink:0;">✕</button>
                    </div>
                  </div>
                  <div class="faq-item"
                    style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;margin-bottom:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                      <div style="flex:1;">
                        <div class="wa-form-group" style="margin-bottom:8px;">
                          <label class="wa-label" style="font-size:0.7rem;">❓ السؤال</label>
                          <input class="wa-input" style="padding:6px 10px;" value="ما هي مدة التوصيل؟" />
                        </div>
                        <div class="wa-form-group" style="margin-bottom:0;">
                          <label class="wa-label" style="font-size:0.7rem;">💬 الجواب</label>
                          <textarea class="wa-input"
                            style="min-height:50px;padding:6px 10px;">مدة التوصيل من 2 إلى 4 أيام عمل داخل المملكة العربية السعودية. شحن مجاني للطلبات فوق 200 ريال.</textarea>
                        </div>
                      </div>
                      <button onclick="this.closest('.faq-item').remove()"
                        style="background:var(--red-bg);border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:4px 8px;color:var(--red);cursor:pointer;font-size:0.75rem;flex-shrink:0;">✕</button>
                    </div>
                  </div>
                  <div class="faq-item"
                    style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;margin-bottom:10px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                      <div style="flex:1;">
                        <div class="wa-form-group" style="margin-bottom:8px;">
                          <label class="wa-label" style="font-size:0.7rem;">❓ السؤال</label>
                          <input class="wa-input" style="padding:6px 10px;" value="هل يمكن الإرجاع؟" />
                        </div>
                        <div class="wa-form-group" style="margin-bottom:0;">
                          <label class="wa-label" style="font-size:0.7rem;">💬 الجواب</label>
                          <textarea class="wa-input"
                            style="min-height:50px;padding:6px 10px;">نعم، نقبل الإرجاع خلال 7 أيام من تاريخ الاستلام بشرط أن يكون المنتج بحالته الأصلية مع وسومه.</textarea>
                        </div>
                      </div>
                      <button onclick="this.closest('.faq-item').remove()"
                        style="background:var(--red-bg);border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:4px 8px;color:var(--red);cursor:pointer;font-size:0.75rem;flex-shrink:0;">✕</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Live test -->
              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">🧪 اختبار البوت الحي</span></div>
                <div style="padding:14px 20px;">
                  <div
                    style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:14px;min-height:180px;max-height:220px;overflow-y:auto;display:flex;flex-direction:column;gap:10px;margin-bottom:12px;"
                    id="aiTestChat">
                    <div style="display:flex;justify-content:flex-end;">
                      <div
                        style="background:rgba(99,102,241,0.18);border:1px solid rgba(99,102,241,0.2);border-radius:10px 10px 2px 10px;padding:9px 13px;max-width:75%;font-size:0.8rem;color:var(--t1);">
                        كيف أتتبع طلبي؟</div>
                    </div>
                    <div style="display:flex;justify-content:flex-start;">
                      <div
                        style="background:var(--bg2);border:1px solid var(--border);border-radius:10px 10px 10px 2px;padding:9px 13px;max-width:85%;font-size:0.8rem;color:var(--t2);">
                        يمكنك تتبع طلبك عبر الرابط الذي أُرسل لك على الواتساب عند شحن الطلب. برقم الطلب سنزودك بآخر
                        تحديث فوراً 🚚</div>
                    </div>
                  </div>
                  <div style="display:flex;gap:8px;">
                    <input class="wa-input" id="aiTestInput" placeholder="اكتب سؤالاً للاختبار..." style="flex:1;"
                      onkeydown="if(event.key==='Enter')testMessage()" />
                    <button class="btn btn-primary" onclick="testMessage()" style="flex-shrink:0;">إرسال</button>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Save notification -->
          <div id="aiSavedAlert"
            style="display:none;position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#1a2535;border:1px solid var(--green);border-radius:12px;padding:14px 24px;z-index:999;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(0,0,0,0.5);">
            <span style="font-size:1.2rem;">🤖</span>
            <span style="font-size:0.875rem;color:var(--t1);font-weight:700;">تم حفظ بيانات التدريب وإعادة تدريب البوت
              بنجاح ✅</span>
          </div>

        </div><!-- /page-ai-training -->


        <div class="page" id="page-templates">
          <div class="page-header">
            <div>
              <div class="page-h1">📋 إعدادات القوالب</div>
              <div class="page-sub">تخصيص قوالب رسائل الواتساب لكل حالة</div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="btn btn-ghost btn-sm" onclick="resetAllTemplates()">🔄 إعادة تعيين الكل</button>
              <button class="btn btn-primary btn-sm" onclick="saveTemplates()">💾 حفظ الكل</button>
            </div>
          </div>

          <!-- Reset notice -->
          <div
            style="padding:12px 16px;background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:var(--r);margin-bottom:20px;font-size:0.8125rem;color:var(--t2);display:flex;align-items:center;gap:10px;">
            <span style="font-size:1rem;">💡</span>
            <span>يمكنك ضبط الاعتمادات الافتراضية لجميع قوالب نصوص القوالب من هنا — حين يتم أي حدث على طلباتك ستُبلَّغون
              به عبر الواتساب من خلال القوالب المعدة أدناه.</span>
          </div>

          <!-- Tab nav for template sections -->
          <div class="tab-nav" id="templateTabNav">
            <button class="tab-nav-item active" onclick="showTemplateSection('general')">⚙️ اعدادات عامة</button>
            <button class="tab-nav-item" onclick="showTemplateSection('customer')">🔔 إشعارات العميل</button>
            <button class="tab-nav-item" onclick="showTemplateSection('orders')">📦 إشعارات الطلبات</button>
            <button class="tab-nav-item" onclick="showTemplateSection('abandoned')">🛒 السلات المتروكة</button>
            <button class="tab-nav-item" onclick="showTemplateSection('ratings')">⭐ إشعارات التقييم</button>
            <button class="tab-nav-item" onclick="showTemplateSection('widget')">📱 الويدجت</button>
          </div>

          <!-- GENERAL SETTINGS -->
          <div class="template-section" id="tsec-general">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">📱 رقم الواتساب</span></div>
                <div style="padding:18px 20px;">
                  <div style="font-size:0.8rem;color:var(--t3);margin-bottom:16px;">يجب تحديد رقم واتساب متصل لإرسال
                    الرسائل والإشعارات من خلاله.</div>
                  <div class="wa-form-group">
                    <label class="wa-label">📞 اختيار رقم لإرسال من خلاله الإشعارات</label>
                    <select class="wa-input" style="cursor:pointer;">
                      <option>+966580378050 — (متصل)</option>
                      <option>+ إضافة رقم جديد</option>
                    </select>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">⏱️ فاصل زمني بين الرسائل (بالثواني)</label>
                    <div style="font-size:0.75rem;color:var(--t3);margin-bottom:8px;">حدد قيمة بالثواني لإضافة فاصل زمني
                      بين الرسائل بحيث لا يتم جدولة الرسائل في نفس الوقت.</div>
                    <input class="wa-input" type="number" value="30" min="5" max="300" />
                  </div>
                  <button class="btn btn-primary" style="width:100%;" onclick="saveSection('general')">💾 حفظ</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">🔕 إدارة الأرقام المحظورة</span></div>
                <div style="padding:18px 20px;">
                  <div style="font-size:0.8rem;color:var(--t3);margin-bottom:16px;">الأرقام المضافة هنا لن تتلقى أي
                    رسائل تلقائية من النظام.</div>
                  <div class="wa-form-group">
                    <label class="wa-label">قائمة الأرقام المحظورة</label>
                    <textarea class="wa-input wa-textarea"
                      placeholder="أضف الأرقام هنا...&#10;مثال: +966512345678&#10;+966598765432"></textarea>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">📲 الأرقام المطلوب إرسال الإشعارات إليها</label>
                    <textarea class="wa-input" style="min-height:60px;"
                      placeholder="أرقام الإشعارات الداخلية..."></textarea>
                  </div>
                  <button class="btn btn-primary" style="width:100%;" onclick="saveSection('blocked')">💾 حفظ</button>
                </div>
              </div>
            </div>
          </div>

          <!-- CUSTOMER NOTIFICATIONS -->
          <div class="template-section" id="tsec-customer" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">✅ تأكيد الطلب</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">أهلاً @{{customer_name}} 👋
شكراً لطلبك من @{{store_name}}!
رقم طلبك: @{{order_id}}
المبلغ: @{{order_total}} ر.س
سنبدأ بتجهيز طلبك قريباً ✨</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{store_name}} @{{order_id}} @{{order_total}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('تأكيد الطلب')">👁️
                    معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">🚚 تحديث الشحن</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">مرحباً @{{customer_name}} 🚚
طلبك رقم @{{order_id}} في الطريق إليك!
شركة الشحن: @{{shipping_company}}
رقم التتبع: @{{tracking_number}}
المتوقع وصوله: @{{expected_date}}</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{order_id}} @{{shipping_company}} @{{tracking_number}} @{{expected_date}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('تحديث الشحن')">👁️
                    معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">✅ تم التسليم</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">أهلاً @{{customer_name}} 🎉
وصل طلبك بنجاح!
نتمنى أن تكون راضياً عن مشترياتك.
يسعدنا تقييمك للمنتج ⭐</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{order_id}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('تم التسليم')">👁️
                    معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">❌ إلغاء الطلب</span>
                  <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">عزيزي @{{customer_name}}،
نأسف لإخبارك أن طلبك رقم @{{order_id}} تم إلغاؤه.
للاستفسار تواصل معنا على: @{{store_phone}}</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{order_id}} @{{store_phone}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('إلغاء الطلب')">👁️
                    معاينة</button>
                </div>
              </div>

            </div>
            <div style="margin-top:14px;text-align:left;">
              <button class="btn btn-primary" onclick="saveTemplates()">💾 حفظ جميع إشعارات العميل</button>
            </div>
          </div>

          <!-- ORDERS NOTIFICATIONS -->
          <div class="template-section" id="tsec-orders" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">📦 طلب جديد (للتاجر)</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">🛍️ طلب جديد وارد!
رقم: @{{order_id}}
العميل: @{{customer_name}} — @{{customer_phone}}
المنتجات: @{{products_list}}
المجموع: @{{order_total}} ر.س
الدفع: @{{payment_method}}</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{order_id}}
                    @{{customer_name}} @{{customer_phone}} @{{products_list}} @{{order_total}} @{{payment_method}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('طلب جديد')">👁️
                    معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">⚠️ مخزون منخفض (للتاجر)</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">⚠️ تنبيه مخزون!
المنتج: @{{product_name}}
الكمية المتبقية: @{{stock_count}} قطعة
يرجى إعادة التوريد.</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{product_name}}
                    @{{stock_count}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('مخزون منخفض')">👁️
                    معاينة</button>
                </div>
              </div>
            </div>
            <div style="margin-top:14px;text-align:left;">
              <button class="btn btn-primary" onclick="saveTemplates()">💾 حفظ إشعارات الطلبات</button>
            </div>
          </div>

          <!-- ABANDONED CARTS -->
          <div class="template-section" id="tsec-abandoned" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">🛒 تذكير السلة المتروكة</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">وقت الإرسال بعد الترك</label>
                    <select class="wa-input">
                      <option>بعد 30 دقيقة</option>
                      <option selected>بعد ساعة</option>
                      <option>بعد 3 ساعات</option>
                      <option>بعد 24 ساعة</option>
                    </select>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">مرحباً @{{customer_name}} 👋
لاحظنا أنك تركت بعض المنتجات في سلتك!
@{{products_list}}
المجموع: @{{cart_total}} ر.س

أتمّ طلبك الآن: @{{cart_link}} 🛍️</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{products_list}} @{{cart_total}} @{{cart_link}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;"
                    onclick="previewTemplate('السلة المتروكة')">👁️ معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">🏷️ كوبون تشجيعي للسلة المتروكة</span>
                  <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نسبة الخصم</label>
                    <input class="wa-input" type="number" value="10" min="1" max="50" />
                    <div style="font-size:0.72rem;color:var(--t3);margin-top:4px;">سيتم توليد كوبون خصم تلقائي وإرساله
                      مع الرسالة</div>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">نص رسالة الكوبون</label>
                    <textarea class="wa-input wa-textarea">@{{customer_name}} خصم خاص لك! 🎁
كود الخصم: @{{coupon_code}}
خصم @{{discount_pct}}% على سلتك
المجموع بعد الخصم: @{{discounted_total}} ر.س
ينتهي الكوبون خلال 24 ساعة ⏰</textarea>
                  </div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('كوبون السلة')">👁️
                    معاينة</button>
                </div>
              </div>
            </div>
            <div style="margin-top:14px;text-align:left;">
              <button class="btn btn-primary" onclick="saveTemplates()">💾 حفظ إعدادات السلات المتروكة</button>
            </div>
          </div>

          <!-- RATINGS -->
          <div class="template-section" id="tsec-ratings" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">⭐ طلب تقييم المنتج</span>
                  <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">وقت الإرسال بعد التسليم</label>
                    <select class="wa-input">
                      <option>بعد 24 ساعة</option>
                      <option selected>بعد 3 أيام</option>
                      <option>بعد أسبوع</option>
                    </select>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">نص الرسالة</label>
                    <textarea class="wa-input wa-textarea">أهلاً @{{customer_name}} ⭐
نتمنى أنك راضٍ عن @{{product_name}}
يسعدنا لو شاركتنا رأيك:
@{{rating_link}}
شكراً لثقتك بنا 💙</textarea>
                  </div>
                  <div style="font-size:0.72rem;color:var(--t3);margin-bottom:12px;">المتغيرات: @{{customer_name}}
                    @{{product_name}} @{{rating_link}}</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('طلب تقييم')">👁️
                    معاينة</button>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head">
                  <span class="panel-title">🎁 مكافأة التقييم</span>
                  <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                    <div class="toggle-knob"></div>
                  </div>
                </div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">نوع المكافأة</label>
                    <select class="wa-input">
                      <option>كوبون خصم</option>
                      <option>نقاط ولاء</option>
                      <option>شحن مجاني</option>
                    </select>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">نص رسالة المكافأة</label>
                    <textarea class="wa-input wa-textarea">شكراً على تقييمك @{{customer_name}} 🙏
حصلت على مكافأة خاصة:
@{{reward_details}}
استخدمها في طلبك القادم! 🎁</textarea>
                  </div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;" onclick="previewTemplate('مكافأة تقييم')">👁️
                    معاينة</button>
                </div>
              </div>
            </div>
            <div style="margin-top:14px;text-align:left;">
              <button class="btn btn-primary" onclick="saveTemplates()">💾 حفظ إعدادات التقييم</button>
            </div>
          </div>

          <!-- WIDGET -->
          <div class="template-section" id="tsec-widget" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">📱 إعداد ويدجت الواتساب</span></div>
                <div style="padding:18px 20px;">
                  <div class="wa-form-group">
                    <label class="wa-label">رقم الواتساب للويدجت</label>
                    <input class="wa-input" type="text" value="+966580378050" />
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">رسالة الترحيب المبدئية</label>
                    <textarea class="wa-input wa-textarea"
                      style="min-height:60px;">مرحباً! كيف يمكنني مساعدتك؟ 👋</textarea>
                  </div>
                  <div class="wa-form-group">
                    <label class="wa-label">موضع الويدجت</label>
                    <select class="wa-input">
                      <option>أسفل اليسار</option>
                      <option selected>أسفل اليمين</option>
                    </select>
                  </div>
                  <div class="wa-toggle-row">
                    <div>
                      <div class="wa-toggle-txt">إظهار الويدجت في المتجر</div>
                      <div class="wa-toggle-sub">تفعيل زر الواتساب على صفحات المتجر</div>
                    </div>
                    <div class="toggle on" onclick="this.classList.toggle('on');this.classList.toggle('off')">
                      <div class="toggle-knob"></div>
                    </div>
                  </div>
                  <div style="margin-top:14px;">
                    <button class="btn btn-primary" style="width:100%;" onclick="saveSection('widget')">💾 حفظ إعدادات
                      الويدجت</button>
                  </div>
                </div>
              </div>

              <div class="full-panel">
                <div class="panel-head"><span class="panel-title">📋 كود التضمين</span></div>
                <div style="padding:18px 20px;">
                  <div style="font-size:0.8rem;color:var(--t3);margin-bottom:12px;">انسخ هذا الكود وضعه قبل إغلاق
                    &lt;/body&gt; في متجرك:</div>
                  <div
                    style="background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:14px;font-family:monospace;font-size:0.78rem;color:#a5b4fc;line-height:1.6;white-space:pre-wrap;">
                    &lt;script src="https://wayzon.sa/widget.js"
                    data-phone="+966580378050"
                    data-position="bottom-right"&gt;
                    &lt;/script&gt;</div>
                  <button class="btn btn-ghost btn-sm" style="width:100%;margin-top:12px;"
                    onclick="this.textContent='✅ تم النسخ!';setTimeout(()=>this.textContent='📋 نسخ الكود',2000)">📋 نسخ
                    الكود</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Preview Modal -->
          <div id="previewModal"
            style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:500;align-items:center;justify-content:center;">
            <div
              style="background:var(--bg2);border:1px solid var(--border2);border-radius:var(--r2);padding:24px;width:380px;max-width:90vw;">
              <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <span style="font-size:0.9375rem;font-weight:800;color:var(--t1);">👁️ معاينة القالب</span>
                <button onclick="document.getElementById('previewModal').style.display='none'"
                  style="background:transparent;border:none;color:var(--t3);font-size:1.2rem;cursor:pointer;">✕</button>
              </div>
              <div style="background:#0a1628;border-radius:12px;padding:16px;border:1px solid rgba(16,185,129,0.2);">
                <div
                  style="display:flex;align-items:center;gap:8px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid var(--border);">
                  <div
                    style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:800;color:#fff;">
                    م</div>
                  <div>
                    <div style="font-size:0.8rem;font-weight:700;color:var(--t1);">متجر فاشون</div>
                    <div style="font-size:0.65rem;color:var(--green);">● متصل</div>
                  </div>
                </div>
                <div id="previewContent"
                  style="font-size:0.875rem;color:var(--t1);line-height:1.6;white-space:pre-wrap;background:rgba(99,102,241,0.08);padding:12px;border-radius:8px;">
                </div>
                <div style="font-size:0.65rem;color:var(--t3);margin-top:8px;text-align:left;">✓✓ مُرسَل · الآن</div>
              </div>
            </div>
          </div>

        </div><!-- /page-templates -->


        <!-- ══════════════════ PLANS ══════════════════ -->
        <div class="page" id="page-plans">
          <div class="page-header">
            <div>
              <div class="page-h1">💎 الخطط والأسعار</div>
              <div class="page-sub">خطتك الحالية: <span style="color:{{ auth()->user()->planColor() }};font-weight:700;">{{ auth()->user()->planLabel() }}</span></div>
            </div>
          </div>

          <style>
            .plans-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; max-width:900px; }
            .plan-card { background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:18px; padding:28px 24px; position:relative; transition:all .2s; }
            .plan-card:hover { border-color:rgba(255,255,255,0.15); transform:translateY(-3px); }
            .plan-card.current { border:2px solid rgba(99,102,241,0.5); background:rgba(99,102,241,0.06); }
            .plan-card.feat { border:2px solid #6366f1; background:#12183a; box-shadow:0 0 0 4px rgba(99,102,241,0.09); transform:translateY(-6px); }
            .plan-card.feat:hover { transform:translateY(-10px); }
            .plan-badge { position:absolute; top:-13px; left:50%; transform:translateX(-50%); background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; font-size:0.7rem; font-weight:800; padding:4px 16px; border-radius:99px; white-space:nowrap; }
            .plan-name { font-size:1.1rem; font-weight:900; margin-bottom:6px; }
            .plan-price { font-size:2.6rem; font-weight:900; line-height:1; margin:12px 0 4px; }
            .plan-period { font-size:0.78rem; color:#64748b; margin-bottom:16px; }
            .plan-desc { font-size:0.8rem; color:#94a3b8; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.07); min-height:48px; }
            .plan-feat-list { display:flex; flex-direction:column; gap:10px; margin-bottom:24px; }
            .plan-feat { display:flex; align-items:flex-start; gap:8px; font-size:0.8rem; color:#94a3b8; }
            .plan-feat .fi { width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.55rem; font-weight:900; flex-shrink:0; margin-top:2px; }
            .fi-y { background:rgba(16,185,129,0.15); color:#10b981; }
            .fi-n { background:rgba(255,255,255,0.04); color:#475569; }
            .fi-s { background:rgba(99,102,241,0.2); color:#a5b4fc; }
            .plan-btn { width:100%; padding:12px; border-radius:12px; font-size:0.875rem; font-weight:800; font-family:inherit; cursor:pointer; border:none; transition:all .2s; }
            .plan-btn-current { background:rgba(99,102,241,0.1); color:#a5b4fc; border:1px solid rgba(99,102,241,0.25); cursor:default; }
            .plan-btn-upgrade { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; box-shadow:0 4px 16px rgba(99,102,241,0.35); }
            .plan-btn-upgrade:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(99,102,241,0.45); }
            .plan-btn-pro { background:linear-gradient(135deg,#7c3aed,#a855f7); color:#fff; box-shadow:0 4px 16px rgba(139,92,246,0.35); }
            .billing-toggle { display:inline-flex; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:99px; padding:4px; gap:3px; margin-bottom:28px; }
            .bt-btn { padding:7px 20px; border-radius:99px; font-size:0.8rem; font-weight:700; font-family:inherit; cursor:pointer; border:none; color:#64748b; background:transparent; transition:all .2s; }
            .bt-btn.active { background:#6366f1; color:#fff; }
            @media(max-width:768px){ .plans-grid{grid-template-columns:1fr;max-width:380px;} .plan-card.feat{transform:none;} }
          </style>

          <div class="billing-toggle">
            <button class="bt-btn active" id="pt-monthly" onclick="setPlanBilling('monthly')">شهري</button>
            <button class="bt-btn" id="pt-yearly" onclick="setPlanBilling('yearly')">سنوي — وفّر 20%</button>
          </div>

          <div class="plans-grid">

            {{-- BASIC --}}
            <div class="plan-card {{ auth()->user()->plan === 'basic' ? 'current' : '' }}">
              <div class="plan-name">🚀 الأساسية</div>
              <div class="plan-price" id="pp-basic" style="color:#f0f4ff;">55</div>
              <div class="plan-period"><span id="ps-basic">ر.س / شهر</span></div>
              <div class="plan-desc">مثالية للمتاجر الناشئة التي تبدأ رحلتها مع الأتمتة</div>
              <div class="plan-feat-list">
                <div class="plan-feat"><span class="fi fi-y">✓</span> ربط مع سلة (الطلبات + الحالات)</div>
                <div class="plan-feat"><span class="fi fi-y">✓</span> إرسال رسائل تلقائية للعملاء</div>
                <div class="plan-feat"><span class="fi fi-y">✓</span> تخصيص نصوص الرسائل</div>
                <div class="plan-feat"><span class="fi fi-y">✓</span> لوحة تحكم الرسائل</div>
                <div class="plan-feat"><span class="fi fi-n">—</span> ردود ذكية بالذكاء الاصطناعي</div>
                <div class="plan-feat"><span class="fi fi-n">—</span> سيناريوهات الرد (Flows)</div>
              </div>
              @if(auth()->user()->plan === 'basic')
                <button class="plan-btn plan-btn-current">✓ خطتك الحالية</button>
              @elseif(auth()->user()->pending_plan === 'basic')
                <button class="plan-btn" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);cursor:default;">⏳ بانتظار الدفع</button>
              @else
                <form method="POST" action="{{ route('plan.change') }}">
                  @csrf
                  <input type="hidden" name="plan" value="basic">
                  <button type="submit" class="plan-btn plan-btn-upgrade" style="background:rgba(255,255,255,0.07);color:#f0f4ff;box-shadow:none;">الانتقال لهذه الخطة</button>
                </form>
              @endif
            </div>

            {{-- SMART --}}
            <div class="plan-card feat {{ auth()->user()->plan === 'smart' ? 'current' : '' }}">
              <span class="plan-badge">⭐ الأكثر طلباً</span>
              <div class="plan-name" style="color:#a5b4fc;">🧠 الذكية</div>
              <div class="plan-price" id="pp-smart" style="background:linear-gradient(135deg,#fff,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">99</div>
              <div class="plan-period"><span id="ps-smart">ر.س / شهر</span></div>
              <div class="plan-desc" style="color:#c4b5fd;">للمتاجر التي تريد ردوداً ذكية وتجربة عملاء استثنائية</div>
              <div class="plan-feat-list">
                <div class="plan-feat"><span class="fi fi-y">✓</span> كل مميزات الأساسية</div>
                <div class="plan-feat"><span class="fi fi-s">✦</span> ردود ذكية باستخدام OpenAI</div>
                <div class="plan-feat"><span class="fi fi-s">✦</span> الرد التلقائي على الاستفسارات</div>
                <div class="plan-feat"><span class="fi fi-s">✦</span> تخصيص أسلوب الرد</div>
                <div class="plan-feat"><span class="fi fi-s">✦</span> تدريب بيانات المتجر</div>
                <div class="plan-feat"><span class="fi fi-n">—</span> سيناريوهات الرد (Flows)</div>
              </div>
              @if(auth()->user()->plan === 'smart')
                <button class="plan-btn plan-btn-current">✓ خطتك الحالية</button>
              @elseif(auth()->user()->pending_plan === 'smart')
                <button class="plan-btn" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);cursor:default;">⏳ بانتظار الدفع</button>
              @else
                <form method="POST" action="{{ route('plan.change') }}">
                  @csrf
                  <input type="hidden" name="plan" value="smart">
                  <button type="submit" class="plan-btn plan-btn-upgrade">ترقية الآن ←</button>
                </form>
              @endif
            </div>

            {{-- PRO --}}
            <div class="plan-card {{ auth()->user()->plan === 'pro' ? 'current' : '' }}" style="border-color:rgba(168,85,247,0.3);">
              <div class="plan-name">🏆 الاحترافية</div>
              <div class="plan-price" id="pp-pro" style="background:linear-gradient(135deg,#d8b4fe,#f0abfc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">139</div>
              <div class="plan-period"><span id="ps-pro">ر.س / شهر</span></div>
              <div class="plan-desc">للمتاجر الجادة التي تريد التحكم الكامل والأداء المتميز</div>
              <div class="plan-feat-list">
                <div class="plan-feat"><span class="fi fi-y">✓</span> كل مميزات الذكية</div>
                <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> سيناريوهات الرد (Flows)</div>
                <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> تحليل الرسائل والتفاعل</div>
                <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> أولوية في الأداء والردود</div>
                <div class="plan-feat"><span class="fi" style="background:rgba(168,85,247,0.18);color:#d8b4fe;">◆</span> تحديثات مستقبلية</div>
              </div>
              @if(auth()->user()->plan === 'pro')
                <button class="plan-btn plan-btn-current">✓ خطتك الحالية</button>
              @elseif(auth()->user()->pending_plan === 'pro')
                <button class="plan-btn" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);cursor:default;">⏳ بانتظار الدفع</button>
              @else
                <form method="POST" action="{{ route('plan.change') }}">
                  @csrf
                  <input type="hidden" name="plan" value="pro">
                  <button type="submit" class="plan-btn plan-btn-pro">ترقية الآن ←</button>
                </form>
              @endif
            </div>

          </div>

          <script>
            let _planYearly = false;
            const _planPrices = { basic: 55, smart: 99, pro: 139 };
            function setPlanBilling(mode) {
              _planYearly = mode === 'yearly';
              document.getElementById('pt-monthly').classList.toggle('active', !_planYearly);
              document.getElementById('pt-yearly').classList.toggle('active', _planYearly);
              const disc = _planYearly ? 0.8 : 1;
              ['basic','smart','pro'].forEach(k => {
                const el = document.getElementById('pp-' + k);
                const ps = document.getElementById('ps-' + k);
                if (!el) return;
                const val = _planYearly ? Math.round(_planPrices[k] * 12 * disc) : _planPrices[k];
                el.textContent = val;
                if (ps) ps.textContent = _planYearly ? 'ر.س / سنة' : 'ر.س / شهر';
              });
            }
          </script>
        </div><!-- /page-plans -->


        <!-- ══════════════════ CAMPAIGNS ══════════════════ -->
        <div class="page" id="page-campaigns">
          <div class="page-header">
            <div>
              <div class="page-h1">📣 الحملات</div>
              <div class="page-sub">إرسال رسائل جماعية لعملائك عبر واتساب</div>
            </div>
            <button class="btn btn-primary btn-sm" onclick="alert('هذه الميزة قيد التطوير وستكون متاحة قريباً')">+ إنشاء حملة</button>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:24px;">
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">حملات نشطة</div>
            </div>
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">رسائل أُرسلت</div>
            </div>
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0%</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">معدل الفتح</div>
            </div>
          </div>

          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">📋 الحملات السابقة</span>
            </div>
            <div style="padding:48px;text-align:center;">
              <div style="font-size:3rem;margin-bottom:16px;">📣</div>
              <div style="font-size:1rem;font-weight:700;color:var(--t2);margin-bottom:8px;">لا توجد حملات بعد</div>
              <div style="font-size:0.85rem;color:var(--t3);margin-bottom:24px;">أنشئ حملتك الأولى لإرسال رسائل جماعية لعملائك</div>
              <button class="btn btn-primary" onclick="alert('هذه الميزة قيد التطوير وستكون متاحة قريباً')">+ إنشاء أول حملة</button>
            </div>
          </div>
        </div><!-- /page-campaigns -->


        <!-- ══════════════════ COUPONS ══════════════════ -->
        <div class="page" id="page-coupons">
          <div class="page-header">
            <div>
              <div class="page-h1">🏷️ الكوبونات</div>
              <div class="page-sub">إنشاء وإدارة كوبونات الخصم لعملائك</div>
            </div>
            <button class="btn btn-primary btn-sm" onclick="alert('هذه الميزة قيد التطوير وستكون متاحة قريباً')">+ إنشاء كوبون</button>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:24px;">
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">كوبونات نشطة</div>
            </div>
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">كوبونات مستخدمة</div>
            </div>
            <div class="full-panel" style="padding:20px;text-align:center;">
              <div style="font-size:1.8rem;font-weight:900;color:var(--t1);">0 ر.س</div>
              <div style="font-size:0.8rem;color:var(--t3);margin-top:4px;">إجمالي الخصومات</div>
            </div>
          </div>

          <div class="full-panel">
            <div class="panel-head">
              <span class="panel-title">🏷️ الكوبونات المتاحة</span>
            </div>
            <div style="padding:48px;text-align:center;">
              <div style="font-size:3rem;margin-bottom:16px;">🏷️</div>
              <div style="font-size:1rem;font-weight:700;color:var(--t2);margin-bottom:8px;">لا توجد كوبونات بعد</div>
              <div style="font-size:0.85rem;color:var(--t3);margin-bottom:24px;">أنشئ كوبون خصم وأرسله لعملائك عبر واتساب</div>
              <button class="btn btn-primary" onclick="alert('هذه الميزة قيد التطوير وستكون متاحة قريباً')">+ إنشاء أول كوبون</button>
            </div>
          </div>
        </div><!-- /page-coupons -->


        <!-- ══════════════════ SETTINGS ══════════════════ -->
        <div class="page" id="page-settings">
          <div class="page-header">
            <div>
              <div class="page-h1">⚙️ الإعدادات</div>
              <div class="page-sub">إدارة بيانات حسابك ومتجرك</div>
            </div>
          </div>

          @if(session('success'))
          <div style="background:var(--green-bg);border:1px solid var(--green);color:var(--green);padding:12px 18px;border-radius:var(--r);margin-bottom:16px;font-weight:600;">
            {{ session('success') }}
          </div>
          @endif

          <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <div class="full-panel" style="max-width:600px;">
              <div class="panel-head">
                <span class="panel-title">👤 البيانات الشخصية</span>
              </div>
              <div style="padding:20px;display:flex;flex-direction:column;gap:16px;">

                <div class="wa-form-group">
                  <label class="wa-label">الاسم</label>
                  <input class="wa-input" type="text" name="name" value="{{ auth()->user()->name }}" required />
                  @error('name')<div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <div class="wa-form-group">
                  <label class="wa-label">البريد الإلكتروني</label>
                  <input class="wa-input" type="email" name="email" value="{{ auth()->user()->email }}" required />
                  @error('email')<div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <div class="wa-form-group">
                  <label class="wa-label">اسم المتجر</label>
                  <input class="wa-input" type="text" name="store_name" value="{{ $store?->store_name ?? '' }}" placeholder="اسم متجرك في سلة" />
                </div>

                <hr style="border-color:var(--border);margin:4px 0;" />

                <div class="wa-form-group">
                  <label class="wa-label">كلمة مرور جديدة (اتركها فارغة إن لم تريد التغيير)</label>
                  <input class="wa-input" type="password" name="password" placeholder="••••••••" />
                </div>

                <div class="wa-form-group">
                  <label class="wa-label">تأكيد كلمة المرور</label>
                  <input class="wa-input" type="password" name="password_confirmation" placeholder="••••••••" />
                  @error('password')<div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">💾 حفظ الإعدادات</button>
              </div>
            </div>
          </form>
        </div><!-- /page-settings -->


      </main>
    </div>
  </div>

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
    // ── Page switching ──
    function toggleSidebar() {
      const s = document.getElementById('sidebar');
      const o = document.getElementById('mobOverlay');
      const isOpen = s.classList.contains('open');
      s.classList.toggle('open', !isOpen);
      if (o) o.classList.toggle('open', !isOpen);
    }
    function closeSidebar() {
      document.getElementById('sidebar').classList.remove('open');
      const o = document.getElementById('mobOverlay');
      if (o) o.classList.remove('open');
    }

    function switchPage(el) {
      const pageName = el.dataset.page;
      document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
      el.classList.add('active');
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      document.getElementById('page-' + pageName).classList.add('active');
      const titles = { dashboard: 'لوحة التحكم', orders: 'الطلبات', shipping: 'الشحن والتوصيل', customers: 'العملاء', products: 'المنتجات', reports: 'التقارير', whatsapp: 'واتساب', campaigns: 'الحملات', coupons: 'الكوبونات', 'basket-orders': 'أوامر السلة', templates: 'إعدادات القوالب', 'order-ratings': 'طلب تقييم', 'order-status': 'حالات الطلب', 'ai-training': 'تدريب الذكاء الاصطناعي', settings: 'الإعدادات', plans: 'الخطط والأسعار' };
      document.getElementById('topbarTitle').textContent = titles[pageName] || pageName;
      closeSidebar();
      // Reset scroll position on both body (mobile) and content div (desktop)
      window.scrollTo(0, 0);
      document.querySelector('.content')?.scrollTo(0, 0);

      // Init report charts lazily
      if (pageName === 'reports' && !window._reportChartsInit) {
        initReportCharts();
        window._reportChartsInit = true;
      }
    }
    function switchPageByName(name) {
      const el = document.querySelector('[data-page="' + name + '"]');
      if (el) switchPage(el);
    }

    // ── Filter tabs ──
    document.querySelectorAll('.filter-bar').forEach(bar => {
      bar.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', () => {
          bar.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
        });
      });
    });

    // ── Tab nav ──
    document.querySelectorAll('.tab-nav').forEach(nav => {
      nav.querySelectorAll('.tab-nav-item').forEach(tab => {
        tab.addEventListener('click', () => {
          nav.querySelectorAll('.tab-nav-item').forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
        });
      });
    });

    // ── Chart defaults ──
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font = { family: "'Tajawal', sans-serif" };

    // ── Sales chart ──
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const labels = Array.from({ length: 30 }, (_, i) => (i + 1) + '');
    const salesData = [820, 740, 890, 960, 1100, 980, 1050, 1200, 1080, 1320, 1150, 990, 1400, 1350, 1280, 1500, 1420, 1380, 1600, 1520, 1480, 1700, 1650, 1580, 1900, 1820, 1760, 2100, 1980, 2200];
    const ordersData = [12, 10, 14, 15, 18, 14, 16, 20, 17, 22, 19, 16, 24, 21, 20, 25, 23, 22, 27, 26, 24, 29, 28, 26, 32, 30, 29, 35, 33, 34];

    const sg = salesCtx.createLinearGradient(0, 0, 0, 210);
    sg.addColorStop(0, 'rgba(99,102,241,0.28)');
    sg.addColorStop(1, 'rgba(99,102,241,0)');

    new Chart(salesCtx, {
      type: 'line',
      data: {
        labels,
        datasets: [
          { label: 'المبيعات (ر.س)', data: salesData, borderColor: '#6366f1', backgroundColor: sg, borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0, pointHoverRadius: 5, yAxisID: 'y' },
          { label: 'الطلبات', data: ordersData, borderColor: '#10b981', backgroundColor: 'transparent', borderWidth: 2, fill: false, tension: 0.4, pointRadius: 0, pointHoverRadius: 5, borderDash: [4, 4], yAxisID: 'y1' }
        ]
      },
      options: {
        responsive: true, interaction: { mode: 'index', intersect: false },
        plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1a1f2e', borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1, padding: 12 } },
        scales: {
          x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { maxTicksLimit: 8, font: { size: 11 } } },
          y: { position: 'right', grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { font: { size: 11 }, callback: v => v >= 1000 ? (v / 1000).toFixed(1) + 'K' : v } },
          y1: { display: false }
        }
      }
    });

    // ── Category donut ──
    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
      type: 'doughnut',
      data: {
        labels: ['ملابس', 'إكسسوارات', 'أحذية', 'أخرى'],
        datasets: [{ data: [42, 28, 18, 12], backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#8b5cf6'], borderWidth: 3, borderColor: '#161b24', hoverOffset: 5 }]
      },
      options: {
        responsive: true, cutout: '72%',
        plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1a1f2e', borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}%` } } }
      }
    });

    // ── Report charts ──
    function initReportCharts() {
      // Weekly bar
      const rwCtx = document.getElementById('reportWeekly').getContext('2d');
      new Chart(rwCtx, {
        type: 'bar',
        data: {
          labels: ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4', 'الأسبوع 5', 'الأسبوع 6', 'الأسبوع 7'],
          datasets: [{ label: 'المبيعات (ر.س)', data: [5200, 6800, 5900, 8200, 7400, 9100, 10500], backgroundColor: 'rgba(99,102,241,0.7)', borderRadius: 6, borderSkipped: false }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1a1f2e', borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1 } },
          scales: { x: { grid: { color: 'rgba(255,255,255,0.04)' } }, y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { callback: v => v >= 1000 ? (v / 1000).toFixed(1) + 'K' : v } } }
        }
      });

      // Source doughnut
      const rsCtx = document.getElementById('reportSource').getContext('2d');
      new Chart(rsCtx, {
        type: 'doughnut',
        data: {
          labels: ['واتساب', 'تيك توك', 'إنستغرام', 'مباشر', 'أخرى'],
          datasets: [{ data: [38, 24, 20, 12, 6], backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#06b6d4', '#8b5cf6'], borderWidth: 3, borderColor: '#161b24', hoverOffset: 5 }]
        },
        options: {
          responsive: true, cutout: '65%',
          plugins: {
            legend: { display: true, position: 'bottom', labels: { font: { size: 11 }, color: '#94a3b8', padding: 12, usePointStyle: true } },
            tooltip: { backgroundColor: '#1a1f2e', borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1, callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}%` } }
          }
        }
      });
    }

    // ── Mobile overlay close ──
    document.addEventListener('click', e => {
      const sb = document.getElementById('sidebar');
      const tg = document.getElementById('mobToggle');
      if (sb.classList.contains('open') && !sb.contains(e.target) && tg && !tg.contains(e.target)) {
        sb.classList.remove('open');
      }
    });

    // ── Chart tabs ──
    document.querySelectorAll('.chart-tabs').forEach(tabs => {
      tabs.querySelectorAll('.ctab').forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.querySelectorAll('.ctab').forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
        });
      });
    });

    // ── Basket Orders ──
    function sendOrder(btn, cartId) {
      btn.textContent = '✅ أُرسل';
      btn.style.color = 'var(--green)';
      btn.disabled = true;
      const alertEl = document.getElementById('orderSentAlert');
      document.getElementById('orderSentMsg').textContent = 'تم إرسال أمر السلة ' + cartId + ' للعميل بنجاح عبر واتساب';
      alertEl.style.display = 'flex';
      setTimeout(() => { alertEl.style.display = 'none'; }, 3000);
      const row = btn.closest('tr');
      const statusCell = row.querySelector('td:nth-child(6)');
      if (statusCell) statusCell.innerHTML = '<span class="badge b-cyan">📤 أُرسل الأمر</span>';
    }

    // ── Templates ──
    function showTemplateSection(name) {
      document.querySelectorAll('.template-section').forEach(s => s.style.display = 'none');
      const sec = document.getElementById('tsec-' + name);
      if (sec) sec.style.display = 'block';
      document.querySelectorAll('#templateTabNav .tab-nav-item').forEach(t => t.classList.remove('active'));
      if (event && event.target) event.target.classList.add('active');
    }

    function previewTemplate(name) {
      const panel = event.target.closest('.full-panel');
      const textareas = panel ? panel.querySelectorAll('textarea') : [];
      const content = textareas.length ? textareas[textareas.length - 1].value : '';
      const preview = content
        .replace(/@{{customer_name}}/g, 'فيصل العمري')
        .replace(/@{{store_name}}/g, 'متجر فاشون')
        .replace(/@{{order_id}}/g, '#WZ-1094')
        .replace(/@{{order_total}}/g, '285')
        .replace(/@{{cart_total}}/g, '705')
        .replace(/@{{products_list}}/g, '• فستان سواريه × 1\n• حقيبة جلدية × 1')
        .replace(/@{{shipping_company}}/g, 'أرامكس')
        .replace(/@{{tracking_number}}/g, 'SA1234567890')
        .replace(/@{{expected_date}}/g, '13 أبريل 2025')
        .replace(/@{{product_name}}/g, 'فستان سواريه')
        .replace(/@{{rating_link}}/g, 'wayzon.sa/rate/1094')
        .replace(/@{{cart_link}}/g, 'wayzon.sa/cart/081')
        .replace(/@{{coupon_code}}/g, 'SAVE10')
        .replace(/@{{discount_pct}}/g, '10')
        .replace(/@{{discounted_total}}/g, '634')
        .replace(/@{{reward_details}}/g, 'خصم 10% على طلبك القادم')
        .replace(/@{{customer_phone}}/g, '+966504567890')
        .replace(/@{{payment_method}}/g, 'بطاقة بنكية')
        .replace(/@{{stock_count}}/g, '3')
        .replace(/@{{store_phone}}/g, '+966580378050');
      document.getElementById('previewContent').textContent = preview;
      document.getElementById('previewModal').style.display = 'flex';
    }

    function saveTemplates() {
      const btn = event.target;
      const orig = btn.textContent;
      btn.textContent = '✅ تم الحفظ!';
      btn.style.background = 'var(--green)';
      setTimeout(() => { btn.textContent = orig; btn.style.background = ''; }, 2000);
    }
    function saveSection(n) { saveTemplates(); }
    function resetAllTemplates() {
      if (window.confirm('هل تريد إعادة تعيين جميع القوالب للإعدادات الافتراضية؟')) {
        window.alert('تم إعادة تعيين جميع القوالب بنجاح ✅');
      }
    }

    // Close preview modal on backdrop
    document.addEventListener('click', e => {
      const modal = document.getElementById('previewModal');
      if (modal && e.target === modal) modal.style.display = 'none';
    });

    // ── WhatsApp dynamic status ──
    const WA_STATUS_URL = '{{ route("whatsapp.status") }}';
    const WA_LOGOUT_URL = '{{ route("whatsapp.logout") }}';
    const WA_CSRF = '{{ csrf_token() }}';

    async function refreshWaStatus() {
      try {
        const res = await fetch(WA_STATUS_URL);
        const d = await res.json();
        const dot = document.getElementById('waStatusDot');
        const txt = document.getElementById('waStatusTxt');
        const num = document.getElementById('waStatusNum');
        const connectBtn = document.getElementById('waConnectBtn');
        const disconnectBtn = document.getElementById('waDisconnectBtn');
        const navBadge = document.getElementById('waNavBadge');

        if (d.state === 'ready') {
          dot.style.background = 'var(--green)';
          txt.textContent = 'الحساب متصل ومفعّل';
          num.textContent = '';
          connectBtn.style.display = 'none';
          disconnectBtn.style.display = '';
          navBadge.textContent = 'متصل';
          navBadge.style.background = 'var(--green-bg)';
          navBadge.style.color = 'var(--green)';
        } else {
          dot.style.background = 'var(--red)';
          txt.textContent = 'غير متصل';
          num.textContent = '';
          connectBtn.style.display = '';
          disconnectBtn.style.display = 'none';
          navBadge.textContent = 'غير متصل';
          navBadge.style.background = 'var(--red-bg)';
          navBadge.style.color = 'var(--red)';
        }
      } catch(e) {}
    }

    async function dashboardDisconnectWA() {
      if (!confirm('هل تريد قطع الاتصال؟')) return;
      await fetch(WA_LOGOUT_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': WA_CSRF } });
      refreshWaStatus();
    }

    refreshWaStatus();
    setInterval(refreshWaStatus, 10000);
  </script>
</body>

</html>
<script>
  // ── Order Ratings ──
  function resendRating(btn) {
    btn.textContent = '✅ أُعيد الإرسال';
    btn.style.color = 'var(--green)';
    btn.disabled = true;
  }
  function sendRatingBlast() {
    alert('تم إرسال طلب التقييم لـ 62 عميل بانتظار التقييم ✅');
  }

  // ── Order Status ──
  function updateOrderStatus(sel) {
    const row = sel.closest('tr');
    const statusCell = row.querySelector('td:nth-child(6)');
    const notifCell = row.querySelector('td:nth-child(7)');
    const val = sel.value;
    const map = {
      '🆕 جديد': ['b-primary', '✓ أُرسل تأكيد'],
      '✅ مؤكد': ['b-primary', '✓ أُرسل تأكيد'],
      '📦 قيد التجهيز': ['b-amber', '✓ أُرسل تحديث'],
      '🚚 جاري التوصيل': ['b-cyan', '✓ أُرسل تتبع'],
      '✅ تم التسليم': ['b-green', '⭐ أُرسل تقييم'],
      '❌ ملغي': ['b-red', '✓ أُرسل إلغاء']
    };
    if (statusCell && map[val]) {
      statusCell.innerHTML = `<span class="badge ${map[val][0]}">${val}</span>`;
      notifCell.innerHTML = `<span class="badge b-green" style="font-size:0.65rem;">${map[val][1]}</span>`;
    }
  }

  // ── AI Training ──
  function addFAQ() {
    const list = document.getElementById('faqList');
    const div = document.createElement('div');
    div.className = 'faq-item';
    div.style.cssText = 'background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;margin-bottom:10px;';
    div.innerHTML = `<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
    <div style="flex:1;">
      <div class="wa-form-group" style="margin-bottom:8px;">
        <label class="wa-label" style="font-size:0.7rem;">❓ السؤال</label>
        <input class="wa-input" style="padding:6px 10px;" placeholder="اكتب السؤال هنا..." />
      </div>
      <div class="wa-form-group" style="margin-bottom:0;">
        <label class="wa-label" style="font-size:0.7rem;">💬 الجواب</label>
        <textarea class="wa-input" style="min-height:50px;padding:6px 10px;" placeholder="اكتب الجواب هنا..."></textarea>
      </div>
    </div>
    <button onclick="this.closest('.faq-item').remove()" style="background:var(--red-bg);border:1px solid rgba(239,68,68,0.2);border-radius:6px;padding:4px 8px;color:var(--red);cursor:pointer;font-size:0.75rem;flex-shrink:0;">✕</button>
  </div>`;
    list.appendChild(div);
    div.querySelector('input').focus();
  }

  const aiResponses = {
    'مدة التوصيل': 'مدة التوصيل من 2 إلى 4 أيام عمل. شحن مجاني فوق 200 ريال 🚚',
    'كيف أتتبع': 'يمكنك تتبع طلبك عبر الرابط المُرسل على الواتساب، أو أرسل لنا رقم طلبك 📦',
    'إرجاع': 'نقبل الإرجاع خلال 7 أيام بحالته الأصلية مع وسومه ↩️',
    'دفع': 'نقبل: تحويل بنكي، بطاقة بنكية، مدى، Tabby، وكاش عند الاستلام 💳',
    'أوقات': 'نعمل من الأحد للخميس 7 صباحاً - 9:30 مساءً ⏰',
    'خصم': 'تابع قناتنا على الواتساب للحصول على آخر العروض والخصومات 🏷️'
  };

  function testMessage() {
    const input = document.getElementById('aiTestInput');
    const chat = document.getElementById('aiTestChat');
    const msg = input.value.trim();
    if (!msg) return;

    // User bubble
    const userBubble = document.createElement('div');
    userBubble.style.display = 'flex';
    userBubble.style.justifyContent = 'flex-end';
    userBubble.innerHTML = `<div style="background:rgba(99,102,241,0.18);border:1px solid rgba(99,102,241,0.2);border-radius:10px 10px 2px 10px;padding:9px 13px;max-width:75%;font-size:0.8rem;color:var(--t1);">${msg}</div>`;
    chat.appendChild(userBubble);
    input.value = '';
    chat.scrollTop = chat.scrollHeight;

    // AI response
    setTimeout(() => {
      let reply = 'شكراً على سؤالك! سيتواصل معك فريق الدعم قريباً 🤖';
      for (const key in aiResponses) {
        if (msg.includes(key)) { reply = aiResponses[key]; break; }
      }
      const aiBubble = document.createElement('div');
      aiBubble.style.display = 'flex';
      aiBubble.style.justifyContent = 'flex-start';
      aiBubble.innerHTML = `<div style="background:var(--bg2);border:1px solid var(--border);border-radius:10px 10px 10px 2px;padding:9px 13px;max-width:85%;font-size:0.8rem;color:var(--t2);">${reply}</div>`;
      chat.appendChild(aiBubble);
      chat.scrollTop = chat.scrollHeight;
    }, 700);
  }

  function testAI() {
    document.getElementById('aiTestInput').focus();
    document.getElementById('aiTestInput').placeholder = 'اكتب سؤالاً لاختبار البوت...';
  }

  // Collect FAQ items from the form
  function collectFAQs() {
    const faqs = [];
    document.querySelectorAll('#faqList .faq-item').forEach(item => {
      const q = item.querySelector('input')?.value?.trim();
      const a = item.querySelector('textarea')?.value?.trim();
      if (q || a) faqs.push({ q: q || '', a: a || '' });
    });
    return faqs;
  }

  // Load saved config into form on page load
  async function loadBotConfig() {
    try {
      const res = await fetch('/bot-config');
      const cfg = await res.json();
      if (!cfg || !Object.keys(cfg).length) return;
      if (cfg.store_training)  document.getElementById('ai_store_training').value = cfg.store_training;
      if (cfg.store_desc && !cfg.store_training) document.getElementById('ai_store_training').value = cfg.store_desc;
      // Legacy fields (hidden, kept for compat)
      // if (cfg.work_hours) ...etc — replaced by store_training
      if (cfg.reply_with_name  === false) document.getElementById('tog_reply_name')?.classList.replace('on','off');
      if (cfg.stop_on_manual   === false) document.getElementById('tog_stop_manual')?.classList.replace('on','off');
      if (cfg.link_products    === false) document.getElementById('tog_link_products')?.classList.replace('on','off');
      if (cfg.multi_lang       === false) document.getElementById('tog_multi_lang')?.classList.replace('on','off');
      if (cfg.manual_resume_after) {
        const sel = document.getElementById('manual_resume_after');
        if (sel) sel.value = String(cfg.manual_resume_after);
      }
    } catch(e) {}
  }
  loadBotConfig();

  // Poll paused contacts every 10s
  async function loadPausedContacts() {
    try {
      const r = await fetch('/whatsapp/manual-paused');
      const d = await r.json();
      const section = document.getElementById('manual_paused_section');
      const list    = document.getElementById('manual_paused_list');
      if (!d.pauses || !d.pauses.length) { section.style.display = 'none'; return; }
      section.style.display = '';
      list.innerHTML = d.pauses.map(p =>
        `<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;font-size:0.8rem;color:var(--t2);">
          <span>📱 ${p.phone} — باقي ${p.remainingMin} د</span>
          <button onclick="resumeManual('${p.phone}')" style="background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;padding:3px 10px;border-radius:6px;font-size:0.72rem;font-weight:700;font-family:inherit;cursor:pointer;">▶ استئناف</button>
        </div>`
      ).join('');
    } catch(e) {}
  }
  async function resumeManual(phone) {
    await fetch(`/whatsapp/manual-resume/${encodeURIComponent(phone)}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
    loadPausedContacts();
  }
  async function resumeAllManual() {
    await fetch('/whatsapp/manual-resume-all', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
    loadPausedContacts();
  }
  loadPausedContacts();
  setInterval(loadPausedContacts, 10000);

  async function saveAITraining() {
    const btn = document.querySelector('[onclick="saveAITraining()"]');
    const orig = btn.textContent;
    btn.textContent = '⏳ جارٍ الحفظ...';
    btn.disabled = true;

    const payload = {
      store_training:   document.getElementById('ai_store_training')?.value || '',
      reply_with_name:     document.getElementById('tog_reply_name')?.classList.contains('on'),
      stop_on_manual:      document.getElementById('tog_stop_manual')?.classList.contains('on'),
      manual_resume_after: parseInt(document.getElementById('manual_resume_after')?.value) || 30,
      link_products:    document.getElementById('tog_link_products')?.classList.contains('on'),
      multi_lang:       document.getElementById('tog_multi_lang')?.classList.contains('on'),
      faqs:             collectFAQs(),
    };

    try {
      const res = await fetch('/bot-config', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify(payload),
      });
      if (res.ok) {
        const alert = document.getElementById('aiSavedAlert');
        alert.style.display = 'flex';
        setTimeout(() => { alert.style.display = 'none'; }, 3500);
      } else {
        alert('حدث خطأ أثناء الحفظ، حاول مرة أخرى.');
      }
    } catch(e) {
      alert('تعذر الاتصال بالخادم.');
    }
    btn.textContent = orig;
    btn.disabled = false;
  }
</script>