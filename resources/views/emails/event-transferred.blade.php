<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dokumen Agenda Diteruskan</title>
</head>
<body>
    <p>Yth. {{ $event->title ? '' : '' }}</p>

    <p>Dokumen untuk agenda <strong>{{ $event->title }}</strong> telah diteruskan kepada Anda oleh sistem.</p>

    @if(!empty($event->description))
        <p><strong>Ringkasan:</strong> {{ Str::limit($event->description, 200) }}</p>
    @endif

    <p>Silakan lihat detail agenda di: <a href="{{ url('/events/' . $event->id) }}">{{ url('/events/' . $event->id) }}</a></p>

    <p>File dokumen terlampir pada email ini (jika tersedia).</p>

    <p>Terima kasih.</p>
</body>
</html>
