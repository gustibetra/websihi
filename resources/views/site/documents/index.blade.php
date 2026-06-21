@extends('layouts.site')

@section('title', 'Pusat Unduhan')

@push('styles')
<style>
    .download-sidebar {
        position: -webkit-sticky;
        position: sticky;
        top: 110px;
        z-index: 10;
        background: var(--color-white);
        padding: 30px;
        border-radius: 12px;
        box-shadow: var(--shadow-1);
        border: 1px solid var(--color-border-opacity) !important;
    }

    .category-list li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--color-body) !important;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        padding: 10px 14px;
        border-radius: 6px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .category-list li a:hover {
        background: var(--color-light);
        color: var(--color-primary) !important;
        padding-left: 18px;
    }

    .category-list li a.active {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .clear-filter-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 6px;
        background: rgba(239, 68, 68, 0.08);
        color: var(--color-danger) !important;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 25px;
        width: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(239, 68, 68, 0.15);
    }

    .clear-filter-btn:hover {
        background: var(--color-danger);
        color: white !important;
        border-color: var(--color-danger);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .download-card {
        border: 1px solid var(--color-border-opacity) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        border-radius: 12px !important;
        background: var(--color-white);
    }

    .download-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
        border-color: var(--color-primary) !important;
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
                    <h2 class="title">Pusat Unduhan</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Unduh Berkas, Formulir, Panduan, dan Dokumen Penting</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Unduhan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Download Center Area -->
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Documents List -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row g-4">
                    @forelse($downloads as $item)
                        @php
                            $extension = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                            $icon = match($extension) {
                                'pdf' => 'feather-file',
                                'doc', 'docx' => 'feather-file-text',
                                'xls', 'xlsx' => 'feather-grid',
                                'ppt', 'pptx' => 'feather-tv',
                                'zip', 'rar' => 'feather-package',
                                'png', 'jpg', 'jpeg' => 'feather-image',
                                default => 'feather-file'
                            };
                            $iconColor = match($extension) {
                                'pdf' => 'var(--color-danger)',
                                'doc', 'docx' => 'var(--color-primary)',
                                'xls', 'xlsx' => 'var(--color-success)',
                                'ppt', 'pptx' => 'var(--color-warning)',
                                'zip', 'rar' => '#8b5cf6',
                                'png', 'jpg', 'jpeg' => '#06b6d4',
                                default => 'var(--color-body)'
                            };
                        @endphp
                        <div class="col-lg-12">
                            <div class="rbt-card card-list-2 variation-01 rbt-hover download-card d-flex flex-column flex-sm-row gap-4 p--25 align-items-center">
                                <!-- File Icon -->
                                <div class="d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 10px; background: var(--color-light); flex-shrink: 0; color: {{ $iconColor }};">
                                    <i class="{{ $icon }}" style="font-size: 32px;"></i>
                                </div>

                                <!-- Details -->
                                <div class="flex-grow-1 w-100">
                                    <h5 class="mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">{{ $item->title }}</h5>
                                    <p class="text-muted mb--10" style="font-size: 13px; line-height: 1.5;">{{ $item->description ?: 'Tidak ada deskripsi tambahan.' }}</p>
                                    
                                    <div class="d-flex flex-wrap gap-2 align-items-center" style="font-size: 12px;">
                                        <span class="badge" style="background: var(--color-border-opacity); color: var(--color-body); font-weight: 500; font-size: 11px; padding: 4px 8px; border-radius: 3px;">
                                            <i class="feather-folder"></i> {{ $item->category?->data1 ?? 'Dokumen' }}
                                        </span>
                                        @if($item->jurusan)
                                            <span class="badge" style="background: rgba(47, 87, 239, 0.1); color: var(--color-primary); font-weight: 500; font-size: 11px; padding: 4px 8px; border-radius: 3px;">
                                                <i class="feather-book-open"></i> {{ $item->jurusan->nama }}
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-weight: 500; font-size: 11px; padding: 4px 8px; border-radius: 3px;">
                                                <i class="feather-globe"></i> Umum
                                            </span>
                                        @endif
                                        <span class="text-muted"><i class="feather-database"></i> {{ $item->file_size }}</span>
                                        <span class="text-muted"><i class="feather-calendar"></i> {{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Download Trigger Button -->
                                <div class="flex-shrink-0 mt_mobile--15">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" download class="rbt-btn btn-gradient hover-icon-reverse radius-round btn-sm" style="height: 40px; line-height: 38px; padding: 0 20px; font-size: 13px;">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Unduh</span>
                                            <span class="btn-icon"><i class="feather-download"></i></span>
                                            <span class="btn-icon"><i class="feather-download"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border-opacity);">
                                <i class="feather-file-text text-warning mb--15" style="font-size: 48px;"></i>
                                <h5 class="mb--5">Belum Ada Berkas</h5>
                                <p class="mb--0 text-muted">Belum ada berkas atau dokumen yang diunggah saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($downloads->hasPages())
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                                    @if ($downloads->onFirstPage())
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $downloads->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                    @endif

                                    @for ($page = 1; $page <= $downloads->lastPage(); $page++)
                                        @if ($page == $downloads->currentPage())
                                            <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $downloads->url($page) }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    @if ($downloads->hasMorePages())
                                        <li><a href="{{ $downloads->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
                                    @else
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-right"></i></a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Filters -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper download-sidebar">
                    <!-- Clear Filter Action -->
                    @if(request()->anyFilled(['category', 'jurusan', 'search']))
                        <a href="{{ route('site.documents.index') }}" class="clear-filter-btn">
                            <i class="feather-x-circle"></i> Bersihkan Semua Filter
                        </a>
                    @endif

                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('site.documents.index') }}" method="GET" class="rbt-search-style-1">
                                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                                @if(request('jurusan')) <input type="hidden" name="jurusan" value="{{ request('jurusan') }}"> @endif
                                <input type="text" name="search" placeholder="Cari dokumen..." value="{{ request('search') }}" style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Kategori Unduhan Widget -->
                    @if($categories->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories mt--40" style="border-top: 1px solid var(--color-border); padding-top: 30px;">
                            <h4 class="title widget-title-trigger" style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Kategori Dokumen</span>
                                <i class="feather-chevron-{{ request('category') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('category') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                    <li>
                                        <a href="{{ route('site.documents.index', request()->except('category')) }}" class="{{ !request('category') ? 'active' : '' }}">
                                            Semua Kategori
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('site.documents.index', array_merge(request()->all(), ['category' => $category->id])) }}" class="{{ request('category') == $category->id ? 'active' : '' }}">
                                                {{ $category->data1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Jurusan/Program Filter Widget -->
                    @if($jurusans->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories mt--40" style="border-top: 1px solid var(--color-border); padding-top: 30px;">
                            <h4 class="title widget-title-trigger" style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Jurusan / Kompetensi</span>
                                <i class="feather-chevron-{{ request('jurusan') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('jurusan') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                    <li>
                                        <a href="{{ route('site.documents.index', request()->except('jurusan')) }}" class="{{ !request('jurusan') ? 'active' : '' }}">
                                            Semua Jurusan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('site.documents.index', array_merge(request()->all(), ['jurusan' => 'umum'])) }}" class="{{ request('jurusan') === 'umum' ? 'active' : '' }}">
                                            Umum / Semua Jurusan
                                        </a>
                                    </li>
                                    @foreach($jurusans as $program)
                                        <li>
                                            <a href="{{ route('site.documents.index', array_merge(request()->all(), ['jurusan' => $program->id])) }}" class="{{ request('jurusan') == $program->id ? 'active' : '' }}">
                                                {{ $program->nama }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Download Center Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.widget-title-trigger').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const inner = this.nextElementSibling;
            const icon = this.querySelector('.filter-toggle-icon');
            if (inner) {
                if (inner.style.display === 'none') {
                    inner.style.display = 'block';
                    if (icon) {
                        icon.classList.remove('feather-chevron-down');
                        icon.classList.add('feather-chevron-up');
                    }
                } else {
                    inner.style.display = 'none';
                    if (icon) {
                        icon.classList.remove('feather-chevron-up');
                        icon.classList.add('feather-chevron-down');
                    }
                }
            }
        });
    });
});
</script>
@endpush

