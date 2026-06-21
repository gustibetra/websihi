@extends('layouts.site')

@section('title', $page->title)

@section('meta_description', $page->excerpt ?? $page->subtitle)

@push('styles')
<style>
/* Member Cards and Hover Effects */
.member-card {
    background: var(--color-white) !important;
    border: 1px solid var(--color-border) !important;
    border-radius: 10px !important;
    padding: 24px 20px !important;
    text-align: center !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    box-shadow: var(--shadow-1) !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
}
.member-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: var(--shadow-2) !important;
    border-color: var(--color-primary) !important;
}
.member-photo-full {
    width: 120px !important;
    height: 120px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    margin-bottom: 15px !important;
    border: 3px solid var(--color-border) !important;
    transition: all 0.3s ease !important;
}
.member-card:hover .member-photo-full {
    border-color: var(--color-primary) !important;
}
.member-name {
    font-size: 16px !important;
    font-weight: 600 !important;
    color: var(--color-heading) !important;
    margin-bottom: 5px !important;
    line-height: 1.4 !important;
}
.member-position {
    font-size: 13px !important;
    color: var(--color-primary) !important;
    font-weight: 500 !important;
    margin-bottom: 0 !important;
    line-height: 1.3 !important;
}

/* Group Label Styles */
.group-label-full {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    border-bottom: 2px solid var(--color-border-2) !important;
    padding-bottom: 15px !important;
    margin-bottom: 25px !important;
    flex-wrap: wrap !important;
    gap: 15px !important;
}
.group-label-content {
    display: flex !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 10px !important;
}
.group-label-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: var(--color-heading) !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}
.group-label-separator {
    color: var(--color-border) !important;
    font-size: 18px !important;
}
.group-label-subtitle {
    font-size: 15px !important;
    color: var(--color-body) !important;
    font-weight: 500 !important;
}
.group-label-logo img {
    height: 40px !important;
    width: auto !important;
    object-fit: contain !important;
}

/* ── Modal Detail Anggota — Premium Redesign ───────────────────────────── */
.member-detail-modal-content {
    border-radius: 16px !important;
    border: none !important;
    box-shadow: 0 25px 60px rgba(0,0,0,0.18) !important;
    overflow: hidden !important;
    background: var(--color-white) !important;
}
.member-detail-modal-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%) !important;
    color: var(--color-white) !important;
    border-bottom: none !important;
    padding: 18px 24px !important;
    position: relative !important;
    overflow: hidden !important;
}
.member-detail-modal-header::before {
    content: '' !important;
    position: absolute !important;
    top: -20px !important; right: -20px !important;
    width: 80px !important; height: 80px !important;
    background: rgba(255,255,255,0.07) !important;
    border-radius: 50% !important;
}
.member-detail-modal-title {
    color: var(--color-white) !important;
    font-weight: 600 !important;
    font-size: 15px !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    letter-spacing: 0.2px !important;
}
.member-detail-modal-header .btn-close {
    filter: invert(1) grayscale(1) brightness(2) !important;
    opacity: 0.8 !important;
    width: 20px !important;
    height: 20px !important;
}
.member-detail-modal-header .btn-close:hover { opacity: 1 !important; }

/* Modal body layout */
.member-detail-modal-body {
    padding: 0 !important;
}
.member-modal-photo-col {
    background: linear-gradient(180deg, rgba(31,95,237,0.04) 0%, rgba(228,18,114,0.04) 100%) !important;
    padding: 30px 20px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    border-right: 1px solid var(--color-border) !important;
    min-height: 320px !important;
}
.member-modal-info-col {
    padding: 28px 28px 24px !important;
}

/* Photo area */
.member-modal-avatar-wrap {
    width: 140px !important;
    height: 140px !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    border: 4px solid var(--color-white) !important;
    box-shadow: 0 8px 24px rgba(31,95,237,0.18) !important;
    background: var(--color-light) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin-bottom: 16px !important;
    position: relative !important;
}
.member-modal-avatar-wrap img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.member-modal-avatar-icon {
    font-size: 64px !important;
    color: var(--color-primary) !important;
    opacity: 0.6 !important;
}
.member-modal-position-chip {
    display: inline-block !important;
    padding: 5px 14px !important;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%) !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    border-radius: 20px !important;
    text-align: center !important;
    max-width: 180px !important;
    word-break: break-word !important;
    line-height: 1.4 !important;
    margin-top: 4px !important;
}
.member-modal-category-chip {
    display: inline-block !important;
    padding: 3px 12px !important;
    background: var(--color-light) !important;
    color: var(--color-body) !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    border-radius: 20px !important;
    border: 1px solid var(--color-border) !important;
    margin-top: 6px !important;
}

/* Right info panel */
.member-modal-name {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: var(--color-heading) !important;
    line-height: 1.3 !important;
    margin-bottom: 4px !important;
}
.member-modal-org-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    padding: 4px 12px !important;
    background: var(--color-primary-opacity) !important;
    color: var(--color-primary) !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    margin-bottom: 18px !important;
}
.member-modal-divider {
    height: 1px !important;
    background: var(--color-border) !important;
    margin-bottom: 18px !important;
}
.member-modal-info-grid {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
}
.member-modal-info-row {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
    padding: 10px 14px !important;
    background: var(--color-light) !important;
    border-radius: 8px !important;
    border: 1px solid var(--color-border) !important;
}
.member-modal-info-icon {
    width: 32px !important;
    height: 32px !important;
    border-radius: 8px !important;
    background: var(--color-primary-opacity) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    margin-top: 1px !important;
}
.member-modal-info-icon i {
    font-size: 15px !important;
    color: var(--color-primary) !important;
}
.member-modal-info-text {
    flex: 1 !important;
    min-width: 0 !important;
}
.member-modal-info-label {
    font-size: 11px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    color: var(--color-body) !important;
    opacity: 0.7 !important;
    margin-bottom: 2px !important;
}
.member-modal-info-value {
    font-size: 14px !important;
    font-weight: 500 !important;
    color: var(--color-heading) !important;
    word-break: break-word !important;
    line-height: 1.4 !important;
}

/* ── Gradient Section Header — Compact, all-corner rounded ─────────────── */
.struktur-section-header { margin-bottom: 20px !important; }
.struktur-section-header-inner {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    padding: 11px 18px !important;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%) !important;
    border-radius: 10px !important;
    position: relative !important;
    overflow: hidden !important;
}
.struktur-section-header-inner::before {
    content: '' !important; position: absolute !important; top: -20px !important; right: -20px !important;
    width: 70px !important; height: 70px !important; background: rgba(255,255,255,0.08) !important; border-radius: 50% !important;
}
.struktur-section-header-inner::after {
    content: '' !important; position: absolute !important; bottom: -15px !important; left: 20px !important;
    width: 50px !important; height: 50px !important; background: rgba(255,255,255,0.05) !important; border-radius: 50% !important;
}
.struktur-section-icon {
    width: 32px !important; height: 32px !important; border-radius: 8px !important;
    background: rgba(255,255,255,0.18) !important;
    display: flex !important; align-items: center !important;
    justify-content: center !important; flex-shrink: 0 !important;
}
.struktur-section-icon i { font-size: 16px !important; color: #fff !important; }
.struktur-section-text { flex: 1 !important; }
.struktur-section-title {
    color: #fff !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    margin: 0 !important;
    letter-spacing: 0.3px !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.12) !important;
}
.struktur-section-logo { margin-left: auto !important; flex-shrink: 0 !important; }
.struktur-section-logo img {
    height: 28px !important; width: auto !important; object-fit: contain !important;
    filter: brightness(0) invert(1) !important; opacity: 0.8 !important;
}
.struktur-section-divider { display: none !important; }
</style>
@endpush

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

<!-- Start Content Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5">
            {{-- Left Sidebar Menu --}}
            <div class="col-lg-3">
                <aside class="rbt-sidebar-widget-wrapper">
                    @php
                    // Cari parent menu dari page ini
                    $currentMenu = \App\Models\Menu::where('page_id', $page->id)
                        ->where('link_type', 'structure')
                        ->where('is_active', 1)
                        ->first();
                    
                    $parentMenu = null;
                    $siblingMenus = collect();
                    
                    if ($currentMenu) {
                        if ($currentMenu->parent_id) {
                            // Jika ada parent, ambil parent dan siblings
                            $parentMenu = \App\Models\Menu::find($currentMenu->parent_id);
                            $siblingMenus = \App\Models\Menu::where('parent_id', $currentMenu->parent_id)
                                ->where('link_type', 'structure')
                                ->where('is_active', 1)
                                ->orderBy('order')
                                ->with('page')
                                ->get();
                        } else {
                            // Jika tidak ada parent, ambil children
                            $siblingMenus = \App\Models\Menu::where('parent_id', $currentMenu->id)
                                ->where('link_type', 'structure')
                                ->where('is_active', 1)
                                ->orderBy('order')
                                ->with('page')
                                ->get();
                        }
                    }
                    @endphp
                    
                    <div class="rbt-single-widget" style="padding: 25px; background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border);">
                        @if($parentMenu)
                        <h5 class="rbt-widget-title" style="font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $parentMenu->title }}
                        </h5>
                        @endif
                        
                        @if($siblingMenus->count() > 0)
                        <ul class="rbt-sidebar-list-wrapper recent-post-list" style="margin: 0; padding: 0; list-style: none;">
                            @foreach($siblingMenus as $menu)
                            @if($menu->page)
                            <li style="margin-bottom: 10px; display: block;">
                                <a href="{{ route('struktur.show', $menu->page->slug) }}" 
                                   class="rbt-btn btn-xs w-100 justify-content-start {{ $menu->page->id == $page->id ? 'btn-gradient' : 'btn-border' }}"
                                   style="padding: 12px 15px; height: auto; text-align: left; text-transform: none; border-radius: 6px; font-size: 14px; font-weight: 500; display: flex; align-items: center;">
                                    <i class="feather-chevron-right" style="margin-right: 8px; font-size: 16px; top: 0;"></i>
                                    <span style="white-space: normal; line-height: 1.3;">{{ $menu->title }}</span>
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </aside>
            </div>
            
            {{-- Main Content --}}
            <div class="col-lg-9">
                @if($page->content)
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="rbt-feature feature-style-1 align-items-start p--30" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border-left: 4px solid var(--color-primary);">
                            <div class="feature-content" style="width: 100%;">
                                <div class="content rbt-article-content" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                                    {!! $page->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($page->structure_common_id)
                    {{-- Spesifik Struktur --}}
                    @include('site.struktur.partials.specific-structure', ['structure' => $structure, 'page' => $page])
                @else
                    {{-- Semua Struktur berdasarkan tipe --}}
                    @include('site.struktur.partials.all-structures', ['structures' => $structures, 'page' => $page])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/site/js/struktur.js') }}"></script>
@endpush
