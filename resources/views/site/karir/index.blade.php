@extends('layouts.site')
@section('title', 'Job Career')
@section('content')

<style>
    .kr-hero{background:linear-gradient(135deg,#13294B 0%,#1F57ED 45%,#7A5CF0 100%);position:relative;overflow:hidden;padding:90px 0 100px;color:#fff;}
    .kr-hero::before{content:'';position:absolute;width:420px;height:420px;border-radius:50%;background:rgba(255,255,255,.06);top:-160px;right:-120px;}
    .kr-hero::after{content:'';position:absolute;width:260px;height:260px;border-radius:50%;background:rgba(255,209,102,.14);bottom:-120px;left:-80px;}
    .kr-chip{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25);border-radius:50px;padding:8px 18px;font-size:12px;font-weight:700;letter-spacing:1px;}
    .kr-stat{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.22);border-radius:16px;padding:16px 20px;backdrop-filter:blur(8px);}
    .kr-soft{background:#E4E9FF;color:#1F57ED;border-radius:50px;padding:6px 16px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;}
    .kr-job{border:none;border-radius:18px;overflow:hidden;box-shadow:0 6px 24px rgba(19,41,67,.08);transition:all .3s;background:#fff;height:100%;}
    .kr-job:hover{transform:translateY(-8px);box-shadow:0 16px 40px rgba(19,41,67,.16);}
    .kr-job .ph{position:relative;height:170px;overflow:hidden;background:#EEF2FF;}
    .kr-job .ph img{width:100%;height:100%;object-fit:cover;transition:transform .5s;}
    .kr-job:hover .ph img{transform:scale(1.07);}
    .kr-job .ph .st{position:absolute;top:12px;left:12px;background:#059669;color:#fff;font-size:10px;font-weight:800;padding:5px 12px;border-radius:50px;}
    .kr-job .bd{padding:20px;}
    .kr-meta{display:inline-flex;align-items:center;gap:5px;background:#F1F5F9;color:#475569;font-size:11px;font-weight:600;border-radius:8px;padding:4px 10px;}
    .kr-btn-grad{background:linear-gradient(90deg,#1F57ED,#7A5CF0);color:#fff;border:none;border-radius:12px;font-weight:700;padding:10px 18px;font-size:13px;display:inline-flex;align-items:center;gap:6px;text-decoration:none;}
    .kr-btn-grad:hover{color:#fff;filter:brightness(1.12);transform:translateY(-1px);}
    .kr-btn-line{border:1.5px solid #E2E8F0;color:#475569;border-radius:12px;font-weight:600;padding:9px 16px;font-size:13px;display:inline-flex;align-items:center;gap:6px;text-decoration:none;background:#fff;}
    .kr-btn-line:hover{border-color:#1F57ED;color:#1F57ED;}
    .kr-form-card{border:none;border-radius:22px;box-shadow:0 20px 60px rgba(19,41,67,.12);overflow:hidden;}
    .kr-form-head{background:linear-gradient(90deg,#1F57ED,#7A5CF0);color:#fff;padding:22px 28px;}
    .kr-step-n{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#1F57ED,#7A5CF0);color:#fff;font-weight:800;display:flex;align-items:center;justify-content:center;font-size:18px;margin:0 auto 12px;box-shadow:0 8px 20px rgba(31,87,237,.35);}
</style>

{{-- ═══ HERO ═══ --}}
<section class="kr-hero">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="kr-chip mb-4"><i class="ri-briefcase-4-line"></i> WE ARE HIRING!</span>
                <h1 class="fw-bold mb-3" style="letter-spacing:-1px;">Bangun Karir & <span style="color:#FFD166;">Masa Depan</span> Bersama SIHI</h1>
                <p class="mb-4" style="opacity:.88;max-width:560px;">Bergabunglah dengan jaringan mitra industri Subang International Hotel Institute. Temukan lowongan terbaru dari perusahaan hospitality berstandar internasional.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#lowongan" class="kr-btn-grad" style="background:#fff;color:#13294B;"><i class="ri-search-eye-line"></i> Lihat Lowongan</a>
                    <a href="#talent-pool" class="kr-btn-line" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.3);color:#fff;">Kirim Lamaran Umum</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6"><div class="kr-stat text-center"><div class="fs-3 fw-bold" style="color:#FFD166;">{{ $postings->count() }}</div><div class="small" style="opacity:.8;">Posisi Terbuka</div></div></div>
                    <div class="col-6"><div class="kr-stat text-center"><div class="fs-3 fw-bold" style="color:#7CF5C8;">{{ $postings->unique('company_name')->count() }}</div><div class="small" style="opacity:.8;">Perusahaan Mitra</div></div></div>
                    <div class="col-12"><div class="kr-stat text-center"><div class="fs-4 fw-bold">100%</div><div class="small" style="opacity:.8;">Komitmen Pengembangan Karir</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ LOWONGAN TERBUKA ═══ --}}
<section id="lowongan" class="py-5" style="background:#F6F8FF;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="kr-soft">Career Opportunities</span>
            <h2 class="fw-bold mt-3">Posisi yang <span style="color:#1F57ED;">Sedang Terbuka</span></h2>
        </div>
        <div class="row g-4">
            @forelse($postings as $p)
                <div class="col-md-6 col-lg-4">
                    <div class="kr-job">
                        <div class="ph">
                            @if($p->company_photo)
                                <img src="{{ asset('storage/' . $p->company_photo) }}" alt="{{ $p->company_name }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="color:#1F57ED;font-size:52px;"><i class="ri-building-2-line"></i></div>
                            @endif
                            <span class="st">● DIBUKA</span>
                        </div>
                        <div class="bd">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="fw-bold" style="color:#13294B;">{{ $p->company_name }}</div>
                                @if($p->company_website)
                                    <a href="{{ $p->company_website }}" target="_blank" class="small fw-bold text-primary text-decoration-none" title="Kunjungi website perusahaan">
                                        <i class="ri-global-line"></i> Website
                                    </a>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-2" style="color:#1F57ED;">{{ $p->position }}</h5>
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                @if($p->employment_type)<span class="kr-meta"><i class="ri-time-line"></i>{{ $p->employment_type }}</span>@endif
                                @if($p->location)<span class="kr-meta"><i class="ri-map-pin-line"></i>{{ $p->location }}</span>@endif
                            </div>
                            @if($p->description)
                                <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($p->description, 90) }}</p>
                            @endif
                            <a href="{{ route('karir.index', ['posisi' => $p->id]) }}#talent-pool" class="kr-btn-grad w-100 justify-content-center">
                                <i class="ri-send-plane-line"></i> Lamar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="ri-briefcase-line d-block mb-3" style="font-size:56px;opacity:.25;"></i>
                    <h5 class="fw-bold text-muted">Belum ada lowongan terbuka</h5>
                    <p class="text-muted">Kirimkan lamaran umum Anda melalui form di bawah untuk masuk ke Talent Pool kami.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══ ALUR REKRUTMEN ═══ --}}
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="kr-soft">Recruitment Process</span>
            <h2 class="fw-bold mt-3">Alur <span style="color:#7A5CF0;">Rekrutmen</span></h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6"><div class="kr-step-n">1</div><div class="fw-bold">Kirim Lamaran</div><small class="text-muted">Isi form & lampirkan link Google Drive berkas Anda.</small></div>
            <div class="col-md-3 col-6"><div class="kr-step-n">2</div><div class="fw-bold">Seleksi & Interview</div><small class="text-muted">Verifikasi berkas dan wawancara bersama tim Manajemen SIHI.</small></div>
            <div class="col-md-3 col-6"><div class="kr-step-n">3</div><div class="fw-bold">Tes Praktik</div><small class="text-muted">Micro-teaching / tes skill sesuai posisi.</small></div>
            <div class="col-md-3 col-6"><div class="kr-step-n">4</div><div class="fw-bold">Offering & Onboarding</div><small class="text-muted">Selamat anda akan ditempatkan sesuai dengan posisi yang anda lamar!</small></div>
        </div>
    </div>
</section>

{{-- ═══ FORM LAMARAN (TALENT POOL) ═══ --}}
<section id="talent-pool" class="py-5" style="background:#F6F8FF;">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <span class="kr-soft">Talent Pool</span>
                <h2 class="fw-bold mt-3 mb-3">Tidak Menemukan Posisi yang Cocok?</h2>
                <p class="text-muted mb-4">Kirimkan berkas Anda via <strong>Google Drive</strong> dan bergabunglah dengan <strong>Talent Pool SIHI</strong>. Kami akan menghubungi Anda ketika ada posisi yang sesuai dengan keahlian Anda.</p>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:#E4E9FF;color:#1F57ED;"><i class="ri-mail-line"></i></div>
                    <strong>sihi.online@gmail.com</strong>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:#ECFDF5;color:#059669;"><i class="ri-phone-line"></i></div>
                    <strong>+62821-2323-0470</strong>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="kr-form-card">
                    <div class="kr-form-head">
                        <h5 class="fw-bold mb-0"><i class="ri-file-paper-2-line me-2"></i>Form Lamaran Online</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if(session('success'))<div class="alert alert-success py-2 small">{{ session('success') }}</div>@endif
                        @if(session('error'))<div class="alert alert-danger py-2 small">{{ session('error') }}</div>@endif
                        @if($errors->any())<div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>@endif

                        <form method="POST" action="{{ route('karir.apply') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="whatsapp" class="form-control" placeholder="628xxxxxxxxxx" value="{{ old('whatsapp') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Posisi yang Dilamar</label>
                                    <select name="job_posting_id" class="form-select">
                                        <option value="">Lamaran Umum (Talent Pool)</option>
                                        @foreach($postings as $p)
                                            <option value="{{ $p->id }}" {{ (string) request('posisi') === (string) $p->id ? 'selected' : '' }}>
                                                {{ $p->position }} — {{ $p->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Link Google Drive Berkas (CV, dll) <span class="text-danger">*</span></label>
                                    <input type="url" name="drive_link" class="form-control" placeholder="https://drive.google.com/..." value="{{ old('drive_link') }}" required>
                                    <small class="text-muted">Upload CV & berkas Anda ke Google Drive, atur akses <em>"Anyone with the link"</em>, lalu paste linknya di sini.</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Perkenalan Singkat</label>
                                    <textarea name="intro" rows="3" class="form-control" placeholder="Ceritakan singkat keahlian & pengalaman Anda...">{{ old('intro') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button class="kr-btn-grad w-100 justify-content-center py-3">
                                        <i class="ri-send-plane-line"></i> KIRIM LAMARAN
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection