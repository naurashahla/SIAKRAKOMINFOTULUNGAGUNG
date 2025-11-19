<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $event->title }} - SIAKRA</title>
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
            /* allow natural scrolling for long event pages */
            overflow-y: auto;
        }

        /* Header Navigation */
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            position: relative;
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

        /* Muted/disabled appearance for create button */
        .btn-create.disabled,
        .btn-action.btn-create[disabled] {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
            filter: grayscale(8%);
            box-shadow: none;
        }



        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .back-link:hover {
            color: #3b82f6;
            text-decoration: none;
        }

        .event-detail-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .event-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            padding: 20px 24px;
            color: white;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .event-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .event-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
            /* reserve space so any top-right badge won't overlap the title */
            padding-right: 90px;
            line-height: 1.05;
            letter-spacing: -0.01em;
        }

        .event-subtitle {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .event-content {
            padding: 20px 24px;
        }

        .event-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .meta-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 14px;
            flex-shrink: 0;
        }

        .meta-content h4 {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .meta-content p {
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            margin: 0;
            line-height: 1.4;
        }

        .description-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #3b82f6;
        }

        .description-content {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px 16px;
            border-left: 3px solid #3b82f6;
            font-size: 14px;
            line-height: 1.5;
            color: #475569;
        }

        /* Document Section */
        .document-section {
            margin-bottom: 20px;
        }

        .document-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .document-preview {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .document-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 18px;
        }

        .document-icon .fa-file-pdf {
            color: #dc2626;
            background: #fee2e2;
            padding: 8px;
            border-radius: 8px;
        }

        .document-icon .fa-file-word {
            color: #2563eb;
            background: #dbeafe;
            padding: 8px;
            border-radius: 8px;
        }

        .document-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .document-type {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .document-actions {
            display: flex;
            gap: 12px;
        }

        .btn-download, .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            border: 1px solid;
        }

        .btn-download {
            color: #059669;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-color: #a7f3d0;
        }

        .btn-download:hover {
            color: #047857;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #6ee7b7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
            text-decoration: none;
        }

        .btn-view {
            color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-color: #93c5fd;
        }

        .btn-view:hover {
            color: #2563eb;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #60a5fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
            text-decoration: none;
        }

        .recipients-section {
            margin-bottom: 20px;
        }

        .recipients-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
        }

        .recipient-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            position: relative;
        }

        .recipient-card:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(16, 24, 40, 0.06);
        }

        .recipient-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
            font-size: 14px;
            /* allow long names to wrap to next line instead of being overlapped */
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        /* Header inside recipient card to align name and badge */
        .recipient-header {
            display: flex;
            gap: 8px;
            align-items: flex-start;
            justify-content: space-between;
        }

        .name-block {
            flex: 1 1 auto;
            min-width: 0; /* allow children to truncate/wrap properly */
        }

        .badge-container {
            flex: 0 0 auto;
            display: flex;
            align-items: flex-start;
            margin-left: 12px;
        }

        .recipient-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #60a5fa 0%, #1e3a8a 100%);
            flex: 0 0 auto;
            margin-right: 10px;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(2,6,23,0.12);
        }

        .recipient-email {
            color: #64748b;
            font-size: 12px;
        }

        /* Original notification-status (used for event notification meta) */
        .notification-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-sent {
            background: #ecfdf5;
            color: #047857;
        }

        .notification-pending {
            background: #fef3c7;
            color: #b45309;
        }

        .notification-failed {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Attendance-specific badge styling (kehadiran) */
        .attendance-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: none;
            letter-spacing: 0.01em;
            position: static;
            align-self: flex-start; /* align to top of the card */
            box-shadow: 0 6px 18px rgba(2,6,23,0.06);
            line-height: 1;
            white-space: nowrap;
        }

        .attendance-badge.notification-sent {
            background: #e6f0ff; /* very light blue */
            color: #1e40af; /* blue text */
        }

        .attendance-badge.notification-pending {
            background: #feecec; /* very light red */
            color: #b91c1c; /* red text */
        }
        
        /* Completed (Selesai) -> green */
        .attendance-badge.notification-completed {
            background: #ecfdf5; /* very light green */
            color: #047857; /* green text */
        }
        
        /* Transferred (Dialihkan) -> yellow */
        .attendance-badge.notification-transferred {
            background: #fef3c7; /* very light yellow */
            color: #b45309; /* amber/dark yellow text */
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            border: 1px solid;
        }

        .btn-edit {
            color: #1e40af;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-color: #93c5fd;
        }

        .btn-edit:hover {
            color: #1e3a8a;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #60a5fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
            text-decoration: none;
        }

        .btn-delete {
            color: #dc2626;
            background: #fef2f2;
            border-color: #fecaca;
        }

        /* Icon-only variant for compact header actions */
        .btn-action.icon-only {
            padding: 8px;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn-action.icon-only i {
            margin: 0;
        }

        .btn-delete:hover {
            color: #b91c1c;
            background: #fee2e2;
            border-color: #fca5a5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
            text-decoration: none;
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

        /* Document Preview Modal */
        .modal-xl {
            max-width: 90%;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 20px 24px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 18px;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            opacity: 1;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
        }

        /* Completions (Notulen) styling */
        .completion-section {
            margin-top: 18px;
        }

        .completion-card {
            background: #ffffff;
            border: 1px solid #e6eef6;
            border-radius: 10px;
            padding: 18px;
            color: #0f172a;
        }

        .completion-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:8px;
        }

        .completion-author {
            font-weight:800;
            letter-spacing:0.02em;
            color:#0f172a;
            text-transform:uppercase;
            font-size:15px;
        }

        .completion-time {
            font-size:13px;
            color:#6b7280;
        }

        .completion-text {
            color:#475569;
            margin-bottom:12px;
            line-height:1.6;
        }

        .attached-label {
            font-size:13px;
            color:#374151;
            margin-bottom:8px;
            font-weight:700;
        }

        .file-row {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:12px 0;
            border-top:1px dashed #eef2f7;
        }

        .file-meta {
            display:flex;
            flex-direction:column;
            gap:4px;
        }

        .file-name {
            font-weight:700;
            color:#0f172a;
        }

        .file-sub {
            font-size:12px;
            color:#6b7280;
        }

        .file-actions { display:flex; gap:8px; }


        #documentPreviewContainer {
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        /* responsive image/pdf preview inside modal */
        #documentPreviewContainer img {
            max-width: 100%;
            max-height: calc(100vh - 220px);
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        #documentPreviewContainer iframe.preview-iframe {
            width: 100%;
            height: calc(100vh - 220px);
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }

            .event-header {
                padding: 24px 20px;
            }

            .event-title {
                font-size: 20px;
                padding-right: 48px; /* reduce reserved space on small screens */
            }

            .event-content {
                padding: 24px 20px;
            }

            .event-meta-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .recipients-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .document-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .document-actions {
                width: 100%;
                justify-content: center;
            }
        }


    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <!-- Left side - Brand -->
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <i class="fas fa-calendar-alt me-2"></i>
                    SIAKRA
                </a>
                
                <!-- Center - Navigation Menu (removed per request) -->

                <!-- Right side -->
                <div class="dropdown">
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
        </div>
    </nav>



    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        <a href="{{ route('events.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Semua Agenda
        </a>

        <div class="event-detail-card">
            <!-- Event Header -->
            <div class="event-header">
                <div class="header-left" style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                    <div class="header-text">
                        <h1 class="event-title">{{ $event->title }}</h1>
                        <p class="event-subtitle">
                            @if($event->startDate->isToday())
                                Agenda Hari Ini
                            @elseif($event->startDate->isTomorrow())
                                Agenda Besok
                            @elseif($event->startDate->isPast())
                                Agenda Telah Berlalu
                            @else
                                Agenda Mendatang
                            @endif
                            • {{ $event->startDate->format('d F Y') }}
                        </p>
                    </div>
                </div>

                @if(in_array(auth()->user()->role ?? '', ['admin','super_admin']))
                    <div class="header-actions" style="display:flex;gap:8px;align-items:center;z-index:2;">
                        <a href="{{ route('events.edit', $event) }}" class="btn-action btn-edit icon-only" onclick="event.stopPropagation();" title="Ubah" aria-label="Ubah">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete icon-only" onclick="event.stopPropagation();" title="Hapus" aria-label="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Event Content -->
            <div class="event-content">
                <!-- Event Meta Information -->
                <div class="event-meta-grid">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="meta-content">
                            <h4>Tanggal</h4>
                            <p>
                                {{ $event->startDate->format('d F Y') }}
                                @if($event->endDate && $event->endDate != $event->startDate)
                                    - {{ \Carbon\Carbon::parse($event->endDate)->format('d F Y') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($event->startTime || $event->endTime)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="meta-content">
                            <h4>Waktu</h4>
                            <p>
                                @if($event->startTime)
                                    {{ $event->startTime }} WIB
                                @else
                                    Sepanjang Hari
                                @endif
                                -
                                @if($event->no_end_date)
                                    Selesai
                                @elseif($event->endTime)
                                    {{ $event->endTime }} WIB
                                @else
                                    Sepanjang Hari
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($event->location)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="meta-content">
                            <h4>Lokasi</h4>
                            <p>{{ $event->location }}</p>
                        </div>
                    </div>
                    @endif

                    @if($event->asal_surat)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="meta-content">
                            <h4>Asal Surat</h4>
                            <p>{{ $event->asal_surat }}</p>
                        </div>
                    </div>
                    @endif

                    @if(in_array(auth()->user()->role ?? '', ['admin','super_admin']))
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="meta-content">
                            <h4>Status Notifikasi</h4>
                            <p>
                                <span class="notification-status notification-{{ $event->notification_status }}">
                                    @if($event->notification_status == 'sent')
                                        <i class="fas fa-check"></i> Terkirim
                                    @elseif($event->notification_status == 'failed')
                                        <i class="fas fa-times"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Menunggu
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                @if($event->description)
                <div class="description-section">
                    <h2 class="section-title">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </h2>
                    <div class="description-content">
                        {{ $event->description }}
                    </div>
                </div>
                @endif

                <!-- Keterangan -->
                @if($event->keterangan)
                <div class="description-section">
                    <h2 class="section-title">
                        <i class="fas fa-sticky-note"></i>
                        Keterangan
                    </h2>
                    <div class="description-content">
                        {{ $event->keterangan }}
                    </div>
                </div>
                @endif

                <!-- Document Section -->
                @if($event->document_path)
                <div class="document-section">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Dokumen Terlampir
                    </h2>
                    <div class="document-card">
                        <div class="document-preview">
                            <div class="document-icon">
                                @if(pathinfo($event->document_path, PATHINFO_EXTENSION) === 'pdf')
                                    <i class="fas fa-file-pdf"></i>
                                @else
                                    <i class="fas fa-file-word"></i>
                                @endif
                            </div>
                            <div class="document-info">
                                <h4 class="document-name">{{ basename($event->document_path) }}</h4>
                                <p class="document-type">
                                    {{ strtoupper(pathinfo($event->document_path, PATHINFO_EXTENSION)) }} Document
                                    @if(file_exists(storage_path('app/public/' . $event->document_path)))
                                        @php
                                            $fileSize = filesize(storage_path('app/public/' . $event->document_path));
                                            $units = ['B', 'KB', 'MB', 'GB'];
                                            $bytes = max($fileSize, 0);
                                            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                                            $pow = min($pow, count($units) - 1);
                                            $bytes /= pow(1024, $pow);
                                            $formattedSize = round($bytes, 2) . ' ' . $units[$pow];
                                        @endphp
                                        • {{ $formattedSize }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="document-actions">
                            <a href="{{ route('events.download-document', $event) }}" class="btn-download">
                                <i class="fas fa-download"></i>
                                Download
                            </a>
                            @if(pathinfo($event->document_path, PATHINFO_EXTENSION) === 'pdf')
                                <a href="{{ route('events.preview-document', $event) }}" class="btn-view" target="_blank">
                                    <i class="fas fa-eye"></i>
                                    Pratinjau
                                </a>
                            @else
                                <a href="{{ route('events.preview-document', $event) }}" class="btn-view" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                    Buka File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recipients -->
                @if($event->recipients->count() > 0)
                <div class="recipients-section">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i>
                        Penerima Undangan ({{ $event->recipients->count() }} orang)
                    </h2>
                    <div class="recipients-grid">
                        @foreach($event->recipients as $recipient)
                        @php
                            $att = $attendances[$recipient->id] ?? null;
                            $status = $att->status ?? null;

                            // If there is a completion by this recipient, prefer that and mark as completed
                            $completionByUser = isset($completions) ? $completions->firstWhere('user_id', $recipient->id) : null;
                            if ($completionByUser) {
                                $status = 'completed';
                            }

                            // Map status to readable label
                            switch($status) {
                                case 'attended':
                                    $statusLabel = 'Hadir';
                                    $statusClass = 'notification-sent';
                                    break;
                                case 'completed':
                                    $statusLabel = 'Selesai';
                                    $statusClass = 'notification-completed';
                                    break;
                                case 'transferred':
                                    $statusLabel = 'Dialihkan';
                                    $statusClass = 'notification-transferred';
                                    break;
                                default:
                                    $statusLabel = 'Tidak Hadir';
                                    $statusClass = 'notification-pending';
                            }
                        @endphp
                        <div class="recipient-card">
                            <div class="recipient-header">
                                <div class="name-block" style="display:flex;align-items:flex-start;gap:8px;min-width:0;">
                                    <div class="recipient-avatar">{{ strtoupper(substr($recipient->name, 0, 1)) }}</div>
                                    <div style="min-width:0;">
                                        <div class="recipient-name">{{ $recipient->name }}</div>
                                        <div class="recipient-email">{{ $recipient->email ?? 'Email tidak tersedia' }}</div>
                                    </div>
                                </div>

                                <div class="badge-container">
                                    <span id="attendance-badge-{{ $recipient->id }}" data-user-id="{{ $recipient->id }}" class="attendance-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Completions (Notulen & Bukti Dukung) -->
                @php
                    $showCompletionsSection = (isset($completions) && $completions->count() > 0) || (auth()->check() && auth()->user()->role === 'super_admin');
                @endphp

                @if($showCompletionsSection)
                <div class="completion-section">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Keterangan & Dokumen Peserta
                    </h2>

                    @if(isset($completions) && $completions->count() > 0)
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            @foreach($completions as $completion)
                                <div class="completion-card">
                                    <div class="completion-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                        <div style="display:flex;flex-direction:column;">
                                            <div class="completion-author">{{ $completion->user->name ?? 'Pengguna' }}</div>
                                            <div class="completion-time">{{ $completion->created_at->format('d F Y H:i') }}</div>
                                        </div>
                                        <div style="display:flex;gap:8px;align-items:center;">
                                            @if(auth()->check() && (auth()->id() == $completion->user_id || in_array(auth()->user()->role ?? '', ['admin','super_admin'])))
                                                <a href="{{ url('/events/'.$event->id.'/completions/'.$completion->id.'/edit') }}" class="btn-action btn-edit" title="Edit notulen" style="padding:6px 10px;font-size:13px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button" data-completion-id="{{ $completion->id }}" class="btn-action btn-delete completion-delete-btn" title="Hapus notulen" style="padding:6px 10px;font-size:13px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="completion-text">{!! nl2br(e($completion->notulen)) !!}</div>

                                    @if(!empty($completion->files) && is_array($completion->files))
                                        <div style="margin-top:6px;">
                                            <div class="attached-label">Dokumen Terlampir</div>
                                            <div style="display:flex;flex-direction:column;gap:6px;">
                                                @foreach($completion->files as $f)
                                                    @php
                                                        $full = storage_path('app/public/' . $f);
                                                        $exists = file_exists($full);
                                                        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                                        $size = null;
                                                        if ($exists) {
                                                            $bytes = filesize($full);
                                                            $units = ['B','KB','MB','GB'];
                                                            $p = floor(($bytes ? log($bytes) : 0) / log(1024));
                                                            $p = min($p, count($units)-1);
                                                            $size = round($bytes / pow(1024, $p), 2) . ' ' . $units[$p];
                                                        }
                                                    @endphp
                                                    <div class="file-row">
                                                        <div class="file-meta">
                                                            <div class="file-name">{{ basename($f) }}</div>
                                                            <div class="file-sub">{{ strtoupper($ext) }} • {{ $size ?? '—' }}</div>
                                                        </div>
                                                        <div class="file-actions">
                                                            @if($exists)
                                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewDocument('{{ addslashes($f) }}', '{{ addslashes(basename($f)) }}', '{{ $completion->id }}')">Pratinjau</button>
                                                            @else
                                                                <span class="file-sub">File tidak ditemukan</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="completion-card">
                            <div style="font-weight:700;color:#0f172a;">Belum ada notulen atau bukti dukung</div>
                            @if(auth()->check() && auth()->user()->role === 'super_admin')
                                <div style="margin-top:8px;color:#6b7280;">Super admin dapat melihat notulen dan bukti dukung di sini saat ada yang mengunggahnya. Penerima undangan tetap satu-satunya yang dapat menyelesaikan agenda.</div>
                            @endif
                        </div>
                    @endif
                </div>
                @endif

                <!-- Action Buttons for assignment/transfer -->
                <div class="action-buttons">
                    @auth
                        @php
                            $currentUser = auth()->user();
                            $isRecipient = $event->recipients->contains('id', $currentUser->id);
                        @endphp

                        @if($isRecipient)
                            <!-- Mark attendance -->
                            <form id="attend-form" method="POST" action="{{ route('events.attend', $event) }}" data-user-id="{{ auth()->id() }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action btn-edit">
                                    <i class="fas fa-check-circle"></i>
                                    Saya Hadir
                                </button>
                            </form>

                            <!-- Transfer document modal trigger -->
                            <button type="button" class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#transferModal">
                                <i class="fas fa-share-square"></i>
                                Disposisi
                            </button>

                            @php
                                // check if current user has attended this event
                                $hasAttended = false;
                                try {
                                    if (auth()->check()) {
                                        $att = \App\Models\EventAttendance::where('event_id', $event->id)
                                            ->where('user_id', auth()->id())
                                            ->first();
                                        if ($att && $att->status === 'attended') {
                                            $hasAttended = true;
                                        }
                                    }
                                } catch (\Exception $e) {
                                    $hasAttended = false;
                                }
                            @endphp

                            @if($hasAttended)
                                <a href="{{ route('events.complete.form', $event) }}" class="btn-action btn-create" style="display:inline-flex; align-items:center;">
                                    <i class="fas fa-clipboard-check me-1"></i>
                                    Notulen & Bukti
                                </a>
                            @else
                                <button type="button" class="btn-action btn-create disabled" disabled title="Tandai 'Saya Hadir' terlebih dahulu untuk menyelesaikan agenda">
                                    <i class="fas fa-clipboard-check me-1"></i>
                                    Notulen & Bukti
                                </button>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Document Preview Modal -->
    <div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentPreviewModalLabel">
                        <i class="fas fa-file-alt me-2"></i>
                        Pratinjau Dokumen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="documentPreviewContainer">
                        <!-- preview element (img or iframe.preview-iframe) will be injected here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="downloadFromPreview" href="#" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer Document Modal -->
    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">
                        <i class="fas fa-share-square me-2"></i>
                        Disposisi ke Pegawai Lain
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('events.transfer', $event) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="to_user_id" class="form-label">Pilih pegawai penerima</label>
                            <select id="to_user_id" name="to_user_id" class="form-select" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawaiList as $p)
                                    @if(auth()->check() && auth()->user()->id == $p->id)
                                        @continue
                                    @endif
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Disposisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const baseUrl = '{{ url('/') }}';
        const eventIdForPreview = '{{ $event->id }}';
        function deleteEvent(id) {
            if (confirm('Apakah Anda yakin ingin menghapus Agenda ini?')) {
                const form = document.getElementById('delete-form');
                form.action = '/events/' + id;
                form.submit();
            }
        }

        function deleteCompletion(id) {
            if (confirm('Apakah Anda yakin ingin menghapus notulen ini?')) {
                const form = document.getElementById('delete-form');
                form.action = '/events/{{ $event->id }}/completions/' + id;
                form.submit();
            }
        }

        // Attach click handlers for completion delete buttons and attendance form (AJAX)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.completion-delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-completion-id');
                    if (id) deleteCompletion(id);
                });
            });

            // AJAX submit for global "Saya Hadir" — updates badge in-place
            const attendForm = document.getElementById('attend-form');
            if (attendForm) {
                attendForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const tokenInput = this.querySelector('input[name="_token"]');
                    const token = tokenInput ? tokenInput.value : '';
                    const userId = this.getAttribute('data-user-id');
                    const submitUrl = this.action;

                    fetch(submitUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams({ _token: token })
                    }).then(function(res) {
                        return res.json();
                    }).then(function(data) {
                        if (data && data.success) {
                            if (userId) {
                                const badge = document.getElementById('attendance-badge-' + userId);
                                if (badge) {
                                    badge.textContent = 'Hadir';
                                    badge.classList.remove('notification-pending');
                                    badge.classList.add('notification-sent');
                                }
                            }

                            // Replace disabled Notulen & Bukti button with active link (remove disabled class)
                            const createBtn = document.querySelector('.action-buttons .btn-action.btn-create');
                            if (createBtn && (createBtn.disabled || createBtn.classList.contains('disabled'))) {
                                const activeLink = document.createElement('a');
                                // copy classes but strip any 'disabled' marker
                                const classList = Array.from(createBtn.classList || []).filter(c => c !== 'disabled');
                                activeLink.className = classList.join(' ');
                                activeLink.href = '{{ route('events.complete.form', $event) }}';
                                activeLink.setAttribute('style', 'display:inline-flex; align-items:center;');
                                activeLink.innerHTML = '<i class="fas fa-clipboard-check me-1"></i> Notulen & Bukti';
                                createBtn.parentNode.replaceChild(activeLink, createBtn);
                            }

                        } else {
                            alert(data.message || 'Gagal menandai kehadiran.');
                        }
                    }).catch(function(err) {
                        console.error('Attend AJAX error', err);
                        // On error, fallback to regular submission
                        attendForm.submit();
                    });
                });
            }
        });

        function previewDocument(documentPath, documentName, completionId) {
            // Set modal title
            document.getElementById('documentPreviewModalLabel').innerHTML = '<i class="fas fa-file-alt me-2"></i>Pratinjau: ' + documentName;

            // Build preview and download URLs via controller endpoints
            const previewUrl = baseUrl + '/events/' + encodeURIComponent(eventIdForPreview) + '/completions/' + encodeURIComponent(completionId) + '/files/preview?path=' + encodeURIComponent(documentPath);
            const downloadUrl = baseUrl + '/events/' + encodeURIComponent(eventIdForPreview) + '/completions/' + encodeURIComponent(completionId) + '/files/download?path=' + encodeURIComponent(documentPath);

            const container = document.getElementById('documentPreviewContainer');
            container.innerHTML = '';

            // determine extension to pick img vs iframe
            const ext = (documentPath.split('.').pop() || '').toLowerCase();

            // set download link
            document.getElementById('downloadFromPreview').href = downloadUrl;

            if (['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
                const img = document.createElement('img');
                img.src = previewUrl;
                img.alt = documentName;
                img.loading = 'auto';
                container.appendChild(img);
            } else if (ext === 'pdf') {
                const iframe = document.createElement('iframe');
                iframe.className = 'preview-iframe';
                iframe.src = previewUrl;
                container.appendChild(iframe);
            } else {
                // For other types open in new tab (let browser handle rendering)
                window.open(previewUrl, '_blank');
                return;
            }

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
            modal.show();
        }

        // Clear preview container when modal is closed to prevent unnecessary loading
        document.getElementById('documentPreviewModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('documentPreviewContainer').innerHTML = '';
        });


    </script>
</body>
</html>