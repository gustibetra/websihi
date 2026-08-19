@extends('layouts.site')
@section('title', 'Pelatihan Kerja')
@section('content')
<!-- Hero Section -->
<div class="rbt-breadcrumb-area rbt-breadcrumb-10 bg-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title text-white mb-3">Pelatihan Kerja</h2>
                    <p class="text-white-50 mb-4" style="font-size: 18px;">Pelatihan Kerja Untuk Meningkatkan Kompetensi Mahasiswa</p>
                    <ul class="page-list justify-content-center">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                        <li class="rbt-breadcrumb-item active text-white">Pelatihan Kerja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">


        <!-- Program Grid -->
        @if($programs->count() > 0)
        <div class="row g-4">
            @foreach($programs as $program)
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="rbt-card variation-02 rbt-hover h-100" style="border: 1px solid var(--color-border); box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white);">

                    {{-- ✅ FOTO BANNER: ambil dari data3 --}}
                    <div class="rbt-card-img" style="height: 200px; overflow: hidden; position: relative; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                        @if($program->data3)
                            <img src="{{ asset('storage/' . $program->data3) }}"
                                 alt="{{ $program->data1 }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="feather-award text-muted" style="font-size: 48px;"></i>
                            </div>
                        @endif

                        {{-- ✅ BADGE KATEGORI: ambil dari data4 --}}
                        
                    </div>

                    <div class="rbt-card-body p-4">
                        <h5 class="rbt-card-title mb-3" style="font-size: 18px; font-weight: 700;">{{ $program->data1 }}</h5>
                        @if($program->text1)
                        <p class="rbt-card-text text-muted" style="font-size: 14px; line-height: 1.6;">
                            {{ Str::limit($program->text1, 120) }}
                        </p>
                        @endif
                        <a href="{{ route('site.pelatihan-kerja.detail', $program->key1) }}" class="btn btn-sm btn-outline-primary mt-3 rounded-pill">
                            Selengkapnya <i class="feather-arrow-right ms-1" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="feather-award text-muted" style="font-size: 64px; opacity: 0.3;"></i>
            <h5 class="mt-3 text-muted">Belum ada program pelatihan kerja</h5>
        </div>
        @endif
    </div>
</div>
@endsection