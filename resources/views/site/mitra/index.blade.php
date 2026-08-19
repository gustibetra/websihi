@extends('layouts.site')

@section('title', 'Kerjasama Industri (DU/DI)')

@section('content')
<!-- Start Breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">MOU Subang International Hotel Institute</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Daftar MOU SIHI</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="rbt-breadcrumb-item active">MOU SIHI</li>
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
        @if(isset($mitras) && $mitras->count() > 0)
            <div class="row g-4">
                @foreach($mitras as $mitra)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="rbt-card variation-02 rbt-hover h-100" style="border: 1px solid var(--color-border); box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white);">
                            <div class="rbt-card-img" style="height: 180px; background: var(--color-light); display: flex; align-items: center; justify-content: center; padding: 20px; position: relative;">
                                {{-- Logo Mitra - data3 berisi path gambar --}}
                                @if($mitra->data3 && strpos($mitra->data3, 'mitra_industri') !== false)
                                    <img src="{{ asset('storage/' . $mitra->data3) }}" 
                                         alt="{{ $mitra->data1 }}" 
                                         style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                @else
                                    <i class="feather-briefcase text-muted" style="font-size: 48px;"></i>
                                @endif
                                
                                {{-- Badge Bidang Industri --}}
                                @if($mitra->data4)
                                    @php
                                        $bidang = \App\Models\Common::where('table_name', 'bidang_industri')->where('id', $mitra->data4)->first();
                                    @endphp
                                    @if($bidang)
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-3" style="font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                            {{ $bidang->data1 }}
                                        </span>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="rbt-card-body p--25">
                                <h5 class="rbt-card-title mb--10" style="font-size: 16px; font-weight: 700; line-height: 1.4; min-height: 45px;">
                                    {{ $mitra->data1 }}
                                </h5>
                                
                                {{-- Alamat - text2 --}}
                                @if($mitra->text2)
                                    <p class="text-muted small mb-2" style="font-size: 12px; line-height: 1.5;">
                                        <i class="feather-map-pin" style="font-size: 12px;"></i> 
                                        {{ Str::limit($mitra->text2, 80) }}
                                    </p>
                                @endif
                                
                                {{-- Telepon - data5 --}}
                                @if($mitra->data5)
                                    <p class="text-muted small mb-3" style="font-size: 12px;">
                                        <i class="feather-phone" style="font-size: 12px;"></i> 
                                        {{ $mitra->data5 }}
                                    </p>
                                @endif
                                
                                <div class="d-flex gap-2 flex-wrap">
                                    {{-- Link Website - data2 --}}
                                    @if($mitra->data2 && filter_var($mitra->data2, FILTER_VALIDATE_URL))
                                        <a href="{{ $mitra->data2 }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="btn btn-sm btn-outline-primary" 
                                           style="font-size: 12px; padding: 6px 12px;">
                                            <i class="feather-globe" style="font-size: 12px;"></i> Website
                                        </a>
                                    @endif
                                    
                                    {{-- Detail MOU - gunakan ID jika key1 NULL --}}
                                    <a href="{{ route('site.mitra.detail', $mitra->key1 ?? $mitra->id) }}" 
                                       class="btn btn-sm btn-primary" 
                                       style="font-size: 12px; padding: 6px 12px;">
                                        <i class="feather-file-text" style="font-size: 12px;"></i> Detail MOU
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="feather-briefcase text-muted" style="font-size: 64px; opacity: 0.3;"></i>
                <h5 class="mt-3 text-muted">Belum ada data mitra industri</h5>
                <p class="text-muted">Data mitra akan ditampilkan di sini setelah ditambahkan.</p>
            </div>
        @endif
    </div>
</div>
<!-- End Content Area -->
@endsection