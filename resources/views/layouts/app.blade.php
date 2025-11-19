<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIAKRA')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 20px;
            color: #0f172a !important;
            text-decoration: none;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #64748b !important;
            font-weight: 600;
            padding: 8px 16px !important;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            letter-spacing: 0.02em;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-create {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-create:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
        }

        /* Main Content */
        .main-content {
            padding: 12px 20px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        /* Stats Cards Row */
        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            flex: 1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: inherit !important;
            text-decoration: none !important;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .stat-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-icon.blue { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white;
        }
        .stat-icon.green { 
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); 
            color: white;
        }
        .stat-icon.yellow { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
            color: white;
        }
        .stat-icon.cyan { 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
            color: white;
        }

        .stat-content h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .stat-content p {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        /* Content Sections */
        .content-row {
            display: flex;
            gap: 20px;
            height: calc(100vh - 200px);
        }

        .content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .section-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .events-section {
            flex: 1;
        }

        .events-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .event-item-link {
            text-decoration: none;
            color: inherit;
            display: block;
            margin-bottom: 12px;
        }

        .event-item-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .event-item-link:last-child {
            margin-bottom: 0;
        }

        .event-item {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            background: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .event-item:hover {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .event-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }

        .event-header-left {
            flex: 1;
        }

        .event-item-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 4px 0;
        }

        .event-meta-line {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .event-schedule {
            color: #6b7280;
        }

        .event-description-inline {
            color: #9ca3af;
        }

        .event-recipients {
            font-size: 12px;
            color: #9ca3af;
            /* color: #3b82f6; */
        }

        .sent-btn {
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: default;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .event-item:hover .sent-btn {
            background: #3b82f6;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 32px;
            margin-bottom: 12px;
        }

        /* User dropdown */
        .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown {
            background: transparent;
            border: none;
            color: #6b7280;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-dropdown:hover {
            color: #374151;
        }

        .dropdown-menu {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 14px;
            color: #374151;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-row {
                flex-direction: column;
                gap: 12px;
            }

            .content-row {
                flex-direction: column;
                height: auto;
            }
        }
        /* Off-canvas sidebar (minimal) */
        .offsidebar{
            position:fixed; left:0; top:0; height:100vh; width:260px; background:#fff; border-right:1px solid #e5e7eb; box-shadow:2px 0 18px rgba(2,6,23,0.06); transform:translateX(-300px); transition:transform .25s ease; z-index:1200; padding-top:18px;
        }
        .offsidebar.open{ transform:translateX(0); }
    .offsidebar .close-btn{ position:absolute; right:8px; top:8px; background:none;border:none;font-size:18px;cursor:pointer;color:#374151 }
    .offsidebar nav a{ display:flex; align-items:center; gap:10px; padding:10px 16px; color:#374151; text-decoration:none; font-weight:600; border-radius:8px; margin:6px 10px }
        .offsidebar nav a:hover{ background:linear-gradient(135deg,#f1f5f9,#e2e8f0); color:#0f172a }
        /* Icon styling to match Semua Agenda sidebar */
        .offsidebar nav a i{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:36px;
            height:36px;
            border-radius:8px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59,130,246,0.18);
            font-size:14px;
        }
    /* Push layout when sidebar open on desktop */
    :root.sidebar-open .navbar, :root.sidebar-open .main-content{ margin-left:260px; transition:margin-left .25s ease }
    /* Hide navbar when necessary */
    .navbar.nav-hidden{ display:none !important }
        @media (max-width:768px){ :root.sidebar-open .navbar, :root.sidebar-open .main-content{ margin-left:0 } }
    </style>
</head>
<body>
    <!-- Off-canvas sidebar and backdrop -->
    <div id="offBackdrop" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.06); z-index:1100;"></div>
    <aside id="offsidebar" class="offsidebar" aria-hidden="true">
        <div style="padding:0 16px;margin-bottom:8px;">
            <div class="navbar-brand" style="font-size:22px; display:inline-block; font-weight:800; letter-spacing:0.5px; margin-left:10px; margin-top:4px; background: linear-gradient(135deg,#3b82f6,#1e40af); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">SIAKRA</div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" data-target="Dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('events.index') }}" data-target="Semua Agenda"><i class="fas fa-calendar"></i> Semua Agenda</a>
            @auth
                @if(Auth::user())
                    @php $role = strtolower(Auth::user()->role ?? ''); @endphp

                    @if(in_array($role, ['admin', 'super_admin']))
                        <a href="{{ route('events.create') }}" data-target="Buat Agenda"><i class="fas fa-plus"></i> Buat Agenda</a>
                    @endif

                    @if($role === 'super_admin')
                        <a href="{{ route('users.index') }}" data-target="Manajemen User"><i class="fas fa-users"></i> Manajemen User</a>
                        <!-- Manajemen Penerima removed from global sidebar; accessible from Manajemen User page -->
                    @endif
                @endif
            @endauth
        </nav>
        <div style="position:absolute; bottom:16px; width:100%; padding:0 12px">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-100 text-start" style="background:none;border:none;padding:10px;color:#64748b;font-weight:600"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
            </form>
        </div>
        </aside>
    <style>
        body{ font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; background:#f8f9fa; }
        .navbar{ background:linear-gradient(135deg,#fff,#f8fafc); border-bottom:1px solid #e5e7eb; padding:10px 0; }
        .page-title { font-weight:700; font-size:18px; }
        .container-main{ padding-top:22px; }

        /* Off-canvas sidebar (shared with dashboard) */
        .offsidebar{ position:fixed; left:0; top:0; height:100vh; width:260px; background:#fff; border-right:1px solid #e5e7eb; box-shadow:2px 0 18px rgba(2,6,23,0.06); transform:translateX(-300px); transition:transform .25s ease; z-index:1200; padding-top:18px; }
        .offsidebar.open{ transform:translateX(0); }
        .offsidebar .close-btn{ position:absolute; right:8px; top:8px; background:none;border:none;font-size:18px;cursor:pointer;color:#374151 }
        .offsidebar nav a{ display:flex; align-items:center; gap:10px; padding:10px 16px; color:#374151; text-decoration:none; font-weight:600; border-radius:8px; margin:6px 10px }
        .offsidebar nav a:hover{ background:linear-gradient(135deg,#f1f5f9,#e2e8f0); color:#0f172a }
        .offsidebar nav a i{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:36px;
            height:36px;
            border-radius:8px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59,130,246,0.18);
            font-size:14px;
        }
        /* Push layout when sidebar open on desktop */
        :root.sidebar-open .navbar, :root.sidebar-open .container-main{ margin-left:260px; transition:margin-left .25s ease }
        @media (max-width:768px){ :root.sidebar-open .navbar, :root.sidebar-open .container-main{ margin-left:0 } }

        /* Centralized backdrop style for sidebar -- use a subtle gray overlay to match dashboard look */
    .off-backdrop{ display:block; position:fixed; inset:0; background:rgba(15,23,42,0.06); z-index:1100; opacity:0; pointer-events:none; transition:opacity .18s ease; }
    .off-backdrop.show{ opacity:1; pointer-events:auto; }

    /* Navbar link styles copied from dashboard for consistent header nav */
    .nav-link { color: #64748b !important; font-weight: 600; padding: 8px 16px !important; text-decoration: none; border-radius: 8px; transition: all 0.3s ease; font-size: 14px; letter-spacing: 0.02em; }
    .nav-link:hover { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #1e293b !important; transform: translateY(-1px); }
    .nav-link.active { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white !important; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .btn-create { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px; transition: all 0.3s ease; letter-spacing: 0.02em; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3); }
    .btn-create:hover { background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4); }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Off-canvas sidebar backdrop and sidebar -->
    <div id="offBackdrop" class="off-backdrop"></div>
    <aside id="offsidebar" class="offsidebar" aria-hidden="true">
        <div style="padding:0 16px;margin-bottom:8px;">
            <div class="navbar-brand" style="font-size:22px; display:inline-block; font-weight:800; letter-spacing:0.5px; margin-left:10px; margin-top:4px; background: linear-gradient(135deg,#3b82f6,#1e40af); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">SIAKRA</div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" data-target="Dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('events.index') }}" data-target="Semua Agenda"><i class="fas fa-calendar"></i> Semua Agenda</a>
            @auth
                @if(Auth::user())
                    @php $role = strtolower(Auth::user()->role ?? ''); @endphp

                    @if(in_array($role, ['admin', 'super admin']))
                        <a href="{{ route('events.create') }}" data-target="Buat Agenda"><i class="fas fa-plus"></i> Buat Agenda</a>
                    @endif

                    @if($role === 'super admin')
                        <a href="{{ route('users.index') }}" data-target="Manajemen User"><i class="fas fa-users"></i> Manajemen User</a>
                        <!-- Manajemen Penerima removed from layout sidebar; use 'Kelola Penerima' from Manajemen User page -->
                    @endif
                @endif
            @endauth
        </nav>
        <div style="position:absolute; bottom:16px; width:100%; padding:0 12px">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-100 text-start" style="background:none;border:none;padding:10px;color:#64748b;font-weight:600"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <nav class="navbar">
        <div class="container">
            <!-- <div class="d-flex align-items-center justify-content-between w-100"> -->
                <!-- Left side - Brand + hamburger -->
                <!-- <div class="d-flex align-items-center">
                    <span id="brandToggle" style="cursor:pointer; margin-right:10px;"><i class="fas fa-bars me-2"></i></span>
                    <a href="{{ route('dashboard') ?? url('/') }}" class="me-3 page-title text-decoration-none text-dark">SIAKRA</a>
                </div> -->
                <div class="navbar-brand" style="display:flex;align-items:center;gap:8px;">
                    <span id="brandToggle" style="cursor:pointer"><i class="fas fa-bars me-2"></i></span>
                    <span>SIAKRA</span>
                </div>

                <!-- Center - Navigation Menu (hidden) -->
                <div id="centerNav" class="d-flex align-items-center gap-2" style="display:none !important;">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'nav-link active' : 'nav-link' }}">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'nav-link active' : 'nav-link' }}">
                        <i class="fas fa-calendar me-1"></i>
                        Semua Agenda
                    </a>
                    @auth
                        @if(in_array(strtolower(Auth::user()->role ?? ''), ['admin','super admin']))
                            <a href="{{ route('events.create') }}" class="{{ request()->routeIs('events.create') ? 'nav-link active' : 'nav-link' }} btn-create">
                                <i class="fas fa-plus me-1"></i>
                                Buat Agenda
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Right side -->
                <div>
                    <div class="dropdown">
                        <button class="user-dropdown dropdown-toggle btn btn-light" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::user()->name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container container-main">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
            const off = document.getElementById('offsidebar');
            const brandToggle = document.getElementById('brandToggle');
            const offBackdrop = document.getElementById('offBackdrop');
            const NAV_KEY = 'siakra:selectedNav';

            function open(){
                if(!off) return;
                off.classList.add('open');
                off.setAttribute('aria-hidden','false');
                document.documentElement.classList.add('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.add('nav-hidden');
                if(offBackdrop) offBackdrop.classList.add('show');
            }

            function close(){
                if(!off) return;
                off.classList.remove('open');
                off.setAttribute('aria-hidden','true');
                document.documentElement.classList.remove('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.remove('nav-hidden');
                if(offBackdrop) offBackdrop.classList.remove('show');
            }

            if(brandToggle) brandToggle.addEventListener('click', function(e){ e.preventDefault(); if(off && off.classList.contains('open')) close(); else open(); });
            if(offBackdrop) offBackdrop.addEventListener('click', function(){ close(); });

            // Close sidebar when clicking anywhere outside the sidebar (covers pages where per-page handlers didn't close)
            document.addEventListener('click', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    // If click is inside the sidebar or on the toggle button, do nothing
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    // Otherwise close
                    close();
                }catch(err){ /* ignore */ }
            }, true);

            // Also listen for pointerdown in capturing phase to catch touch and pointer events earlier
            document.addEventListener('pointerdown', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){}
            }, true);

            // Restore persisted selection on page load
            document.addEventListener('DOMContentLoaded', function(){
                try {
                    const stored = localStorage.getItem(NAV_KEY);
                    const center = document.getElementById('centerNav');
                    if (stored && center) {
                        const data = JSON.parse(stored);

                        // Only restore the persisted single-nav if it matches the current page
                        // This prevents a previously-clicked link (e.g. "Buat Agenda") from
                        // replacing the normal center navigation when visiting a different route.
                        try {
                            const storedUrl = new URL(data.href, window.location.origin);
                            const currentUrl = new URL(window.location.href);

                            if (storedUrl.pathname === currentUrl.pathname) {
                                center.innerHTML = '';
                                const single = document.createElement('a');
                                single.className = 'nav-link active';
                                single.href = data.href || '{{ url('/') }}';
                                single.innerHTML = data.html || (data.title || '');
                                center.appendChild(single);
                            }
                        } catch (e) {
                            // If URL parsing fails, don't override the center nav
                            console.warn('stored nav href parse failed, skipping restore', e);
                        }
                    }
                } catch(err){ console.error('restore selected nav failed', err); }
            });

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        // Prevent default navigation so we can close the sidebar first and then navigate reliably
                        try{ e.preventDefault(); }catch(err){}

                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';

                        try{ localStorage.setItem(NAV_KEY, JSON.stringify({ title: t, href: href, html: a.innerHTML })); }catch(e){}
                        // Update center nav immediately for snappy feedback
                        const center = document.getElementById('centerNav');
                        if(center){ center.innerHTML = ''; const single = document.createElement('a'); single.className = 'nav-link active'; single.href = href; single.innerHTML = a.innerHTML; center.appendChild(single); }

                        // Close the sidebar and navigate after a small delay to allow the close animation
                        close();
                        setTimeout(function(){
                            try{ if(href && href !== '#') window.location.href = href; }catch(err){}
                        }, 180);
                    });
                });
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
