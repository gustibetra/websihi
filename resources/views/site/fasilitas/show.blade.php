@extends('layouts.site')

@section('title', $fasilitas->data1 . ' - Portal Resmi Sekolah')

@section('content')
    @php
        $images = !empty($fasilitas->data6) ? explode(';', $fasilitas->data6) : [];
    @endphp

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-area rbt-breadcrumb-10 bg-image" style="background-image: url('{{ asset('assets/site/images/bg/bg-image-6.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">{{ $fasilitas->data1 }}</h2>
                        <ul class="bradcrumb-nav">
                            <li class="bradcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="bradcrumb-item"><a href="{{ route('fasilitas.index') }}">Fasilitas</a></li>
                            <li class="bradcrumb-item current">{{ $fasilitas->data1 }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="rbt-about-area rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    @if(count($images) > 1)
                        <div id="carouselFasilitasDetail" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" style="border-radius: 12px; overflow: hidden; height: 500px;">
                                @foreach($images as $idx => $imgPath)
                                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $imgPath) }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="{{ $fasilitas->data1 }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFasilitasDetail" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselFasilitasDetail" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    @elseif(count($images) === 1)
                        <img src="{{ asset('storage/' . $images[0]) }}" class="img-fluid rounded" style="width: 100%; max-height: 500px; object-fit: cover;" alt="{{ $fasilitas->data1 }}">
                    @endif
                </div>

                <div class="col-lg-8">
                    <h1 class="mb-4">{{ $fasilitas->data1 }}</h1>
                    @if($fasilitas->text1)
                        <div style="line-height: 1.8; font-size: 15px;">
                            {!! $fasilitas->text1 !!}
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-4">Informasi Fasilitas</h5>
                        @if($fasilitas->data2)
                            <div class="d-flex align-items-center gap-3 p-3 mb-3 rounded" style="background: var(--color-extra2);">
                                <div class="d-flex align-items-center justify-content-center bg-primary-opacity rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="feather-map-pin text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Lokasi Ruangan</small>
                                    <span class="fw-bold">{{ $fasilitas->data2 }}</span>
                                </div>
                            </div>
                        @endif
                        @if($fasilitas->data4)
                            <div class="d-flex align-items-center gap-3 p-3 mb-3 rounded" style="background: var(--color-extra2);">
                                <div class="d-flex align-items-center justify-content-center bg-success-opacity rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="feather-users text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Kapasitas Ruang</small>
                                    <span class="fw-bold">{{ $fasilitas->data4 }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('fasilitas.index') }}" class="btn btn-primary w-100 mt-3">
                        <i class="feather-arrow-left me-2"></i> Kembali ke Daftar Fasilitas
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection