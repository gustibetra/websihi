@extends('layouts.elearning')
@section('title', 'Monitor Absensi Staff')
@section('content')

@php
    // ✅ Aman: jika tanggal invalid, tidak akan 500
    try {
        $tanggalIndo = \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
    } catch (\Throwable $e) {
        $tanggalIndo = now()->translatedFormat('d M Y');
    }

    // ✅ Label jabatan yang rapi (tanpa underscore)
    $jabatan = [
        'pengajar'       => 'Pengajar',
        'administrasi'   => 'Admin & Keuangan',
        'keuangan'       => 'Admin & Keuangan',
        'direktur'       => 'Direktur Lembaga',
        'wakil_direktur' => 'Wakil Direktur',
    ];
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-fingerprint-2-line text-primary"></i> Monitor Absensi Staff</h4>
        <p class="text-muted small mb-0">Pantau kehadiran seluruh staff lembaga</p>
    </div>
    <form method="GET" class="d-flex gap-2">
        <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm">
        <button class="btn btn-sm btn-primary fw-bold">Tampilkan</button>
    </form>
</div>

{{-- ═══ STATISTIK (4 kartu) ═══ --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-primary">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-group-line"></i></div>
            <div><div class="text-muted small">Total Staff</div><div class="fw-bold fs-5 text-primary">{{ $users->count() }}</div></div>
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-success">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-thumb-up-line"></i></div>
            <div><div class="text-muted small">Tepat Waktu</div><div class="fw-bold fs-5 text-success">{{ $hadir }}</div></div> {{-- ✅ DIPERBAIKI --}}
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-warning">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-alarm-warning-line"></i></div>
            <div><div class="text-muted small">Terlambat</div><div class="fw-bold fs-5 text-warning">{{ $telat }}</div></div>
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-danger">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-user-unfollow-line"></i></div>
            <div><div class="text-muted small">Belum Absen</div><div class="fw-bold fs-5 text-danger">{{ $belum }}</div></div>
        </div>
    </div></div>
</div>

{{-- ═══ TABEL KEHADIRAN ═══ --}}
<div class="el-card card p-4">
    <h6 class="fw-bold mb-3"><i class="ri-calendar-check-line text-primary me-1"></i> Kehadiran Tanggal {{ $tanggalIndo }}</h6>
    <div class="table-responsive">
        <table class="table align-middle small mb-0">
            <thead class="table-light">
                <tr><th>Nama Staff</th><th>Jabatan</th><th>Check-In</th><th>Check-Out</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($users as $u)
                @php $a = $attendances->get($u->id); @endphp
                <tr>
                    <td>
                        <div class="fw-bold">{{ $u->name }}</div>
                        <small class="text-muted">{{ $u->nomor_induk ?? $u->email }}</small>
                    </td>
                    {{-- ✅ Label jabatan rapi --}}
                    <td>
                        <span class="badge {{ in_array($u->staff_type, ['direktur', 'wakil_direktur']) ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary' }}">
                            {{ $jabatan[$u->staff_type] ?? ucfirst($u->staff_type ?? '-') }}
                        </span>
                    </td>
                    <td>{{ $a->check_in ?? '—' }}</td>
                    <td>{{ $a->check_out ?? '—' }}</td>
                    <td>
                        @if($a)
                            <span class="badge {{ $a->status === 'Terlambat' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' }}">
                                <i class="{{ $a->status === 'Terlambat' ? 'ri-alarm-warning-line' : 'ri-thumb-up-line' }} me-1"></i>{{ $a->status }}
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Belum Absen</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($a)
                            <form method="POST" action="{{ route('elearning.staff.absensi.monitor.destroy', $a->id) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus catatan absen {{ $u->name }} pada tanggal ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Koreksi (hapus)"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada staff aktif.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection