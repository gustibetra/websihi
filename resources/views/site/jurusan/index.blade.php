@extends('layouts.site')

@section('title', 'Program Keahlian')
@section('meta_description', 'Daftar Program Keahlian yang tersedia di sekolah kami.')

@section('content')
<!-- Breadcrumb -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Program Diploma</h2>
                    <p class="mb--20">Pilih program diploma yang sesuai dengan minat dan bakat Anda</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li><div class="icon-right"><i class="feather-chevron-right"></i></div></li>
                        <li class="rbt-breadcrumb-item active">Program Keahlian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rbt-section-gap">
    <div class="container">
        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('jurusan.space', $program->kode) }}" class="text-decoration-none">
                        <div class="rbt-card variation-01 rbt-hover h-100" style="border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-1); transition: all 0.3s ease;">
                            <div class="rbt-card-img" style="height: 200px; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); display: flex; align-items: center; justify-content: center;">
                                @if($program->logo)
                                    <img src="{{ asset('storage/' . $program->logo) }}" alt="{{ $program->nama }}" style="max-height: 120px; max-width: 80%; object-fit: contain;">
                                @else
                                    <div style="text-align: center; color: white;">
                                        <i class="feather-book-open" style="font-size: 64px; opacity: 0.8;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="rbt-card-body" style="padding: 24px;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="rbt-badge" style="background: var(--color-primary-light); color: var(--color-primary); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $program->kode }}</span>
                                    @if($program->akreditasi)
                                        <span class="rbt-badge" style="background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">Akreditasi {{ $program->akreditasi }}</span>
                                    @endif
                                </div>
                                <h5 class="rbt-card-title" style="font-size: 18px; font-weight: 700; color: var(--color-heading); margin-bottom: 10px;">{{ $program->nama }}</h5>
                                @if($program->deskripsi)
                                    <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6;">{{ Str::limit(strip_tags($program->deskripsi), 120) }}</p>
                                @endif
                                <div class="d-flex align-items-center gap-1 mt-3" style="color: var(--color-primary); font-weight: 600; font-size: 14px;">
                                    <span>Lihat Detail</span>
                                    <i class="feather-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="feather-book-open" style="font-size: 64px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Belum ada program keahlian.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
