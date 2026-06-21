<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') @if(View::hasSection('title')) - @endif {{ $seoConfig->data1 ?? ($settings->institution_name ?? 'Portal Sekolah') }}</title>

@if(View::hasSection('meta_description'))
    <meta name="description" content="@yield('meta_description')">
@elseif(View::hasSection('description'))
    <meta name="description" content="@yield('description')">
@else
    <meta name="description" content="{{ $seoConfig->text1 ?? ($settings->description ?? 'Portal Resmi Sekolah') }}">
@endif

<meta name="keywords" content="@yield('meta_keywords', $seoConfig->text2 ?? '')">

<!-- Google Site Verification -->
@if($seoConfig && $seoConfig->data3)
    <meta name="google-site-verification" content="{{ $seoConfig->data3 }}">
@endif

<!-- Open Graph / OG Tags -->
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('title') @if(View::hasSection('title')) - @endif {{ $seoConfig->data1 ?? ($settings->institution_name ?? 'Portal Sekolah') }}">
<meta property="og:description" content="@yield('meta_description', $seoConfig->text1 ?? ($settings->description ?? 'Portal Resmi Sekolah'))">
@if($seoConfig && $seoConfig->data4)
    <meta property="og:image" content="{{ asset('storage/' . $seoConfig->data4) }}">
@endif

<!-- Google Analytics -->
@if($seoConfig && $seoConfig->data2)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoConfig->data2 }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $seoConfig->data2 }}');
    </script>
@endif

<!-- Favicon -->
@if($settings && $settings->favicon)
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $settings->favicon) }}">
@elseif($settings && $settings->logo_square)
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $settings->logo_square) }}">
@else
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/site/images/favicon.png') }}">
@endif

<!-- CSS here -->
<link rel="stylesheet" href="{{ asset('assets/site/css/vendor/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/vendor/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/vendor/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/sal.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/feather.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/euclid-circulara.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/swiper.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/odometer.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/animation.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/magnigy-popup.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/plyr.css') }}">
<link rel="stylesheet" href="{{ asset('assets/site/css/plugins/jodit.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

<link rel="stylesheet" href="{{ asset('assets/site/css/styles.css') }}">

<!-- Additional CSS -->
@stack('styles')

<!-- Livewire Styles -->
@livewireStyles

