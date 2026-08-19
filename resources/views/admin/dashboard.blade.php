@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb-current', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="row">
    <div class="col-12">
        <div class="card bg-primary bg-gradient border-0 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-sm">
                        <div class="text-white-50">
                            <h5 class="text-white mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h5>
                            <p class="mb-0">Kelola konten website sekolah dengan mudah melalui dashboard ini.</p>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-white bg-opacity-10 rounded-circle fs-1">
                                <i class="ri-dashboard-3-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <!-- Total Guru -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Guru</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalGuru }}</h4>
                        <a href="{{ route('admin.teachers.index') }}?jenis=guru" class="text-decoration-underline">Lihat Detail</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="ri-user-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tendik -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tenaga Kependidikan</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalTendik }}</h4>
                        <a href="{{ route('admin.teachers.index') }}?jenis=tendik" class="text-decoration-underline">Lihat Detail</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="ri-team-line text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Berita -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Berita</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalNews }}</h4>
                        <a href="{{ route('admin.news.index') }}" class="text-decoration-underline">Lihat Detail</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="ri-newspaper-line text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pengumuman -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Pengumuman</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalAnnouncements }}</h4>
                        <a href="{{ route('admin.announcements.index') }}" class="text-decoration-underline">Lihat Detail</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="ri-megaphone-line text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Jurusan & Galeri -->
<div class="row">
    <!-- Total Program Jurusan -->
    <div class="col-xl-6 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Program Diploma</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalJurusan }}</h4>
                        <a href="{{ route('admin.jurusan.index') }}" class="text-decoration-underline">Kelola Jurusan</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary-subtle rounded fs-3">
                            <i class="ri-book-2-line text-secondary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Galeri -->
    <div class="col-xl-6 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Galeri</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalGalleries }}</h4>
                        <a href="{{ route('admin.galleries.index') }}" class="text-decoration-underline">Lihat Galeri</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                            <i class="ri-gallery-line text-danger"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
