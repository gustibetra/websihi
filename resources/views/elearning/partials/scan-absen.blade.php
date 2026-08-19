{{-- ═══ ZONA ABSEN SCAN KARTU ═══ --}}
<div class="el-card card p-4 mb-0 text-center" style="border:2px dashed #1F57ED;background:linear-gradient(135deg,#F8FAFF,#F5F3FF);border-radius:20px;">
    <i class="ri-qr-scan-line" style="font-size:48px;color:#1F57ED;"></i>
    <h5 class="fw-bold mt-2 mb-1">Absen Scan Kartu</h5>
    <p class="small text-muted mb-3">Arahkan barcode KTM / ID Card SIHI ke dalam bingkai kamera.</p>

    <div style="max-width:420px;margin:0 auto;">
        <div id="qr-reader" style="width:100%;border-radius:16px;overflow:hidden;background:#0F172A;min-height:180px;"></div>
        <div id="scanHint" class="small text-muted mt-2"></div>
    </div>

    <div id="scanResult" class="mx-auto mt-3 text-start" style="max-width:480px;display:none;"></div>
</div>

<style>
    @keyframes spinAbsen{to{transform:rotate(360deg)}}
    #qr-reader video{border-radius:16px;}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function(){
    const url    = @json($scanRoute);
    const hintEl = document.getElementById('scanHint');

    let scanner = null, scanning = false, starting = false, cooldown = false;

    const BTN = '<button type="button" class="btn btn-primary fw-bold px-4 py-2" onclick="window.__startCam()">' +
                '<i class="ri-camera-lens-line me-1"></i> Aktifkan Kamera & Scan</button>';

    document.addEventListener('DOMContentLoaded', () => {
        try {
            navigator.permissions.query({ name: 'camera' }).then(st => {
                const update = () => {
                    if (st.state === 'granted' && !scanning) startCamera();
                    else if (!scanning) hintEl.innerHTML = BTN;
                };
                update();
                if (st.addEventListener) st.addEventListener('change', update);
                st.onchange = update;
            }).catch(() => { hintEl.innerHTML = BTN; });
        } catch (e) { hintEl.innerHTML = BTN; }
    });

    window.addEventListener('focus', () => {
        if (scanning || starting) return;
        try {
            navigator.permissions.query({ name: 'camera' }).then(st => {
                if (st.state === 'granted') startCamera();
            }).catch(() => {});
        } catch (e) {}
    });

    window.__startCam = startCamera;

    function hint(h){ hintEl.innerHTML = h; }

    async function startCamera(){
        if (scanning || starting) return;
        starting = true;
        hint('<i class="ri-loader-4-line me-1" style="animation:spinAbsen 1s linear infinite;display:inline-block;"></i> Menyalakan kamera...');

        if (!window.isSecureContext || typeof Html5Qrcode === 'undefined') {
            starting = false;
            hint(BTN);
            return fail('Kamera tidak tersedia di perangkat ini.');
        }

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            stream.getTracks().forEach(t => t.stop());
        } catch (e) {
            starting = false;
            hint('<button type="button" class="btn btn-danger fw-bold px-4 py-2" onclick="window.__startCam()">' +
                 '<i class="ri-refresh-line me-1"></i> Coba Lagi</button>');
            return fail('Kamera tidak diizinkan di perangkat ini.');
        }

        if (!scanner) {
            scanner = new Html5Qrcode("qr-reader", {
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.QR_CODE
                ]
            });
        }

        const cfg = { fps: 10, qrbox: { width: 260, height: 160 } };
        const strategies = [ { facingMode: "environment" }, { facingMode: "user" }, true ];

        for (const s of strategies) {
            try { await scanner.start(s, cfg, onScan, () => {}); return okStart(); } catch (e) {}
        }

        try {
            const cams = (await navigator.mediaDevices.enumerateDevices()).filter(d => d.kind === 'videoinput');
            for (const c of cams) {
                try { await scanner.start({ deviceId: { exact: c.deviceId } }, cfg, onScan, () => {}); return okStart(); } catch (e) {}
            }
        } catch (e) {}

        starting = false;
        hint(BTN);
        fail('Kamera tidak dapat dinyalakan.');
    }

    function okStart(){
        scanning = true; starting = false;
        hint('<span class="text-success fw-bold"><i class="ri-camera-lens-line me-1"></i>Kamera aktif</span>');
    }

    function fail(msg){
        showResult(false, msg);
    }

    function onScan(text){
        if (cooldown) return;
        cooldown = true; setTimeout(() => cooldown = false, 4000);
        submitScan(text);
    }

    function submitScan(code){
        code = (code || '').trim();
        if (!code) return;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code: code })
        })
        .then(r => r.json())
        .then(d => { showResult(!!d.ok, d.msg || 'Terjadi kesalahan.'); beep(!!d.ok); })
        .catch(() => showResult(false, 'Gagal terhubung ke server.'));
    }

    function showResult(ok, msg){
        const box = document.getElementById('scanResult');
        box.style.display = 'block';
        box.className = 'mx-auto mt-3 text-start alert ' + (ok ? 'alert-success' : 'alert-danger');
        box.style.maxWidth = '480px';
        box.innerHTML = '<i class="' + (ok ? 'ri-checkbox-circle-fill' : 'ri-error-warning-fill') + ' me-1"></i> ' + msg;
    }

    function beep(ok){
        try{
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const o = ctx.createOscillator(), g = ctx.createGain();
            o.connect(g); g.connect(ctx.destination);
            o.frequency.value = ok ? 880 : 220;
            g.gain.value = .15;
            o.start(); o.stop(ctx.currentTime + (ok ? .18 : .35));
        }catch(e){}
    }
})();
</script>
@endpush