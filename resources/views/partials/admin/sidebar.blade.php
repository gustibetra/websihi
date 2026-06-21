        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                @php
                    $setting = \App\Models\Setting::first();
                    $logoUrl = $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('assets/admin/images/logo-dark.png');
                    $logoSquareUrl = $setting && $setting->logo_square ? asset('storage/' . $setting->logo_square) : asset('assets/admin/images/logo-sm.png');
                @endphp
                
                <!-- Dark Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ $logoSquareUrl }}" alt="" style="height: 50px; width: 50px; object-fit: contain;">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ $logoUrl }}" alt="" style="height: 50px; max-width: 180px; object-fit: contain;">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ $logoSquareUrl }}" alt="" style="height: 50px; width: 50px; object-fit: contain;">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ $logoUrl }}" alt="" style="height: 50px; max-width: 180px; object-fit: contain;">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                            </a>
                        </li>

                        <!-- ── Konten ────────────────────────────────────────────── -->
                        <li class="menu-title"><i class="ri-more-fill"></i> <span>Konten</span></li>
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                                <i class="ri-newspaper-line"></i> <span>Berita</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
                                <i class="ri-megaphone-line"></i> <span>Pengumuman</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.events.*') || request()->routeIs('admin.agendas.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                                <i class="ri-calendar-event-line"></i> <span>Agenda / Kegiatan</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                                <i class="ri-file-text-line"></i> <span>Halaman</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
                                <i class="ri-gallery-line"></i> <span>Galeri</span>
                            </a>
                        </li>

                        @auth
                            @if(auth()->user()->isAdmin())
                            
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.testimonials.index') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                                    <i class="ri-discuss-line"></i> <span>Testimoni</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.structural.index') || request()->routeIs('admin.teachers.*') || request()->routeIs('admin.students.index') || request()->routeIs('admin.alumni.index') || request()->routeIs('admin.structure.*') ? '' : 'collapsed' }}" 
                                   href="#sidebarSDM" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ request()->routeIs('admin.structural.index') || request()->routeIs('admin.teachers.*') || request()->routeIs('admin.students.index') || request()->routeIs('admin.alumni.index') || request()->routeIs('admin.structure.*') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarSDM">
                                    <i class="ri-team-line"></i> <span data-key="t-sdm">SDM</span>
                                </a>
                                <div class="collapse menu-dropdown {{ request()->routeIs('admin.structural.index') || request()->routeIs('admin.teachers.*') || request()->routeIs('admin.students.index') || request()->routeIs('admin.alumni.index') || request()->routeIs('admin.structure.*') ? 'show' : '' }}" id="sidebarSDM">
                                    <ul class="nav nav-sm flex-column">
                                        @if(auth()->user()->isSuperAdmin())
                                        <li class="nav-item">
                                            <a href="{{ route('admin.structural.index') }}" class="nav-link {{ request()->routeIs('admin.structural.index') ? 'active' : '' }}">
                                                <i class="ri-building-3-line"></i> <span>Struktural Yayasan</span>
                                            </a>
                                        </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                                                <i class="ri-team-line"></i> <span>Guru & Tendik</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                                                <i class="ri-user-voice-line"></i> <span>Siswa</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.alumni.index') }}" class="nav-link {{ request()->routeIs('admin.alumni.index') ? 'active' : '' }}">
                                                <i class="ri-user-star-line"></i> <span>Alumni</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.structure.index') }}" class="nav-link {{ request()->routeIs('admin.structure.*') ? 'active' : '' }}">
                                                <i class="ri-organization-chart"></i> <span>Anggota Struktur</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ── Data Sekolah ───────────────────────────────────────── -->
                            <!-- <li class="menu-title"><i class="ri-more-fill"></i> <span>Data Sekolah</span></li> -->
                            
                            @php
                                $isDataSekolahActive = request()->routeIs('admin.jurusan.*') || 
                                    request()->routeIs('admin.achievements.*') || 
                                    request()->routeIs('admin.mitra-industri.*') || 
                                    request()->routeIs('admin.fasilitas.*') || 
                                    request()->routeIs('admin.downloads.*');
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ $isDataSekolahActive ? '' : 'collapsed' }}" 
                                   href="#sidebarDataSekolah" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ $isDataSekolahActive ? 'true' : 'false' }}" 
                                   aria-controls="sidebarDataSekolah">
                                    <i class="ri-graduation-cap-line"></i> <span data-key="t-data-sekolah">Data Sekolah</span>
                                </a>
                                <div class="collapse menu-dropdown {{ $isDataSekolahActive ? 'show' : '' }}" id="sidebarDataSekolah">
                                    <ul class="nav nav-sm flex-column">
                                        @if(auth()->user()->isSuperAdmin())
                                        <li class="nav-item">
                                            <a href="{{ route('admin.jurusan.index') }}" class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
                                                <i class="ri-book-2-line"></i> <span>Program Jurusan</span>
                                            </a>
                                        </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route('admin.achievements.index') }}" class="nav-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                                                <i class="ri-trophy-line"></i> <span>Prestasi</span>
                                            </a>
                                        </li>
                                        @if(auth()->user()->isSuperAdmin())
                                        <li class="nav-item">
                                            <a href="{{ route('admin.mitra-industri.index') }}" class="nav-link {{ request()->routeIs('admin.mitra-industri.*') ? 'active' : '' }}">
                                                <i class="ri-building-2-line"></i> <span>Mitra DU/DI</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.fasilitas.index') }}" class="nav-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                                                <i class="ri-home-office-line"></i> <span>Fasilitas</span>
                                            </a>
                                        </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route('admin.downloads.index') }}" class="nav-link {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}">
                                                <i class="ri-download-cloud-line"></i> <span>Download Center</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            @if(auth()->user()->isSuperAdmin())
                            <!-- ── Pengaturan ─────────────────────────────────────────── -->
                            <!-- <li class="menu-title"><i class="ri-more-fill"></i> <span>Pengaturan</span></li> -->

                            @php
                                $isPengaturanActive = request()->routeIs('admin.settings.*') || request()->routeIs('admin.users.*') || (request()->routeIs('admin.common-data.*') && !request()->routeIs('admin.common-data.show'));
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ $isPengaturanActive ? '' : 'collapsed' }}" 
                                   href="#sidebarPengaturan" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ $isPengaturanActive ? 'true' : 'false' }}" 
                                   aria-controls="sidebarPengaturan">
                                    <i class="ri-settings-3-line"></i> <span data-key="t-pengaturan">Pengaturan</span>
                                </a>
                                <div class="collapse menu-dropdown {{ $isPengaturanActive ? 'show' : '' }}" id="sidebarPengaturan">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                                <i class="ri-settings-3-line"></i> <span>Pengaturan Website</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.common-data.index') }}" class="nav-link {{ request()->routeIs('admin.common-data.index') ? 'active' : '' }}">
                                                <i class="ri-database-2-line"></i> <span>Common Data</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                                <i class="ri-user-settings-line"></i> <span>Manajemen User</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @endif
                        @endauth

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
