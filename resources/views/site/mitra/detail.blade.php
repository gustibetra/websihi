@extends('layouts.site')

@section('title', $mitra->data1 . ' - Detail MOU')

@section('content')
<!-- Start Breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">{{ $mitra->data1 }}</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Detail Kerjasama Industri</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="rbt-breadcrumb-item"><a href="{{ url('/site/mitra-industri') }}">Mitra Industri</a></li>
                        <li class="rbt-breadcrumb-item active">Detail MOU</li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <!-- Back Button -->
                        <a href="{{ url('/site/mitra-industri') }}" class="btn btn-secondary mb-4">
                            <i class="feather-arrow-left me-2"></i>Kembali ke Daftar Mitra
                        </a>
                        
                        <!-- Logo & Header -->
                        <div class="text-center mb-5">
                            @php
                                $logoPath = null;
                                // Logo ada di data3 berdasarkan database
                                if(isset($mitra->data3) && strpos($mitra->data3, 'mitra_industri') !== false) {
                                    $logoPath = $mitra->data3;
                                }
                            @endphp
                            
                            @if($logoPath)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $logoPath) }}" 
                                         alt="{{ $mitra->data1 }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 150px; object-fit: contain;">
                                </div>
                            @endif
                            
                            <h2 class="mb-3">{{ $mitra->data1 }}</h2>
                            
                            @if($mitra->data4)
                                @php
                                    // data4 = bidang industri ID
                                    $bidangIndustri = \App\Models\Common::where('table_name', 'bidang_industri')
                                        ->where('id', $mitra->data4)
                                        ->first();
                                @endphp
                                @if($bidangIndustri)
                                    <span class="badge bg-primary mb-2" style="font-size: 14px; padding: 8px 16px;">
                                        <i class="feather-briefcase me-1"></i>{{ $bidangIndustri->data1 }}
                                    </span>
                                @endif
                            @endif
                        </div>

                        <!-- Information Grid -->
                        <div class="row g-4">
                            <!-- Website -->
                            @if($mitra->data2 && filter_var($mitra->data2, FILTER_VALIDATE_URL))
                                <div class="col-md-6">
                                    <div class="p-4 rounded border h-100" style="background: var(--color-light);">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: var(--color-primary-opacity); flex-shrink: 0;">
                                                <i class="feather-globe text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="font-size: 12px; text-transform: uppercase; color: var(--color-body); font-weight: 600;">Website</h6>
                                                <a href="{{ $mitra->data2 }}" target="_blank" class="text-decoration-none" style="color: var(--color-primary); font-weight: 500;">
                                                    {{ $mitra->data2 }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Telepon/Kontak -->
                            @if($mitra->data5)
                                <div class="col-md-6">
                                    <div class="p-4 rounded border h-100" style="background: var(--color-light);">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: var(--color-primary-opacity); flex-shrink: 0;">
                                                <i class="feather-phone text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="font-size: 12px; text-transform: uppercase; color: var(--color-body); font-weight: 600;">Telepon / Kontak</h6>
                                                <p class="mb-0" style="font-weight: 500;">{{ $mitra->data5 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Alamat -->
                            @if($mitra->text2)
                                <div class="col-12">
                                    <div class="p-4 rounded border" style="background: var(--color-light);">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: var(--color-primary-opacity); flex-shrink: 0;">
                                                <i class="feather-map-pin text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1" style="font-size: 12px; text-transform: uppercase; color: var(--color-body); font-weight: 600;">Alamat</h6>
                                                <p class="mb-0" style="line-height: 1.6;">{{ $mitra->text2 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Jenis Kerjasama -->
@if($mitra->data6)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h6 class="text-uppercase text-muted mb-3" style="font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">
                <i class="feather-briefcase me-2"></i>Jenis Kerjasama
            </h6>
            <div class="d-flex flex-wrap gap-2">
                @php
                    // Ambil ID jenis kerjasama dari data6 (format: "72;69")
                    $jenisKerjasamaIDs = explode(';', $mitra->data6);
                    $jenisKerjasamaList = \App\Models\Common::whereIn('id', $jenisKerjasamaIDs)
                        ->where('table_name', 'jenis_kerjasama')
                        ->where('is_active', true)
                        ->orderBy('data1')
                        ->get();
                @endphp
                
                @forelse($jenisKerjasamaList as $jenis)
                    <span class="badge bg-primary bg-gradient px-3 py-2" style="font-size: 13px; font-weight: 500; border-radius: 8px;">
                        <i class="feather-check-circle me-1" style="font-size: 12px;"></i>
                        {{ $jenis->data1 }}
                    </span>
                @empty
                    <span class="text-muted">Belum ada data jenis kerjasama</span>
                @endforelse
            </div>
        </div>
    </div>
@endif

                            <!-- Deskripsi/Profil Singkat -->
                            @if($mitra->text3)
                                <div class="col-12">
                                    <div class="p-4 rounded border" style="background: var(--color-light);">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: var(--color-primary-opacity); flex-shrink: 0;">
                                                <i class="feather-file-text text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <div style="flex: 1;">
                                                <h6 class="mb-3" style="font-size: 12px; text-transform: uppercase; color: var(--color-body); font-weight: 600;">Deskripsi / Profil Singkat</h6>
                                                <div style="line-height: 1.8; white-space: pre-line;">{{ $mitra->text3 }}</div>
                                            </div>
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
</div>
<!-- End Content Area -->
@endsection

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    
    .badge {
        border-radius: 25px;
    }
    
    .rounded-circle {
        border-radius: 50% !important;
    }
    
    .border {
        border: 1px solid var(--color-border) !important;
    }
</style>
@endpush