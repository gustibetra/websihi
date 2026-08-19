@extends('layouts.admin')
@section('title', 'Monitor Absensi E-Learning')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="ri-fingerprint-2-line text-primary"></i> Monitor Absensi</h4>
            <p class="text-muted small mb-0">Pantau kehadiran Staff & Mahasiswa — siapa sudah dan belum absen</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <form method="GET" action="{{ route('admin.elearning.absensi') }}" class="d-flex gap-2">
                <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm" onchange="this.form.submit()">
                <button class="btn btn-sm btn-soft-primary">Tampilkan</button>
            </form>
            <a href="{{ route('admin.elearning.users') }}" class="btn btn-sm btn-light"><i class="ri-arrow-left-line me-1"></i> Kelola Akun</a>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success py-2 small">{{ session('success') }}</div>@endif

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-thumb-up-line"></i></div>
            <div><div class="text-muted small">Tepat Waktu</div><div class="fw-bold fs-5 text-success">{{ $hadir }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FFFBEB;color:#F59E0B;font-size:20px;"><i class="ri-alarm-warning-line"></i></div>
            <div><div class="text-muted small">Terlambat</div><div class="fw-bold fs-5 text-warning">{{ $telat }}</div></div>
        </div></div></div>
        <div class="col-md-4 col-12"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-user-unfollow-line"></i></div>
            <div><div class="text-muted small">Belum / Tidak Absen</div><div class="fw-bold fs-5 text-danger">{{ $belum }}</div></div>
        </div></div></div>
    </div>

    {{-- Tabel Kehadiran --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="ri-calendar-check-line text-primary me-1"></i> Kehadiran Tanggal {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light"><tr><th>Pengguna</th><th>Role</th><th>Check-In</th><th>Check-Out</th><th>Status</th><th class="text-end">Koreksi</th></tr></thead>
                    <tbody>
                    @forelse($users as $u)
                        @php $a = $attendances->get($u->id); @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:34px;height:34px;background:linear-gradient(135deg,#1F57ED,#7A5CF0);color:#fff;font-weight:700;font-size:12px;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                    <div><div class="fw-bold">{{ $u->name }}</div><small class="text-muted">{{ $u->nomor_induk ?? '-' }}</small></div>
                                </div>
                            </td>
                            <td><span class="badge {{ $u->role === 'staff' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }}">{{ ucfirst($u->role) }}{{ $u->staff_type ? ' • ' . ucfirst($u->staff_type) : '' }}</span></td>
                            <td class="fw-bold">{{ $a->check_in ?? '—' }}</td>
                            <td class="fw-bold">{{ $a->check_out ?? '—' }}</td>
                            <td>
                                @if($a)
                                    <span class="badge {{ $a->status === 'Hadir' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                        <i class="{{ $a->status === 'Hadir' ? 'ri-thumb-up-line' : 'ri-alarm-warning-line' }} me-1"></i>{{ $a->status }}
                                    </span>
                                @else
                                    <span class="badge {{ $date === now()->toDateString() ? 'bg-secondary-subtle text-secondary' : 'bg-danger-subtle text-danger' }}">
                                        <i class="ri-close-circle-line me-1"></i>{{ $date === now()->toDateString() ? 'Belum Absen' : 'Tidak Absen' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($a)
                                    <form method="POST" action="{{ route('admin.elearning.absensi.destroy', $a->id) }}" class="d-inline" onsubmit="return confirm('Hapus catatan absen ini (untuk koreksi)?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus catatan (koreksi)"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                @else — @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengguna aktif.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection