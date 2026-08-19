@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold">Data Pendaftar Siswa Baru</h4>
            <p class="text-muted mb-0 small">Kelola seluruh data pendaftaran yang masuk dari halaman publik.</p>
        </div>
        <a href="{{ route('admin.pendaftaran.export', request()->only(['search', 'status'])) }}" class="btn btn-success">
            <i class="feather-download me-1"></i> Download Excel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Kartu Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
                <div><div class="text-muted small text-uppercase">Total</div><h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4></div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(13,110,253,.1)"><i class="feather-users" style="color:#0d6efd"></i></div>
            </div></div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
                <div><div class="text-muted small text-uppercase">Baru</div><h4 class="mb-0 fw-bold">{{ $stats['baru'] }}</h4></div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(255,193,7,.15)"><i class="feather-clock" style="color:#ffc107"></i></div>
            </div></div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
                <div><div class="text-muted small text-uppercase">Diterima</div><h4 class="mb-0 fw-bold text-success">{{ $stats['diterima'] }}</h4></div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(25,135,84,.1)"><i class="feather-check-circle" style="color:#198754"></i></div>
            </div></div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
                <div><div class="text-muted small text-uppercase">Ditolak</div><h4 class="mb-0 fw-bold text-danger">{{ $stats['ditolak'] }}</h4></div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(220,53,69,.1)"><i class="feather-x-circle" style="color:#dc3545"></i></div>
            </div></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4"><div class="card-body">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama, asal sekolah, email, no WA...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="feather-search me-1"></i> Filter</button>
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div></div>

    {{-- Tabel Data --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Pendaftar</th>
                        <th>Program Pilihan</th>
                        <th>Asal Sekolah</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pendaftar as $i => $p)
                    <tr>
                        <td class="ps-4">{{ $pendaftar->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $p->jenis_kelamin }} · Lulus {{ $p->tahun_lulus }}</div>
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $p->program }}</span></td>
                        <td class="small">{{ $p->asal_sekolah }}</td>
                        <td class="small">
                            <div><i class="feather-smartphone me-1"></i>{{ $p->no_whatsapp }}</div>
                            <div class="text-muted">{{ $p->email }}</div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.pendaftaran.update-status', $p->id) }}">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                    class="form-select form-select-sm w-auto
                                    {{ $p->status == 'Diterima' ? 'text-success fw-bold' : ($p->status == 'Ditolak' ? 'text-danger fw-bold' : '') }}">
                                    @foreach(['Baru', 'Diterima', 'Ditolak'] as $s)
                                        <option value="{{ $s }}" {{ $p->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="small text-muted">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        {{-- 👁️ Tombol Lihat Detail --}}
        <a href="{{ route('admin.pendaftaran.show', $p->id) }}"
           class="btn btn-sm btn-outline-primary d-inline-flex align-items-center justify-content-center"
           style="width: 32px; height: 32px; padding: 0;"
           title="Lihat Detail">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </a>

        {{-- 🗑️ Tombol Hapus --}}
        <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus data {{ $p->nama_lengkap }}?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px; padding: 0;"
                    title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </button>
        </form>
    </div>
</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada data pendaftar.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($pendaftar->hasPages())
            <div class="card-footer bg-white">{{ $pendaftar->links() }}</div>
        @endif
    </div>
</div>
@endsection