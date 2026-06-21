@extends('layouts.site')

@section('title', 'Testimoni Alumni')

@push('styles')
<style>
    .testimonial-section-title {
        border-bottom: 2px solid var(--color-primary-opacity);
        padding-bottom: 12px;
        margin-bottom: 30px;
        font-weight: 700;
        color: var(--color-heading);
    }
    .testi-alumni-card {
        background: var(--color-white);
        border: 1px solid var(--color-border-opacity);
        border-radius: 12px;
        padding: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--shadow-1);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .testi-alumni-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        border-color: var(--color-primary);
    }
    .testi-quote-icon {
        font-size: 36px;
        color: var(--color-primary);
        opacity: 0.15;
        line-height: 1;
        margin-bottom: 15px;
    }
    .testi-content {
        font-size: 15px;
        line-height: 1.7;
        font-style: italic;
        color: var(--color-body);
        margin-bottom: 25px;
        flex-grow: 1;
    }
    .testi-author-thumb {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--color-primary-opacity);
    }
</style>
@endpush

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Testimoni Alumni</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Tanggapan, Kesan, dan Pesan dari Alumni Sekolah Kami</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Testimoni Alumni</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Testimonials Area -->
<div class="rbt-section-gapBottom mt--50">
    <div class="container">
        @php
            $kuliahTestis = $alumni->where('status_alumni', 'Kuliah');
            $bekerjaTestis = $alumni->where('status_alumni', 'Bekerja');
            $wirausahaTestis = $alumni->where('status_alumni', 'Wirausaha');
            $lainnyaTestis = $alumni->whereNotIn('status_alumni', ['Kuliah', 'Bekerja', 'Wirausaha']);
        @endphp

        <!-- 1. Melanjutkan Kuliah Section -->
        @if($kuliahTestis->count() > 0)
            <div class="testimonial-group-wrapper mb--60">
                <h3 class="testimonial-section-title d-flex align-items-center gap-3">
                    <i class="feather-book-open text-primary" style="font-size: 24px;"></i>
                    Melanjutkan Pendidikan (Kuliah)
                </h3>
                <div class="row g-4">
                    @foreach($kuliahTestis as $alm)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="testi-alumni-card">
                                <div>
                                    <div class="testi-quote-icon"><i class="feather-quote"></i></div>
                                    <p class="testi-content">"{{ $alm->testimoni }}"</p>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3 pt--15" style="border-top: 1px solid var(--color-border-opacity);">
                                    <img class="testi-author-thumb shadow-sm" 
                                         src="{{ $alm->photo ? asset('storage/' . $alm->photo) : asset('assets/site/images/client/user.jpg') }}" 
                                         alt="{{ $alm->name }}">
                                    <div>
                                        <h6 class="mb--0" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h6>
                                        <span class="d-block text-muted" style="font-size: 12px; font-weight: 500;">
                                            Lulusan {{ $alm->tahun_lulus }} • {{ $alm->jurusan?->singkatan ?? 'Umum' }}
                                        </span>
                                        <span class="badge mt--5" style="background: var(--color-primary-opacity); color: var(--color-primary); font-size: 9px; padding: 2px 6px;">
                                            {{ $alm->tempat_kerja }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 2. Sudah Bekerja Section -->
        @if($bekerjaTestis->count() > 0)
            <div class="testimonial-group-wrapper mb--60">
                <h3 class="testimonial-section-title d-flex align-items-center gap-3">
                    <i class="feather-briefcase text-secondary" style="font-size: 24px;"></i>
                    Memasuki Dunia Kerja (Bekerja)
                </h3>
                <div class="row g-4">
                    @foreach($bekerjaTestis as $alm)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="testi-alumni-card">
                                <div>
                                    <div class="testi-quote-icon" style="color: var(--color-secondary);"><i class="feather-quote"></i></div>
                                    <p class="testi-content">"{{ $alm->testimoni }}"</p>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3 pt--15" style="border-top: 1px solid var(--color-border-opacity);">
                                    <img class="testi-author-thumb shadow-sm" 
                                         src="{{ $alm->photo ? asset('storage/' . $alm->photo) : asset('assets/site/images/client/user.jpg') }}" 
                                         alt="{{ $alm->name }}"
                                         style="border-color: var(--color-secondary-opacity);">
                                    <div>
                                        <h6 class="mb--0" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h6>
                                        <span class="d-block text-muted" style="font-size: 12px; font-weight: 500;">
                                            Lulusan {{ $alm->tahun_lulus }} • {{ $alm->jurusan?->singkatan ?? 'Umum' }}
                                        </span>
                                        <span class="badge mt--5" style="background: var(--color-secondary-opacity); color: var(--color-secondary); font-size: 9px; padding: 2px 6px;">
                                            {{ $alm->tempat_kerja }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 3. Wirausaha & Lainnya Section -->
        @if($wirausahaTestis->count() > 0 || $lainnyaTestis->count() > 0)
            <div class="testimonial-group-wrapper">
                <h3 class="testimonial-section-title d-flex align-items-center gap-3">
                    <i class="feather-trending-up text-success" style="font-size: 24px;"></i>
                    Wirausaha & Status Lainnya
                </h3>
                <div class="row g-4">
                    @foreach($wirausahaTestis->merge($lainnyaTestis) as $alm)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="testi-alumni-card">
                                <div>
                                    <div class="testi-quote-icon" style="color: #10b981;"><i class="feather-quote"></i></div>
                                    <p class="testi-content">"{{ $alm->testimoni }}"</p>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3 pt--15" style="border-top: 1px solid var(--color-border-opacity);">
                                    <img class="testi-author-thumb shadow-sm" 
                                         src="{{ $alm->photo ? asset('storage/' . $alm->photo) : asset('assets/site/images/client/user.jpg') }}" 
                                         alt="{{ $alm->name }}"
                                         style="border-color: rgba(16, 185, 129, 0.2);">
                                    <div>
                                        <h6 class="mb--0" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h6>
                                        <span class="d-block text-muted" style="font-size: 12px; font-weight: 500;">
                                            Lulusan {{ $alm->tahun_lulus }} • {{ $alm->jurusan?->singkatan ?? 'Umum' }}
                                        </span>
                                        <span class="badge mt--5" style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 9px; padding: 2px 6px;">
                                            {{ $alm->status_alumni }} @if($alm->tempat_kerja) • {{ $alm->tempat_kerja }}@endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($alumni->count() === 0)
            <div class="row">
                <div class="col-12">
                    <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 12px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border-opacity);">
                        <i class="feather-message-square text-warning mb--15" style="font-size: 48px;"></i>
                        <h5 class="mb--5">Belum Ada Testimoni Alumni</h5>
                        <p class="mb--0 text-muted">Testimoni dari alumni sekolah belum diunggah saat ini.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
