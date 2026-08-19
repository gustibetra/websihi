@extends('layouts.site')

@section('title', 'Prestasi Sekolah & Siswa')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Prestasi</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Galeri Prestasi dan Penghargaan Institute & Mahasiswa/i</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Achievements Area -->
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Achievements Grid -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row g-5">
                    @forelse($achievements as $item)
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between" style="box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); border: none;">
                                <div>
                                    <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative; background: linear-gradient(135deg, rgba(31, 95, 237, 0.1) 0%, rgba(228, 18, 114, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                        @php
                                            $itemPhotos = $item->photo_urls;
                                        @endphp
                                        @if(count($itemPhotos) > 1)
                                            <div id="carouselItem-{{ $item->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="width: 100%; height: 100%;">
                                                <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                    @foreach($itemPhotos as $idx => $url)
                                                        <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="width: 100%; height: 100%;">
                                                            <img src="{{ $url }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif(count($itemPhotos) === 1)
                                            <img src="{{ $itemPhotos[0] }}" alt="{{ $item->title }}" style="width: 100% !important; height: 100% !important; min-width: 100% !important; max-width: 100% !important; object-fit: cover;">
                                        @else
                                            <div class="text-center p-4">
                                                <img src="{{ asset('assets/site/images/icons/trophy.png') }}" alt="Trophy" style="width: 60px !important; height: auto !important; min-width: auto !important; max-width: 100% !important; opacity: 0.8; margin: auto; display: block;">
                                            </div>
                                        @endif
                                        
                                        <!-- Icon over Image (No Background) -->
                                        <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Icon" style="position: absolute; top: 15px; right: 15px; z-index: 10; width: 42px; height: 42px; object-fit: contain; pointer-events: none; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.1));">
                                        
                                        <span class="rbt-badge-card position-absolute top-0 start-0 m-3 {{ $item->type === 'Mahasiswa' ? 'bg-color-primary color-white' : 'bg-color-secondary color-white' }}" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                            {{ $item->type === 'siswa' ? 'Mahasiswa/i' : 'Institute' }}
                                        </span>
                                    </div>
                                    <div class="rbt-card-body p--25">
                                        <div class="rbt-card-top mb--10 d-flex justify-content-between align-items-center">
                                            <div class="rbt-review" style="font-size: 13px; font-weight: 600; color: {{ $item->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; display: flex; align-items: center; gap: 5px;">
                                                <i class="feather-award text-warning" style="font-size: 16px;"></i>
                                                <span>{{ Str::limit($item->achiever, 22) }}</span>
                                            </div>
                                            @if($item->tingkat)
                                                <span class="rbt-badge-5 {{ $item->type === 'siswa' ? 'bg-color-secondary-opacity color-secondary' : 'bg-color-primary-opacity color-primary' }}" style="font-size: 10px; font-weight: 700; padding: 3px 6px; border-radius: 4px; border: none; line-height: 1;">
                                                    {{ $item->tingkat->data1 }}
                                                </span>
                                            @endif
                                        </div>
                                        <h5 class="rbt-card-title mb--15" style="font-size: 18px; line-height: 1.4; font-weight: 700;">
                                            <a href="{{ route('prestasi.show', $item->id) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $item->title }}</a>
                                        </h5>
                                        <ul class="rbt-meta mb--10" style="font-size: 12px; color: var(--color-body); list-style: none; padding: 0; display: flex; gap: 15px; margin: 0 0 15px 0;">
                                            <li><i class="feather-calendar"></i> {{ $item->date ? $item->date->format('d M Y') : '-' }}</li>
                                            @if($item->organizer)
                                                <li><i class="feather-globe"></i> {{ Str::limit($item->organizer, 18) }}</li>
                                            @endif
                                        </ul>
                                        <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($item->description), 110) }}</p>
                                    </div>
                                </div>
                                <div class="rbt-card-body p--25 pt--0">
                                    <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                        <a class="transparent-button" href="{{ route('prestasi.show', $item->id) }}" style="font-size: 13px; font-weight: 600; color: {{ $item->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; display: flex; align-items: center; gap: 6px;">
                                            Detail Prestasi
                                            <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="{{ $item->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                        </a>
                                        @if($item->news)
                                            <a class="rbt-btn-link" href="{{ route('berita.show', $item->news->slug) }}" style="font-size: 12px; font-weight: 600;"><i class="feather-link"></i> Berita Terkait</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                                <i class="feather-award text-warning mb--15" style="font-size: 48px;"></i>
                                <h5 class="mb--5">Belum Ada Prestasi</h5>
                                <p class="mb--0 text-muted">Belum ada data prestasi siswa atau sekolah yang diterbitkan saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($achievements->hasPages())
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                                    @if ($achievements->onFirstPage())
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $achievements->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                    @endif

                                    @for ($page = 1; $page <= $achievements->lastPage(); $page++)
                                        @if ($page == $achievements->currentPage())
                                            <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $achievements->url($page) }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    @if ($achievements->hasMorePages())
                                        <li><a href="{{ $achievements->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
                                    @else
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-right"></i></a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Filters -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1); position: sticky; top: 120px; z-index: 10;">
                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('prestasi.index') }}" method="GET" class="rbt-search-style-1">
                                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                                @if(request('tingkat')) <input type="hidden" name="tingkat" value="{{ request('tingkat') }}"> @endif
                                @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                                <input type="text" name="search" placeholder="Cari prestasi..." value="{{ request('search') }}" style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Type Filter Widget -->
                    <div class="rbt-single-widget rbt-widget-categories" style="margin-top: 15px !important;">
                        <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                            <span>Tipe Prestasi</span>
                            <i class="feather-chevron-{{ request('type') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                        </h4>
                        <div class="inner" style="display: {{ request('type') ? 'block' : 'none' }};">
                            <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                <li>
                                    <a href="{{ route('prestasi.index', request()->except('type')) }}" class="{{ !request('type') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('type') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('type') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Semua Tipe
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('prestasi.index', array_merge(request()->all(), ['type' => 'Mahasiswa/i'])) }}" class="{{ request('type') === 'Mahasiswa/i' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('type') === 'Mahasiswa/i' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('type') === 'Mahasiswa/i' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Mahasiswa / Individu & Tim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('prestasi.index', array_merge(request()->all(), ['type' => 'Institute'])) }}" class="{{ request('type') === 'Institute' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('type') === 'Institute' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('type') === 'Institute' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Institute / Yayasan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Kategori Prestasi Widget -->
                    @if($categories->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Kategori Bidang</span>
                                <i class="feather-chevron-{{ request('category') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('category') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('prestasi.index', request()->except('category')) }}" class="{{ !request('category') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('category') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('category') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Kategori
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('prestasi.index', array_merge(request()->all(), ['category' => $category->id])) }}" class="{{ request('category') == $category->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('category') == $category->id ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('category') == $category->id ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $category->data1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Tingkat Prestasi Widget -->
                    @if($tingkats->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Tingkat Kejuaraan</span>
                                <i class="feather-chevron-{{ request('tingkat') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('tingkat') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('prestasi.index', request()->except('tingkat')) }}" class="{{ !request('tingkat') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('tingkat') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('tingkat') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Tingkat
                                        </a>
                                    </li>
                                    @foreach($tingkats as $tingkat)
                                        <li>
                                            <a href="{{ route('prestasi.index', array_merge(request()->all(), ['tingkat' => $tingkat->id])) }}" class="{{ request('tingkat') == $tingkat->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('tingkat') == $tingkat->id ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('tingkat') == $tingkat->id ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $tingkat->data1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Year Filter Widget -->
                    @if($years->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Tahun</span>
                                <i class="feather-chevron-{{ request('year') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('year') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('prestasi.index', request()->except('year')) }}" class="{{ !request('year') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('year') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('year') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Tahun
                                        </a>
                                    </li>
                                    @foreach($years as $year)
                                        <li>
                                            <a href="{{ route('prestasi.index', array_merge(request()->all(), ['year' => $year])) }}" class="{{ request('year') == $year ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('year') == $year ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('year') == $year ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $year }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Achievements Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.widget-title-trigger').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const inner = this.nextElementSibling;
            const icon = this.querySelector('.filter-toggle-icon');
            if (inner) {
                if (inner.style.display === 'none') {
                    inner.style.display = 'block';
                    if (icon) {
                        icon.classList.remove('feather-chevron-down');
                        icon.classList.add('feather-chevron-up');
                    }
                } else {
                    inner.style.display = 'none';
                    if (icon) {
                        icon.classList.remove('feather-chevron-up');
                        icon.classList.add('feather-chevron-down');
                    }
                }
            }
        });
    });
});
</script>
@endpush

