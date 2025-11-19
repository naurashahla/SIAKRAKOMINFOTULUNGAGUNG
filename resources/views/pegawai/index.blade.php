@extends('layouts.app')

@section('page_title', 'Manajemen Penerima')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0" style="font-size:22px; font-weight:700;">Daftar Penerima</h4>
            <div class="d-flex gap-2 align-items-center">
                <form method="GET" action="{{ route('pegawai.index') }}" class="d-flex">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama atau email" style="min-width:260px; font-size:13px;" />
                    <select name="bidang" class="form-select form-select-sm ms-2" style="font-size:13px;" onchange="this.form.submit()">
                        <option value="">Semua Bidang</option>
                        @foreach($bidangOptions ?? [] as $b)
                            <option value="{{ $b }}" @if(request('bidang')===$b) selected @endif>{{ $b }}</option>
                        @endforeach
                    </select>
                    {{-- Filter button removed - bidang selection auto-submits the form --}}
                </form>
                <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm" style="font-size:13px;"><i class="fas fa-plus me-1"></i> Tambah</a>
                <a href="{{ route('pegawai.export') }}?{{ http_build_query(request()->only(['q','bidang'])) }}" class="btn btn-outline-success btn-sm" style="font-size:13px;">Export CSV</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <strong style="font-size:16px;">Manajemen Penerima</strong>
                    <div class="text-muted" style="font-size:13px;">Menampilkan semua pegawai</div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="font-size:14px;">Nama</th>
                                <th style="font-size:14px;">Email</th>
                                <th style="font-size:14px;">Bidang</th>
                                <th style="font-size:14px;">Jabatan</th>
                                <th class="text-end pe-4" style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pegawai as $p)
                            <tr>
                                <td class="ps-4" style="font-size:14px; font-weight:600;">{{ $p->nama }}</td>
                                <td style="font-size:13px; color:#4b5563;">{{ $p->email }}</td>
                                <td style="font-size:13px;">{{ $p->bidang }}</td>
                                <td style="font-size:13px;">{{ $p->jabatan }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('pegawai.edit', $p->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:6px;"><i class="fas fa-edit" style="font-size:14px"></i></a>
                                    <form method="POST" action="{{ route('pegawai.destroy', $p->id) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerima ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:6px;"><i class="fas fa-trash" style="font-size:14px"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada penerima.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex align-items-center justify-content-between px-4">
                <div style="font-size:13px; color:#6b7280;">
                    Menampilkan {{ $pegawai->firstItem() ?? 0 }} - {{ $pegawai->lastItem() ?? 0 }} dari {{ $pegawai->total() ?? 0 }}
                </div>
                <div class="pe-3">
                    {{-- Use bootstrap-5 pagination and preserve query params --}}
                    {!! $pegawai->appends(request()->only(['q','bidang']))->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Make user icon sit closer to the username in the navbar for Manajemen Penerima (match dashboard) */
    .user-dropdown i, .user-dropdown .fa-user-circle { margin-right: 6px !important; font-size: 18px !important; }
    .navbar .user-dropdown { gap: 6px !important; }
</style>
@endpush
