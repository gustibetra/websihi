<!-- Start Footer Area -->
<footer class="rbt-footer footer-style-1 bg-color-white">
    <div class="footer-top">
        <div class="rbt-separator-mid">
            <div class="container">
                <div class="row g-5">
                    <!-- Column 1: Profile & Social Share -->
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                        <div class="footer-widget">
                            <div class="logo logo-dark">
                                <a href="{{ route('home') }}">
                                    @if($settings && $settings->logo)
                                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->institution_name ?? 'Sekolah' }}" style="max-height: 60px; width: auto;">
                                    @else
                                        <img src="{{ asset('assets/site/images/logo/logo.png') }}" alt="logo">
                                    @endif
                                </a>
                            </div>
                            @if($settings && $settings->description)
                                <p class="description mt--20">{{ Str::limit($settings->description, 200) }}</p>
                            @endif

                            <ul class="social-icon social-default justify-content-start mt--20">
                                @if($settings && $settings->facebook)
                                    <li>
                                        <a href="{{ $settings->facebook }}" target="_blank" rel="noopener">
                                            <i class="feather-facebook"></i>
                                        </a>
                                    </li>
                                @endif
                                @if($settings && $settings->twitter)
                                    <li>
                                        <a href="{{ $settings->twitter }}" target="_blank" rel="noopener">
                                            <i class="feather-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                                @if($settings && $settings->instagram)
                                    <li>
                                        <a href="{{ $settings->instagram }}" target="_blank" rel="noopener">
                                            <i class="feather-instagram"></i>
                                        </a>
                                    </li>
                                @endif
                                @if($settings && $settings->youtube)
                                    <li>
                                        <a href="{{ $settings->youtube }}" target="_blank" rel="noopener">
                                            <i class="feather-youtube"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h5 class="ft-title">Tautan Cepat</h5>
                            <ul class="ft-link">
                                @if(isset($footerMenus) && $footerMenus->count() > 0)
                                    @foreach($footerMenus as $menu)
                                        <li>
                                            <a href="{{ $menu->url ?? '#' }}" @if($menu->open_new_tab) target="_blank" rel="noopener" @endif>{{ $menu->title }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li><a href="{{ route('home') }}">Beranda</a></li>
                                    <li><a href="{{ route('berita.index') }}">Berita & Artikel</a></li>
                                    <li><a href="{{ route('agenda.index') }}">Agenda Sekolah</a></li>
                                    <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Column 3: Contact Details -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h5 class="ft-title">Hubungi Kami</h5>
                            <ul class="ft-link">
                                @if($settings && $settings->phone)
                                    <li><span>Telepon:</span> <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></li>
                                @endif
                                @if($settings && $settings->email)
                                    <li><span>Email:</span> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                                @endif
                                @if($settings && $settings->address)
                                    <li><span>Alamat:</span> <span class="d-block text-muted mt-1" style="font-size: 14px; line-height: 1.6;">{{ $settings->address }}</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Area -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
    
    <div class="copyright-area copyright-style-1 ptb--20">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                    <p class="rbt-link-hover text-center text-lg-start">© {{ date('Y') }} <a href="#">{{ $settings->institution_name ?? 'Portal Sekolah' }}</a>. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                    <ul class="copyright-link rbt-link-hover justify-content-center justify-content-lg-end mt_sm--10 mt_md--10">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('berita.index') }}">Berita</a></li>
                        <li><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
