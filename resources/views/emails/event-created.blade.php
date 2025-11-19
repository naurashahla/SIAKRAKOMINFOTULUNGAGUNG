<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Created - {{ $event->title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #1a5490 0%, #2563eb 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .header p {
            margin: 8px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a5490;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .event-details {
            background-color: #f8f9fa;
            border-left: 4px solid #1a5490;
            padding: 25px;
            border-radius: 6px;
            margin: 30px 0;
        }
        
        .event-title {
            font-size: 22px;
            font-weight: bold;
            color: #1a5490;
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }
        
        .detail-label {
            font-weight: bold;
            color: #374151;
            min-width: 120px;
            margin-right: 15px;
        }
        
        .detail-value {
            color: #6b7280;
            flex: 1;
        }
        
        .description-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .description-title {
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
        }
        
        .description-content {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            line-height: 1.7;
        }
        
        .cta-section {
            text-align: center;
            margin: 40px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #153a67 0%, #1a3ec8 100%);
            color: #ffffffff !important;
            border: 1px solid  #153a67;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s ease, background-color 0.15s ease, color 0.15s ease;
        }

        /* On hover/focus/active make the button blue with white text */
        .cta-button:hover,
        .cta-button:focus,
        .cta-button:active {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #153a67 0%, #1a3ec8 100%);
            color: #ffd700 !important; /* gold text on hover/active */
            border-color: #153a67;
            outline: none;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6b7280;
        }
        
        .footer .brand {
            font-weight: bold;
            color: #1a5490;
            font-size: 16px;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            
            .event-details {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                min-width: auto;
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>SIAKRA</h1>
            <p>Sistem Informasi Agenda Kerja & Rapat</p>
        </div>
        
        <div class="content">
            <div class="greeting">Halo! 👋</div>
            
            <div class="message">
                Event baru telah berhasil dibuat dalam SIAKRA. Berikut adalah detail lengkap dari event yang baru saja dibuat:
            </div>
            
            <div class="event-details">
                <div class="event-title">{{ $event->title }}</div>
                
                <div class="detail-row">
                    <div class="detail-label">Tanggal:</div>
                    <div class="detail-value">
                        @php
                            $start = \Carbon\Carbon::parse($event->startDate)->locale('id');
                        @endphp

                        @if($event->endDate)
                            @php $end = \Carbon\Carbon::parse($event->endDate)->locale('id'); @endphp
                            @if(! $start->isSameDay($end))
                                {{ $start->translatedFormat('l, d F Y') }} - {{ $end->translatedFormat('l, d F Y') }}
                            @else
                                {{ $start->translatedFormat('l, d F Y') }}
                            @endif
                        @else
                            {{ $start->translatedFormat('l, d F Y') }}
                        @endif
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Waktu:</div>
                    <div class="detail-value">
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
                    </div>
                </div>
                
                @if($event->location)
                <div class="detail-row">
                    <div class="detail-label">Lokasi:</div>
                    <div class="detail-value">{{ $event->location }}</div>
                </div>
                @endif
                
                @if($event->recipients->count() > 0)
                <div class="detail-row">
                    <div class="detail-label">Recipients:</div>
                    <div class="detail-value">{{ $event->recipients->count() }} orang</div>
                </div>
                @endif
                
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value">
                        @php
                            $today = \Carbon\Carbon::now();
                            $startDate = \Carbon\Carbon::parse($event->startDate);
                            
                            if ($startDate->isFuture()) {
                                echo 'Akan Datang';
                            } else {
                                echo 'Sedang Berlangsung';
                            }
                        @endphp
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Dibuat pada:</div>
                    <div class="detail-value">{{ $event->created_at->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</div>
                </div>
                
                @if($event->description)
                <div class="description-section">
                    <div class="description-title">Deskripsi Event:</div>
                    <div class="description-content">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
                @endif
            </div>
            
            <div class="cta-section">
                <a href="{{ route('events.index') }}" class="cta-button">
                    Lihat Semua Event
                </a>
            </div>
            
            <div class="message">
                <strong>Catatan Penting:</strong><br>
                • Pastikan untuk menyimpan informasi ini untuk referensi Anda<br>
                • Jika ada perubahan, Anda akan menerima notifikasi email terpisah<br>
                • Untuk pertanyaan lebih lanjut, silakan hubungi administrator sistem
            </div>
        </div>
        
        <div class="footer">
            <p class="brand">SIAKRA</p>
            <p>Sistem Informasi Agenda Kerja & Rapat</p>
            <p>Email ini dikirim secara otomatis pada {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</p>
            <p style="margin-top: 15px; font-size: 12px;">
                &copy; {{ date('Y') }} SIAKRA. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>