@extends('layouts.site')

@section('title', 'Hubungi Kami')
@section('meta_description', 'Hubungi kami melalui saluran komunikasi resmi sekolah kami.')

@push('styles')
<style>
.rbt-google-map iframe {
    width: 100% !important;
    height: 550px !important;
    border: 0;
    display: block;
}

.rbt-social-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

@media (max-width: 1199.98px) {
    .rbt-social-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}

@media (max-width: 767.98px) {
    .rbt-social-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}

@media (max-width: 479.98px) {
    .rbt-social-grid {
        grid-template-columns: repeat(1, 1fr);
        gap: 15px;
    }
}

.rbt-social-card {
    background: #ffffff;
    border: 1px solid #eaeaea;
    border-radius: 16px;
    padding: 25px 15px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.rbt-social-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.rbt-social-card .icon {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #f6f6f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    font-size: 22px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.rbt-social-card .title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #1c1d1f;
    transition: all 0.4s ease;
}

.rbt-social-card .description {
    font-size: 13px;
    color: #6b7385;
    margin-bottom: 20px;
    line-height: 1.5;
    transition: all 0.4s ease;
}

.rbt-social-card .action-btn {
    font-size: 13px;
    font-weight: 600;
    color: #059fe1;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.4s ease;
    margin-top: auto;
}

.rbt-social-card .action-btn i {
    transition: transform 0.3s ease;
}

/* Hover behaviors */
.rbt-social-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    border-color: transparent;
}

.rbt-social-card:hover::before {
    opacity: 1;
}

.rbt-social-card:hover .icon {
    background: #ffffff !important;
    transform: scale(1.1);
}

.rbt-social-card:hover .title {
    color: #ffffff;
}

.rbt-social-card:hover .description {
    color: rgba(255, 255, 255, 0.9);
}

.rbt-social-card:hover .action-btn {
    color: #ffffff;
}

.rbt-social-card:hover .action-btn i {
    transform: translateX(5px);
}

/* WhatsApp Styling */
.rbt-social-card.wa-card .icon {
    color: #25D366;
}
.rbt-social-card.wa-card::before {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}
.rbt-social-card.wa-card:hover .icon {
    color: #128C7E;
}
.rbt-social-card.wa-card .action-btn {
    color: #128C7E;
}

/* Instagram Styling */
.rbt-social-card.ig-card .icon {
    color: #E1306C;
}
.rbt-social-card.ig-card::before {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}
.rbt-social-card.ig-card:hover .icon {
    color: #d6249f;
}
.rbt-social-card.ig-card .action-btn {
    color: #cc2366;
}

/* Facebook Styling */
.rbt-social-card.fb-card .icon {
    color: #1877F2;
}
.rbt-social-card.fb-card::before {
    background: linear-gradient(135deg, #1877F2 0%, #0d5bb5 100%);
}
.rbt-social-card.fb-card:hover .icon {
    color: #1877F2;
}
.rbt-social-card.fb-card .action-btn {
    color: #1877F2;
}

/* YouTube Styling */
.rbt-social-card.yt-card .icon {
    color: #FF0000;
}
.rbt-social-card.yt-card::before {
    background: linear-gradient(135deg, #FF0000 0%, #b30000 100%);
}
.rbt-social-card.yt-card:hover .icon {
    color: #FF0000;
}
.rbt-social-card.yt-card .action-btn {
    color: #FF0000;
}

/* Twitter Styling */
.rbt-social-card.tw-card .icon {
    color: #1DA1F2;
}
.rbt-social-card.tw-card::before {
    background: linear-gradient(135deg, #1DA1F2 0%, #0c7eb5 100%);
}
.rbt-social-card.tw-card:hover .icon {
    color: #1DA1F2;
}
.rbt-social-card.tw-card .action-btn {
    color: #1DA1F2;
}
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<!-- <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Hubungi Kami</h2>
                    <p class="mb--20">Hubungi kami melalui saluran komunikasi resmi sekolah kami</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li><div class="icon-right"><i class="feather-chevron-right"></i></div></li>
                        <li class="rbt-breadcrumb-item active">Hubungi Kami</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="rbt-conatct-area bg-gradient-11 rbt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb--60">
                    <span class="subtitle bg-secondary-opacity">HUBUNGI KAMI</span>
                    <h2 class="title">Informasi & Kontak Resmi <br> {{ $settings->institution_name ?? 'Sekolah' }}</h2>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <!-- Phone -->
            @if($settings && $settings->phone)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-phone"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Nomor Telepon</h4>
                            <p><a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></p>
                            @if($settings->whatsapp)
                                <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" rel="noopener">WhatsApp Chat</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Email -->
            @if($settings && $settings->email)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-mail"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Alamat Email</h4>
                            <p><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Address -->
            @if($settings && $settings->address)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-map-pin"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Lokasi Kampus</h4>
                            <p>{{ $settings->address }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="rbt-social-area bg-color-white rbt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb--60">
                    <span class="subtitle bg-primary-opacity">MEDIA SOSIAL</span>
                    <h2 class="title">Kunjungi Media Sosial Resmi Kami</h2>
                    <p class="description">Ikuti perkembangan informasi terbaru, galeri kegiatan, prestasi, serta pengumuman resmi melalui akun media sosial kami.</p>
                </div>
            </div>
        </div>
        <div class="rbt-social-grid">
            @if($settings && $settings->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" rel="noopener" class="d-block h-100">
                    <div class="rbt-social-card wa-card">
                        <div class="icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h4 class="title">WhatsApp</h4>
                        <p class="description">Hubungi kami secara langsung untuk layanan informasi cepat via chat.</p>
                        <span class="action-btn">Kirim Pesan <i class="feather-arrow-right"></i></span>
                    </div>
                </a>
            @endif

            @if($settings && $settings->instagram)
                <a href="{{ $settings->instagram }}" target="_blank" rel="noopener" class="d-block h-100">
                    <div class="rbt-social-card ig-card">
                        <div class="icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <h4 class="title">Instagram</h4>
                        <p class="description">Lihat galeri foto kegiatan, informasi harian, dan dokumentasi sekolah.</p>
                        <span class="action-btn">Ikuti Kami <i class="feather-arrow-right"></i></span>
                    </div>
                </a>
            @endif

            @if($settings && $settings->facebook)
                <a href="{{ $settings->facebook }}" target="_blank" rel="noopener" class="d-block h-100">
                    <div class="rbt-social-card fb-card">
                        <div class="icon">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <h4 class="title">Facebook</h4>
                        <p class="description">Terhubung dengan komunitas alumni, orang tua murid, dan kiriman berita kami.</p>
                        <span class="action-btn">Kunjungi Halaman <i class="feather-arrow-right"></i></span>
                    </div>
                </a>
            @endif

            @if($settings && $settings->youtube)
                <a href="{{ $settings->youtube }}" target="_blank" rel="noopener" class="d-block h-100">
                    <div class="rbt-social-card yt-card">
                        <div class="icon">
                            <i class="fab fa-youtube"></i>
                        </div>
                        <h4 class="title">YouTube</h4>
                        <p class="description">Tonton video profil sekolah, dokumentasi acara besar, dan kreasi siswa kami.</p>
                        <span class="action-btn">Tonton Video <i class="feather-arrow-right"></i></span>
                    </div>
                </a>
            @endif

            @if($settings && $settings->twitter)
                <a href="{{ $settings->twitter }}" target="_blank" rel="noopener" class="d-block h-100">
                    <div class="rbt-social-card tw-card">
                        <div class="icon">
                            <i class="fab fa-twitter"></i>
                        </div>
                        <h4 class="title">Twitter / X</h4>
                        <p class="description">Dapatkan pembaruan berita singkat secara langsung dan real-time.</p>
                        <span class="action-btn">Ikuti Pembaruan <i class="feather-arrow-right"></i></span>
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Map Section -->
@if($settings && $settings->google_map)
    <div class="rbt-google-map bg-color-white rbt-section-gapTop">
        {!! $settings->google_map !!}
    </div>
@endif

@endsection
