@extends('layouts.site')

@section('title', 'Galeri Dokumentasi')
@section('description', 'Koleksi dokumentasi foto kegiatan sekolah')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Galeri Dokumentasi</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Koleksi Dokumentasi Foto Kegiatan Sekolah</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Galeri</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Gallery Grid Area -->
<style>
    .rbt-card-img:hover .gallery-carousel-control {
        opacity: 1 !important;
    }
    /* Gallery Filter Strip — clean inline, no card */
    .gallery-filter-strip {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 36px;
        padding: 0;
    }
    .gallery-filter-strip .filter-prefix {
        font-size: 12px;
        font-weight: 700;
        color: var(--color-body);
        text-transform: uppercase;
        letter-spacing: 0.7px;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-right: 4px;
        white-space: nowrap;
    }
    .gallery-filter-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    .gallery-filter-tags a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 500;
        border: 1.5px solid var(--color-border);
        background: var(--color-white);
        color: var(--color-body);
        text-decoration: none;
        transition: all 0.25s ease;
        white-space: nowrap;
    }
    .gallery-filter-tags a:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
        background: var(--color-primary-opacity, rgba(31,95,237,0.08));
        transform: translateY(-1px);
    }
    .gallery-filter-tags a.active {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(31,95,237,0.25);
    }
    .gallery-filter-tags a.active:hover {
        background: var(--color-primary);
        color: #fff;
        transform: translateY(-1px);
    }
    .gallery-filter-tags .filter-count {
        font-size: 11px;
        font-weight: 700;
        background: rgba(255,255,255,0.25);
        padding: 1px 6px;
        border-radius: 20px;
        line-height: 1.5;
    }
    .gallery-filter-tags a:not(.active) .filter-count {
        background: var(--color-border);
        color: var(--color-body);
    }
</style>
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">

        {{-- Filter Strip --}}
        @if($categories->count() > 0)
        <div class="gallery-filter-strip">
            <span class="filter-prefix"><i class="ri-filter-3-line"></i> Filter:</span>
            <div class="gallery-filter-tags">
                <a href="{{ route('gallery.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                    <i class="ri-grid-fill" style="font-size:15px;"></i>
                    Semua Album
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('gallery.index', ['category' => $cat->id]) }}" class="{{ request('category') == $cat->id ? 'active' : '' }}">
                        <i class="ri-image-line" style="font-size:15px;"></i>
                        {{ $cat->data1 }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="row g-5">
            @forelse($galleries as $gallery)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    @include('partials.site.gallery-card', ['gal' => $gallery])
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                        <i class="feather-image text-warning mb--15" style="font-size: 48px;"></i>
                        <h5 class="mb--5">Belum Ada Galeri</h5>
                        <p class="mb--0 text-muted">Belum ada album galeri dokumentasi kegiatan sekolah yang diterbitkan saat ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
            <div class="row">
                <div class="col-lg-12 mt--60">
                    <nav>
                        <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                            @if ($galleries->onFirstPage())
                                <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                            @else
                                <li><a href="{{ $galleries->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                            @endif

                            @php
                                $start = max(1, $galleries->currentPage() - 3);
                                $end = min($galleries->lastPage(), $galleries->currentPage() + 3);
                            @endphp

                            @if($start > 1)
                                <li><a href="{{ $galleries->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                @endif
                            @endif

                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $galleries->currentPage())
                                    <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $galleries->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            @if($end < $galleries->lastPage())
                                @if($end < $galleries->lastPage() - 1)
                                    <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                @endif
                                <li><a href="{{ $galleries->url($galleries->lastPage()) }}">{{ $galleries->lastPage() }}</a></li>
                            @endif

                            @if ($galleries->hasMorePages())
                                <li><a href="{{ $galleries->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
                            @else
                                <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- End Gallery Grid Area -->
@endsection
