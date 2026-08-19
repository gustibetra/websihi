<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Learning SIHI — @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f4f6fb; min-height: 100vh; }

        .el-sidebar {
            background: linear-gradient(180deg, #13294B 0%, #1F57ED 200%);
            min-height: 100vh;
            padding: 20px 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .el-sidebar .brand {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 18px;
        }
        .el-sidebar .brand-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #FFD166; font-size: 22px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.15);
        }
        .el-sidebar .brand-text { color: #fff; }
        .el-sidebar .brand-text h6 { margin: 0; font-size: 14px; font-weight: 800; letter-spacing: -.2px; }
        .el-sidebar .brand-text small { color: rgba(255,255,255,.6); font-size: 11px; }

        .el-user-box {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 18px;
            display: flex; align-items: center; gap: 10px;
        }
        .el-user-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFD166, #06D6A0);
            display: flex; align-items: center; justify-content: center;
            color: #13294B; font-weight: 800; font-size: 14px;
            flex-shrink: 0;
        }
        .el-user-info .name { color: #fff; font-size: 13px; font-weight: 700; margin: 0; }
        .el-user-info .role { color: rgba(255,255,255,.6); font-size: 11px; margin: 0; }

        .el-section-title {
            color: rgba(255,255,255,.4);
            font-size: 10px; font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0 14px;
            margin: 14px 0 8px;
        }

        .el-nav {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px;
            border-radius: 10px;
            color: rgba(255,255,255,.7);
            text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all .25s;
            margin-bottom: 3px;
            border: none;
            background: transparent;
            width: 100%; text-align: left;
        }
        .el-nav:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
            transform: translateX(2px);
        }
        .el-nav.active {
            background: linear-gradient(135deg, rgba(255, 209, 102, .15), rgba(6, 214, 160, .1));
            color: #fff; font-weight: 700;
            border: 1px solid rgba(255, 209, 102, .3);
            box-shadow: 0 4px 14px rgba(0,0,0,.15);
        }
        .el-nav i { font-size: 17px; }

        .el-logout-btn { color: #ff8a8a; }
        .el-logout-btn:hover { background: rgba(255, 107, 107, .1) !important; color: #ff6b6b !important; }

        .el-nav .el-badge {
            margin-left: auto;
            background: #EF4444; color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 2px 7px;
            border-radius: 50px;
            line-height: 1;
        }

        .el-topbar {
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
            padding: 14px 28px;
            position: sticky; top: 0; z-index: 50;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.02);
        }
        .el-breadcrumb { font-size: 13px; color: #6B7280; }
        .el-breadcrumb .page-title { color: #1F2937; font-weight: 700; font-size: 15px; }
        .el-topbar-right { display: flex; align-items: center; gap: 14px; }
        .el-topbar-right .notif-dot {
            position: relative; width: 38px; height: 38px;
            border-radius: 50%; background: #F3F4F6;
            display: flex; align-items: center; justify-content: center;
            color: #6B7280; font-size: 18px; cursor: pointer;
            transition: all .2s;
        }
        .el-topbar-right .notif-dot:hover { background: #E5E7EB; }
        .el-topbar-right .notif-dot::after {
            content: ''; position: absolute; top: 8px; right: 10px;
            width: 8px; height: 8px; border-radius: 50%;
            background: #EF4444; border: 2px solid #fff;
        }

        .el-content { padding: 28px; }

        .el-card {
            border: none; border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,.04);
            transition: all .25s;
        }
        .el-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.08); }

        .alert { border-radius: 10px; border: none; font-size: 13px; padding: 12px 16px; }
        .alert-success { background: #D1FAE5; color: #065F46; }
        .alert-danger { background: #FEE2E2; color: #991B1B; }
        .alert-warning { background: #FEF3C7; color: #92400E; }

        .el-role-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 50px;
            font-size: 10px; font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .el-role-badge.staff-pengajar { background: #DBEAFE; color: #1E40AF; }
        .el-role-badge.staff-admin { background: #FEF3C7; color: #92400E; }
        .el-role-badge.staff-direktur { background: #FDE68A; color: #78350F; }
        .el-role-badge.mahasiswa { background: #D1FAE5; color: #065F46; }

        .dropdown-menu { border-radius: 12px !important; border: none !important; box-shadow: 0 10px 30px rgba(0,0,0,.1) !important; }
        .dropdown-item { font-size: 13px; padding: 8px 16px; border-radius: 6px; margin: 2px 6px; width: calc(100% - 12px); }
        .dropdown-item:hover { background: #F3F4F6; }

        .el-mobile-toggle {
            display: none; background: none; border: none;
            color: #1F57ED; font-size: 22px;
        }

        @media (max-width: 991px) {
            .el-sidebar {
                position: fixed; top: 0; left: -280px;
                width: 260px; transition: left .3s;
                min-height: 100vh;
            }
            .el-sidebar.show { left: 0; box-shadow: 10px 0 30px rgba(0,0,0,.2); }
            .el-mobile-toggle { display: block; }
            .el-content { padding: 18px; }
            .el-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,.4); z-index: 99;
            }
            .el-overlay.show { display: block; }
        }
    </style>
</head>
<body>

@php
    $user = auth('elearning')->user();
    if (!$user) {
        abort(403, 'Sesi berakhir. Silakan login kembali.');
    }
    $initials = collect(explode(' ', trim($user->name)))
        ->take(2)
        ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
        ->implode('');

    // ✅ ROLE HELPERS
    $isStaff      = $user->role === 'staff';
    $isPengajar   = $isStaff && $user->staff_type === 'pengajar';
    $isAdminKeu   = $isStaff && in_array($user->staff_type, ['administrasi', 'keuangan']);
    $isDirektur   = $isStaff && $user->staff_type === 'direktur';
    $isWadir      = $isStaff && $user->staff_type === 'wakil_direktur';
    $isMahasiswa  = $user->role === 'mahasiswa';

    $roleBadgeClass = $isPengajar ? 'staff-pengajar'
        : ($isAdminKeu ? 'staff-admin'
        : (($isDirektur || $isWadir) ? 'staff-direktur' : 'mahasiswa'));

    $roleLabel = $isPengajar ? 'Staff Pengajar'
        : ($isAdminKeu ? 'Staff Admin & Keuangan'
        : ($isDirektur ? 'Direktur Lembaga'
        : ($isWadir ? 'Wakil Direktur' : 'Mahasiswa')));

    // ✅ AMAN: semua count dibungkus try-catch
    $tunggakanCount = 0;
    $berkasMenungguCount = 0;
    $lamaranBaruCount = 0;
    try {
        if ($isAdminKeu) {
            $tunggakanCount = \DB::table('elearning_payments')->where('status', 'Tunggakan')->count();
            $berkasMenungguCount = \DB::table('elearning_documents')->where('status', 'Menunggu')->count();
            $lamaranBaruCount = \DB::table('elearning_job_applications')->where('status', 'Baru')->count();
        }
    } catch (\Throwable $e) {
        // Silent fail - jangan pernah crash
    }

    // ✅ AMAN: cek route ada sebelum dipanggil
    $hasDashboardRoute   = app('router')->has('elearning.staff.dashboard');
    $hasAbsenRoute       = app('router')->has('elearning.staff.absen');
    $hasMonitorRoute     = app('router')->has('elearning.staff.absensi.monitor');
    $hasPendaftarRoute   = app('router')->has('elearning.staff.pendaftar');
    $hasPembayaranRoute  = app('router')->has('elearning.staff.pembayaran');
    $hasBerkasRoute      = app('router')->has('elearning.staff.berkas');
    $hasBerkasAlumniRoute = app('router')->has('elearning.staff.berkas.alumni');
    $hasLokerRoute       = app('router')->has('elearning.staff.loker');
    $hasKelasRoute       = app('router')->has('elearning.staff.kelas');
    $hasMahasiswaDashboard = app('router')->has('elearning.mahasiswa.dashboard');
    $hasMahasiswaAbsen   = app('router')->has('elearning.mahasiswa.absen');
    $hasMahasiswaMateri  = app('router')->has('elearning.mahasiswa.materi');
    $hasMahasiswaKelas   = app('router')->has('elearning.mahasiswa.kelas');
    $hasMahasiswaBayar   = app('router')->has('elearning.mahasiswa.pembayaran');
    $hasMahasiswaBerkas  = app('router')->has('elearning.mahasiswa.berkas');
    $hasProfileRoute     = app('router')->has('elearning.profile');
    $hasHomeRoute        = app('router')->has('home');
    $hasLogoutRoute      = app('router')->has('elearning.logout');
@endphp

<div class="el-overlay" id="elOverlay" onclick="toggleSidebar()"></div>

<div class="container-fluid p-0">
    <div class="row g-0">

        {{-- ══════════════ SIDEBAR ══════════════ --}}
        <div class="col-lg-auto col-xl-2">
            <aside class="el-sidebar" id="elSidebar">

                <div class="brand">
                    <div class="brand-icon"><i class="ri-graduation-cap-fill"></i></div>
                    <div class="brand-text">
                        <h6>E-Learning</h6>
                        <small>SIHI Portal</small>
                    </div>
                </div>

                <div class="el-user-box">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,255,255,.2);">
                    @else
                        <div class="el-user-avatar">{{ $initials }}</div>
                    @endif
                    <div class="el-user-info">
                        <p class="name">{{ \Illuminate\Support\Str::limit($user->name, 22) }}</p>
                        <p class="role">{{ $roleLabel }}</p>
                    </div>
                </div>

                <div class="el-section-title">Menu Utama</div>
                <nav>
                    @if($isStaff)
                        {{-- Dashboard --}}
                        @if($hasDashboardRoute)
                            <a class="el-nav {{ request()->routeIs('elearning.staff.dashboard') ? 'active' : '' }}"
                               href="{{ route('elearning.staff.dashboard') }}">
                                <i class="ri-dashboard-3-line"></i> Dashboard
                            </a>
                        @endif

                        {{-- Ruang Absen --}}
                        @if($hasAbsenRoute)
                            <a class="el-nav {{ request()->routeIs('elearning.staff.absen*') ? 'active' : '' }}"
                               href="{{ route('elearning.staff.absen') }}">
                                <i class="ri-fingerprint-2-line"></i> Ruang Absen
                            </a>
                        @endif

                        {{-- ✅ DIREKTUR: Monitor Absensi Staff (AMAN) --}}
                        @if($isDirektur && $hasMonitorRoute)
                            <a class="el-nav {{ request()->routeIs('elearning.staff.absensi.monitor*') ? 'active' : '' }}"
                               href="{{ route('elearning.staff.absensi.monitor') }}">
                                <i class="ri-group-line"></i> Monitor Absensi Staff
                            </a>
                        @endif

                        {{-- ✅ WAKIL DIREKTUR: Data Pendaftar (AMAN) --}}
                        @if($isWadir && $hasPendaftarRoute)
                            <a class="el-nav {{ request()->routeIs('elearning.staff.pendaftar*') ? 'active' : '' }}"
                               href="{{ route('elearning.staff.pendaftar') }}">
                                <i class="ri-file-list-3-line"></i> Data Pendaftar
                            </a>
                        @endif

                        {{-- Admin & Keuangan --}}
                        @if($isAdminKeu)
                            @if($hasPembayaranRoute)
                                <a class="el-nav {{ request()->routeIs('elearning.staff.pembayaran*') ? 'active' : '' }}"
                                   href="{{ route('elearning.staff.pembayaran') }}">
                                    <i class="ri-money-dollar-circle-line"></i> Ruang Pembayaran
                                    @if($tunggakanCount > 0)
                                        <span class="el-badge">{{ $tunggakanCount }}</span>
                                    @endif
                                </a>
                            @endif

                            @if($hasBerkasRoute)
                                <a class="el-nav {{ request()->routeIs('elearning.staff.berkas*') ? 'active' : '' }}"
                                   href="{{ route('elearning.staff.berkas') }}">
                                    <i class="ri-folder-zip-line"></i> Berkas Mahasiswa
                                    @if($berkasMenungguCount > 0)
                                        <span class="el-badge">{{ $berkasMenungguCount }}</span>
                                    @endif
                                </a>
                            @endif

                            @if($hasBerkasAlumniRoute)
                                <a class="el-nav {{ request()->routeIs('elearning.staff.berkas.alumni*') ? 'active' : '' }}"
                                   href="{{ route('elearning.staff.berkas.alumni') }}">
                                    <i class="ri-briefcase-4-line"></i> Berkas Alumni
                                    @if($lamaranBaruCount > 0)
                                        <span class="el-badge">{{ $lamaranBaruCount }}</span>
                                    @endif
                                </a>
                            @endif

                            @if($hasLokerRoute)
                                <a class="el-nav {{ request()->routeIs('elearning.staff.loker*') ? 'active' : '' }}"
                                   href="{{ route('elearning.staff.loker') }}">
                                    <i class="ri-briefcase-4-line"></i> Kelola Loker
                                </a>
                            @endif
                        @endif

                        {{-- Pengajar --}}
                        @if($isPengajar && $hasKelasRoute)
                            <a class="el-nav {{ request()->routeIs('elearning.staff.kelas*') ? 'active' : '' }}"
                               href="{{ route('elearning.staff.kelas') }}">
                                <i class="ri-book-open-line"></i> Ruang Kelas
                            </a>
                        @endif
                    @else
                        {{-- MAHASISWA --}}
                        @if($hasMahasiswaDashboard)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.dashboard') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.dashboard') }}">
                                <i class="ri-dashboard-3-line"></i> Dashboard
                            </a>
                        @endif

                        @if($hasMahasiswaAbsen)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.absen*') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.absen') }}">
                                <i class="ri-fingerprint-2-line"></i> Ruang Absensi
                            </a>
                        @endif

                        @if($hasMahasiswaMateri)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.materi*') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.materi') }}">
                                <i class="ri-folder-download-line"></i> Ruang Materi
                            </a>
                        @endif

                        @if($hasMahasiswaKelas)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.kelas*') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.kelas') }}">
                                <i class="ri-edit-2-line"></i> Ruang Kelas
                            </a>
                        @endif

                        @if($hasMahasiswaBayar)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.pembayaran') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.pembayaran') }}">
                                <i class="ri-money-dollar-circle-line"></i> Pembayaran
                            </a>
                        @endif

                        @if($hasMahasiswaBerkas)
                            <a class="el-nav {{ request()->routeIs('elearning.mahasiswa.berkas*') ? 'active' : '' }}"
                               href="{{ route('elearning.mahasiswa.berkas') }}">
                                <i class="ri-folder-zip-line"></i> Ruang Berkas
                            </a>
                        @endif
                    @endif
                </nav>

                <div class="el-section-title">Lainnya</div>
                <nav>
                    @if($hasProfileRoute)
                        <a class="el-nav" href="{{ route('elearning.profile') }}">
                            <i class="ri-user-settings-line"></i> Profil Saya
                        </a>
                    @endif
                    @if($hasHomeRoute)
                        <a class="el-nav" href="{{ route('home') }}" target="_blank">
                            <i class="ri-global-line"></i> Website Utama
                        </a>
                    @endif
                    @if($hasLogoutRoute)
                        <form method="POST" action="{{ route('elearning.logout') }}" class="mt-3 px-0">
                            @csrf
                            <button type="submit" class="el-nav el-logout-btn"
                                    onclick="return confirm('Yakin ingin keluar?')">
                                <i class="ri-logout-box-r-line"></i> Keluar
                            </button>
                        </form>
                    @endif
                </nav>
            </aside>
        </div>

        {{-- ══════════════ MAIN AREA ══════════════ --}}
        <div class="col-lg col-xl-10">

            <div class="el-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="el-mobile-toggle" onclick="toggleSidebar()">
                        <i class="ri-menu-3-line"></i>
                    </button>
                    <div class="el-breadcrumb">
                        <small><i class="ri-home-4-line me-1"></i> E-Learning</small>
                        @hasSection('title')
                            <div class="page-title">@yield('title')</div>
                        @endif
                    </div>
                </div>
                
                <div class="el-topbar-right">
                    <div class="notif-dot" title="Notifikasi">
                        <i class="ri-notification-3-line"></i>
                    </div>
                    
                    <div class="dropdown">
                        <button class="d-flex align-items-center gap-2 border-0 bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.08);">
                            @else
                                <div class="el-user-avatar" style="width:38px;height:38px;font-size:13px;">{{ $initials }}</div>
                            @endif
                            <div class="d-none d-md-block text-start">
                                <div style="font-size:13px;font-weight:700;color:#1F2937;line-height:1;">
                                    {{ \Illuminate\Support\Str::limit($user->name, 20) }}
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="el-role-badge {{ $roleBadgeClass }}">{{ $roleLabel }}</span>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-muted ms-1 d-none d-md-block"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 240px; margin-top: 12px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold small">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $user->nomor_induk ?? ($user->email ?? '') }}</div>
                            </li>
                            <li class="py-1">
                                @if($hasProfileRoute)
                                    <a class="dropdown-item" href="{{ route('elearning.profile') }}">
                                        <i class="ri-user-settings-line me-2 text-primary"></i>Profil, Foto & Password
                                    </a>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                @if($hasLogoutRoute)
                                    <form method="POST" action="{{ route('elearning.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="ri-logout-box-r-line me-2"></i>Keluar
                                        </button>
                                    </form>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="el-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                        <i class="ri-checkbox-circle-fill" style="font-size:18px;"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                        <i class="ri-error-warning-fill" style="font-size:18px;"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="ri-error-warning-fill" style="font-size:18px;"></i>
                            <strong>Terdapat kesalahan:</strong>
                        </div>
                        <ul class="mb-0 ps-4">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('elSidebar').classList.toggle('show');
        document.getElementById('elOverlay').classList.toggle('show');
    }
</script>
@stack('scripts')
</body>
</html>