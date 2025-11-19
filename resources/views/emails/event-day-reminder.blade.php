<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reminder Event Besok Hari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .event-details {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #1976d2;
        }
        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; color: #1976d2;">Reminder Event Besok Hari</h2>
        <p style="margin: 5px 0 0 0;">Dinas Komunikasi dan Informatika</p>
    </div>

    <div class="content">
        <p>Yth. Bapak/Ibu,</p>
        
        <p>Dengan hormat, kami mengingatkan bahwa besok hari akan ada kegiatan/event yang memerlukan perhatian Anda:</p>

        <div class="event-details">
            <div class="detail-row">
                <span class="label">Nama Event:</span> {{ $event->title }}
            </div>
            
            <div class="detail-row">
                <span class="label">Tanggal:</span>
                {{ \Carbon\Carbon::parse($event->startDate)->locale('id')->translatedFormat('l, d F Y') }}
                @if($event->endDate && $event->startDate !== $event->endDate)
                    - {{ \Carbon\Carbon::parse($event->endDate)->locale('id')->translatedFormat('l, d F Y') }}
                @endif
            </div>
            
            <div class="detail-row">
                <span class="label">Waktu:</span>
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
            
            @if($event->location)
            <div class="detail-row">
                <span class="label">Lokasi:</span> {{ $event->location }}
            </div>
            @endif
            
            @if($event->description)
            <div class="detail-row">
                <span class="label">Deskripsi:</span> {{ $event->description }}
            </div>
            @endif
            
            @if($event->disposisi_dihadiri)
            <div class="detail-row">
                <span class="label">Disposisi Dihadiri:</span> {{ $event->disposisi_dihadiri }}
            </div>
            @endif
        </div>

        <p>Mohon untuk mempersiapkan diri dan mengatur jadwal Anda untuk menghadiri event tersebut.</p>
        
        <p>Anda akan menerima reminder tambahan 1 jam sebelum event dimulai.</p>

        <p>Terima kasih atas perhatian dan partisipasinya.</p>

        <p>Hormat kami,<br>
        <strong>Tim Event Management<br>
        Dinas Komunikasi dan Informatika</strong></p>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>Jika ada pertanyaan, silakan hubungi admin sistem.</p>
    </div>
</body>
</html>