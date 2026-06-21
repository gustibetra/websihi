@extends('layouts.site')

@section('title', $structure->data1)

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
    justify-content: center !important;
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
    position: relative !important;
}
.group-label-full::after {
    content: "" !important;
    position: absolute !important;
    bottom: -2px !important;
    left: 0 !important;
    width: 80px !important;
    height: 3px !important;
    background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary) 100%) !important;
    border-radius: 3px !important;
    z-index: 1 !important;
}
.group-label-content {
    display: flex !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 10px !important;
}
.group-label-title {
    font-size: 18px !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary) 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    display: inline-block !important;
}
.group-label-logo img {
    height: 35px !important;
    width: auto !important;
    object-fit: contain !important;
}

/* ── Gradient Section Header — Compact, all-corner rounded ─────────────── */
.struktur-section-header { margin-bottom: 20px !important; }
.struktur-section-header-inner {
    display: flex !important; align-items: center !important; gap: 12px !important;
    padding: 11px 18px !important;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%) !important;
    border-radius: 10px !important; position: relative !important; overflow: hidden !important;
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
    color: #fff !important; font-size: 14px !important; font-weight: 600 !important;
    margin: 0 !important; letter-spacing: 0.3px !important; text-shadow: 0 1px 2px rgba(0,0,0,0.12) !important;
}
.struktur-section-logo { margin-left: auto !important; flex-shrink: 0 !important; }
.struktur-section-logo img {
    height: 28px !important; width: auto !important; object-fit: contain !important;
    filter: brightness(0) invert(1) !important; opacity: 0.8 !important;
}
.struktur-section-divider { display: none !important; }

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
}
.member-detail-modal-header .btn-close:hover { opacity: 1 !important; }
.member-detail-modal-body { padding: 0 !important; }
.member-modal-photo-col {
    background: linear-gradient(180deg, rgba(31,95,237,0.04) 0%, rgba(228,18,114,0.04) 100%) !important;
    padding: 30px 20px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    border-right: 1px solid var(--color-border) !important;
    min-height: 300px !important;
}
.member-modal-info-col { padding: 26px 26px 22px !important; }
.member-modal-avatar-wrap {
    width: 130px !important;
    height: 130px !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    border: 4px solid var(--color-white) !important;
    box-shadow: 0 8px 24px rgba(31,95,237,0.18) !important;
    background: var(--color-light) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin-bottom: 14px !important;
}
.member-modal-avatar-wrap img { width: 100% !important; height: 100% !important; object-fit: cover !important; }
.member-modal-avatar-icon { font-size: 58px !important; color: var(--color-primary) !important; opacity: 0.6 !important; }
.member-modal-position-chip {
    display: inline-block !important;
    padding: 5px 14px !important;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%) !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    border-radius: 20px !important;
    text-align: center !important;
    max-width: 175px !important;
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
    margin-bottom: 16px !important;
}
.member-modal-divider { height: 1px !important; background: var(--color-border) !important; margin-bottom: 16px !important; }
.member-modal-info-grid { display: flex !important; flex-direction: column !important; gap: 10px !important; }
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
    width: 32px !important; height: 32px !important; border-radius: 8px !important;
    background: var(--color-primary-opacity) !important;
    display: flex !important; align-items: center !important; justify-content: center !important;
    flex-shrink: 0 !important; margin-top: 1px !important;
}
.member-modal-info-icon i { font-size: 15px !important; color: var(--color-primary) !important; }
.member-modal-info-text { flex: 1 !important; min-width: 0 !important; }
.member-modal-info-label {
    font-size: 11px !important; font-weight: 600 !important;
    text-transform: uppercase !important; letter-spacing: 0.5px !important;
    color: var(--color-body) !important; opacity: 0.7 !important; margin-bottom: 2px !important;
}
.member-modal-info-value {
    font-size: 14px !important; font-weight: 500 !important;
    color: var(--color-heading) !important; word-break: break-word !important; line-height: 1.4 !important;
}

/* Header & Tab styles */
.org-show-header {
    background: var(--color-white) !important;
    border: 1px solid var(--color-border) !important;
    border-radius: 12px !important;
    box-shadow: var(--shadow-1) !important;
}
.org-show-logo-wrap {
    width: 120px !important;
    height: 120px !important;
    background: linear-gradient(135deg, rgba(31, 95, 237, 0.05) 0%, rgba(228, 18, 114, 0.05) 100%) !important;
    border: 1px solid var(--color-border) !important;
    border-radius: 10px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden !important;
    flex-shrink: 0 !important;
}
.org-show-logo-wrap img {
    max-width: 90px !important;
    max-height: 90px !important;
    object-fit: contain !important;
}
.org-show-logo-wrap i {
    font-size: 50px !important;
    color: var(--color-primary) !important;
}
.org-show-title {
    font-size: 28px !important;
    font-weight: 750 !important;
    color: var(--color-heading) !important;
    margin-bottom: 8px !important;
}
.org-show-meta {
    font-size: 14px !important;
    color: var(--color-body) !important;
    display: flex !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 15px !important;
}
.org-show-meta span {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
}
.org-show-meta i {
    color: var(--color-primary) !important;
    font-size: 16px !important;
}

.rbt-course-tab-button-wrap {
    border-bottom: 2px solid var(--color-border-2) !important;
    margin-bottom: 30px !important;
}
.rbt-course-tab-button {
    border: none !important;
    margin-bottom: -2px !important;
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
                    <h2 class="title">{{ $structure->data1 }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('site.ekskul.index') }}">Ekstrakurikuler</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($structure->data1, 35) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Show Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5">
            {{-- Left Sidebar Menu --}}
            <div class="col-lg-3 col-12">
                <aside class="rbt-sidebar-widget-wrapper">
                    @php
                    $otherStructures = \App\Models\Common::where('table_name', 'structure')
                        ->where('key2', 'ekskul')
                        ->where('is_active', true)
                        ->orderBy('data1', 'asc')
                        ->get();
                    @endphp
                    
                    <div class="rbt-single-widget" style="padding: 25px; background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border);">
                        <h5 class="rbt-widget-title" style="font-size: 16px; font-weight: 700; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px;">
                            Ekstrakurikuler
                        </h5>
                        
                        @if($otherStructures->count() > 0)
                        <ul class="rbt-sidebar-list-wrapper recent-post-list" style="margin: 0; padding: 0; list-style: none;">
                            @foreach($otherStructures as $item)
                            <li style="margin-bottom: 10px; display: block;">
                                <a href="{{ route('site.ekskul.show', $item->key1) }}" 
                                   class="rbt-btn btn-xs w-100 justify-content-start {{ $item->id == $structure->id ? 'btn-gradient' : 'btn-border' }}"
                                   style="padding: 12px 15px; height: auto; text-align: left; text-transform: none; border-radius: 6px; font-size: 14px; font-weight: 500; display: flex; align-items: center;">
                                    <i class="feather-chevron-right" style="margin-right: 8px; font-size: 16px; top: 0;"></i>
                                    <span style="white-space: normal; line-height: 1.3;">{{ $item->data1 }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </aside>
            </div>
            
            {{-- Main Content --}}
            <div class="col-lg-9 col-12">
                {{-- Header Box --}}
                <div class="org-show-header p--30 mb--40 d-flex align-items-center gap-4 flex-wrap flex-sm-nowrap">
                    <div class="org-show-logo-wrap">
                        @if($structure->data6)
                            <img src="{{ asset('storage/' . $structure->data6) }}" alt="{{ $structure->data1 }}">
                        @else
                            <i class="ri-basketball-line"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="org-show-title">{{ $structure->data1 }}</h3>
                        <div class="org-show-meta">
                            <span>
                                <i class="ri-calendar-line"></i>
                                Periode: <strong>{{ $structure->period?->key1 ?? $structure->period?->data1 ?? '2024/2025' }}</strong>
                            </span>
                            <span>
                                <i class="ri-award-line"></i>
                                Kategori: <strong>Ekstrakurikuler Sekolah</strong>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tab Navigation --}}
                <div class="rbt-course-tab-button-wrap">
                    <ul class="rbt-course-tab-button nav nav-tabs" id="orgDetailsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-pane" type="button" role="tab" aria-controls="detail-pane" aria-selected="true">
                                <span class="filter-text">Detail</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="structure-tab" data-bs-toggle="tab" data-bs-target="#structure-pane" type="button" role="tab" aria-controls="structure-pane" aria-selected="false">
                                <span class="filter-text">Struktur</span>
                            </button>
                        </li>
                    </ul>
                </div>

                {{-- Tab Contents --}}
                <div class="tab-content" id="orgDetailsTabContent">
                    {{-- Detail Tab Pane --}}
                    <div class="tab-pane fade show active" id="detail-pane" role="tabpanel" aria-labelledby="detail-tab">
                        <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 40px; background: var(--color-white);">
                            <h4 class="mb--20" style="font-size: 20px; font-weight: 700; color: var(--color-heading);">Profil & Visi Misi</h4>
                            <div class="content rbt-article-content" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                                @if($structure->text1)
                                    {!! $structure->text1 !!}
                                @else
                                    <div class="text-muted text-center py-5">
                                        <i class="ri-file-text-line" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 15px;"></i>
                                        Profil, deskripsi lengkap, serta visi misi untuk ekstrakurikuler ini belum diisi.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Struktur Tab Pane --}}
                    <div class="tab-pane fade" id="structure-pane" role="tabpanel" aria-labelledby="structure-tab">
                        @php
                        $getMemberAttributes = function($structureMember) use ($structure) {
                            $person = $structureMember->getPerson();
                            if (!$person) {
                                return '';
                            }

                            $photo = $person->photo ? asset('storage/' . $person->photo) : '';
                            $position = $structureMember->position ?: 'Anggota';
                            $memberId = $person->id ?? '-';
                            $period = $structureMember->period ?? '-';
                            
                            $sdmCategory = 'Anggota';
                            $identitas = '-';
                            $detailTambahan = '-';

                            if ($person instanceof \App\Models\Teacher) {
                                $sdmCategory = 'Guru & Tenaga Kependidikan';
                                $identitas = $person->nip ? 'NIP: ' . $person->nip : 'Bidang Studi: ' . ($person->bidang_studi ?: '-');
                                $detailTambahan = $person->jabatan ?: '-';
                            } elseif ($person instanceof \App\Models\Student) {
                                $sdmCategory = 'Siswa';
                                $identitas = $person->nisn ? 'NISN: ' . $person->nisn : 'NIS: ' . ($person->nis ?: '-');
                                
                                $kelas = \App\Models\Common::where('table_name', 'kelas')->find($person->kelas_id);
                                $jurusan = \App\Models\Common::where('table_name', 'jurusan')->find($person->jurusan_id);
                                $detailTambahan = ($kelas ? $kelas->data1 : '') . ($jurusan ? ' (' . $jurusan->data2 . ')' : '');
                            }

                            $currentStructureLabel = $structure->data1 ?? $structure->key1 ?? '-';
                            $isActive = (bool) $structureMember->is_active;

                            return 'role="button" tabindex="0" class="member-card member-card-clickable" data-member-photo="' . e($photo) . '" data-member-name="' . e($person->name) . '" data-member-id="' . e($memberId) . '" data-member-gender="' . e($person->gender) . '" data-member-period="' . e($period) . '" data-member-position="' . e($position) . '" data-member-party="' . e($identitas) . '" data-member-fraction="' . e($sdmCategory) . '" data-member-dapil="' . e($detailTambahan) . '" data-member-structure="' . e($currentStructureLabel) . '" data-member-active="' . ($isActive ? '1' : '0') . '"';
                        };
                        @endphp

                        {{-- Loop through sections --}}
                        @forelse($sections as $section)
                            @php
                                $membersInSection = $section->assigned_members ?? collect();
                            @endphp
                            
                            @if($membersInSection->isNotEmpty())
                                <div class="row justify-content-center mb-5">
                                    <div class="col-12 mb-4">
                                        <div class="struktur-section-header">
                                            <div class="struktur-section-header-inner">
                                                <div class="struktur-section-icon">
                                                    <i class="ri-team-line"></i>
                                                </div>
                                                <div class="struktur-section-text">
                                                    <h4 class="struktur-section-title">{{ $section->name }}</h4>
                                                </div>
                                                @php
                                                if (!isset($settings)) {
                                                    $settings = app(\App\Models\Setting::class)->first();
                                                    $logoPath = $settings && $settings->logo_square ? $settings->logo_square : ($settings && $settings->logo ? $settings->logo : null);
                                                }
                                                @endphp
                                                @if(isset($logoPath) && $logoPath)
                                                <div class="struktur-section-logo">
                                                    <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo">
                                                </div>
                                                @endif
                                            </div>
                                            <div class="struktur-section-divider"></div>
                                        </div>
                                    </div>

                                    @foreach($membersInSection as $structureMember)
                                        @php $person = $structureMember->getPerson(); @endphp
                                        @if($person)
                                            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                                                <div {!! $getMemberAttributes($structureMember) !!}>
                                                    @if($person->photo)
                                                    <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="member-photo-full">
                                                    @else
                                                    <div class="member-photo-full d-flex align-items-center justify-content-center" style="background: var(--color-light) !important; border: 3px solid var(--color-border) !important; border-radius: 50% !important; margin-bottom: 15px !important; transition: all 0.3s ease !important;">
                                                        <i class="ri-user-line" style="font-size: 50px; color: var(--color-primary);"></i>
                                                    </div>
                                                    @endif
                                                    <h5 class="member-name">{{ $person->name }}</h5>
                                                    <p class="member-position">{{ $structureMember->position }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @empty
                            {{-- No sections --}}
                        @endforelse

                        {{-- Unassigned Members --}}
                        @if(isset($unassignedMembers) && $unassignedMembers->isNotEmpty())
                            <div class="row justify-content-center mb-5">
                                <div class="col-12 mb-3">
                                    <div class="group-label-full">
                                        <div class="group-label-content">
                                            <span class="group-label-title">Anggota</span>
                                        </div>
                                        @if(isset($logoPath) && $logoPath)
                                        <div class="group-label-logo">
                                            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @foreach($unassignedMembers as $structureMember)
                                    @php $person = $structureMember->getPerson(); @endphp
                                    @if($person)
                                        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                                            <div {!! $getMemberAttributes($structureMember) !!}>
                                                @if($person->photo)
                                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="member-photo-full">
                                                @else
                                                <div class="member-photo-full d-flex align-items-center justify-content-center" style="background: var(--color-light) !important; border: 3px solid var(--color-border) !important; border-radius: 50% !important; margin-bottom: 15px !important; transition: all 0.3s ease !important;">
                                                    <i class="ri-user-line" style="font-size: 50px; color: var(--color-primary);"></i>
                                                </div>
                                                @endif
                                                <h5 class="member-name">{{ $person->name }}</h5>
                                                <p class="member-position">{{ $structureMember->position }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @if($sections->isEmpty() && (!isset($unassignedMembers) || $unassignedMembers->isEmpty()))
                            <div class="row">
                                <div class="col-12">
                                    <div style="text-align: center; padding: 60px; background: #f9fafb; border-radius: 8px;">
                                        <i class="ri-user-line" style="font-size: 64px; color: #d1d5db; margin-bottom: 20px;"></i>
                                        <h5 style="color: #6b7280; margin: 0;">Belum ada anggota kepengurusan</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member Detail Modal -->
<div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg member-detail-modal-dialog">
        <div class="modal-content member-detail-modal-content">
            <div class="modal-header member-detail-modal-header">
                <h5 class="modal-title member-detail-modal-title" id="memberDetailModalLabel">
                    <i class="ri-user-line me-2"></i>Informasi Detail Anggota
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body member-detail-modal-body">
                <div class="row g-4 align-items-start">
                    <div class="col-md-4 text-center">
                        <div class="member-detail-photo-wrap d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 250px; background: var(--color-light);">
                            <img id="memberDetailPhoto" src="" alt="" class="img-fluid member-detail-photo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <div id="memberDetailPhotoFallback" style="font-size: 80px; color: var(--color-primary); display: none;">
                                <i class="ri-user-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="member-detail-topline mb-2">
                            <div class="member-detail-name-block">
                                <h4 id="memberDetailName" class="member-detail-name mb-1"></h4>
                                <span id="memberDetailPosition" class="member-detail-position-badge"></span>
                            </div>
                            <span id="memberDetailStructure" class="member-detail-structure-badge"></span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless table-sm mb-0 member-detail-table">
                                <tbody>
                                    <tr>
                                        <td class="member-detail-label" style="width: 200px;"><i class="ri-calendar-line me-2"></i>Periode</td>
                                        <td class="member-detail-value"><span id="memberDetailPeriod" class="badge bg-info-subtle text-info">-</span></td>
                                    </tr>
                                    <tr>
                                        <td class="member-detail-label"><i class="ri-user-settings-line me-2"></i>Kategori SDM</td>
                                        <td id="memberDetailFraction" class="member-detail-value">-</td>
                                    </tr>
                                    <tr>
                                        <td class="member-detail-label"><i class="ri-profile-line me-2"></i>Identitas / Keterangan</td>
                                        <td id="memberDetailParty" class="member-detail-value">-</td>
                                    </tr>
                                    <tr>
                                        <td class="member-detail-label"><i class="ri-information-line me-2"></i>Detail Tambahan</td>
                                        <td id="memberDetailDapil" class="member-detail-value">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/site/js/struktur.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const clickableCards = document.querySelectorAll('.member-card-clickable');
    const modalPhoto = document.getElementById('memberDetailPhoto');
    const modalFallback = document.getElementById('memberDetailPhotoFallback');
    
    if (clickableCards.length > 0 && modalPhoto && modalFallback) {
        clickableCards.forEach(card => {
            card.addEventListener('click', function() {
                const photo = this.getAttribute('data-member-photo') || '';
                if (photo) {
                    modalPhoto.src = photo;
                    modalPhoto.style.display = 'block';
                    modalFallback.style.display = 'none';
                } else {
                    modalPhoto.src = '';
                    modalPhoto.style.display = 'none';
                    modalFallback.style.display = 'block';
                }
            });
        });
    }
});
</script>
@endpush
