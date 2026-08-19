@extends('layouts.elearning')
@section('title', 'Berkas Mahasiswa')
@section('content')

@php
    $menunggu = $documents->where('status', 'Menunggu')->count();
    $verif    = $documents->where('status', 'Diverifikasi')->count();
    $tolak    = $documents->where('status', 'Ditolak')->count();
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-folder-zip-line text-primary"></i> Berkas Mahasiswa</h4>
        <p class="text-muted small mb-0">Berkas yang dikirim mahasiswa otomatis masuk ke sini</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-folder-line"></i></div>
        <div><div class="text-muted small">Total Berkas</div><div class="fw-bold fs-5">{{ $documents->count() }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-time-line"></i></div>
        <div><div class="text-muted small">Menunggu</div><div class="fw-bold fs-5">{{ $menunggu }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-checkbox-circle-line"></i></div>
        <div><div class="text-muted small">Diverifikasi</div><div class="fw-bold fs-5">{{ $verif }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-close-circle-line"></i></div>
        <div><div class="text-muted small">Ditolak</div><div class="fw-bold fs-5">{{ $tolak }}</div></div>
    </div></div></div>
</div>

<div class="el-card card p-4">
    <div class="table-responsive">
        <table class="table align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mahasiswa</th>
                    <th>Berkas</th>
                    <th>Dikirim</th>
                    <th>Status</th>
                    <th style="min-width:260px;">Review & Feedback</th>
                    <th style="width:80px;" class="text-center">Aksi</th> {{-- ✅ BARU --}}
                </tr>
            </thead>
            <tbody>
            @forelse($documents as $d)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $d->student->name ?? '-' }}</div>
                        <small class="text-muted">{{ $d->student->nomor_induk ?? '' }}</small>
                    </td>
                    <td>
                        <div class="fw-bold">{{ $d->title }}</div>
                        <small class="text-muted">{{ $d->category ?? 'Lainnya' }}</small><br>
                        <a href="{{ $d->drive_link }}" target="_blank" class="small fw-bold text-primary"><i class="ri-google-drive-line me-1"></i>Buka Drive</a>
                    </td>
                    <td>{{ $d->submitted_at?->format('d M Y, H:i') ?? '-' }}</td>
                    <td>
                        @if($d->status === 'Diverifikasi')
                            <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                        @elseif($d->status === 'Ditolak')
                            <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('elearning.staff.berkas.review', $d->id) }}" class="d-flex flex-column gap-1">
                            @csrf
                            <div class="d-flex gap-1">
                                <select name="status" class="form-select form-select-sm">
                                    <option value="Menunggu" {{ $d->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diverifikasi" {{ $d->status === 'Diverifikasi' ? 'selected' : '' }}>✅ Diverifikasi</option>
                                    <option value="Ditolak" {{ $d->status === 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                </select>
                                <button class="btn btn-sm btn-primary text-nowrap"><i class="ri-save-line me-1"></i>Simpan</button>
                            </div>
                            <input type="text" name="feedback" class="form-control form-control-sm" placeholder="Feedback untuk mahasiswa (opsional)" value="{{ $d->feedback }}">
                        </form>
                    </td>

                    {{-- ✅ BARU: KOLOM AKSI HAPUS --}}
                    <td class="text-center">
                        <form method="POST" action="{{ route('elearning.staff.berkas.destroy', $d->id) }}"
                              onsubmit="return confirm('Hapus berkas &quot;{{ $d->title }}&quot; milik {{ $d->student->name ?? 'Unknown' }}?\n\nBerkas akan dihapus PERMANEN dan mahasiswa harus kirim ulang jika diperlukan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus berkas">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="ri-folder-open-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                        Belum ada berkas masuk dari mahasiswa.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection