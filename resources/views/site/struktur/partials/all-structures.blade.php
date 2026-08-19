{{-- Semua Struktur: Semua Organisasi Sekolah, Semua OSIS, Semua Ekskul, dll --}}

@php
$getMemberAttributes = function($structureMember, $structure, $page) {
    $person = $structureMember->getPerson();
    if (!$person) {
        return '';
    }

    $photo = $person->photo ? asset('storage/' . $person->photo) : '';
    $position = $structureMember->position ?: 'Anggota';
    $memberId = $person->id ?? '-';
    $period = $structureMember->period ?? $page->period ?? '-';
    
    // Map dynamic fields based on model class
    $sdmCategory = 'Anggota';
    $identitas = '-';
    $detailTambahan = '-';

    if ($person instanceof \App\Models\Teacher) {
        $sdmCategory = 'Guru & Tenaga Kependidikan';
        $identitas = $person->nip ? 'NIP: ' . $person->nip : 'Bidang Studi: ' . ($person->bidang_studi ?: '-');
        $detailTambahan = $person->description ?: '-';
    } elseif ($person instanceof \App\Models\Student) {
        $sdmCategory = 'Siswa';
        $identitas = $person->nisn ? 'NISN: ' . $person->nisn : 'NIS: ' . ($person->nis ?: '-');
        
        $kelas = \App\Models\Common::where('table_name', 'kelas')->find($person->kelas_id);
        $jurusan = \App\Models\Common::where('table_name', 'jurusan')->find($person->jurusan_id);
        $detailTambahan = ($kelas ? $kelas->data1 : '') . ($jurusan ? ' (' . $jurusan->data2 . ')' : '');
    } elseif ($person instanceof \App\Models\StructuralMember) {
        $sdmCategory = 'Struktural Yayasan';
        $identitas = 'Jabatan: ' . ($person->jabatan ?: '-');
        $detailTambahan = $person->description ?: '-';
    } elseif ($person instanceof \App\Models\Alumni) {
        $sdmCategory = 'Alumni';
        $identitas = 'Tahun Lulus: ' . ($person->tahun_lulus ?: '-');
        $detailTambahan = $person->tempat_kerja ? 'Bekerja di: ' . $person->tempat_kerja : 'Alumni';
    }

    $currentStructureLabel = $structure->data1 ?? $structure->key1 ?? $page->title ?? '-';
    $isActive = (bool) $structureMember->is_active;

    return 'role="button" tabindex="0" class="member-card member-card-clickable" data-member-photo="' . e($photo) . '" data-member-name="' . e($person->name) . '" data-member-id="' . e($memberId) . '" data-member-gender="' . e($person->gender) . '" data-member-period="' . e($period) . '" data-member-position="' . e($position) . '" data-member-party="' . e($identitas) . '" data-member-fraction="' . e($sdmCategory) . '" data-member-dapil="' . e($detailTambahan) . '" data-member-structure="' . e($currentStructureLabel) . '" data-member-active="' . ($isActive ? '1' : '0') . '"';
};
@endphp

@foreach($structures as $structure)
    <div class="row justify-content-center mb-5 border-bottom pb-4">
        <div class="col-12 mb-3">
            <div class="group-label-full">
                <div class="group-label-content">
                    <span class="group-label-title" style="font-size: 18px; font-weight: 700; color: var(--rs-theme-primary);">{{ $structure->data1 ?? $structure->key1 }}</span>
                    @if($structure->text1)
                    <span class="group-label-separator">|</span>
                    <span class="group-label-subtitle">{{ $structure->text1 }}</span>
                    @endif
                </div>
                @php
                $settings = app(\App\Models\Setting::class)->first();
                $logoPath = $settings && $settings->logo_square ? $settings->logo_square : ($settings && $settings->logo ? $settings->logo : null);
                @endphp
                @if($logoPath)
                <div class="group-label-logo">
                    <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo">
                </div>
                @endif
            </div>
        </div>

        {{-- Loop through sections of this structure --}}
        @php
            $sectionsData = $structure->sections_data ?? collect();
            $unassignedMembers = $structure->unassigned_members ?? collect();
            $hasMembers = false;
        @endphp

        @foreach($sectionsData as $section)
            @php
                $membersInSection = $section->assigned_members ?? collect();
            @endphp
            @if($membersInSection->isNotEmpty())
                @php $hasMembers = true; @endphp
                <div class="col-12 mt-3 mb-2">
                    <h6 class="fw-bold" style="font-size: 14px; letter-spacing: 0.5px; background: linear-gradient(90deg, #2F57EF 0%, #13294B 100%); color: #ffffff; padding: 10px 18px; border-radius: 8px; display: flex; align-items: center; gap: 8px; text-transform: uppercase;">
    <i class="ri-team-line" style="font-size: 16px;"></i>
    {{ strtoupper($section->name) }}
</h6>
                </div>
                @foreach($membersInSection as $structureMember)
                    @php $person = $structureMember->getPerson(); @endphp
                    @if($person)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div {!! $getMemberAttributes($structureMember, $structure, $page) !!}>
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
            @endif
        @endforeach

        {{-- Unassigned members --}}
        @if($unassignedMembers->isNotEmpty())
            @php $hasMembers = true; @endphp
            <div class="col-12 mt-3 mb-2">
                <h6 class="fw-bold" style="font-size: 14px; letter-spacing: 0.5px; background: linear-gradient(90deg, #2F57EF 0%, #13294B 100%); color: #ffffff; padding: 10px 18px; border-radius: 8px; display: flex; align-items: center; gap: 8px; text-transform: uppercase;">
    <i class="ri-group-line" style="font-size: 16px;"></i>
    ANGGOTA
</h6>
            </div>
            @foreach($unassignedMembers as $structureMember)
                @php $person = $structureMember->getPerson(); @endphp
                @if($person)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div {!! $getMemberAttributes($structureMember, $structure, $page) !!}>
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
        @endif

        @if(!$hasMembers)
            <div class="col-12">
                <div style="text-align: center; padding: 30px; background: #f9fafb; border-radius: 8px;">
                    <i class="ri-user-line" style="font-size: 40px; color: #d1d5db; margin-bottom: 10px;"></i>
                    <p style="color: #6b7280; margin: 0; font-size: 13px;">Belum ada anggota di {{ $structure->data1 ?? $structure->key1 }}</p>
                </div>
            </div>
        @endif
    </div>
@endforeach

@if($structures->count() == 0)
<div class="row">
    <div class="col-12">
        <div style="text-align: center; padding: 60px; background: #f9fafb; border-radius: 8px;">
            <i class="ri-folder-open-line" style="font-size: 64px; color: #d1d5db; margin-bottom: 20px;"></i>
            <h5 style="color: #6b7280; margin: 0;">Belum ada data struktur</h5>
        </div>
    </div>
</div>
@endif

<!-- Member Detail Modal -->
<div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content member-detail-modal-content">
            <div class="modal-header member-detail-modal-header">
                <h5 class="modal-title member-detail-modal-title" id="memberDetailModalLabel">
                    <i class="ri-user-star-line"></i> 
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body member-detail-modal-body">
                <div class="row g-0">
                    {{-- Left: Photo + Position chip --}}
                    <div class="col-md-4 col-12 member-modal-photo-col">
                        <div class="member-modal-avatar-wrap">
                            <img id="memberDetailPhoto" src="" alt="" style="display:none;">
                            <i class="ri-user-line member-modal-avatar-icon" id="memberDetailPhotoFallback"></i>
                        </div>
                        <div class="text-center">
                            <span id="memberDetailPosition" class="member-modal-position-chip">-</span>
                            <br>
                            <span id="memberDetailFraction" class="member-modal-category-chip">-</span>
                        </div>
                    </div>
                    {{-- Right: Info details --}}
                    <div class="col-md-8 col-12 member-modal-info-col">
                        <h4 id="memberDetailName" class="member-modal-name"></h4>
                        <div id="memberDetailStructureWrap" class="member-modal-org-badge">
                            <i class="ri-building-line"></i>
                            <span id="memberDetailStructure"></span>
                        </div>
                        <div class="member-modal-divider"></div>
                        <div class="member-modal-info-grid">
                            <div class="member-modal-info-row">
                                <div class="member-modal-info-icon"><i class="ri-calendar-event-line"></i></div>
                                <div class="member-modal-info-text">
                                    <div class="member-modal-info-label">Periode</div>
                                    <div id="memberDetailPeriod" class="member-modal-info-value">-</div>
                                </div>
                            </div>
                            <div class="member-modal-info-row">
                                <div class="member-modal-info-icon"><i class="ri-profile-line"></i></div>
                                <div class="member-modal-info-text">
                                    <div class="member-modal-info-label">Identitas / Keterangan</div>
                                    <div id="memberDetailParty" class="member-modal-info-value">-</div>
                                </div>
                            </div>
                            <div class="member-modal-info-row">
                                <div class="member-modal-info-icon"><i class="ri-information-2-line"></i></div>
                                <div class="member-modal-info-text">
                                    <div class="member-modal-info-label">Detail Tambahan</div>
                                    <div id="memberDetailDapil" class="member-modal-info-value">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

