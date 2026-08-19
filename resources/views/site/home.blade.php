@extends('layouts.site')

@section('title', 'Beranda - SIHI')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/site/css/home.css') }}">
<style>
    iframe {
        width: 100% !important;
        height: 100% !important;
        min-height: 320px;
        border: 0;
    }
    .social-embed-wrapper iframe, .social-embed-wrapper blockquote {
        width: 100% !important;
        height: 100% !important;
        border: none;
        margin: 0 !important;
        max-width: 100% !important;
    }
    .social-embed-wrapper {
        position: relative;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
@endpush

@section('content')
    @foreach($sections as $section)
        @if($section->key1 === 'hero_banner')
            <!-- ==================== HERO BANNER SECTION ==================== -->
            <div class="rbt-banner-area rbt-banner-19">
                <div class="wrapper">
                    <div class="swiper rbt-banner-activation-2 rbt-slider-activation rbt-slider-animation rbt-arrow-between">
                        <div class="swiper-wrapper">
                            @forelse($heroBanners as $banner)
                                <div class="swiper-slide">
                                    <div class="rbt-banner-item bg_image" style="background-image: url('{{ $banner->data2 ? asset('storage/' . $banner->data2) : asset('assets/site/images/banner/.jpg') }}'); background-size: cover; background-position: center;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="inner text-start">
                                                        <h6 class="subtitle">
                                                            <span>WELCOME TO SIHI</span>
                                                        </h6>
                                                        <h1 class="title color-white">{{ $banner->data1 }}</h1>
                                                        @if($banner->text1)
                                                            <p class="description color-white">{{ $banner->text1 }}</p>
                                                        @endif
                                                        @if($banner->data3)
                                                            <div class="bottom-content d-flex align-items-center gap-5 flex-wrap">
                                                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ $banner->data4 ?: '#' }}">
                                                                    <span class="icon-reverse-wrapper">
                                                                        <span class="btn-text">{{ $banner->data3 }}</span>
                                                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="rbt-banner-item bg_image" style="background: linear-gradient(135deg, #2F57EF 0%, #C586EE 100%);">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="inner text-start">
                                                        <h6 class="subtitle">
                                                            <span>WELCOME TO SIHI</span>
                                                        </h6>
                                                        <h1 class="title color-white">Mewujudkan Generasi Unggul</h1>
                                                        <p class="description color-white">Selamat datang di website sihi.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="rbt-slider-control">
                            <div class="rbt-swiper-arrow-2 rbt-arrow-left">
                                <span class="icon">
                                    <i class="rbt-icon-top feather-arrow-left"></i>
                                </span>
                                <span class="text">Prev</span>
                            </div>

                            <div class="rbt-swiper-arrow-2 rbt-arrow-right">
                                <span class="text">
                                    Next
                                </span>
                                <span class="icon">
                                    <i class="rbt-icon feather-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'sambutan')
    <!-- ==================== SAMBUTAN KEPALA SEKOLAH SECTION ==================== -->
    <div class="rbt-about-area rbt-section-gapTop overflow-hidden">
        <div class="about-style-4">
            <div class="container">
                <div class="row row--40 mt_dec--40 align-items-center">
                    <!-- Kolom Kiri: Teks Sambutan -->
                    <div class="col-xl-6 col-12 mt--40">
                        <div class="content">
                            <div class="section-title">
                                <h6 class="b2 mb--15">
                                    <span class="theme-gradient">{{ $section->data5 ?? 'Sambutan Kepala Sekolah' }}</span>
                                </h6>
                                <h2 class="title w-600">WELCOME TO SIHI</h2>
                                <p class="mt--20 sambutan-text" style="text-align: justify;">
                                    {!! nl2br(e($section->text1)) !!}
                                </p>
                                <div class="d-flex align-items-center gap-5 flex-wrap mt--30">
                                    <a class="rbt-btn btn-gradient hover-icon-reverse" href="/page/sambutan-kepala-sekolah">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Explore More</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan: Foto Kepala Sekolah -->
                    <div class="col-xl-6 col-12 mt--40">
                        <div class="about-thumb text-center">
                            <div class="shape-1">
                                <img src="{{ asset('assets/site/images/shape/mf-shape-01.png') }}" alt="Shape">
                            </div>
                            <div class="shape-2">
                                <img src="{{ asset('assets/site/images/shape/v-union.png') }}" alt="Shape">
                            </div>
                            <div class="thumb-1">
                                <img src="{{ $section->data2 ? asset('storage/' . $section->data2) : asset('assets/site/images/others/m-banner-men.png') }}" 
                                     alt="{{ $section->data3 ?? 'Kepala Sekolah' }}"
                                     class="img-fluid rounded shadow">
                            </div>
                            <h6 class="title mt--20">{{ $section->data3 ?? 'Kepala Sekolah' }} ({{ $section->data4 ?? 'Kepala Sekolah' }})</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @elseif($section->key1 === 'program_keahlian')
            <!-- ==================== PROGRAM KEAHLIAN SECTION ==================== -->
            <div class="rbt-categories-area rbt-section-gap">
                <div class="container">
                    <div class="position-relative">
                        <div class="row">
                            <div class="col-lg-8 col-md-7 col-12">
                                <div class="section-title">
                                    <h6 class="b2 mb--15"><span class="theme-gradient">Program Studi / Jurusan</span></h6>
                                    <h2 class="title">Program Studi / Jurusan <span><img src="{{ asset('assets/site/images/shape/o-icon-2.png') }}" alt="Cap Icon"></span>  </h2>
                                    <p class="description">{{ $section->text1 }}</p>
                                </div>
                            </div>
                        </div>

                        @if($programKeahlian->count() < 3)
                            <!-- Static Card Style Four Grid for less than 3 majors -->
                            <div class="row row--15 mt--30">
                                @forelse($programKeahlian as $prog)
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt--30" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                        <div class="rbt-card variation-01 rbt-hover card-list-2" style="border: 1px solid var(--color-border-opacity) !important; border-radius: 12px; overflow: hidden; background: var(--color-white); box-shadow: var(--shadow-1);">
                                            <div class="rbt-card-img" style="background: var(--color-light); display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 20px; max-height: 200px; height: 100%;">
                                                <a href="jurusan/{{ $prog->kode }}" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                                                    @if($prog->logo)
                                                        <img src="{{ asset('storage/' . $prog->logo) }}" alt="{{ $prog->nama }}" style="max-height: 130px; max-width: 100%; object-fit: contain;">
                                                    @else
                                                        <img src="{{ asset('assets/site/images/category/image/web-design.jpg') }}" alt="{{ $prog->nama }}" style="max-height: 130px; max-width: 100%; object-fit: cover; border-radius: 6px;">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="rbt-card-body">
                                                @if($prog->singkatan)
                                                    <div class="rbt-category">
                                                        <a href="#" onclick="return false;">{{ $prog->singkatan }}</a>
                                                    </div>
                                                @endif
                                                <h4 class="rbt-card-title">
                                                    <a href="jurusan/{{ $prog->kode }}">{{ $prog->nama }}</a>
                                                </h4>
                                                <p class="rbt-card-text">{{ Str::limit($prog->deskripsi, 120) }}</p>
                                                <div class="rbt-card-bottom">
                                                    <a class="transparent-button" href="jurusan/{{ $prog->kode }}">
                                                        Pelajari Selengkapnya
                                                        <i>
                                                            <svg width="17" height="12" xmlns="http://www.w3.org/2000/svg">
                                                                <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                                    <path d="M10.614 0l5.629 5.629-5.63 5.629"/>
                                                                    <path stroke-linecap="square" d="M.663 5.572h14.594"/>
                                                                </g>
                                                            </svg>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center text-muted">Belum ada Program Keahlian.</div>
                                @endforelse
                            </div>
                        @else
                            <!-- Existing Swiper style -->
                            <div class="category-activation-four-custom swiper pt--50">
                                <div class="swiper-wrapper">
                                    @forelse($programKeahlian as $prog)
                                        <!-- Start Single Item -->
                                        <div class="swiper-slide">
                                            <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center h-100">
                                                <div class="inner">
                                                    <div class="thumbnail" >
                                                        <a href="#">
                                                            @if($prog->logo)
                                                                <img src="{{ asset('storage/' . $prog->logo) }}" alt="{{ $prog->nama }}" >
                                                            @else
                                                                <img src="{{ asset('assets/site/images/category/image/web-design.jpg') }}" alt="{{ $prog->nama }}" >
                                                            @endif
                                                            @if($prog->singkatan)
                                                                <div class="read-more-btn">
                                                                    <span class="rbt-btn btn-sm btn-white radius-round">{{ $prog->singkatan }}</span>
                                                                </div>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="content mt--15">
                                                        <h5 class="title"><a href="jurusan/{{ $prog->kode }}">{{ $prog->nama }}</a></h5>
                                                        <p class="description">{{ Str::limit($prog->deskripsi_singkat, 120) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Single Item -->
                                    @empty
                                        <div class="swiper-slide text-center text-muted">Belum ada Program Keahlian.</div>
                                    @endforelse
                                </div>
                            </div>
                            <!-- pagination -->
                            <div class="d-flex justify-content-center gap-3 rbt-arrow-between mt--30 rbt-categories-pagination-four">
                                <div class="rbt-swiper-arrow style_2 rbt-arrow-left" tabindex="0" role="button">
                                    <div class="custom-overfolow">
                                        <i class="rbt-icon feather-arrow-left"></i>
                                        <i class="rbt-icon-top feather-arrow-left"></i>
                                    </div>
                                </div>

                                <div class="rbt-swiper-arrow style_2 rbt-arrow-right" tabindex="0" role="button">
                                    <div class="custom-overfolow">
                                        <i class="rbt-icon feather-arrow-right"></i>
                                        <i class="rbt-icon-top feather-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'prestasi_siswa')
    <!-- ==================== PRESTASI YAYASAN SECTION ==================== -->
    <div class="rbt-course-area rbt-sec-cir-shadow-1 bg-color-extra2 rbt-section-gap rbt-section-box">
        <div class="gradient-shape-top"></div>
        <div class="gradient-shape-bottom"></div>
        <div class="container">
            <div class="row mb--30">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity justify-content-center">Prestasi & Penghargaan</span>
                        <h2 class="title w-600"><span class="theme-gradient">Prestasi</span> Yayasan</h2>
                        <p class="description">Daftar pencapaian luar biasa yang berhasil diraih oleh institusi kami di berbagai bidang.</p>
                    </div>
                </div>
            </div>

            @if($prestasiSekolah->count() > 0)
                @php
                    $firstSekolah = $prestasiSekolah->first();
                    $otherSekolah = $prestasiSekolah->skip(1)->take(3);
                @endphp
                <div class="row row--15 d-flex align-items-stretch">
                    <!-- Large Card (Left) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex">
                        <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between w-100" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); flex-grow: 1;">
                            <div>
                                <div class="rbt-card-img" style="height: 280px; overflow: hidden; position: relative; background: linear-gradient(135deg, rgba(228, 18, 114, 0.1) 0%, rgba(31, 95, 237, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                    @php
                                        $photosSekolah = $firstSekolah->photo_urls;
                                    @endphp
                                    @if(count($photosSekolah) > 1)
                                        <div id="carouselSekolah-{{ $firstSekolah->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 100%; height: 100%;">
                                            <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                @foreach($photosSekolah as $idx => $url)
                                                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="width: 100%; height: 100%;">
                                                        <img src="{{ $url }}" alt="{{ $firstSekolah->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselSekolah-{{ $firstSekolah->id }}" data-bs-slide="prev" style="border: none; background: none;">
                                                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0px 1px 3px rgba(0,0,0,0.5));"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselSekolah-{{ $firstSekolah->id }}" data-bs-slide="next" style="border: none; background: none;">
                                                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0px 1px 3px rgba(0,0,0,0.5));"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @elseif(count($photosSekolah) === 1)
                                        <img src="{{ $photosSekolah[0] }}" alt="{{ $firstSekolah->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="text-center p-4">
                                            <img src="{{ asset('assets/site/images/icons/trophy.png') }}" alt="Trophy" style="width: 80px; height: auto; animation: pulse 2s infinite; opacity: 0.9;">
                                        </div>
                                    @endif
                                    
                                    <!-- Icon over Image -->
                                    <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Icon" style="position: absolute; top: 15px; right: 15px; z-index: 10; width: 48px; height: 48px; object-fit: contain; pointer-events: none; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.1));">
                                    
                                    <span class="rbt-badge-card position-absolute top-0 start-0 m-3 bg-color-secondary color-white" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                        Yayasan
                                    </span>
                                </div>
                                
                                <div class="rbt-card-body p--30">
                                    <div class="rbt-card-top mb--10 d-flex justify-content-between align-items-center">
                                        <div class="rbt-review" style="font-size: 13px; font-weight: 600; color: var(--color-secondary); display: flex; align-items: center; gap: 5px;">
                                            <i class="feather-award text-warning" style="font-size: 16px;"></i>
                                            <span>{{ $firstSekolah->achiever }}</span>
                                        </div>
                                        @if($firstSekolah->tingkat)
                                            <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px; border: none; line-height: 1;">
                                                {{ $firstSekolah->tingkat->data1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="rbt-card-title mb--15" style="font-size: 20px; line-height: 1.4; font-weight: 700;">
                                        <a href="{{ route('prestasi.show', $firstSekolah->id) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $firstSekolah->title }}</a>
                                    </h3>
                                    <ul class="rbt-meta mb--10" style="font-size: 12px; color: var(--color-body); list-style: none; padding: 0; display: flex; gap: 15px; margin: 0 0 15px 0;">
                                        <li><i class="feather-calendar"></i> {{ $firstSekolah->date ? $firstSekolah->date->format('d M Y') : '-' }}</li>
                                        @if($firstSekolah->organizer)
                                            <li><i class="feather-globe"></i> {{ $firstSekolah->organizer }}</li>
                                        @endif
                                    </ul>
                                    <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($firstSekolah->description), 130) }}</p>
                                </div>
                            </div>
                            
                            <div class="rbt-card-body p--30 pt--0">
                                <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                    <a class="transparent-button" href="{{ route('prestasi.show', $firstSekolah->id) }}" style="font-size: 13px; font-weight: 600; color: var(--color-secondary); display: flex; align-items: center; gap: 6px;">
                                        Detail Prestasi
                                        <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-secondary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                    </a>
                                    @if($firstSekolah->news)
                                        <a class="rbt-btn-link" href="{{ route('berita.show', $firstSekolah->news->slug) }}" style="font-size: 12px; font-weight: 600;"><i class="feather-link"></i> Berita Terkait</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- List Cards (Right) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column gap-3 h-100">
                            @foreach($otherSekolah as $item)
                                <div class="rbt-card card-list variation-02 rbt-hover" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); padding: 16px 20px; margin-top: 0 !important; display: flex; align-items: center; gap: 15px; flex: 1; height: 100%; max-height: none !important; position: relative;">
                                    <div class="rbt-card-img" style="width: 130px; height: 100px; flex-shrink: 0; overflow: hidden; border-radius: 6px; position: relative; background: linear-gradient(135deg, rgba(228, 18, 114, 0.1) 0%, rgba(31, 95, 237, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                        @php
                                            $itemPhotosSekolah = $item->photo_urls;
                                        @endphp
                                        @if(count($itemPhotosSekolah) > 1)
                                            <div id="carouselItem-{{ $item->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="width: 100%; height: 100%;">
                                                <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                    @foreach($itemPhotosSekolah as $idx => $url)
                                                        <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="width: 100%; height: 100%;">
                                                            <img src="{{ $url }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif(count($itemPhotosSekolah) === 1)
                                            <img src="{{ $itemPhotosSekolah[0] }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/site/images/icons/trophy.png') }}" alt="Trophy" style="width: 50px !important; height: auto !important; min-width: auto !important; max-width: 100% !important; opacity: 0.8; margin: auto; display: block;">
                                        @endif
                                    </div>
                                    <div class="rbt-card-body" style="padding: 0 45px 0 0 !important; margin: 0 !important; display: flex; flex-direction: column; justify-content: center; height: 100%; border: none; background: none;">
                                        <div class="d-flex align-items-center gap-2 mb--5">
                                            <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                {{ $item->kategori->data1 ?? 'Penghargaan' }}
                                            </span>
                                            @if($item->tingkat)
                                                <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                    {{ $item->tingkat->data1 }}
                                                </span>
                                            @endif
                                        </div>
                                        <h5 class="rbt-card-title" style="font-size: 16px; line-height: 1.3; font-weight: 600; margin-bottom: 4px;">
                                            <a href="{{ route('prestasi.show', $item->id) }}" style="color: var(--color-heading); transition: 0.3s;">{{ Str::limit($item->title, 55) }}</a>
                                        </h5>
                                        <div style="font-size: 12px; color: var(--color-body); display: flex; flex-direction: column; gap: 1px; margin-bottom: 5px;">
                                            <span><i class="feather-award text-warning me-1"></i> {{ Str::limit($item->achiever, 25) }}</span>
                                            <span><i class="feather-calendar me-1"></i> {{ $item->date ? $item->date->format('d M Y') : '-' }}</span>
                                        </div>
                                        <div class="rbt-card-bottom">
                                            <a class="transparent-button" href="{{ route('prestasi.show', $item->id) }}" style="font-size: 12px; font-weight: 600; color: var(--color-secondary); display: flex; align-items: center; gap: 4px;">
                                                Detail<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-secondary)" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i>
                                            </a>
                                        </div>
                                        
                                        <!-- Absolute Right Icon -->
                                        <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Icon" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 10; width: 42px; height: 42px; object-fit: contain; pointer-events: none; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.08));">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                            <i class="feather-award text-warning mb--15" style="font-size: 48px;"></i>
                            <h5 class="mb--5">Belum Ada Prestasi Yayasan</h5>
                            <p class="mb--0 text-muted">Belum ada data prestasi yayasan yang diterbitkan saat ini.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Button 'View All' -->
            <div class="row mt--60">
                <div class="col-lg-12">
                    <div class="load-more-btn text-center">
                        <a class="rbt-btn btn-gradient btn-lg btn-mobile hover-icon-reverse" href="{{ route('prestasi.index') }}">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Lihat Semua Prestasi</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .rbt-card.card-list.variation-02 {
            transition: all 0.3s ease;
        }
        .rbt-card.card-list.variation-02:hover .animate-icon {
            transform: translateY(-5px);
        }
        .animate-icon {
            transition: transform 0.3s ease;
        }
    </style>

@elseif($section->key1 === 'prestasi_sekolah')
    <!-- Skip since it is combined inside prestasi_siswa -->

        @elseif($section->key1 === 'karya_siswa')
            <!-- ==================== KARYA & PROJEK SISWA SECTION ==================== -->
            <div class="rbt-blog-area bg-color-white rbt-section-gap">
                <div class="container">
                    <div class="row mb--60">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <span class="subtitle bg-primary-opacity justify-content-center">Skill & Keahlian</span>
                                <h2 class="title"><span class="theme-gradient">Keterampilan </span> Skill</h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5">
                        @forelse($karyaSiswa as $karya)
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="rbt-card variation-02 rbt-hover h-100">
                                    <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative;">
                                        @if($karya->data2)
                                            <img src="{{ asset('storage/' . $karya->data2) }}" alt="{{ $karya->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="feather-monitor fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                        @if($karya->data3)
                                            @php
                                                $jur = $programKeahlian->firstWhere('id', $karya->data3);
                                            @endphp
                                            @if($jur)
                                                <span class="rbt-badge-card bg-color-primary-opacity color-primary position-absolute top-0 start-0 m-3">
                                                    {{ $jur->singkatan ?: $jur->kode }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="rbt-card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="rbt-card-title"><a href="#">{{ $karya->data1 }}</a></h5>
                                            <p class="rbt-card-text">{{ Str::limit($karya->text1, 120) }}</p>
                                        </div>
                                        <div class="rbt-card-bottom mt--15">
                                            @if($karya->data4)
                                                @php
                                                    $linkedNews = \App\Models\News::find($karya->data4);
                                                @endphp
                                                @if($linkedNews)
                                                    <a class="transparent-button" href="{{ route('berita.show', $linkedNews->slug) }}">Baca Berita<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#2F57EF" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i></a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">Belum ada karya siswa.</div>
                        @endforelse
                    </div>

                    @if($karyaSiswa->count() > 0)
                        <!-- Button 'View All' -->
                        <div class="row mt--60">
                            <div class="col-lg-12">
                                <div class="load-more-btn text-center">
                                    <a class="rbt-btn btn-gradient btn-lg btn-mobile hover-icon-reverse" href="{{ url('/skill') }}">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Lihat Lainnya</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        @elseif($section->key1 === 'berita_terbaru')
            <!-- ==================== BERITA TERBARU SECTION ==================== -->
            <div class="rbt-blog-area rbt-sec-cir-shadow-1 rbt-section-gap bg-color-extra2 rbt-section-box">
                <div class="gradient-shape-top version-02"></div>
                <div class="gradient-shape-bottom version-02"></div>
                <div class="container">
                    <div class="row g-5 align-items-end mb--40">
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="section-title text-start">
                                <span class="subtitle bg-primary-opacity justify-content-start">Informasi</span>
                                <h2 class="title"><span class="theme-gradient">Informasi & Berita</span> Terkini</h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="load-more-btn text-start text-md-end">
                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('berita.index') }}">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Semua Berita</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row mb--40">
                        <div class="col-lg-12">
                            <div class="rbt-course-tab-button-wrap">
                                <ul class="rbt-course-tab-button nav nav-tabs" id="newsTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="active" id="unggulan-tab" data-bs-toggle="tab" data-bs-target="#unggulan-pane" type="button" role="tab" aria-controls="unggulan-pane" aria-selected="true">
                                            <span class="filter-text">Unggulan</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="terkini-tab" data-bs-toggle="tab" data-bs-target="#terkini-pane" type="button" role="tab" aria-controls="terkini-pane" aria-selected="false">
                                            <span class="filter-text">Terkini</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="akademik-tab" data-bs-toggle="tab" data-bs-target="#akademik-pane" type="button" role="tab" aria-controls="akademik-pane" aria-selected="false">
                                            <span class="filter-text">Akademik</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="kegiatan-tab" data-bs-toggle="tab" data-bs-target="#kegiatan-pane" type="button" role="tab" aria-controls="kegiatan-pane" aria-selected="false">
                                            <span class="filter-text">Kegiatan</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="newsTabContent">
                                
                                @foreach([
                                    'unggulan' => $featuredNews,
                                    'terkini' => $latestNews,
                                    'akademik' => $academicNews,
                                    'kegiatan' => $activityNews
                                ] as $paneId => $newsList)
                                    <div class="tab-pane fade {{ $paneId === 'unggulan' ? 'active show' : '' }}" id="{{ $paneId }}-pane" role="tabpanel" aria-labelledby="{{ $paneId }}-tab">
                                        @if($newsList->count() > 0)
                                            @php
                                                $firstNews = $newsList->first();
                                                $otherNews = $newsList->skip(1)->take(3);
                                            @endphp
                                            <div class="row row--15 d-flex align-items-stretch">
                                                <!-- Large Card (Left) -->
                                                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex">
                                                    <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between w-100" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); flex-grow: 1;">
                                                        <div>
                                                            <div class="rbt-card-img" style="height: 280px; overflow: hidden; position: relative;">
                                                                <a href="{{ route('berita.show', $firstNews->slug) }}">
                                                                    @if($firstNews->image)
                                                                        <img src="{{ asset('storage/' . $firstNews->image) }}" alt="{{ $firstNews->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('assets/site/images/placeholder.jpg') }}" alt="{{ $firstNews->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @endif
                                                                </a>
                                                                <span class="rbt-badge-card position-absolute top-0 start-0 m-3 bg-color-primary color-white" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                                                    {{ $firstNews->category->data1 ?? 'Berita' }}
                                                                </span>
                                                            </div>
                                                            
                                                            <div class="rbt-card-body p--30">
                                                                <ul class="rbt-meta mb--10" style="font-size: 12px; color: var(--color-body); list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 15px; margin: 0 0 15px 0;">
                                                                    <li><i class="feather-calendar"></i> {{ $firstNews->published_at ? $firstNews->published_at->format('d M Y') : '-' }}</li>
                                                                    <li><i class="feather-eye"></i> {{ $firstNews->view_count ?? 0 }}</li>
                                                                    @php
                                                                        $readTimeFirst = ceil(str_word_count(strip_tags($firstNews->content)) / 200);
                                                                    @endphp
                                                                    <li><i class="feather-clock"></i> {{ $readTimeFirst > 0 ? $readTimeFirst : 1 }} mnt</li>
                                                                    <li><i class="feather-user"></i> {{ $firstNews->author ?? 'Admin' }}</li>
                                                                </ul>
                                                                <h3 class="rbt-card-title mb--15" style="font-size: 20px; line-height: 1.4; font-weight: 700;">
                                                                    <a href="{{ route('berita.show', $firstNews->slug) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $firstNews->title }}</a>
                                                                </h3>
                                                                <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($firstNews->excerpt ?? $firstNews->content), 130) }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="rbt-card-body p--30 pt--0">
                                                            <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                                                                <a class="transparent-button" href="{{ route('berita.show', $firstNews->slug) }}" style="font-size: 13px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 6px;">
                                                                    Selengkapnya
                                                                    <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- List Cards (Right) -->
                                                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex flex-column justify-content-between">
                                                    <div class="d-flex flex-column gap-3 h-100">
                                                        @foreach($otherNews as $item)
                                                            <div class="rbt-card card-list variation-02 rbt-hover" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); padding: 16px 20px; margin-top: 0 !important; display: flex; align-items: center; gap: 15px; flex: 1; height: 100%; max-height: none !important; position: relative;">
                                                                <div class="rbt-card-img" style="width: 130px; height: 100px; flex-shrink: 0; overflow: hidden; border-radius: 6px; position: relative;">
                                                                    <a href="{{ route('berita.show', $item->slug) }}">
                                                                        @if($item->image)
                                                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                                                        @else
                                                                            <img src="{{ asset('assets/site/images/placeholder.jpg') }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="rbt-card-body" style="padding: 0 !important; margin: 0 !important; display: flex; flex-direction: column; justify-content: center; height: 100%; border: none; background: none;">
                                                                    <div class="d-flex align-items-center gap-2 mb--5">
                                                                        <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                                            {{ $item->category->data1 ?? 'Berita' }}
                                                                        </span>
                                                                    </div>
                                                                    <h5 class="rbt-card-title" style="font-size: 16px; line-height: 1.3; font-weight: 600; margin-bottom: 4px;">
                                                                        <a href="{{ route('berita.show', $item->slug) }}" style="color: var(--color-heading); transition: 0.3s;">{{ Str::limit($item->title, 55) }}</a>
                                                                    </h5>
                                                                    <div style="font-size: 12px; color: var(--color-body); display: flex; gap: 10px; margin-bottom: 5px;">
                                                                        <span><i class="feather-calendar me-1"></i> {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</span>
                                                                        <span><i class="feather-eye me-1"></i> {{ $item->view_count ?? 0 }}</span>
                                                                        @php
                                                                            $readTimeItem = ceil(str_word_count(strip_tags($item->content)) / 200);
                                                                        @endphp
                                                                        <span><i class="feather-clock me-1"></i> {{ $readTimeItem > 0 ? $readTimeItem : 1 }} mnt</span>
                                                                    </div>
                                                                    <div class="rbt-card-bottom">
                                                                        <a class="transparent-button" href="{{ route('berita.show', $item->slug) }}" style="font-size: 12px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 4px;">
                                                                            Detail<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                                                        <i class="feather-alert-circle text-warning mb--15" style="font-size: 48px;"></i>
                                                        <h5 class="mb--5">Belum Ada Berita</h5>
                                                        <p class="mb--0 text-muted">Belum ada berita yang diterbitkan untuk kategori ini saat ini.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'agenda_event')
            <!-- ==================== AGENDA & EVENT SECTION ==================== -->
            <div class="rbt-event-area bg-color-white rbt-section-gap">
                <div class="container">
                    <div class="row mb--60">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <span class="subtitle bg-primary-opacity justify-content-center">Agenda</span>
                                <h2 class="title"><span class="theme-gradient">Agenda & Event</span> Yayasan</h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5">
                        <!-- Kalender -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="rbt-contact-form contact-form-style-1 max-width-auto shadow-2 p--40" style="background: #fff; border-radius: 10px; border: 1px solid var(--color-border);">
                                <div class="calendar-header d-flex justify-content-between align-items-center mb--25">
                                    <h4 id="currentMonth" class="title mb-0" style="font-size: 18px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--color-heading);">{{ now()->format('F Y') }}</h4>
                                    <div class="calendar-nav d-flex gap-2">
                                        <button type="button" class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border: none; background: #f3f4f6; border-radius: 6px; color: #555; cursor: pointer; transition: 0.2s;" onclick="changeMonth(-1)"><i class="feather-chevron-left" style="font-size: 14px;"></i></button>
                                        <button type="button" class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border: none; background: #f3f4f6; border-radius: 6px; color: #555; cursor: pointer; transition: 0.2s;" onclick="changeMonth(1)"><i class="feather-chevron-right" style="font-size: 14px;"></i></button>
                                    </div>
                                </div>
                                <div class="calendar-body">
                                    <div class="calendar-weekdays mb--15 text-muted" style="display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-size: 12px; font-weight: 600;">
                                        <div class="weekday">Sen</div>
                                        <div class="weekday">Sel</div>
                                        <div class="weekday">Rab</div>
                                        <div class="weekday">Kam</div>
                                        <div class="weekday">Jum</div>
                                        <div class="weekday">Sab</div>
                                        <div class="weekday">Min</div>
                                    </div>
                                    <div class="calendar-dates" id="calendarDates" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; text-align: center;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Event List -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="rbt-contact-form contact-form-style-1 max-width-auto shadow-2 p--40" style="background: #fff; border-radius: 10px; border: 1px solid var(--color-border); min-height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h4 class="title mb--30" style="font-size: 18px; font-weight: 800; color: var(--color-heading); border-bottom: 1px solid var(--color-border); padding-bottom: 15px;">Kegiatan Mendatang</h4>
                                    <div id="eventDetails" class="event-details-content d-flex flex-column gap-3">
                                        @forelse($upcomingEvents as $event)
                                            <div class="event-item p--15 d-flex gap-3 align-items-center" style="background: #f8f9fa; border-radius: 8px; border: 1px solid var(--color-border); cursor: pointer; transition: 0.3s;" onclick="window.location.href='{{ route('agenda.show', $event->slug) }}'">
                                                <div class="event-icon-box d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); width: 46px; height: 46px; border-radius: 8px; flex-shrink: 0;">
                                                    <i class="feather-calendar" style="color: #fff; font-size: 18px;"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <h5 class="rbt-card-title mb--5" style="font-size: 15px; font-weight: 600; line-height: 1.4; margin-bottom: 3px;">
                                                        <a href="{{ route('agenda.show', $event->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ $event->title }}</a>
                                                    </h5>
                                                    <div class="event-meta d-flex gap-3 flex-wrap" style="font-size: 12px; color: var(--color-body);">
                                                        <span><i class="feather-clock" style="color: var(--color-primary); margin-right: 4px;"></i> {{ $event->start_datetime->format('H:i') }} WIB</span>
                                                        <span><i class="feather-map-pin" style="color: var(--color-primary); margin-right: 4px;"></i> {{ Str::limit($event->location ?? 'TBA', 35) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="no-event text-center py-5 text-muted">
                                                <i class="feather-calendar" style="font-size: 48px; color: var(--color-border);"></i>
                                                <p class="mt--15">Tidak ada agenda untuk bulan ini</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                
                                <div class="text-center mt--30">
                                    <a href="{{ route('agenda.index') }}" class="rbt-btn btn-gradient btn-sm" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border: none; color: #fff; font-weight: 600; padding: 12px 30px; border-radius: 6px; display: inline-flex; align-items: center; gap: 8px; justify-content: center;">
                                        Lihat Semua Agenda <i class="feather-arrow-right" style="font-size: 14px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'galeri')
            <!-- ==================== GALERI SECTION ==================== -->
            <style>
                .rbt-card-img:hover .gallery-carousel-control {
                    opacity: 1 !important;
                }
            </style>
            <div class="rbt-gallery-area bg-color-extra2 rbt-section-gap">
                <div class="container">
                    <div class="row mb--40">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <span class="subtitle bg-primary-opacity justify-content-center">Dokumentasi</span>
                                <h2 class="title"><span class="theme-gradient">Galeri</span> Dokumentasi Kegiatan</h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $usedCategoryIds = $galleries->pluck('category_id')->unique()->toArray();
                        $activeCategories = $galleryCategories->filter(function($cat) use ($usedCategoryIds) {
                            return in_array($cat->id, $usedCategoryIds);
                        });
                    @endphp

                    @if($activeCategories->count() > 0)
                    <div class="row mb--40">
                        <div class="col-lg-12">
                            <div class="rbt-course-tab-button-wrap">
                                <ul class="rbt-course-tab-button nav nav-tabs justify-content-center" id="galleryTab" role="tablist" style="border: none;">
                                    <li class="nav-item" role="presentation">
                                        <button class="active" id="all-gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-all-pane" type="button" role="tab" aria-controls="gallery-all-pane" aria-selected="true">
                                            <span class="filter-text">Semua</span>
                                        </button>
                                    </li>
                                    @foreach($activeCategories as $cat)
                                        <li class="nav-item" role="presentation">
                                            <button id="cat-{{ $cat->id }}-tab" data-bs-toggle="tab" data-bs-target="#gallery-cat-{{ $cat->id }}-pane" type="button" role="tab" aria-controls="gallery-cat-{{ $cat->id }}-pane" aria-selected="false">
                                                <span class="filter-text">{{ $cat->data1 }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="galleryTabContent">
                                
                                <!-- Tab Semua -->
                                <div class="tab-pane fade show active" id="gallery-all-pane" role="tabpanel" aria-labelledby="all-gallery-tab">
                                    <div class="row g-5">
                                        @forelse($galleries->take(8) as $gal)
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                                @include('partials.site.gallery-card', ['gal' => $gal])
                                            </div>
                                        @empty
                                            <div class="col-12 text-center text-muted">Belum ada galeri dokumentasi.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Tabs per category -->
                                @foreach($activeCategories as $cat)
                                    @php
                                        $catGalleries = $galleries->where('category_id', $cat->id)->take(8);
                                    @endphp
                                    <div class="tab-pane fade" id="gallery-cat-{{ $cat->id }}-pane" role="tabpanel" aria-labelledby="cat-{{ $cat->id }}-tab">
                                        <div class="row g-5">
                                            @forelse($catGalleries as $gal)
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                                    @include('partials.site.gallery-card', ['gal' => $gal])
                                                </div>
                                            @empty
                                                <div class="col-12 text-center text-muted">Belum ada galeri untuk kategori ini.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            </div>



        @elseif($section->key1 === 'alumni_berprestasi')
            <!-- ==================== ALUMNI BERPRESTASI SECTION ==================== -->
            <div class="rbt-testimonial-area bg-color-white rbt-section-gap">
                <div class="container">
                    <div class="row mb--40">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <span class="subtitle bg-secondary-opacity justify-content-center">Sukses Alumni</span>
                                <h2 class="title">Testimoni & Kisah Inspiratif <span class="theme-gradient">Alumni</span></h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="position-relative">
                        <div class="alumni-swiper-activation swiper ptb--20">
                            <div class="swiper-wrapper">
                                @forelse($alumni as $alm)
                                    <div class="swiper-slide h-auto p-2">
                                        <div class="rbt-testimonial-box h-100" style="box-shadow: var(--shadow-1); border-radius: 12px; border: 1px solid var(--color-border); transition: all 0.3s ease;">
                                            <div class="inner p--30">
                                                <div class="clint-info-wrapper d-flex align-items-center gap-3">
                                                    <div class="thumb" style="width: 65px; height: 65px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--color-primary-opacity);">
                                                        @if($alm->photo)
                                                            <img src="{{ asset('storage/' . $alm->photo) }}" alt="{{ $alm->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                                                                <i class="feather-user text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="client-info">
                                                        <h5 class="title mb--0" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h5>
                                                        <span style="font-size: 12px; color: var(--color-body);">Lulusan {{ $alm->tahun_lulus }}</span>
                                                    </div>
                                                </div>
                                                <div class="description mt--20">
                                                    <div class="d-flex flex-wrap gap-1 mb--15">
                                                        <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px;">
                                                            {{ $alm->status_alumni }}
                                                        </span>
                                                        @if($alm->tempat_kerja)
                                                            <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                {{ $alm->tempat_kerja }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($alm->testimoni)
                                                        <p class="subtitle-3" style="font-size: 13.5px; line-height: 1.6; font-style: italic; color: var(--color-body);">"{{ Str::limit($alm->testimoni, 140) }}"</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide text-center text-muted">Belum ada alumni inspiratif.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Add Arrows Navigation -->
                        <div class="d-flex justify-content-center gap-3 rbt-arrow-between mt--30">
                            <div class="rbt-swiper-arrow style_2 rbt-arrow-left alumni-arrow-left" tabindex="0" role="button">
                                <div class="custom-overfolow">
                                    <i class="rbt-icon feather-arrow-left"></i>
                                    <i class="rbt-icon-top feather-arrow-left"></i>
                                </div>
                            </div>
                            <div class="rbt-swiper-arrow style_2 rbt-arrow-right alumni-arrow-right" tabindex="0" role="button">
                                <div class="custom-overfolow">
                                    <i class="rbt-icon feather-arrow-right"></i>
                                    <i class="rbt-icon-top feather-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'testimoni')
            <!-- ==================== TESTIMONI SECTION ==================== -->
            <div class="rbt-testimonial-area bg-color-white rbt-section-gap">
                <div class="container">
                    <div class="row mb--60">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <span class="subtitle bg-primary-opacity justify-content-center">Testimoni</span>
                                <h2 class="title">{{ $section->data2 ?? 'Tanggapan Mereka' }}</h2>
                                <p class="description">{{ $section->text1 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper testimonial-swiper-activation rbt-dot-bottom-1" style="overflow: hidden; padding-bottom: 20px;">
                        <div class="swiper-wrapper">
                            @forelse($testimonials as $testi)
                                <div class="swiper-slide h-auto p-1">
                                    <div class="rbt-testimonial-box h-100" style="box-shadow: var(--shadow-1); border-radius: 12px; border: 1px solid var(--color-border); transition: all 0.3s ease;">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb" style="width: 70px; height: 70px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                                                    @if($testi->photo)
                                                        <img src="{{ asset('storage/' . $testi->photo) }}" alt="{{ $testi->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                                                            <i class="feather-user text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title" style="font-size: 15px; font-weight: 600; color: var(--color-heading); margin-bottom: 2px;">{{ $testi->name }}</h5>
                                                    <span style="font-size: 12px; color: var(--color-primary); font-weight: 500;">{{ $testi->role }}</span>
                                                </div>
                                            </div>
                                            <div class="description mt--20">
                                                <p class="subtitle-3" style="font-size: 13.5px; line-height: 1.6; font-style: italic; color: var(--color-body); min-height: 80px;">"{{ $testi->content }}"</p>
                                                <div class="rating mt--10">
                                                    @for($i=1; $i<=5; $i++)
                                                        <a href="#" onclick="return false;"><i class="fa{{ $i <= ($testi->rating ?? 5) ? 's' : 'r' }} fa-star" style="color: #ffb700;"></i></a>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide text-center text-muted py-5 w-100">Belum ada testimoni.</div>
                            @endforelse
                        </div>

                        <!-- Navigation controls -->
                        <div class="rbt-swiper-arrow-wrapper mt--40 d-flex justify-content-center gap-3">
                            <div class="rbt-swiper-arrow testimonial-arrow-left" style="cursor: pointer; width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--color-border); display: flex; align-items: center; justify-content: center; background: var(--color-white); color: var(--color-body); transition: all 0.3s ease; box-shadow: var(--shadow-1);">
                                <i class="feather-arrow-left"></i>
                            </div>
                            <div class="rbt-swiper-arrow testimonial-arrow-right" style="cursor: pointer; width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--color-border); display: flex; align-items: center; justify-content: center; background: var(--color-white); color: var(--color-body); transition: all 0.3s ease; box-shadow: var(--shadow-1);">
                                <i class="feather-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'mitra_industri')
            <!-- ==================== MITRA INDUSTRI SECTION ==================== -->
            <div class="rbt-brand-area bg-color-white rbt-section-gapBottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="rbt-brand-title-wrap">
                                <h5 class="rbt-brand-title w-600 text-center mb-0">{{ $section->data2 ?? 'Kemitraan Industri & Dunia Kerja (DUDI)' }}</h5>
                            </div>
                            <ul class="brand-list brand-style-3 justify-content-center mt--30 flex-wrap gap-5">
                                @forelse($mitraIndustri as $mitra)
                                    <li>
                                        <a href="{{ $mitra->data2 ?: '#' }}" target="_blank" class="text-decoration-none">
                                            @if($mitra->data3)
                                                <img src="{{ asset('storage/' . $mitra->data3) }}" alt="{{ $mitra->data1 }}" style="max-height: 50px; object-fit: contain;">
                                            @else
                                                <span class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded text-decoration-none" style="border: 1px solid var(--color-border-opacity); transition: all 0.3s ease; box-shadow: var(--shadow-1);">
                                                    <i class="feather-briefcase text-primary" style="font-size: 16px;"></i>
                                                    <span class="fw-bold" style="font-size: 14px; letter-spacing: 0.5px; color: var(--color-heading);">{{ $mitra->data1 }}</span>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-muted">Belum ada kerja sama industri.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'school_life')
            <!-- ==================== SCHOOL LIFE SECTION ==================== -->
            <div class="rbt-video-area video-section-02 bg-color-white rbt-section-gap">
                <div class="shape-1">
                    <img src="{{ asset('assets/site/images/shape/v-star.png') }}" alt="Star Shape">
                </div>
                <div class="container">
                    <div class="row row--35 align-items-center mt_dec--50">
                        <div class="col-xl-6 col-12 mt--50">
                            <div class="video-popup-wrapper version-02">
                                <div class="v-shape-1">
                                    <img src="{{ asset('assets/site/images/shape/video-dot-01.png') }}" alt="Shape">
                                </div>
                                @if($section->data6 || $section->data7)
                                    <div class="feature-1">
                                        <img src="{{ asset('assets/site/images/icons/video-icon-01.png') }}" alt="Icon">
                                        <div>
                                            <h5 class="number">{{ $section->data6 ?? '99%' }}</h5>
                                            <h6 class="subtitle">{{ $section->data7 ?? 'Satisfied' }}</h6>
                                        </div>
                                    </div>
                                @endif
                                <img class="w-100 rbt-radius" src="{{ $section->data2 ? asset('storage/' . $section->data2) : asset('assets/site/images/others/video-10.jpg') }}" alt="Video Images">
                                <a class="rbt-btn btn-white rounded-player-2 popup-video with-animation position-to-top" href="{{ $section->data3 ?? 'https://www.youtube.com/watch?v=nA1Aqp0sPQo' }}">
                                    <span class="play-icon"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-12 mt--50">
                            <div class="inner">
                                <div class="section-title text-start">
                                    @if($section->data4)
                                        <h6 class="b2 mb--15"><span class="theme-gradient">{{ $section->data4 }}</span></h6>
                                    @endif
                                    @if($section->data5)
                                        <h2 class="title w-600">{{ $section->data5 }}</h2>
                                    @endif
                                </div>

                                <!-- Start Feature List  -->
                                <div class="rbt-feature-wrapper mt--30 ml_dec_20 ml_md--0 ml_sm--0">
                                    @if($section->data8)
                                        <div class="rbt-feature feature-style-2 rv-scale-lg rbt-radius">
                                            <div class="icon bg-pink-opacity">
                                                <i class="{{ $section->data9 ?: 'feather-heart' }}"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h6 class="feature-title">{{ $section->data8 }}</h6>
                                                <p class="feature-description">{{ $section->text1 }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($section->data10)
                                        <div class="rbt-feature feature-style-2 rv-scale-lg rbt-radius">
                                            <div class="icon bg-primary-opacity">
                                                <i class="{{ $section->data11 ?: 'feather-book' }}"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h6 class="feature-title">{{ $section->data10 }}</h6>
                                                <p class="feature-description">{{ $section->text2 }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($section->data12)
                                        <div class="rbt-feature feature-style-2 rv-scale-lg rbt-radius">
                                            <div class="icon bg-secondary-opacity">
                                                <i class="{{ $section->data13 ?: 'feather-award' }}"></i>
                                            </div>
                                            <div class="feature-content">
                                                <h6 class="feature-title">{{ $section->data12 }}</h6>
                                                <p class="feature-description">{{ $section->text3 }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- End Feature List  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'fasilitas')
            <!-- ==================== FASILITAS SEKOLAH SECTION ==================== -->
            <div class="rbt-facility-area bg-color-white rbt-section-gap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center mb--60">
                                <span class="subtitle bg-primary-opacity">{{ $section->data5 ?? 'FASILITAS SEKOLAH' }}</span>
                                <h2 class="title">{{ $section->data1 ?? 'Fasilitas & Sarana Prasarana' }}</h2>
                                @if($section->text1)
                                    <p class="description mt--20">{{ $section->text1 }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row g-5">
                        @forelse($fasilitas as $item)
                            @php
                                $images = !empty($item->data6) ? explode(';', $item->data6) : [];
                                $firstImage = count($images) > 0 ? $images[0] : null;
                            @endphp
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <div class="rbt-card variation-02 rbt-hover h-100" 
                                     style="cursor: pointer;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#fasilitasModal{{ $item->id }}">
                                    <div class="rbt-card-img" style="height: 180px; overflow: hidden; position: relative;">
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                                                <i class="feather-image fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                        @if($item->data4)
                                            <span class="position-absolute top-0 start-0 m-3" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%) !important; color: #ffffff !important; font-size: 10px; z-index: 5; font-weight: 600; padding: 3px 8px; border-radius: 4px;">
                                                Kapasitas: {{ $item->data4 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="rbt-card-body p--15 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="rbt-card-title mb--5" style="font-size: 15px; font-weight: 600; line-height: 1.4;">
                                                <a href="javascript:void(0);" onclick="return false;" style="color: var(--color-heading); text-decoration: none;">{{ $item->data1 }}</a>
                                            </h5>
                                            @if($item->text1)
                                                <p class="rbt-card-text mt--5 text-muted" style="font-size: 13px; line-height: 1.5; margin-bottom: 0;">{{ Str::limit(strip_tags($item->text1), 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail Fasilitas -->
                            <div class="modal fade" id="fasilitasModal{{ $item->id }}" tabindex="-1" aria-labelledby="fasilitasModalLabel{{ $item->id }}" aria-hidden="true" style="z-index: 1050;">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
                                        <div class="modal-header border-bottom p-4" style="background: var(--color-extra2);">
                                            <h5 class="modal-title fw-bold" id="fasilitasModalLabel{{ $item->id }}" style="font-size: 20px; color: var(--color-heading);">{{ $item->data1 }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <!-- Image Gallery Carousel / Single Image -->
                                            <div class="mb-4" style="border-radius: 12px; overflow: hidden; height: 380px; background: var(--color-extra2); position: relative;">
                                                @if(count($images) > 1)
                                                    <div id="carouselFasilitas{{ $item->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 100%; height: 100%;">
                                                        <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                            @foreach($images as $idx => $imgPath)
                                                                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="width: 100%; height: 100%;">
                                                                    <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $item->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFasilitas{{ $item->id }}" data-bs-slide="prev" style="border: none; background: none;">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselFasilitas{{ $item->id }}" data-bs-slide="next" style="border: none; background: none;">
                                                            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                @elseif(count($images) === 1)
                                                    <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $item->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                                        <i class="ri-community-line fs-48 text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row g-3 mb-4">
                                                @if($item->data2)
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--color-extra2); border: 1px solid var(--color-border-opacity);">
                                                            <div class="d-flex align-items-center justify-content-center bg-primary-opacity rounded-circle" style="width: 40px; height: 40px;">
                                                                <i class="feather-map-pin text-primary fs-16"></i>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block" style="font-size: 11px;">Lokasi Ruangan</small>
                                                                <span class="fw-bold" style="color: var(--color-heading); font-size: 14px;">{{ $item->data2 }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($item->data4)
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--color-extra2); border: 1px solid var(--color-border-opacity);">
                                                            <div class="d-flex align-items-center justify-content-center bg-success-opacity rounded-circle" style="width: 40px; height: 40px;">
                                                                <i class="feather-users text-success fs-16"></i>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block" style="font-size: 11px;">Kapasitas Ruang</small>
                                                                <span class="fw-bold" style="color: var(--color-heading); font-size: 14px;">{{ $item->data4 }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($item->text1)
                                                <div class="mt-4 border-top pt-4">
                                                    <h6 class="fw-bold mb-3" style="color: var(--color-heading); font-size: 16px;">Deskripsi Lengkap</h6>
                                                    <div class="text-muted" style="line-height: 1.8; font-size: 14.5px;">
                                                        {!! $item->text1 !!}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-top p-3" style="background: var(--color-extra2);">
                                            <button type="button" class="btn btn-sm btn-secondary radius-round" data-bs-dismiss="modal" style="border: none; padding: 8px 24px; font-weight: 500;">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Data fasilitas belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @elseif($section->key1 === 'faq')
            <!-- ==================== FAQ SECTION ==================== -->
            <div class="rbt-accordion-area accordion-style-1 bg-color-extra2 rbt-section-gap">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="rbt-accordion-style accordion">
                                <div class="section-title text-center mb--60">
                                    <span class="subtitle bg-pink-opacity">{{ $section->data5 ?? 'FAQ' }}</span>
                                    <h2 class="title">{{ $section->data1 ?? 'Frequently Asked Questions' }}</h2>
                                    @if($section->text1)
                                        <p class="description has-medium-font-size mt--20">{{ $section->text1 }}</p>
                                    @endif
                                </div>
                                <div class="rbt-accordion-style rbt-accordion-04 accordion">
                                    <div class="accordion" id="faqAccordionHome">
                                        @forelse($faqs as $index => $faq)
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header card-header" id="headingFaq{{ $faq->id }}">
                                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                                            type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#collapseFaq{{ $faq->id }}" 
                                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                                            aria-controls="collapseFaq{{ $faq->id }}">
                                                        {{ $faq->data1 }}
                                                    </button>
                                                </h2>
                                                <div id="collapseFaq{{ $faq->id }}" 
                                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                                     aria-labelledby="headingFaq{{ $faq->id }}" 
                                                     data-bs-parent="#faqAccordionHome">
                                                    <div class="accordion-body card-body">
                                                        {!! nl2br(e($faq->text1)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center p-4">
                                                <p class="text-muted">Belum ada FAQ yang dipublikasikan.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($section->key1 === 'social_media')
            <!-- ==================== SOCIAL MEDIA SECTION ==================== -->
            @if($socialMedia)
                @php
                    $activeSocials = [];
                    if (($socialMedia->data2 ?? '0') === '1' && ($socialMedia->text1 ?? '')) $activeSocials[] = ['type' => 'instagram', 'title' => 'Instagram', 'icon' => 'instagram', 'color' => '#E1306C', 'url' => $socialMedia->data1, 'embed' => $socialMedia->text1];
                    if (($socialMedia->data4 ?? '0') === '1' && ($socialMedia->text2 ?? '')) $activeSocials[] = ['type' => 'youtube', 'title' => 'YouTube', 'icon' => 'youtube', 'color' => '#FF0000', 'url' => $socialMedia->data3, 'embed' => $socialMedia->text2];
                    if (($socialMedia->data6 ?? '0') === '1' && ($socialMedia->text3 ?? '')) $activeSocials[] = ['type' => 'facebook', 'title' => 'Facebook', 'icon' => 'facebook', 'color' => '#1877F2', 'url' => $socialMedia->data5, 'embed' => $socialMedia->text3];
                    if (($socialMedia->data8 ?? '0') === '1' && ($socialMedia->text4 ?? '')) $activeSocials[] = ['type' => 'tiktok', 'title' => 'TikTok', 'icon' => 'music', 'color' => '#000000', 'url' => $socialMedia->data7, 'embed' => $socialMedia->text4];
                    
                    $count = count($activeSocials);
                    $colClass = match($count) {
                        1 => 'col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12',
                        2 => 'col-lg-6 col-md-6 col-12',
                        3 => 'col-lg-4 col-md-6 col-12',
                        default => 'col-lg-3 col-md-6 col-12' // 4 or more
                    };
                @endphp
                @if($count > 0)
                    <div class="rbt-social-feed-area bg-color-white rbt-section-gap">
                        <div class="container">
                            <div class="row mb--45">
                                <div class="col-lg-12">
                                    <div class="section-title text-center">
                                        <span class="subtitle bg-primary-opacity">{{ $section->data2 ?? 'Koneksi Sosial' }}</span>
                                        <h2 class="title">{{ $section->data1 ?? 'Kanal Media Sosial Resmi' }}</h2>
                                        @if($section->text1)
                                            <p class="description mt--20" style="font-size: 15px; color: var(--color-body);">{{ $section->text1 }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 justify-content-center">
                                @foreach($activeSocials as $social)
                                    <div class="{{ $colClass }}">
                                        <div class="rbt-card variation-01 rbt-hover p--20 d-flex flex-column h-100" style="border-radius: 12px; border: 1px solid var(--color-border); background: var(--color-white); box-shadow: var(--shadow-1);">
                                            <div class="rbt-card-body p--0 flex-grow-1 d-flex flex-column">
                                                <h5 class="title mb--15 d-flex align-items-center gap-2" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">
                                                    <i class="feather-{{ $social['icon'] }}" style="font-size: 20px; color: {{ $social['color'] }};"></i> {{ $social['title'] }}
                                                </h5>
                                                <div class="social-embed-wrapper flex-grow-1" style="border-radius: 8px; overflow: hidden; border: 1px solid var(--color-border-opacity); background: var(--color-extra2); height: 420px; min-height: 420px; display: flex; align-items: center; justify-content: center;">
                                                    {!! $social['embed'] !!}
                                                </div>
                                                <div class="text-center mt--15" style="border-top: 1px solid var(--color-border-opacity); padding-top: 12px;">
                                                    <a href="{{ $social['url'] ?: '#' }}" target="_blank" class="rbt-btn-link text-primary d-inline-flex align-items-center gap-1" style="font-size: 13px; font-weight: 600;">
                                                        Kunjungi {{ $social['title'] }} <i class="feather-external-link" style="font-size: 13px;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    @endforeach
@endsection

@push('scripts')
<script src="{{ asset('assets/site/js/home.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const initialEvents = @json($upcomingEvents);
    const apiUrl = '{{ route('api.events.by-month') }}';
    if (typeof initCalendar === 'function') {
        initCalendar(initialEvents, apiUrl);
    }

    if (typeof Swiper !== 'undefined') {
        new Swiper(".category-activation-four-custom", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".rbt-arrow-right",
                prevEl: ".rbt-arrow-left",
                clickable: true,
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                },
                481: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });

        new Swiper(".alumni-swiper-activation", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".alumni-arrow-right",
                prevEl: ".alumni-arrow-left",
                clickable: true,
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
            },
        });

        new Swiper(".testimonial-swiper-activation", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".testimonial-arrow-right",
                prevEl: ".testimonial-arrow-left",
                clickable: true,
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
            },
        });
    }
});
</script>
@endpush
