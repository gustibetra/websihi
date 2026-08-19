@extends('layouts.elearning')
@section('title', 'Dashboard Staff')
@section('content')
@php
    $user       = auth('elearning')->user();
    $isPengajar = $user->staff_type === 'pengajar';
    $isAdminKeu = in_array($user->staff_type, ['administrasi', 'keuangan']);
    $isDirektur = $user->staff_type === 'direktur';        // ✅ BARU
    $isWadir    = $user->staff_type === 'wakil_direktur';  // ✅ BARU

    // ✅ Label role yang benar untuk semua tipe
    $roleLabel = $isPengajar ? 'Staff Pengajar'
        : ($isAdminKeu ? 'Staff Administrasi & Keuangan'
        : ($isDirektur ? 'Direktur Lembaga'
        : ($isWadir ? 'Wakil Direktur' : 'Staff')));

    // ✅ STATISTIK DIREKTUR: kehadiran staff hari ini (aman try-catch)
    $statsDirektur = ['total' => 0, 'hadir' => 0, 'telat' => 0, 'belum' => 0];
    if ($isDirektur) {
        try {
            $staffIds   = \App\Models\ElearningUser::where('role', 'staff')->where('is_active', true)->pluck('id');
            $absenToday = \App\Models\ElearningAttendance::where('date', now()->toDateString())
                ->whereIn('user_id', $staffIds)->get();
            $statsDirektur = [
                'total' => $staffIds->count(),
                'hadir' => $absenToday->where('status', 'Hadir')->count(),
                'telat' => $absenToday->where('status', 'Terlambat')->count(),
                'belum' => max(0, $staffIds->count() - $absenToday->count()),
            ];
        } catch (\Throwable $e) { /* silent */ }
    }

    // ✅ STATISTIK WAKIL DIREKTUR: pendaftar (aman try-catch)
    $statsWadir = ['total' => 0, 'baru' => 0, 'diterima' => 0];
    if ($isWadir) {
        try {
            $statsWadir = [
                'total'    => \App\Models\Registration::count(),
                'baru'     => \App\Models\Registration::whereIn('status', ['Baru', null])->orWhereNull('status')->count(),
                'diterima' => \App\Models\Registration::where('status', 'Diterima')->count(),
            ];
        } catch (\Throwable $e) { /* silent */ }
    }
@endphp

<div class="mb-4">
    <h4 class="fw-bold mb-1">Halo, {{ $user->name }}! 👋</h4>
    <p class="text-muted small mb-0">{{ now()->translatedFormat('l, d F Y') }} • {{ $roleLabel }}</p>
</div>

{{-- ═══ STATISTIK (sesuai role) ═══ --}}
<div class="row g-3 mb-4">
    @if($isAdminKeu)
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-error-warning-line"></i></div>
            <div><div class="text-muted small">Tunggakan</div><div class="fw-bold text-danger">{{ $statsAdminKeu['tunggakan'] ?? 0 }} tagihan</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-checkbox-circle-line"></i></div>
            <div><div class="text-muted small">Lunas</div><div class="fw-bold text-success">{{ $statsAdminKeu['lunas'] ?? 0 }} tagihan</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-graduation-cap-line"></i></div>
            <div><div class="text-muted small">Mahasiswa</div><div class="fw-bold">{{ $statsAdminKeu['mahasiswa'] ?? 0 }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FFF7ED;color:#EA580C;font-size:20px;"><i class="ri-wallet-3-line"></i></div>
            <div><div class="text-muted small">Nominal Tunggakan</div><div class="fw-bold text-danger">Rp {{ number_format($statsAdminKeu['nominalTunggakan'] ?? 0, 0, ',', '.') }}</div></div>
        </div></div></div>

    @elseif($isDirektur)
        {{-- ✅ STATISTIK DIREKTUR --}}
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-group-line"></i></div>
            <div><div class="text-muted small">Total Staff</div><div class="fw-bold">{{ $statsDirektur['total'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-thumb-up-line"></i></div>
            <div><div class="text-muted small">Tepat Waktu</div><div class="fw-bold text-success">{{ $statsDirektur['hadir'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-alarm-warning-line"></i></div>
            <div><div class="text-muted small">Terlambat</div><div class="fw-bold text-warning">{{ $statsDirektur['telat'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-user-unfollow-line"></i></div>
            <div><div class="text-muted small">Belum Absen</div><div class="fw-bold text-danger">{{ $statsDirektur['belum'] }}</div></div>
        </div></div></div>

    @elseif($isWadir)
        {{-- ✅ STATISTIK WAKIL DIREKTUR --}}
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-file-list-3-line"></i></div>
            <div><div class="text-muted small">Total Pendaftar</div><div class="fw-bold">{{ $statsWadir['total'] }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-sparkling-line"></i></div>
            <div><div class="text-muted small">Pendaftar Baru</div><div class="fw-bold text-warning">{{ $statsWadir['baru'] }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-user-follow-line"></i></div>
            <div><div class="text-muted small">Diterima</div><div class="fw-bold text-success">{{ $statsWadir['diterima'] }}</div></div>
        </div></div></div>

    @else
        {{-- PENGARAJAR --}}
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-book-open-line"></i></div>
            <div><div class="text-muted small">Kelas Saya</div><div class="fw-bold">{{ $statsPengajar['kelas'] ?? 0 }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FFF7ED;color:#EA580C;font-size:20px;"><i class="ri-folder-upload-line"></i></div>
            <div><div class="text-muted small">Materi</div><div class="fw-bold">{{ $statsPengajar['materi'] ?? 0 }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-6"><div class="el-card card p-3 h-100"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:46px;height:46px;background:#FDF2F8;color:#DB2777;font-size:20px;"><i class="ri-edit-2-line"></i></div>
            <div><div class="text-muted small">Ujian</div><div class="fw-bold">{{ $statsPengajar['ujian'] ?? 0 }}</div></div>
        </div></div></div>
    @endif
</div>

{{-- ═══ RUANGAN SAYA (sesuai role) ═══ --}}
<h6 class="fw-bold mb-3"><i class="ri-door-open-line text-primary me-1"></i> Ruangan Saya</h6>
<div class="row g-3">

    {{-- Semua staff: Ruang Absen --}}
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.absen') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #059669 !important;">
                <i class="ri-fingerprint-2-line" style="font-size:40px; color:#059669;"></i>
                <h6 class="fw-bold mt-3 mb-1">Ruang Absen</h6>
                <p class="small text-muted mb-2">Status: <strong>{{ $absenHariIni ? $absenHariIni->status . ' (In ' . $absenHariIni->check_in . ')' : 'Belum Absen' }}</strong></p>
                <span class="btn btn-sm btn-success fw-bold">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>

    {{-- ✅ DIREKTUR: Monitor Absensi Staff --}}
    @if($isDirektur)
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.absensi.monitor') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #F59E0B !important;">
                <i class="ri-group-line" style="font-size:40px; color:#F59E0B;"></i>
                <h6 class="fw-bold mt-3 mb-1">Monitor Absensi Staff</h6>
                <p class="small text-muted mb-2"><strong>{{ $statsDirektur['belum'] }}</strong> staff belum absen hari ini</p>
                <span class="btn btn-sm btn-warning fw-bold">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    @endif

    {{-- ✅ WAKIL DIREKTUR: Data Pendaftar --}}
    @if($isWadir)
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.pendaftar') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #F59E0B !important;">
                <i class="ri-file-list-3-line" style="font-size:40px; color:#F59E0B;"></i>
                <h6 class="fw-bold mt-3 mb-1">Data Pendaftar</h6>
                <p class="small text-muted mb-2"><strong>{{ $statsWadir['baru'] }}</strong> pendaftar baru menunggu</p>
                <span class="btn btn-sm btn-warning fw-bold">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    @endif

    {{-- Admin & Keuangan --}}
    @if($isAdminKeu)
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.pembayaran') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #1F57ED !important;">
                <i class="ri-money-dollar-circle-line" style="font-size:40px; color:#1F57ED;"></i>
                <h6 class="fw-bold mt-3 mb-1">Ruang Pembayaran</h6>
                <p class="small text-muted mb-2"><strong>{{ $statsAdminKeu['tunggakan'] ?? 0 }}</strong> tagihan menunggu lunas</p>
                <span class="btn btn-sm btn-primary fw-bold">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.berkas') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #06B6D4 !important;">
                <i class="ri-folder-zip-line" style="font-size:40px; color:#06B6D4;"></i>
                <h6 class="fw-bold mt-3 mb-1">Berkas Mahasiswa</h6>
                <p class="small text-muted mb-2">Verifikasi berkas & dokumen</p>
                <span class="btn btn-sm btn-info fw-bold text-white">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.loker') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #7A5CF0 !important;">
                <i class="ri-briefcase-4-line" style="font-size:40px; color:#7A5CF0;"></i>
                <h6 class="fw-bold mt-3 mb-1">Kelola Loker</h6>
                <p class="small text-muted mb-2">Publikasikan lowongan kerja</p>
                <span class="btn btn-sm fw-bold" style="background:#7A5CF0;color:#fff;">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    @endif

    {{-- Pengajar --}}
    @if($isPengajar)
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.kelas') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #7A5CF0 !important;">
                <i class="ri-book-open-line" style="font-size:40px; color:#7A5CF0;"></i>
                <h6 class="fw-bold mt-3 mb-1">Ruang Kelas</h6>
                <p class="small text-muted mb-2">Kelola materi & ujian</p>
                <span class="btn btn-sm fw-bold" style="background:#7A5CF0;color:#fff;">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('elearning.staff.absen.mahasiswa') }}" class="text-decoration-none">
            <div class="el-card card p-4 h-100 text-center" style="border-left:4px solid #06B6D4 !important;">
                <i class="ri-group-line" style="font-size:40px; color:#06B6D4;"></i>
                <h6 class="fw-bold mt-3 mb-1">Monitor Absensi Mahasiswa</h6>
                <p class="small text-muted mb-2">Pantau check-in mahasiswa</p>
                <span class="btn btn-sm btn-info fw-bold text-white">Buka Ruang <i class="ri-arrow-right-line ms-1"></i></span>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection