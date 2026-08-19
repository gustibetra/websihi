<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login E-Learning — SIHI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1F57ED; --secondary:#7A5CF0; --dark:#13294B; --gold:#FFD166; }
        * { font-family:'Plus Jakarta Sans',sans-serif; }
        body { background:#f4f6fb; }

        .login-split { display:flex; min-height:100vh; }

        /* ═══ PANEL KIRI (Branding) ═══ */
        .login-left {
            display:none; position:relative; overflow:hidden; flex:1.1;
            background: linear-gradient(150deg, var(--dark) 0%, var(--primary) 55%, var(--secondary) 100%);
            color:#fff; padding:48px; flex-direction:column; justify-content:space-between;
        }
        @media (min-width: 992px) { .login-left { display:flex; } }
        .login-left .circle {
            position:absolute; border-radius:50%; pointer-events:none;
            animation: float 7s ease-in-out infinite;
        }
        .circle-1 { width:420px; height:420px; background:rgba(255,255,255,.06); top:-150px; right:-150px; }
        .circle-2 { width:280px; height:280px; background:rgba(255,209,102,.12); bottom:-90px; left:-70px; animation-delay:1.5s !important; }
        .circle-3 { width:120px; height:120px; background:rgba(6,214,160,.15); top:38%; left:12%; animation-delay:3s !important; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }

        .brand-row { display:flex; align-items:center; gap:12px; position:relative; z-index:2; }
        .brand-logo {
            width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,.14);
            border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(8px);
            display:flex; align-items:center; justify-content:center; font-size:24px; color:var(--gold);
        }
        .left-headline { font-size: clamp(28px, 3vw, 42px); font-weight:800; line-height:1.2; letter-spacing:-.5px; }
        .left-headline em { font-style:normal; color:var(--gold); }

        .feature-card {
            background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
            backdrop-filter:blur(8px); border-radius:14px; padding:14px 16px;
            display:flex; gap:12px; align-items:center; transition:.3s;
        }
        .feature-card:hover { background:rgba(255,255,255,.18); transform:translateX(6px); }
        .feature-card .ic {
            width:42px; height:42px; border-radius:10px; background:rgba(255,255,255,.15);
            display:flex; align-items:center; justify-content:center; font-size:19px; color:var(--gold); flex-shrink:0;
        }
        .feature-card b { font-size:14px; display:block; }
        .feature-card small { opacity:.75; font-size:12px; }

        /* ═══ PANEL KANAN (Form) ═══ */
        .login-right { flex:1; display:flex; align-items:center; justify-content:center; padding:40px 20px; }
        .login-box { width:100%; max-width:460px; }

        .mobile-logo {
            width:64px; height:64px; border-radius:18px; margin:0 auto 14px;
            background:linear-gradient(135deg, var(--primary), var(--secondary));
            display:flex; align-items:center; justify-content:center;
            font-size:30px; color:#fff; box-shadow:0 12px 30px rgba(31,87,237,.35);
        }

        .form-label { font-size:13px; font-weight:600; color:#374151; display:flex; align-items:center; gap:6px; }
        .form-label i { color:var(--secondary); }
        .input-group-text { background:#F9FAFB; border:1.5px solid #E5E7EB; border-right:none; color:var(--secondary); }
        .form-control { border:1.5px solid #E5E7EB; font-size:14px; padding:12px 14px; }
        .form-control:focus { border-color:var(--secondary); box-shadow:0 0 0 4px rgba(122,92,240,.12); }
        .input-group .form-control { border-left:none; }
        .btn-eye { border:1.5px solid #E5E7EB; border-left:none; background:#fff; color:#6B7280; }

        .btn-login {
            width:100%; border:none; border-radius:12px; padding:14px;
            background:linear-gradient(135deg, var(--primary), var(--secondary));
            color:#fff; font-weight:700; font-size:15px; letter-spacing:.3px;
            display:flex; align-items:center; justify-content:center; gap:8px;
            transition:.3s; box-shadow:0 10px 24px rgba(31,87,237,.3);
        }
        .btn-login:hover { transform:translateY(-2px); box-shadow:0 14px 30px rgba(122,92,240,.4); color:#fff; }

        .alert { border:none; border-radius:12px; font-size:13px; padding:12px 16px; display:flex; gap:10px; align-items:flex-start; }
        .alert i { font-size:18px; margin-top:1px; flex-shrink:0; }
        .alert-danger { background:#FEE2E2; color:#991B1B; }
        .alert-success { background:#D1FAE5; color:#065F46; }

        .hint-box {
            background:#EEF2FF; border:1px dashed #C7D2FE; border-radius:12px;
            padding:10px 14px; font-size:12px; color:#4338CA;
            display:flex; gap:8px; align-items:center;
        }

        /* Animasi masuk */
        @keyframes fadeUp { from{opacity:0; transform:translateY(20px)} to{opacity:1; transform:none} }
        .anim { animation:fadeUp .6s ease both; }
        .d1{animation-delay:.05s} .d2{animation-delay:.15s} .d3{animation-delay:.25s} .d4{animation-delay:.35s} .d5{animation-delay:.45s}
    </style>
</head>
<body>

<div class="login-split">

    {{-- ═══════════ PANEL KIRI : BRANDING ═══════════ --}}
    <div class="login-left">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>

        <div class="brand-row anim d1">
            <div class="brand-logo"><i class="ri-graduation-cap-fill"></i></div>
            <div>
                <div class="fw-bold" style="font-size:15px;">E-Learning SIHI</div>
                <small style="opacity:.7;">Subang International Hotel Institute</small>
            </div>
        </div>

        <div class="position-relative" style="z-index:2;">
            <h1 class="left-headline anim d2">
                Belajar Lebih Mudah,<br>
                Karir Lebih <em>Cerah.</em>
            </h1>
            <p class="anim d3" style="opacity:.85; max-width:440px; line-height:1.7;">
                Satu portal untuk seluruh kebutuhan pembelajaran Anda — absen, materi, ujian, hingga informasi pembayaran.
            </p>

            <div class="d-flex flex-column gap-3 mt-4" style="max-width:420px;">
                <div class="feature-card anim d3">
                    <div class="ic"><i class="ri-fingerprint-2-line"></i></div>
                    <div><b>Absen Online</b><small>Check-in & check-out kehadiran digital</small></div>
                </div>
                <div class="feature-card anim d4">
                    <div class="ic"><i class="ri-book-open-line"></i></div>
                    <div><b>Materi & Ujian</b><small>Unduh materi dan kerjakan ujian kapan saja</small></div>
                </div>
                <div class="feature-card anim d5">
                    <div class="ic"><i class="ri-wallet-3-line"></i></div>
                    <div><b>Info Pembayaran</b><small>Pantau status lunas & tunggakan secara real-time</small></div>
                </div>
            </div>
        </div>

        <small class="anim d5" style="opacity:.6; position:relative; z-index:2;">
            © {{ date('Y') }} Subang International Hotel Institute. Hak Cipta Dilindungi.
        </small>
    </div>

    {{-- ═══════════ PANEL KANAN : FORM LOGIN ═══════════ --}}
    <div class="login-right">
        <div class="login-box">

            {{-- Logo mobile --}}
            <div class="text-center d-lg-none anim d1">
                <div class="mobile-logo"><i class="ri-graduation-cap-fill"></i></div>
                <h5 class="fw-bold mb-1">E-Learning SIHI</h5>
                <p class="text-muted small mb-4">Subang International Hotel Institute</p>
            </div>

            <div class="text-center anim d2 d-none d-lg-block">
                <h4 class="fw-bold mb-1" style="color:#1F2937;">Selamat Datang Kembali! 👋</h4>
                <p class="text-muted small mb-4">Silakan masuk untuk melanjutkan pembelajaran</p>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success anim d3 mb-3"><i class="ri-checkbox-circle-fill"></i><div>{{ session('success') }}</div></div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger anim d3 mb-3"><i class="ri-error-warning-fill"></i><div>{{ $errors->first() }}</div></div>
            @endif

            <form method="POST" action="{{ route('elearning.login') }}" class="anim d3">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><i class="ri-id-card-line"></i> NIP / NIM</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-user-voice-line"></i></span>
                        <input type="text" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror"
                               placeholder="Masukkan NIP (staff) / NIM (mahasiswa)"
                               value="{{ old('nomor_induk') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="ri-lock-2-line"></i> Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-key-2-line"></i></span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password Anda" required>
                        <button type="button" class="btn-eye" onclick="togglePassword()" title="Lihat password">
                            <i class="ri-eye-line" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                    </div>
                    <span class="small text-muted">Lupa password? Hubungi admin</span>
                </div>

                <button type="submit" class="btn-login anim d4">
                    <i class="ri-login-box-line"></i> Masuk ke Portal
                </button>
            </form>

            <div class="hint-box mt-4 anim d5">
                <i class="ri-information-line" style="font-size:16px;"></i>
                <span><b>Staff</b> login menggunakan <b>NIP</b> • <b>Mahasiswa</b> login menggunakan <b>NIM</b>. Akun dibuat oleh admin.</span>
            </div>

            <div class="text-center mt-4 anim d5">
                <a href="{{ route('home') }}" class="text-decoration-none small fw-semibold" style="color:var(--secondary);">
                    <i class="ri-arrow-left-line me-1"></i> Kembali ke Website Utama
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') { input.type = 'text'; icon.className = 'ri-eye-off-line'; }
        else { input.type = 'password'; icon.className = 'ri-eye-line'; }
    }
</script>
</body>
</html>