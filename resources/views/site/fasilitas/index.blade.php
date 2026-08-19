@extends('layouts.site')

@section('title', 'Fasilitas Sekolah - Portal Resmi Sekolah')

@section('content')
    <!-- Start Page Title -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <span class="subtitle bg-primary-opacity">SARANA & PRASARANA</span>
                        <h2 class="title">Fasilitas Kampus</h2>
                        <p class="description">Fasilitas dan sarana prasarana yang lengkap dan modern untuk menunjang kegiatan pembelajaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Fasilitas Area -->
    <div class="rbt-facility-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">
                @forelse($fasilitas as $item)
                    @php
                        $images = !empty($item->data6) ? explode(';', $item->data6) : [];
                        $firstImage = count($images) > 0 ? $images[0] : null;
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
                                    <span class="position-absolute top-0 start-0 m-3" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: #ffffff; font-size: 10px; z-index: 5; font-weight: 600; padding: 3px 8px; border-radius: 4px;">
                                        Kapasitas: {{ $item->data4 }}
                                    </span>
                                @endif
                            </div>
                            <div class="rbt-card-body p--15 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="rbt-card-title mb--5" style="font-size: 15px; font-weight: 600; line-height: 1.4;">
                                        {{ $item->data1 }}
                                    </h5>
                                    @if($item->text1)
                                        <p class="rbt-card-text mt--5 text-muted" style="font-size: 13px; line-height: 1.5;">{{ Str::limit(strip_tags($item->text1), 100) }}</p>
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
                                    <!-- Image Gallery -->
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
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselFasilitas{{ $item->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselFasilitas{{ $item->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        @elseif(count($images) === 1)
                                            <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $item->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                                <i class="feather-image fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info Cards -->
                                    <div class="row g-3 mb-4">
                                        @if($item->data2)
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--color-extra2); border: 1px solid var(--color-border-opacity);">
                                                    <div class="d-flex align-items-center justify-content-center bg-primary-opacity rounded-circle" style="width: 40px; height: 40px;">
                                                        <i class="feather-map-pin text-primary"></i>
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
                                                        <i class="feather-users text-success"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block" style="font-size: 11px;">Kapasitas Ruang</small>
                                                        <span class="fw-bold" style="color: var(--color-heading); font-size: 14px;">{{ $item->data4 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Deskripsi -->
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
@endsection