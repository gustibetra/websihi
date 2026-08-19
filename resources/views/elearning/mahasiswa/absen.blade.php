@extends('layouts.elearning')
@section('title', 'Ruang Absensi')
@section('content')

<style>
    .abm-hero{background:linear-gradient(135deg,#13294B 0%,#1F57ED 55%,#7A5CF0 100%);border-radius:20px;color:#fff;padding:28px 32px;position:relative;overflow:hidden;margin-bottom:24px;}
    .abm-hero::before{content:'';position:absolute;width:280px;height:280px;border-radius:50%;background:rgba(255,255,255,.07);top:-100px;right:-70px;}
    .abm-clock-box{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(10px);border-radius:16px;padding:16px 34px;text-align:center;}
    .abm-clock{font-size:44px;font-weight:800;letter-spacing:3px;line-height:1.1;}
    .abm-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);border-radius:50px;padding:6px 14px;font-size:12px;font-weight:600;}
    .abm-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);}
    .abm-table th{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:#6B7280;border-bottom:2px solid #EEF2FF;}
    .abm-table td{vertical-align:middle;font-size:13px;}
    .abm-table tbody tr:hover{background:#F8FAFF;}
    .abm-scan-zone{border:2px dashed #059669;background:linear-gradient(135deg,#F0FDF4,#ECFDF5);border-radius:20px;padding:24px;box-shadow:0 8px 30px rgba(5,150,105,.08);margin-bottom:24px;}
</style>

{{-- HERO + JAM --}}
<div class="abm-hero">
    <div class="row align-items-center g-4 position-relative" style="z-index:2;">
        <div class="col-md-7">
            <span class="abm-chip mb-3"><i class="ri-fingerprint-2-line"></i> Ruang Absensi Mahasiswa</span>
            <h3 class="fw-bold mb-2" style="letter-spacing:-.5px;">Absen Kehadiran 🙋</h3>
            <p class="mb-3" style="opacity:.85;font-size:14px;">Aktifkan kamera lalu scan <strong>KTM SIHI</strong> Anda. Absensi hanya aktif apabila staff pengajar telah membukanya.</p>
            <div class="d-flex gap-2 flex-wrap">
                <span class="abm-chip"><i class="ri-calendar-2-line"></i> {{ now()->format('l, d F Y') }}</span>
                <span class="abm-chip"><i class="ri-time-line"></i> Batas tepat waktu: 08:00</span>
            </div>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="abm-clock-box d-inline-block">
                <div class="small mb-1" style="opacity:.8;">Waktu Saat Ini</div>
                <div class="abm-clock" id="liveClock">--:--:--</div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ ZONA SCAN KTM (KAMERA + SCANNER FISIK) --}}
<div class="abm-scan-zone">
    @unless($absenOpen)
        <div class="text-center mb-3">
            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                <i class="ri-lock-line me-1"></i> Absensi belum dibuka oleh pengajar — scan akan aktif setelah dibuka.
            </span>
        </div>
    @endunless
    @include('elearning.partials.scan-absen', ['scanRoute' => route('elearning.mahasiswa.absen.scan')])
</div>

{{-- ═══ RIWAYAT (LEBAR PENUH) ═══ --}}
<div class="abm-card card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0"><i class="ri-history-line text-primary me-1"></i> Riwayat Absen (30 Hari)</h6>
            <span class="badge bg-primary-subtle text-primary">{{ $riwayat->count() }} catatan</span>
        </div>
        <div class="table-responsive">
            <table class="table abm-table align-middle mb-0">
                <thead><tr><th>Tanggal</th><th>Check-In</th><th>Check-Out</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($riwayat as $r)
                    <tr>
                        <td><i class="ri-calendar-line text-muted me-1"></i> {{ $r->date->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $r->check_in ?? '—' }}</td>
                        <td>{{ $r->check_out ?? '—' }}</td>
                        <td><span class="badge {{ $r->status === 'Hadir' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                            <i class="{{ $r->status === 'Hadir' ? 'ri-thumb-up-line' : 'ri-alarm-warning-line' }} me-1"></i>{{ $r->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat absen.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function tickClock(){ const el=document.getElementById('liveClock'); if(!el) return; el.textContent=new Date().toLocaleTimeString('id-ID',{hour12:false}); }
    setInterval(tickClock,1000); tickClock();
</script>
@endpush
@endsection