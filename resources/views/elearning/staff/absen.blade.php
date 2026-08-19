@extends('layouts.elearning')
@section('title', 'Ruang Absen')
@section('content')

<style>
    .abs-hero{background:linear-gradient(135deg,#13294B 0%,#1F57ED 55%,#7A5CF0 100%);border-radius:20px;color:#fff;padding:28px 32px;position:relative;overflow:hidden;margin-bottom:24px;}
    .abs-hero::before,.abs-hero::after{content:'';position:absolute;border-radius:50%;pointer-events:none;}
    .abs-hero::before{width:280px;height:280px;background:rgba(255,255,255,.07);top:-100px;right:-70px;}
    .abs-hero::after{width:170px;height:170px;background:rgba(255,209,102,.16);bottom:-70px;left:25%;}
    .abs-clock-box{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(10px);border-radius:16px;padding:16px 34px;text-align:center;}
    .abs-clock{font-size:44px;font-weight:800;letter-spacing:3px;line-height:1.1;}
    .abs-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);border-radius:50px;padding:6px 14px;font-size:12px;font-weight:600;}
    .abs-stat{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.05);overflow:hidden;position:relative;}
    .abs-stat .bar{position:absolute;left:0;top:0;bottom:0;width:5px;}
    .abs-stat .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .abs-action{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);}
    .abs-table th{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:#6B7280;border-bottom:2px solid #EEF2FF;}
    .abs-table td{vertical-align:middle;font-size:13px;}
    .abs-table tbody tr:hover{background:#F8FAFF;}
    .abs-scan-zone{border:2px dashed #1F57ED;background:linear-gradient(135deg,#F8FAFF,#F5F3FF);border-radius:20px;padding:24px;box-shadow:0 8px 30px rgba(31,87,237,.08);margin-bottom:24px;}
</style>

@php
    $user = auth('elearning')->user();
    $isPengajar = $user->staff_type === 'pengajar';
    $bulanIni = $riwayat->filter(fn($r) => $r->date->format('m-Y') === now()->format('m-Y'));
    $telatBulanIni = $bulanIni->where('status','Terlambat')->count();
    $tepatBulanIni = $bulanIni->where('status','Hadir')->count();
    $durasiHariIni = null;
    if ($absenHariIni && $absenHariIni->check_in && $absenHariIni->check_out) {
        $durasiHariIni = \Carbon\Carbon::parse($absenHariIni->check_in)->diffInMinutes(\Carbon\Carbon::parse($absenHariIni->check_out));
    }
@endphp

{{-- ═══ HERO + JAM LIVE ═══ --}}
<div class="abs-hero">
    <div class="row align-items-center g-4 position-relative" style="z-index:2;">
        <div class="col-md-7">
            <span class="abs-chip mb-3"><i class="ri-fingerprint-2-line"></i> Ruang Absen Staff</span>
            <h3 class="fw-bold mb-2" style="letter-spacing:-.5px;">Halo, {{ $user->name }}! 👋</h3>
            <p class="mb-3" style="opacity:.85; font-size:14px;">Aktifkan kamera atau gunakan scanner untuk memindai ID Card SIHI Anda. Kehadiran tercatat otomatis secara digital.</p>
            <div class="d-flex gap-2 flex-wrap">
                <span class="abs-chip"><i class="ri-calendar-2-line"></i> {{ now()->format('l, d F Y') }}</span>
                <span class="abs-chip"><i class="ri-time-line"></i> Batas tepat waktu: 08:00</span>
                @if($isPengajar)
                    <span class="abs-chip" style="background:rgba(255,209,102,.2);border-color:rgba(255,209,102,.4);">
                        <i class="ri-shield-star-line"></i> Mode Pengajar
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="abs-clock-box d-inline-block">
                <div class="small mb-1" style="opacity:.8;">Waktu Saat Ini</div>
                <div class="abs-clock" id="liveClock">--:--:--</div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ ZONA SCAN (KAMERA + SCANNER FISIK) --}}
<div class="abs-scan-zone">
    @include('elearning.partials.scan-absen', ['scanRoute' => route('elearning.staff.absen.scan')])
</div>

{{-- PINTASAN MONITOR MAHASISWA (KHUSUS PENGAJAR) --}}
@if($isPengajar)
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('elearning.staff.absen.mahasiswa') }}" class="btn btn-sm btn-outline-primary fw-bold">
        <i class="ri-group-line me-1"></i> Buka Monitor Absensi Mahasiswa
    </a>
</div>
@endif

{{-- ═══ STATISTIK KEHADIRAN STAFF ═══ --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="abs-stat card p-3"><div class="bar" style="background:#1F57ED;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-calendar-check-line"></i></div>
                <div><div class="text-muted small">Kehadiran Bulan Ini</div><div class="fw-bold fs-5">{{ $bulanIni->count() }} hari</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-stat card p-3"><div class="bar" style="background:#059669;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#ECFDF5;color:#059669;"><i class="ri-thumb-up-line"></i></div>
                <div><div class="text-muted small">Tepat Waktu</div><div class="fw-bold fs-5">{{ $tepatBulanIni }}x</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-stat card p-3"><div class="bar" style="background:#F59E0B;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#FFFBEB;color:#F59E0B;"><i class="ri-alarm-warning-line"></i></div>
                <div><div class="text-muted small">Terlambat</div><div class="fw-bold fs-5">{{ $telatBulanIni }}x</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="abs-stat card p-3"><div class="bar" style="background:#7A5CF0;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#F5F3FF;color:#7A5CF0;"><i class="ri-timer-line"></i></div>
                <div><div class="text-muted small">Durasi Hari Ini</div>
                    <div class="fw-bold fs-5">@if($durasiHariIni !== null) {{ floor($durasiHariIni/60) }}j {{ $durasiHariIni%60 }}m @else — @endif</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ RIWAYAT ABSEN (LEBAR PENUH) ═══ --}}
<div class="abs-action card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="ri-history-line text-primary me-1"></i> Riwayat Absen Saya (30 Hari)</h6>
            <span class="badge bg-primary-subtle text-primary">{{ $riwayat->count() }} catatan</span>
        </div>
        <div class="table-responsive">
            <table class="table abs-table align-middle mb-0">
                <thead><tr><th>Tanggal</th><th>Check-In</th><th>Check-Out</th><th>Durasi</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($riwayat as $r)
                    @php
                        $dur = ($r->check_in && $r->check_out) ? \Carbon\Carbon::parse($r->check_in)->diffInMinutes(\Carbon\Carbon::parse($r->check_out)) : null;
                    @endphp
                    <tr>
                        <td><i class="ri-calendar-line text-muted me-1"></i> {{ $r->date->format('d M Y') }}</td>
                        <td>{{ $r->check_in ?? '—' }}</td>
                        <td>{{ $r->check_out ?? '—' }}</td>
                        <td>@if($dur !== null) {{ floor($dur/60) }}j {{ $dur%60 }}m @else — @endif</td>
                        <td>
                            <span class="badge {{ $r->status === 'Hadir' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                <i class="{{ $r->status === 'Hadir' ? 'ri-thumb-up-line' : 'ri-alarm-warning-line' }} me-1"></i>{{ $r->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat absen.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function tickClock(){
        const el = document.getElementById('liveClock');
        if(!el) return;
        el.textContent = new Date().toLocaleTimeString('id-ID', { hour12:false });
    }
    setInterval(tickClock, 1000); tickClock();
</script>
@endpush
@endsection