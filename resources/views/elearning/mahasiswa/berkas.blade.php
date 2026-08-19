@extends('layouts.elearning')
@section('title', 'Ruang Berkas')
@section('content')

<style>
    .doc-hero{background:linear-gradient(135deg,#13294B 0%,#1F57ED 55%,#7A5CF0 100%);border-radius:20px;color:#fff;padding:28px 32px;position:relative;overflow:hidden;margin-bottom:24px;}
    .doc-hero::before{content:'';position:absolute;width:280px;height:280px;background:rgba(255,255,255,.07);border-radius:50%;top:-100px;right:-70px;}
    .doc-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);border-radius:50px;padding:6px 14px;font-size:12px;font-weight:600;}
    .doc-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);}
    .doc-item{border:1px solid #EEF2FF;border-radius:14px;padding:14px;background:#FBFCFF;}
</style>

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>@endif

<div class="doc-hero">
    <div class="position-relative" style="z-index:2;">
        <span class="doc-chip mb-3"><i class="ri-folder-zip-line"></i> Ruang Berkas Digital</span>
        <h3 class="fw-bold mb-2">Kirim Berkas Anda 📁</h3>
        <p class="mb-3" style="opacity:.85;font-size:14px;">Kirim CV, KTP, transkrip, dan berkas lain via link Google Drive. Berkas otomatis diterima staff Administrasi & Keuangan.</p>
        <div class="d-flex gap-2 flex-wrap">
            <span class="doc-chip"><i class="ri-google-drive-line"></i> Pengiriman via Google Drive</span>
            <span class="doc-chip"><i class="ri-shield-check-line"></i> Ditinjau langsung oleh staff</span>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- FORM KIRIM --}}
    <div class="col-lg-4">
        <div class="doc-card card p-4">
            <h6 class="fw-bold mb-3"><i class="ri-send-plane-line text-primary me-1"></i> Kirim Berkas Baru</h6>
            <form method="POST" action="{{ route('elearning.mahasiswa.berkas.store') }}">
                @csrf
                <div class="mb-2">
                    <label class="form-label small fw-bold">Nama Berkas <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Contoh: CV Terbaru 2026" required value="{{ old('title') }}">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Jenis Berkas</label>
                    <select name="category" class="form-select form-select-sm">
                        <option value="CV / Resume">📄 CV / Resume</option>
                        <option value="KTP">🪪 KTP</option>
                        <option value="Kartu Mahasiswa">🎓 Kartu Mahasiswa</option>
                        <option value="Transkrip Nilai">📊 Transkrip Nilai</option>
                        <option value="SKCK">🛡️ SKCK</option>
                        <option value="Sertifikat">🏅 Sertifikat</option>
                        <option value="Lainnya">📎 Lainnya</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Link Google Drive <span class="text-danger">*</span></label>
                    <input type="url" name="drive_link" class="form-control form-control-sm" placeholder="https://drive.google.com/..." required value="{{ old('drive_link') }}">
                    <small class="text-muted">Atur akses: <em>"Anyone with the link"</em></small>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Catatan (opsional)</label>
                    <textarea name="notes" rows="2" class="form-control form-control-sm" placeholder="Catatan untuk staff...">{{ old('notes') }}</textarea>
                </div>
                <button class="btn btn-sm btn-primary fw-bold w-100"><i class="ri-send-plane-line me-1"></i> Kirim Berkas</button>
            </form>
        </div>
    </div>

    {{-- DAFTAR BERKAS SAYA --}}
    <div class="col-lg-8">
        <div class="doc-card card p-4">
            <h6 class="fw-bold mb-3"><i class="ri-folder-line text-primary me-1"></i> Berkas Saya ({{ $documents->count() }})</h6>
            @forelse($documents as $d)
                <div class="doc-item mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-bold small">{{ $d->title }}</div>
                            <small class="text-muted">{{ $d->category ?? 'Lainnya' }} • {{ $d->submitted_at?->format('d M Y, H:i') ?? '-' }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($d->status === 'Diverifikasi')
                                <span class="badge bg-success-subtle text-success"><i class="ri-checkbox-circle-line me-1"></i>Diverifikasi</span>
                            @elseif($d->status === 'Ditolak')
                                <span class="badge bg-danger-subtle text-danger"><i class="ri-close-circle-line me-1"></i>Ditolak</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning"><i class="ri-time-line me-1"></i>Menunggu Review</span>
                            @endif
                            <a href="{{ $d->drive_link }}" target="_blank" class="btn btn-sm btn-light" title="Buka Drive"><i class="ri-google-drive-line"></i></a>
                            <form method="POST" action="{{ route('elearning.mahasiswa.berkas.destroy', $d->id) }}" onsubmit="return confirm('Hapus berkas &quot;{{ $d->title }}&quot;?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        </div>
                    </div>
                    @if($d->feedback)
                        <div class="mt-2 p-2 rounded-3 small" style="background:#EEF2FF;color:#1E40AF;">
                            <i class="ri-chat-3-line me-1"></i><strong>Feedback staff:</strong> {{ $d->feedback }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="ri-folder-open-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                    Belum ada berkas terkirim. Kirim berkas pertama Anda lewat form di samping.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection