@extends('layouts.site')
@section('title', $program->data1 . ' - Pelatihan Kerja')
@section('content')
<!-- Breadcrumb -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">{{ $program->data1 }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('site.pelatihan-kerja.index') }}">Pelatihan Kerja</a></li>
                        <li class="rbt-breadcrumb-item active">{{ $program->data1 }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">

                        {{-- ✅ FOTO BANNER dari data3 --}}
                        @if($program->data3)
                        <div class="mb-4" style="border-radius: 12px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $program->data3) }}"
                                 alt="{{ $program->data1 }}"
                                 class="w-100" style="max-height: 400px; object-fit: cover;">
                        </div>
                        @endif

                        {{-- ✅ KATEGORI dari data4 --}}
                        @if($program->data4)
                        <span class="badge bg-primary mb-3" style="font-size: 12px; padding: 6px 14px; border-radius: 20px;">
                            {{ $program->data4 }}
                        </span>
                        @endif

                        <h2 class="mb-4" style="font-size: 28px; font-weight: 700;">{{ $program->data1 }}</h2>

                        @if($program->text1)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3" style="font-size: 16px; color: var(--color-primary);">
                                <i class="feather-info me-2"></i>Deskripsi Program
                            </h5>
                            <div style="line-height: 1.8; color: var(--color-body);">
                                {!! nl2br(e($program->text1)) !!}
                            </div>
                        </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('site.pelatihan-kerja.index') }}" class="btn btn-secondary">
                                <i class="feather-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Program Lainnya</h5>
                        @if($otherPrograms->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($otherPrograms as $other)
                            <a href="{{ route('site.pelatihan-kerja.detail', $other->key1) }}" class="text-decoration-none">
                                <div class="p-3 rounded border d-flex align-items-center gap-3">
                                    {{-- Thumbnail kecil dari data3 --}}
                                    @if($other->data3)
                                    <img src="{{ asset('storage/' . $other->data3) }}" alt="{{ $other->data1 }}"
                                         style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                                    @else
                                    <div class="d-flex align-items-center justify-content-center bg-light" style="width: 55px; height: 55px; border-radius: 8px; flex-shrink: 0;">
                                        <i class="feather-award text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        @if($other->data4)
                                        <span class="badge bg-primary mb-1" style="font-size: 10px;">{{ $other->data4 }}</span>
                                        @endif
                                        <h6 class="mb-0" style="font-size: 14px; font-weight: 600; color: var(--color-heading);">
                                            {{ $other->data1 }}
                                        </h6>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">Tidak ada program lain.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection