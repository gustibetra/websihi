@extends('layouts.site')

@section('title', 'Direktori Alumni')

@push('styles')
<style>
    .alumni-card {
        border: 1px solid var(--color-border-opacity) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, var(--color-white) 0%, rgba(47, 87, 239, 0.04) 100%) !important;
        cursor: pointer;
        overflow: hidden;
    }
    .alumni-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
        border-color: var(--color-primary) !important;
    }
    .alumni-tab-btn {
        background: var(--color-light);
        border: 1px solid var(--color-border-opacity);
        border-radius: 30px;
        padding: 8px 24px;
        font-size: 15px;
        font-weight: 500;
        color: var(--color-body);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none !important;
        display: inline-block;
    }
    .alumni-tab-btn:hover {
        background: var(--color-primary-opacity);
        color: var(--color-primary) !important;
    }
    .alumni-tab-btn.active {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        color: #ffffff !important;
        border-color: transparent;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(47, 87, 239, 0.25);
    }
    .modal-alumni-thumb {
        width: 140px;
        height: 180px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--color-primary-opacity);
    }
    .modal-testimonial-quote {
        background: var(--color-light);
        border-left: 4px solid var(--color-primary);
        padding: 20px;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        position: relative;
    }
    .modal-testimonial-quote::before {
        content: '"';
        font-family: serif;
        font-size: 60px;
        color: var(--color-primary);
        opacity: 0.15;
        position: absolute;
        top: -10px;
        left: 10px;
        line-height: 1;
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
                    <h2 class="title">Direktori Alumni</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Jaringan Alumni, Kisah Sukses, dan Profil Lulusan Sekolah Kami</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Alumni</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Alumni Directory Area -->
<div class="rbt-section-gapBottom mt--50">
    <div class="container">
        <!-- Tab Navigation Filters -->
        <div class="row mb--40">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center gap-3" id="alumniFilters">
                    <a href="{{ route('site.alumni.index', ['status' => 'all']) }}" class="alumni-tab-btn {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">Semua Alumni</a>
                    <a href="{{ route('site.alumni.index', ['status' => 'Kuliah']) }}" class="alumni-tab-btn {{ ($status ?? '') === 'Kuliah' ? 'active' : '' }}">Melanjutkan Kuliah</a>
                    <a href="{{ route('site.alumni.index', ['status' => 'Bekerja']) }}" class="alumni-tab-btn {{ ($status ?? '') === 'Bekerja' ? 'active' : '' }}">Sudah Bekerja</a>
                    <a href="{{ route('site.alumni.index', ['status' => 'Wirausaha']) }}" class="alumni-tab-btn {{ ($status ?? '') === 'Wirausaha' ? 'active' : '' }}">Wirausaha</a>
                    <a href="{{ route('site.alumni.index', ['status' => 'Lainnya']) }}" class="alumni-tab-btn {{ ($status ?? '') === 'Lainnya' ? 'active' : '' }}">Status Lainnya</a>
                </div>
            </div>
        </div>

        <!-- Alumni Grid -->
        <div class="row g-4" id="alumniGrid">
            @forelse($alumni as $alm)
                @php
                    // Group statuses into filters
                    $filterVal = 'Lainnya';
                    if (in_array($alm->status_alumni, ['Kuliah', 'Bekerja', 'Wirausaha'])) {
                        $filterVal = $alm->status_alumni;
                    }
                @endphp
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 alumni-item" data-status="{{ $filterVal }}">
                    <div class="rbt-card alumni-card h-100 d-flex flex-column justify-content-between p--20" 
                         onclick="showAlumniDetail({{ json_encode($alm) }}, '{{ $alm->jurusan?->nama ?? 'Umum' }}')">
                        <div>
                            <!-- Photo Container -->
                            <div class="text-center mb--20">
                                <div class="mx-auto" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 3px solid var(--color-primary-opacity);">
                                    @if($alm->photo)
                                        <img src="{{ asset('storage/' . $alm->photo) }}" alt="{{ $alm->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                                            <i class="feather-user text-muted fs-3"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="text-center">
                                <h5 class="mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">{{ $alm->name }}</h5>
                                <span class="d-block text-muted mb--10" style="font-size: 13px;">Lulusan Tahun {{ $alm->tahun_lulus }}</span>
                                
                                <div class="d-flex flex-column align-items-center gap-2 mb--15">
                                    <span class="badge" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: white; font-weight: 600; font-size: 11px; padding: 4px 10px; border-radius: 3px;">
                                        {{ $alm->status_alumni ?? 'Belum Terdata' }}
                                    </span>
                                    <span class="badge" style="background: rgba(47, 87, 239, 0.08); color: var(--color-primary); font-weight: 600; font-size: 11px; padding: 4px 10px; border-radius: 3px;">
                                        {{ $alm->jurusan?->singkatan ?? 'Umum' }}
                                    </span>
                                </div>

                                @if($alm->tempat_kerja)
                                    <p class="text-muted mb--0" style="font-size: 13px; line-height: 1.4; font-weight: 500;">
                                        <i class="feather-map-pin" style="font-size: 12px; margin-right: 4px;"></i> {{ $alm->tempat_kerja }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt--20">
                            <button type="button" class="rbt-btn btn-gradient btn-xs radius-round w-100" style="height: 32px; line-height: 30px; font-size: 11px; padding: 0 15px;">
                                Lihat Profil
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 12px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border-opacity);">
                        <i class="feather-users text-warning mb--15" style="font-size: 48px;"></i>
                        <h5 class="mb--5">Belum Ada Data Alumni</h5>
                        <p class="mb--0 text-muted">Data alumni belum diunggah atau terdaftar saat ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($alumni->hasPages())
            <div class="row">
                <div class="col-lg-12 mt--60">
                    <nav>
                        <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                            @if ($alumni->onFirstPage())
                                <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                            @else
                                <li><a href="{{ $alumni->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                            @endif

                            @for ($page = 1; $page <= $alumni->lastPage(); $page++)
                                @if ($page == $alumni->currentPage())
                                    <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $alumni->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            @if ($alumni->hasMorePages())
                                <li><a href="{{ $alumni->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
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

<!-- Alumni Details Modal -->
<div class="modal fade" id="alumniDetailModal" tabindex="-1" aria-labelledby="alumniDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header p--20" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border: none;">
                <h5 class="modal-title text-white" id="alumniDetailModalLabel" style="font-weight: 600;">Profil Detail Alumni</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1); opacity: 0.8;"></button>
            </div>
            <div class="modal-body p--30">
                <div class="row g-4">
                    <!-- Photo Column -->
                    <div class="col-md-4 text-center">
                        <img id="modalAlumniPhoto" class="modal-alumni-thumb shadow" src="" alt="Foto Alumni">
                    </div>
                    
                    <!-- Information Column -->
                    <div class="col-md-8">
                        <h3 id="modalAlumniName" class="mb--5" style="font-weight: 700; color: var(--color-heading); font-size: 24px;">Nama Alumni</h3>
                        <p class="text-muted mb--20" style="font-size: 14px; font-weight: 500;">
                            Lulusan Program Keahlian <span id="modalAlumniMajor" class="fw-bold text-primary">Jurusan</span> • Tahun Kelulusan <span id="modalAlumniGradYear" class="fw-bold">202X</span>
                        </p>

                        <div class="row g-3 mb--25">
                            <div class="col-sm-6">
                                <div style="font-size: 13px; color: #888; margin-bottom: 2px;">STATUS ALUMNI</div>
                                <span id="modalAlumniStatus" class="badge" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: white; padding: 6px 12px; font-size: 12px; border-radius: 3px; font-weight: 600;">Status</span>
                            </div>
                            <div class="col-sm-6">
                                <div id="modalAlumniWorkLabel" style="font-size: 13px; color: #888; margin-bottom: 2px;">UNIVERSITAS / PERUSAHAAN</div>
                                <strong id="modalAlumniWorkplace" style="color: var(--color-heading); font-size: 15px; font-weight: 600;">Tempat Kerja/Kuliah</strong>
                            </div>
                            <div class="col-sm-6">
                                <div style="font-size: 13px; color: #888; margin-bottom: 2px;">POSISI / JURUSAN SEKARANG</div>
                                <strong id="modalAlumniJob" style="color: var(--color-heading); font-size: 15px; font-weight: 600;">Jabatan / Jurusan Kuliah</strong>
                            </div>
                            <div class="col-sm-6">
                                <div style="font-size: 13px; color: #888; margin-bottom: 2px;">EMAIL / KONTAK</div>
                                <strong id="modalAlumniContact" style="color: var(--color-heading); font-size: 15px; font-weight: 600;">email@domain.com</strong>
                            </div>
                        </div>

                        <!-- Testimonial Quote -->
                        <div id="modalAlumniTestimonialWrapper" class="mt--20 d-none">
                            <div style="font-size: 13px; color: #888; margin-bottom: 6px; font-weight: 600;">TESTIMONI ALUMNI</div>
                            <div class="modal-testimonial-quote">
                                <p id="modalAlumniTestimonial" class="mb--0" style="color: var(--color-body); font-size: 14.5px; line-height: 1.6;"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p--15" style="border-top: 1px solid var(--color-border-opacity);">
                <button type="button" class="rbt-btn btn-xs btn-border radius-round" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Populate and Show Alumni Modal
    function showAlumniDetail(alumni, majorName) {
        // Elements
        const photoEl = document.getElementById('modalAlumniPhoto');
        const nameEl = document.getElementById('modalAlumniName');
        const majorEl = document.getElementById('modalAlumniMajor');
        const gradYearEl = document.getElementById('modalAlumniGradYear');
        const statusEl = document.getElementById('modalAlumniStatus');
        const workLabelEl = document.getElementById('modalAlumniWorkLabel');
        const workplaceEl = document.getElementById('modalAlumniWorkplace');
        const jobEl = document.getElementById('modalAlumniJob');
        const contactEl = document.getElementById('modalAlumniContact');
        const testimonialWrapper = document.getElementById('modalAlumniTestimonialWrapper');
        const testimonialEl = document.getElementById('modalAlumniTestimonial');

        // Photo
        if (alumni.photo) {
            photoEl.src = '{{ asset("storage") }}/' + alumni.photo;
        } else {
            photoEl.src = '{{ asset("assets/site/images/client/user.jpg") }}';
        }

        // Set Texts
        nameEl.innerText = alumni.name;
        majorEl.innerText = majorName;
        gradYearEl.innerText = alumni.tahun_lulus;
        statusEl.innerText = alumni.status_alumni || 'Belum Terdata';
        contactEl.innerText = alumni.email || alumni.phone || 'Tidak Ada Kontak';

        // Workplace Labels based on Status
        if (alumni.status_alumni === 'Kuliah') {
            workLabelEl.innerText = 'NAMA UNIVERSITAS / KAMPUS';
            workplaceEl.innerText = alumni.tempat_kerja || '-';
            jobEl.previousElementSibling.innerText = 'PROGRAM STUDI / JURUSAN KULIAH';
            jobEl.innerText = alumni.jabatan || '-';
        } else if (alumni.status_alumni === 'Bekerja') {
            workLabelEl.innerText = 'NAMA PERUSAHAAN / INSTITUSI';
            workplaceEl.innerText = alumni.tempat_kerja || '-';
            jobEl.previousElementSibling.innerText = 'JABATAN / POSISI KERJA';
            jobEl.innerText = alumni.jabatan || '-';
        } else {
            workLabelEl.innerText = 'TEMPAT KULIAH / INSTANSI / USAHA';
            workplaceEl.innerText = alumni.tempat_kerja || '-';
            jobEl.previousElementSibling.innerText = 'PEKERJAAN / DETAIL AKTIVITAS';
            jobEl.innerText = alumni.jabatan || '-';
        }

        // Testimonial
        if (alumni.testimoni) {
            testimonialEl.innerText = alumni.testimoni;
            testimonialWrapper.classList.remove('d-none');
        } else {
            testimonialWrapper.classList.add('d-none');
        }

        // Show Modal
        const alumniModal = new bootstrap.Modal(document.getElementById('alumniDetailModal'));
        alumniModal.show();
    }
</script>
@endpush
