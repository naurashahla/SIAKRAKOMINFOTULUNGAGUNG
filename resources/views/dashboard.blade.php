<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor - SIAKRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            max-height: 100vh;
            overflow: hidden;
        }

        /* Header Navigation */
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
        /* Icon styling to match Semua Agenda / Dashboard canonical sidebar */
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
        /* Notification status colors (used for dashboard/event badges) */
        .notification-pending { background: #7a7a7aff; }
        .notification-sent { background: #10b981; }
        .notification-failed { background: #ef4444; }
        /* Small status dot used next to event actions */
        .notification-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            vertical-align: middle;
        }
        .event-right-controls { display:flex; align-items:center; gap:8px; }
    </style>
</head>
<body>
    <!-- Off-canvas sidebar -->
    <!-- Backdrop: clicking this will close the sidebar -->
    <div id="offBackdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.16); z-index:1100;"></div>
        <aside id="offsidebar" class="offsidebar" aria-hidden="true">
        <div style="padding:0 16px;margin-bottom:8px;">
            <div class="navbar-brand" style="font-size:22px; display:inline-block; font-weight:800; letter-spacing:0.5px; margin-left:10px; margin-top:4px;">SIAKRA</div>
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
                        <!-- Manajemen Penerima removed from dashboard sidebar; accessible via Manajemen User -->
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
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <!-- Left side - Brand (non-clickable text) -->
                <div class="navbar-brand" style="display:flex;align-items:center;gap:8px;">
                    <span id="brandToggle" style="cursor:pointer"><i class="fas fa-bars me-2"></i></span>
                    <span>SIAKRA</span>
                </div>
                
                <!-- Center - Navigation Menu (dashboard page: show only Dashboard) -->
                <div id="centerNav" class="d-flex align-items-center gap-2" style="display:none !important;">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                </div>

                <!-- Right side -->
                <div class="dropdown">
                    <button class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Stats Cards Row -->
            <div class="stats-row">
                <a href="{{ route('events.index', ['date_filter' => 'today']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                    <div class="stat-icon blue">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $todaysCount }}</h3>
                        <p>Agenda Hari Ini</p>
                    </div>
                </a>
                <a href="{{ route('events.index', ['date_filter' => 'tomorrow']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                    <div class="stat-icon green">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $tomorrowCount ?? 0 }}</h3>
                        <p>Agenda Besok</p>
                        <small style="font-size: 11px; color: #9ca3af;">Terjadwal besok</small>
                    </div>
                </a>
                <a href="{{ route('events.index', ['status' => 'upcoming']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                    <div class="stat-icon yellow">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $upcomingCount }}</h3>
                        <p>Agenda Mendatang</p>
                        <small style="font-size: 11px; color: #9ca3af;">Akan datang</small>
                    </div>
                </a>
                <a href="{{ route('events.index', ['date_filter' => 'all_events']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                    <div class="stat-icon cyan">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $totalEvents }}</h3>
                        <p>Total Agenda</p>
                        <small style="font-size: 11px; color: #9ca3af;">Sepanjang masa</small>
                    </div>
                </a>
            </div>

            <!-- Content Row -->
            <div class="content-row">
                <!-- Left Content -->
                <div class="content-left">
                    <!-- Today's Events -->
                    <div class="section-card events-section">
                        <h5 class="section-title">
                            <i class="fas fa-calendar"></i>
                            Agenda Diskominfo Tulungagung Hari Ini
                        </h5>
                        @if($todaysEvents->count() > 0)
                            <div class="events-list">
                                @foreach($todaysEvents as $event)
                                    <a href="{{ route('events.show', $event) }}" class="event-item-link">
                                        <div class="event-item">
                                            <div class="event-item-header">
                                                <div class="event-header-left">
                                                    <h6 class="event-item-title">{{ $event->title }}</h6>
                                                    <div class="event-meta-line">
                                                        <span class="event-schedule">
                                                            Hari Ini
                                                            @if($event->startTime)
                                                                pukul {{ $event->startTime }}
                                                            @endif
                                                        </span>
                                                        @if($event->description)
                                                            <span class="event-description-inline"> • {{ Str::limit($event->description, 40) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="event-recipients">
                                                        {{ $event->recipients->count() }} penerima
                                                    </div>
                                                </div>
                                                <div class="event-right-controls">
                                                    <span class="notification-dot notification-{{ $event->notification_status ?? 'pending' }}" title="{{ ucfirst($event->notification_status ?? 'pending') }}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <p class="mb-0">Tidak ada Agenda hari ini</p>
                            </div>
                        @endif
                    </div>

                    <!-- Upcoming Events -->
                    <div class="section-card events-section">
                        <h5 class="section-title">
                            <i class="fas fa-clock"></i>
                            Agenda Diskominfo Tulungagung Mendatang
                        </h5>
                        @if($upcomingEvents->count() > 0)
                            <div class="events-list">
                                @foreach($upcomingEvents as $event)
                                    <a href="{{ route('events.show', $event) }}" class="event-item-link">
                                        <div class="event-item">
                                            <div class="event-item-header">
                                                <div class="event-header-left">
                                                    <h6 class="event-item-title">{{ $event->title }}</h6>
                                                    <div class="event-meta-line">
                                                        <span class="event-schedule">
                                                            {{ $event->startDate->format('D, M j') }}
                                                            @if($event->startTime)
                                                                pukul {{ $event->startTime }}
                                                            @endif
                                                        </span>
                                                        @if($event->description)
                                                            <span class="event-description-inline"> • {{ Str::limit($event->description, 40) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="event-recipients">
                                                        {{ $event->recipients->count() }} penerima
                                                    </div>
                                                </div>
                                                <div class="event-right-controls">
                                                    <span class="notification-dot notification-{{ $event->notification_status ?? 'pending' }}" title="{{ ucfirst($event->notification_status ?? 'pending') }}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <p class="mb-0">Tidak ada Agenda mendatang</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
            const off = document.getElementById('offsidebar');
            const brandToggle = document.getElementById('brandToggle');
            const offBackdrop = document.getElementById('offBackdrop');
            const pageTitle = document.getElementById('pageTitle');

            const NAV_KEY = 'siakra:selectedNav';

            function open(){
                if(!off) return;
                off.classList.add('open');
                off.setAttribute('aria-hidden','false');
                document.documentElement.classList.add('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.add('nav-hidden'); // hide navbar when sidebar opens
                if(offBackdrop) offBackdrop.style.display = 'block';
            }

            function close(){
                if(!off) return;
                off.classList.remove('open');
                off.setAttribute('aria-hidden','true');
                document.documentElement.classList.remove('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.remove('nav-hidden');
                if(offBackdrop) offBackdrop.style.display = 'none';
            }

            // Restore persisted selection on page load (if any)
            document.addEventListener('DOMContentLoaded', function(){
                try{
                    const stored = localStorage.getItem(NAV_KEY);
                    const center = document.getElementById('centerNav');
                    if(stored && center){
                        const data = JSON.parse(stored);
                        center.innerHTML = '';
                        const single = document.createElement('a');
                        single.className = 'nav-link active';
                        single.href = data.href || '#';
                        single.innerHTML = data.html || (data.title || '');
                        center.appendChild(single);
                    }
                }catch(err){
                    // if parse fails, ignore and continue
                    console.error('restore selected nav failed', err);
                }
            });

            if(brandToggle) brandToggle.addEventListener('click', function(e){ e.preventDefault(); if(off && off.classList.contains('open')) close(); else open(); });
            if(offBackdrop) offBackdrop.addEventListener('click', function(){ close(); });

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';
                        // update page title (if present)
                        if(pageTitle && t) pageTitle.textContent = t;

                        // persist the selection so it survives a full page reload
                        try{
                            const payload = { title: t, href: href, html: a.innerHTML };
                            localStorage.setItem(NAV_KEY, JSON.stringify(payload));
                        }catch(err){ console.error('localStorage set failed', err); }

                        // close sidebar and make navbar visible again
                        close();
                        const navbar = document.querySelector('.navbar');
                        if(navbar) navbar.classList.remove('nav-hidden');

                        // immediately replace the center nav for a snappy feel
                        const center = document.getElementById('centerNav');
                        if(center){
                            center.innerHTML = '';
                            const single = document.createElement('a');
                            single.className = 'nav-link active';
                            single.href = href;
                            single.innerHTML = a.innerHTML;
                            center.appendChild(single);
                        }

                        // let the browser follow the link normally
                    });
                });
            }

            // clicking the brand clears the stored selection (returns to normal nav)
            document.querySelectorAll('.navbar-brand').forEach(el=>{
                el.addEventListener('click', function(){
                    try{ localStorage.removeItem(NAV_KEY); }catch(e){}
                });
            });

            document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
        })();
    </script>
</body>
</html>