<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User - SIAKRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Edit User</h3>
            <a href="{{ request('return_to') ? request('return_to') : route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            @if(request('return_to'))
                <input type="hidden" name="return_to" value="{{ e(request('return_to')) }}" />
            @endif

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password (biarkan kosong jika tidak ingin mengganti)</label>
                <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control" autocomplete="new-password">
                    <button type="button" class="btn btn-outline-secondary btn-sm toggle-password" data-target="#password" aria-pressed="false" aria-label="Tampilkan password">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                    <button type="button" class="btn btn-outline-secondary btn-sm toggle-password" data-target="#password_confirmation" aria-pressed="false" aria-label="Tampilkan konfirmasi password">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <div class="input-group">
                    <select class="form-select" name="role" id="role-select" style="flex:1 1 auto; min-width:0;">
                        <option value="user" {{ (old('role', $user->role ?? 'user') == 'user') ? 'selected' : '' }}>User</option>
                        @if(Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin']))
                            <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                        @endif
                        @if(Auth::user() && Auth::user()->role === 'super_admin')
                            <option value="super_admin" {{ (old('role', $user->role ?? '') == 'super_admin') ? 'selected' : '' }}>Super Admin</option>
                        @endif
                    </select>
                </div>
                @if(Auth::id() === $user->id)
                @endif
            </div>
            <!-- Bidang & Jabatan selectors (populated from Pegawai options) -->
            <div class="mb-3">
                <label class="form-label">Bidang</label>
                <div class="input-group">
                    <select class="form-select" name="bidang" id="bidang-select" style="flex:1 1 auto; min-width:0;">
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($bidangOptions ?? [] as $b)
                            <option value="{{ $b }}" {{ (old('bidang', $user->bidang ?? '') == $b) ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="manage-bidang-btn" title="Kelola Bidang" aria-label="Kelola Bidang"><i class="fas fa-plus" aria-hidden="true"></i></button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <div class="input-group">
                    <select class="form-select" name="jabatan" id="jabatan-select" style="flex:1 1 auto; min-width:0;">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatanOptions ?? [] as $j)
                            <option value="{{ $j }}" {{ (old('jabatan', $user->jabatan ?? '') == $j) ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="manage-jabatan-btn" title="Kelola Jabatan" aria-label="Kelola Jabatan"><i class="fas fa-plus" aria-hidden="true"></i></button>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        </form>
    </div>
    
                <!-- Modal: Manage Options (Bidang / Jabatan) -->
                <div class="modal fade" id="manageOptionsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="manageOptionsTitle">Kelola</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="options-list" class="mb-3"></div>
                                <div class="input-group">
                                    <input type="text" id="new-option-value" class="form-control" placeholder="Nilai baru">
                                    <button id="add-option-btn" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function(){
        const manageModal = new bootstrap.Modal(document.getElementById('manageOptionsModal'));
        let currentType = null; // 'bidang' or 'jabatan'

        function renderOptionsList(items) {
            const container = document.getElementById('options-list');
            container.innerHTML = '';
            if(!items || !items.length) {
                container.innerHTML = '<div class="text-muted">Belum ada data</div>';
                return;
            }
            items.forEach(function(v){
                const row = document.createElement('div');
                row.className = 'd-flex align-items-center justify-content-between mb-2';
                const span = document.createElement('div'); span.textContent = v.value || v;
                const btn = document.createElement('button'); btn.className = 'btn btn-sm btn-outline-danger'; btn.textContent = 'Hapus';
                btn.addEventListener('click', function(){ deleteOption(v.id || v, currentType); });
                row.appendChild(span); row.appendChild(btn);
                container.appendChild(row);
            });
        }

        async function fetchOptions(type){
            const res = await fetch('/options-list?type=' + encodeURIComponent(type));
            if(!res.ok) return [];
            return res.json();
        }

        async function loadAndShow(type){
            currentType = type;
            document.getElementById('manageOptionsTitle').textContent = 'Kelola ' + (type === 'bidang' ? 'Bidang' : 'Jabatan');
            // fetch options via simple endpoint
            const resp = await fetch('/options-json?type=' + encodeURIComponent(type));
            if(!resp.ok) {
                renderOptionsList([]);
            } else {
                const data = await resp.json();
                renderOptionsList(data.options || []);
            }
            manageModal.show();
        }

        async function deleteOption(id, type){
            if(!confirm('Hapus opsi ini?')) return;
            const res = await fetch('/options/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            if(res.ok) {
                // refresh list
                loadAndShow(type);
                // also refresh selects on the page by reloading the window (simple)
                setTimeout(()=> location.reload(), 300);
            } else {
                alert('Gagal menghapus opsi');
            }
        }

        document.getElementById('manage-bidang-btn').addEventListener('click', function(){ loadAndShow('bidang'); });
        document.getElementById('manage-jabatan-btn').addEventListener('click', function(){ loadAndShow('jabatan'); });

        document.getElementById('add-option-btn').addEventListener('click', async function(){
            const val = document.getElementById('new-option-value').value.trim();
            if(!val) return alert('Masukkan nilai');
            const res = await fetch('/options', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: currentType, value: val }) });
            if(res.ok){
                document.getElementById('new-option-value').value='';
                loadAndShow(currentType);
                setTimeout(()=> location.reload(), 300);
            } else {
                alert('Gagal menambahkan opsi');
            }
        });

        // No custom dropdown initialization required anymore — using native <select>s

        // Initialize password visibility toggles (for edit form)
        function initPasswordToggles() {
            document.querySelectorAll('.toggle-password').forEach(function(btn){
                btn.addEventListener('click', function(e){
                    var targetSelector = this.getAttribute('data-target');
                    if (!targetSelector) return;
                    var input = document.querySelector(targetSelector);
                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        this.setAttribute('aria-pressed', 'true');
                        this.setAttribute('aria-label', 'Sembunyikan password');
                        this.innerHTML = '<i class="fas fa-eye" aria-hidden="true"></i>';
                    } else {
                        input.type = 'password';
                        this.setAttribute('aria-pressed', 'false');
                        this.setAttribute('aria-label', 'Tampilkan password');
                        this.innerHTML = '<i class="fas fa-eye-slash" aria-hidden="true"></i>';
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPasswordToggles);
        } else {
            initPasswordToggles();
        }

    })();
</script>
</html>
