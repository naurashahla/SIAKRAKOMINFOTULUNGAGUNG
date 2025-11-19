<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Updated - SIAKRA</title>
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
            background: linear-gradient(135deg, #1a5490 0%, #2563eb 100%);
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
        .event-badge {
            display: inline-block;
            background: linear-gradient(135deg, #1a5490 0%, #2563eb 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
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
            color: #1a5490;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            align-items: center;
        }
        .detail-label {
            font-weight: 600;
            color: #374151;
            min-width: 120px;
            margin-right: 15px;
        }
        .detail-value {
            color: #6b7280;
            flex: 1;
        }
        .changes-section {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }
        .changes-title {
            font-size: 16px;
            font-weight: 600;
            color: #856404;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .changes-list {
            margin: 0;
            padding-left: 20px;
        }
        .changes-list li {
            margin-bottom: 8px;
            color: #856404;
        }
        .cta-section {
            text-align: center;
            margin: 40px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a5490 0%, #2563eb 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            color: white;
        }
        .footer {
            background-color: #f8f9fa;
            color: white;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            opacity: 0.8;
            color: #6b7280;
        }
        .divider {
            height: 2px;
            background: linear-gradient(135deg, #1a5490 0%, #2563eb 100%);
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
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📝 Event Updated</h1>
            <p>An event has been successfully updated in SIAKRA</p>
        </div>
        
        <div class="content">
            <div class="event-badge">Event Update Notification</div>
            
            <p>Hello,</p>
            <p>An event has been updated in the SIAKRA (Sistem Informasi Agenda Kerja & Rapat) system. Here are the updated details:</p>
            
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
                
                @if($event->location)
                <div class="detail-row">
                    <span class="detail-label">📍 Lokasi:</span>
                    <span class="detail-value">{{ $event->location }}</span>
                </div>
                @endif
                
                @if($event->recipients && $event->recipients->count() > 0)
                <div class="detail-row">
                    <span class="detail-label">👥 Participants:</span>
                    <span class="detail-value">{{ $event->recipients->count() }} orang</span>
                </div>
                @endif

                @if($event->description)
                <div class="detail-row">
                    <span class="detail-label">📝 Deskripsi:</span>
                    <span class="detail-value">{{ $event->description }}</span>
                </div>
                @endif
            </div>

            @if(!empty($changes))
            <div class="changes-section">
                <div class="changes-title">
                    🔄 What Changed:
                </div>
                <ul class="changes-list">
                    @foreach($changes as $field => $change)
                        <li><strong>{{ ucfirst($field) }}:</strong> Changed from "{{ $change['from'] }}" to "{{ $change['to'] }}"</li>

                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <p>Please make note of these updates and adjust your schedule accordingly if needed.</p>
            <div class="cta-section">
                <a href="{{ url('/events') }}" class="cta-button">View All Events</a>
            </div>

            <p style="margin-top: 30px; color: #6c757d; font-size: 14px;">
                This is an automated notification from SIAKRA system. If you have any questions, please contact the event organizer.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>SIAKRA</strong></p>
            <p>Sistem Informasi Agenda Kerja & Rapat</p>
            <p>© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>
</body>
</html>