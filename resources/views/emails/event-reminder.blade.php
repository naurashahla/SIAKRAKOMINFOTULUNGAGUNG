<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reminder - SIAKRA</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .reminder-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .countdown-section {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
            border: 2px solid #ff6b35;
        }
        .countdown-title {
            font-size: 18px;
            font-weight: 700;
            color: #e65100;
            margin-bottom: 10px;
        }
        .countdown-time {
            font-size: 32px;
            font-weight: 800;
            color: #ff6b35;
            margin: 10px 0;
        }
        .event-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
        }
        .event-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            align-items: center;
        }
        .detail-label {
            font-weight: 600;
            color: #5a6c7d;
            min-width: 120px;
            margin-right: 15px;
        }
        .detail-value {
            color: #2c3e50;
            flex: 1;
        }
        .urgent-notice {
            background-color: #ffebee;
            border: 1px solid #ff6b35;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .urgent-notice h3 {
            color: #ff6b35;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .urgent-notice p {
            color: #d32f2f;
            font-size: 14px;
            margin: 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            opacity: 0.8;
        }
        .divider {
            height: 2px;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            margin: 30px 0;
            border-radius: 1px;
        }
        .icon {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 25px 20px;
            }
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .detail-label {
                min-width: auto;
                margin-bottom: 5px;
            }
            .countdown-time {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>⏰ Reminder Event</h1>
            <p>Event Anda dimulai dalam 1 jam!</p>
        </div>
        
        <div class="content">
            <div class="reminder-badge">🚨 Reminder Alert</div>
            
            <p>Hello,</p>
            <p>This is a friendly reminder that your scheduled event in SIAKRA (Sistem Informasi Agenda Kerja & Rapat) is starting soon!</p>
            
            <div class="countdown-section">
                <div class="countdown-title">⏰ Event dimulai dalam</div>
                <div class="countdown-time">1 JAM</div>
                <p style="margin: 0; color: #e65100; font-weight: 600;">Bersiaplah sekarang!</p>
            </div>
            
            <div class="event-details">
                <div class="event-title">{{ $event->title }}</div>
                
                <div class="detail-row">
                    <span class="detail-label">📅 Tanggal:</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($event->startDate)->locale('id')->translatedFormat('l, d F Y') }}
                        @if($event->endDate && $event->startDate !== $event->endDate)
                            - {{ \Carbon\Carbon::parse($event->endDate)->locale('id')->translatedFormat('l, d F Y') }}
                        @endif
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">⏰ Waktu:</span>
                    <span class="detail-value">
                        @if($event->startTime)
                            {{ $event->startTime }} WIB
                        @else
                            Sepanjang Hari
                        @endif
                        -
                        @if($event->no_end_date)
                            Selesai
                        @elseif($event->endDate && $event->endTime)
                            {{ $event->endTime }} WIB
                        @else
                            Sepanjang Hari
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📍 Lokasi:</span>
                    <span class="detail-value">{{ $event->location ?: 'TBA' }}</span>
                </div>
                
                @if($event->description)
                <div class="detail-row">
                    <span class="detail-label">📝 Deskripsi:</span>
                    <span class="detail-value">{{ $event->description }}</span>
                </div>
                @endif

                @if($event->disposisi_dihadiri)
                <div class="detail-row">
                    <span class="detail-label">👥 Disposisi Dihadiri:</span>
                    <span class="detail-value">{{ $event->disposisi_dihadiri }}</span>
                </div>
                @endif
            </div>

            <div class="urgent-notice">
                <h3>📍 Preparation Checklist</h3>
                <p>• Check your schedule and clear any conflicts<br>
                • Prepare any necessary materials or documents<br>
                • Confirm the location and directions<br>
                • Set up any required technology or equipment</p>
            </div>
            
            <div class="divider"></div>
            
            <p>Please make sure you're prepared and ready to attend. If you have any questions or need to make changes, please contact the event organizer as soon as possible.</p>
            
            <a href="{{ url('/events') }}" class="cta-button">View Event Details</a>
            
            <p style="margin-top: 30px; color: #6c757d; font-size: 14px;">
                This is an automated reminder from SIAKRA system. You are receiving this because you were invited to this event.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>SIAKRA</strong></p>
            <p>Sistem Informasi Administrasi Kegiatan dan Rapat Organisasi</p>
            <p>© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>
</body>
</html>