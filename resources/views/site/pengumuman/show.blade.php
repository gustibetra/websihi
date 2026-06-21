@extends('layouts.site')

@section('title', $announcement->title)

@section('meta_description', $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    @if($announcement->category)
                        <span class="rbt-badge-card bg-color-primary-opacity color-primary mb--15">{{ $announcement->category->data1 }}</span>
                    @endif
                    <h2 class="title">{{ $announcement->title }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($announcement->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Announcement Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Details Content -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 12px; padding: 50px 60px; background: var(--color-white); border-top: none; border: 1px solid var(--color-border);">
                    
                    @if($announcement->image)
                    <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                        <img class="w-100" src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}" style="border-radius: 8px;">
                    </div>
                    @endif

                    @php
                        $isExpired = false;
                        if ($announcement->end_date) {
                            $isExpired = \Carbon\Carbon::parse($announcement->end_date)->isPast();
                        }
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 14px; flex-wrap: wrap;">
                            <span><i class="feather-calendar"></i> Dimulai: {{ $announcement->start_date ? \Carbon\Carbon::parse($announcement->start_date)->format('d M Y') : $announcement->created_at->format('d M Y') }}</span>
                            @if($announcement->end_date)
                                <span><i class="feather-clock"></i> Berakhir: {{ \Carbon\Carbon::parse($announcement->end_date)->format('d M Y') }}</span>
                            @endif
                            <span class="rbt-badge-card px-2 py-1 {{ $isExpired ? 'bg-color-danger color-white' : 'bg-color-success color-white' }}" style="font-size: 11px;">
                                {{ $isExpired ? 'Berakhir' : 'Aktif' }}
                            </span>
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

                    <div class="content rbt-article-content" id="announcementContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! $announcement->content !!}
                    </div>

                    @if($announcement->attachment)
                    <div class="rbt-feature feature-style-1 align-items-center mt--40 p--30" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                        <div class="icon" style="width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
                            <i class="feather-file-text" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <div class="feature-content pl--20" style="flex: 1;">
                            <h6 class="feature-title mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">Lampiran Dokumen</h6>
                            <p class="feature-description mb--0" style="font-size: 14px; color: var(--color-body);">{{ basename($announcement->attachment) }}</p>
                        </div>
                        <div class="button-group pl--20 mt_mobile--15">
                            <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank" class="rbt-btn hover-icon-reverse radius-round btn-sm" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border: none; color: #fff;">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Download</span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                </span>
                            </a>
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($announcement->title) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($announcement->title . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Previous/Next Announcement Nav -->
                    @php
                        $prevAnnouncement = \App\Models\Announcement::where('is_active', true)
                            ->where('id', '<', $announcement->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        
                        $nextAnnouncement = \App\Models\Announcement::where('is_active', true)
                            ->where('id', '>', $announcement->id)
                            ->orderBy('id', 'asc')
                            ->first();
                    @endphp
                    @if($prevAnnouncement || $nextAnnouncement)
                        <div class="rbt-post-navigation mt--50 d-flex justify-content-between align-items-center gap-4 flex-wrap" style="border-top: 1px solid var(--color-border); padding-top: 30px;">
                            @if($prevAnnouncement)
                                <div class="post-navigation-item prev" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('pengumuman.show', $prevAnnouncement->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;"><i class="feather-arrow-left"></i> Pengumuman Sebelumnya</span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($prevAnnouncement->title, 50) }}</h6>
                                    </a>
                                </div>
                            @else
                                <div style="flex: 1;"></div>
                            @endif

                            @if($nextAnnouncement)
                                <div class="post-navigation-item next text-end" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('pengumuman.show', $nextAnnouncement->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;">Pengumuman Selanjutnya <i class="feather-arrow-right"></i></span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($nextAnnouncement->title, 50) }}</h6>
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
                <aside class="rbt-sidebar-widget-wrapper" style="position: sticky; top: 120px; z-index: 10; background: var(--color-white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border);">
                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('pengumuman.index') }}" method="GET" class="rbt-search-style-1">
                                <input type="text" name="search" placeholder="Cari pengumuman..." style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Recent Announcements Widget -->
                    @php
                        $recentAnnouncements = \App\Models\Announcement::where('is_active', true)
                            ->where('id', '!=', $announcement->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    @if($recentAnnouncements->count() > 0)
                        <div class="rbt-single-widget rbt-widget-recent-post" style="margin-top: 15px !important;">
                            <h4 class="title" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading);">Pengumuman Terbaru</h4>
                            <div class="inner">
                                <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                    @foreach($recentAnnouncements as $recent)
                                        <li style="display: flex; gap: 10px; align-items: center;">
                                            @if($recent->image)
                                                <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                    <a href="{{ route('pengumuman.show', $recent->slug) }}">
                                                        <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="content">
                                                <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                    <a href="{{ route('pengumuman.show', $recent->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($recent->title, 55) }}</a>
                                                </h6>
                                                <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                    <li><i class="feather-calendar"></i> {{ $recent->created_at->format('d M Y') }}</li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Related Announcements by Category -->
                    @if($announcement->category)
                        @php
                            $relatedAnnouncements = \App\Models\Announcement::where('is_active', true)
                                ->where('category_id', $announcement->category_id)
                                ->where('id', '!=', $announcement->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if($relatedAnnouncements->count() > 0)
                            <div class="rbt-single-widget rbt-widget-recent-post" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                                <h4 class="title" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading);">Pengumuman Terkait</h4>
                                <div class="inner">
                                    <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                        @foreach($relatedAnnouncements as $related)
                                            <li style="display: flex; gap: 10px; align-items: center;">
                                                @if($related->image)
                                                    <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                        <a href="{{ route('pengumuman.show', $related->slug) }}">
                                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="content">
                                                    <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                        <a href="{{ route('pengumuman.show', $related->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($related->title, 55) }}</a>
                                                    </h6>
                                                    <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                        <li><i class="feather-calendar"></i> {{ $related->created_at->format('d M Y') }}</li>
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
<!-- End Announcement Details Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('announcementTextSize');
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
        const content = document.getElementById('announcementContent');
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
        localStorage.setItem('announcementTextSize', size);
    }
});
</script>
@endpush
