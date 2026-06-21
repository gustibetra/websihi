<!doctype html>
<html lang="id" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    @include('partials.admin.header')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('partials.admin.topbar')

        @include('partials.admin.sidebar')

        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row mt-0">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@yield('page-title', 'Dashboard')</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('breadcrumb-parent', 'Home')</a></li>
                                        <li class="breadcrumb-item active">@yield('breadcrumb-current', 'Dashboard')</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            @php $appSetting = \App\Models\Setting::first(); @endphp
                            <script>document.write(new Date().getFullYear())</script> &copy;
                            {{ $appSetting?->site_name ?? config('app.name', 'Website SMK') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Mirrorapps
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('partials.admin.customizer')
    @include('partials.admin.script')
    
    <!-- Page Specific Scripts -->
    @yield('page-scripts')

</body>

</html>
