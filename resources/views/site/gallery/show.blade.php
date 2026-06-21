@extends('layouts.site')

@section('title', $gallery->title)
@section('description', Str::limit(strip_tags($gallery->description), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">{{ $gallery->title }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($gallery->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Gallery Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Slider Section -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 20px; background: var(--color-white); border-top: none; overflow: hidden;">
                    
                    <div class="swiper gallery-main-swiper bg-dark" style="border-radius: 8px; max-height: 550px; height: 450px;">
                        <div class="swiper-wrapper">
                            @foreach($gallery->images as $image)
                                <div class="swiper-slide d-flex align-items-center justify-content-center h-100">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" class="popup-image w-100 h-100 d-block">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev" style="color: #fff; width: 35px; height: 35px; background: rgba(0,0,0,0.5); border-radius: 50%;"><i class="feather-chevron-left"></i></div>
                        <div class="swiper-button-next" style="color: #fff; width: 35px; height: 35px; background: rgba(0,0,0,0.5); border-radius: 50%;"><i class="feather-chevron-right"></i></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
            </div>

            <!-- Sidebar Info Section -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1);">
                    <div class="rbt-single-widget">
                        <div class="d-flex justify-content-between align-items-center mb--20">
                            <h4 class="title mb--0" style="font-size: 18px; font-weight: 600; color: var(--color-heading);">Detail Album</h4>
                            <a href="{{ route('gallery.index') }}" class="rbt-btn btn-sm btn-border" style="font-size: 11px; padding: 5px 12px; height: auto;"><i class="feather-arrow-left"></i> Kembali</a>
                        </div>
                        
                        <div class="gallery-meta mb--20" style="font-size: 13px; color: var(--color-body); display: flex; flex-direction: column; gap: 8px;">
                            <span><i class="feather-image"></i> Total: <strong>{{ $gallery->images_count }} Foto</strong></span>
                            <span><i class="feather-calendar"></i> Tanggal: <strong>{{ $gallery->created_at->format('d M Y') }}</strong></span>
                            @if($gallery->user)
                                <span><i class="feather-user"></i> Pengunggah: <strong>{{ $gallery->user->name }}</strong></span>
                            @endif
                        </div>

                        <hr class="my-4">

                        <h5 class="mb--10" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">Deskripsi</h5>
                        <p class="text-muted" style="font-size: 14px; line-height: 1.6; text-align: justify;">
                            {{ $gallery->description ?: 'Tidak ada deskripsi untuk album ini.' }}
                        </p>

                        <hr class="my-4">

                        <h5 class="mb--15" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">Semua Foto</h5>
                        <div class="gallery-thumb-list" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
                            @foreach($gallery->images as $image)
                                <div class="gallery-thumb-item" data-slide-index="{{ $loop->index }}" style="aspect-ratio: 1; border-radius: 6px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: 0.2s;">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Gallery Details Area -->

@endsection

@push('scripts')
<style>
.gallery-thumb-item:hover,
.gallery-thumb-item.is-active {
    border-color: var(--color-primary) !important;
    transform: scale(1.05);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gallerySwiperElement = document.querySelector('.gallery-main-swiper');
    if (!gallerySwiperElement) {
        return;
    }

    const thumbs = Array.from(document.querySelectorAll('.gallery-thumb-item'));
    const swiper = new Swiper(gallerySwiperElement, {
        loop: false,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: gallerySwiperElement.querySelector('.swiper-button-next'),
            prevEl: gallerySwiperElement.querySelector('.swiper-button-prev'),
        },
        pagination: {
            el: gallerySwiperElement.querySelector('.swiper-pagination'),
            clickable: true,
        },
        on: {
            slideChange: function () {
                thumbs.forEach(function (thumb, index) {
                    thumb.classList.toggle('is-active', index === swiper.activeIndex);
                });
            }
        }
    });

    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            const index = parseInt(this.getAttribute('data-slide-index'), 10) || 0;
            swiper.slideTo(index);
        });
    });

    if (thumbs.length) {
        thumbs[0].classList.add('is-active');
    }
});
</script>
@endpush
