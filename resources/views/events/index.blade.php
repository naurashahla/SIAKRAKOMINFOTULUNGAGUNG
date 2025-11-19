<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>
        @if(($effectiveDateFilter ?? 'today') == 'today')
            Agenda Diskominfo Tulungagung - SIAKRA
        @elseif(($effectiveDateFilter ?? '') == 'tomorrow')
            Agenda Diskominfo Tulungagung Besok - SIAKRA
        @elseif(($effectiveDateFilter ?? '') == 'upcoming')
            Agenda Diskominfo Tulungagung Mendatang - SIAKRA
        @elseif(($effectiveDateFilter ?? '') == 'this_week')
            Agenda Diskominfo Tulungagung Minggu Ini - SIAKRA
        @elseif(($effectiveDateFilter ?? '') == 'this_month')
            Agenda Diskominfo Tulungagung Bulan Ini - SIAKRA
        @elseif(($effectiveDateFilter ?? '') == 'next_month')
            Agenda Diskominfo Tulungagung Bulan Depan - SIAKRA
        @else
            Semua Agenda Diskominfo Tulungagung - SIAKRA
        @endif
    </title>
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
            overflow-x: hidden; /* Prevent horizontal scroll */
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

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 24px;
            height: calc(100vh - 64px);
            overflow-y: auto;
            overflow-x: hidden; /* Prevent horizontal scroll in main content */
        }

        .page-header {
            margin-bottom: 20px;
        }

        .combined-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .header-left {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        .events-count {
            background: transparent;
            color: #6b7280;
            font-size: 16px;
            font-weight: 600;
            padding: 0;
            border-radius: 0;
            border: none;
        }

        .header-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-box {
            position: relative;
            min-width: 200px;
        }

        .search-input {
            width: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 12px 10px 40px;
            font-size: 14px;
            color: #1f2937;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }

        .filter-select {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #1f2937;
            min-width: 130px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 36px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Agenda Saya (mine) button: match center nav (.nav-link) styles */
        #mine-toggle-btn {
            background-image: none !important; /* remove default select arrow */
            padding: 8px 16px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            min-width: 120px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            color: #64748b !important;
            transition: all 0.3s ease !important;
        }

        /* Active state for Agenda Saya - reuse .nav-link.active look */
        #mine-toggle-btn.mine-active, #mine-toggle-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
            color: white !important;
            border-color: transparent !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
        }

        #mine-toggle-btn.mine-active i, #mine-toggle-btn.active i {
            color: #fff !important;
        }

        /* Passive state: remove border and shadow so it looks neutral */
        #mine-toggle-btn:not(.mine-active):not(.active) {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            color: #64748b !important;
        }

        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: white;
        }

        /* Calendar Button Styles */
        #specific-date-btn {
            background-image: none !important;
            padding-right: 8px !important;
            min-width: 40px !important;
            transition: all 0.2s ease;
        }

        #specific-date-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        #specific-date-btn.active {
            background: #eff6ff;
            border-color: #3b82f6;
            color: #1d4ed8;
        }

        .specific-date-wrapper {
            display: none;
            transition: all 0.3s ease;
            margin-top: 8px;
            position: relative;
            width: 100%;
        }
        
        .date-filter-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .date-filter-select {
            min-width: 140px;
        }
        
        .specific-date-input {
            background: #f0f9ff;
            border: 1px solid #3b82f6;
            color: #1e40af;
        }
        
        .specific-date-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        /* Additional Calendar Styling for Perfect Match */
        .specific-date-wrapper {
            position: relative;
        }
        
        /* Visual feedback when date is selected */
        .specific-date-wrapper.date-selected {
            animation: dateSelected 0.6s ease-in-out;
        }
        
        @keyframes dateSelected {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .specific-date-wrapper.date-selected .custom-calendar-widget {
            border-color: #10b981 !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15) !important;
        }
        
        .custom-calendar-widget {
            background: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            padding: 12px !important;
            width: 280px !important;
            max-width: calc(100vw - 40px) !important;
            font-family: 'Inter', sans-serif !important;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            z-index: 1000 !important;
            margin-top: 4px !important;
            overflow: hidden !important;
        }
        
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding: 0 4px;
        }
        
        .calendar-month-year {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            min-width: 140px;
            text-align: center;
        }
        
        .calendar-nav-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 16px;
            font-weight: 500;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .calendar-nav-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }
        
        .calendar-grid {
            width: 100%;
        }
        
        .calendar-day-headers {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 8px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            padding: 8px 4px;
        }
        
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        
        .calendar-day {
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 13px !important;
            border: none !important;
            background: white !important;
            cursor: pointer !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
            color: #374151 !important;
            position: relative !important;
            font-weight: 500 !important;
            margin: 0 auto !important;
            min-width: 32px !important;
            flex-shrink: 0 !important;
        }
        
        .calendar-day:hover {
            background: #f3f4f6 !important;
        }
        
        .calendar-day.today {
            background: #3b82f6 !important;
            color: white !important;
            font-weight: 600 !important;
        }
        
        .calendar-day.selected {
            background: #1d4ed8 !important;
            color: white !important;
            font-weight: 600 !important;
        }
        
        .calendar-day.other-month {
            color: #d1d5db !important;
        }
        
        .calendar-day.has-events {
            background: #dbeafe;
            color: #1e40af;
            font-weight: 500;
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
            background: #bfdbfe;
        }
        
        .calendar-day.has-events.selected {
            background: #1d4ed8;
            color: white;
        }
        
        .calendar-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #f3f4f6;
        }
        
        .calendar-footer-btn {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            background: none;
        }
        
        /* Date selection feedback animation */
        .date-selected {
            animation: dateSelectionPulse 0.6s ease-out;
        }
        
        @keyframes dateSelectionPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .calendar-day.selected {
            background: #10b981 !important;
            color: white !important;
            border: 2px solid #059669 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
        }

        .clear-btn {
            color: #6b7280;
        }
        
        .clear-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }
        
        .today-btn {
            color: #3b82f6;
        }
        
        .today-btn:hover {
            background: #eff6ff;
            color: #1d4ed8;
        }



        .export-daily-btn {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }

        .export-daily-btn:hover {
            background: #dcfce7;
            border-color: #86efac;
            color: #15803d;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .events-grid {
            display: grid;
            /* Reduce min card width so more cards can fit per row on wider screens */
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            align-items: start;
        }

        .event-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .event-card.clickable-card {
            cursor: pointer;
        }

        .event-card.clickable-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #1e40af, #6366f1);
            border-radius: 12px 12px 0 0;
        }

        .event-card:hover {
            background: #f8fafc;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
            border-color: #cbd5e1;
        }

        .event-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .event-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            line-height: 1.4;
            letter-spacing: -0.02em;
            /* Reserve horizontal space so top-right attendance badge doesn't overlap title */
            padding-right: 110px;
        }

        .event-description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
            flex: 1;
            font-weight: 400;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 12px;
            margin-top: auto;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .event-meta-item i {
            color: #6b7280;
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .event-actions {
            display: flex;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            margin-top: auto;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid;
            transition: all 0.3s ease;
            min-width: 80px;
            text-align: center;
            letter-spacing: 0.02em;
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
        }

        .btn-export {
            color: #059669;
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .btn-export:hover {
            color: #047857;
            background: #d1fae5;
            border-color: #6ee7b7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        .btn-delete {
            color: #dc2626;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .btn-delete:hover {
            color: #b91c1c;
            background: #fee2e2;
            border-color: #fca5a5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
        }

        .notification-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 16px;
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

        /* Attendance badge for event cards (current user's status) */
        .attendance-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            position: absolute;
            top: 8px;
            right: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
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

        .attendance-badge.notification-completed {
            background: #ecfdf5; /* very light green */
            color: #047857; /* green text */
        }

        .attendance-badge.notification-transferred {
            background: #fef3c7; /* very light yellow */
            color: #b45309; /* amber/dark yellow text */
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 24px;
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

        /* Responsive adjustments */
        @media (max-height: 800px) {
            .main-content {
                padding: 10px 20px;
            }
            
            .combined-header {
                padding: 12px;
                margin-bottom: 16px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .events-grid {
                gap: 12px;
            }
            
            .event-card {
                padding: 14px;
            }
        }

        @media (max-height: 700px) {
            .navbar {
                padding: 6px 0;
            }
            
            .main-content {
                padding: 8px 16px;
                max-height: calc(100vh - 60px);
            }
            
            .combined-header {
                padding: 10px;
                margin-bottom: 12px;
                gap: 12px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .page-subtitle {
                font-size: 13px;
            }
            
            .header-right {
                gap: 8px;
            }
            
            .search-input, .filter-select {
                padding: 6px 8px;
                font-size: 13px;
            }

            .view-toggle-btn {
                padding: 6px 8px;
                font-size: 12px;
            }
            
            .search-input {
                padding-left: 28px;
            }
            
            .filter-select {
                min-width: 100px;
                padding-right: 28px;
            }
            
            .search-icon {
                left: 8px;
                font-size: 12px;
            }
            
            .events-grid {
                gap: 10px;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
            
            .event-card {
                padding: 12px;
            }
            
            .event-title {
                font-size: 15px;
                margin-bottom: 4px;
            }
            
            .event-description {
                font-size: 12px;
                margin-bottom: 10px;
            }
            
            .event-meta {
                gap: 4px;
                margin-bottom: 10px;
            }
            
            .event-meta-item {
                font-size: 12px;
                gap: 4px;
            }
            
            .event-actions {
                padding-top: 10px;
                gap: 6px;
            }
            
            .btn-action {
                padding: 5px 10px;
                font-size: 11px;
                min-width: 60px;
            }
            
            .empty-state {
                padding: 30px 16px;
            }
            
            .empty-state i {
                font-size: 40px;
                margin-bottom: 10px;
            }
            
            .empty-state h3 {
                font-size: 16px;
                margin-bottom: 4px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 8px 12px;
            }
            
            .combined-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .header-left {
                text-align: center;
            }
            
            .header-right {
                flex-direction: column;
                gap: 8px;
            }
            
            .search-box {
                width: 100%;
                min-width: auto;
            }
            
            .filter-select {
                width: 100%;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .event-card {
                padding: 12px;
            }
            
            .event-title {
                font-size: 15px;
                margin-bottom: 4px;
                padding-right: 48px; /* smaller reserved space on narrower screens */
            }
            
            .event-description {
                font-size: 12px;
                margin-bottom: 10px;
            }
            
            .event-meta {
                gap: 4px;
                margin-bottom: 10px;
            }
            
            .event-meta-item {
                font-size: 12px;
                gap: 4px;
            }
            
            .event-actions {
                padding-top: 10px;
                gap: 6px;
            }
            
            .btn-action {
                padding: 5px 10px;
                font-size: 11px;
                min-width: 60px;
            }
            
            /* Mobile Calendar Responsive Fixes */
            .custom-calendar-widget {
                width: calc(100vw - 32px) !important;
                max-width: 320px !important;
                right: 0 !important;
                left: auto !important;
                transform: none !important;
                padding: 10px !important;
                margin-top: 8px !important;
                border-radius: 12px !important;
            }
            
            .calendar-header {
                margin-bottom: 12px !important;
                padding: 0 2px !important;
            }
            
            .calendar-month-year {
                font-size: 15px !important;
                min-width: 120px !important;
            }
            
            .calendar-nav-btn {
                width: 32px !important;
                height: 32px !important;
                font-size: 18px !important;
            }
            
            .calendar-days {
                gap: 2px !important;
            }
            
            .calendar-day {
                width: 36px !important;
                height: 36px !important;
                font-size: 14px !important;
                min-width: 36px !important;
                border-radius: 8px !important;
            }
            
            .calendar-day.has-events::after {
                width: 5px !important;
                height: 5px !important;
                bottom: 3px !important;
                right: 3px !important;
            }
            
            .calendar-footer {
                margin-top: 12px !important;
                padding-top: 10px !important;
            }
            
            .calendar-footer-btn {
                padding: 8px 12px !important;
                font-size: 13px !important;
            }
            
            /* Ensure calendar widget doesn't cause horizontal scroll */
            .date-filter-wrapper {
                position: relative !important;
                overflow: visible !important;
            }
            
            .specific-date-wrapper {
                position: relative !important;
                overflow: visible !important;
                width: 100% !important;
            }
            
            /* Smart positioning for calendar widget on mobile */
            .custom-calendar-widget {
                margin-right: 16px !important;
            }
            
            /* Ensure calendar is within viewport bounds */
            @media (max-width: 350px) {
                .custom-calendar-widget {
                    width: calc(100vw - 20px) !important;
                    max-width: 280px !important;
                    right: 10px !important;
                    margin-right: 0 !important;
                }
            }
        }

        /* Extra small mobile devices (portrait phones, less than 576px) */
        @media (max-width: 575px) {
            .custom-calendar-widget {
                width: calc(100vw - 24px) !important;
                max-width: 300px !important;
                padding: 8px !important;
                margin-top: 6px !important;
                right: 12px !important;
                left: auto !important;
                transform: none !important;
            }
            
            .calendar-header {
                margin-bottom: 10px !important;
                padding: 0 !important;
            }
            
            .calendar-month-year {
                font-size: 14px !important;
                min-width: 100px !important;
            }
            
            .calendar-nav-btn {
                width: 28px !important;
                height: 28px !important;
                font-size: 16px !important;
            }
            
            .calendar-day-header {
                font-size: 11px !important;
                padding: 6px 2px !important;
            }
            
            .calendar-days {
                gap: 1px !important;
            }
            
            .calendar-day {
                width: 32px !important;
                height: 32px !important;
                font-size: 13px !important;
                min-width: 32px !important;
            }
            
            .calendar-footer {
                margin-top: 10px !important;
                padding-top: 8px !important;
            }
            
            .calendar-footer-btn {
                padding: 6px 10px !important;
                font-size: 12px !important;
            }
            
            /* Make header more compact on very small screens */
            .combined-header {
                padding: 10px !important;
                gap: 10px !important;
            }
            
            .page-title {
                font-size: 18px !important;
            }
            
            .page-subtitle {
                font-size: 12px !important;
            }
            
            .header-right {
                gap: 6px !important;
            }
            
            .search-input, .filter-select {
                padding: 6px 8px !important;
                font-size: 13px !important;
            }
            
            .search-input {
                padding-left: 32px !important;
            }
            
            .search-icon {
                left: 10px !important;
                font-size: 12px !important;
            }
        }

        /* Pagination Styles */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background: white;
            color: #6b7280;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 40px;
            height: 40px;
        }

        .page-link:hover {
            background: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .page-item.disabled .page-link {
            color: #d1d5db;
            cursor: not-allowed;
            background: #f9fafb;
        }

        .page-item.disabled .page-link:hover {
            background: #f9fafb;
            color: #d1d5db;
            border-color: #e5e7eb;
        }

        @media (max-width: 768px) {
            .pagination {
                gap: 4px;
            }
            
            .page-link {
                padding: 6px 8px;
                min-width: 32px;
                height: 32px;
                font-size: 12px;
            }
        }

        /* Advanced Search Styles */
        .advanced-search-wrapper {
            position: relative;
            display: inline-block;
        }

        .advanced-search-toggle {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 12px;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .advanced-search-toggle:hover {
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
        }

        .advanced-search-panel {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-top: 4px;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            min-width: 220px;
            max-width: 280px;
            width: max-content;
        }

        .advanced-search-panel.show {
            display: block;
        }

        .search-section {
            margin-bottom: 12px;
        }

        .search-section:last-child {
            margin-bottom: 0;
        }

        .search-section-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .search-row {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input-small {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            width: 80px;
            height: 28px;
        }

        .search-input-medium {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            width: 140px;
            height: 28px;
            flex-shrink: 0;
        }

        .search-select-small {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            width: 100px;
            height: 28px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 4px center;
            background-repeat: no-repeat;
            background-size: 12px;
            padding-right: 24px;
        }

        .search-label {
            font-size: 12px;
            color: #6b7280;
            margin-right: 4px;
        }

        .clear-filters-btn {
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-filters-btn:hover {
            background: #b91c1c;
        }

        /* Responsive advanced search */
        @media (max-width: 768px) {
            .advanced-search-panel {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                right: auto;
                min-width: 240px;
                max-width: 90vw;
                max-height: 80vh;
                overflow-y: auto;
            }
            
            .search-row {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .search-input-medium {
                width: 100%;
            }
            
            .search-label {
                margin-right: 0;
                margin-bottom: 4px;
            }
        }

        /* Close button for mobile */
        .panel-close-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .panel-close-btn:hover {
            background: #f3f4f6;
            color: #374151;
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
        /* Hide navbar when necessary */
        .navbar.nav-hidden{ display:none !important }
        @media (max-width:768px){ :root.sidebar-open .navbar, :root.sidebar-open .main-content{ margin-left:0 } }
    </style>
</head>
<body>
    <!-- Off-canvas sidebar -->
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
                        <!-- Manajemen Penerima link removed from sidebar; accessible via Manajemen User -->
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
                <!-- Left side - Brand (non-clickable) -->
                <div class="navbar-brand" style="display:flex;align-items:center;gap:8px;">
                    <span id="brandToggle" style="cursor:pointer"><i class="fas fa-bars me-2"></i></span>
                    <span>SIAKRA</span>
                </div>
                
                <!-- Center - Navigation Menu (only for non-admin users) -->
                @if(!(auth()->check() && in_array(strtolower(auth()->user()->role ?? ''), ['admin','super_admin'])))
                <div id="centerNav" class="d-flex align-items-center gap-2">
                    <a href="{{ route('events.index') }}" class="nav-link active">
                        <i class="fas fa-calendar me-1"></i>
                        Semua Agenda
                    </a>
                </div>
                @endif

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
        <!-- Combined Header with Title and Search/Filters -->
        <div class="combined-header">
            <div class="header-left">
                <h1 class="page-title">
                    @if(($effectiveDateFilter ?? 'today') == 'today')
                        Agenda Diskominfo Tulungagung
                    @elseif(($effectiveDateFilter ?? '') == 'tomorrow')
                        Agenda Diskominfo Tulungagung Besok
                    @elseif(($effectiveDateFilter ?? '') == 'upcoming')
                        Agenda Diskominfo Tulungagung Mendatang
                    @elseif(($effectiveDateFilter ?? '') == 'this_week')
                        Agenda Diskominfo Tulungagung Minggu Ini
                    @elseif(($effectiveDateFilter ?? '') == 'this_month')
                        Agenda Diskominfo Tulungagung Bulan Ini
                    @elseif(($effectiveDateFilter ?? '') == 'next_month')
                        Agenda Diskominfo Tulungagung Bulan Depan
                    @else
                        Semua Agenda Diskominfo Tulungagung
                    @endif
                    <span class="events-count">({{ $events->count() }})</span>
                </h1>
                <p class="page-subtitle">
                    @if(($effectiveDateFilter ?? 'today') == 'today')
                        Menampilkan Agenda kegiatan untuk hari ini, {{ \Carbon\Carbon::now()->format('d F Y') }}
                    @elseif(($effectiveDateFilter ?? '') == 'tomorrow')
                        Menampilkan Agenda kegiatan untuk besok, {{ \Carbon\Carbon::now()->addDay()->format('d F Y') }}
                    @elseif(($effectiveDateFilter ?? '') == 'upcoming')
                        Menampilkan Agenda kegiatan yang akan datang
                    @elseif(($effectiveDateFilter ?? '') == 'this_week')
                        Menampilkan Agenda kegiatan untuk minggu ini ({{ \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('d F') }} - {{ \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->format('d F Y') }})
                    @elseif(($effectiveDateFilter ?? '') == 'this_month')
                        Menampilkan Agenda kegiatan untuk bulan {{ \Carbon\Carbon::now()->format('F Y') }}
                    @elseif(($effectiveDateFilter ?? '') == 'next_month')
                        Menampilkan Agenda kegiatan untuk bulan {{ \Carbon\Carbon::now()->addMonth()->format('F Y') }}
                    @elseif(($effectiveDateFilter ?? '') == 'specific' && request('specific_date'))
                        Menampilkan Agenda kegiatan untuk tanggal {{ \Carbon\Carbon::parse(request('specific_date'))->format('d F Y') }}
                    @else
                        Kelola Agenda dan rapat Anda
                    @endif
                </p>
            </div>
            
            <div class="header-right">
                <form id="events-filter-form" method="GET" action="{{ route('events.index') }}" style="display: flex; gap: 12px; align-items: center;">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               name="search" 
                               class="search-input" 
                               placeholder="Cari Agenda..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    @if(in_array($role, ['admin','super_admin']))
                    <!-- Notification status filter for admins -->
                    <div>
                        <select name="notification_status" class="filter-select" style="min-width:160px;">
                            <option value="" {{ request('notification_status') == '' ? 'selected' : '' }}>Semua Notifikasi</option>
                            <option value="sent" {{ request('notification_status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                            <option value="pending" {{ request('notification_status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="failed" {{ request('notification_status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>
                    @endif

                    <!-- Date Filter with Calendar Icon -->
                    <div class="date-filter-wrapper">
                        <select name="date_filter" class="filter-select date-filter-select">
                            <option value="all_events" {{ ($effectiveDateFilter ?? '') == 'all_events' ? 'selected' : '' }}>Semua Tanggal</option>
                            <option value="today" {{ ($effectiveDateFilter ?? 'today') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="tomorrow" {{ ($effectiveDateFilter ?? '') == 'tomorrow' ? 'selected' : '' }}>Besok</option>
                            <option value="upcoming" {{ ($effectiveDateFilter ?? '') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                            <option value="this_week" {{ ($effectiveDateFilter ?? '') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="this_month" {{ ($effectiveDateFilter ?? '') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="next_month" {{ ($effectiveDateFilter ?? '') == 'next_month' ? 'selected' : '' }}>Bulan Depan</option>
                        </select>
                    </div>

                    <!-- Specific Date Filter Button -->
                    <div class="date-filter-wrapper">
                        <button type="button" 
                                class="filter-select" 
                                id="specific-date-btn" 
                                onclick="toggleSpecificDateCalendar()" 
                                style="cursor: pointer; display: flex; align-items: center; justify-content: center; min-width: 40px; padding: 8px;"
                                title="@if(request('specific_date')){{ \Carbon\Carbon::parse(request('specific_date'))->format('d F Y') }}@else Pilih Tanggal Spesifik @endif">
                            <i class="fas fa-calendar-alt" style="font-size: 16px;"></i>
                        </button>
                        
                        <!-- Custom Calendar Widget that appears when button is clicked -->
                        <div class="specific-date-wrapper" id="specific-date-wrapper" style="display: none;">
                            <div class="custom-calendar-widget" id="custom-calendar">
                                <div class="calendar-header">
                                    <button type="button" class="calendar-nav-btn" id="prev-month">&lt;</button>
                                    <div class="calendar-month-year" id="calendar-month-year">October 2025</div>
                                    <button type="button" class="calendar-nav-btn" id="next-month">&gt;</button>
                                </div>
                                
                                <div class="calendar-grid">
                                    <div class="calendar-day-headers">
                                        <div class="calendar-day-header">Min</div>
                                        <div class="calendar-day-header">Sen</div>
                                        <div class="calendar-day-header">Sel</div>
                                        <div class="calendar-day-header">Rab</div>
                                        <div class="calendar-day-header">Kam</div>
                                        <div class="calendar-day-header">Jum</div>
                                        <div class="calendar-day-header">Sab</div>
                                    </div>
                                    <div class="calendar-days" id="calendar-days">
                                        <!-- Days will be populated by JavaScript -->
                                    </div>
                                </div>
                                
                                <div class="calendar-footer">
                                    <button type="button" class="calendar-footer-btn clear-btn" id="clear-date">Hapus Filter</button>
                                    <button type="button" class="calendar-footer-btn today-btn" id="today-btn">Hari Ini</button>
                                </div>
                            </div>
                            
                <!-- Hidden input for form submission -->
                <!-- (merged: use single hidden field `specific-date-hidden`) -->
                        </div>
                    </div>
                    
                    <!-- Mine (Agenda Saya) toggle and Hidden inputs -->
                    @if(auth()->check() && !in_array(auth()->user()->role, ['admin','super_admin']))
                        <button type="button" id="mine-toggle-btn" class="filter-select nav-link {{ request('mine') ? 'mine-active' : '' }}" 
                                onclick="document.getElementById('mine-hidden').value = document.getElementById('mine-hidden').value ? '' : '1'; document.getElementById('filter-submit-btn').click();"
                                title="Tampilkan Agenda Saya" aria-pressed="{{ request('mine') ? 'true' : 'false' }}">
                            <i class="fas fa-user"></i>
                            <span style="font-size:14px; font-weight:600;">Agenda Saya</span>
                        </button>
                    @endif

                    <input type="hidden" name="mine" id="mine-hidden" value="{{ request('mine') }}">
                    <input type="hidden" name="sort" value="desc">
                    <input type="hidden" name="sort_field" value="startDate">
                    <input type="hidden" name="specific_date" value="{{ request('specific_date') }}" id="specific-date-hidden">

                    <button type="submit" style="display: none;" id="filter-submit-btn"></button>
                </form>


                
                @if(in_array($role, ['admin','super_admin']))
                <!-- Export Word Button - Uses Current Filter Date -->
                <button type="button" 
                        class="export-daily-btn" 
                        onclick="exportCurrentFilterDate()"
                        title="Ekspor Agenda untuk Tanggal yang Sedang Dipilih">
                    <i class="fas fa-file-word"></i>
                    Word
                </button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($events->count() > 0)
            
            <div class="events-grid" id="events-container">
                @foreach($events as $event)
                    <div class="event-card clickable-card" data-event-card onclick="location.href='{{ route('events.show', $event) }}'">
                        @php
                            $status = null;
                            if (auth()->check()) {
                                try {
                                    $att = \App\Models\EventAttendance::where('event_id', $event->id)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                    $status = $att->status ?? null;
                                } catch (\Exception $e) {
                                    $status = null;
                                }
                                try {
                                    $comp = \App\Models\EventCompletion::where('event_id', $event->id)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                    if ($comp) $status = 'completed';
                                } catch (\Exception $e) {}
                            }

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

                        @php
                            // Aggregate attendance for this event (attended / recipients)
                            $recCount = $event->recipients_count ?? ($event->recipients->count() ?? 0);
                            $attCount = $attendanceRows[$event->id] ?? 0;
                            $aggClass = 'notification-pending';
                            if ($recCount > 0) {
                                // number of completions (users who uploaded notulen/bukti)
                                $compCount = $completionRows[$event->id] ?? 0;

                                // decide badge class
                                if ($attCount == $recCount && $compCount == $recCount) {
                                    // everyone attended and everyone completed -> mark as finished
                                    $aggClass = 'notification-completed';
                                    $aggLabel = 'Selesai';
                                } else {
                                    if ($attCount == $recCount) {
                                        $aggClass = 'notification-completed';
                                    } elseif ($attCount > 0) {
                                        $aggClass = 'notification-sent';
                                    } else {
                                        $aggClass = 'notification-pending';
                                    }
                                    $aggLabel = $attCount . '/' . $recCount . ' Hadir';
                                }
                            }
                        @endphp

                        @if(isset($recCount) && $recCount > 0)
                            <span id="event-attendance-badge-{{ $event->id }}" class="attendance-badge {{ $aggClass }}">{{ $aggLabel }}</span>
                        @endif

                        <div class="event-content">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            @if($event->description)
                                <p class="event-description">{{ Str::limit($event->description, 100) }}</p>
                            @endif
                            
                            <div class="event-meta">
                                <div class="event-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $event->startDate->format('d M Y') }}</span>
                                    @if($event->startTime)
                                        <span>at {{ $event->startTime }}</span>
                                    @endif
                                </div>
                                @if($event->location)
                                    <div class="event-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif
                                @if($event->asal_surat)
                                    <div class="event-meta-item">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $event->asal_surat }}</span>
                                    </div>
                                @endif
                                @if($event->recipients->count() > 0)
                                    <div class="event-meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $event->recipients->count() }} orang</span>
                                    </div>
                                @endif
                                @if(in_array($role, ['admin','super_admin']))
                                <div class="event-meta-item">
                                    <i class="fas fa-bell"></i>
                                    <span>Notifikasi:</span>
                                    <span class="notification-badge notification-{{ $event->notification_status }}">
                                        @if($event->notification_status == 'sent')
                                            <i class="fas fa-check"></i> Terkirim
                                        @elseif($event->notification_status == 'failed')
                                            <i class="fas fa-times"></i> Gagal
                                        @else
                                            <i class="fas fa-clock"></i> Menunggu
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if(in_array($role, ['admin','super_admin']))
                        <div class="event-actions">
                            <a href="{{ route('events.edit', $event) }}" class="btn-action btn-edit" onclick="event.stopPropagation();">
                                <i class="fas fa-edit me-1"></i>
                                Ubah
                            </a>
                            <a href="#" onclick="deleteEvent('{{ $event->id }}'); event.stopPropagation();" class="btn-action btn-delete">
                                <i class="fas fa-trash me-1"></i>
                                Hapus
                            </a>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper" style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $events->links('custom.pagination') }}
            </div>

        @else
            <div class="empty-state">
                <i class="fas fa-calendar-plus"></i>
                <h3>Belum ada Agenda</h3>
                @if(in_array(strtolower(auth()->user()->role ?? ''), ['admin','super_admin']))
                <p>Buat Agenda pertama Anda untuk memulai</p>
                <a href="{{ route('events.create') }}" class="btn-create">
                    <i class="fas fa-plus me-1" style="font-size:16px; vertical-align:center;"></i>
                    Buat Agenda
                </a>
                @else
                <p>Belum ada Agenda yang tersedia saat ini</p>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Form (hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteEvent(id) {
            if (confirm('Apakah Anda yakin ingin menghapus Agenda ini?')) {
                const form = document.getElementById('delete-form');
                form.action = '/events/' + id;
                form.submit();
            }
        }

        // View Toggle Functionality - REMOVED
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved view preference - always use grid view now
            const eventsContainer = document.getElementById('events-container');
            const eventCards = document.querySelectorAll('[data-event-card]');

            // Force grid view if the events container exists (guard for empty state)
            if (eventsContainer) {
                eventsContainer.className = 'events-grid';
                eventCards.forEach(card => {
                    card.classList.remove('list-view');
                });
            }

            // Auto-submit form when filters change
            const searchInput = document.querySelector('[name="search"]');
            const statusSelect = document.querySelector('[name="status"]');
            const notificationSelect = document.querySelector('[name="notification_status"]');
            const dateSelect = document.querySelector('[name="date_filter"]');
            const sortSelect = document.querySelector('[name="sort"]');
            const form = document.getElementById('events-filter-form'); // Use specific form ID

            // Auto-submit on select change (only if element exists)
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    form.submit();
                });
            }

            if (notificationSelect) {
                notificationSelect.addEventListener('change', function() {
                    form.submit();
                });
            }

            dateSelect.addEventListener('change', function() {
                // If user selected the "specific" option, open the calendar instead of submitting
                if (this.value === 'specific') {
                    // Keep the select on 'specific' and show the calendar widget
                    showSpecificDateCalendar();
                    return; // Do not submit the form
                }

                // For all other selections, clear any specific date and submit
                document.getElementById('specific-date-hidden').value = '';
                // Reset specific date button tooltip
                const specificDateBtn = document.getElementById('specific-date-btn');
                specificDateBtn.title = 'Pilih Tanggal Spesifik';
                specificDateBtn.classList.remove('active');
                // Hide calendar if visible
                const wrapper = document.getElementById('specific-date-wrapper');
                if (wrapper) wrapper.style.display = 'none';
                form.submit();
            });

            // Add special handler for when user clicks on the already selected "specific" option
            dateSelect.addEventListener('click', function(e) {
                // Check if user is clicking on specific option when it's already selected
                if (this.value === 'specific') {
                    const specificDateWrapper = document.getElementById('specific-date-wrapper');
                    // If calendar is hidden, show it again
                    if (specificDateWrapper.style.display === 'none' || !specificDateWrapper.style.display) {

                        showSpecificDateCalendar();
                    }
                }
            });

            // Add focus handler to detect when dropdown gets focus and specific is selected
            dateSelect.addEventListener('focus', function() {
                if (this.value === 'specific') {
                    const specificDateWrapper = document.getElementById('specific-date-wrapper');
                    // Show calendar if it's hidden
                    if (specificDateWrapper.style.display === 'none' || !specificDateWrapper.style.display) {

                        showSpecificDateCalendar();
                    }
                }
            });

            // Add handler for when dropdown opens (mousedown) to check if specific is already selected
            dateSelect.addEventListener('mousedown', function() {
                // Store current state for comparison after selection
                this.previousValue = this.value;
            });

            // Add handler for when dropdown selection is made
            dateSelect.addEventListener('mouseup', function() {
                // Small delay to allow selection to process
                setTimeout(() => {
                    if (this.value === 'specific' && this.previousValue === 'specific') {
                        // User clicked on specific when it was already selected

                        showSpecificDateCalendar();
                    }
                }, 100);
            });

            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    form.submit();
                });
            }

            // Auto-submit on search input with debounce
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    form.submit();
                }, 500); // 500ms delay
            });
        });

        // Function to toggle calendar for specific date selection
        function toggleSpecificDateCalendar() {
            const specificDateWrapper = document.getElementById('specific-date-wrapper');
            
            if (specificDateWrapper.style.display === 'none' || !specificDateWrapper.style.display) {
                // Show calendar
                showSpecificDateCalendar();
            } else {
                // Hide calendar
                specificDateWrapper.style.display = 'none';
            }
        }

        // Function to show calendar for specific date selection
        function showSpecificDateCalendar() {
            const specificDateWrapper = document.getElementById('specific-date-wrapper');
            
            // Show calendar wrapper
            specificDateWrapper.style.display = 'block';
            
            // Load events and initialize calendar
            loadEventsData().then(() => {
                initializeCustomCalendar();
                // Add small delay to ensure DOM is updated before positioning
                setTimeout(() => {
                    adjustCalendarPosition();
                }, 100);
            }).catch((error) => {
                console.warn('Failed to load events, initializing calendar anyway:', error);
                initializeCustomCalendar();
                setTimeout(() => {
                    adjustCalendarPosition();
                }, 100);
            });
        }

        // Unified Date Filter Functions

        // Helper function to format date consistently with export Word (d F Y format)
        function formatDateForDisplay(dateValue) {
            const dateObj = new Date(dateValue + 'T00:00:00'); // Add time to avoid timezone issues
            const day = dateObj.getDate();
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const month = monthNames[dateObj.getMonth()];
            const year = dateObj.getFullYear();
            return `${day} ${month} ${year}`;
        }
        
        function updateSpecificDate(dateValue) {
            const form = document.getElementById('events-filter-form');
            

            
            // Update the specific date button text
            const specificDateBtn = document.getElementById('specific-date-btn');
            
            if (dateValue && dateValue.trim() !== '') {
                const formattedDate = formatDateForDisplay(dateValue);
                specificDateBtn.title = formattedDate;
                specificDateBtn.classList.add('active');
                
                // Update hidden inputs
                document.getElementById('specific-date-hidden').value = dateValue;
                
                // Create URL with parameters
                const baseUrl = "{{ route('events.index') }}";
                const currentUrl = new URL(baseUrl, window.location.origin);
                
                // Get current form values (guard in case some controls are not present)
                const searchEl = document.querySelector('[name="search"]');
                const statusEl = document.querySelector('[name="status"]');
                const notificationEl = document.querySelector('[name="notification_status"]');
                const sortEl = document.querySelector('[name="sort"]');
                const sortFieldEl = document.querySelector('[name="sort_field"]');

                const searchValue = searchEl ? searchEl.value : '';
                const statusValue = statusEl ? statusEl.value : '';
                const notificationValue = notificationEl ? notificationEl.value : '';
                const sortValue = sortEl ? sortEl.value : '';
                const sortFieldValue = sortFieldEl ? sortFieldEl.value : '';
                
                // Clear existing parameters
                currentUrl.search = '';
                
                // Add parameters
                if (searchValue) currentUrl.searchParams.set('search', searchValue);
                if (statusValue) currentUrl.searchParams.set('status', statusValue);
                if (notificationValue) currentUrl.searchParams.set('notification_status', notificationValue);
                if (sortValue) currentUrl.searchParams.set('sort', sortValue);
                if (sortFieldValue) currentUrl.searchParams.set('sort_field', sortFieldValue);
                
                // Add specific date
                currentUrl.searchParams.set('specific_date', dateValue);
                
                // Debug: log values before redirect to help trace issues
                try {
                    console.log('[DEBUG] updateSpecificDate - dateValue:', dateValue);
                    console.log('[DEBUG] search:', searchValue, 'status:', statusValue, 'sort:', sortValue, 'sort_field:', sortFieldValue);
                    console.log('[DEBUG] Redirecting to:', currentUrl.toString());
                } catch (e) {
                    // Ignore logging errors in older browsers
                }

                // Redirect
                window.location.href = currentUrl.toString();
            } else {
                // Clear specific date filter
                specificDateBtn.title = 'Pilih Tanggal Spesifik';
                specificDateBtn.classList.remove('active');
                document.getElementById('specific-date-hidden').value = '';
                
                // Redirect to clean events index
                window.location.href = "{{ route('events.index') }}";
            }
        }
        
        // Load events data for calendar
        let eventsData = {};
        let currentCalendarDate = new Date();
        let selectedDate = null;
        
        // Fallback events data from server-side rendering
        const fallbackEventsData = @json($eventsForCalendar ?? []);

        
        // Function to process fallback events data
        function processFallbackEventsData() {

            eventsData = {};
            
            fallbackEventsData.forEach(event => {
                const startDate = event.startDate; // Already in Y-m-d format
                if (!eventsData[startDate]) {
                    eventsData[startDate] = [];
                }
                eventsData[startDate].push(event);
                
                // Also add to end date if different
                if (event.endDate && event.endDate !== event.startDate) {
                    const endDate = event.endDate;
                    if (!eventsData[endDate]) {
                        eventsData[endDate] = [];
                    }
                    eventsData[endDate].push(event);
                }
            });
            

            return eventsData;
        }
        
        // Function to load events from server
        async function loadEventsData() {
            try {

                
                const response = await fetch('/events-data', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                

                
                if (response.ok) {
                    const responseText = await response.text();

                    
                    try {
                        const events = JSON.parse(responseText);

                        
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
                        

                        
                        // Update calendar if it's visible
                        if (document.getElementById('specific-date-wrapper').style.display !== 'none') {
            renderCustomCalendar();
        }
        
        // Function to adjust calendar position to prevent cutoff
        function adjustCalendarPosition() {
            const calendar = document.getElementById('custom-calendar');
            if (!calendar || calendar.style.display === 'none') return;
            
            const rect = calendar.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            // Check if calendar is cut off on the right
            if (rect.right > viewportWidth) {
                const overflow = rect.right - viewportWidth + 20; // 20px margin
                calendar.style.right = `${overflow}px`;
                calendar.style.left = 'auto';
            }
            
            // Check if calendar is cut off on the bottom
            if (rect.bottom > viewportHeight) {
                const overflow = rect.bottom - viewportHeight + 20; // 20px margin
                calendar.style.top = `-${calendar.offsetHeight + overflow + 10}px`;
                calendar.style.marginTop = '0';
            }
            
            // Ensure calendar is not cut off on the left
            if (rect.left < 10) {
                calendar.style.left = '10px';
                calendar.style.right = 'auto';
            }
        }                        return eventsData;
                    } catch (parseError) {
                        // JSON parsing failed, use fallback data
                        
                        // Use fallback data

                        return processFallbackEventsData();
                    }
                } else if (response.status === 401) {
                    // Authentication failed, use fallback data
                    // Use fallback data instead of showing error

                    return processFallbackEventsData();
                } else {
                    console.warn('Could not load events data - HTTP', response.status);
                    const errorText = await response.text();
                    console.warn('Error response:', errorText);
                    
                    // Use fallback data

                    return processFallbackEventsData();
                }
            } catch (error) {
                // Network error, use fallback data
                
                // Use fallback data

                return processFallbackEventsData();
            }
        }
        
        function initializeCustomCalendar() {
            // Remove existing event listeners first to prevent duplicates
            const prevBtn = document.getElementById('prev-month');
            const nextBtn = document.getElementById('next-month');
            const todayBtn = document.getElementById('today-btn');
            const clearBtn = document.getElementById('clear-date');
            
            // Clone elements to remove all event listeners
            const newPrevBtn = prevBtn.cloneNode(true);
            const newNextBtn = nextBtn.cloneNode(true);
            const newTodayBtn = todayBtn.cloneNode(true);
            const newClearBtn = clearBtn.cloneNode(true);
            
            prevBtn.parentNode.replaceChild(newPrevBtn, prevBtn);
            nextBtn.parentNode.replaceChild(newNextBtn, nextBtn);
            todayBtn.parentNode.replaceChild(newTodayBtn, todayBtn);
            clearBtn.parentNode.replaceChild(newClearBtn, clearBtn);
            
            // Set up fresh event listeners
            document.getElementById('prev-month').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
                renderCustomCalendar();
            });
            
            document.getElementById('next-month').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
                renderCustomCalendar();
            });
            
            document.getElementById('today-btn').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const today = new Date();
                selectCalendarDate(today);
            });
            
            document.getElementById('clear-date').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                selectedDate = null;
                
                // Clear specific date by redirecting to events index without specific_date parameter
                window.location.href = "{{ route('events.index') }}";
            });
            
            // Initialize with current date or selected date
            const currentSelectedDate = document.getElementById('specific-date-hidden').value;
            if (currentSelectedDate) {
                // Append time to avoid timezone offset when parsing date-only strings
                selectedDate = new Date(currentSelectedDate + 'T00:00:00');
                currentCalendarDate = new Date(selectedDate);
            }
            
            // Position calendar properly after rendering
            renderCustomCalendar();
            adjustCalendarPosition();
        }
        
        function renderCustomCalendar() {
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            // Update month/year display
            const monthYearElement = document.getElementById('calendar-month-year');
            monthYearElement.textContent = `${monthNames[currentCalendarDate.getMonth()]} ${currentCalendarDate.getFullYear()}`;
            
            // Clear previous days
            const daysContainer = document.getElementById('calendar-days');
            daysContainer.innerHTML = '';
            
            // Get first day of month and number of days
            const firstDay = new Date(currentCalendarDate.getFullYear(), currentCalendarDate.getMonth(), 1);
            const lastDay = new Date(currentCalendarDate.getFullYear(), currentCalendarDate.getMonth() + 1, 0);
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
                if (date.getMonth() !== currentCalendarDate.getMonth()) {
                    dayElement.classList.add('other-month');
                }
                
                if (date.getTime() === today.getTime()) {
                    dayElement.classList.add('today');
                }
                
                if (selectedDate && date.getTime() === selectedDate.getTime()) {
                    dayElement.classList.add('selected');
                }
                
                // Check if date has events
                // Fix timezone issue: use local date formatting instead of UTC
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;
                const hasEvents = eventsData[dateStr] && eventsData[dateStr].length > 0;
                
                if (hasEvents) {
                    dayElement.classList.add('has-events');
                    dayElement.title = `${eventsData[dateStr].length} Agenda pada tanggal ini - Klik untuk filter`;
                }
                
                // Add click handler
                dayElement.addEventListener('click', () => {
                    selectCalendarDate(date);
                });
                
                daysContainer.appendChild(dayElement);
            }
            
            // Adjust position after rendering
            setTimeout(() => {
                adjustCalendarPosition();
            }, 50);
        }
        
        function selectCalendarDate(date) {
            selectedDate = new Date(date);
            // Fix timezone issue: use local date formatting instead of UTC
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const dateStr = `${year}-${month}-${day}`;
            

            
            // Update calendar display to show selected date
            renderCustomCalendar();
            
            // Keep the calendar widget visible to show selection feedback
            const specificDateWrapper = document.getElementById('specific-date-wrapper');
            if (specificDateWrapper) {
                // Add a visual indication that date is selected
                specificDateWrapper.classList.add('date-selected');
            }
            
            // Hide calendar after a short delay to allow user to see the selection
            setTimeout(() => {
                if (specificDateWrapper) {
                    specificDateWrapper.style.display = 'none';
                    specificDateWrapper.classList.remove('date-selected');
                }
                // Update form and submit after calendar is hidden
                updateSpecificDate(dateStr);
            }, 800); // 800ms delay to show selection feedback
        }
        
        function clearAllFilters() {
            // Redirect to events index without any parameters
            window.location.href = "{{ route('events.index') }}";
        }

        // Check if specific date is selected on load
        document.addEventListener('DOMContentLoaded', function() {

            
            const specificDate = document.getElementById('specific-date-hidden').value;
            const specificDateBtn = document.getElementById('specific-date-btn');
            const specificDateWrapper = document.getElementById('specific-date-wrapper');
            

            
            // Always load events data first
            loadEventsData().then(() => {
                
                if (specificDate && specificDate.trim() !== '') {
                    // Update specific date button tooltip to show selected date
                    const formattedDate = formatDateForDisplay(specificDate);
                    specificDateBtn.title = formattedDate;
                    specificDateBtn.classList.add('active');
                    
                    // Initialize calendar but keep it hidden initially
                    selectedDate = new Date(specificDate + 'T00:00:00');
                    currentCalendarDate = new Date(selectedDate);
                    
                    // Initialize calendar (ready for when user clicks)
                    initializeCustomCalendar();
                } else {
                    // No specific date selected, ensure button shows default tooltip
                    specificDateBtn.title = 'Pilih Tanggal Spesifik';
                    specificDateBtn.classList.remove('active');
                }
            }).catch((error) => {
                console.warn('Failed to load events on page load:', error);
                
                // Still handle specific date even if events data failed to load
                if (specificDate && specificDate.trim() !== '') {
                    selectedDate = new Date(specificDate + 'T00:00:00');
                    currentCalendarDate = new Date(selectedDate);
                }
            });
        });
    </script>

    <!-- Date Selection Modal -->
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">
                        <i class="fas fa-file-word me-2"></i>Ekspor Agenda ke Word
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="exportDateForm">
                        <div class="mb-3">
                            <label for="exportDate" class="form-label">Pilih Tanggal</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="exportDate" 
                                   value="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="exportCustomDate()">
                        <i class="fas fa-file-word me-1"></i>Ekspor Word
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDateModal() {
            const modal = new bootstrap.Modal(document.getElementById('dateModal'));
            modal.show();
        }

        function exportCustomDate() {
            const selectedDate = document.getElementById('exportDate').value;
            if (selectedDate) {
                const exportUrl = "{{ route('events.daily-export.word', ':date') }}".replace(':date', selectedDate);
                window.open(exportUrl, '_blank');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('dateModal'));
                modal.hide();
            } else {
                alert('Silakan pilih tanggal');
            }
        }

        function exportCurrentFilterDate() {
            // Get current date filter value
            const dateFilter = document.querySelector('[name="date_filter"]').value;
            const specificDate = document.querySelector('[name="specific_date"]').value;
            
            let exportDate = null;
            
            // Check if specific date is selected
            if (specificDate && specificDate.trim() !== '') {
                exportDate = specificDate;
            } else {
                // Handle dropdown filters
                const today = new Date();
                
                switch (dateFilter) {
                    case 'today':
                        exportDate = today.toISOString().split('T')[0];
                        break;
                    case 'tomorrow':
                        const tomorrow = new Date(today);
                        tomorrow.setDate(today.getDate() + 1);
                        exportDate = tomorrow.toISOString().split('T')[0];
                        break;
                    case 'upcoming':
                    case 'this_week':
                    case 'this_month':
                    case 'next_month':
                    case 'all_events':
                        // For non-specific date filters, show modal to let user choose
                        openDateModal();
                        return;
                    default:
                        // Default to today
                        exportDate = today.toISOString().split('T')[0];
                        break;
                }
            }
            
            if (exportDate) {
                const exportUrl = "{{ route('events.daily-export.word', ':date') }}".replace(':date', exportDate);
                window.open(exportUrl, '_blank');
            } else {
                // Fallback to modal if no specific date can be determined
                openDateModal();
            }
        }
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
            }

            function close(){
                if(!off) return;
                off.classList.remove('open');
                off.setAttribute('aria-hidden','true');
                document.documentElement.classList.remove('sidebar-open');
                const navbar = document.querySelector('.navbar');
                if(navbar) navbar.classList.remove('nav-hidden');
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

            // Restore persisted selection on page load
            // We persist only a simple state ('mine' or 'all') and do NOT replace the centerNav
            // innerHTML because that removed the "Semua Agenda" link. Instead we mark the
            // intended selection on the center container so the buttons/links can be styled
            // correctly when they are added later.
            document.addEventListener('DOMContentLoaded', function(){
                try{
                    const stored = localStorage.getItem(NAV_KEY);
                    const center = document.getElementById('centerNav');
                    if(stored && center){
                        // keep the stored value (string: 'mine'|'all') on the center element for later
                        center.dataset.selectedNav = stored;
                    }
                }catch(err){ console.error('restore selected nav failed', err); }
            });

            if(off){
                off.querySelectorAll('a[data-target]').forEach(a=>{
                    a.addEventListener('click', function(e){
                        const t = a.getAttribute('data-target');
                        const href = a.getAttribute('href') || '#';
                        try{
                            // Persist only whether user selected 'mine' or 'all'. Sidebar links map
                            // to the general 'all' selection so we store 'all'.
                            localStorage.setItem(NAV_KEY, 'all');
                        }catch(e){}
                        close();
                        // Do not replace center nav contents here; leave DOM intact and let
                        // page navigation/rendering determine correct active classes.
                    });
                });
            }

            // Ensure clicking center nav links (e.g. 'Semua Agenda') clears the 'mine' state
            // so the page does not remain stuck on 'Agenda Saya'.
            try {
                const center = document.getElementById('centerNav');
                if (center) {
                    center.querySelectorAll('a.nav-link').forEach(link => {
                        link.addEventListener('click', function (e) {
                            try { localStorage.setItem(NAV_KEY, 'all'); } catch (err) {}
                            // allow normal navigation to proceed
                        });
                    });
                }
            } catch (err) { /* ignore */ }

            // Close sidebar when clicking anywhere outside the sidebar (capturing)
            document.addEventListener('click', function(e){
                try{
                    if(!off) return;
                    if(!off.classList.contains('open')) return;
                    if(off.contains(e.target)) return;
                    if(brandToggle && brandToggle.contains(e.target)) return;
                    close();
                }catch(err){}
            }, true);
        })();
    </script>
    @auth
    <script>
        // Move the existing "Agenda Saya" button to the topbar (right of center nav)
        // and wire header title changes: when clicked, header becomes "Agenda {UserName}".
        document.addEventListener('DOMContentLoaded', function () {
            try {
                var mineBtn = document.getElementById('mine-toggle-btn');
                var centerNav = document.getElementById('centerNav');
                var pageTitleEl = document.querySelector('.combined-header .page-title');
                var defaultTitle = pageTitleEl ? pageTitleEl.textContent.trim() : document.title;
                var userName = {!! json_encode(Auth::user()->name ?? '') !!};

                if (mineBtn && centerNav) {
                    // Append after existing center nav items
                    centerNav.appendChild(mineBtn);
                    mineBtn.style.marginLeft = '8px';

                    // Helper: set center nav active state depending on whether 'mine' is active
                    function setCenterActive(isMine) {
                        try {
                            const links = centerNav.querySelectorAll('.nav-link');
                            links.forEach((l, idx) => l.classList.remove('active'));

                            if (isMine) {
                                // Mark the mine button as active and clear other active links
                                mineBtn.classList.add('mine-active');
                                mineBtn.classList.add('active');
                            } else {
                                // Restore default: first center nav link becomes active
                                if (links.length > 0) {
                                    links[0].classList.add('active');
                                }
                                mineBtn.classList.remove('mine-active');
                                mineBtn.classList.remove('active');
                            }
                        } catch (err) { /* ignore */ }
                    }

                    // When Agenda Saya clicked/toggled, update the header title accordingly
                    mineBtn.addEventListener('click', function (e) {
                        // If the button has a 'mine-active' class or is toggled via aria-pressed, use that to decide state
                        var isActive = mineBtn.classList.contains('mine-active') || mineBtn.getAttribute('aria-pressed') === 'true';

                        // Toggle visual state
                        var willBeActive = !isActive;
                        mineBtn.setAttribute('aria-pressed', willBeActive.toString());
                        setCenterActive(willBeActive);

                        if (willBeActive) {
                            // Now active — set header to Agenda {UserName}
                            if (pageTitleEl) pageTitleEl.textContent = 'Agenda ' + (userName || 'Saya');
                            // Persist simple state
                            try {
                                localStorage.setItem('siakra:selectedNav', 'mine');
                            } catch (err) {}
                        } else {
                            // Deactivated — restore default
                            if (pageTitleEl) pageTitleEl.textContent = defaultTitle;
                            try {
                                localStorage.setItem('siakra:selectedNav', 'all');
                            } catch (err) {}
                        }
                        // Note: the inline onclick on the button will still toggle the hidden 'mine' input
                        // and submit the filter form which reloads the page. Persisting above ensures
                        // the visual state is stored before reload.
                    });

                    // If persisted nav exists and indicates Agenda Saya, ensure header shows it
                    try {
                        var stored = (centerNav && centerNav.dataset && centerNav.dataset.selectedNav) || localStorage.getItem('siakra:selectedNav');
                        if (stored === 'mine') {
                            if (pageTitleEl) pageTitleEl.textContent = 'Agenda ' + (userName || 'Saya');
                            setCenterActive(true);
                        } else {
                            setCenterActive(false);
                        }
                    } catch (err) { /* ignore */ }
                }
            } catch (err) {
                console.error('Move Agenda Saya button failed', err);
            }
        });
    </script>
    @endauth
</body>
</html>