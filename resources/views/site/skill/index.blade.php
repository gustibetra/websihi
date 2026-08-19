@extends('layouts.site')

@section('title', 'Skill & Keahlian')

@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Skill & Keahlian</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">Galeri Skill & Keahlian yang didapat oleh mahasiswa/i</p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Skill & Keahlian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<!-- Start Projects Area -->
<div class="rbt-blog-area rbt-section-gapBottom mt--50">
    <div class="container">
        <div class="row g-5">
            <!-- Projects Grid -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row g-5">
                    @forelse($projects as $project)
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="rbt-card variation-02 rbt-hover h-100 d-flex flex-column justify-content-between" style="box-shadow: var(--shadow-1); border-radius: 10px; overflow: hidden; background: var(--color-white); border: none;">
                                <div>
                                    <div class="rbt-card-img" style="height: 220px; overflow: hidden; position: relative; background: linear-gradient(135deg, rgba(31, 95, 237, 0.1) 0%, rgba(228, 18, 114, 0.1) 100%); display: flex; align-items: center; justify-content: center;">
                                        @if($project->data2)
                                            <img src="{{ asset('storage/' . $project->data2) }}" alt="{{ $project->data1 }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="text-center p-4">
                                                <i class="feather-monitor text-primary" style="font-size: 50px;"></i>
                                            </div>
                                        @endif
                                        
                                        @if($project->data3)
                                            @php
                                                $jur = $jurusans->firstWhere('id', $project->data3);
                                            @endphp
                                            @if($jur)
                                                <span class="rbt-badge-card position-absolute top-0 start-0 m-3 bg-color-primary color-white" style="z-index: 10; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                                    {{ $jur->singkatan ?: $jur->kode }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="rbt-card-body p--25">
                                        <h5 class="rbt-card-title mb--15" style="font-size: 18px; line-height: 1.4; font-weight: 700;">
                                            <a href="{{ route('skill.show', $project->id) }}" style="color: var(--color-heading); transition: 0.3s;">{{ $project->data1 }}</a>
                                        </h5>
                                        <p class="rbt-card-text" style="font-size: 14px; color: var(--color-body); line-height: 1.6; margin-bottom: 0;">{{ Str::limit(strip_tags($project->text1), 120) }}</p>
                                    </div>
                                </div>
                                <div class="rbt-card-body p--25 pt--0">
                                    <div class="rbt-card-bottom" style="border-top: 1px solid var(--color-border); padding-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                        <a class="transparent-button" href="{{ route('skill.show', $project->id) }}" style="font-size: 13px; font-weight: 600; color: var(--color-primary); display: flex; align-items: center; gap: 6px;">
                                            Detail Skill & Keahlian
                                            <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="var(--color-primary)" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M0 6h15M11 1l5 5-5 5"/></g></svg></i>
                                        </a>
                                        @if($project->data4)
                                            @php
                                                $linkedNews = \App\Models\News::find($project->data4);
                                            @endphp
                                            @if($linkedNews)
                                                <a class="rbt-btn-link" href="{{ route('berita.show', $linkedNews->slug) }}" style="font-size: 12px; font-weight: 600;"><i class="feather-link"></i> Berita Terkait</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="rbt-info-panel text-center p--50" style="background: var(--color-white); border-radius: 10px; box-shadow: var(--shadow-1);">
                                <i class="feather-monitor text-primary mb--15" style="font-size: 48px;"></i>
                                <h5 class="mb--5">Belum Ditambahkan Skill & Keahlian</h5>
                                <p class="mb--0 text-muted">Belum ada data yang diterbitkan saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($projects->hasPages())
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul class="rbt-pagination justify-content-center" style="gap: 5px;">
                                    @if ($projects->onFirstPage())
                                        <li class="disabled"><a href="#" onclick="return false;"><i class="feather-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $projects->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                    @endif

                                    @for ($page = 1; $page <= $projects->lastPage(); $page++)
                                        @if ($page == $projects->currentPage())
                                            <li class="active"><a href="#" onclick="return false;">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $projects->url($page) }}">{{ $page }}</a></li>
                                        @endif
                                    @endfor

                                    @if ($projects->hasMorePages())
                                        <li><a href="{{ $projects->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
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
                            <form action="{{ route('skill.index') }}" method="GET" class="rbt-search-style-1">
                                @if(request('jurusan')) <input type="hidden" name="jurusan" value="{{ request('jurusan') }}"> @endif
                                <input type="text" name="search" placeholder="Cari Skill & Keahlian..." value="{{ request('search') }}" style="border: 1px solid var(--color-border); border-radius: 5px; padding: 12px 20px; width: 100%; background: var(--color-white); color: var(--color-heading);">
                                <button class="search-btn" type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--color-body);"><i class="feather-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Program Studi Filter Widget -->
                    @if($jurusans->count() > 0)
                        <div class="rbt-single-widget rbt-widget-categories" style="margin-top: 15px !important;">
                            <h4 class="title widget-title-trigger" style="font-size: 15px !important; font-weight: 600; margin-bottom: 8px !important; color: var(--color-heading); display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span>Program Keahlian</span>
                                <i class="feather-chevron-{{ request('jurusan') ? 'up' : 'down' }} filter-toggle-icon" style="font-size: 16px; transition: transform 0.3s;"></i>
                            </h4>
                            <div class="inner" style="display: {{ request('jurusan') ? 'block' : 'none' }};">
                                <ul class="category-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px !important;">
                                    <li>
                                        <a href="{{ route('skill.index', request()->except('jurusan')) }}" class="{{ !request('jurusan') ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ !request('jurusan') ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ !request('jurusan') ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                            Semua Program
                                        </a>
                                    </li>
                                    @foreach($jurusans as $jur)
                                        <li>
                                            <a href="{{ route('skill.index', array_merge(request()->all(), ['jurusan' => $jur->id])) }}" class="{{ request('jurusan') == $jur->id ? 'active' : '' }}" style="display: flex; justify-content: space-between; color: {{ request('jurusan') == $jur->id ? 'var(--color-primary) !important' : 'var(--color-body)' }}; font-weight: {{ request('jurusan') == $jur->id ? '600 !important' : '500' }}; text-decoration: none; font-size: 14px !important; padding: 2px 0 !important;">
                                                {{ $jur->nama }}
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
<!-- End Projects Area -->
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

