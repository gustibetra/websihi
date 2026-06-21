@extends('layouts.site')

@section('title', 'Ekstrakurikuler')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Ekstrakurikuler</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Salurkan minat, bakat, dan kembangkan potensi terbaik dirimu di luar jam pelajaran</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Ekstrakurikuler</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start List Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5">
            @forelse($structures as $item)
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between" style="box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); border: none;">
                        <div>
                            <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(31, 95, 237, 0.05) 0%, rgba(228, 18, 114, 0.05) 100%);">
                                <a href="{{ route('site.ekskul.show', $item->key1) }}" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    @if($item->data6)
                                        <img src="{{ asset('storage/' . $item->data6) }}" alt="{{ $item->data1 }}" style="max-height: 140px; max-width: 80%; object-fit: contain; width: auto; height: auto;">
                                    @else
                                        <div style="width: 90px; height: 90px; border-radius: 50%; background: var(--color-white); box-shadow: var(--shadow-1); display: flex; align-items: center; justify-content: center; border: 2px solid var(--color-border);">
                                            <i class="ri-basketball-line" style="font-size: 44px; color: var(--color-primary);"></i>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="rbt-card-body p--25">
                                <h5 class="rbt-card-title mb--15" style="font-size: 18px; line-height: 1.4; font-weight: 600;">
                                    <a href="{{ route('site.ekskul.show', $item->key1) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $item->data1 }}</a>
                                </h5>
                                <ul class="rbt-meta mb--10" style="font-size: 12px; color: var(--color-body); list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 12px; margin: 0 0 10px 0;">
                                    <li><i class="feather-calendar"></i> Periode: {{ $item->period?->key1 ?? $item->period?->data1 ?? '2024/2025' }}</li>
                                </ul>
                                <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">
                                    {{ $item->text1 ? Str::limit(strip_tags($item->text1), 120) : 'Informasi profil dan deskripsi mengenai ekstrakurikuler ini belum diisi.' }}
                                </p>
                            </div>
                        </div>
                        <div class="rbt-card-body p--25 pt--0">
                            <div class="rbt-card-bottom mt--15" style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                                <a class="transparent-button" href="{{ route('site.ekskul.show', $item->key1) }}" style="font-size: 14px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 8px;">
                                    Selengkapnya
                                    <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center p--50" style="background: var(--color-extra2); border-radius: 10px; border: 1px dashed var(--color-border);">
                        <i class="ri-award-line" style="font-size: 64px; color: var(--color-primary-opacity); margin-bottom: 20px; display: inline-block;"></i>
                        <h4 style="color: var(--color-heading); font-weight: 600;">Belum Ada Ekstrakurikuler</h4>
                        <p class="text-muted">Data kegiatan ekstrakurikuler belum tersedia untuk periode ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
