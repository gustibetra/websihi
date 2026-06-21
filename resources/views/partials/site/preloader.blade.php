<!-- preloader start -->
<div id="pre-load">
    <div id="loader" class="loader">
        <div class="loader-container has-theme-yellow">
            <div class="loader-icon">
                @if($settings && $settings->logo_square)
                    <img src="{{ asset('storage/' . $settings->logo_square) }}" alt="{{ $settings->institution_name ?? 'DPRD' }}">
                @elseif($settings && $settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->institution_name ?? 'DPRD' }}">
                @else
                    <img src="{{ asset('assets/site/images/favicon-yellow.png') }}" alt="DPRD">
                @endif
            </div>
        </div>
    </div>
</div>
<!-- preloader end -->

<!-- Mouse cursor -->
<div id="rs-mouse">
    <div id="cursor-ball"></div>
</div>
<!-- preloader end -->

