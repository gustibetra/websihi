@php
    $setting = \App\Models\Setting::first();
    $institutionName = $setting && $setting->institution_name ? $setting->institution_name : 'DPRD';
    $faviconUrl = $setting && $setting->favicon ? asset('storage/' . $setting->favicon) : asset('assets/admin/images/favicon.ico');
@endphp
<meta charset="utf-8" />
<title>@yield('title', 'Dashboard') | {{ $institutionName }} Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Sistem Informasi {{ $institutionName }}" name="description" />
<meta content="{{ $institutionName }}" name="author" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}?v={{ time() }}">
<link rel="icon" type="image/png" href="{{ $faviconUrl }}?v={{ time() }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}?v={{ time() }}">

<script src="{{ asset('assets/admin/js/layout.js') }}"></script>
<link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/cropperjs/cropper.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    /* Avatar user form - scoped, tidak konflik dengan .avatar-lg template */
    .user-avatar-lg { width: 80px; height: 80px; }
    .user-avatar-lg .avatar-title { width: 100%; height: 100%; overflow: hidden; }
    .cropper-view-box, .cropper-face { border-radius: 50%; }
    
    /* Hide dash indicator on collapsible submenus when icons are used */
    .navbar-menu .navbar-nav .nav-sm .nav-link::before {
        display: none !important;
    }
</style>

<script>
    window.assetBaseUrl = '{{ asset('') }}';
    window.assetAdminUrl = '{{ asset('assets/admin') }}';
</script>

<!-- Custom CSS -->
@stack('styles')

<!-- Livewire Styles -->
@livewireStyles