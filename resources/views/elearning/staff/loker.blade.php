@extends('layouts.elearning')
@section('title', 'Kelola Loker')
@section('content')

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-briefcase-4-line text-primary"></i> Kelola Lowongan Kerja</h4>
        <p class="text-muted small mb-0">Loker yang Anda input otomatis tampil di halaman Job Career website</p>
    </div>
</div>

<div class="row g-4">
    {{-- FORM INPUT LOKER --}}
    <div class="col-lg-4">
        <div class="el-card card p-4">
            <h6 class="fw-bold mb-3"><i class="ri-add-circle-line text-success me-1"></i> Publikasikan Loker Baru</h6>
            <form method="POST" action="{{ route('elearning.staff.loker.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="form-label small fw-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control form-control-sm" placeholder="Contoh: Grand Aston Hotel" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Website Perusahaan (opsional)</label>
                    <input type="url" name="company_website" class="form-control form-control-sm" placeholder="https://...">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Foto/Logo Perusahaan (opsional)</label>
                    <input type="file" name="company_photo" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Posisi <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control form-control-sm" placeholder="Contoh: Front Office Staff" required>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Tipe Kerja</label>
                        <select name="employment_type" class="form-select form-select-sm">
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Magang">Magang</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Lokasi</label>
                        <input type="text" name="location" class="form-control form-control-sm" placeholder="Subang">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Deskripsi (opsional)</label>
                    <textarea name="description" rows="3" class="form-control form-control-sm" placeholder="Kualifikasi & tanggung jawab singkat..."></textarea>
                </div>
                <button class="btn btn-sm btn-success fw-bold w-100"><i class="ri-send-plane-line me-1"></i> Publikasikan Loker</button>
            </form>
        </div>
    </div>

    {{-- DAFTAR LOKER --}}
    <div class="col-lg-8">
        <div class="el-card card p-4">
            <h6 class="fw-bold mb-3"><i class="ri-list-check-2 text-primary me-1"></i> Daftar Loker ({{ $postings->count() }})</h6>
            <div class="table-responsive">
                <table class="table align-middle small mb-0">
                    <thead class="table-light">
                        <tr><th>Perusahaan</th><th>Posisi</th><th>Status</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($postings as $p)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($p->company_photo)
                                        <img src="{{ asset('storage/' . $p->company_photo) }}" class="rounded" style="width:42px;height:42px;object-fit:cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded" style="width:42px;height:42px;background:#EEF2FF;color:#1F57ED;"><i class="ri-building-2-line"></i></div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $p->company_name }}</div>
                                        @if($p->company_website)
                                            <a href="{{ $p->company_website }}" target="_blank" class="small text-primary">{{ \Illuminate\Support\Str::limit(parse_url($p->company_website, PHP_URL_HOST) ?? 'Website', 25) }}</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $p->position }}</div>
                                <small class="text-muted">{{ $p->employment_type ?? '-' }} • {{ $p->location ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $p->isOpen() ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ $p->isOpen() ? '● DIBUKA' : '○ DITUTUP' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <form method="POST" action="{{ route('elearning.staff.loker.toggle', $p->id) }}">
                                        @csrf
                                        <button class="btn btn-sm {{ $p->isOpen() ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="Ganti status">
                                            <i class="ri-toggle-box-line"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('elearning.staff.loker.destroy', $p->id) }}"
                                          onsubmit="return confirm('Hapus loker {{ $p->position }} di {{ $p->company_name }}?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada loker dipublikasikan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection