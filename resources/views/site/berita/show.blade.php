@extends('layouts.site')

@section('title', $news->title)

@section('meta_description', $news->excerpt ?? Str::limit(strip_tags($news->content), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    @if($news->category)
                        <span class="rbt-badge-card bg-color-primary-opacity color-primary mb--15">{{ $news->category->data1 }}</span>
                    @endif
                    <h2 class="title">{{ $news->title }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($news->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Blog Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Details Content -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 40px; background: var(--color-white); border-top: none;">
                    
                    @if($news->image)
                    <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                        <img class="w-100" src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" style="border-radius: 8px;">
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 14px;">
                            <span><i class="feather-calendar"></i> {{ $news->published_at ? $news->published_at->format('d M Y') : '-' }}</span>
                            <span><i class="feather-user"></i> {{ $news->author ?? 'Admin' }}</span>
                            <span><i class="feather-eye"></i> {{ $news->view_count ?? 0 }}</span>
                        </div>
                        
                        <div class="text-size-controls d-flex gap-2">
                            <button type="button" onclick="decreaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 13px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perkecil Teks">A-</button>
                            <button type="button" onclick="resetTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 12px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Reset Ukuran Teks">A</button>
                            <button type="button" onclick="increaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 15px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perbesar Teks">A+</button>
                            <button type="button" onclick="window.print()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Print Halaman">
                                <i class="feather-printer" style="font-size: 14px; color: var(--color-body);"></i>
                            </button>
                        </div>
                    </div>

                    <div class="content rbt-article-content" id="newsContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! $news->content !!}
                    </div>

                    @if($news->is_have_file && $news->file)
                    <div class="rbt-feature feature-style-1 align-items-center mt--40 p--30" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border-left: 4px solid var(--color-primary);">
                        <div class="icon bg-primary-opacity" style="width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="feather-file-text" style="font-size: 24px; color: var(--color-primary);"></i>
                        </div>
                        <div class="feature-content pl--20" style="flex: 1;">
                            <h6 class="feature-title mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">Lampiran Dokumen</h6>
                            <p class="feature-description mb--0" style="font-size: 14px; color: var(--color-body);">{{ basename($news->file) }}</p>
                        </div>
                        <div class="button-group pl--20 mt_mobile--15">
                            <a href="{{ asset('storage/' . $news->file) }}" target="_blank" class="rbt-btn btn-gradient hover-icon-reverse radius-round btn-sm">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Download</span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                    @endif

                    @php
                        $tags = $news->tags ? (is_string($news->tags) ? explode(',', $news->tags) : $news->tags) : [];
                    @endphp
                    @if(count($tags) > 0)
                        <div class="rbt-widget-tag-list mt--30 d-flex flex-wrap gap-2" style="border-top: 1px solid var(--color-border); padding-top: 20px;">
                            <span style="font-weight: 600; color: var(--color-heading); font-size: 15px; display: flex; align-items: center;">Tags:</span>
                            @foreach($tags as $tag)
                                <a href="{{ route('berita.index', ['tag' => trim($tag)]) }}" style="font-size: 13px; padding: 4px 10px; background: var(--color-border-opacity); border-radius: 4px; text-decoration: none; color: var(--color-body);">#{{ trim($tag) }}</a>
                            @endforeach
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Previous/Next Post Nav -->
                    @php
                        $prevNews = \App\Models\News::where('status', 'published')
                            ->where('id', '<', $news->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        
                        $nextNews = \App\Models\News::where('status', 'published')
                            ->where('id', '>', $news->id)
                            ->orderBy('id', 'asc')
                            ->first();
                    @endphp
                    @if($prevNews || $nextNews)
                        <div class="rbt-post-navigation mt--50 d-flex justify-content-between align-items-center gap-4 flex-wrap" style="border-top: 1px solid var(--color-border); padding-top: 30px;">
                            @if($prevNews)
                                <div class="post-navigation-item prev" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('berita.show', $prevNews->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;"><i class="feather-arrow-left"></i> Berita Sebelumnya</span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($prevNews->title, 50) }}</h6>
                                    </a>
                                </div>
                            @else
                                <div style="flex: 1;"></div>
                            @endif

                            @if($nextNews)
                                <div class="post-navigation-item next text-end" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('berita.show', $nextNews->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;">Berita Selanjutnya <i class="feather-arrow-right"></i></span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($nextNews->title, 50) }}</h6>
                                    </a>
                                </div>
                            @else
                                <div style="flex: 1;"></div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1);">
                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('berita.index') }}" method="GET" class="rbt-search-style-1">
                                <input type="text" name="search" placeholder="Cari berita..." style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Recent News Widget -->
                    @php
                        $recentNews = \App\Models\News::where('status', 'published')
                            ->where('id', '!=', $news->id)
                            ->orderBy('published_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    @if($recentNews->count() > 0)
                        <div class="rbt-single-widget rbt-widget-recent-post" style="margin-top: 15px !important;">
                            <h4 class="title" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading);">Berita Terbaru</h4>
                            <div class="inner">
                                <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                    @foreach($recentNews as $recent)
                                        <li style="display: flex; gap: 10px; align-items: center;">
                                            @if($recent->image)
                                                <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                    <a href="{{ route('berita.show', $recent->slug) }}">
                                                        <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="content">
                                                <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                    <a href="{{ route('berita.show', $recent->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($recent->title, 55) }}</a>
                                                </h6>
                                                <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                    <li><i class="feather-calendar"></i> {{ $recent->published_at ? $recent->published_at->format('d M Y') : '-' }}</li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Related News by Category -->
                    @if($news->category)
                        @php
                            $relatedNews = \App\Models\News::where('status', 'published')
                                ->where('category_id', $news->category_id)
                                ->where('id', '!=', $news->id)
                                ->orderBy('published_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if($relatedNews->count() > 0)
                            <div class="rbt-single-widget rbt-widget-recent-post" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                                <h4 class="title" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading);">Berita Terkait</h4>
                                <div class="inner">
                                    <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                        @foreach($relatedNews as $related)
                                            <li style="display: flex; gap: 12px; align-items: center;">
                                                @if($related->image)
                                                    <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                        <a href="{{ route('berita.show', $related->slug) }}">
                                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="content">
                                                    <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                        <a href="{{ route('berita.show', $related->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($related->title, 55) }}</a>
                                                    </h6>
                                                    <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                        <li><i class="feather-calendar"></i> {{ $related->published_at ? $related->published_at->format('d M Y') : '-' }}</li>
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endif
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Blog Details Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('newsTextSize');
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
        const content = document.getElementById('newsContent');
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
        localStorage.setItem('newsTextSize', size);
    }
});
</script>
@endpush
