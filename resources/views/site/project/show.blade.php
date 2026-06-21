@extends('layouts.site')

@section('title', $project->data1)

@section('meta_description', Str::limit(strip_tags($project->text1), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    @if($jurusan)
                        <span class="rbt-badge-card bg-color-primary-opacity color-primary mb--15">{{ $jurusan->nama }}</span>
                    @endif
                    <h2 class="title">{{ $project->data1 }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('project.index') }}">Karya Siswa</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($project->data1, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Project Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Details Content -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 40px; background: var(--color-white); border-top: none;">
                    
                    @if($project->data2)
                        <div class="post-thumbnail mb--40 position-relative text-center" style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-2);">
                            <img class="w-100" src="{{ asset('storage/' . $project->data2) }}" alt="{{ $project->data1 }}" style="max-height: 480px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Project Metadata Info Box -->
                    <div class="mb--40" style="padding: 30px; background: var(--color-light); border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--color-primary);"></div>
                        <div class="row g-4" style="font-size: 14px;">
                            <!-- Nama Projek -->
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: var(--primary-opacity); color: var(--color-primary); flex-shrink: 0;">
                                        <i class="feather-cpu" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Nama Projek / Karya</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $project->data1 }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Jurusan Terkait -->
                            @if($jurusan)
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: var(--primary-opacity); color: var(--color-primary); flex-shrink: 0;">
                                        <i class="feather-book-open" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Jurusan Terkait</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $jurusan->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Kategori -->
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: var(--primary-opacity); color: var(--color-primary); flex-shrink: 0;">
                                        <i class="feather-tag" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Kategori</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">Karya Siswa</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Panel -->
                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <span class="rbt-badge-card px-3 py-2 bg-color-primary-opacity color-primary" style="font-weight: 600; font-size: 13px;">
                            Karya & Projek Kreatif
                        </span>
                        
                        <div class="text-size-controls d-flex gap-2">
                            <button type="button" onclick="decreaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 13px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perkecil Teks">A-</button>
                            <button type="button" onclick="resetTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 12px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Reset Ukuran Teks">A</button>
                            <button type="button" onclick="increaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 15px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perbesar Teks">A+</button>
                            <button type="button" onclick="window.print()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Print Halaman">
                                <i class="feather-printer" style="font-size: 14px; color: var(--color-body);"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Project Description -->
                    <div class="content rbt-article-content" id="projectContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! nl2br(e($project->text1)) !!}
                    </div>

                    @if($news)
                    <!-- Linked News Box -->
                    <div class="p--25 mt--40 mb--30" style="background: var(--color-light); border-radius: 8px; border-left: 4px solid var(--color-primary); padding: 25px;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-color-primary-opacity d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 8px; flex-shrink: 0;">
                                    <i class="feather-link" style="font-size: 24px; color: var(--color-primary);"></i>
                                </div>
                                <div>
                                    <h6 class="mb--5" style="font-size: 15px; font-weight: 600; color: var(--color-heading); margin-bottom: 5px;">Berita Terkait</h6>
                                    <p class="mb--0 text-muted" style="font-size: 13px;">Baca berita selengkapnya mengenai projek karya siswa ini.</p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('berita.show', $news->slug) }}" class="rbt-btn btn-gradient hover-icon-reverse radius-round btn-sm" style="height: 40px; line-height: 38px; padding: 0 20px; font-size: 13px;">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Baca Berita</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="social-share-block mt--40" style="border-top: 1px solid var(--color-border); padding-top: 20px;">
                        <div class="post-like" style="border: none; padding: 0;">
                            <span style="font-size: 15px; font-weight: 600; color: var(--color-heading);">Bagikan Halaman Ini:</span>
                        </div>
                        <ul class="social-icon social-default transparent-with-border">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" title="Share ke Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($project->data1) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($project->data1 . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1);">
                    <div class="rbt-single-widget rbt-widget-recent-post" style="margin-top: 15px !important;">
                        <div class="d-flex justify-content-between align-items-center mb--8" style="margin-bottom: 8px !important;">
                            <h4 class="title mb--0" style="font-size: 15px !important; font-weight: 600; color: var(--color-heading); margin-bottom: 0 !important;">Projek Lainnya</h4>
                            <a href="{{ route('project.index') }}" class="rbt-btn btn-sm btn-border" style="font-size: 11px; padding: 5px 12px; height: auto;"><i class="feather-arrow-left"></i> Kembali</a>
                        </div>
                        
                        @php
                            $otherProjects = \App\Models\Common::where('table_name', 'karya_siswa')
                                ->where('is_active', true)
                                ->where('id', '!=', $project->id)
                                ->orderBy('id', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if($otherProjects->count() > 0)
                            <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                @foreach($otherProjects as $other)
                                    <li style="display: flex; gap: 10px; align-items: center;">
                                        @if($other->data2)
                                            <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                <a href="{{ route('project.show', $other->id) }}">
                                                    <img src="{{ asset('storage/' . $other->data2) }}" alt="{{ $other->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </a>
                                            </div>
                                        @else
                                            <div class="thumbnail d-flex align-items-center justify-content-center bg-light" style="width: 55px; height: 55px; flex-shrink: 0; border-radius: 6px;">
                                                <i class="feather-monitor text-primary" style="font-size: 18px;"></i>
                                            </div>
                                        @endif
                                        <div class="content">
                                            <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                <a href="{{ route('project.show', $other->id) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($other->data1, 55) }}</a>
                                            </h6>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Belum ada projek lainnya.</p>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Project Details Area -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('projectTextSize');
    if (savedSize) {
        currentSize = parseInt(savedSize);
        applyTextSize(currentSize);
    }

    window.increaseTextSize = function() {
        if (currentSize < maxSize) {
            currentSize += step;
            applyTextSize(currentSize);
            saveTextSize(currentSize);
        }
    };

    window.decreaseTextSize = function() {
        if (currentSize > minSize) {
            currentSize -= step;
            applyTextSize(currentSize);
            saveTextSize(currentSize);
        }
    };

    window.resetTextSize = function() {
        currentSize = 16;
        applyTextSize(currentSize);
        saveTextSize(currentSize);
    };

    function applyTextSize(size) {
        const content = document.getElementById('projectContent');
        if (content) {
            content.style.setProperty('font-size', size + 'px', 'important');
            const lineHeight = size * 1.8 / 16;
            content.style.setProperty('line-height', lineHeight, 'important');
            
            const paragraphs = content.querySelectorAll('p, li, td, th, blockquote');
            paragraphs.forEach(function(el) {
                el.style.setProperty('font-size', size + 'px', 'important');
            });
        }
    }

    function saveTextSize(size) {
        localStorage.setItem('projectTextSize', size);
    }
});
</script>
@endpush
