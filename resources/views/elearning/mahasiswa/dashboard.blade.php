@extends('layouts.elearning')
@section('title', 'Dashboard Mahasiswa')
@section('content')

<style>
    .mhs-hero{background:linear-gradient(135deg,#13294B 0%,#1F57ED 55%,#7A5CF0 100%);border-radius:20px;color:#fff;padding:30px 34px;position:relative;overflow:hidden;margin-bottom:24px;}
    .mhs-hero::before,.mhs-hero::after{content:'';position:absolute;border-radius:50%;pointer-events:none;}
    .mhs-hero::before{width:300px;height:300px;background:rgba(255,255,255,.07);top:-110px;right:-80px;}
    .mhs-hero::after{width:180px;height:180px;background:rgba(6,214,160,.18);bottom:-70px;left:22%;}
    .mhs-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);border-radius:50px;padding:6px 14px;font-size:12px;font-weight:600;}
    .mhs-stat{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.05);position:relative;overflow:hidden;}
    .mhs-stat .bar{position:absolute;left:0;top:0;bottom:0;width:5px;}
    .mhs-stat .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .mhs-room{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);transition:.3s;text-decoration:none;display:block;}
    .mhs-room:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(0,0,0,.12);}
    .mhs-room .room-ic{width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:14px;}
    .mhs-table th{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:#6B7280;border-bottom:2px solid #EEF2FF;}
    .mhs-table td{vertical-align:middle;font-size:13px;}
</style>

@php $user = auth('elearning')->user(); @endphp

{{-- HERO --}}
<div class="mhs-hero">
    <div class="position-relative" style="z-index:2;">
        <span class="mhs-chip mb-3"><i class="ri-graduation-cap-fill"></i> Portal Mahasiswa</span>
        <h3 class="fw-bold mb-2" style="letter-spacing:-.5px;">Halo, {{ $user->name }}! 👋</h3>
        <p class="mb-3" style="opacity:.85;font-size:14px;max-width:560px;">Selamat datang di ruang belajar digital Anda. Pantau kehadiran, unduh materi, serta kerjakan ujian & tugas — semua dalam satu portal.</p>
        <div class="d-flex gap-2 flex-wrap">
            <span class="mhs-chip"><i class="ri-id-card-line"></i> {{ $user->nomor_induk ?? '-' }}</span>
            <span class="mhs-chip"><i class="ri-hotel-bed-line"></i> Program {{ $user->program ?? '-' }}</span>
            <span class="mhs-chip"><i class="ri-calendar-2-line"></i> {{ now()->format('l, d F Y') }}</span>
        </div>
    </div>
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="mhs-stat card p-3"><div class="bar" style="background:#1F57ED;"></div>
        <div class="d-flex align-items-center gap-3">
            <div class="ic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-fingerprint-2-line"></i></div>
            <div><div class="text-muted small">Absen Hari Ini</div>
                <div class="fw-bold {{ $absenHariIni ? ($absenHariIni->status==='Hadir'?'text-success':'text-warning') : 'text-muted' }}">
                    {{ $absenHariIni ? $absenHariIni->status . ' (' . $absenHariIni->check_in . ')' : ($absenOpen ? 'Belum absen' : 'Belum dibuka') }}
                </div></div>
        </div></div></div>
    <div class="col-md-3 col-6"><div class="mhs-stat card p-3"><div class="bar" style="background:#059669;"></div>
        <div class="d-flex align-items-center gap-3">
            <div class="ic" style="background:#ECFDF5;color:#059669;"><i class="ri-book-open-line"></i></div>
            <div><div class="text-muted small">Kelas Tersedia</div><div class="fw-bold fs-5">{{ $kelasCount }}</div></div>
        </div></div></div>
    <div class="col-md-3 col-6"><div class="mhs-stat card p-3"><div class="bar" style="background:#7A5CF0;"></div>
        <div class="d-flex align-items-center gap-3">
            <div class="ic" style="background:#F5F3FF;color:#7A5CF0;"><i class="ri-folder-download-line"></i></div>
            <div><div class="text-muted small">Materi</div><div class="fw-bold fs-5">{{ $materiCount }}</div></div>
        </div></div></div>
    <div class="col-md-3 col-6"><div class="mhs-stat card p-3"><div class="bar" style="background:#DC2626;"></div>
        <div class="d-flex align-items-center gap-3">
            <div class="ic" style="background:#FEF2F2;color:#DC2626;"><i class="ri-error-warning-line"></i></div>
            <div><div class="text-muted small">Tunggakan</div><div class="fw-bold fs-5 {{ $tunggakan > 0 ? 'text-danger' : 'text-success' }}">{{ $tunggakan }} tagihan</div></div>
        </div></div></div>
</div>

{{-- RUANGAN SAYA --}}
<h6 class="fw-bold mb-3"><i class="ri-door-open-line text-primary me-1"></i> Ruangan Saya</h6>
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <a href="{{ route('elearning.mahasiswa.absen') }}" class="mhs-room card p-4 h-100">
            <div class="room-ic" style="background:#ECFDF5;color:#059669;"><i class="ri-fingerprint-2-line"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Ruang Absensi</h6>
            <p class="small text-muted mb-2">Absen kehadiran harian</p>
            @if($absenHariIni)<span class="badge bg-success-subtle text-success">Sudah Absen</span>
            @elseif($absenOpen)<span class="badge bg-primary-subtle text-primary">Dibuka — Absen Sekarang!</span>
            @else<span class="badge bg-secondary-subtle text-secondary">Belum Dibuka</span>@endif
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('elearning.mahasiswa.materi') }}" class="mhs-room card p-4 h-100">
            <div class="room-ic" style="background:#F5F3FF;color:#7A5CF0;"><i class="ri-folder-download-line"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Ruang Materi</h6>
            <p class="small text-muted mb-2">Unduh materi pembelajaran</p>
            <span class="badge bg-primary-subtle text-primary">{{ $materiCount }} materi</span>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('elearning.mahasiswa.kelas') }}" class="mhs-room card p-4 h-100">
            <div class="room-ic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-edit-2-line"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Ruang Kelas</h6>
            <p class="small text-muted mb-2">Ujian & tugas via Google Drive</p>
            <span class="badge bg-primary-subtle text-primary">{{ $openExams->count() }} terbuka</span>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('elearning.mahasiswa.pembayaran') }}" class="mhs-room card p-4 h-100">
            <div class="room-ic" style="background:#FFF7ED;color:#EA580C;"><i class="ri-wallet-3-line"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Pembayaran</h6>
            <p class="small text-muted mb-2">Rincian lunas & tunggakan</p>
            <span class="badge {{ $tunggakan > 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">{{ $tunggakan > 0 ? $tunggakan . ' Tunggakan' : 'Lunas' }}</span>
        </a>
    </div>
</div>

{{-- UJIAN & TUGAS TERBUKA --}}
<div class="mhs-stat card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="ri-alarm-warning-line text-danger me-1"></i> Ujian & Tugas yang Sedang Terbuka</h6>
            <span class="badge bg-danger-subtle text-danger">{{ $openExams->count() }} perlu dikerjakan</span>
        </div>
        <div class="table-responsive">
            <table class="table mhs-table align-middle mb-0">
                <thead><tr><th>Jenis</th><th>Judul</th><th>Kelas</th><th>Batas Akhir</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                @forelse($openExams as $e)
                    <tr>
                        <td><span class="badge {{ $e->type === 'tugas' ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary' }}">
                            <i class="{{ $e->type === 'tugas' ? 'ri-file-list-3-line' : 'ri-edit-2-line' }} me-1"></i>{{ ucfirst($e->type) }}</span></td>
                        <td class="fw-bold">{{ $e->title }}</td>
                        <td>{{ $e->course->title }}</td>
                        <td><i class="ri-time-line text-muted me-1"></i>{{ $e->end_at->format('d M Y, H:i') }}</td>
                        <td class="text-end"><a href="{{ route('elearning.mahasiswa.kelas.show', $e->course_id) }}" class="btn btn-sm btn-primary fw-bold">Kerjakan <i class="ri-arrow-right-line ms-1"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4"><i class="ri-emoji-line d-block mb-2" style="font-size:32px;opacity:.4;"></i>Tidak ada ujian/tugas terbuka. Tetap semangat belajar! ✨</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection