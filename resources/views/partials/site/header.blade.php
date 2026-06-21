<!-- Start Header Area -->
<header class="rbt-header rbt-header-4 rbt-header-4-container-var">
    <div class="rbt-sticky-placeholder"></div>
    <!-- Start Header Top -->
    <div class="rbt-header-top rbt-header-top-1 header-space-betwween bg-color-white rbt-border-bottom d-none d-xl-block">
        <div class="container">
            <div class="rbt-header-sec align-items-center ">
                <div class="rbt-header-sec-col rbt-header-left">
                    <div class="rbt-header-content">
                        <div class="header-info">
                            <ul class="rbt-information-list">
                                @if($settings && $settings->phone)
                                    <li>
                                        <a href="tel:{{ $settings->phone }}"><i class="feather-phone"></i>{{ $settings->phone }}</a>
                                    </li>
                                @endif
                                @if($settings && $settings->email)
                                    <li>
                                        <a href="mailto:{{ $settings->email }}"><i class="feather-mail"></i>{{ $settings->email }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="rbt-header-sec-col rbt-header-right">
                    <div class="rbt-header-content">
                        <div class="header-info">
                            <ul class="social-share-transparent version-02">
                                @if($settings && $settings->facebook)
                                    <li>
                                        <a href="{{ $settings->facebook }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                @endif
                                @if($settings && $settings->twitter)
                                    <li>
                                        <a href="{{ $settings->twitter }}" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                                    </li>
                                @endif
                                @if($settings && $settings->instagram)
                                    <li>
                                        <a href="{{ $settings->instagram }}" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                                    </li>
                                @endif
                                @if($settings && $settings->youtube)
                                    <li>
                                        <a href="{{ $settings->youtube }}" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top -->

    <div class="rbt-header-wrapper header-space-betwween shadow-none bg-color-white header-sticky">
        <div class="container">
            <div class="mainbar-row rbt-navigation-start align-items-center">
                <div class="header-left">
                    <div class="logo logo-dark">
                        <a href="{{ route('home') }}">
                            @if($settings && $settings->logo)
                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->institution_name ?? 'Sekolah' }}" style="max-height: 55px; width: auto;">
                            @else
                                <img src="{{ asset('assets/site/images/logo/logo.png') }}" alt="logo">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            @if(isset($headerMenus) && $headerMenus->count() > 0)
                                @include('partials.site.menu-item', ['menus' => $headerMenus])
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <!-- Navbar Icons -->
                    <ul class="quick-access">
                        <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn" href="#">
                                <i class="feather-search"></i>
                            </a>
                        </li>
                    </ul>

                     <div class="rbt-separator d-none d-xl-block"></div>

                    <div class="rbt-btn-wrapper d-none d-xl-block ms-4">
                        <a class="rbt-btn btn-gradient btn-xs" href="{{ ($settings && $settings->ppdb_link) ? $settings->ppdb_link : '#' }}" {!! ($settings && $settings->ppdb_link) ? 'target="_blank" rel="noopener"' : '' !!}>PPDB</a>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar d-block d-xl-none">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                    <!-- End Mobile-Menu-Bar -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Search Dropdown  -->
    <div class="rbt-search-dropdown">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('berita.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Cari berita, agenda, pengumuman..." value="{{ request('search') }}">
                        <div class="submit-btn">
                            <button class="rbt-btn btn-gradient btn-md" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Search Dropdown  -->
</header>
