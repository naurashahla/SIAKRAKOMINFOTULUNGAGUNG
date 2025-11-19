<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Agenda - SIAKRA</title>
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
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-create:hover {
            background: #2d2d2d;
            color: white;
        }

        .btn-create i {
            margin-right: 6px;
        }

        /* Main Content */
        .main-content {
            max-width: 550px;
            margin: 0 auto;
            padding: 12px 20px;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .form-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 12px;
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
            color: #9ca3af;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 50px;
            height: auto;
        }

        .row {
            margin: 0 -6px;
        }

        .col-6 {
            padding: 0 6px;
        }

        .form-select {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 13px;
            color: #1f2937;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
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
            background: #3b82f6;;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-save:hover {
            background: #2d2d2d;
        }

        .alert {
            border-radius: 6px;
            border: none;
            margin-bottom: 16px;
            font-size: 13px;
            padding: 8px 12px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 3px solid #dc2626;
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

        /* Search input styling */
        .search-input {
            background: white;
            border: 1px solid #d1d5db;
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
            color: #9ca3af;
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
        /* Push layout when sidebar open on desktop */
        :root.sidebar-open .navbar, :root.sidebar-open .main-content{ margin-left:260px; transition:margin-left .25s ease }

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
    <!-- Backdrop: clicking this will close the sidebar -->
    <div id="offBackdrop" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.06); z-index:1100;"></div>
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
                <!-- Left side - Brand + hamburger -->
                <div class="navbar-brand" style="display:flex;align-items:center;gap:8px;">
                    <span id="brandToggle" style="cursor:pointer"><i class="fas fa-bars me-2"></i></span>
                    <span>SIAKRA</span>
                </div>
                
                <!-- Center - Navigation Menu (only Buat Agenda) -->
                <div id="centerNav" class="d-flex align-items-center gap-2" style="display:none !important;">
                    <a href="{{ route('events.create') }}" class="nav-link active" data-target="Buat Agenda">
                        <i class="fas fa-plus me-1"></i>
                        Buat Agenda
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
            <h1 class="form-title">Buat Agenda</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required>
                </div>

                <div class="form-group">
                    <label for="asal_surat" class="form-label">Dari</label>
                    <input type="text" 
                           class="form-control" 
                           id="asal_surat" 
                           name="asal_surat" 
                           placeholder="Contoh: Sekretariat Daerah, Dinas Pendidikan, dll"
                           value="{{ old('asal_surat') }}">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              rows="2">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="startDate" class="form-label">Tanggal Mulai</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="startDate" 
                                   name="startDate" 
                                   value="{{ old('startDate') }}" 
                                   required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="startTime" class="form-label">Waktu Mulai</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="startTime" 
                                   name="startTime" 
                                   value="{{ old('startTime') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="endDate" class="form-label">Tanggal Selesai</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="endDate" 
                                   name="endDate" 
                                   value="{{ old('endDate') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="endTime" class="form-label">Waktu Selesai</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="endTime" 
                                   name="endTime" 
                                   value="{{ old('endTime') }}">
                            <!-- Checkbox for ongoing/no end date -->
                            <input type="hidden" name="no_end_date" value="0">
                            <label class="form-check-label" style="display: flex; align-items: center; gap: 8px; margin-top: 8px; cursor: pointer; font-size: 13px; font-weight: 500;">
                                <input type="checkbox" 
                                       id="noEndDate" 
                                       name="no_end_date"
                                       value="1"
                                       {{ old('no_end_date') ? 'checked' : '' }}
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
                           value="{{ old('location') }}">
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" 
                              id="keterangan" 
                              name="keterangan" 
                              rows="2" 
                              placeholder="Catatan tambahan atau informasi khusus tentang Agenda">{{ old('keterangan') }}</textarea>
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
                        <div class="file-preview" id="file-preview" style="display: none;">
                            <div class="file-preview-content">
                                <i class="fas fa-file-alt file-icon"></i>
                                <div class="file-details">
                                    <span class="file-name" id="file-name"></span>
                                    <span class="file-size" id="file-size"></span>
                                </div>
                                <button type="button" class="remove-file" onclick="removeFile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient_type" class="form-label">Penerima</label>
                    <select class="form-select" id="recipient_type" name="recipient_type" onchange="toggleRecipientOptions()">
                        <option value="">-- Pilih --</option>
                        <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>Semua Staff ({{ $pegawaiCount }} orang)</option>
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
                                   onchange="updateSelectedCount()"
                                   {{ (old('selected_bidangs') && in_array($bidang, old('selected_bidangs'))) ? 'checked' : '' }}>
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
                                   onchange="updateSelectedCount()"
                                   {{ (old('selected_individuals') && in_array($pegawai->id, old('selected_individuals'))) ? 'checked' : '' }}>
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
                            <!-- Selected items will be shown here -->
                        </div>
                        <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                            Dipilih: <strong><span id="selected_count">0</span> penerima</strong>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('events.index') }}" class="btn-cancel" onclick="try{ localStorage.setItem('siakra:selectedNav', JSON.stringify({ title: 'Semua Agenda', href: '{{ route('events.index') }}', html: '<i class=&quot;fas fa-calendar&quot;></i> Semua Agenda' })); }catch(e){}">Batal</a>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
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

            if(brandToggle) brandToggle.addEventListener('click', function(e){ e.preventDefault(); if(off && off.classList.contains('open')) close(); else open(); });
            if(offBackdrop) offBackdrop.addEventListener('click', function(){ close(); });
            document.addEventListener('pointerdown', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){}
            }, true);

            // Close sidebar when clicking anywhere outside the sidebar (capturing) - ensures pages with their own scripts close on outside click
            document.addEventListener('click', function(e){
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
                try{
                    const stored = localStorage.getItem(NAV_KEY);
                    const center = document.getElementById('centerNav');
                    if(stored && center){
                        const data = JSON.parse(stored);
                        center.innerHTML = '';
                        const single = document.createElement('a');
                        single.className = 'nav-link active';
                        single.href = data.href || '{{ route('events.index') }}';
                        single.innerHTML = data.html || (data.title || 'Semua Agenda');
                        center.appendChild(single);
                    }
                }catch(err){ console.error('restore selected nav failed', err); }
            });

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';
                        try{ localStorage.setItem(NAV_KEY, JSON.stringify({ title: t, href: href, html: a.innerHTML })); }catch(e){}
                        close();
                        const center = document.getElementById('centerNav');
                        if(center){ center.innerHTML = ''; const single = document.createElement('a'); single.className = 'nav-link active'; single.href = href; single.innerHTML = a.innerHTML; center.appendChild(single); }
                    });
                });
            }
        })();
        // Data from server
        window.pegawaiCount = {{ $pegawaiCount }};
        window.bidangCounts = @json($bidangCounts);
        window.pegawaiData = @json($pegawaiList->keyBy('id')->toArray());
        window.kepalaBidangCount = {{ $kepalaBidangCount }};
        window.kepalaBidangData = @json($kepalaBidangList->keyBy('id')->toArray());
        window.kepalaBidangCounts = @json($kepalaBidangCounts);

        // Use data from window object
        const pegawaiCount = window.pegawaiCount;
        const bidangCounts = window.bidangCounts;
        const pegawaiData = window.pegawaiData;
        const kepalaBidangCount = window.kepalaBidangCount;
        const kepalaBidangData = window.kepalaBidangData;
        const kepalaBidangCounts = window.kepalaBidangCounts;
        
        // Handle recipient type selection
        function toggleRecipientOptions() {
            const recipientType = document.getElementById('recipient_type').value;
            const bidangSelection = document.getElementById('bidang_selection');
            const kepalaBidangSelection = document.getElementById('kepala_bidang_selection');
            const individualSelection = document.getElementById('individual_selection');
            const previewSelected = document.getElementById('preview_selected');
            
            // Hide all options first
            bidangSelection.style.display = 'none';
            kepalaBidangSelection.style.display = 'none';
            individualSelection.style.display = 'none';
            previewSelected.style.display = 'none';
            
            // Clear previous selections
            clearAllSelections();
            
            // Show relevant option
            if (recipientType === 'bidang') {
                bidangSelection.style.display = 'block';
                previewSelected.style.display = 'block';
            } else if (recipientType === 'kepala_bidang') {
                kepalaBidangSelection.style.display = 'block';
                previewSelected.style.display = 'block';
            } else if (recipientType === 'individual') {
                individualSelection.style.display = 'block';
                previewSelected.style.display = 'block';
            } else if (recipientType === 'all') {
                previewSelected.style.display = 'block';
                updateSelectedCount();
            }
        }
        
        // Clear all checkbox selections
        function clearAllSelections() {
            const bidangCheckboxes = document.querySelectorAll('input[name="selected_bidangs[]"]');
            const kepalaBidangCheckboxes = document.querySelectorAll('input[name="selected_kepala_bidangs[]"]');
            const individualCheckboxes = document.querySelectorAll('input[name="selected_individuals[]"]');
            
            bidangCheckboxes.forEach(cb => cb.checked = false);
            kepalaBidangCheckboxes.forEach(cb => cb.checked = false);
            individualCheckboxes.forEach(cb => cb.checked = false);
            
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
        
        // Update selected count and preview
        function updateSelectedCount() {
            const recipientType = document.getElementById('recipient_type').value;
            const selectedCountSpan = document.getElementById('selected_count');
            const selectedPreview = document.getElementById('selected_preview');
            
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
                        (kb.jabatan.includes('KEPALA BIDANG') || kb.jabatan.includes('KABID')) || 
                        (kb.jabatan.includes('SEKRETARIS') && bidangName === 'PIMPINAN')
                        
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
        
        // Toggle end date fields when S/D Selesai checkbox is changed
        function toggleEndDateFields() {
            const noEndDateCheckbox = document.getElementById('noEndDate');
            const endDateInput = document.getElementById('endDate');
            const endTimeInput = document.getElementById('endTime');
            
            if (noEndDateCheckbox && noEndDateCheckbox.checked) {
                // Keep endDate enabled, but disable endTime when "S/D Selesai" is checked
                endDateInput.disabled = false;
                endDateInput.style.opacity = '1';
                endTimeInput.disabled = true;
                endTimeInput.value = '';
                endTimeInput.style.opacity = '0.5';
            } else {
                // Enable both fields when checkbox is unchecked
                endDateInput.disabled = false;
                endTimeInput.disabled = false;
                endDateInput.style.opacity = '1';
                endTimeInput.style.opacity = '1';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const recipientType = document.getElementById('recipient_type').value;
            if (recipientType) {
                toggleRecipientOptions();
            }
            
            // Initialize toggle if checkbox is already checked
            const noEndDateCheckbox = document.getElementById('noEndDate');
            if (noEndDateCheckbox && noEndDateCheckbox.checked) {
                toggleEndDateFields();
            }
        });

        // File upload functions
        function handleFileSelect(event) {
            const file = event.target.files[0];
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const uploadContainer = document.querySelector('.file-upload-container');
            
            if (file) {
                // Validate file type
                const allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file PDF atau DOCX yang diperbolehkan!');
                    event.target.value = '';
                    return;
                }
                
                // Validate file size (10MB = 10 * 1024 * 1024 bytes)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file tidak boleh lebih dari 10MB!');
                    event.target.value = '';
                    return;
                }
                
                // Show preview
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                filePreview.style.display = 'block';
                uploadContainer.classList.add('has-file');
                
                // Update icon based on file type
                const fileIcon = document.querySelector('.file-icon');
                if (file.type === 'application/pdf') {
                    fileIcon.className = 'fas fa-file-pdf file-icon';
                    fileIcon.style.color = '#dc2626';
                } else {
                    fileIcon.className = 'fas fa-file-word file-icon';
                    fileIcon.style.color = '#2563eb';
                }
            }
        }

        function removeFile() {
            const fileInput = document.getElementById('document');
            const filePreview = document.getElementById('file-preview');
            const uploadContainer = document.querySelector('.file-upload-container');
            
            fileInput.value = '';
            filePreview.style.display = 'none';
            uploadContainer.classList.remove('has-file');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>