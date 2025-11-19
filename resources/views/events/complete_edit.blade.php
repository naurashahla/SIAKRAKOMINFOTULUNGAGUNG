<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Notulen - {{ $event->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <a href="{{ route('events.show', $event) }}" class="btn btn-link">← Kembali ke detail agenda</a>
    <div class="card">
        <div class="card-header">
            <strong>Edit Notulen: </strong> {{ $event->title }}
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

            <form id="edit-completion-form" method="POST" action="{{ route('events.completions.update', ['event' => $event, 'completion' => $completion]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="notulen" class="form-label">Notulen (ringkasan hasil kegiatan)</label>
                    <textarea name="notulen" id="notulen" rows="8" class="form-control" required>{{ old('notulen', $completion->notulen) }}</textarea>
                </div>

                @if (!empty($files))
                    <div class="mb-3">
                        <label class="form-label">Berkas terlampir saat ini</label>
                        <div class="list-group" id="existing-files-list">
                            @foreach ($files as $f)
                                <div class="list-group-item d-flex justify-content-between align-items-center" data-file-path="{{ $f }}">
                                    <div>
                                        <a href="{{ asset('storage/' . $f) }}" target="_blank">{{ basename($f) }}</a>
                                        <div class="text-muted small">{{ $f }}</div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="previewFile('{{ $f }}')">Pratinjau</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" aria-label="Hapus berkas" onclick="markFileForRemoval('{{ $f }}', this)">×</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="bukti_dukung" class="form-label">Tambahkan Berkas Baru (docx, pdf, jpeg/jpg) — bisa upload beberapa file</label>
                    <input type="file" name="bukti_dukung[]" id="bukti_dukung" class="form-control" accept=".pdf,.docx,.jpeg,.jpg" multiple>
                    <div class="form-text">Maks 10MB per file. Gunakan beberapa file jika perlu.</div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('events.show', $event) }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

            <!-- Delete button removed per request -->
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div id="filePreviewHeader" class="modal-header" style="background: linear-gradient(90deg,#2b8cff,#1e6fe8); color: #fff;">
                <div>
                    <div class="d-flex align-items-center">
                        <div style="font-size:20px; margin-right:12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z"/>
                                <path d="M10 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold" id="filePreviewFilename">Pratinjau</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body p-0" id="filePreviewBody" style="min-height:60vh; background:#fff; display:flex; align-items:center; justify-content:center;">
                <!-- Content injected by JS -->
            </div>
            <div class="modal-footer" id="filePreviewFooter" style="justify-content:flex-end;">
                <div id="filePreviewActions">
                    <!-- Download button injected by JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Base URL to storage (no trailing slash)
    const storageBase = "{{ rtrim(asset('storage'), '/') }}";
    const csrfToken = "{{ csrf_token() }}";
    // App base and current event/completion ids used by preview/download/delete endpoints
    const baseUrl = "{{ url('/') }}";
    const eventIdForPreview = "{{ $event->id }}";
    const completionIdForPreview = "{{ $completion->id }}";

    function previewFile(path) {
        const ext = (path.split('.').pop() || '').toLowerCase();
        // Use controller preview endpoint so preview works even without public/storage symlink
        const previewUrl = baseUrl + '/events/' + encodeURIComponent(eventIdForPreview) + '/completions/' + encodeURIComponent(completionIdForPreview) + '/files/preview?path=' + encodeURIComponent(path);
        const url = previewUrl;

        const body = document.getElementById('filePreviewBody');
        const actions = document.getElementById('filePreviewActions');
        const filenameEl = document.getElementById('filePreviewFilename');

        // Reset
        body.innerHTML = '';
        actions.innerHTML = '';

        // Friendly filename
        let basename = path.split('/').pop() || path;
        try { basename = decodeURIComponent(basename); } catch (e) {}
        filenameEl.textContent = basename;

        // Download button (use controller download route)
        const base = '{{ url('/') }}';
        const eventId = '{{ $event->id }}';
        const completionId = '{{ $completion->id }}';
        const downloadUrl = base + '/events/' + encodeURIComponent(eventId) + '/completions/' + encodeURIComponent(completionId) + '/files/download?path=' + encodeURIComponent(path);
        const downloadBtn = document.createElement('a');
        downloadBtn.className = 'btn btn-primary';
        downloadBtn.href = downloadUrl;
        downloadBtn.target = '_blank';
        // add download icon to match other preview modal
        downloadBtn.innerHTML = '<i class="fas fa-download me-1"></i> Download';
        actions.appendChild(downloadBtn);

        if (['pdf'].includes(ext)) {
            const iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.style.width = '100%';
            iframe.style.height = 'calc(100vh - 220px)';
            iframe.frameBorder = 0;
            iframe.className = 'preview-iframe';
            body.appendChild(iframe);
        } else if (['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
            const imgWrap = document.createElement('div');
            imgWrap.style.width = '100%';
            imgWrap.style.display = 'flex';
            imgWrap.style.justifyContent = 'center';
            imgWrap.style.alignItems = 'center';
            imgWrap.style.padding = '12px';

            const img = document.createElement('img');
            img.src = url;
            img.style.maxWidth = '100%';
            img.style.maxHeight = 'calc(100vh - 220px)';
            img.style.height = 'auto';
            img.style.display = 'block';
            img.style.borderRadius = '6px';

            imgWrap.appendChild(img);
            body.appendChild(imgWrap);
        } else {
            // For other types open in a new tab so browser/download handles it
            window.open(url, '_blank');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
        modal.show();
    }

    async function markFileForRemoval(path, btn) {
        if (!confirm('Hapus berkas ini?')) return;

        const url = baseUrl + '/events/' + encodeURIComponent(eventIdForPreview) + '/completions/' + encodeURIComponent(completionIdForPreview) + '/files/delete';

        try {
            const resp = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ path: path })
            });

            const data = await resp.json();
            if (!resp.ok) {
                alert('Gagal menghapus berkas: ' + (data.error || resp.statusText));
                return;
            }

            // remove list item
            const item = btn.closest('.list-group-item');
            if (item) item.remove();
        } catch (e) {
            alert('Gagal menghapus berkas: ' + e.message);
        }
    }
</script>
</body>
</html>
