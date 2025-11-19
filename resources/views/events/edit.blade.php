<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Agenda - SIAKRA</title>
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
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            font-size: 13px;
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

        .btn-create i {
            margin-right: 6px;
        }

        /* Main Content */
        .main-content {
            max-width: 550px;
            margin: 0 auto;
            padding: 20px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .form-container {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 3px;
            display: block;
        }

        .form-control {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 13px;
            transition: all 0.2s ease;
            width: 100%;
            color: #1f2937;
            height: 32px;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 60px;
            height: auto;
        }

        .row {
            margin: 0 -8px;
        }

        .col-6 {
            padding: 0 8px;
        }

        .form-select {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 13px;
            color: #1f2937;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%6494a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 6px center;
            background-repeat: no-repeat;
            background-size: 14px;
            padding-right: 30px;
            height: 32px;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: white;
        }

        .selected-count {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-cancel {
            background: transparent;
            color: #6b7280;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #f9fafb;
            color: #374151;
            text-decoration: none;
        }

        .btn-save {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 16px;
            font-size: 14px;
            padding: 12px 16px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        /* User dropdown */
        .dropdown-toggle::after {
            display: none;
        }

        .user-dropdown {
            background: transparent;
            border: none;
            color: #64748b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            color: #1e293b;
        }

        .dropdown-menu {
            border: 1px solid #e2e8f0;
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
            background: #f1f5f9;
            color: #1f2937;
        }

        /* Search input styling */
        .search-input {
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            width: 100%;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .search-input::placeholder {
            color: #94a3b8;
            font-style: italic;
        }

        /* File Upload Styling */
        .file-upload-container {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 16px;
            background: #fafafa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-container:hover {
            border-color: #3b82f6;
            background: #f8faff;
        }

        .file-upload-container.has-file {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-info {
            text-align: center;
            color: #6b7280;
            pointer-events: none;
        }

        .file-upload-info i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
            color: #9ca3af;
        }

        .file-upload-container:hover .file-upload-info i {
            color: #3b82f6;
        }

        .file-text {
            font-size: 13px;
            font-weight: 500;
        }

        .file-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            margin-top: 8px;
        }

        .file-preview-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .file-icon {
            font-size: 24px;
            color: #3b82f6;
        }

        .file-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .file-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }

        .file-size {
            font-size: 12px;
            color: #6b7280;
        }

        .remove-file {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 4px;
            padding: 4px 6px;
            color: #dc2626;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .remove-file:hover {
            background: #fecaca;
            border-color: #f87171;
        }

        .remove-file i {
            font-size: 12px;
        }

        /* Calendar Widget Styles */
        .calendar-menu-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .calendar-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            z-index: 10;
        }

        .calendar-toggle:hover {
            color: #3b82f6;
        }

        .calendar-widget {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 260px;
            padding: 12px;
            display: none;
            font-family: 'Inter', sans-serif;
            /* Constrain popup height so it doesn't stretch the page; allow scrolling inside */
            max-height: 380px;
            overflow-y: auto;
        }

        .calendar-widget.show {
            display: block;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .calendar-month-year {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }

        .calendar-nav-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .calendar-nav-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            row-gap: 6px;
            margin-bottom: 8px;
        }

        /* When day containers are wrapped with an inner div, use display:contents
           so generated day buttons participate directly in the grid layout instead
           of stacking inside a single grid cell. This prevents the tall/column
           layout seen when the days are appended into a wrapper element. */
        #startDate-days, #endDate-days {
            display: contents;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            padding: 4px 2px;
        }

        .calendar-day {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.2s ease;
            color: #1f2937;
            font-weight: 500;
        }

        .calendar-day:hover {
            background: #f3f4f6;
        }

        .calendar-day.today {
            background: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .calendar-day.selected {
            background: #1d4ed8;
            color: white;
            font-weight: 600;
        }

        .calendar-day.other-month {
            color: #d1d5db;
        }

        .calendar-day.disabled {
            color: #e5e7eb;
            cursor: not-allowed;
        }

        .calendar-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            gap: 6px;
        }

        .calendar-btn {
            padding: 4px 10px;
            font-size: 11px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            flex: 1;
            text-align: center;
        }

        .calendar-btn.clear {
            background: #f9fafb;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .calendar-btn.clear:hover {
            background: #f3f4f6;
        }

        .calendar-btn.today {
            background: #3b82f6;
            color: white;
        }

        .calendar-btn.today:hover {
            background: #2563eb;
        }

        .date-input-enhanced {
            padding-right: 32px;
        }

        /* Event indicator styles */
        .calendar-day.has-events {
            position: relative;
            background: #f0f9ff;
            border: 1px solid #3b82f6;
        }

        .calendar-day.has-events::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 6px;
            height: 6px;
            background: #3b82f6;
            border-radius: 50%;
        }

        .calendar-day.has-events:hover {
            background: #dbeafe;
        }

        /* Event popup styles */
        .event-popup {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        .event-popup.show {
            display: block;
        }

        .event-popup-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            background: #f9fafb;
        }

        .event-popup-content {
            padding: 8px 0;
        }

        .event-item {
            padding: 8px 16px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .event-item:hover {
            background: #f9fafb;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-title {
            font-size: 13px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .event-time {
            font-size: 11px;
            color: #6b7280;
        }

        .event-actions {
            padding: 8px 16px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            display: flex;
            justify-content: space-between;
        }

        .event-action-btn {
            padding: 4px 8px;
            font-size: 11px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .event-action-btn.select {
            background: #3b82f6;
            color: white;
        }

        .event-action-btn.select:hover {
            background: #2563eb;
        }

        .event-action-btn.close {
            background: #f3f4f6;
            color: #6b7280;
        }

        .event-action-btn.close:hover {
            background: #e5e7eb;
        }

        /* Responsive adjustments */
        @media (max-height: 800px) {
            .main-content {
                margin: 10px auto;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .form-title {
                font-size: 18px;
                margin-bottom: 16px;
            }
            
            .form-group {
                margin-bottom: 12px;
            }
            
            textarea.form-control {
                min-height: 50px;
            }
        }

        @media (max-height: 700px) {
            .navbar {
                padding: 6px 0;
            }
            
            .main-content {
                margin: 5px auto;
                max-height: calc(100vh - 60px);
            }
            
            .form-container {
                padding: 16px;
            }
            
            .form-title {
                font-size: 16px;
                margin-bottom: 12px;
            }
            
            .form-group {
                margin-bottom: 10px;
            }
            
            .form-control {
                height: 32px;
                padding: 6px 8px;
                font-size: 12px;
            }
            
            .form-select {
                height: 32px;
                padding: 6px 8px;
                font-size: 12px;
            }
            
            textarea.form-control {
                min-height: 40px;
            }
            
            .form-actions {
                margin-top: 16px;
                padding-top: 12px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 0 10px;
            }
            
            .row {
                margin: 0;
            }
            
            .col-6 {
                padding: 0 5px;
            }
        }
        /* Off-canvas sidebar (shared with dashboard) */
        .offsidebar{
            position:fixed; left:0; top:0; height:100vh; width:260px; background:#fff; border-right:1px solid #e5e7eb; box-shadow:2px 0 18px rgba(2,6,23,0.06); transform:translateX(-300px); transition:transform .25s ease; z-index:1200; padding-top:18px;
        }
        .offsidebar.open{ transform:translateX(0); }
    .offsidebar .close-btn{ position:absolute; right:8px; top:8px; background:none;border:none;font-size:18px;cursor:pointer;color:#374151 }
        .offsidebar nav a{ display:flex; align-items:center; gap:10px; padding:10px 16px; color:#374151; text-decoration:none; font-weight:600; border-radius:8px; margin:6px 10px }
        .offsidebar nav a:hover{ background:linear-gradient(135deg,#f1f5f9,#e2e8f0); color:#0f172a }
        /* Icon styling to match dashboard's blue gradient */
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
        /* Backdrop for off-canvas sidebar (dashboard style) */
        .off-backdrop{ display:block; position:fixed; inset:0; background:rgba(15,23,42,0.06); z-index:1100; opacity:0; pointer-events:none; transition:opacity .18s ease; }
        .off-backdrop.show{ opacity:1; pointer-events:auto; }
    /* Push layout when sidebar open on desktop: move navbar and adjust main-content so it stays centered (match create page behavior) */
    :root.sidebar-open .navbar, :root.sidebar-open .main-content { margin-left:260px; transition:margin-left .25s ease }

    /* Keep the main-content centered within the remaining viewport when the sidebar is open.
       The page uses a fixed max-width (550px) for the content area, so we offset the left margin
       by 260px (sidebar width) plus half of the remaining free space so the form stays centered
       without changing its width. This avoids shifting the form to the left when the sidebar opens. */
    :root.sidebar-open .main-content {
        margin-left: calc(260px + ((100% - 260px) - 550px) / 2);
    }
        /* Hide navbar when necessary */
        .navbar.nav-hidden{ display:none !important }
    @media (max-width:768px){ :root.sidebar-open .navbar, :root.sidebar-open .main-content{ margin-left:0 } }
    </style>
</head>
<body>
    <!-- Off-canvas sidebar -->
    <!-- Backdrop: clicking this will close the sidebar -->
    <div id="offBackdrop" class="off-backdrop" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.06); z-index:1100;"></div>
    <aside id="offsidebar" class="offsidebar" aria-hidden="true">
        <div style="padding:0 16px;margin-bottom:8px;">
            <div class="navbar-brand" style="font-size:22px; display:inline-block; font-weight:800; letter-spacing:0.5px; margin-left:10px; margin-top:4px;">SIAKRA</div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" data-target="Dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('events.index') }}" data-target="Semua Agenda"><i class="fas fa-calendar"></i> Semua Agenda</a>
            @auth
                @if(Auth::user())
                    @php $role = strtolower(Auth::user()->role); @endphp

                    @if(in_array($role, ['admin', 'super_admin']))
                        <a href="{{ route('events.create') }}" data-target="Buat Agenda"><i class="fas fa-plus"></i> Buat Agenda</a>
                    @endif

                        @if($role === 'super_admin')
                        <a href="{{ route('users.index') }}" data-target="Manajemen User"><i class="fas fa-users"></i> Manajemen User</a>
                        <!-- Manajemen Penerima removed from sidebar here; manage via Manajemen User -->
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
                <!-- Left side - Brand + sidebar toggle -->
                <div class="navbar-brand" style="display:flex;align-items:center;gap:8px;">
                    <span id="brandToggle" style="cursor:pointer"><i class="fas fa-bars me-2"></i></span>
                    <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">SIAKRA</a>
                </div>
                
                <!-- Center - Navigation Menu: show only Edit Agenda on this page -->
                <div id="centerNav" class="d-flex align-items-center gap-2" style="display:none !important;">
                    <a class="nav-link active" style="pointer-events: none; cursor: default;">
                        <i class="fas fa-edit me-1"></i>
                        Edit Agenda
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
        <div class="form-container">
            <h1 class="form-title">Ubah Agenda</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $event->title) }}" 
                           required>
                </div>

                <div class="form-group">
                    <label for="asal_surat" class="form-label">Dari</label>
                    <input type="text" 
                           class="form-control" 
                           id="asal_surat" 
                           name="asal_surat" 
                           placeholder="Contoh: Sekretariat Daerah, Dinas Pendidikan, dll"
                           value="{{ old('asal_surat', $event->asal_surat) }}">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              rows="2">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="startDate" class="form-label">Tanggal Mulai</label>
                            <div class="calendar-menu-wrapper">
                                <input type="date" 
                                       class="form-control date-input-enhanced" 
                                       id="startDate" 
                                       name="startDate" 
                                       value="{{ old('startDate', $event->startDate->format('Y-m-d')) }}" 
                                       required>
                                <div class="calendar-widget" id="startDate-calendar">
                                    <div class="calendar-header">
                                        <button type="button" class="calendar-nav-btn" data-calendar-id="startDate" data-direction="-1">‹</button>
                                        <div class="calendar-month-year" id="startDate-month-year"></div>
                                        <button type="button" class="calendar-nav-btn" data-calendar-id="startDate" data-direction="1">›</button>
                                    </div>
                                    <div class="calendar-grid">
                                        <div class="calendar-day-header">M </div>
                                        <div class="calendar-day-header">S</div>
                                        <div class="calendar-day-header">S</div>
                                        <div class="calendar-day-header">R</div>
                                        <div class="calendar-day-header">K</div>
                                        <div class="calendar-day-header">J</div>
                                        <div class="calendar-day-header">S</div>
                                        <div id="startDate-days"></div>
                                    </div>
                                    <div class="calendar-footer">
                                        <button type="button" class="calendar-btn clear" data-calendar-id="startDate" data-action="clear">Bersihkan</button>
                                        <button type="button" class="calendar-btn today" data-calendar-id="startDate" data-action="today">Hari Ini</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="startTime" class="form-label">Waktu Mulai</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="startTime" 
                                   name="startTime" 
                                   value="{{ old('startTime', $event->startTime ? substr($event->startTime, 0, 5) : '') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="endDate" class="form-label">Tanggal Selesai</label>
                            <div class="calendar-menu-wrapper">
                                <input type="date" 
                                       class="form-control date-input-enhanced" 
                                       id="endDate" 
                                       name="endDate" 
                                       value="{{ old('endDate', $event->endDate ? $event->endDate->format('Y-m-d') : '') }}">
                                <div class="calendar-widget" id="endDate-calendar">
                                    <div class="calendar-header">
                                        <button type="button" class="calendar-nav-btn" data-calendar-id="endDate" data-direction="-1">‹</button>
                                        <div class="calendar-month-year" id="endDate-month-year"></div>
                                        <button type="button" class="calendar-nav-btn" data-calendar-id="endDate" data-direction="1">›</button>
                                    </div>
                                    <div class="calendar-grid">
                                        <div class="calendar-day-header">Su</div>
                                        <div class="calendar-day-header">Mo</div>
                                        <div class="calendar-day-header">Tu</div>
                                        <div class="calendar-day-header">We</div>
                                        <div class="calendar-day-header">Th</div>
                                        <div class="calendar-day-header">Fr</div>
                                        <div class="calendar-day-header">Sa</div>
                                        <div id="endDate-days"></div>
                                    </div>
                                    <div class="calendar-footer">
                                        <button type="button" class="calendar-btn clear" data-calendar-id="endDate" data-action="clear">Bersihkan</button>
                                        <button type="button" class="calendar-btn today" data-calendar-id="endDate" data-action="today">Hari Ini</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="endTime" class="form-label">Waktu Selesai</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="endTime" 
                                   name="endTime" 
                                   value="{{ old('endTime', $event->endTime ? substr($event->endTime, 0, 5) : '') }}">
                            <!-- Checkbox for ongoing/no end date -->
                            <input type="hidden" name="no_end_date" value="0">
                            <label class="form-check-label" style="display: flex; align-items: center; gap: 8px; margin-top: 8px; cursor: pointer; font-size: 13px; font-weight: 500;">
                                <input type="checkbox" 
                                       id="noEndDate" 
                                       name="no_end_date"
                                       value="1"
                                       {{ old('no_end_date', $event->no_end_date ?? 0) ? 'checked' : '' }}
                                       onchange="toggleEndDateFields()">
                                <span>S/D Selesai</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" 
                           class="form-control" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $event->location) }}">
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" 
                              id="keterangan" 
                              name="keterangan" 
                              rows="2" 
                              placeholder="Catatan tambahan atau informasi khusus tentang Agenda">{{ old('keterangan', $event->keterangan) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="document" class="form-label">Dokumen (Opsional)</label>
                    <div class="file-upload-container">
                        <input type="file" 
                               class="form-control file-input" 
                               id="document" 
                               name="document" 
                               accept=".pdf,.docx"
                               onchange="handleFileSelect(event)">
                        <div class="file-upload-info">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="file-text">Pilih file PDF atau DOCX (maksimal 10MB)</span>
                        </div>
                        @php
                            // Show preview if there is a document_path set on the event.
                            // Don't strictly require the physical file to exist — show the stored name so users know a file is attached.
                            $hasDocument = !empty($event->document_path);
                            $basename = $hasDocument ? basename($event->document_path) : '';
                            $ext = $hasDocument ? strtolower(pathinfo($event->document_path, PATHINFO_EXTENSION)) : '';
                            // Compute formatted size only if the physical file exists on disk
                            $formattedSize = '';
                            if ($hasDocument && file_exists(storage_path('app/public/' . $event->document_path))) {
                                $fileSize = filesize(storage_path('app/public/' . $event->document_path));
                                $units = ['B','KB','MB','GB'];
                                $bytes = max($fileSize, 0);
                                $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
                                $pow = min($pow, count($units) - 1);
                                $bytes = $bytes / pow(1024, $pow);
                                $formattedSize = round($bytes, 2) . ' ' . $units[$pow];
                            }
                        @endphp
                        <div class="file-preview" id="file-preview" style="display: {{ $hasDocument ? 'block' : 'none' }};">
                            <div class="file-preview-content">
                                <i class="fas fa-file-alt file-icon" style="color: {{ ($hasDocument && $ext === 'pdf') ? '#dc2626' : '#2563eb' }}"></i>
                                <div class="file-details">
                                    <span class="file-name" id="file-name">{{ $hasDocument ? $basename : '' }}</span>
                                    <span class="file-size" id="file-size">{{ $hasDocument ? ($formattedSize ?? '') : '' }}</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <!-- @if($ext === 'pdf')
                                        <a href="{{ route('events.preview-document', $event) }}" class="btn-view" target="_blank" style="background:none;border:1px solid #e5e7eb;padding:6px 8px;border-radius:6px;color:#374151;text-decoration:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;">
                                            <i class="fas fa-eye"></i>
                                            Pratinjau
                                        </a>
                                    @else
                                        <a href="{{ route('events.preview-document', $event) }}" class="btn-view" target="_blank" style="background:none;border:1px solid #e5e7eb;padding:6px 8px;border-radius:6px;color:#374151;text-decoration:none;font-size:13px;display:inline-flex;align-items:center;gap:6px;">
                                            <i class="fas fa-external-link-alt"></i>
                                            Buka File
                                        </a>
                                    @endif -->
                                    <button type="button" class="remove-file" onclick="removeFile()" style="background:#fee2e2;border:1px solid #fca5a5;padding:6px 8px;border-radius:6px;color:#dc2626;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="existing_document" id="existing_document" value="{{ $event->document_path ?? '' }}">
                        <input type="hidden" name="remove_existing_document" id="remove_existing_document" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient_type" class="form-label">Penerima</label>
                    <select class="form-select" id="recipient_type" name="recipient_type">
                        <option value="">-- Pilih --</option>
                        <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>Semua Staff ({{ $pegawaiList->count() }} orang)</option>
                        <option value="kepala_bidang" {{ old('recipient_type') == 'kepala_bidang' ? 'selected' : '' }}>Pilih Kepala Bidang</option>
                        <option value="bidang" {{ old('recipient_type') == 'bidang' ? 'selected' : '' }}>Pilih Bidang</option>
                        <option value="individual" {{ old('recipient_type') == 'individual' ? 'selected' : '' }}>Pilih Individual</option>
                    </select>
                </div>

                <!-- Bidang Selection -->
                <div id="bidang_selection" class="form-group" style="display: none;">
                    <label class="form-label">Pilih Bidang</label>
                    <div style="max-height: 150px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px; background: #f9fafb;">
                        @foreach($bidangOptions as $bidang)
                        <label class="form-check-label" style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; cursor: pointer;">
                            <input type="checkbox" 
                                   name="selected_bidangs[]" 
                                   value="{{ $bidang }}" 
                                   class="bidang-checkbox"
                                   {{ (old('selected_bidangs') && in_array($bidang, old('selected_bidangs'))) || in_array($bidang, $currentBidangs) ? 'checked' : '' }}>
                            <span style="font-size: 13px;">{{ $bidang }} ({{ $bidangCounts[$bidang] ?? 0 }} orang)</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Kepala Bidang Selection -->
                <div id="kepala_bidang_selection" class="form-group" style="display: none;">
                    <label class="form-label">Pilih Kepala Bidang</label>
                    <div style="max-height: 150px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px; background: #f9fafb;">
                        @foreach($bidangOptions as $bidang)
                        @if($bidang !== 'MAGANG' && $bidang !== 'SEKRETARIAT')
                        <label class="form-check-label" style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; cursor: pointer;">
                            <input type="checkbox" 
                                   name="selected_kepala_bidangs[]" 
                                   value="{{ $bidang }}" 
                                   onchange="updateSelectedCount()"
                                   {{ (old('selected_kepala_bidangs') && in_array($bidang, old('selected_kepala_bidangs'))) ? 'checked' : '' }}>
                            <span style="font-size: 13px;">{{ $bidang }} ({{ $kepalaBidangCounts[$bidang] ?? 0 }} kepala bidang)</span>
                        </label>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Individual Selection -->
                <div id="individual_selection" class="form-group" style="display: none;">
                    <label class="form-label">Pilih Individual</label>
                    
                    <!-- Search Input -->
                    <div style="margin-bottom: 8px;">
                        <input type="text" 
                               id="individual_search" 
                               class="form-control search-input" 
                               placeholder="Cari nama atau jabatan..." 
                               onkeyup="filterIndividuals()"
                               style="height: 28px; font-size: 12px;">
                    </div>
                    
                    <div id="individual_list" style="max-height: 200px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px; background: #f9fafb;">
               @foreach($pegawaiList as $pegawai)
               <label class="form-check-label individual-item" 
                   data-name="{{ strtolower($pegawai->name) }}" 
                   data-jabatan="{{ strtolower($pegawai->jabatan) }}"
                               style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; cursor: pointer;">
                            <input type="checkbox" 
                                   name="selected_individuals[]" 
                                   value="{{ $pegawai->id }}" 
                                   class="individual-checkbox"
                                   onchange="updateSelectedCount()"
                                   {{ (old('selected_individuals') && in_array($pegawai->id, old('selected_individuals'))) || in_array($pegawai->id, $currentRecipients) ? 'checked' : '' }}>
                            <span style="font-size: 13px;">{{ $pegawai->name }} — {{ $pegawai->jabatan }}</span>
                        </label>
                        @endforeach
                        
                        <!-- No results message -->
                        <div id="no_results" style="display: none; text-align: center; color: #6b7280; font-size: 12px; padding: 16px;">
                            Tidak ada hasil yang ditemukan
                        </div>
                    </div>
                </div>

                <!-- Preview Selected -->
                 <div id="preview_selected" class="form-group" style="display: none;">
                    <div style="margin-top: 8px;">
                        <label class="form-label">Pratinjau Penerima</label>
                        <div id="selected_preview" style="padding: 8px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; font-size: 13px; max-height: 100px; overflow-y: auto;">
                            <!-- Preview content will be populated by JavaScript -->
                        </div>
                        <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                            Dipilih: <strong><span id="selected_count">0</span> penerima</strong>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('events.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">Perbarui Agenda</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data from server
        window.pegawaiCount = {{ $pegawaiCount}};
        window.bidangCounts = @json($bidangCounts);
        window.pegawaiData = @json($pegawaiList->keyBy('id'));
        window.kepalaBidangCount = {{ $kepalaBidangCount }};
        window.kepalaBidangData = @json($kepalaBidangList->keyBy('id'));
        window.kepalaBidangCounts = @json($kepalaBidangCounts);

        // Use data from window object
        const pegawaiCount = window.pegawaiCount;
        const bidangCounts = window.bidangCounts;
        const pegawaiData = window.pegawaiData;
        const kepalaBidangCount = window.kepalaBidangCount;
        const kepalaBidangData = window.kepalaBidangData;
        const kepalaBidangCounts = window.kepalaBidangCounts;

        // Load events data for calendar
        let eventsData = {};
        
        // Function to load events from server
        async function loadEventsData() {
            try {
                const response = await fetch('/events-data');
                if (response.ok) {
                    const events = await response.json();
                    eventsData = {};
                    
                    events.forEach(event => {
                        const startDate = event.startDate.split(' ')[0]; // Get date part only
                        if (!eventsData[startDate]) {
                            eventsData[startDate] = [];
                        }
                        eventsData[startDate].push(event);
                        
                        // Also add to end date if different
                        if (event.endDate && event.endDate !== event.startDate) {
                            const endDate = event.endDate.split(' ')[0];
                            if (!eventsData[endDate]) {
                                eventsData[endDate] = [];
                            }
                            eventsData[endDate].push(event);
                        }
                    });
                } else {
                    console.warn('Could not load events data');
                }
            } catch (error) {
                console.warn('Error loading events data:', error);
            }
        }
        
        // Calendar Widget Functions
        const calendarStates = {
            startDate: { currentMonth: new Date(), selectedDate: null },
            endDate: { currentMonth: new Date(), selectedDate: null }
        };
        
        function toggleCalendarWidget(inputId) {
            event.preventDefault();
            event.stopPropagation();
            const widget = document.getElementById(inputId + '-calendar');
            const allWidgets = document.querySelectorAll('.calendar-widget');
            
            // Close all other widgets
            allWidgets.forEach(w => {
                if (w.id !== inputId + '-calendar') {
                    w.classList.remove('show');
                }
            });
            
            // Toggle current widget
            if (widget.classList.contains('show')) {
                widget.classList.remove('show');
            } else {
                // Initialize calendar if opening
                initializeCalendar(inputId);
                widget.classList.add('show');
            }
        }
        
        function initializeCalendar(inputId) {
            const input = document.getElementById(inputId);
            const state = calendarStates[inputId];
            
            // Set selected date from input value
            if (input.value) {
                state.selectedDate = new Date(input.value);
                state.currentMonth = new Date(state.selectedDate);
            } else {
                state.currentMonth = new Date();
                state.selectedDate = null;
            }
            
            renderCalendar(inputId);
        }
        
        function renderCalendar(inputId) {
            const state = calendarStates[inputId];
            const monthYearElement = document.getElementById(inputId + '-month-year');
            const daysContainer = document.getElementById(inputId + '-days');
            
            // Update month/year display
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            monthYearElement.textContent = `${monthNames[state.currentMonth.getMonth()]} ${state.currentMonth.getFullYear()}`;
            
            // Clear previous days
            daysContainer.innerHTML = '';
            
            // Get first day of month and number of days
            const firstDay = new Date(state.currentMonth.getFullYear(), state.currentMonth.getMonth(), 1);
            const lastDay = new Date(state.currentMonth.getFullYear(), state.currentMonth.getMonth() + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay()); // Start from Sunday
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // Generate 42 days (6 weeks)
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const dayElement = document.createElement('button');
                dayElement.type = 'button';
                dayElement.className = 'calendar-day';
                dayElement.textContent = date.getDate();
                
                // Add classes for styling
                if (date.getMonth() !== state.currentMonth.getMonth()) {
                    dayElement.classList.add('other-month');
                }
                
                if (date.getTime() === today.getTime()) {
                    dayElement.classList.add('today');
                }
                
                if (state.selectedDate && date.getTime() === state.selectedDate.getTime()) {
                    dayElement.classList.add('selected');
                }
                
                // Check if date has events
                const dateStr = date.toISOString().split('T')[0];
                const hasEvents = eventsData[dateStr] && eventsData[dateStr].length > 0;
                
                if (hasEvents) {
                    dayElement.classList.add('has-events');
                    dayElement.title = `${eventsData[dateStr].length} Agenda pada tanggal ini`;
                }
                
                // Add click handler
                dayElement.addEventListener('click', (clickEvent) => {
                    clickEvent.preventDefault();
                    clickEvent.stopPropagation();
                    
                    if (hasEvents) {
                        showEventPopup(inputId, date, eventsData[dateStr]);
                    } else {
                        selectDate(inputId, date);
                    }
                });
                
                daysContainer.appendChild(dayElement);
            }
        }
        
        function changeMonth(inputId, direction) {
            event.preventDefault();
            event.stopPropagation();
            const state = calendarStates[inputId];
            state.currentMonth.setMonth(state.currentMonth.getMonth() + direction);
            renderCalendar(inputId);
        }
        
        function selectDate(inputId, date) {
            const input = document.getElementById(inputId);
            const state = calendarStates[inputId];
            
            state.selectedDate = new Date(date);
            input.value = date.toISOString().split('T')[0];
            
            // Re-render to update selection
            renderCalendar(inputId);
            
            // Close calendar
            closeCalendarWidget(inputId);
            
            // Trigger change event for validation
            input.dispatchEvent(new Event('change'));
        }
        
        function setToday(inputId) {
            event.preventDefault();
            event.stopPropagation();
            const today = new Date();
            selectDate(inputId, today);
        }
        
        function clearDate(inputId) {
            event.preventDefault();
            event.stopPropagation();
            const input = document.getElementById(inputId);
            const state = calendarStates[inputId];
            
            input.value = '';
            state.selectedDate = null;
            renderCalendar(inputId);
            closeCalendarWidget(inputId);
            
            // Trigger change event
            input.dispatchEvent(new Event('change'));
        }
        
        function closeCalendarWidget(inputId) {
            const widget = document.getElementById(inputId + '-calendar');
            widget.classList.remove('show');
        }
        
        // Event popup functions
        function showEventPopup(inputId, date, events) {
            // Close any existing popup
            closeEventPopup();
            
            const calendarWidget = document.getElementById(inputId + '-calendar');
            const popup = document.createElement('div');
            popup.className = 'event-popup show';
            popup.id = 'event-popup';
            
            const dateStr = date.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            let popupContent = `
                <div class="event-popup-header">
                    Agenda pada ${dateStr}
                </div>
                <div class="event-popup-content">
            `;
            
            events.forEach(event => {
                const startTime = event.startTime ? event.startTime.substring(0, 5) : '';
                const endTime = event.endTime ? event.endTime.substring(0, 5) : '';
                const timeStr = startTime ? (endTime ? `${startTime} - ${endTime}` : startTime) : 'Sepanjang hari';
                
                popupContent += `
                    <div class="event-item" data-event-id="${event.id}">
                        <div class="event-title">${event.title}</div>
                        <div class="event-time">${timeStr}</div>
                    </div>
                `;
            });
            
            popupContent += `
                </div>
                <div class="event-actions">
                    <button class="event-action-btn select" data-input-id="${inputId}" data-date="${date.toISOString().split('T')[0]}">Pilih Tanggal</button>
                    <button class="event-action-btn close">Tutup</button>
                </div>
            `;
            
            popup.innerHTML = popupContent;
            calendarWidget.appendChild(popup);
            
            // Add event listeners to popup buttons
            popup.querySelectorAll('.event-item').forEach(item => {
                item.addEventListener('click', () => {
                    const eventId = item.getAttribute('data-event-id');
                    viewEventDetail(eventId);
                });
            });
            
            popup.querySelector('.event-action-btn.select').addEventListener('click', () => {
                const inputId = popup.querySelector('.event-action-btn.select').getAttribute('data-input-id');
                const dateStr = popup.querySelector('.event-action-btn.select').getAttribute('data-date');
                selectDateFromPopup(inputId, dateStr);
            });
            
            popup.querySelector('.event-action-btn.close').addEventListener('click', () => {
                closeEventPopup();
            });
        }
        
        function closeEventPopup() {
            const existingPopup = document.getElementById('event-popup');
            if (existingPopup) {
                existingPopup.remove();
            }
        }
        
        function selectDateFromPopup(inputId, dateStr) {
            const input = document.getElementById(inputId);
            const state = calendarStates[inputId];
            const date = new Date(dateStr);
            
            state.selectedDate = new Date(date);
            input.value = dateStr;
            
            // Re-render calendar and close popup
            renderCalendar(inputId);
            closeEventPopup();
            closeCalendarWidget(inputId);
            
            // Trigger change event
            input.dispatchEvent(new Event('change'));
        }
        
        function viewEventDetail(eventId) {
            // Open event detail in new tab or redirect
            window.open(`/events/${eventId}`, '_blank');
        }
        
        // Close calendar widgets and popups when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.calendar-menu-wrapper')) {
                document.querySelectorAll('.calendar-widget').forEach(widget => {
                    widget.classList.remove('show');
                });
                closeEventPopup();
            }
        });
        
        // Date validation
        function validateDates() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
                return false;
            }
            return true;
        }
        
        // Add event listeners for date validation
        document.getElementById('startDate').addEventListener('change', validateDates);
        document.getElementById('endDate').addEventListener('change', validateDates);
        
        // Original recipient functions
        function toggleRecipientOptions() {
            const recipientType = document.getElementById('recipient_type').value;
            const bidangSelection = document.getElementById('bidang_selection');
            const kepalaBidangSelection = document.getElementById('kepala_bidang_selection');
            const individualSelection = document.getElementById('individual_selection');
            const previewSelected = document.getElementById('preview_selected');
            
            // Hide all selections first
            bidangSelection.style.display = 'none';
            kepalaBidangSelection.style.display = 'none';
            individualSelection.style.display = 'none';
            previewSelected.style.display = 'none';
            
            // Clear all selections
            clearAllSelections();
            
            // Show appropriate selection
            switch(recipientType) {
                case 'all':
                    previewSelected.style.display = 'block';
                    updatePreviewForAll();
                    break;
                case 'kepala_bidang':
                    kepalaBidangSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
                case 'bidang':
                    bidangSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
                case 'individual':
                    individualSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
            }
            
            updateSelectedCount();
        }
        
        function clearAllSelections() {
            // Clear bidang checkboxes
            const bidangCheckboxes = document.querySelectorAll('input[name="selected_bidangs[]"]');
            bidangCheckboxes.forEach(checkbox => checkbox.checked = false);
            
            // Clear kepala bidang checkboxes
            const kepalaBidangCheckboxes = document.querySelectorAll('input[name="selected_kepala_bidangs[]"]');
            kepalaBidangCheckboxes.forEach(checkbox => checkbox.checked = false);
            
            // Clear individual checkboxes
            const individualCheckboxes = document.querySelectorAll('input[name="selected_individuals[]"]');
            individualCheckboxes.forEach(checkbox => checkbox.checked = false);

            // Clear search input
            const searchInput = document.getElementById('individual_search');
            if (searchInput) {
                searchInput.value = '';
                filterIndividuals(); // Reset filter
            }

            updateSelectedCount();
        }
        
        // Filter individuals based on search input
        function filterIndividuals() {
            const searchTerm = document.getElementById('individual_search').value.toLowerCase();
            const individualItems = document.querySelectorAll('.individual-item');
            const noResults = document.getElementById('no_results');
            let visibleCount = 0;
            
            individualItems.forEach(item => {
                const name = item.dataset.name;
                const jabatan = item.dataset.jabatan;
                
                if (name.includes(searchTerm) || jabatan.includes(searchTerm)) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
        
        function updateSelectedCount() {
            const recipientType = document.getElementById('recipient_type').value;
            const selectedPreview = document.getElementById('selected_preview');
            const selectedCountSpan = document.getElementById('selected_count');
            
            let count = 0;
            let previewHtml = '';
            
            if (recipientType === 'all') {
                count = pegawaiCount;
                previewHtml = 'Semua staff akan menerima notifikasi event ini.';
            } else if (recipientType === 'kepala_bidang') {
                const checkedKepalaBidangs = document.querySelectorAll('input[name="selected_kepala_bidangs[]"]:checked');
                const selectedNames = [];
                count = 0;
                checkedKepalaBidangs.forEach(cb => {
                    const bidangName = cb.value;
                    const bidangCount = kepalaBidangCounts[bidangName] || 0;
                    count += bidangCount;
                    
                    // Find kepala bidang from the selected bidang
                    const kepalaBidangInBidang = Object.values(kepalaBidangData).filter(kb => 
                        kb.bidang === bidangName && 
                        (kb.jabatan.includes('KEPALA BIDANG') || kb.jabatan.includes('KABID') || 
                        (kb.jabatan.includes('SEKRETARIS') && bidangName === 'PIMPINAN'))
                    );
                    
                    kepalaBidangInBidang.forEach(kb => {
                        selectedNames.push(`${kb.name} - ${kb.jabatan}`);
                    });
                });
                
                if (selectedNames.length > 0) {
                    if (selectedNames.length <= 3) {
                        previewHtml = `Kepala Bidang terpilih: ${selectedNames.join(', ')}`;
                    } else {
                        previewHtml = `Kepala Bidang terpilih: ${selectedNames.slice(0, 3).join(', ')} dan ${selectedNames.length - 3} orang lainnya`;
                    }
                } else {
                    previewHtml = 'Belum ada kepala bidang yang dipilih.';
                }
            } else if (recipientType === 'bidang') {
                const checkedBidangs = document.querySelectorAll('input[name="selected_bidangs[]"]:checked');
                const selectedBidangs = [];
                count = 0;
                checkedBidangs.forEach(cb => {
                    const bidangCount = bidangCounts[cb.value] || 0;
                    count += bidangCount;
                    selectedBidangs.push(`${cb.value} (${bidangCount} orang)`);
                });
                previewHtml = selectedBidangs.length > 0 
                    ? `Bidang terpilih: ${selectedBidangs.join(', ')}`
                    : 'Belum ada bidang yang dipilih.';
            } else if (recipientType === 'individual') {
                const checkedIndividuals = document.querySelectorAll('input[name="selected_individuals[]"]:checked');
                count = checkedIndividuals.length;
                const selectedNames = [];
                checkedIndividuals.forEach(cb => {
                    const pegawai = pegawaiData[cb.value];
                    if (pegawai) {
                        selectedNames.push(pegawai.name);
                    }
                });
                if (selectedNames.length > 0) {
                    if (selectedNames.length <= 5) {
                        previewHtml = `Staff terpilih: ${selectedNames.join(', ')}`;
                    } else {
                        previewHtml = `Staff terpilih: ${selectedNames.slice(0, 5).join(', ')} dan ${selectedNames.length - 5} orang lainnya`;
                    }
                } else {
                    previewHtml = 'Belum ada staff yang dipilih.';
                }
            }
            
            if (selectedCountSpan) selectedCountSpan.textContent = count;
            if (selectedPreview) selectedPreview.innerHTML = previewHtml;
        }
        
        function updatePreviewForAll() {
            const selectedPreview = document.getElementById('selected_preview');
            const selectedCountSpan = document.getElementById('selected_count');
            const totalCount = Object.keys(pegawaiData).length;
            
            if (selectedPreview) selectedPreview.innerHTML = `Semua anggota staff (${totalCount} orang)`;
            if (selectedCountSpan) selectedCountSpan.textContent = totalCount;
        }
        
        // Toggle end date fields based on "S/D Selesai" checkbox
        function toggleEndDateFields() {
            const noEndDateCheckbox = document.getElementById('noEndDate');
            const endDateInput = document.getElementById('endDate');
            const endTimeInput = document.getElementById('endTime');
            const eventTimeDisplay = document.querySelector('.event-time');
            
            if (noEndDateCheckbox && noEndDateCheckbox.checked) {
                // Keep endDate enabled, but disable endTime when "S/D Selesai" is checked
                endDateInput.disabled = false;
                endDateInput.style.opacity = '1';
                endTimeInput.disabled = true;
                endTimeInput.value = '';
                endTimeInput.style.opacity = '0.5';
                
                // Update preview to show "selesai" format
                updateEventPreview();
            } else {
                // Enable both fields when checkbox is unchecked
                endDateInput.disabled = false;
                endTimeInput.disabled = false;
                endDateInput.style.opacity = '1';
                endTimeInput.style.opacity = '1';
                
                // Update preview
                updateEventPreview();
            }
        }
        
        // Update event preview based on current form values
        function updateEventPreview() {
            const startTimeInput = document.getElementById('startTime');
            const endTimeInput = document.getElementById('endTime');
            const noEndDateCheckbox = document.getElementById('noEndDate');
            const eventTimeDisplay = document.querySelector('.event-time');
            
            if (eventTimeDisplay) {
                const startTime = startTimeInput.value ? startTimeInput.value.substring(0, 5) : '';
                const endTime = endTimeInput.value ? endTimeInput.value.substring(0, 5) : '';
                
                let timeStr = '';
                if (noEndDateCheckbox.checked) {
                    // S/D Selesai format
                    timeStr = startTime ? `${startTime} - Selesai` : 'Sepanjang hari';
                } else {
                    // Normal format
                    timeStr = startTime ? (endTime ? `${startTime} - ${endTime}` : startTime) : 'Sepanjang hari';
                }
                
                eventTimeDisplay.textContent = timeStr;
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if no_end_date checkbox should be initialized
            const noEndDateCheckbox = document.getElementById('noEndDate');
            if (noEndDateCheckbox && noEndDateCheckbox.checked) {
                toggleEndDateFields();
            }
            
            // Add event listeners to update preview when time inputs change
            const startTimeInput = document.getElementById('startTime');
            const endTimeInput = document.getElementById('endTime');
            
            if (startTimeInput) {
                startTimeInput.addEventListener('change', updateEventPreview);
                startTimeInput.addEventListener('input', updateEventPreview);
            }
            
            if (endTimeInput) {
                endTimeInput.addEventListener('change', updateEventPreview);
                endTimeInput.addEventListener('input', updateEventPreview);
            }
            
            // Load events data for calendar
            loadEventsData();
            
            // Set up event listeners for calendar toggles
            document.querySelectorAll('.calendar-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const calendarId = this.getAttribute('data-calendar-id');
                    toggleCalendarWidget(calendarId);
                });
            });
            
            // Set up event listeners for calendar navigation buttons
            document.querySelectorAll('.calendar-nav-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const calendarId = this.getAttribute('data-calendar-id');
                    const direction = parseInt(this.getAttribute('data-direction'));
                    if (direction) {
                        changeMonth(calendarId, direction);
                    }
                });
            });
            
            // Set up event listeners for calendar action buttons
            document.querySelectorAll('.calendar-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const calendarId = this.getAttribute('data-calendar-id');
                    const action = this.getAttribute('data-action');
                    
                    if (action === 'clear') {
                        clearDate(calendarId);
                    } else if (action === 'today') {
                        setToday(calendarId);
                    }
                });
            });
            
            // Set up event listener for recipient type select
            document.getElementById('recipient_type').addEventListener('change', function() {
                toggleRecipientOptions();
            });
            
            // Set up event listeners for checkboxes
            document.querySelectorAll('.bidang-checkbox, .individual-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                });
            });
            
            // Set initial state based on current recipients
            const currentRecipientCount = {{ count($currentRecipients) }};
            const currentBidangs = @json($currentBidangs);
            const totalStaff = Object.keys(pegawaiData).length;
            
            // Try to determine the current recipient type
            if (currentRecipientCount === totalStaff) {
                document.getElementById('recipient_type').value = 'all';
            } else if (currentBidangs.length > 0 && currentRecipientCount > 0) {
                // Check if all recipients match the selected bidangs
                const bidangStaffCount = currentBidangs.reduce((total, bidang) => total + (bidangCounts[bidang] || 0), 0);
                if (bidangStaffCount === currentRecipientCount) {
                    document.getElementById('recipient_type').value = 'bidang';
                } else {
                    document.getElementById('recipient_type').value = 'individual';
                }
            } else if (currentRecipientCount > 0) {
                document.getElementById('recipient_type').value = 'individual';
            }
            
            // Toggle to show/hide appropriate options but without clearing selections
            // We need a special version of toggle that preserves existing checkboxes
            const recipientType = document.getElementById('recipient_type').value;
            const bidangSelection = document.getElementById('bidang_selection');
            const kepalaBidangSelection = document.getElementById('kepala_bidang_selection');
            const individualSelection = document.getElementById('individual_selection');
            const previewSelected = document.getElementById('preview_selected');
            
            // Hide all selections first
            bidangSelection.style.display = 'none';
            kepalaBidangSelection.style.display = 'none';
            individualSelection.style.display = 'none';
            previewSelected.style.display = 'none';
            
            // Show appropriate selection
            switch(recipientType) {
                case 'all':
                    previewSelected.style.display = 'block';
                    updatePreviewForAll();
                    break;
                case 'kepala_bidang':
                    kepalaBidangSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
                case 'bidang':
                    bidangSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
                case 'individual':
                    individualSelection.style.display = 'block';
                    previewSelected.style.display = 'block';
                    break;
            }
            
            // Now that visibility is set, trigger update to show correct preview
            updateSelectedCount();
        });
    </script>
    <script>
        // File upload helper functions (copied from create page)
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const uploadContainer = document.querySelector('.file-upload-container');
            const removeFlag = document.getElementById('remove_existing_document');

            if (file) {
                // Validate file type
                const allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file PDF atau DOCX yang diperbolehkan!');
                    event.target.value = '';
                    return;
                }

                // Validate file size (10MB)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file tidak boleh lebih dari 10MB!');
                    event.target.value = '';
                    return;
                }

                // Show preview
                if (fileName) fileName.textContent = file.name;
                if (fileSize) fileSize.textContent = formatFileSize(file.size);
                if (filePreview) filePreview.style.display = 'block';
                if (uploadContainer) uploadContainer.classList.add('has-file');

                // Update icon based on file type
                const fileIcon = document.querySelector('.file-icon');
                if (fileIcon) {
                    if (file.type === 'application/pdf') {
                        fileIcon.className = 'fas fa-file-pdf file-icon';
                        fileIcon.style.color = '#dc2626';
                    } else {
                        fileIcon.className = 'fas fa-file-word file-icon';
                        fileIcon.style.color = '#2563eb';
                    }
                }

                // If selecting a new file, ensure existing-document-remove flag is reset
                if (removeFlag) removeFlag.value = '0';
            }
        }

        function removeFile() {
            const fileInput = document.getElementById('document');
            const filePreview = document.getElementById('file-preview');
            const uploadContainer = document.querySelector('.file-upload-container');
            const existingDoc = document.getElementById('existing_document');
            const removeFlag = document.getElementById('remove_existing_document');

            if (fileInput) fileInput.value = '';
            if (filePreview) filePreview.style.display = 'none';
            if (uploadContainer) uploadContainer.classList.remove('has-file');

            // If there was an existing document, mark it for removal on submit
            if (existingDoc && existingDoc.value) {
                if (removeFlag) removeFlag.value = '1';
            }
        }

        // On DOM ready, if there's an existing document, ensure the upload container shows has-file
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const existingDoc = document.getElementById('existing_document');
                const uploadContainer = document.querySelector('.file-upload-container');
                if (existingDoc && existingDoc.value && uploadContainer) {
                    uploadContainer.classList.add('has-file');
                }
            } catch (e) { console.warn(e); }
        });
    </script>
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

            // Close sidebar when clicking outside
            document.addEventListener('click', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){ }
            }, true);

            // Also listen for pointerdown to catch touch events
            document.addEventListener('pointerdown', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){}
            }, true);

            // Restore persisted selection on page load (safe URL check)
            document.addEventListener('DOMContentLoaded', function(){
                try {
                    const stored = localStorage.getItem(NAV_KEY);
                    const center = document.getElementById('centerNav');
                    if (stored && center) {
                        const data = JSON.parse(stored);
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
                            console.warn('stored nav href parse failed, skipping restore', e);
                        }
                    }
                } catch(err){ console.error('restore selected nav failed', err); }
            });

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        try{ e.preventDefault(); }catch(err){}

                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';

                        try{ localStorage.setItem(NAV_KEY, JSON.stringify({ title: t, href: href, html: a.innerHTML })); }catch(e){}
                        const center = document.getElementById('centerNav');
                        if(center){ center.innerHTML = ''; const single = document.createElement('a'); single.className = 'nav-link active'; single.href = href; single.innerHTML = a.innerHTML; center.appendChild(single); }

                        close();
                        setTimeout(function(){ try{ if(href && href !== '#') window.location.href = href; }catch(err){} }, 180);
                    });
                });
            }
        })();
    </script>
</body>
</html>