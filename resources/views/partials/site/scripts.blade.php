<!-- JS here -->
<!-- Modernizer JS -->
<script src="{{ asset('assets/site/js/vendor/modernizr.min.js') }}"></script>
<!-- jQuery JS -->
<script src="{{ asset('assets/site/js/vendor/jquery.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/site/js/vendor/bootstrap.min.js') }}"></script>
<!-- sal.js -->
<script src="{{ asset('assets/site/js/vendor/sal.js') }}"></script>
<!-- Dark Mode Switcher -->
<script src="{{ asset('assets/site/js/vendor/js.cookie.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/jquery.style.switcher.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/swiper.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/jquery-appear.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/odometer.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/backtotop.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/isotop.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/imageloaded.js') }}"></script>

<script src="{{ asset('assets/site/js/vendor/wow.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/waypoint.min.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/easypie.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/text-type.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/jquery-one-page-nav.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/magnify-popup.min.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/paralax-scroll.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/paralax.min.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/countdown.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/plyr.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/jodit.min.js') }}"></script>
<script src="{{ asset('assets/site/js/vendor/Sortable.min.js') }}"></script>

<script>
    window.siteSecuritySettings = {
        disableDevtools: {{ app(\App\Services\SecuritySettingService::class)->isEnabled('disable_devtools') ? 'true' : 'false' }}
    };
</script>

<!-- Main JS -->
<script src="{{ asset('assets/site/js/main.js') }}?v={{ filemtime(public_path('assets/site/js/main.js')) }}"></script>

<!-- Livewire Scripts -->
@livewireScripts

<!-- Additional JS -->
@stack('scripts')
