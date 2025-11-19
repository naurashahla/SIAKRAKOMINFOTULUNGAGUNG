<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - SIAKRA</title>
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

                    @if(in_array($role, ['admin','super_admin']))
                        <a href="{{ route('events.create') }}" data-target="Buat Agenda"><i class="fas fa-plus"></i> Buat Agenda</a>
                    @endif

                    @if($role === 'super_admin')
                        <a href="{{ route('users.index') }}" data-target="Manajemen User"><i class="fas fa-users"></i> Manajemen User</a>
                        <!-- Manajemen Penerima moved into Manajemen User page (button available there) -->
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
                
                <!-- Center - Navigation Menu (hidden) -->
                <div id="centerNav" class="d-flex align-items-center gap-2" style="display:none !important;">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.index') ? 'active' : '' }}">
                        <i class="fas fa-calendar me-1"></i>
                        Semua Agenda
                    </a>
                    @auth
                        @if(Auth::user())
                            @php $role = strtolower(Auth::user()->role ?? ''); @endphp
                            @if(in_array($role, ['admin','super_admin']))
                                <a href="{{ route('events.create') }}" class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus me-1"></i>
                                    Buat Agenda
                                </a>
                            @endif
                        @endif
                    @endauth
                    <!-- Tambah User button (match Dashboard create button styling) -->
                    @auth
                        @if(strtolower(Auth::user()->role ?? '') === 'super_admin')
                            {{-- Tambah User menu removed per request --}}
                        @endif
                    @endauth
                </div>

                <!-- Right side (match Dashboard spacing) -->
                <div class="dropdown">
                    <button class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
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
        <div class="container py-4">
                <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                <h4 class="mb-0">Daftar Pengguna</h4>
                <div class="d-flex align-items-center gap-2">
                    <!-- Pegawai quick menu: search, bidang filter, add/export (moved into Users header) -->
                    <form id="usersSearchForm" method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center">
                        <input id="pegawaiSearch" type="search" name="pegawai_q" value="{{ request('pegawai_q') }}" class="form-control form-control-sm" placeholder="Cari nama atau email" style="min-width:220px; font-size:13px;" />
                        <select name="pegawai_bidang" class="form-select form-select-sm ms-2" style="font-size:13px;" onchange="this.form.submit()">
                            <option value="">Semua Bidang</option>
                            @foreach($bidangOptions ?? [] as $b)
                                <option value="{{ $b }}" @if(request('pegawai_bidang')===$b) selected @endif>{{ $b }}</option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Primary action: Tambah User (matches Dashboard .btn-create style) -->
                    @auth
                        @if(strtolower(Auth::user()->role ?? '') === 'super_admin')
                            {{-- Tambah User button removed; keep penerima actions but rename label to 'Tambah' --}}
                            <a href="{{ route('users.create') }}" class="btn btn-primary ms-2 btn-sm" style="font-size:13px;"><i class="fas fa-plus me-1"></i> Tambah</a>
                            @if(
                                (function_exists('route') && \Illuminate\Support\Facades\Route::has('users.export'))
                            )
                                <a href="{{ route('users.export') }}?{{ http_build_query(['q' => request('pegawai_q'), 'bidang' => request('pegawai_bidang')]) }}" class="btn btn-outline-success ms-2 btn-sm" style="font-size:13px;">Export CSV</a>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Manajemen Pengguna & Penerima</strong>
                        <div class="text-muted small">Menampilkan semua akun dan penerima</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama</th>
                                    <th>Email</th>
                                    <th style="min-width:120px">Role</th>
                                    <th style="min-width:160px">Bidang</th>
                                    <th>Jabatan</th>
                                    <th class="text-end pe-4" style="min-width:160px; white-space:nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($people as $p)
                                <tr>
                                    <td class="ps-4">{{ $p['name'] }}</td>
                                    <td>{{ $p['email'] }}</td>
                                    <td>
                                        @if($p['type'] === 'user')
                                            @php $role = isset($p['role']) && $p['role'] ? strtolower($p['role']) : 'user'; @endphp
                                            @if($role === 'admin')
                                                <span class="badge text-white" style="background: linear-gradient(90deg,#20c997,#2fbf84);padding:0.35rem 0.65rem;border-radius:0.5rem;font-weight:600;">Admin</span>
                                            @elseif($role === 'user')
                                                <span class="badge text-white" style="background: linear-gradient(90deg,#0d6efd,#2b8cff);padding:0.35rem 0.65rem;border-radius:0.5rem;font-weight:600;">User</span>
                                            @elseif($role === 'super_admin')
                                                <span class="badge text-white" style="background: linear-gradient(90deg,#f59e0b,#f97316);padding:0.35rem 0.65rem;border-radius:0.5rem;font-weight:600;">Super Admin</span>
                                            @else
                                                <span class="badge bg-secondary" style="padding:0.35rem 0.65rem;border-radius:0.5rem;font-weight:600;">{{ ucwords(str_replace('_',' ', $role)) }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $p['bidang'] ?? '-' }}</td>
                                    <td>{{ $p['jabatan'] ?? '-' }}</td>
                                    <td class="text-end pe-4" style="min-width:160px; white-space:nowrap">
                                        @if($p['type'] === 'user')
                                            @php
                                                // preserve current page and filters so edit can return to the same listing state
                                                $returnTo = request()->getRequestUri();
                                                $editUrl = url('/users/' . $p['id'] . '/edit') . '?return_to=' . urlencode($returnTo);
                                            @endphp
                                            <a href="{{ $editUrl }}" class="btn btn-sm btn-outline-warning me-1" title="Edit"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="{{ route('users.destroy', $p['id']) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @else
                                            @php
                                                $returnTo = request()->getRequestUri();
                                                $pegEditUrl = url('/pegawai/' . $p['id'] . '/edit') . '?return_to=' . urlencode($returnTo);
                                            @endphp
                                            <a href="{{ $pegEditUrl }}" class="btn btn-sm btn-outline-warning me-1" title="Edit" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:6px;"><i class="fas fa-edit" style="font-size:14px"></i></a>
                                            <form method="POST" action="{{ route('pegawai.destroy', $p['id']) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerima ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:6px;"><i class="fas fa-trash" style="font-size:14px"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada pengguna atau penerima.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 d-flex align-items-center justify-content-between px-4">
                    <div class="me-3" style="font-size:15px; font-weight:600; color:#374151;">
                        Menampilkan {{ $people->firstItem() ?? 0 }} sampai {{ $people->lastItem() ?? 0 }} dari {{ $people->total() ?? 0 }} hasil
                    </div>
                    <div class="pe-3">
                        {!! $people->appends(request()->query())->links('pagination::bootstrap-5') !!}
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

            const NAV_KEY = 'siakra:selectedNav';

            function open(){
                if(!off) return;
                off.classList.add('open');
                off.setAttribute('aria-hidden','false');
                document.documentElement.classList.add('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.add('nav-hidden');
                if(offBackdrop && offBackdrop.classList) offBackdrop.classList.add('show');
            }

            function close(){
                if(!off) return;
                off.classList.remove('open');
                off.setAttribute('aria-hidden','true');
                document.documentElement.classList.remove('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.remove('nav-hidden');
                if(offBackdrop && offBackdrop.classList) offBackdrop.classList.remove('show');
            }

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
                }catch(err){ console.error('restore selected nav failed', err); }
            });

            if(brandToggle) brandToggle.addEventListener('click', function(e){ e.preventDefault(); if(off && off.classList.contains('open')) close(); else open(); });
            if(offBackdrop) offBackdrop.addEventListener('click', function(){ close(); });
            // Also listen for pointerdown in capturing phase to close reliably
            document.addEventListener('pointerdown', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){}
            }, true);

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';

                        try{ const payload = { title: t, href: href, html: a.innerHTML }; localStorage.setItem(NAV_KEY, JSON.stringify(payload)); }catch(err){ }

                        close();

                        const center = document.getElementById('centerNav');
                        if(center){
                            center.innerHTML = '';
                            const single = document.createElement('a');
                            single.className = 'nav-link active';
                            single.href = href;
                            single.innerHTML = a.innerHTML;
                            center.appendChild(single);
                        }
                    });
                });
            }

            document.querySelectorAll('.navbar-brand').forEach(el=>{
                el.addEventListener('click', function(){ try{ localStorage.removeItem(NAV_KEY); }catch(e){} });
            });

            document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
        })();
    </script>
        <script>
            // Debounced auto-submit for users search input
            (function(){
                try{
                    const input = document.getElementById('pegawaiSearch');
                    const form = document.getElementById('usersSearchForm');
                    if(!input || !form) return;

                    let timer = null;
                    const debounceMs = 300; // adjust as needed

                    input.addEventListener('input', function(){
                        // Clear previous timer
                        if(timer) clearTimeout(timer);
                        timer = setTimeout(function(){
                            // Submit the form via GET preserving other controls
                            form.submit();
                        }, debounceMs);
                    });

                    // If user explicitly presses Enter, let the browser submit immediately
                    input.addEventListener('keydown', function(e){
                        if(e.key === 'Enter'){
                            if(timer) clearTimeout(timer);
                            form.submit();
                        }
                    });
                }catch(err){ console.error('search auto-submit init failed', err); }
            })();
        </script>
</body>
</html>
