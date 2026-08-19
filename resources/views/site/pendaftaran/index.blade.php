@extends('layouts.site')

@section('title', 'Pendaftaran Siswa Baru - Portal Resmi Sekolah')

@push('styles')
<style>
    /* ══ Kartu Form ══ */
    .ppdb-form-card {
        background: var(--color-white);
        border-radius: 16px;
        box-shadow: var(--shadow-1);
        border: 1px solid var(--color-border);
        border-top: 5px solid var(--color-primary);
        padding: 40px 35px;
    }
    .ppdb-form-header { text-align: center; margin-bottom: 30px; }
    .ppdb-form-header h3 { font-size: 26px; font-weight: 800; color: var(--color-heading); letter-spacing: 1px; }
    .ppdb-form-header p { color: var(--color-body); font-size: 14px; line-height: 1.7; }

    .ppdb-label {
        font-size: 12px; font-weight: 600; color: var(--color-heading);
        margin-bottom: 6px; display: flex; align-items: center; gap: 6px;
        text-transform: uppercase; letter-spacing: .4px;
    }
    .ppdb-label i { color: var(--color-primary); font-size: 14px; }
    .ppdb-label .req { color: #e41272; }

    .ppdb-input {
        width: 100%; border: 1.5px solid var(--color-border); border-radius: 8px;
        padding: 12px 15px; font-size: 14px; color: var(--color-heading);
        background: var(--color-light); transition: all .3s ease; outline: none;
    }
    .ppdb-input:focus {
        border-color: var(--color-primary); background: var(--color-white);
        box-shadow: 0 0 0 4px rgba(31, 95, 237, .08);
    }
    textarea.ppdb-input { min-height: 110px; resize: vertical; }

    .ppdb-submit {
        width: 100%; border: none; border-radius: 10px; padding: 16px;
        color: #fff; font-size: 15px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase;
        background: linear-gradient(90deg, #2b7cb3 0%, #6a5acd 100%);
        transition: all .3s ease;
        display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .ppdb-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(106, 90, 205, .35); }

    /* ══ Sidebar Info ══ */
    .ppdb-info-card {
        background: var(--color-white); border-radius: 14px;
        border: 1px solid var(--color-border); box-shadow: var(--shadow-1);
        padding: 28px; margin-bottom: 24px;
    }
    .ppdb-info-card h5 {
        font-size: 15px; font-weight: 700; color: var(--color-heading);
        text-transform: uppercase; letter-spacing: .5px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }
    .ppdb-info-card h5 i { color: var(--color-primary); }

    .ppdb-step { display: flex; gap: 14px; margin-bottom: 18px; }
    .ppdb-step:last-child { margin-bottom: 0; }
    .ppdb-step-num {
        width: 38px; height: 38px; flex-shrink: 0; border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6a5acd) 100%);
        color: #fff; font-weight: 700; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
    }
    .ppdb-step h6 { font-size: 14px; font-weight: 700; color: var(--color-heading); margin-bottom: 3px; }
    .ppdb-step p { font-size: 13px; color: var(--color-body); margin: 0; line-height: 1.6; }

    /* ══ Alert ══ */
    .ppdb-alert {
        border-radius: 12px; padding: 18px 22px; display: flex; gap: 14px;
        align-items: flex-start; margin-bottom: 30px; border: 1px solid;
    }
    .ppdb-alert i { font-size: 22px; flex-shrink: 0; margin-top: 2px; }
    .ppdb-alert.success { background: #e8f8ef; border-color: #b7e4c7; color: #155724; }
    .ppdb-alert.success i { color: #28a745; }
    .ppdb-alert.danger { background: #fdecee; border-color: #f5c6cb; color: #721c24; }
    .ppdb-alert.danger i { color: #dc3545; }
    .ppdb-alert strong { display: block; font-size: 15px; margin-bottom: 3px; }
    .ppdb-alert p, .ppdb-alert ul { margin: 0; font-size: 13.5px; line-height: 1.6; }

    @media (max-width: 767px) { .ppdb-form-card { padding: 28px 20px; } }
</style>
@endpush

@section('content')
<!-- Start Breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Pendaftaran Mahasiswa Baru</h2>
                    <p class="mb--20" style="color: var(--color-body); font-size: 16px;">
                        Silahkan isi form di bawah ini untuk mendaftar. Gunakan email dan nomor WhatsApp yang valid untuk mendapatkan pemberitahuan selanjutnya.
                    </p>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="rbt-breadcrumb-item active">Pendaftaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<div class="rbt-section-gap bg-color-extra2">
    <div class="container">

        {{-- Alert Sukses --}}
        @if(session('success'))
        <div class="ppdb-alert success">
            <i class="feather-check-circle"></i>
            <div>
                <strong>Pendaftaran Berhasil Terkirim!</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Alert Error Validasi --}}
        @if($errors->any())
        <div class="ppdb-alert danger">
            <i class="feather-alert-circle"></i>
            <div>
                <strong>Oops! Periksa kembali formulir Anda.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="row g-4">
            {{-- ══ Sidebar Kiri: Informasi ══ --}}
            <div class="col-lg-4">
                <div class="ppdb-info-card">
                    <h5><i class="feather-list"></i> Alur Pendaftaran</h5>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num">1</div>
                        <div><h6>Isi Formulir</h6><p>Lengkapi seluruh data diri dengan benar dan valid.</p></div>
                    </div>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num">2</div>
                        <div><h6>Verifikasi Data</h6><p>Tim admisi menghubungi Anda via WhatsApp untuk verifikasi.</p></div>
                    </div>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num">3</div>
                        <div><h6>Wawancara & Tes</h6><p>Ikuti wawancara dan tes singkat sesuai jadwal.</p></div>
                    </div>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num">4</div>
                        <div><h6>Daftar Ulang</h6><p>Calon Mahasiswa yang lolos melakukan daftar ulang.</p></div>
                    </div>
                </div>

                <div class="ppdb-info-card">
                    <h5><i class="feather-headphones"></i> Butuh Bantuan?</h5>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num"><i class="feather-phone" style="font-size:15px;"></i></div>
                        <div><h6>WhatsApp Admisi</h6><p>+62 821-2323-0470</p></div>
                    </div>
                    <div class="ppdb-step">
                        <div class="ppdb-step-num"><i class="feather-mail" style="font-size:15px;"></i></div>
                        <div><h6>Email</h6><p>sihi.online@gmail.com</p></div>
                    </div>
                </div>
            </div>

            {{-- ══ Form Pendaftaran ══ --}}
            <div class="col-lg-8">
                <div class="ppdb-form-card">
                    <div class="ppdb-form-header">
                        <h3>DAFTAR SEKARANG</h3>
                        <p>Silahkan isi form dibawah untuk mendaftar, gunakan email dan nomor WhatsApp yang valid untuk mendapatkan pemberitahuan selanjutnya.</p>
                    </div>

                    <form action="{{ route('site.pendaftaran.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-user"></i> Nama Lengkap <span class="req">*</span></label>
                                <input type="text" name="nama_lengkap" class="ppdb-input" placeholder="Nama lengkap Anda" value="{{ old('nama_lengkap') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-users"></i> Jenis Kelamin <span class="req">*</span></label>
                                <select name="jenis_kelamin" class="ppdb-input" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" @if(old('jenis_kelamin') == 'Laki-laki') selected @endif>Laki-laki</option>
                                    <option value="Perempuan" @if(old('jenis_kelamin') == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-calendar"></i> Tanggal Lahir <span class="req">*</span></label>
                                <input type="date" name="tgl_lahir" class="ppdb-input" value="{{ old('tgl_lahir') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-home"></i> Asal Sekolah <span class="req">*</span></label>
                                <input type="text" name="asal_sekolah" class="ppdb-input" placeholder="Contoh: SMAN 1 Subang" value="{{ old('asal_sekolah') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="ppdb-label"><i class="feather-map-pin"></i> Alamat Rumah <span class="req">*</span></label>
                                <textarea name="alamat_rumah" class="ppdb-input" placeholder="Tulis alamat lengkap Anda" required>{{ old('alamat_rumah') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-award"></i> Tahun Lulus Sekolah <span class="req">*</span></label>
                                <input type="number" name="tahun_lulus" class="ppdb-input" placeholder="Contoh: 2026" min="1990" max="2035" value="{{ old('tahun_lulus') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-book-open"></i> Jurusan Saat Sekolah</label>
                                <input type="text" name="jurusan_sekolah" class="ppdb-input" placeholder="Contoh: IPA / IPS (opsional)" value="{{ old('jurusan_sekolah') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-smartphone"></i> No WhatsApp <span class="req">*</span></label>
                                <input type="tel" name="no_whatsapp" class="ppdb-input" placeholder="Contoh: 6281234567890" value="{{ old('no_whatsapp') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-phone"></i> No Orang Tua / Wali</label>
                                <input type="tel" name="no_ortu" class="ppdb-input" placeholder="Contoh: 6281234567890 (opsional)" value="{{ old('no_ortu') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-mail"></i> Email <span class="req">*</span></label>
                                <input type="email" name="email" class="ppdb-input" placeholder="Contoh: nama@gmail.com" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ppdb-label"><i class="feather-briefcase"></i> Pilih Program <span class="req">*</span></label>
                                <select name="program" class="ppdb-input" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs as $prog)
                                    <option value="{{ $prog->nama }}" @if(old('program') == $prog->nama) selected @endif>{{ $prog->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="ppdb-submit mt-4">
                            <i class="feather-send"></i> Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection