@extends('layouts.site')

@section('title', $page->title)

@section('meta_description', $page->excerpt ?? Str::limit(strip_tags($page->content), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">{{ $page->title }}</h2>
                    @if($page->subtitle)
                        <p class="mb--20" style="color: var(--color-body); font-size: 16px;">{{ $page->subtitle }}</p>
                    @endif
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($page->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Page Content Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 40px; background: var(--color-white); border-top: none;">
                    
                    @if($page->image)
                    <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                        <img class="w-100" src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" style="border-radius: 8px;">
                    </div>
                    @elseif($page->banner)
                    <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                        <img class="w-100" src="{{ asset('storage/' . $page->banner) }}" alt="{{ $page->title }}" style="border-radius: 8px;">
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 14px;">
                            <span><i class="feather-calendar"></i> {{ $page->created_at->format('d M Y') }}</span>
                            @if($page->updated_at->ne($page->created_at))
                                <span><i class="feather-refresh-cw"></i> Diperbarui {{ $page->updated_at->format('d M Y') }}</span>
                            @endif
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

                    <div class="content rbt-article-content" id="pageContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! $page->content !!}
                    </div>

                    @if($page->attachment)
                    <div class="rbt-feature feature-style-1 align-items-center mt--40 p--30" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border-left: 4px solid var(--color-primary);">
                        <div class="icon bg-primary-opacity" style="width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="feather-file-text" style="font-size: 24px; color: var(--color-primary);"></i>
                        </div>
                        <div class="feature-content pl--20" style="flex: 1;">
                            <h6 class="feature-title mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">Lampiran Dokumen</h6>
                            <p class="feature-description mb--0" style="font-size: 14px; color: var(--color-body);">{{ basename($page->attachment) }}</p>
                        </div>
                        <div class="button-group pl--20 mt_mobile--15">
                            <a href="{{ asset('storage/' . $page->attachment) }}" target="_blank" class="rbt-btn btn-gradient hover-icon-reverse radius-round btn-sm">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Download</span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="social-share-block mt--40">
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($page->title) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($page->title . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('pageTextSize');
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
        const content = document.getElementById('pageContent');
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
        localStorage.setItem('pageTextSize', size);
    }
});
</script>
@endpush
