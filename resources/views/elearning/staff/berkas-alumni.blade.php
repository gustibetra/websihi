@extends('layouts.elearning')
@section('title', 'Ruang Berkas Alumni')
@section('content')

@php
    $baru     = $applications->where('status', 'Baru')->count();
    $diproses = $applications->where('status', 'Diproses')->count();
    $diterima = $applications->where('status', 'Diterima')->count();
    $ditolak  = $applications->where('status', 'Ditolak')->count();
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-briefcase-4-line text-primary"></i> Ruang Berkas Alumni</h4>
        <p class="text-muted small mb-0">Lamaran dari form Talent Pool website otomatis masuk ke sini</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-inbox-archive-line"></i></div>
        <div><div class="text-muted small">Total Lamaran</div><div class="fw-bold fs-5">{{ $applications->count() }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-sparkling-line"></i></div>
        <div><div class="text-muted small">Baru</div><div class="fw-bold fs-5">{{ $baru }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-loader-4-line"></i></div>
        <div><div class="text-muted small">Diproses</div><div class="fw-bold fs-5">{{ $diproses }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-user-follow-line"></i></div>
        <div><div class="text-muted small">Diterima</div><div class="fw-bold fs-5">{{ $diterima }}</div></div>
    </div></div></div>
</div>

<div class="el-card card p-4">
    <div class="table-responsive">
        <table class="table align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th>Pelamar</th>
                    <th>Posisi Dilamar</th>
                    <th>Kontak</th>
                    <th>Berkas</th>
                    <th>Tanggal</th>
                    <th style="min-width:200px;">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($applications as $a)
                <tr>
                    {{-- PELAMAR --}}
                    <td>
                        <div class="fw-bold">{{ $a->name }}</div>
                        <small class="text-muted">{{ $a->email }}</small>
                        @if($a->intro)<div class="text-muted fst-italic mt-1">"{{ \Illuminate\Support\Str::limit($a->intro, 80) }}"</div>@endif
                    </td>

                    {{-- ✅ POSISI + INFO PERUSAHAAN (jika dari lowongan spesifik) --}}
                    <td>
                        <span class="badge bg-primary-subtle text-primary mb-1">{{ $a->position }}</span>
                        @if($a->posting)
                            <div class="d-flex align-items-center gap-1 mt-1">
                                @if($a->posting->company_photo)
                                    <img src="{{ asset('storage/' . $a->posting->company_photo) }}" class="rounded" style="width:20px;height:20px;object-fit:cover;">
                                @endif
                                <small class="text-muted text-truncate" style="max-width:140px;">
                                    {{ $a->posting->company_name }}
                                </small>
                            </div>
                        @else
                            <small class="text-muted fst-italic"><i class="ri-user-star-line me-1"></i>Talent Pool (Umum)</small>
                        @endif
                    </td>

                    {{-- ✅ KONTAK (WhatsApp otomatis terformat) --}}
                    <td>
                        <a href="{{ $a->whatsapp_link }}" target="_blank" class="small fw-bold text-success text-decoration-none">
                            <i class="ri-whatsapp-line me-1"></i>{{ $a->whatsapp }}
                        </a>
                        <div class="text-muted small mt-1">
                            <i class="ri-mail-line me-1"></i>{{ $a->email }}
                        </div>
                    </td>

                    {{-- ✅ BERKAS (prioritas: Drive > CV file > kosong) --}}
                    <td>
                        @if($a->hasDriveLink())
                            <a href="{{ $a->drive_link }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="ri-google-drive-line me-1"></i> Buka Drive
                            </a>
                            <small class="d-block text-muted mt-1">Google Drive</small>
                        @elseif($a->hasCvFile())
                            <a href="{{ asset('storage/' . $a->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="ri-download-2-line me-1"></i> Download CV
                            </a>
                            <small class="d-block text-muted mt-1">File Upload</small>
                        @else
                            <span class="text-muted small">— Tidak ada —</span>
                        @endif
                    </td>

                    {{-- TANGGAL --}}
                    <td>
                        <div class="fw-bold small">{{ $a->created_at->format('d M Y') }}</div>
                        <small class="text-muted">{{ $a->created_at->format('H:i') }}</small>
                    </td>

                    {{-- ✅ STATUS dengan badge warna otomatis --}}
                    <td>
                        <form method="POST" action="{{ route('elearning.staff.berkas.alumni.review', $a->id) }}">
                            @csrf
                            <div class="d-flex gap-1">
                                <select name="status" class="form-select form-select-sm">
                                    @foreach(['Baru', 'Diproses', 'Diterima', 'Ditolak'] as $s)
                                        <option value="{{ $s }}" {{ $a->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary"><i class="ri-save-line"></i></button>
                            </div>
                        </form>
                        <div class="mt-2">
                            <span class="badge {{ $a->status_badge_class }}">{{ $a->status }}</span>
                        </div>
                    </td>

                    {{-- AKSI HAPUS (dengan konfirmasi aman) --}}
                    <td class="text-center">
                        <form method="POST" action="{{ route('elearning.staff.berkas.alumni.destroy', $a->id) }}"
                              onsubmit="return confirm('Hapus lamaran dari {{ addslashes($a->name) }}?\nLamaran ini akan dihapus permanen.');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus lamaran">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="ri-inbox-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                        Belum ada lamaran masuk dari website.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection