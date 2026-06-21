@if(isset($ppdbConfig) || ($settings && $settings->ppdb_link))
    <!-- Start CallTo Action Area  -->
    <div class="rbt-call-to-action-area rbt-section-gap bg-gradient-8">
        <div class="rbt-callto-action rbt-cta-default style-6">
            <div class="container">
                <div class="row g-5 align-items-center content-wrapper">
                    <div class="col-xxl-3 col-xl-3 col-lg-6">
                        <div class="inner">
                            <div class="content text-start">
                                <h2 class="title color-white mb--0">{{ ($ppdbConfig && $ppdbConfig->data2) ? $ppdbConfig->data2 : 'Pendaftaran PPDB' }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="inner-content text-start">
                            @if(($ppdbConfig && $ppdbConfig->is_active) || ($settings && $settings->ppdb_link))
                                <p class="color-white">{{ ($ppdbConfig && $ppdbConfig->text1) ? $ppdbConfig->text1 : 'Ayo bergabung bersama keluarga besar sekolah kami! Pendaftaran online PPDB tahun ajaran baru telah resmi dibuka.' }}</p>
                            @else
                                <p class="color-white">Penerimaan Peserta Didik Baru (PPDB) belum resmi dibuka untuk tahun ajaran baru. Silakan pelajari syarat, alur pendaftaran, dan informasi lengkap mengenai PPDB di halaman informasi kami.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-6">
                        <div class="call-to-btn text-start text-xl-end">
                            <a class="rbt-btn btn-white hover-icon-reverse" href="{{ ($settings && $settings->ppdb_link) ? $settings->ppdb_link : (($ppdbConfig && $ppdbConfig->data4) ? $ppdbConfig->data4 : '#') }}" {!! ($settings && $settings->ppdb_link) ? 'target="_blank" rel="noopener"' : '' !!}>
                                <span class="icon-reverse-wrapper">
                                    @if(($ppdbConfig && $ppdbConfig->is_active) || ($settings && $settings->ppdb_link))
                                        <span class="btn-text">{{ ($ppdbConfig && $ppdbConfig->data3) ? $ppdbConfig->data3 : 'Daftar Sekarang' }}</span>
                                    @else
                                        <span class="btn-text">Info PPDB</span>
                                    @endif
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End CallTo Action Area  -->
@endif
