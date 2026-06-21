@extends('layouts.site')

@section('title', 'Pengumuman')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Pengumuman</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Informasi dan Pengumuman Resmi Sekolah</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Pengumuman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Announcement Area -->
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Announcement Grid -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row g-5">
                    @forelse($announcements as $item)
                        @php
                            $isExpired = false;
                            if ($item->end_date) {
                                $isExpired = \Carbon\Carbon::parse($item->end_date)->isPast();
                            }
                        @endphp
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between" style="box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white);">
                                <div>
                                    <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative;">
                                        <a href="{{ route('pengumuman.show', $item->slug) }}">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/site/images/placeholder.jpg') }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @endif
                                        </a>
                                        <span class="rbt-badge-card position-absolute top-0 end-0 m-3 {{ $isExpired ? 'bg-color-danger color-white' : 'bg-color-success color-white' }}">
                                            {{ $isExpired ? 'Berakhir' : 'Aktif' }}
                                        </span>
                                        @if($item->category)
                                            <span class="rbt-badge-card position-absolute top-0 start-0 m-3" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%) !important; color: #ffffff !important;">
                                                {{ $item->category->data1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="rbt-card-body p--25">
                                        <ul class="rbt-meta mb--10" style="font-size: 13px; color: var(--color-body);">
                                            <li><i class="feather-calendar"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</li>
                                            @if($item->end_date)
                                                <li><i class="feather-clock"></i> s/d {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</li>
                                            @endif
                                        </ul>
                                        <h5 class="rbt-card-title mb--15" style="font-size: 18px; line-height: 1.4; font-weight: 600;">
                                            <a href="{{ route('pengumuman.show', $item->slug) }}" style="color: var(--color-heading); transition: 0.3s;">{{ Str::limit($item->title, 60) }}</a>
                                        </h5>
                                        <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6;">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                                    </div>
                                </div>
                                <div class="rbt-card-body p--25 pt--0">
                                    <div class="rbt-card-bottom mt--15" style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                                        <a class="transparent-button" href="{{ route('pengumuman.show', $item->slug) }}" style="font-size: 14px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 8px;">
                                            Selengkapnya
                                            <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                                <i class="feather-alert-circle text-warning mb--15" style="font-size: 48px;"></i>
                                <h5 class="mb--5">Belum Ada Pengumuman</h5>
                                <p class="mb--0 text-muted">Belum ada pengumuman yang diterbitkan saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($announcements->hasPages())
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                                    {{-- Previous Page Link --}}
                                    @if ($announcements->onFirstPage())
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $announcements->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $start = max(1, $announcements->currentPage() - 3);
                                        $end = min($announcements->lastPage(), $announcements->currentPage() + 3);
                                    @endphp

                                    @if($start > 1)
                                        <li><a href="{{ $announcements->url(1) }}">1</a></li>
                                        @if($start > 2)
                                            <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $announcements->currentPage())
                                            <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $announcements->url($page) }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    @if($end < $announcements->lastPage())
                                        @if($end < $announcements->lastPage() - 1)
                                            <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                        @endif
                                        <li><a href="{{ $announcements->url($announcements->lastPage()) }}">{{ $announcements->lastPage() }}</a></li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($announcements->hasMorePages())
                                        <li><a href="{{ $announcements->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
                                    @else
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-right"></i></a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="position: sticky; top: 120px; z-index: 10; background: var(--color-white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border);">
                    
                    @if(request()->anyFilled(['search', 'category', 'status', 'period', 'year']))
                        <div class="mb--25 text-end">
                            <a href="{{ route('pengumuman.index') }}" class="rbt-btn-link text-danger" style="font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="feather-trash-2"></i> Bersihkan Semua Filter
                            </a>
                        </div>
                    @endif

                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('pengumuman.index') }}" method="GET" class="rbt-search-style-1">
                                @foreach(request()->except(['page', 'search']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <input type="text" name="search" placeholder="Cari pengumuman..." value="{{ request('search') }}" style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    @if($categories->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="margin-top: 15px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Kategori</span>
                                <i class="feather-chevron-{{ request('category') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('category') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('pengumuman.index', request()->except(['page', 'category'])) }}" class="{{ !request('category') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('category') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('category') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Kategori
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('pengumuman.index', array_merge(request()->except(['page', 'category']), ['category' => $category->id])) }}" class="{{ request('category') == $category->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('category') == $category->id ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('category') == $category->id ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $category->data1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Status Filter Widget -->
                    <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                        <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                            <span>Status</span>
                            <i class="feather-chevron-{{ request('status') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                        </h4>
                        <div class="inner" style="display: {{ request('status') ? 'block' : 'none' }};">
                            <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                <li>
                                    <a href="{{ route('pengumuman.index', request()->except(['page', 'status'])) }}" class="{{ !request('status') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('status') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('status') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Semua Status
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pengumuman.index', array_merge(request()->except(['page', 'status']), ['status' => 'active'])) }}" class="{{ request('status') === 'active' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('status') === 'active' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('status') === 'active' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Aktif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pengumuman.index', array_merge(request()->except(['page', 'status']), ['status' => 'expired'])) }}" class="{{ request('status') === 'expired' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('status') === 'expired' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('status') === 'expired' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Berakhir
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Period Filter Widget -->
                    @if($periods->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Periode</span>
                                <i class="feather-chevron-{{ request('period') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('period') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('pengumuman.index', request()->except(['page', 'period'])) }}" class="{{ !request('period') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('period') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('period') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Periode
                                        </a>
                                    </li>
                                    @foreach($periods as $period)
                                        <li>
                                            <a href="{{ route('pengumuman.index', array_merge(request()->except(['page', 'period']), ['period' => $period->id])) }}" class="{{ request('period') == $period->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('period') == $period->id ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('period') == $period->id ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $period->data1 }}
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
                                        <a href="{{ route('pengumuman.index', request()->except(['page', 'year'])) }}" class="{{ !request('year') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('year') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('year') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Tahun
                                        </a>
                                    </li>
                                    @foreach($years as $year)
                                        <li>
                                            <a href="{{ route('pengumuman.index', array_merge(request()->except(['page', 'year']), ['year' => $year])) }}" class="{{ request('year') == $year ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('year') == $year ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('year') == $year ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
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
<!-- End Announcement Area -->

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

