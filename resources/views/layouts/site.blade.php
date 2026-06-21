<!doctype html>
<html class="no-js" lang="id">
<head>
    @include('partials.site.head')
</head>
<body class="rbt-header-sticky">
    @include('partials.site.header')
    
    @include('partials.site.offcanvas')

    <!-- Body main wrapper start -->
    <main class="rbt-main-wrapper">
        @yield('content')
    </main>
    <!-- Body main wrapper end -->

    @include('partials.site.cta-ppdb')

    @include('partials.site.footer')

    @include('partials.site.backtotop')

    @include('partials.site.scripts')
</body>
</html>
