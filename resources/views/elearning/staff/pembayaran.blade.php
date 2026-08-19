@extends('layouts.elearning')
@section('title', 'Ruang Pembayaran')
@section('content')

<style>
    .pay-stat{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.05);position:relative;overflow:hidden;}
    .pay-stat .bar{position:absolute;left:0;top:0;bottom:0;width:5px;}
    .pay-stat .ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .pay-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);}
    .pay-avatar{width:38px;height:38px;border-radius:50%;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;}
    .pay-avatar.student{background:linear-gradient(135deg,#1F57ED,#7A5CF0);}
    .pay-avatar.alumni{background:linear-gradient(135deg,#F59E0B,#D97706);} /* ✅ BARU */
    .pay-form-wrap{background:linear-gradient(135deg,#F8FAFF 0%,#F5F3FF 100%);border:1px solid #EEF2FF;border-radius:16px;}
    .pay-table th{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:#6B7280;border-bottom:2px solid #EEF2FF;}
    .pay-table td{vertical-align:middle;font-size:13px;}
    .pay-table tbody tr:hover{background:#F8FAFF;}
    .btn-slip{background:linear-gradient(135deg,#F59E0B,#D97706);color:#fff;border:none;font-weight:700;font-size:12px;padding:6px 12px;border-radius:8px;}
    .btn-slip:hover{color:#fff;filter:brightness(1.1);}
    .btn-slip-kecil{background:linear-gradient(135deg,#F59E0B,#D97706);color:#fff;border:none;font-weight:700;padding:4px 10px;border-radius:6px;font-size:11px;}
</style>

@php
    $totalTagihan   = $payments->count();
    $lunasList      = $payments->where('status','Lunas');
    $tunggakanList  = $payments->where('status','Tunggakan');
    $totalLunas     = $lunasList->sum('amount');
    $totalTunggakan = $tunggakanList->sum('amount');
    $progress       = $totalTagihan > 0 ? round(($lunasList->count() / $totalTagihan) * 100) : 0;
    $buktiMasuk     = $payments->filter(fn($p) => !empty($p->payment_proof_link))->count();
    $slipCount      = $payments->filter(fn($p) => !empty($p->slip_number))->count();
    // ✅ BARU: hitung jumlah pembayaran alumni (manual)
    $alumniCount    = $payments->filter(fn($p) => $p->isManualPayment())->count();
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif

{{-- ═══ HEADER ═══ --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-money-dollar-circle-line text-primary"></i> Ruang Pembayaran</h4>
        <p class="text-muted small mb-0">Kelola tagihan mahasiswa, alumni, & pembayar eksternal</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('elearning.staff.pembayaran.slip.create') }}" class="btn btn-slip">
            <i class="ri-printer-line me-1"></i> Buat Slip Pembayaran
        </a>
        <span class="badge bg-primary-subtle text-primary px-3 py-2"><i class="ri-google-drive-line me-1"></i> {{ $buktiMasuk }} Bukti</span>
        <span class="badge px-3 py-2" style="background:#FEF3C7;color:#92400E;"><i class="ri-printer-line me-1"></i> {{ $slipCount }} Slip</span>
        <span class="badge px-3 py-2" style="background:#FEF2F2;color:#991B1B;"><i class="ri-user-star-line me-1"></i> {{ $alumniCount }} Alumni</span> {{-- ✅ BARU --}}
        <span class="badge bg-info-subtle text-info px-3 py-2"><i class="ri-graduation-cap-line me-1"></i> {{ $students->count() }} Mhs</span>
    </div>
</div>

{{-- ═══ KARTU RINGKASAN ═══ --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="pay-stat card p-3"><div class="bar" style="background:#1F57ED;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-file-list-3-line"></i></div>
                <div><div class="text-muted small">Total Tagihan</div><div class="fw-bold fs-5">{{ $totalTagihan }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="pay-stat card p-3"><div class="bar" style="background:#059669;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#ECFDF5;color:#059669;"><i class="ri-checkbox-circle-line"></i></div>
                <div><div class="text-muted small">Lunas</div><div class="fw-bold fs-5 text-success">{{ $lunasList->count() }}</div>
                <small class="text-success">Rp {{ number_format($totalLunas, 0, ',', '.') }}</small></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="pay-stat card p-3"><div class="bar" style="background:#DC2626;"></div>
            <div class="d-flex align-items-center gap-3">
                <div class="ic" style="background:#FEF2F2;color:#DC2626;"><i class="ri-error-warning-line"></i></div>
                <div><div class="text-muted small">Tunggakan</div><div class="fw-bold fs-5 text-danger">{{ $tunggakanList->count() }}</div>
                <small class="text-danger">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</small></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="pay-stat card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-muted small">Progres Pelunasan</div>
                <div class="fw-bold text-primary">{{ $progress }}%</div>
            </div>
            <div class="progress" style="height:8px;border-radius:50px;background:#EEF2FF;">
                <div class="progress-bar" style="width:{{ $progress }}%;border-radius:50px;background:linear-gradient(90deg,#059669,#06D6A0);"></div>
            </div>
            <small class="text-muted d-block mt-2">{{ $lunasList->count() }} dari {{ $totalTagihan }} tagihan lunas</small>
        </div>
    </div>
</div>

{{-- ═══ FORM TAMBAH TAGIHAN CEPAT ═══ --}}
<div class="pay-card card mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h6 class="fw-bold mb-0"><i class="ri-add-circle-line text-success me-1"></i> Tambah Tagihan Cepat</h6>
            <a href="{{ route('elearning.staff.pembayaran.slip.create') }}" class="small text-decoration-none">
                <i class="ri-printer-line me-1"></i> Buat tagihan lengkap (mahasiswa / alumni / eksternal) <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
        <form method="POST" action="{{ route('elearning.staff.pembayaran.store') }}" class="pay-form-wrap p-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold mb-1"><i class="ri-user-line text-primary me-1"></i>Mahasiswa *</label>
                    <select name="student_id" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->nomor_induk ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold mb-1"><i class="ri-price-tag-3-line text-primary me-1"></i>Nama Tagihan *</label>
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Contoh: SPP Semester 1" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold mb-1"><i class="ri-money-dollar-circle-line text-primary me-1"></i>Nominal *</label>
                    <input type="number" name="amount" class="form-control form-control-sm" placeholder="2500000" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold mb-1"><i class="ri-calendar-line text-primary me-1"></i>Jatuh Tempo</label>
                    <input type="date" name="due_date" class="form-control form-control-sm">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-success w-100 fw-bold" style="padding:8px 0;"><i class="ri-add-line me-1"></i>Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ═══ DAFTAR PEMBAYARAN ═══ --}}
<div class="pay-card card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h6 class="fw-bold mb-0"><i class="ri-list-check-2 text-primary me-1"></i> Daftar Pembayaran</h6>
            <input type="text" id="paySearch" class="form-control form-control-sm" style="max-width:240px;" placeholder="🔍 Cari nama / tagihan...">
        </div>
        <div class="table-responsive">
            <table class="table pay-table align-middle mb-0" id="payTable">
                <thead><tr>
                    <th>Pembayar</th>
                    <th>Tagihan</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Bukti / Slip</th>
                    <th class="text-end">Aksi</th>
                </tr></thead>
                <tbody>
                @forelse($payments as $p)
                    @php
                        $overdue = $p->status === 'Tunggakan' && $p->due_date && $p->due_date->lt(now()->startOfDay());
                        $hasSlip = !empty($p->slip_number);
                        $isAlumni = $p->isManualPayment();
                    @endphp
                    <tr>
                        {{-- ✅ KOLOM PEMBAYAR (AMAN untuk alumni & eksternal) --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="pay-avatar {{ $isAlumni ? 'alumni' : 'student' }}">
                                    {{ strtoupper(substr($p->display_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $p->display_name }}</div>
                                    <small class="text-muted">{{ $p->display_nim }}</small>
                                    <div class="mt-1">
                                        @if($isAlumni)
                                            <span class="badge" style="background:#FEF3C7;color:#92400E;font-size:10px;">
                                                <i class="ri-user-star-line me-1"></i>Alumni / Eksternal
                                            </span>
                                        @else
                                            <span class="badge bg-info-subtle text-info" style="font-size:10px;">
                                                <i class="ri-user-3-line me-1"></i>Mahasiswa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $p->title }}</div>
                            @if($p->slip_number)
                                <small class="text-muted"><i class="ri-printer-line me-1"></i>{{ $p->slip_number }}</small>
                            @endif
                        </td>
                        <td class="fw-bold">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                        <td>
                            {{ $p->due_date?->format('d M Y') ?? '—' }}
                            @if($overdue)<div><span class="badge bg-danger-subtle text-danger" style="font-size:10px;"><i class="ri-alarm-line me-1"></i>LEWAT JATUH TEMPO</span></div>@endif
                        </td>
                        <td>
                            <span class="badge {{ $p->status === 'Lunas' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                <i class="{{ $p->status === 'Lunas' ? 'ri-check-line' : 'ri-close-line' }} me-1"></i>{{ $p->status }}
                            </span>
                            @if($p->paid_at)<small class="text-muted d-block mt-1">Lunas {{ $p->paid_at->format('d/m/Y') }}</small>@endif
                        </td>

                        {{-- KOLOM BUKTI / SLIP --}}
                        <td>
                            @if($hasSlip)
                                <a href="{{ route('elearning.staff.pembayaran.slip', $p->id) }}" target="_blank" class="btn-slip-kecil text-decoration-none d-inline-block">
                                    <i class="ri-printer-line me-1"></i> Lihat Slip
                                </a>
                                <div class="mt-1">
                                    <span class="badge bg-success-subtle text-success" style="font-size:10px;">
                                        <i class="ri-check-double-line me-1"></i>SLIP ADA
                                    </span>
                                </div>
                            @endif
                            @if($p->payment_proof_link)
                                <a href="{{ $p->payment_proof_link }}" target="_blank" class="btn btn-sm btn-primary mt-1" style="font-size:11px;">
                                    <i class="ri-google-drive-line me-1"></i> Bukti
                                </a>
                                <div class="mt-1">
                                    <span class="badge {{ $p->proof_type === 'Cicilan' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }}" style="font-size:10px;">
                                        {{ $p->proof_type === 'Cicilan' ? '💳 CICILAN' : '✅ PELUNASAN' }}
                                    </span>
                                </div>
                                <small class="text-muted d-block mt-1">{{ $p->proof_submitted_at?->format('d M') ?? '' }}</small>
                            @elseif(!$hasSlip)
                                <span class="text-muted small">—</span>
                            @endif
                        </td>

                        {{-- KOLOM AKSI --}}
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end flex-wrap">
                                <a href="{{ $hasSlip ? route('elearning.staff.pembayaran.slip', $p->id) : route('elearning.staff.pembayaran.slip.create', ['payment_id' => $p->id]) }}"
                                   target="{{ $hasSlip ? '_blank' : '_self' }}"
                                   class="btn btn-sm btn-slip" title="{{ $hasSlip ? 'Cetak ulang slip' : 'Buat slip' }}">
                                    <i class="ri-printer-line me-1"></i>{{ $hasSlip ? 'Cetak' : 'Buat Slip' }}
                                </a>

                                @if($p->status !== 'Lunas')
                                    <form method="POST" action="{{ route('elearning.staff.pembayaran.lunas', $p->id) }}" class="d-inline" onsubmit="return confirm('Tandai LUNAS tagihan ini?')">
                                        @csrf
                                        <button class="btn btn-sm btn-success fw-bold"><i class="ri-check-line me-1"></i>Lunas</button>
                                    </form>
                                @endif

                                @if($p->payment_proof_link)
                                    <form method="POST" action="{{ route('elearning.staff.pembayaran.bukti.destroy', $p->id) }}" class="d-inline"
                                          onsubmit="return confirm('Hapus bukti pembayaran ini?\nMahasiswa dapat mengirim ulang bukti baru.');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-warning" title="Hapus bukti"><i class="ri-eraser-line"></i></button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('elearning.staff.pembayaran.destroy', $p->id) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus tagihan &quot;{{ $p->title }}&quot; milik {{ addslashes($p->display_name) }}?\nTindakan ini PERMANEN!');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus tagihan"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">
                        <i class="ri-inbox-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                        Belum ada data pembayaran.
                        <div class="mt-3">
                            <a href="{{ route('elearning.staff.pembayaran.slip.create') }}" class="btn btn-slip">
                                <i class="ri-printer-line me-1"></i> Buat Slip Pembayaran Pertama
                            </a>
                        </div>
                    </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('paySearch').addEventListener('input', function(){
        const q = this.value.toLowerCase();
        document.querySelectorAll('#payTable tbody tr').forEach(function(tr){
            tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection