@extends('layouts.site')

@section('title', 'Agenda')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Agenda & Event</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Jadwal Kegiatan dan Acara Sekolah</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Agenda</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Event List Area -->
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Event List -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row g-5">
                    @forelse($events as $item)
                        @php
                            $startDateTime = \Carbon\Carbon::parse($item->start_datetime);
                            $endDateTime = \Carbon\Carbon::parse($item->end_datetime);
                            $isSameDay = $startDateTime->isSameDay($endDateTime);
                            
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        <div class="col-lg-12">
                            <div class="rbt-card card-list-2 variation-01 rbt-hover d-flex flex-column flex-sm-row gap-4 p--20" style="box-shadow: var(--shadow-1); border-radius: 10px; background: var(--color-white); border: none;">
                                <div class="rbt-card-img" style="width: 100%; max-width: 180px; height: 180px; overflow: hidden; border-radius: 8px; flex-shrink: 0; background: var(--color-light);">
                                    <a href="{{ route('agenda.show', $item->slug) }}">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center text-primary" style="padding: 10px;">
                                                <i class="feather-calendar" style="font-size: 40px; margin-bottom: 8px;"></i>
                                                <span style="font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ $months[$startDateTime->month] }}</span>
                                                <span style="font-size: 28px; font-weight: 800; line-height: 1;">{{ $startDateTime->day }}</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="rbt-card-body p--0 d-flex flex-column justify-content-between" style="flex: 1;">
                                    <div>
                                        <div class="rbt-card-top mb--10">
                                            <ul class="rbt-meta" style="font-size: 13px; display: flex; flex-wrap: wrap; gap: 15px; color: var(--color-body); list-style: none; padding: 0;">
                                                @if($item->location)
                                                    <li><i class="feather-map-pin text-primary"></i> {{ $item->location }}</li>
                                                @endif
                                                <li><i class="feather-calendar text-primary"></i> 
                                                    @if($isSameDay)
                                                        {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} {{ $startDateTime->year }}
                                                    @else
                                                        {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} - {{ $endDateTime->day }} {{ $months[$endDateTime->month] }} {{ $endDateTime->year }}
                                                    @endif
                                                </li>
                                                <li><i class="feather-clock text-primary"></i> {{ $startDateTime->format('H:i') }} WIB</li>
                                            </ul>
                                        </div>
                                        <h5 class="rbt-card-title mb--10" style="font-size: 18px; font-weight: 600; line-height: 1.4;">
                                            <a href="{{ route('agenda.show', $item->slug) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $item->title }}</a>
                                        </h5>
                                        <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6;">{{ Str::limit(strip_tags($item->excerpt ?? $item->description), 140) }}</p>
                                    </div>
                                    <div class="rbt-card-bottom mt--15">
                                        <a class="transparent-button" href="{{ route('agenda.show', $item->slug) }}" style="font-size: 14px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 8px;">
                                            Detail Agenda
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
                                <h5 class="mb--5">Belum Ada Agenda</h5>
                                <p class="mb--0 text-muted">Belum ada agenda kegiatan yang terdaftar saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                                    @if ($events->onFirstPage())
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $events->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                    @endif

                                    @php
                                        $start = max(1, $events->currentPage() - 3);
                                        $end = min($events->lastPage(), $events->currentPage() + 3);
                                    @endphp

                                    @if($start > 1)
                                        <li><a href="{{ $events->url(1) }}">1</a></li>
                                        @if($start > 2)
                                            <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $events->currentPage())
                                            <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $events->url($page) }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    @if($end < $events->lastPage())
                                        @if($end < $events->lastPage() - 1)
                                            <li class="disabled"><a href="#" onclick="return false;">...</a></li>
                                        @endif
                                        <li><a href="{{ $events->url($events->lastPage()) }}">{{ $events->lastPage() }}</a></li>
                                    @endif

                                    @if ($events->hasMorePages())
                                        <li><a href="{{ $events->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
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
                <aside class="rbt-sidebar-widget-wrapper" style="position: sticky; top: 120px; z-index: 10; background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1);">
                    
                    @if(request()->anyFilled(['search', 'status', 'month']))
                        <div class="mb--25 text-end">
                            <a href="{{ route('agenda.index') }}" class="rbt-btn-link text-danger" style="font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="feather-trash-2"></i> Bersihkan Semua Filter
                            </a>
                        </div>
                    @endif

                    <!-- Search Widget -->
                    <div class="rbt-single-widget rbt-widget-search">
                        <div class="inner">
                            <form action="{{ route('agenda.index') }}" method="GET" class="rbt-search-style-1">
                                @foreach(request()->except(['page', 'search']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <input type="text" name="search" placeholder="Cari agenda..." value="{{ request('search') }}" style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Filter Widget -->
                    <div class="rbt-single-widget rbt-widget-categories" style="margin-top: 15px !important;">
                        <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                            <span>Status</span>
                            <i class="feather-chevron-{{ request('status') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                        </h4>
                        <div class="inner" style="display: {{ request('status') ? 'block' : 'none' }};">
                            <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                <li>
                                    <a href="{{ route('agenda.index', request()->except(['page', 'status'])) }}" class="{{ !request('status') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('status') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('status') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Semua Status
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agenda.index', array_merge(request()->except(['page', 'status']), ['status' => 'upcoming'])) }}" class="{{ request('status') === 'upcoming' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('status') === 'upcoming' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('status') === 'upcoming' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Akan Datang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agenda.index', array_merge(request()->except(['page', 'status']), ['status' => 'past'])) }}" class="{{ request('status') === 'past' ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('status') === 'past' ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('status') === 'past' ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Sudah Lewat
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Month Filter Widget -->
                    <div class="rbt-single-widget rbt-widget-categories" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                        <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                            <span>Bulan</span>
                            <i class="feather-chevron-{{ request('month') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                        </h4>
                        <div class="inner" style="display: {{ request('month') ? 'block' : 'none' }};">
                            <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                <li>
                                    <a href="{{ route('agenda.index', request()->except(['page', 'month'])) }}" class="{{ !request('month') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('month') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('month') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                        Semua Bulan
                                    </a>
                                </li>
                                @php
                                    $monthNames = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $selectedYear = request('year', date('Y'));
                                    $currentMonth = request('month');
                                    $currentMonthNum = null;
                                    if ($currentMonth) {
                                        if (strpos($currentMonth, '-') !== false) {
                                            list($reqYear, $reqMonth) = explode('-', $currentMonth);
                                            $currentMonthNum = (int)$reqMonth;
                                        } else {
                                            $currentMonthNum = (int)$currentMonth;
                                        }
                                    }
                                @endphp
                                @foreach($monthNames as $monthNum => $monthName)
                                    @php
                                        $monthValue = $selectedYear . '-' . str_pad($monthNum, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <li>
                                        <a href="{{ route('agenda.index', array_merge(request()->except(['page', 'month']), ['month' => $monthValue])) }}" class="{{ $currentMonthNum == $monthNum ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ $currentMonthNum == $monthNum ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ $currentMonthNum == $monthNum ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            {{ $monthName }} {{ $selectedYear }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Event List Area -->

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

