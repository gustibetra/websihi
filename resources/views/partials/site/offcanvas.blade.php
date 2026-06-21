<!-- Mobile Menu Section -->
<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        @if($settings && $settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->institution_name ?? 'Sekolah' }}" style="max-height: 50px; width: auto;">
                        @else
                            <img src="{{ asset('assets/site/images/logo/logo.png') }}" alt="logo">
                        @endif
                    </a>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            @if($settings && $settings->description)
                <p class="description">{{ Str::limit($settings->description, 100) }}</p>
            @endif
            <ul class="navbar-top-left rbt-information-list justify-content-start">
                @if($settings && $settings->email)
                    <li>
                        <a href="mailto:{{ $settings->email }}"><i class="feather-mail"></i>{{ $settings->email }}</a>
                    </li>
                @endif
                @if($settings && $settings->phone)
                    <li>
                        <a href="tel:{{ $settings->phone }}"><i class="feather-phone"></i>{{ $settings->phone }}</a>
                    </li>
                @endif
            </ul>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                @if(isset($headerMenus) && $headerMenus->count() > 0)
                    @include('partials.site.menu-item', ['menus' => $headerMenus])
                @endif
            </ul>
        </nav>

        <div class="rbt-offcanvas-footer">
            <div class="social-share-transparent justify-content-start">
                @if($settings && $settings->facebook)
                    <a href="{{ $settings->facebook }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if($settings && $settings->twitter)
                    <a href="{{ $settings->twitter }}" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                @endif
                @if($settings && $settings->instagram)
                    <a href="{{ $settings->instagram }}" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                @endif
                @if($settings && $settings->youtube)
                    <a href="{{ $settings->youtube }}" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>
