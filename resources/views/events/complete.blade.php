<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selesaikan Agenda - {{ $event->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <a href="{{ route('events.show', $event) }}" class="btn btn-link">← Kembali ke detail agenda</a>
    <div class="card">
        <div class="card-header">
            <strong>Selesaikan Agenda: </strong> {{ $event->title }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('events.complete.submit', $event) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="notulen" class="form-label">Notulen (ringkasan hasil kegiatan)</label>
                    <textarea name="notulen" id="notulen" rows="8" class="form-control" required>{{ old('notulen') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="bukti_dukung" class="form-label">Bukti Dukung (docx, pdf, jpeg/jpg) — bisa upload beberapa file</label>
                    <input type="file" name="bukti_dukung[]" id="bukti_dukung" class="form-control" accept=".pdf,.docx,.jpeg,.jpg" multiple>
                    <div class="form-text">Maks 10MB per file. Gunakan beberapa file jika perlu.</div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('events.show', $event) }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Kirim & Selesaikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
