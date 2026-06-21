@extends('layouts.site')

@section('title', $event->title)

@section('meta_description', $event->excerpt ?? Str::limit(strip_tags($event->description), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">{{ $event->title }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($event->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Event Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            
            @php
                $startDateTime = \Carbon\Carbon::parse($event->start_datetime);
                $endDateTime = \Carbon\Carbon::parse($event->end_datetime);
                $isSameDay = $startDateTime->isSameDay($endDateTime);
                
                $now = now();
                if ($now->lt($startDateTime)) {
                    $status = 'upcoming';
                    $statusText = 'Akan Datang';
                    $statusColor = 'var(--color-primary)';
                    $statusBg = 'bg-color-primary-opacity';
                } elseif ($now->between($startDateTime, $endDateTime)) {
                    $status = 'ongoing';
                    $statusText = 'Sedang Berlangsung';
                    $statusColor = 'var(--color-success)';
                    $statusBg = 'bg-color-success-opacity';
                } else {
                    $status = 'completed';
                    $statusText = 'Selesai';
                    $statusColor = 'var(--color-body)';
                    $statusBg = 'bg-color-border-opacity';
                }

                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            @endphp

            <!-- Details Content -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <!-- Main details card with expanded padding (50px 60px) -->
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 12px; padding: 50px 60px; background: var(--color-white); border-top: none; border: 1px solid var(--color-border);">
                    
                    @if($event->banner)
                    <div class="post-thumbnail mb--30 position-relative text-center">
                        <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}" style="border-radius: 8px; max-height: 400px; width: auto; max-width: 100%; object-fit: cover;">
                    </div>
                    @endif

                    @if($status === 'upcoming')
                    <!-- Countdown Timer card with primary/secondary theme gradient and expanded padding (40px 50px) -->
                    <div id="countdownTimer" class="mb--40 p--40" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border-radius: 12px; text-align: center; color: var(--color-white); padding: 40px 50px; box-shadow: 0 4px 15px rgba(47, 87, 239, 0.25);">
                        <h6 style="color: var(--color-white); text-transform: uppercase; font-size: 13px; font-weight: 700; letter-spacing: 1px;" class="mb--20">Agenda Dimulai Dalam</h6>
                        <div class="d-flex justify-content-center align-items-center gap-4">
                            <div class="countdown-item">
                                <span id="days" style="font-size: 36px; font-weight: 800; display: block; line-height: 1;">0</span>
                                <span style="font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase;">Hari</span>
                            </div>
                            <span style="font-size: 28px; font-weight: 800;">:</span>
                            <div class="countdown-item">
                                <span id="hours" style="font-size: 36px; font-weight: 800; display: block; line-height: 1;">00</span>
                                <span style="font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase;">Jam</span>
                            </div>
                            <span style="font-size: 28px; font-weight: 800;">:</span>
                            <div class="countdown-item">
                                <span id="minutes" style="font-size: 36px; font-weight: 800; display: block; line-height: 1;">00</span>
                                <span style="font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase;">Menit</span>
                            </div>
                            <span style="font-size: 28px; font-weight: 800;">:</span>
                            <div class="countdown-item">
                                <span id="seconds" style="font-size: 36px; font-weight: 800; display: block; line-height: 1;">00</span>
                                <span style="font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase;">Detik</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <h4 class="mb--0" style="font-size: 22px; font-weight: 700; color: var(--color-heading);">Deskripsi Kegiatan</h4>
                        
                        <div class="text-size-controls d-flex gap-2">
                            <button type="button" onclick="decreaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 13px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perkecil Teks">A-</button>
                            <button type="button" onclick="resetTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 12px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Reset Ukuran Teks">A</button>
                            <button type="button" onclick="increaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 15px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perbesar Teks">A+</button>
                            <button type="button" onclick="window.print()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Print Halaman">
                                <i class="feather-printer" style="font-size: 14px; color: var(--color-body);"></i>
                            </button>
                        </div>
                    </div>

                    <div class="content rbt-article-content" id="eventContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! $event->description !!}
                    </div>

                    @if($event->attachment)
                    <div class="rbt-feature feature-style-1 align-items-center mt--40 p--30" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border); border-left: 4px solid var(--color-primary);">
                        <div class="icon" style="width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
                            <i class="feather-file-text" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <div class="feature-content pl--20" style="flex: 1;">
                            <h6 class="feature-title mb--5" style="font-size: 16px; font-weight: 600; color: var(--color-heading);">Lampiran Agenda</h6>
                            <p class="feature-description mb--0" style="font-size: 14px; color: var(--color-body);">{{ basename($event->attachment) }}</p>
                        </div>
                        <div class="button-group pl--20 mt_mobile--15">
                            <a href="{{ asset('storage/' . $event->attachment) }}" target="_blank" class="rbt-btn hover-icon-reverse radius-round btn-sm" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border: none; color: #fff;">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Download</span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                    <span class="btn-icon"><i class="feather-download"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="social-share-block mt--40" style="border-top: 1px solid var(--color-border); padding-top: 20px;">
                        <div class="post-like" style="border: none; padding: 0;">
                            <span style="font-size: 15px; font-weight: 600; color: var(--color-heading);">Bagikan Halaman Ini:</span>
                        </div>
                        <ul class="social-icon social-default transparent-with-border">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" title="Share ke Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($event->title) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($event->title . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Previous/Next Event Nav -->
                    @php
                        $prevEvent = \App\Models\Event::where('is_active', true)
                            ->where('id', '<', $event->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        
                        $nextEvent = \App\Models\Event::where('is_active', true)
                            ->where('id', '>', $event->id)
                            ->orderBy('id', 'asc')
                            ->first();
                    @endphp
                    @if($prevEvent || $nextEvent)
                        <div class="rbt-post-navigation mt--50 d-flex justify-content-between align-items-center gap-4 flex-wrap" style="border-top: 1px solid var(--color-border); padding-top: 30px;">
                            @if($prevEvent)
                                <div class="post-navigation-item prev" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('agenda.show', $prevEvent->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;"><i class="feather-arrow-left"></i> Agenda Sebelumnya</span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($prevEvent->title, 50) }}</h6>
                                    </a>
                                </div>
                            @else
                                <div style="flex: 1;"></div>
                            @endif

                            @if($nextEvent)
                                <div class="post-navigation-item next text-end" style="flex: 1; min-width: 200px;">
                                    <a href="{{ route('agenda.show', $nextEvent->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; gap: 5px;">
                                        <span style="font-size: 12px; color: var(--color-body); text-transform: uppercase; font-weight: 600;">Agenda Selanjutnya <i class="feather-arrow-right"></i></span>
                                        <h6 class="title mb--0" style="font-size: 14px; font-weight: 600; color: var(--color-heading); line-height: 1.4;">{{ Str::limit($nextEvent->title, 50) }}</h6>
                                    </a>
                                </div>
                            @else
                                <div style="flex: 1;"></div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <!-- Sidebar with expanded padding (40px) -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="position: sticky; top: 120px; z-index: 10; background: var(--color-white); padding: 40px; border-radius: 12px; box-shadow: var(--shadow-1); border: 1px solid var(--color-border);">
                    
                    <!-- Informasi Acara Widget -->
                    <div class="rbt-single-widget mt--0" style="padding-bottom: 25px;">
                        <h4 class="title" style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--color-heading);">Informasi Acara</h4>
                        <div class="inner">
                            <div class="mb--20">
                                <span class="rbt-badge-card px-3 py-2 {{ $statusBg }}" style="color: {{ $statusColor }}; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px;">
                                    <span style="width: 8px; height: 8px; background: {{ $statusColor }}; border-radius: 50%;"></span>
                                    {{ $statusText }}
                                </span>
                            </div>
                            
                            <ul class="agenda-meta-list" style="list-style: none; padding: 0; margin: 0 0 25px 0; display: flex; flex-direction: column; gap: 15px; font-size: 14px; color: var(--color-body);">
                                <li style="display: flex; gap: 12px; align-items: flex-start;">
                                    <i class="feather-calendar" style="font-size: 16px; margin-top: 3px; color: var(--color-primary);"></i>
                                    <div>
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #888; margin-bottom: 2px;">Tanggal</span>
                                        <strong style="color: var(--color-heading); font-weight: 600;">
                                            @if($isSameDay)
                                                {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} {{ $startDateTime->year }}
                                            @else
                                                {{ $startDateTime->day }} {{ $months[$startDateTime->month] }} - {{ $endDateTime->day }} {{ $months[$endDateTime->month] }} {{ $endDateTime->year }}
                                            @endif
                                        </strong>
                                    </div>
                                </li>
                                <li style="display: flex; gap: 12px; align-items: flex-start;">
                                    <i class="feather-clock" style="font-size: 16px; margin-top: 3px; color: var(--color-primary);"></i>
                                    <div>
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #888; margin-bottom: 2px;">Waktu</span>
                                        <strong style="color: var(--color-heading); font-weight: 600;">{{ $startDateTime->format('H:i') }} - {{ $endDateTime->format('H:i') }} WIB</strong>
                                    </div>
                                </li>
                                @if($event->location)
                                <li style="display: flex; gap: 12px; align-items: flex-start;">
                                    <i class="feather-map-pin" style="font-size: 16px; margin-top: 3px; color: var(--color-primary);"></i>
                                    <div>
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #888; margin-bottom: 2px;">Lokasi</span>
                                        <strong style="color: var(--color-heading); font-weight: 600;">{{ $event->location }}</strong>
                                    </div>
                                </li>
                                @endif
                                @if($event->organizer)
                                <li style="display: flex; gap: 12px; align-items: flex-start;">
                                    <i class="feather-user" style="font-size: 16px; margin-top: 3px; color: var(--color-primary);"></i>
                                    <div>
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #888; margin-bottom: 2px;">Penyelenggara</span>
                                        <strong style="color: var(--color-heading); font-weight: 600;">{{ $event->organizer }}</strong>
                                    </div>
                                </li>
                                @endif
                                @if($event->speaker)
                                <li style="display: flex; gap: 12px; align-items: flex-start;">
                                    <i class="feather-mic" style="font-size: 16px; margin-top: 3px; color: var(--color-primary);"></i>
                                    <div>
                                        <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #888; margin-bottom: 2px;">Pembicara</span>
                                        <strong style="color: var(--color-heading); font-weight: 600;">{{ $event->speaker }}</strong>
                                    </div>
                                </li>
                                @endif
                            </ul>

                            @if($status === 'upcoming' || $status === 'ongoing')
                                <div style="border-top: 1px solid var(--color-border); padding-top: 20px;">
                                    <span style="display: block; font-size: 12px; font-weight: 600; color: var(--color-heading); margin-bottom: 12px;">Tambahkan ke Kalender:</span>
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                                        <a href="#" onclick="addToGoogleCalendar(); return false;" class="rbt-btn btn-sm btn-white border-primary" style="font-size: 11px; font-weight: 600; padding: 0 5px; height: 32px; display: flex; align-items: center; justify-content: center; gap: 4px; border-radius: 4px;"><i class="fab fa-google text-danger"></i> Google</a>
                                        <a href="#" onclick="addToOutlookCalendar(); return false;" class="rbt-btn btn-sm btn-white border-primary" style="font-size: 11px; font-weight: 600; padding: 0 5px; height: 32px; display: flex; align-items: center; justify-content: center; gap: 4px; border-radius: 4px;"><i class="fab fa-windows text-primary"></i> Outlook</a>
                                        <a href="#" onclick="downloadICS(); return false;" class="rbt-btn btn-sm btn-white border-primary" style="font-size: 11px; font-weight: 600; padding: 0 5px; height: 32px; display: flex; align-items: center; justify-content: center; gap: 4px; border-radius: 4px;"><i class="feather-download text-success"></i> iCal</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upcoming Events Widget -->
                    @php
                        $upcomingEvents = \App\Models\Event::where('is_active', true)
                            ->where('id', '!=', $event->id)
                            ->where('start_datetime', '>=', now())
                            ->orderBy('start_datetime', 'asc')
                            ->limit(5)
                            ->get();
                    @endphp
                    @if($upcomingEvents->count() > 0)
                        <div class="rbt-single-widget rbt-widget-recent-post" style="border-top: 1px solid var(--color-border); margin-top: 12px !important; padding-top: 10px !important;">
                            <h4 class="title" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading);">Agenda Mendatang</h4>
                            <div class="inner">
                                <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                    @foreach($upcomingEvents as $upcoming)
                                        <li style="display: flex; gap: 10px; align-items: center;">
                                            <div class="content">
                                                <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                    <a href="{{ route('agenda.show', $upcoming->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($upcoming->title, 55) }}</a>
                                                </h6>
                                                <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                    <li><i class="feather-calendar" style="color: var(--color-primary);"></i> {{ \Carbon\Carbon::parse($upcoming->start_datetime)->format('d M Y') }}</li>
                                                    @if($upcoming->location)
                                                        <li><i class="feather-map-pin" style="color: var(--color-primary);"></i> {{ Str::limit($upcoming->location, 30) }}</li>
                                                    @endif
                                                </ul>
                                            </div>
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
<!-- End Event Details Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('eventTextSize');
    if (savedSize) {
        currentSize = parseInt(savedSize);
        applyTextSize(currentSize);
    }

    window.increaseTextSize = function() {
        if (currentSize < maxSize) {
            currentSize += step;
            applyTextSize(currentSize);
            saveTextSize(currentSize);
        }
    };

    window.decreaseTextSize = function() {
        if (currentSize > minSize) {
            currentSize -= step;
            applyTextSize(currentSize);
            saveTextSize(currentSize);
        }
    };

    window.resetTextSize = function() {
        currentSize = 16;
        applyTextSize(currentSize);
        saveTextSize(currentSize);
    };

    function applyTextSize(size) {
        const content = document.getElementById('eventContent');
        if (content) {
            content.style.setProperty('font-size', size + 'px', 'important');
            const lineHeight = size * 1.8 / 16;
            content.style.setProperty('line-height', lineHeight, 'important');
            
            const paragraphs = content.querySelectorAll('p, li, td, th, blockquote');
            paragraphs.forEach(function(el) {
                el.style.setProperty('font-size', size + 'px', 'important');
            });
        }
    }

    function saveTextSize(size) {
        localStorage.setItem('eventTextSize', size);
    }

    // Countdown timer for upcoming events
    @if($status === 'upcoming')
    const eventStartTime = {{ \Carbon\Carbon::parse($event->start_datetime)->timestamp * 1000 }};
    
    function updateCountdown() {
        const now = Date.now();
        const distance = eventStartTime - now;
        
        if (!document.getElementById('countdownTimer')) {
            return;
        }

        if (distance < 0) {
            document.getElementById('countdownTimer').innerHTML = '<h6 style="margin: 0; font-size: 18px; font-weight: 600; color: #fff;">Agenda Telah Dimulai!</h6>';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('days').textContent = days;
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
    @endif

    // Add to calendar functions
    @if($status === 'upcoming' || $status === 'ongoing')
    const eventData = {
        title: @json($event->title),
        description: @json(strip_tags($event->description)),
        location: @json($event->location ?? ''),
        startDate: '{{ \Carbon\Carbon::parse($event->start_datetime)->format('Ymd\THis') }}',
        endDate: '{{ \Carbon\Carbon::parse($event->end_datetime)->format('Ymd\THis') }}',
        startISO: '{{ \Carbon\Carbon::parse($event->start_datetime)->toIso8601String() }}',
        endISO: '{{ \Carbon\Carbon::parse($event->end_datetime)->toIso8601String() }}'
    };

    window.addToGoogleCalendar = function() {
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventData.title)}&dates=${eventData.startDate}/${eventData.endDate}&details=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;
        window.open(url, '_blank');
    };

    window.addToOutlookCalendar = function() {
        const url = `https://outlook.live.com/calendar/0/deeplink/compose?subject=${encodeURIComponent(eventData.title)}&startdt=${eventData.startISO}&enddt=${eventData.endISO}&body=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;
        window.open(url, '_blank');
    };

    window.downloadICS = function() {
        const icsContent = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Sekolah//Agenda//EN',
            'BEGIN:VEVENT',
            `UID:${Date.now()}@sekolah.sch.id`,
            `DTSTAMP:${eventData.startDate}`,
            `DTSTART:${eventData.startDate}`,
            `DTEND:${eventData.endDate}`,
            `SUMMARY:${eventData.title}`,
            `DESCRIPTION:${eventData.description.replace(/\n/g, '\\n')}`,
            `LOCATION:${eventData.location}`,
            'STATUS:CONFIRMED',
            'END:VEVENT',
            'END:VCALENDAR'
        ].join('\r\n');

        const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = `agenda-${eventData.startDate}.ics`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
    @endif
});
</script>
@endpush
