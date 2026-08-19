@extends('layouts.elearning')
@section('title', 'Monitor Absensi Mahasiswa')
@section('content')

<style>
    .abs-mon-hero{background:linear-gradient(135deg,#059669 0%,#06D6A0 55%,#F5B301 100%);border-radius:20px;color:#fff;padding:28px 32px;position:relative;overflow:hidden;margin-bottom:24px;}
    .abs-mon-hero::before{content:'';position:absolute;width:280px;height:280px;background:rgba(255,255,255,.08);border-radius:50%;top:-100px;right:-70px;}
    .abs-mon-hero::after{content:'';position:absolute;width:170px;height:170px;background:rgba(255,255,255,.12);border-radius:50%;bottom:-70px;left:10%;}
    .abs-mon-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:50px;padding:6px 14px;font-size:12px;font-weight:600;}
    .abs-mon-stat{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.05);overflow:hidden;position:relative;}
    .abs-mon-stat .bar{position:absolute;left:0;top:0;bottom:0;width:5px;}
    .abs-mon-stat .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .abs-mon-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);overflow:hidden;}
    .abs-mon-card-head{padding:16px 24px;color:#fff;display:flex;align-items:center;gap:10px;}
    .abs-mon-card-head.success{background:linear-gradient(135deg,#059669,#06D6A0);}
    .abs-mon-card-head.danger{background:linear-gradient(135deg,#DC2626,#F87171);}
    .abs-mon-table th{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:#6B7280;border-bottom:2px solid #EEF2FF;}
    .abs-mon-table td{vertical-align:middle;font-size:13px;}
    .abs-mon-table tbody tr:hover{background:#F8FAFF;}
    .abs-mon-avt{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1F57ED,#7A5CF0);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;}
    .abs-mon-avt.gray{background:#E2E8F0;color:#64748B;}
    .abs-mon-control{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.06);background:#fff;}
</style>

@php
    $total     = $sudahAbsen->count() + $belumAbsen->count();
    $tepat     = $sudahAbsen->filter(fn($r) => $r->absen->status === 'Hadir')->count();
    $terlambat = $sudahAbsen->filter(fn($r) => $r->absen->status === 'Terlambat')->count();
@endphp

{{-- ═══ HERO ═══ --}}
<div class="abs-mon-hero position-relative">
    <div class="row align-items-center g-4 position-relative" style="z-index:2;">
        <div class="col-md-8">
            <span class="abs-mon-chip mb-3"><i class="ri-group-line"></i> Monitor Absensi Mahasiswa</span>
            <h3 class="fw-bold mb-2">Rekap Kehadiran Hari Ini 📋</h3>
            <p class="mb-3" style="opacity:.9; font-size:14px;">
                Pantau mahasiswa yang sudah dan belum check-in untuk tanggal
                <strong>{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</strong>
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <span class="abs-mon-chip">
                    <i class="ri-calendar-2-line"></i> {{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }}
                </span>
                <span class="abs-mon-chip">
                    <i class="ri-user-line"></i> Total Mahasiswa: {{ $total }}
                </span>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex flex-column gap-2 align-items-md-end">
                <a href="{{ route('elearning.staff.absen') }}" class="btn btn-sm btn-light fw-bold">
                    <i class="ri-arrow-left-line me-1"></i> Kembali ke Absen Saya
                </a>
                <a href="{{ route('elearning.staff.absen.mahasiswa') }}" class="btn btn-sm fw-bold text-white"
                   style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);">
                    <i class="ri-refresh-line me-1"></i> Refresh Data
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ═══ STATISTIK ═══ --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="abs-mon-stat card p-3"><div class="bar" style="background:#1F57ED;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-group-line"></i></div>
                <div><div class="text-muted small">Total Mahasiswa</div><div class="fw-bold fs-5">{{ $total }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-mon-stat card p-3"><div class="bar" style="background:#059669;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#ECFDF5;color:#059669;"><i class="ri-thumb-up-line"></i></div>
                <div><div class="text-muted small">Tepat Waktu</div><div class="fw-bold fs-5">{{ $tepat }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-mon-stat card p-3"><div class="bar" style="background:#F59E0B;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#FFFBEB;color:#F59E0B;"><i class="ri-alarm-warning-line"></i></div>
                <div><div class="text-muted small">Terlambat</div><div class="fw-bold fs-5">{{ $terlambat }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-mon-stat card p-3"><div class="bar" style="background:#DC2626;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#FEF2F2;color:#DC2626;"><i class="ri-user-unfollow-line"></i></div>
                <div><div class="text-muted small">Belum Absen</div><div class="fw-bold fs-5">{{ $belumAbsen->count() }}</div></div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ KONTROL ABSENSI ═══ --}}
<div class="abs-mon-control card p-3 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <strong class="small">Status Absensi Mahasiswa:</strong>
            <span class="badge {{ $absenOpen ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                <i class="{{ $absenOpen ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' }} me-1"></i>
                {{ $absenOpen ? 'DIBUKA — mahasiswa bisa check-in' : 'DITUTUP — mahasiswa belum bisa absen' }}
            </span>
        </div>
        <form method="POST" action="{{ route('elearning.staff.absen.toggle-mahasiswa') }}">
            @csrf
            <button class="btn btn-sm fw-bold {{ $absenOpen ? 'btn-outline-danger' : 'btn-outline-success' }}"
                    onclick="return confirm('{{ $absenOpen ? 'Tutup absensi?' : 'Buka absensi?' }}')">
                <i class="{{ $absenOpen ? 'ri-lock-line' : 'ri-lock-unlock-line' }} me-1"></i>
                {{ $absenOpen ? 'Tutup Absensi' : 'Buka Absensi' }}
            </button>
        </form>
    </div>
</div>

{{-- ═══ 2 KOLOM: SUDAH & BELUM ═══ --}}
<div class="row g-4">
    {{-- KOLOM SUDAH ABSEN --}}
    <div class="col-lg-6">
        <div class="abs-mon-card card h-100">
            <div class="abs-mon-card-head success">
                <i class="ri-checkbox-circle-line" style="font-size:22px;"></i>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-0">Sudah Absen</h6>
                    <small style="opacity:.85;">{{ $sudahAbsen->count() }} mahasiswa</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table abs-mon-table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="padding:12px 16px;">Mahasiswa</th>
                                <th style="padding:12px 16px;">Check-In</th>
                                <th style="padding:12px 16px;">Status</th>
                                <th style="padding:12px 16px;" class="text-end">Aksi</th> {{-- ✅ BARU --}}
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sudahAbsen as $row)
                            @php
                                $initials = collect(explode(' ', trim($row->student->name)))
                                    ->take(2)
                                    ->map(fn($w) => mb_strtoupper(mb_substr($w,0,1)))
                                    ->implode('');
                            @endphp
                            <tr>
                                <td style="padding:12px 16px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="abs-mon-avt">{{ $initials }}</div>
                                        <div style="min-width:0;">
                                            <div class="fw-bold text-truncate">{{ $row->student->name }}</div>
                                            <small class="text-muted">{{ $row->student->nomor_induk ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:12px 16px;">
                                    <i class="ri-time-line me-1 text-muted"></i>
                                    {{ $row->absen->check_in ?? '-' }}
                                </td>
                                <td style="padding:12px 16px;">
                                    <span class="badge {{ $row->absen->status === 'Terlambat' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' }}">
                                        <i class="{{ $row->absen->status === 'Terlambat' ? 'ri-alarm-warning-line' : 'ri-thumb-up-line' }} me-1"></i>
                                        {{ $row->absen->status }}
                                    </span>
                                </td>
                                {{-- ✅ BARU: TOMBOL HAPUS ABSENSI --}}
                                <td style="padding:12px 16px;" class="text-end">
                                    <form method="POST" action="{{ route('elearning.staff.absen.mahasiswa.destroy', $row->absen->id) }}"
                                          onsubmit="return confirm('Hapus absensi {{ $row->student->name }} ({{ $row->absen->date->format('d M Y') }})?\nMahasiswa akan pindah ke kolom BELUM ABSEN dan bisa check-in ulang.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus absensi">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5" style="padding:40px 16px;">
                                    <i class="ri-inbox-line d-block mb-2" style="font-size:40px;opacity:.3;"></i>
                                    Belum ada mahasiswa yang absen hari ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM BELUM ABSEN --}}
    <div class="col-lg-6">
        <div class="abs-mon-card card h-100">
            <div class="abs-mon-card-head danger">
                <i class="ri-error-warning-line" style="font-size:22px;"></i>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-0">Belum Absen</h6>
                    <small style="opacity:.85;">{{ $belumAbsen->count() }} mahasiswa</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table abs-mon-table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="padding:12px 16px;">Mahasiswa</th>
                                <th style="padding:12px 16px;">NIM</th>
                                <th style="padding:12px 16px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($belumAbsen as $s)
                            @php
                                $initials = collect(explode(' ', trim($s->name)))
                                    ->take(2)
                                    ->map(fn($w) => mb_strtoupper(mb_substr($w,0,1)))
                                    ->implode('');
                            @endphp
                            <tr>
                                <td style="padding:12px 16px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="abs-mon-avt gray">{{ $initials }}</div>
                                        <div class="fw-bold text-truncate">{{ $s->name }}</div>
                                    </div>
                                </td>
                                <td style="padding:12px 16px;" class="text-muted">
                                    {{ $s->nomor_induk ?? '-' }}
                                </td>
                                <td style="padding:12px 16px;">
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="ri-close-circle-line me-1"></i>Belum check-in
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5" style="padding:40px 16px;color:#059669;">
                                    <i class="ri-checkbox-circle-line d-block mb-2" style="font-size:40px;opacity:.6;"></i>
                                    <strong>Semua mahasiswa sudah absen! 🎉</strong>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection