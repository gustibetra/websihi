@extends('layouts.site')

@section('title', $achievement->title)

@section('meta_description', Str::limit(strip_tags($achievement->description), 160))

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    @if($achievement->tingkat)
                        <span class="rbt-badge-card bg-color-primary-opacity color-primary mb--15">{{ $achievement->tingkat->data1 }}</span>
                    @endif
                    <h2 class="title">{{ $achievement->title }}</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">{{ Str::limit($achievement->title, 40) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Achievement Details Area -->
<div class="rbt-blog-details-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Details Content -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="blog-content-wrapper rbt-article-content-wrapper" style="box-shadow: var(--shadow-1); border-radius: 10px; padding: 40px; background: var(--color-white); border-top: none;">
                    
                    @php
                        $photos = $achievement->photo_urls;
                    @endphp
                    @if(count($photos) > 1)
                        <!-- Multi-Photo Carousel -->
                        <div id="achievementCarousel" class="carousel slide mb--40" data-bs-ride="carousel" style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-2); position: relative;">
                            <div class="carousel-inner" style="max-height: 480px; background: #000;">
                                @foreach($photos as $idx => $url)
                                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="height: 480px;">
                                        <img class="d-block w-100 h-100" src="{{ $url }}" alt="{{ $achievement->title }}" style="object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#achievementCarousel" data-bs-slide="prev" style="border: none; background: none;">
                                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0px 1px 3px rgba(0,0,0,0.5));"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#achievementCarousel" data-bs-slide="next" style="border: none; background: none;">
                                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0px 1px 3px rgba(0,0,0,0.5));"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            
                            <!-- Icon over Image (No Background) -->
                            <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Badge" style="position: absolute; top: 20px; right: 20px; z-index: 10; width: 56px; height: 56px; object-fit: contain; pointer-events: none; filter: drop-shadow(0px 2px 5px rgba(0,0,0,0.25));">
                        </div>
                    @elseif(count($photos) === 1)
                        <div class="post-thumbnail mb--40 position-relative text-center" style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-2); position: relative;">
                            <img class="w-100" src="{{ $photos[0] }}" alt="{{ $achievement->title }}" style="max-height: 480px; object-fit: cover;">
                            
                            <!-- Icon over Image (No Background) -->
                            <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="Award Badge" style="position: absolute; top: 20px; right: 20px; z-index: 10; width: 56px; height: 56px; object-fit: contain; pointer-events: none; filter: drop-shadow(0px 2px 5px rgba(0,0,0,0.25));">
                        </div>
                    @endif

                    <!-- Achievement Metadata Info Box -->
                    <div class="mb--40" style="padding: 30px; background: var(--color-light); border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }};"></div>
                        <div class="row g-4" style="font-size: 14px;">
                            <!-- Peraih / Pemenang -->
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-user" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Peraih / Pemenang</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->achiever }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Penyelenggara -->
                            @if($achievement->organizer)
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-globe" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Penyelenggara</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->organizer }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Tanggal Penghargaan -->
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-calendar" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Tanggal Penghargaan</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->date ? $achievement->date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tingkat Kejuaraan -->
                            @if($achievement->tingkat)
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-award" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Tingkat Kejuaraan</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->tingkat->data1 }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Kategori Bidang -->
                            @if($achievement->kategori)
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-folder" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Kategori Bidang</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->kategori->data1 }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Jurusan Terkait -->
                            @if($achievement->jurusan)
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 50%; background: {{ $achievement->type === 'siswa' ? 'var(--primary-opacity)' : 'var(--secondary-opacity)' }}; color: {{ $achievement->type === 'siswa' ? 'var(--color-primary)' : 'var(--color-secondary)' }}; flex-shrink: 0;">
                                        <i class="feather-book-open" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb--0" style="font-size: 11px; text-transform: uppercase; color: var(--color-body); font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; line-height: 1.1;">Jurusan Terkait</h6>
                                        <p class="mb--0" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $achievement->jurusan->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions Panel -->
                    <div class="d-flex justify-content-between align-items-center mb--30 pb--15" style="border-bottom: 1px solid var(--color-border); flex-wrap: wrap; gap: 15px;">
                        <span class="rbt-badge-card px-3 py-2 {{ $achievement->type === 'siswa' ? 'bg-color-primary-opacity color-primary' : 'bg-color-secondary-opacity color-secondary' }}" style="font-weight: 600; font-size: 13px;">
                            Prestasi {{ $achievement->type === 'siswa' ? 'Siswa' : 'Sekolah' }}
                        </span>
                        
                        <div class="text-size-controls d-flex gap-2">
                            <button type="button" onclick="decreaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 13px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perkecil Teks">A-</button>
                            <button type="button" onclick="resetTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 12px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Reset Ukuran Teks">A</button>
                            <button type="button" onclick="increaseTextSize()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); font-size: 15px; font-weight: bold; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Perbesar Teks">A+</button>
                            <button type="button" onclick="window.print()" class="rbt-round-btn style-2" style="width: 35px; height: 35px; border: 1px solid var(--color-border); background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%;" title="Print Halaman">
                                <i class="feather-printer" style="font-size: 14px; color: var(--color-body);"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Achievement Description -->
                    <div class="content rbt-article-content" id="achievementContent" style="font-size: 16px; line-height: 1.8; color: var(--color-body);">
                        {!! $achievement->description !!}
                    </div>

                    @php
                        $students = $achievement->students;
                    @endphp
                    @if($students->isNotEmpty())
                    <!-- Profil Juara Section -->
                    <div class="winner-profile-section mt--50 mb--40" style="border-top: 1px solid var(--color-border); padding-top: 40px;">
                        <h4 class="title mb--30" style="font-size: 22px; font-weight: 700; color: var(--color-heading); display: flex; align-items: center; gap: 10px;">
                            <i class="feather-award text-warning" style="font-size: 26px;"></i>
                            Profil Juara
                        </h4>
                        <div class="row g-4">
                            @foreach($students as $student)
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="winner-card rbt-hover" style="padding: 15px; border: 1px solid rgba(0,0,0,0.08); box-shadow: var(--shadow-1); border-radius: 10px; background: var(--color-white); overflow: hidden; position: relative; transition: all 0.3s ease; height: 100%;">
                                        <!-- Subtle Background Decoration using original card-icon-1.png -->
                                        <div class="dec-bg" style="position: absolute; right: 5px; bottom: 5px; opacity: 0.04; width: 80px; height: 80px; z-index: 1; pointer-events: none;">
                                            <img src="{{ asset('assets/site/images/icons/card-icon-1.png') }}" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 2;">
                                            <!-- Student Photo (3x4 aspect ratio, rounded rectangular) -->
                                            <div style="width: 75px; height: 100px; border-radius: 6px; overflow: hidden; border: 2px solid var(--color-primary-opacity); box-shadow: var(--shadow-1); flex-shrink: 0;">
                                                @if($student->photo_url)
                                                    <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/admin/images/users/user-dummy-img.jpg') }}" alt="{{ $student->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                            
                                            <!-- Student Details -->
                                            <div class="winner-details text-start" style="flex-grow: 1;">
                                                <h6 class="mb--5" style="font-size: 15px; font-weight: 700; color: var(--color-heading); line-height: 1.3;">{{ $student->name }}</h6>
                                                
                                                <div style="font-size: 12px; color: var(--color-body); line-height: 1.4;">
                                                    <div class="d-flex align-items-center gap-1 mb--2">
                                                        <i class="feather-home text-primary" style="font-size: 12px;"></i>
                                                        <span>Kelas: <strong>{{ $student->kelas?->data1 ?? '-' }}</strong></span>
                                                    </div>
                                                    <div class="d-flex align-items-start gap-1">
                                                        <i class="feather-book-open text-primary mt--3" style="font-size: 12px;"></i>
                                                        <span>Jurusan: <strong>{{ $student->jurusan?->nama ?? '-' }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($achievement->news)
                    <!-- Linked News Box -->
                    <div class="p--25 mt--40 mb--30" style="background: var(--color-light); border-radius: 8px; border-left: 4px solid var(--color-primary);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-color-primary-opacity d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 8px; flex-shrink: 0;">
                                    <i class="feather-link" style="font-size: 24px; color: var(--color-primary);"></i>
                                </div>
                                <div>
                                    <h6 class="mb--5" style="font-size: 15px; font-weight: 600; color: var(--color-heading);">Berita Terkait</h6>
                                    <p class="mb--0 text-muted" style="font-size: 13px;">Baca berita selengkapnya mengenai prestasi ini.</p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('berita.show', $achievement->news->slug) }}" class="rbt-btn btn-gradient hover-icon-reverse radius-round btn-sm" style="height: 40px; line-height: 38px; padding: 0 20px; font-size: 13px;">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Baca Berita</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($achievement->title) }}" target="_blank" title="Share ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" title="Share ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($achievement->title . ' ' . request()->url()) }}" target="_blank" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <aside class="rbt-sidebar-widget-wrapper" style="background: var(--color-white); padding: 30px; border-radius: 10px; box-shadow: var(--shadow-1);">
                    <div class="rbt-single-widget rbt-widget-recent-post" style="margin-top: 15px !important;">
                        <div class="d-flex justify-content-between align-items-center mb--8" style="margin-bottom: 8px !important;">
                            <h4 class="title mb--0" style="font-size: 15px !important; font-weight: 600; color: var(--color-heading); margin-bottom: 0 !important;">Prestasi Lainnya</h4>
                            <a href="{{ route('prestasi.index') }}" class="rbt-btn btn-sm btn-border" style="font-size: 11px; padding: 5px 12px; height: auto;"><i class="feather-arrow-left"></i> Kembali</a>
                        </div>
                        
                        @php
                            $otherAchievements = \App\Models\Achievement::where('is_active', true)
                                ->where('id', '!=', $achievement->id)
                                ->orderBy('date', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if($otherAchievements->count() > 0)
                            <ul class="recent-post-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px !important;">
                                @foreach($otherAchievements as $other)
                                    <li style="display: flex; gap: 10px; align-items: center;">
                                        @if($other->photo_url)
                                            <div class="thumbnail" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                                <a href="{{ route('prestasi.show', $other->id) }}">
                                                    <img src="{{ $other->photo_url }}" alt="{{ $other->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="content">
                                            <h6 class="title" style="font-size: 13px !important; font-weight: 600; line-height: 1.3; margin-bottom: 2px !important;">
                                                <a href="{{ route('prestasi.show', $other->id) }}" style="color: var(--color-heading); text-decoration: none;">{{ Str::limit($other->title, 55) }}</a>
                                            </h6>
                                            <ul class="rbt-meta" style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--color-body);">
                                                <li><i class="feather-calendar"></i> {{ $other->date ? $other->date->format('d M Y') : '-' }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Belum ada prestasi lainnya.</p>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- End Achievement Details Area -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Text size control
    let currentSize = 16;
    const minSize = 12;
    const maxSize = 24;
    const step = 2;

    const savedSize = localStorage.getItem('achievementTextSize');
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
        const content = document.getElementById('achievementContent');
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
        localStorage.setItem('achievementTextSize', size);
    }
});
</script>
@endpush
