@extends('layouts.site')

@section('title', $program->nama . (isset($page) ? ' — ' . $page->title : ' — Tentang Jurusan'))
@section('meta_description', isset($page) ? Str::limit(strip_tags($page->content ?? ''), 160) : Str::limit(strip_tags($program->deskripsi ?? ''), 160))

@push('styles')
<style>
.jd-hero {
    background: linear-gradient(135deg, var(--color-primary, #007bff) 0%, var(--color-secondary, #0056b3) 100%);
    padding: 60px 0 40px;
    position: relative;
    overflow: hidden;
}

.jd-hero::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -120px; right: -80px;
    pointer-events: none;
}
.jd-hero::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    bottom: -60px; left: 20%;
    pointer-events: none;
}

.jd-hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 20px;
    font-size: 13px;
    color: rgba(255,255,255,0.7);
}
.jd-hero-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.jd-hero-breadcrumb a:hover { color: #fff; }
.jd-hero-breadcrumb .sep { opacity: 0.5; }

.jd-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.25);
    color: rgba(255,255,255,0.9);
    font-size: 12px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 30px;
    margin-bottom: 16px;
    letter-spacing: 0.3px;
}

.jd-hero h1 {
    font-size: 36px;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 14px;
    position: relative;
    z-index: 1;
}

.jd-hero-desc {
    font-size: 16px;
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
    max-width: 680px;
    margin-bottom: 28px;
    position: relative;
    z-index: 1;
}

.jd-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
    position: relative;
    z-index: 1;
}

.jd-hero-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.85);
    font-size: 14px;
}

.jd-hero-meta-item i {
    font-size: 16px;
    opacity: 0.8;
}

.jd-hero-meta-item strong {
    color: #fff;
    font-weight: 600;
}

.jd-kaprodi-thumb {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.4);
    object-fit: cover;
}
.jd-kaprodi-fallback {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255,255,255,0.4);
}

/* ── Sticky Tab Nav ── */
.jd-sticky-nav {
    background: var(--color-white, #fff);
    border-bottom: 2px solid var(--color-border, #eee);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: visible !important;
}

.jd-sticky-nav-inner {
    display: flex;
    align-items: center;
    gap: 0;
    overflow: visible !important;
}

/* Hide main sticky header on this page so only program menu is sticky */
body.rbt-header-sticky .rbt-header-wrapper.rbt-sticky {
    display: none !important;
}

/* Mobile Toggle Header */
.jd-mobile-header {
    display: none;
    cursor: pointer;
    border-bottom: none;
    user-select: none;
}
.jd-mobile-header.active .feather-chevron-down {
    transform: rotate(180deg);
}
.transition-transform {
    transition: transform 0.2s ease;
}

/* Active state for dropdown toggle link when child is active */
.jd-sticky-nav .dropdown-toggle.active {
    color: var(--color-primary, #007bff) !important;
    border-bottom-color: var(--color-primary, #007bff) !important;
}

@media (max-width: 768px) {
    .jd-mobile-header {
        display: flex !important;
    }
    .jd-sticky-nav-inner {
        display: none; /* Hidden by default on mobile */
        flex-direction: column;
        width: 100%;
        padding: 0 15px 15px 15px !important;
        gap: 8px;
        border-top: 1px solid var(--color-border, #eee);
        margin-top: 5px;
    }
    .jd-sticky-nav-inner.show {
        display: flex !important;
    }
    .jd-nav-link {
        padding: 10px 16px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        border: 1px solid var(--color-border, #eee) !important;
        border-radius: 8px !important;
        background: #f9f9f9 !important;
        color: var(--color-body, #555) !important;
        border-bottom: 1px solid var(--color-border, #eee) !important;
        bottom: 0 !important;
        transition: all 0.2s ease;
        width: 100%;
        justify-content: flex-start;
    }
    .jd-sticky-nav-inner .dropdown {
        width: 100%;
    }
    .jd-sticky-nav-inner .dropdown-toggle {
        width: 100%;
        justify-content: space-between;
    }
    .jd-sticky-nav-inner .dropdown-menu {
        position: static !important;
        transform: none !important;
        width: 100%;
        box-shadow: none !important;
        border: 1px solid var(--color-border, #eee) !important;
        background: #fdfdfd !important;
        margin-top: 6px !important;
        margin-bottom: 6px !important;
        padding: 6px !important;
    }
    .jd-nav-link:hover {
        background: rgba(var(--color-primary-rgb, 0,123,255), 0.05) !important;
        color: var(--color-primary, #007bff) !important;
    }
    .jd-nav-link.active,
    .jd-sticky-nav .dropdown-toggle.active {
        background: var(--color-primary, #007bff) !important;
        color: #fff !important;
        border-color: var(--color-primary, #007bff) !important;
    }
    .jd-back-btn {
        margin-left: 0 !important;
        width: 100%;
        justify-content: center;
        margin-top: 4px;
        border-radius: 8px !important;
        padding: 10px 18px !important;
    }
}

.jd-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 16px 22px;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-body, #555);
    text-decoration: none !important;
    border-bottom: 3px solid transparent;
    white-space: nowrap;
    transition: all 0.2s ease;
    position: relative;
    bottom: -2px;
}

.jd-nav-link:hover {
    color: var(--color-primary, #007bff);
    background: rgba(var(--color-primary-rgb, 0,123,255), 0.04);
}

.jd-nav-link.active {
    color: var(--color-primary, #007bff);
    border-bottom-color: var(--color-primary, #007bff);
}

.jd-nav-link i { font-size: 15px; }

.jd-back-btn {
    margin-left: auto;
    padding: 8px 18px;
    margin-right: 10px;
    font-size: 13px;
    color: var(--color-body);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    white-space: nowrap;
    transition: all 0.2s;
}
.jd-back-btn:hover { color: var(--color-primary); border-color: var(--color-primary); }

/* ── Dropdown Nav Link Styling ── */
.jd-sticky-nav .dropdown-menu {
    border: 1px solid rgba(0,0,0,0.08) !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    border-radius: 12px !important;
    padding: 8px !important;
    margin-top: 5px !important;
}
.jd-sticky-nav .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    color: var(--color-body, #555) !important;
    border-radius: 8px !important;
    transition: all 0.2s ease !important;
}
.jd-sticky-nav .dropdown-item:hover {
    color: var(--color-primary, #007bff) !important;
    background: rgba(var(--color-primary-rgb, 0,123,255), 0.05) !important;
}
.jd-sticky-nav .dropdown-item i {
    font-size: 15px !important;
    color: var(--color-body, #555);
}
.jd-sticky-nav .dropdown-item:hover i {
    color: var(--color-primary, #007bff);
}
.jd-sticky-nav .dropdown-toggle::after {
    display: none !important;
}

/* ── Main Content Area ── */
.jd-content-area {
    padding-top: 48px;
    padding-bottom: 64px;
}

/* ── Section Cards ── */
.jd-section-card {
    background: var(--color-white, #fff);
    border-radius: 14px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 28px;
    overflow: hidden;
}

.jd-section-header {
    padding: 20px 28px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 14px;
}

.jd-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--color-primary, #007bff), var(--color-secondary, #0056b3));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.jd-section-icon i { font-size: 18px; color: #fff; }

.jd-section-header h4 {
    font-size: 17px;
    font-weight: 700;
    color: var(--color-heading, #1a1a2e);
    margin: 0;
}

.jd-section-body { padding: 28px; }

/* ── Deskripsi content ── */
.jd-prose {
    font-size: 15.5px;
    line-height: 1.85;
    color: var(--color-body, #555);
}
.jd-prose p:last-child { margin-bottom: 0; }

/* ── Kaprodi block ── */
.jd-kaprodi-profile {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 20px;
    background: var(--color-bg-subtle, #f8f9fa);
    border-radius: 12px;
    border: 1px solid var(--color-border, #eee);
}

.jd-kaprodi-avatar {
    width: 90px; height: 90px;
    border-radius: 12px;
    object-fit: cover;
    flex-shrink: 0;
    border: 3px solid rgba(var(--color-primary-rgb, 0,123,255), 0.2);
}
.jd-kaprodi-avatar-fallback {
    width: 90px; height: 90px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--color-primary, #007bff), var(--color-secondary, #0056b3));
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.jd-kaprodi-avatar-fallback i { font-size: 36px; color: #fff; }
.jd-kaprodi-info h5 { font-size: 18px; font-weight: 700; color: var(--color-heading, #1a1a2e); margin-bottom: 4px; }
.jd-kaprodi-info .nip { font-size: 13px; color: #999; margin-bottom: 8px; }
.jd-kaprodi-badge {
    display: inline-block;
    background: rgba(var(--color-primary-rgb, 0,123,255), 0.08);
    color: var(--color-primary, #007bff);
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}

/* ── Teacher grid ── */
.jd-teacher-card {
    background: var(--color-white, #fff);
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    padding: 20px 16px;
    text-align: center;
    transition: all 0.25s ease;
    border: 1px solid var(--color-border, #eee);
}
.jd-teacher-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border-color: var(--color-primary, #007bff);
}
.jd-teacher-photo {
    width: 72px; height: 72px;
    border-radius: 50%;
    margin: 0 auto 12px;
    overflow: hidden;
    border: 3px solid rgba(var(--color-primary-rgb,0,123,255),0.15);
}
.jd-teacher-photo img { width: 100%; height: 100%; object-fit: cover; }
.jd-teacher-photo .fallback {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--color-primary, #007bff), var(--color-secondary, #0056b3));
    display: flex; align-items: center; justify-content: center;
}
.jd-teacher-photo .fallback i { font-size: 28px; color: #fff; }
.jd-teacher-name { font-size: 13.5px; font-weight: 600; color: var(--color-heading, #333); margin-bottom: 4px; }
.jd-teacher-role { font-size: 12px; color: #888; }

/* ── News card ── */
.jd-news-card {
    background: var(--color-white, #fff);
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid var(--color-border, #eee);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.jd-news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
.jd-news-thumb {
    height: 160px;
    background: linear-gradient(135deg, var(--color-primary,#007bff), var(--color-secondary,#0056b3));
    overflow: hidden;
    flex-shrink: 0;
}
.jd-news-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.jd-news-card:hover .jd-news-thumb img { transform: scale(1.05); }
.jd-news-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.jd-news-date { font-size: 11px; color: #aaa; margin-bottom: 6px; }
.jd-news-title {
    font-size: 14px; font-weight: 600; color: var(--color-heading,#333); line-height: 1.4;
    flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 10px;
}
.jd-news-readmore {
    font-size: 12px; color: var(--color-primary,#007bff); font-weight: 600;
    display: flex; align-items: center; gap: 4px; text-decoration: none !important;
}

/* ── Page content mode ── */
.jd-page-content {
    background: var(--color-white, #fff);
    border-radius: 14px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    padding: 40px 44px;
    border: 1px solid rgba(0,0,0,0.05);
}
.jd-page-content .prose {
    font-size: 16px;
    line-height: 1.85;
    color: var(--color-body, #555);
}

/* Responsive */
@media (max-width: 767px) {
    .jd-hero h1 { font-size: 26px; }
    .jd-hero { padding: 40px 0 28px; }
    .jd-page-content { padding: 24px 20px; }
    .jd-section-body { padding: 20px; }
    .jd-kaprodi-profile { flex-direction: column; text-align: center; }
}

/* ── Event/Agenda Cards ── */
.jd-event-card {
    background: var(--color-white, #fff);
    border-radius: 16px;
    border: 1px solid var(--color-border, #eee);
    border-left: 4px solid var(--color-primary, #007bff);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    height: 100%;
}
.jd-event-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border-color: var(--color-primary-opacity, rgba(0,123,255,0.2));
}
.jd-event-date {
    width: 65px;
    height: 68px;
    border-radius: 12px;
    overflow: hidden;
    background: var(--color-bg-subtle, #f8f9fa);
    border: 1px solid var(--color-border, #eee);
    flex-shrink: 0;
}
.jd-event-month {
    width: 100%;
    background: var(--color-primary, #007bff);
    color: #fff;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.8px;
    padding: 3px 0;
    text-align: center;
    line-height: 1.2;
    display: block;
}
.jd-event-day {
    font-size: 20px;
    font-weight: 800;
    color: var(--color-heading, #1a1a2e);
    line-height: 1.3;
    padding: 2px 0 4px 0;
    display: block;
    text-align: center;
}
.jd-event-title {
    font-size: 15.5px;
    font-weight: 700;
    line-height: 1.45;
    margin-bottom: 6px;
}
.jd-event-title a {
    color: var(--color-heading, #1a1a2e);
    text-decoration: none !important;
    transition: color 0.2s ease;
}
.jd-event-card:hover .jd-event-title a {
    color: var(--color-primary, #007bff);
}
.jd-event-meta {
    font-size: 12.5px;
    color: var(--color-body, #555);
}
.jd-event-meta i {
    font-size: 13.5px;
    margin-right: 4px;
}
.jd-event-arrow {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(var(--color-primary-rgb, 0,123,255), 0.05);
    color: var(--color-primary, #007bff);
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.jd-event-card:hover .jd-event-arrow {
    background: var(--color-primary, #007bff);
    color: #fff;
    transform: translateX(3px);
}
</style>
@endpush

@section('content')

@php
    $embedUrl = null;
    if ($program->video_url) {
        $url = $program->video_url;
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $embedUrl = 'https://www.youtube.com/embed/' . $match[1];
        } elseif (preg_match('%(?:vimeo\.com/)(?:channels/(?:\w+/)?|groups/(?:[^\/]*)/videos/|album/(?:\d+)/video/|video/|)(\d+)(?:$|[?&])%i', $url, $match)) {
            $embedUrl = 'https://player.vimeo.com/video/' . $match[1];
        }
    }
    $isAboutPage = !isset($page);
@endphp

{{-- ══════════════════════════════════════
     HERO BANNER
     ══════════════════════════════════════ --}}
<div class="jd-hero">
    <div class="container">
        {{-- Breadcrumb --}}
        <div class="jd-hero-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep"><i class="feather-chevron-right" style="font-size:12px;"></i></span>
            <a href="{{ route('jurusan.index') }}">Program Keahlian</a>
            <span class="sep"><i class="feather-chevron-right" style="font-size:12px;"></i></span>
            <span>{{ $program->nama }}</span>
            @if(isset($page))
                <span class="sep"><i class="feather-chevron-right" style="font-size:12px;"></i></span>
                <span>{{ $page->title }}</span>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-9">
                {{-- Badge --}}
                <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                    @if($program->akreditasi)
                        <div class="feature-sin best-seller-badge">
                            <span class="rbt-badge-2 text-white" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); height: 42px; line-height: 42px; box-shadow: none; padding: 0 20px;">
                                <span class="image" style="margin-right: 8px; display: inline-flex; align-items: center;"><img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Akreditasi Icon" style="max-height: 22px;"></span>
                                Akreditasi <strong class="text-white ms-1">{{ $program->akreditasi }}</strong>
                            </span>
                        </div>
                    @endif
                    <div class="jd-hero-badge mb-0" style="height: 42px; display: inline-flex; align-items: center; border-radius: 500px; padding: 0 20px;">
                        <i class="feather-award"></i> Program Keahlian &nbsp;•&nbsp; {{ $program->kode }}
                    </div>
                </div>

                {{-- Title --}}
                @if(isset($page))
                    <h1>{{ $page->title }}</h1>
                    @if($page->subtitle)
                        <p class="jd-hero-desc">{{ $page->subtitle }}</p>
                    @else
                        <p class="jd-hero-desc">{{ $program->nama }}</p>
                    @endif
                @else
                    <h1>{{ $program->nama }}</h1>
                    @if($program->deskripsi_singkat)
                        <p class="jd-hero-desc">{{ $program->deskripsi_singkat }}</p>
                    @elseif($program->deskripsi)
                        <p class="jd-hero-desc">{{ Str::limit(strip_tags($program->deskripsi), 220) }}</p>
                    @endif
                @endif

                {{-- Meta info --}}
                <div class="jd-hero-meta">
                    @php
                        $kaProdiHero = $program->kepalaProdi ?? null;
                    @endphp
                    @if($kaProdiHero)
                        <div class="jd-hero-meta-item">
                            @if($kaProdiHero->photo)
                                <img src="{{ asset('storage/'.$kaProdiHero->photo) }}" class="jd-kaprodi-thumb" alt="{{ $kaProdiHero->name }}">
                            @else
                                <span class="jd-kaprodi-fallback"><i class="feather-user" style="font-size:14px;color:#fff;"></i></span>
                            @endif
                            <span>Kaprodi: <strong>{{ $kaProdiHero->name }}</strong></span>
                        </div>
                    @endif

                    @if(isset($teachers) && $teachers->count() > 0)
                        <div class="jd-hero-meta-item">
                            <i class="feather-users"></i>
                            <span><strong>{{ $teachers->count() }}+</strong> Pengajar</span>
                        </div>
                    @endif

                    @if($program->tahun_berdiri)
                        <div class="jd-hero-meta-item">
                            <i class="feather-calendar"></i>
                            <span>Berdiri <strong>{{ $program->tahun_berdiri }}</strong></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     STICKY TAB NAV  (Jurusan Menu + default tabs)
     ══════════════════════════════════════ --}}
<div class="jd-sticky-nav">
    <div class="container">
        <!-- Mobile Toggle Header -->
        <div class="jd-mobile-header d-flex d-md-none align-items-center justify-content-between py-3 px-2" style="cursor: pointer;">
            <span class="fw-bold text-dark" style="font-size: 14.5px;">
                <i class="feather-menu me-2 text-primary"></i>Navigasi Halaman
            </span>
            <span class="jd-mobile-toggle-btn badge bg-primary-opacity text-primary py-2 px-3 d-flex align-items-center gap-1" style="font-size: 12px; font-weight: 600; border-radius: 20px; transition: all 0.2s ease;">
                <span class="jd-mobile-toggle-text">Buka</span> <i class="feather-chevron-down transition-transform"></i>
            </span>
        </div>

        <div class="jd-sticky-nav-inner">

            {{-- Default "Tentang" tab always first --}}
            @php
                $currentUrl  = url()->current();
                $hasCustomMenu = count($jurusanMenu) > 0;
            @endphp
            <a href="{{ route('jurusan.space', $program->kode) }}{{ $isAboutPage ? '#overview' : '' }}"
               class="jd-nav-link {{ $isAboutPage ? 'active' : '' }}">
                <i class="feather-info"></i> Tentang
            </a>

            @if(!$hasCustomMenu)
                {{-- No custom menu: show all default links directly as tabs --}}
                @if($isAboutPage)
                    @if($program->visi || $program->misi)
                        <a href="#visimisi" class="jd-nav-link"><i class="feather-compass"></i> Visi & Misi</a>
                    @endif
                    @if(isset($teachers) && $teachers->count() > 0)
                        <a href="#pengajar" class="jd-nav-link"><i class="feather-users"></i> Pengajar</a>
                    @endif
                    @if(isset($recentNews) && $recentNews->count() > 0)
                        <a href="#berita" class="jd-nav-link"><i class="feather-rss"></i> Berita</a>
                    @endif
                    @if(isset($agendaJurusan) && $agendaJurusan->count() > 0)
                        <a href="#agenda" class="jd-nav-link"><i class="feather-calendar"></i> Agenda</a>
                    @endif
                    @if(isset($prestasiJurusan) && $prestasiJurusan->count() > 0)
                        <a href="#prestasi" class="jd-nav-link"><i class="feather-award"></i> Prestasi</a>
                    @endif
                    @if(isset($projectJurusan) && $projectJurusan->count() > 0)
                        <a href="#project" class="jd-nav-link"><i class="feather-monitor"></i> Project</a>
                    @endif
                    @if(isset($galleryJurusan) && $galleryJurusan->count() > 0)
                        <a href="#gallery" class="jd-nav-link"><i class="feather-image"></i> Galeri</a>
                    @endif
                    @if(isset($alumniJurusan) && $alumniJurusan->count() > 0)
                        <a href="#testimoni" class="jd-nav-link"><i class="feather-message-square"></i> Testimoni</a>
                    @endif
                @endif
            @else
                {{-- Has custom menu: group default links into a dropdown --}}
                @php
                    $hasDefaultLinks = ($program->visi || $program->misi) ||
                                       (isset($teachers) && $teachers->count() > 0) ||
                                       (isset($recentNews) && $recentNews->count() > 0) ||
                                       (isset($agendaJurusan) && $agendaJurusan->count() > 0) ||
                                       (isset($prestasiJurusan) && $prestasiJurusan->count() > 0) ||
                                       (isset($projectJurusan) && $projectJurusan->count() > 0) ||
                                       (isset($galleryJurusan) && $galleryJurusan->count() > 0) ||
                                       (isset($alumniJurusan) && $alumniJurusan->count() > 0);
                @endphp

                @if($hasDefaultLinks)
                    <div class="dropdown">
                        <a href="#" class="jd-nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="feather-grid"></i> Informasi <i class="feather-chevron-down ms-1"></i>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg">
                            @if($program->visi || $program->misi)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#visimisi' : route('jurusan.space', $program->kode) . '#visimisi' }}">
                                        <i class="feather-compass"></i> Visi & Misi
                                    </a>
                                </li>
                            @endif
                            @if(isset($teachers) && $teachers->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#pengajar' : route('jurusan.space', $program->kode) . '#pengajar' }}">
                                        <i class="feather-users"></i> Pengajar
                                    </a>
                                </li>
                            @endif
                            @if(isset($recentNews) && $recentNews->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#berita' : route('jurusan.space', $program->kode) . '#berita' }}">
                                        <i class="feather-rss"></i> Berita
                                    </a>
                                </li>
                            @endif
                            @if(isset($agendaJurusan) && $agendaJurusan->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#agenda' : route('jurusan.space', $program->kode) . '#agenda' }}">
                                        <i class="feather-calendar"></i> Agenda
                                    </a>
                                </li>
                            @endif
                            @if(isset($prestasiJurusan) && $prestasiJurusan->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#prestasi' : route('jurusan.space', $program->kode) . '#prestasi' }}">
                                        <i class="feather-award"></i> Prestasi
                                    </a>
                                </li>
                            @endif
                            @if(isset($projectJurusan) && $projectJurusan->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#project' : route('jurusan.space', $program->kode) . '#project' }}">
                                        <i class="feather-monitor"></i> Project
                                    </a>
                                </li>
                            @endif
                            @if(isset($galleryJurusan) && $galleryJurusan->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#gallery' : route('jurusan.space', $program->kode) . '#gallery' }}">
                                        <i class="feather-image"></i> Galeri
                                    </a>
                                </li>
                            @endif
                            @if(isset($alumniJurusan) && $alumniJurusan->count() > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ $isAboutPage ? '#testimoni' : route('jurusan.space', $program->kode) . '#testimoni' }}">
                                        <i class="feather-message-square"></i> Testimoni
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            @endif

            {{-- Dynamic menu from DB (always outside dropdown) --}}
            @foreach($jurusanMenu as $item)
                @php
                    $itemUrl    = $item->url;
                    $itemActive = $itemUrl && (isset($page) && rtrim($itemUrl, '/') === rtrim($currentUrl, '/'));
                @endphp
                <a href="{{ $itemUrl ?? 'javascript:void(0);' }}"
                   class="jd-nav-link {{ $itemActive ? 'active' : '' }}">
                    @if($item->icon) <i class="{{ $item->icon }}"></i> @else <i class="feather-chevron-right"></i> @endif
                    {{ $item->title }}
                </a>
            @endforeach

            {{-- Back to all --}}
            <a href="{{ route('jurusan.index') }}" class="jd-back-btn">
                <i class="feather-grid"></i>
                Semua Program
            </a>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     MAIN CONTENT
     ══════════════════════════════════════ --}}
<div class="jd-content-area">
    <div class="container">

        @if(isset($page))
            {{-- ── PAGE MODE ── --}}
            <div class="jd-page-content">
                @if($page->image)
                    <img src="{{ asset('storage/'.$page->image) }}" alt="{{ $page->title }}"
                         class="img-fluid rounded mb-4 w-100" style="max-height:400px; object-fit:cover;">
                @elseif($page->banner)
                    <img src="{{ asset('storage/'.$page->banner) }}" alt="{{ $page->title }}"
                         class="img-fluid rounded mb-4 w-100" style="max-height:400px; object-fit:cover;">
                @endif

                <div class="prose">{!! $page->content !!}</div>

                @if($page->attachment)
                    <div class="mt-4 p-4" style="background:#f8f9fa; border-radius:10px; border-left:4px solid var(--color-primary,#007bff);">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <i class="feather-file-text" style="font-size:24px; color:var(--color-primary,#007bff); flex-shrink:0;"></i>
                            <div class="flex-grow-1">
                                <strong style="font-size:15px;">Lampiran Dokumen</strong>
                                <p class="text-muted mb-0" style="font-size:13px;">{{ basename($page->attachment) }}</p>
                            </div>
                            <a href="{{ asset('storage/'.$page->attachment) }}" target="_blank"
                               class="rbt-btn btn-gradient btn-sm" style="border-radius:8px; padding:8px 20px;">
                                <i class="feather-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        @else
            {{-- ── ABOUT MODE ── --}}

            <div class="row g-4">

                {{-- Deskripsi Detail --}}
                @if($program->deskripsi)
                    <div class="col-12" id="overview">
                        <div class="jd-section-card">
                            <div class="jd-section-header">
                                <div class="jd-section-icon"><i class="feather-file-text"></i></div>
                                <h4>Tentang Program Keahlian</h4>
                            </div>
                            <div class="jd-section-body">
                                <div class="row g-4">
                                    <div class="col-lg-{{ ($program->email || $program->phone || $program->tahun_berdiri) ? '8' : '12' }}">
                                        <div class="jd-prose">{!! $program->deskripsi !!}</div>
                                    </div>
                                    @if($program->email || $program->phone || $program->tahun_berdiri)
                                        <div class="col-lg-4">
                                            <div class="p-4 bg-light rounded border">
                                                <h5 class="fw-bold mb-3 text-dark" style="font-size: 16px;"><i class="feather-info me-2"></i>Detail Jurusan</h5>
                                                <ul class="list-unstyled mb-0" style="font-size: 14px; line-height: 2;">
                                                    @if($program->tahun_berdiri)
                                                        <li class="d-flex justify-content-between border-bottom py-2">
                                                            <span class="text-muted">Tahun Berdiri</span>
                                                            <span class="fw-semibold text-dark">{{ $program->tahun_berdiri }}</span>
                                                        </li>
                                                    @endif
                                                    @if($program->email)
                                                        <li class="d-flex justify-content-between border-bottom py-2">
                                                            <span class="text-muted">Email</span>
                                                            <span class="fw-semibold text-dark"><a href="mailto:{{ $program->email }}" class="text-decoration-none text-primary">{{ $program->email }}</a></span>
                                                        </li>
                                                    @endif
                                                    @if($program->phone)
                                                        <li class="d-flex justify-content-between py-2">
                                                            <span class="text-muted">Telepon</span>
                                                            <span class="fw-semibold text-dark">{{ $program->phone }}</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Empty State --}}
                @if(!$program->deskripsi && !$program->kurikulum && !$program->visi && !$program->misi && !$program->tujuan && !$program->profil_lulusan && (!isset($teachers) || !$teachers->count()) && (!isset($recentNews) || !$recentNews->count()) && (!isset($agendaJurusan) || !$agendaJurusan->count()) && (!isset($prestasiJurusan) || !$prestasiJurusan->count()) && (!isset($projectJurusan) || !$projectJurusan->count()) && (!isset($galleryJurusan) || !$galleryJurusan->count()) && (!isset($alumniJurusan) || !$alumniJurusan->count()))
                    <div class="col-12">
                        <div class="text-center py-5 jd-section-card">
                            <i class="feather-book-open" style="font-size:64px; color:#ddd;"></i>
                            <h5 class="mt-3" style="color:#aaa;">Konten Sedang Disiapkan</h5>
                            <p class="text-muted">Informasi lengkap tentang program ini akan segera tersedia.</p>
                        </div>
                    </div>
                @endif

            </div>{{-- end row --}}
        @endif

    </div>
</div>

@if(!isset($page))
    {{-- Visi & Misi --}}
    @if($program->visi || $program->misi)
        <div class="rbt-section-gap bg-color-extra2" id="visimisi">
            <div class="container">
                <div class="row mb--40 text-center">
                    <div class="col-lg-12">
                        <div class="section-title justify-content-center">
                            <span class="subtitle bg-primary-opacity justify-content-center">Visi & Misi</span>
                            <h1 class="title">Read About Our
                                <span class="header-caption">
                                    <span class="cd-headline clip is-full-width">
                                        <span class="cd-words-wrapper">
                                            <b class="is-visible theme-gradient">Mission.</b>
                                            <b class="is-hidden theme-gradient">Vission.</b>
                                        </span>
                                </span>
                                </span>
                            </h1>
                            <p class="description">Visi dan misi program keahlian {{ $program->nama }} untuk mencetak lulusan unggul.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">
                    @if($program->visi)
                        <div class="col-lg-6">
                            <div class="p-5 bg-white rounded-3 h-100 border-top border-primary border-4 shadow-sm" style="transition: all 0.3s ease;">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="bg-primary-opacity rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="feather-eye text-primary fs-4"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0 text-primary" style="font-size: 20px;">Visi</h4>
                                </div>
                                <div class="jd-prose text-dark" style="font-size: 15px; line-height: 1.8;">{!! nl2br(e($program->visi)) !!}</div>
                            </div>
                        </div>
                    @endif
                    @if($program->misi)
                        <div class="col-lg-6">
                            <div class="p-5 bg-white rounded-3 h-100 border-top border-success border-4 shadow-sm" style="transition: all 0.3s ease;">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="bg-success-opacity rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="feather-target text-success fs-4"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0 text-success" style="font-size: 20px;">Misi</h4>
                                </div>
                                <ul class="list-unstyled mb-0 jd-prose text-dark" style="font-size: 15px; line-height: 1.8;">
                                    @foreach(explode("\n", $program->misi) as $misiLine)
                                        @if(trim($misiLine))
                                            <li class="d-flex align-items-start gap-2 mb-3">
                                                <i class="feather-check-circle text-success mt-1" style="font-size: 16px; flex-shrink:0;"></i>
                                                <span>{{ trim($misiLine) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Tujuan --}}
    @if($program->tujuan)
        <div class="rbt-section-gap bg-color-white" id="tujuan">
            <div class="container">
                <div class="row mb--40 text-center">
                    <div class="col-lg-12">
                        <div class="section-title justify-content-center">
                            <span class="subtitle bg-primary-opacity justify-content-center">Target Capaian</span>
                            <h2 class="title">Tujuan Program Keahlian</h2>
                            <p class="description">Fokus utama pengembangan kompetensi siswa pada program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="p-5 bg-color-extra2 rounded-3 shadow-sm border border-light">
                            <div class="row g-4">
                                @php $tujuanIndex = 0; @endphp
                                @foreach(explode("\n", $program->tujuan) as $tujuanLine)
                                    @if(trim($tujuanLine))
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded shadow-sm h-100">
                                                <div class="bg-primary-opacity rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                                    <span class="fw-bold text-primary" style="font-size: 14px;">{{ ++$tujuanIndex }}</span>
                                                </div>
                                                <span class="text-dark fw-medium" style="font-size: 14.5px; line-height: 1.6;">{{ trim($tujuanLine) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Profil Lulusan --}}
    @if($program->profil_lulusan)
        <div class="rbt-section-gap bg-color-extra2" id="profil_lulusan">
            <div class="container">
                <div class="row mb--40 text-center">
                    <div class="col-lg-12">
                        <div class="section-title justify-content-center">
                            <span class="subtitle bg-secondary-opacity justify-content-center">Prospek Karir</span>
                            <h2 class="title">Profil Lulusan</h2>
                            <p class="description">Kompetensi utama dan prospek karir setelah menyelesaikan pendidikan di program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="p-5 bg-white rounded-3 shadow-sm border border-light">
                            <div class="row align-items-center g-5">
                                <div class="col-lg-4 text-center">
                                    <div class="bg-secondary-opacity rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                        <i class="feather-award text-secondary" style="font-size: 48px;"></i>
                                    </div>
                                    <h4 class="fw-bold text-secondary">Kompetensi Lulusan</h4>
                                </div>
                                <div class="col-lg-8 border-start border-md-none">
                                    <div class="jd-prose text-dark px-lg-3" style="font-size: 15.5px; line-height: 1.8;">{!! nl2br(e($program->profil_lulusan)) !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Video Profil embed --}}
    @if($embedUrl)
        <div class="rbt-section-gap bg-color-white" id="video-profil">
            <div class="container">
                <div class="row mb--40 text-center">
                    <div class="col-lg-12">
                        <div class="section-title justify-content-center">
                            <span class="subtitle bg-primary-opacity justify-content-center">Media</span>
                            <h2 class="title">Video Profil Jurusan</h2>
                            <p class="description">Tonton video profil untuk mengenal lebih dekat program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="ratio ratio-16x9 mx-auto shadow-lg rounded-3 overflow-hidden" style="max-width: 800px; border: 4px solid var(--color-white);">
                            <iframe src="{{ $embedUrl }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tim Pengajar --}}
    @if(isset($teachers) && $teachers->count() > 0)
        <div class="rbt-section-gap bg-color-extra2" id="pengajar">
            <div class="container">
                <div class="row mb--40 text-center">
                    <div class="col-lg-12">
                        <div class="section-title justify-content-center">
                            <span class="subtitle bg-primary-opacity justify-content-center">Pendidik</span>
                            <h2 class="title">Tim Pengajar</h2>
                            <p class="description">Guru dan instruktur berpengalaman yang membimbing siswa di program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($teachers as $teacher)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="rbt-card variation-01 rbt-hover h-100" style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-1); border: 1px solid var(--color-border); background: var(--color-white); text-align: center; padding: 24px 16px; transition: all 0.3s ease;">
                                <div class="teacher-photo-wrapper mx-auto mb-3" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid rgba(var(--color-primary-rgb, 0, 123, 255), 0.15); box-shadow: var(--shadow-1);">
                                    @if($teacher->photo)
                                        <img src="{{ asset('storage/'.$teacher->photo) }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-1 d-flex align-items-center justify-content-center h-100 w-100">
                                            <i class="feather-user text-white fs-3"></i>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ Str::limit($teacher->name, 30) }}</h5>
                                @if($teacher->jabatan)
                                    <span class="text-muted small d-block">{{ Str::limit($teacher->jabatan, 45) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    {{-- Berita Jurusan --}}
    @if(isset($recentNews) && $recentNews->count() > 0)
        <div class="rbt-blog-area rbt-sec-cir-shadow-1 rbt-section-gap bg-color-extra2 rbt-section-box" id="berita">
            <div class="gradient-shape-top version-02"></div>
            <div class="gradient-shape-bottom version-02"></div>
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity justify-content-start">Informasi</span>
                            <h2 class="title">Berita Jurusan</h2>
                            <p class="description">Berita dan informasi terbaru mengenai kegiatan dan pencapaian di program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('berita.index', ['jurusan' => $program->id]) }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Semua Berita</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                @php
                    $firstNews = $recentNews->first();
                    $otherNews = $recentNews->skip(1)->take(3);
                @endphp
                <div class="row row--15 d-flex align-items-stretch">
                    <!-- Large Card (Left) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex">
                        <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between w-100" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); flex-grow: 1;">
                            <div>
                                <div class="rbt-card-img" style="height: 280px; overflow: hidden; position: relative;">
                                    <a href="{{ route('berita.show', $firstNews->slug) }}">
                                        @if($firstNews->image)
                                            <img src="{{ asset('storage/' . $firstNews->image) }}" alt="{{ $firstNews->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/site/images/placeholder.jpg') }}" alt="{{ $firstNews->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </a>
                                    <span class="rbt-badge-card position-absolute top-0 start-0 m-3 bg-color-primary color-white" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                        {{ $firstNews->category->data1 ?? 'Berita' }}
                                    </span>
                                </div>
                                
                                <div class="rbt-card-body p--30">
                                    <ul class="rbt-meta mb--10" style="font-size: 12px; color: var(--color-body); list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 15px; margin: 0 0 15px 0;">
                                        <li><i class="feather-calendar"></i> {{ $firstNews->published_at ? $firstNews->published_at->format('d M Y') : '-' }}</li>
                                        <li><i class="feather-eye"></i> {{ $firstNews->view_count ?? 0 }}</li>
                                        @php
                                            $readTimeFirst = ceil(str_word_count(strip_tags($firstNews->content)) / 200);
                                        @endphp
                                        <li><i class="feather-clock"></i> {{ $readTimeFirst > 0 ? $readTimeFirst : 1 }} mnt</li>
                                        <li><i class="feather-user"></i> {{ $firstNews->author ?? 'Admin' }}</li>
                                    </ul>
                                    <h3 class="rbt-card-title mb--15" style="font-size: 20px; line-height: 1.4; font-weight: 700;">
                                        <a href="{{ route('berita.show', $firstNews->slug) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ $firstNews->title }}</a>
                                    </h3>
                                    <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($firstNews->excerpt ?? $firstNews->content), 130) }}</p>
                                </div>
                            </div>
                            
                            <div class="rbt-card-body p--30 pt--0">
                                <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                                    <a class="transparent-button" href="{{ route('berita.show', $firstNews->slug) }}" style="font-size: 13px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 6px; text-decoration: none;">
                                        Selengkapnya
                                        <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- List Cards (Right) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column gap-3 h-100">
                            @foreach($otherNews as $item)
                                <div class="rbt-card card-list variation-02 rbt-hover" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); padding: 16px 20px; margin-top: 0 !important; display: flex; align-items: center; gap: 15px; flex: 1; height: 100%; max-height: none !important; position: relative;">
                                    <div class="rbt-card-img" style="width: 130px; height: 100px; flex-shrink: 0; overflow: hidden; border-radius: 6px; position: relative;">
                                        <a href="{{ route('berita.show', $item->slug) }}">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/site/images/placeholder.jpg') }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="rbt-card-body" style="padding: 0 !important; margin: 0 !important; display: flex; flex-direction: column; justify-content: center; height: 100%; border: none; background: none;">
                                        <div class="d-flex align-items-center gap-2 mb--5">
                                            <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                {{ $item->category->data1 ?? 'Berita' }}
                                            </span>
                                        </div>
                                        <h5 class="rbt-card-title" style="font-size: 16px; line-height: 1.3; font-weight: 600; margin-bottom: 4px;">
                                            <a href="{{ route('berita.show', $item->slug) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ Str::limit($item->title, 55) }}</a>
                                        </h5>
                                        <div style="font-size: 12px; color: var(--color-body); display: flex; gap: 10px; margin-bottom: 5px;">
                                            <span><i class="feather-calendar me-1"></i> {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</span>
                                            <span><i class="feather-eye me-1"></i> {{ $item->view_count ?? 0 }}</span>
                                        </div>
                                        <div class="rbt-card-bottom">
                                            <a class="transparent-button" href="{{ route('berita.show', $item->slug) }}" style="font-size: 12px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 4px; text-decoration: none;">
                                                Detail <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Agenda Jurusan --}}
    @if(isset($agendaJurusan) && $agendaJurusan->count() > 0)
        <div class="rbt-event-area bg-color-white rbt-section-gap" id="agenda">
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity justify-content-start">Kegiatan</span>
                            <h2 class="title">Agenda Jurusan</h2>
                            <p class="description">Jadwal kegiatan, workshop, dan agenda akademik mendatang untuk program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('agenda.index') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Semua Agenda</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row g-5">
                    @foreach($agendaJurusan as $event)
                        @php
                            $startDateTime = \Carbon\Carbon::parse($event->start_datetime);
                            $endDateTime = \Carbon\Carbon::parse($event->end_datetime);
                            $isSameDay = $startDateTime->isSameDay($endDateTime);
                            
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        <div class="col-lg-12">
                            <div class="rbt-card card-list-2 variation-01 rbt-hover d-flex flex-column flex-sm-row gap-4 p--20" style="box-shadow: var(--shadow-1); border-radius: 10px; background: var(--color-white); border: none;">
                                <div class="rbt-card-img" style="width: 100%; max-width: 180px; height: 180px; overflow: hidden; border-radius: 8px; flex-shrink: 0; background: var(--color-light);">
                                    <a href="{{ route('agenda.show', $event->slug) }}">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center text-primary" style="padding: 10px;">
                                                <i class="feather-calendar" style="font-size: 40px; margin-bottom: 8px;"></i>
                                                <span style="font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ $months[$startDateTime->month] }}</span>
                                                <span style="font-size: 28px; font-weight: 800; line-height: 1;">{{ $startDateTime->day }}</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="rbt-card-body p--0 d-flex flex-column justify-content-between" style="flex: 1;">
                                    <div>
                                        <div class="rbt-card-top mb--10">
                                            <ul class="rbt-meta" style="font-size: 13px; display: flex; flex-wrap: wrap; gap: 15px; color: var(--color-body); list-style: none; padding: 0;">
                                                @if($event->location)
                                                    <li><i class="feather-map-pin text-primary"></i> {{ $event->location }}</li>
                                                @endif
                                                <li><i class="feather-calendar text-primary"></i> 
                                                    @if($isSameDay)
                                                        {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} {{ $startDateTime->year }}
                                                    @else
                                                        {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} - {{ $endDateTime->day }} {{ $months[$endDateTime->month] }} {{ $endDateTime->year }}
                                                    @endif
                                                </li>
                                                <li><i class="feather-clock text-primary"></i> {{ $startDateTime->format('H:i') }} WIB</li>
                                            </ul>
                                        </div>
                                        <h5 class="rbt-card-title mb--10" style="font-size: 18px; font-weight: 600; line-height: 1.4;">
                                            <a href="{{ route('agenda.show', $event->slug) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ $event->title }}</a>
                                        </h5>
                                        <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6;">{{ Str::limit(strip_tags($event->excerpt ?? $event->description), 140) }}</p>
                                    </div>
                                    <div class="rbt-card-bottom mt--15">
                                        <a class="transparent-button" href="{{ route('agenda.show', $event->slug) }}" style="font-size: 14px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 8px; text-decoration: none;">
                                            Detail Agenda
                                            <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Prestasi Siswa Jurusan --}}
    @if(isset($prestasiJurusan) && $prestasiJurusan->count() > 0)
        <div class="rbt-course-area rbt-sec-cir-shadow-1 bg-color-extra2 rbt-section-gap rbt-section-box" id="prestasi">
            <div class="gradient-shape-top"></div>
            <div class="gradient-shape-bottom"></div>
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity justify-content-start">Prestasi</span>
                            <h2 class="title">Prestasi Siswa Jurusan</h2>
                            <p class="description">Apresiasi atas prestasi, penghargaan, dan kejuaraan yang diraih oleh siswa-siswi program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('prestasi.index') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Semua Prestasi</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                @php
                    $firstPres = $prestasiJurusan->first();
                    $otherPres = $prestasiJurusan->skip(1)->take(3);
                @endphp
                <div class="row row--15 d-flex align-items-stretch">
                    <!-- Large Card (Left) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex">
                        <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between w-100" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); flex-grow: 1;">
                            <div>
                                <div class="rbt-card-img" style="height: 280px; overflow: hidden; position: relative; background: linear-gradient(135deg, rgba(31, 95, 237, 0.1) 0%, rgba(228, 18, 114, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                    @php $photos = $firstPres->photo_urls; @endphp
                                    @if(count($photos) > 0)
                                        <img src="{{ $photos[0] }}" alt="{{ $firstPres->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/site/images/icons/trophy.png') }}" alt="Trophy" style="width: 80px; height: auto; opacity: 0.9;">
                                    @endif
                                    <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Icon" style="position: absolute; top: 15px; right: 15px; z-index: 10; width: 48px; height: 48px; object-fit: contain; pointer-events: none;">
                                    <span class="rbt-badge-card position-absolute top-0 start-0 m-3 bg-color-primary color-white" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">Siswa</span>
                                </div>
                                <div class="rbt-card-body p--30">
                                    <div class="rbt-card-top mb--10 d-flex justify-content-between align-items-center">
                                        <div class="rbt-review" style="font-size: 13px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 5px;">
                                            <i class="feather-award text-warning" style="font-size: 16px;"></i>
                                            <span>{{ $firstPres->achiever }}</span>
                                        </div>
                                        @if($firstPres->tingkat)
                                            <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                                                {{ $firstPres->tingkat->data1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="rbt-card-title mb--15" style="font-size: 20px; line-height: 1.4; font-weight: 700;">
                                        <a href="{{ route('prestasi.show', $firstPres->id) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ $firstPres->title }}</a>
                                    </h3>
                                    <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($firstPres->description), 130) }}</p>
                                </div>
                            </div>
                            <div class="rbt-card-body p--30 pt--0">
                                <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                                    <a class="transparent-button" href="{{ route('prestasi.show', $firstPres->id) }}" style="font-size: 13px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 6px; text-decoration: none;">
                                        Detail Prestasi
                                        <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- List Cards (Right) -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column gap-3 h-100">
                            @foreach($otherPres as $item)
                                <div class="rbt-card card-list variation-02 rbt-hover" style="border: none; box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); padding: 16px 20px; margin-top: 0 !important; display: flex; align-items: center; gap: 15px; flex: 1; height: 100%;">
                                    <div class="rbt-card-img" style="width: 130px; height: 100px; flex-shrink: 0; overflow: hidden; border-radius: 6px; position: relative; background: linear-gradient(135deg, rgba(31, 95, 237, 0.05) 0%, rgba(228, 18, 114, 0.05) 100%); display: flex; align-items: center; justify-content: center;">
                                        @php $subPhotos = $item->photo_urls; @endphp
                                        @if(count($subPhotos) > 0)
                                            <img src="{{ $subPhotos[0] }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/site/images/icons/trophy.png') }}" alt="Trophy" style="width: 44px; height: auto; opacity: 0.8;">
                                        @endif
                                    </div>
                                    <div class="rbt-card-body" style="padding: 0 !important; margin: 0 !important; display: flex; flex-direction: column; justify-content: center; height: 100%;">
                                        <div class="d-flex align-items-center gap-2 mb--5">
                                            <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                {{ Str::limit($item->achiever, 20) }}
                                            </span>
                                            @if($item->tingkat)
                                                <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; line-height: 1;">
                                                    {{ $item->tingkat->data1 }}
                                                </span>
                                            @endif
                                        </div>
                                        <h5 class="rbt-card-title" style="font-size: 16px; line-height: 1.3; font-weight: 600; margin-bottom: 4px;">
                                            <a href="{{ route('prestasi.show', $item->id) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ Str::limit($item->title, 55) }}</a>
                                        </h5>
                                        <div class="rbt-card-bottom">
                                            <a class="transparent-button" href="{{ route('prestasi.show', $item->id) }}" style="font-size: 12px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 4px; text-decoration: none;">
                                                Detail <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Project Siswa Jurusan --}}
    @if(isset($projectJurusan) && $projectJurusan->count() > 0)
        <div class="rbt-blog-area bg-color-white rbt-section-gap" id="project">
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity justify-content-start">Karya Kreatif</span>
                            <h2 class="title">Project Siswa Jurusan</h2>
                            <p class="description">Kumpulan karya, portfolio aplikasi, dan project nyata yang diciptakan oleh siswa-siswi program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ url('/project') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Lihat Semua Project</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($projectJurusan as $project)
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--color-border); box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white);">
                                <div>
                                    <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative;">
                                        @if($project->data2)
                                            <img src="{{ asset('storage/' . $project->data2) }}" alt="{{ $project->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100" style="height: 220px;">
                                                <i class="feather-monitor fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h5 class="rbt-card-title mb-2" style="font-size: 15px; font-weight: 700; line-height: 1.4;">
                                            <a href="{{ route('project.show', $project->id) }}" style="color: var(--color-heading); transition: 0.3s; text-decoration: none;">{{ Str::limit($project->data1, 60) }}</a>
                                        </h5>
                                        <p class="text-muted small mb-0">{{ Str::limit($project->text1, 120) }}</p>
                                    </div>
                                </div>
                                <div class="p-3 pt-0">
                                    @if($project->data4)
                                        @php
                                            $linkedNews = \App\Models\News::find($project->data4);
                                        @endphp
                                        @if($linkedNews)
                                            <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 10px;">
                                                <a class="transparent-button" href="{{ route('berita.show', $linkedNews->slug) }}" style="font-size: 12px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 4px; text-decoration: none;">
                                                    Baca Berita
                                                    <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Gallery Jurusan --}}
    @if(isset($galleryJurusan) && $galleryJurusan->count() > 0)
        <div class="rbt-gallery-area bg-color-extra2 rbt-section-gap" id="gallery">
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity justify-content-start">Dokumentasi</span>
                            <h2 class="title">Galeri Kegiatan Jurusan</h2>
                            <p class="description">Dokumentasi visual dari berbagai program, kompetisi, seminar, and aktivitas pembelajaran di program keahlian {{ $program->nama }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('gallery.index') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Semua Galeri</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($galleryJurusan as $gal)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            @include('partials.site.gallery-card', ['gal' => $gal])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Testimoni Alumni Jurusan --}}
    @if(isset($alumniJurusan) && $alumniJurusan->count() > 0)
        <div class="rbt-testimonial-area bg-color-white rbt-section-gap" id="testimoni">
            <div class="container">
                <div class="row g-5 align-items-end mb--40">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-secondary-opacity justify-content-start">Sukses Alumni</span>
                            <h2 class="title">Testimoni Alumni Jurusan</h2>
                            <p class="description">Bagaimana lulusan program keahlian {{ $program->nama }} berkiprah di dunia usaha, industri, maupun perguruan tinggi.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="load-more-btn text-start text-md-end">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('site.alumni.testimonials') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Semua Testimoni</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="position-relative">
                    <div class="alumni-swiper-activation swiper ptb--20" style="overflow: hidden;">
                        <div class="swiper-wrapper">
                            @foreach($alumniJurusan as $alm)
                                <div class="swiper-slide h-auto p-2">
                                    <div class="rbt-testimonial-box h-100" style="box-shadow: var(--shadow-1); border-radius: 12px; border: 1px solid var(--color-border); transition: all 0.3s ease;">
                                        <div class="inner p--30">
                                            <div class="clint-info-wrapper d-flex align-items-center gap-3">
                                                <div class="thumb" style="width: 65px; height: 65px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--color-primary-opacity);">
                                                    @if($alm->photo)
                                                        <img src="{{ asset('storage/' . $alm->photo) }}" alt="{{ $alm->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                                                            <i class="feather-user text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title mb--0" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h5>
                                                    <span style="font-size: 12px; color: var(--color-body);">Lulusan {{ $alm->tahun_lulus }}</span>
                                                </div>
                                            </div>
                                            <div class="description mt--20">
                                                <div class="d-flex flex-wrap gap-1 mb--15">
                                                    <span class="rbt-badge-5 bg-color-primary-opacity color-primary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px;">
                                                        {{ $alm->status_alumni }}
                                                    </span>
                                                    @if($alm->tempat_kerja)
                                                        <span class="rbt-badge-5 bg-color-secondary-opacity color-secondary" style="font-size: 10px; padding: 2px 6px; font-weight: 600; border-radius: 3px; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                            {{ $alm->tempat_kerja }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($alm->testimoni)
                                                    <p class="subtitle-3" style="font-size: 13.5px; line-height: 1.6; font-style: italic; color: var(--color-body);">"{{ $alm->testimoni }}"</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add Arrows Navigation -->
                    <div class="d-flex justify-content-center gap-3 rbt-arrow-between mt--30">
                        <div class="rbt-swiper-arrow style_2 rbt-arrow-left alumni-arrow-left" tabindex="0" role="button">
                            <div class="custom-overfolow">
                                <i class="rbt-icon feather-arrow-left"></i>
                                <i class="rbt-icon-top feather-arrow-left"></i>
                            </div>
                        </div>
                        <div class="rbt-swiper-arrow style_2 rbt-arrow-right alumni-arrow-right" tabindex="0" role="button">
                            <div class="custom-overfolow">
                                <i class="rbt-icon feather-arrow-right"></i>
                                <i class="rbt-icon-top feather-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mobile navigation toggle
    const mobileHeader = document.querySelector('.jd-mobile-header');
    const navInner = document.querySelector('.jd-sticky-nav-inner');
    const toggleText = document.querySelector('.jd-mobile-toggle-text');
    
    if (mobileHeader && navInner) {
        mobileHeader.addEventListener('click', function () {
            const isShown = navInner.classList.toggle('show');
            mobileHeader.classList.toggle('active');
            if (toggleText) {
                toggleText.textContent = isShown ? 'Tutup' : 'Buka';
            }
        });
        
        // Auto-close menu when a nav link is clicked on mobile
        const mobileLinks = navInner.querySelectorAll('.jd-nav-link, .dropdown-item');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function () {
                if (!link.classList.contains('dropdown-toggle')) {
                    navInner.classList.remove('show');
                    mobileHeader.classList.remove('active');
                    if (toggleText) {
                        toggleText.textContent = 'Buka';
                    }
                }
            });
        });
    }

    // Active state for anchor-based nav
    const navLinks = document.querySelectorAll('.jd-nav-link[href^="#"]');
    const dropdownToggle = document.querySelector('.jd-sticky-nav .dropdown-toggle');
    const dropdownItems = document.querySelectorAll('.jd-sticky-nav .dropdown-item[href*="#"]');
    
    if (navLinks.length > 0 || dropdownItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    
                    // Reset active states
                    navLinks.forEach(l => l.classList.remove('active'));
                    if (dropdownToggle) dropdownToggle.classList.remove('active');
                    
                    // Check standard link match
                    const match = document.querySelector(`.jd-nav-link[href="#${id}"]`);
                    if (match) {
                        match.classList.add('active');
                    } else {
                        // Check if it matches a dropdown item (href ends with #id)
                        const matchDropdown = document.querySelector(`.jd-sticky-nav .dropdown-item[href$="#${id}"]`);
                        if (matchDropdown && dropdownToggle) {
                            dropdownToggle.classList.add('active');
                        }
                    }
                }
            });
        }, { threshold: 0.4 });

        document.querySelectorAll('[id]').forEach(sec => observer.observe(sec));
    }

    if (document.querySelector('.alumni-swiper-activation')) {
        new Swiper(".alumni-swiper-activation", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".alumni-arrow-right",
                prevEl: ".alumni-arrow-left",
                clickable: true,
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
            },
        });
    }
});
</script>
@endpush
