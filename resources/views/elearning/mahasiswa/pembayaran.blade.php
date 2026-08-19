@extends('layouts.elearning')
@section('title', 'Rincian Pembayaran')
@section('content')

@php
    $user           = auth('elearning')->user();
    $totalTagihan   = $payments->count();
    $sudahDibayar   = $payments->where('status', 'Lunas')->sum('amount');
    $tunggakan      = $payments->where('status', 'Tunggakan')->sum('amount');
    $lunasCount     = $payments->where('status', 'Lunas')->count();
    $progres        = $totalTagihan > 0 ? round(($lunasCount / $totalTagihan) * 100) : 0;
    $rp             = fn($n) => 'Rp ' . number_format($n, 0, ',', '.');
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-money-dollar-circle-line text-primary"></i> Rincian Pembayaran</h4>
        <p class="text-muted small mb-0">Pantau status pembayaran Anda — lunas atau tunggakan</p>
    </div>
    <span class="badge bg-primary-subtle text-primary fs-6"><i class="ri-graduation-cap-line me-1"></i> {{ $user->nomor_induk ?? '' }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-primary"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-file-list-3-line"></i></div>
        <div><div class="text-muted small">Total Tagihan</div><div class="fw-bold fs-5">{{ $totalTagihan }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-success"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-checkbox-circle-line"></i></div>
        <div><div class="text-muted small">Sudah Dibayar</div><div class="fw-bold fs-5 text-success">{{ $rp($sudahDibayar) }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-danger"><div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-error-warning-line"></i></div>
        <div><div class="text-muted small">Tunggakan</div><div class="fw-bold fs-5 text-danger">{{ $rp($tunggakan) }}</div></div>
    </div></div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3">
        <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Progres Pelunasan</span><strong class="text-primary">{{ $progres }}%</strong></div>
        <div class="progress" style="height:8px;"><div class="progress-bar bg-success" style="width:{{ $progres }}%"></div></div>
        <small class="text-muted d-block mt-2">{{ $lunasCount }} dari {{ $totalTagihan }} tagihan lunas</small>
    </div></div>
</div>

@if($tunggakan > 0)
    <div class="alert alert-danger py-2 small mb-4">
        <i class="ri-error-warning-fill me-1"></i> Anda masih memiliki tunggakan sebesar <strong>{{ $rp($tunggakan) }}</strong>.
        Silakan lakukan pembayaran melalui bagian keuangan, lalu <strong>kirim bukti pembayaran</strong> di bawah.
    </div>
@endif

<div class="el-card card p-4">
    <h6 class="fw-bold mb-3"><i class="ri-list-check-2 text-primary me-1"></i> Daftar Tagihan Saya</h6>
    <div class="table-responsive">
        <table class="table align-middle small mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tagihan</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Bukti Pembayaran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($payments as $p)
                <tr>
                    <td><div class="fw-bold">{{ $p->title }}</div></td>
                    <td>{{ $rp($p->amount) }}</td>
                    <td>{{ $p->due_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        @if($p->status === 'Lunas')
                            <span class="badge bg-success-subtle text-success"><i class="ri-checkbox-circle-line me-1"></i>Lunas</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger"><i class="ri-close-circle-line me-1"></i>Tunggakan</span>
                        @endif
                    </td>
                    <td>
                        @if($p->payment_proof_link)
                            <a href="{{ $p->payment_proof_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="ri-google-drive-line me-1"></i> Lihat Bukti
                            </a>
                            <div class="mt-1">
                                <span class="badge {{ $p->proof_type === 'Lunas' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }}">
                                    {{ $p->proof_type === 'Cicilan' ? '💳 Cicilan' : '✅ Pelunasan' }}
                                </span>
                                <small class="text-muted d-block mt-1">Terkirim {{ $p->proof_submitted_at?->format('d M Y, H:i') ?? '' }} — menunggu verifikasi</small>
                            </div>
                        @else
                            <span class="text-muted">— belum ada bukti —</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($p->status === 'Tunggakan')
                            <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $p->id }}">
                                <i class="ri-upload-cloud-line me-1"></i> Kirim Bukti
                            </button>
                        @else
                            <small class="text-success fw-bold"><i class="ri-checkbox-circle-fill me-1"></i>Selesai</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada tagihan. 🎉</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ═══ MODAL KIRIM BUKTI (satu per tagihan) ═══ --}}
@foreach($payments->where('status', 'Tunggakan') as $p)
    <div class="modal fade" id="buktiModal{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border:none;border-radius:18px;overflow:hidden;">
                <div class="modal-header text-white" style="background:linear-gradient(90deg,#1F57ED,#7A5CF0);">
                    <h6 class="modal-title fw-bold"><i class="ri-upload-cloud-line me-2"></i>Kirim Bukti — {{ $p->title }}</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('elearning.mahasiswa.pembayaran.bukti', $p->id) }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="p-3 rounded-3 mb-3 small" style="background:#F0F9FF;color:#075985;">
                            <i class="ri-information-line me-1"></i>
                            Upload foto bukti bayar/cicilan ke Google Drive, atur akses <em>"Anyone with the link"</em>, lalu paste linknya di sini.
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <select name="proof_type" class="form-select form-select-sm" required>
                                <option value="Lunas">✅ Pelunasan Penuh</option>
                                <option value="Cicilan">💳 Pembayaran Cicilan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Link Google Drive <span class="text-danger">*</span></label>
                            <input type="url" name="payment_proof_link" class="form-control form-control-sm" placeholder="https://drive.google.com/..." value="{{ old('payment_proof_link', $p->payment_proof_link) }}" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label small fw-bold">Catatan (opsional)</label>
                            <textarea name="proof_note" rows="2" class="form-control form-control-sm" placeholder="Contoh: Cicilan ke-2 sebesar Rp 1.000.000">{{ old('proof_note', $p->proof_note) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-3">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary fw-bold"><i class="ri-send-plane-line me-1"></i> Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection