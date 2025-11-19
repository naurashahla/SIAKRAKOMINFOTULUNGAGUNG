@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">Edit Penerima</div>
        <div class="card-body">
            <form method="POST" action="{{ route('pegawai.update', $pegawai) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $pegawai->nama) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $pegawai->email) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Bidang</label>
                    <div class="input-group">
                        <div class="dropdown" style="width:100%">
                            <input type="hidden" name="bidang" id="peg-bidang-hidden" value="{{ old('bidang', $pegawai->bidang) }}">
                            <button class="form-select dropdown-toggle text-start" type="button" id="pegBidangDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false" style="width:100%;">
                                {{ old('bidang', $pegawai->bidang ?? '-- Pilih Bidang --') ?: '-- Pilih Bidang --' }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="pegBidangDropdownBtn" id="pegBidangDropdownMenu" style="max-height:260px; overflow:auto;">
                                <li><button class="dropdown-item" type="button" data-value="">-- Pilih Bidang --</button></li>
                                @foreach($bidangOptions ?? [] as $b)
                                    <li><button class="dropdown-item" type="button" data-value="{{ $b }}">{{ $b }}</button></li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" id="manage-bidang-btn" title="Kelola Bidang" aria-label="Kelola Bidang"><i class="fas fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <div class="input-group">
                        <div class="dropdown" style="width:100%">
                            <input type="hidden" name="jabatan" id="peg-jabatan-hidden" value="{{ old('jabatan', $pegawai->jabatan) }}">
                            <button class="form-select dropdown-toggle text-start" type="button" id="pegJabatanDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false" style="width:100%;">
                                {{ old('jabatan', $pegawai->jabatan ?? '-- Pilih Jabatan --') ?: '-- Pilih Jabatan --' }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="pegJabatanDropdownBtn" id="pegJabatanDropdownMenu" style="max-height:260px; overflow:auto;">
                                <li><button class="dropdown-item" type="button" data-value="">-- Pilih Jabatan --</button></li>
                                @foreach($jabatanOptions ?? [] as $j)
                                    <li><button class="dropdown-item" type="button" data-value="{{ $j }}">{{ $j }}</button></li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" id="manage-jabatan-btn" title="Kelola Jabatan" aria-label="Kelola Jabatan"><i class="fas fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

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

@push('scripts')
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

        async function loadAndShow(type){
            currentType = type;
            document.getElementById('manageOptionsTitle').textContent = 'Kelola ' + (type === 'bidang' ? 'Bidang' : 'Jabatan');
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
                loadAndShow(type);
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

        // Initialize dropdown handlers for pegawai edit custom selects
        function initPegDropdown(btnId, menuId, hiddenId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const hidden = document.getElementById(hiddenId);
            if(!btn || !menu || !hidden) return;
            menu.querySelectorAll('.dropdown-item').forEach(function(item){
                item.addEventListener('click', function(){
                    const val = item.getAttribute('data-value') || '';
                    hidden.value = val;
                    btn.textContent = val || item.textContent || '-- Pilih --';
                    try{ const inst = bootstrap.Dropdown.getInstance(btn) || new bootstrap.Dropdown(btn); inst.hide(); }catch(err){}
                });
            });
            if(hidden.value && hidden.value.trim() !== '') btn.textContent = hidden.value;
        }

        initPegDropdown('pegBidangDropdownBtn','pegBidangDropdownMenu','peg-bidang-hidden');
        initPegDropdown('pegJabatanDropdownBtn','pegJabatanDropdownMenu','peg-jabatan-hidden');

    })();
</script>
@endpush
