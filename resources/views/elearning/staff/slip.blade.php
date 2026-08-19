<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Slip {{ $payment->slip_number }}</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
<style>
    :root{
        --navy:#13294B; --blue:#1F57ED; --purple:#7A5CF0;
        --gold:#F59E0B; --gold2:#FFD166;
    }
    *{ box-sizing:border-box; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    body{ background:#eef1f7; font-family:'Segoe UI', Arial, Helvetica, sans-serif; padding:28px; margin:0; }

    .tools{ max-width:900px; margin:0 auto 16px; display:flex; justify-content:flex-end; gap:8px; }
    .btn{ padding:10px 20px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .btn-print{ background:linear-gradient(90deg,var(--blue),var(--purple)); color:#fff; box-shadow:0 6px 18px rgba(31,87,237,.35); }
    .btn-back{ background:#fff; color:#334155; box-shadow:0 2px 10px rgba(0,0,0,.08); }

    .slip{ max-width:900px; margin:auto; background:#fff; border-radius:18px; overflow:hidden;
           box-shadow:0 20px 60px rgba(19,41,75,.18); position:relative; }
    .slip::before{ content:''; display:block; height:8px;
           background:linear-gradient(90deg,var(--gold),var(--gold2),var(--blue),var(--purple)); }

    .slip-top{ display:flex; justify-content:space-between; align-items:center; gap:16px;
               padding:26px 34px 20px; color:#fff; position:relative; overflow:hidden;
               background:linear-gradient(135deg,var(--navy),var(--blue) 65%,var(--purple)); }
    .slip-top::after{ content:''; position:absolute; right:-70px; top:-70px; width:230px; height:230px;
               border-radius:50%; background:rgba(255,255,255,.08); }
    .slip-top::before{ content:''; position:absolute; left:-40px; bottom:-90px; width:170px; height:170px;
               border-radius:50%; background:rgba(255,209,102,.15); }
    .brand{ display:flex; gap:14px; align-items:center; position:relative; z-index:2; }
    .logo-box{ width:58px; height:58px; background:#fff; border-radius:14px; display:flex;
               align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;
               box-shadow:0 4px 14px rgba(0,0,0,.25); }
    .logo-box img{ width:100%; height:100%; object-fit:contain; }
    .logo-fallback{ font-weight:900; color:var(--navy); font-size:18px; letter-spacing:1px; }
    .inst{ font-weight:800; letter-spacing:.5px; font-size:15px; line-height:1.3; }
    .inst small{ display:block; font-weight:600; opacity:.75; font-size:9px; letter-spacing:2px; text-transform:uppercase; }
    .doc-title{ text-align:right; position:relative; z-index:2; }
    .t1{ font-size:22px; font-weight:800; letter-spacing:3px; }
    .t2{ font-size:11px; letter-spacing:1px; opacity:.9; background:rgba(255,255,255,.14);
         display:inline-block; padding:5px 14px; border-radius:50px; margin-top:7px;
         border:1px solid rgba(255,255,255,.3); }

    .meta-row{ display:flex; gap:10px; padding:18px 34px 0; flex-wrap:wrap; align-items:center; }
    .chip{ font-size:11px; font-weight:700; border-radius:8px; padding:7px 14px; letter-spacing:.5px; }
    .chip.no{ background:#EEF2FF; color:var(--blue); border:1.5px dashed var(--blue); }
    .chip.lunas{ background:#ECFDF5; color:#059669; border:1.5px solid #059669; }
    .chip.tunggakan{ background:#FEF2F2; color:#DC2626; border:1.5px solid #DC2626; }
    .chip.date{ background:#F8FAFC; color:#475569; border:1px solid #E2E8F0; margin-left:auto; }
    .chip.source{ background:#FEF3C7; color:#92400E; border:1.5px solid #F59E0B; } /* ✅ BARU: badge sumber */

    .watermark{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
                font-size:280px; color:rgba(31,87,237,.05); pointer-events:none; }

    .body{ padding:22px 34px 32px; position:relative; }

    .info{ display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px; }
    .info .item{ background:#F8FAFF; border:1px solid #EEF2FF; border-radius:12px; padding:10px 14px;
                 display:flex; gap:12px; align-items:center; }
    .info .ic{ width:38px; height:38px; border-radius:10px; color:#fff; display:flex; align-items:center;
               justify-content:center; font-size:17px; flex-shrink:0;
               background:linear-gradient(135deg,var(--blue),var(--purple)); }
    .info .ic.gold{ background:linear-gradient(135deg,var(--gold),var(--gold2)); }
    .info .lb{ font-size:9px; letter-spacing:1.5px; color:#64748B; text-transform:uppercase; font-weight:700; }
    .info .vl{ font-size:13px; font-weight:700; color:var(--navy); }

    table.rincian{ width:100%; border-collapse:separate; border-spacing:0; border-radius:12px;
                   overflow:hidden; box-shadow:0 0 0 1px #E2E8F0; }
    .rincian th{ background:linear-gradient(90deg,var(--navy),var(--blue)); color:#fff; font-size:10px;
                 letter-spacing:1.5px; text-transform:uppercase; padding:11px 16px; text-align:left; }
    .rincian td{ padding:11px 16px; font-size:13px; color:#334155; border-top:1px solid #EEF2FF; }
    .rincian tbody tr:nth-child(even) td{ background:#F8FAFF; }
    .rincian .amt{ text-align:right; font-weight:600; font-variant-numeric:tabular-nums; }
    tr.total td{ background:linear-gradient(90deg,#EEF2FF,#F5F3FF) !important; font-weight:800;
                 color:var(--navy); font-size:14px; border-top:2px solid var(--blue); }

    .terbilang{ margin-top:16px; background:linear-gradient(90deg,var(--gold),var(--gold2));
                border-radius:12px; padding:11px 18px; text-align:center; font-weight:800;
                color:#78350F; letter-spacing:1.5px; font-size:13px;
                box-shadow:0 6px 18px rgba(245,158,11,.35); }

    .footer-row{ display:flex; justify-content:space-between; gap:26px; margin-top:28px; }
    .note{ flex:1; font-size:10px; color:#64748B; line-height:1.6; }
    .note b{ color:#334155; letter-spacing:.5px; }
    .note ol{ margin:5px 0 0 16px; padding:0; }
    .sign{ width:250px; text-align:center; font-size:12px; color:#334155; }
    .sign .box{ border:1.5px dashed #CBD5E1; border-radius:12px; height:105px; margin:8px 0;
                display:flex; align-items:center; justify-content:center;
                color:#94A3B8; font-size:9px; letter-spacing:2px; }
    .sign .name{ font-weight:800; text-decoration:underline; color:var(--navy); }

    .barcode-wrap{ margin-top:24px; text-align:center; }
    .barcode{ height:44px; max-width:320px; margin:auto;
              background:repeating-linear-gradient(90deg,
                var(--navy) 0 2px, transparent 2px 4px,
                var(--navy) 4px 7px, transparent 7px 9px,
                var(--navy) 9px 10px, transparent 10px 14px,
                var(--navy) 14px 16px, transparent 16px 19px); }
    .bc-num{ font-size:10px; letter-spacing:4px; color:#64748B; margin-top:5px; font-weight:700; }

    .elec{ text-align:center; font-size:9px; color:#94A3B8; margin-top:14px; letter-spacing:.5px; }

    @media print{
        body{ background:#fff; padding:0; }
        .tools{ display:none !important; }
        .slip{ box-shadow:none; border-radius:0; max-width:100%; }
    }
    @media (max-width:640px){
        .info{ grid-template-columns:1fr; }
        .footer-row{ flex-direction:column; }
        .sign{ width:100%; }
        .slip-top{ flex-direction:column; text-align:center; }
        .doc-title{ text-align:center; }
        .chip.date{ margin-left:0; }
    }
</style>
</head>
<body>

<div class="tools">
    <a class="btn btn-back" href="{{ route('elearning.staff.pembayaran') }}"><i class="ri-arrow-left-line"></i> Kembali</a>
    <button class="btn btn-print" onclick="window.print()"><i class="ri-printer-line"></i> Cetak / Simpan PDF</button>
</div>

@php
    $setting = \App\Models\Setting::first();
    $logo = ($setting && $setting->logo) ? asset('storage/' . $setting->logo) : null;
    $items = is_array($payment->details) ? $payment->details : [];
    $statusLow = strtolower($payment->status);
    $isManual  = $payment->isManualPayment(); // ✅ Cek alumni/eksternal

    if (!function_exists('terbilang')) {
        function terbilang($n) {
            $h = ['','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas'];
            $n = (int) $n;
            if ($n < 12) return $h[$n];
            if ($n < 20) return terbilang($n - 10) . ' belas';
            if ($n < 100) return terbilang(intdiv($n, 10)) . ' puluh ' . terbilang($n % 10);
            if ($n < 200) return 'seratus ' . terbilang($n - 100);
            if ($n < 1000) return terbilang(intdiv($n, 100)) . ' ratus ' . terbilang($n % 100);
            if ($n < 2000) return 'seribu ' . terbilang($n - 1000);
            if ($n < 1000000) return terbilang(intdiv($n, 1000)) . ' ribu ' . terbilang($n % 1000);
            if ($n < 1000000000) return terbilang(intdiv($n, 1000000)) . ' juta ' . terbilang($n % 1000000);
            return terbilang(intdiv($n, 1000000000)) . ' miliar ' . terbilang($n % 1000000000);
        }
    }
@endphp

<div class="slip">

    <div class="slip-top">
        <div class="brand">
            <div class="logo-box">
                @if($logo)
                    <img src="{{ $logo }}" alt="Logo">
                @else
                    <span class="logo-fallback">SIHI</span>
                @endif
            </div>
            <div class="inst">
                {{ strtoupper($setting->site_name ?? 'SUBANG INTERNATIONAL HOTEL INSTITUTE') }}
                <small>Slip Pembayaran Resmi</small>
            </div>
        </div>
        <div class="doc-title">
            <div class="t1">SLIP PEMBAYARAN</div>
            <div class="t2"><i class="ri-bill-line"></i> {{ strtoupper($payment->title) }}</div>
        </div>
    </div>

    {{-- ═══ CHIP META ═══ --}}
    <div class="meta-row">
        <span class="chip no"><i class="ri-hashtag"></i> {{ $payment->slip_number ?? 'TANPA NOMOR' }}</span>
        <span class="chip {{ $statusLow }}">
            <i class="ri-{{ $statusLow === 'lunas' ? 'checkbox-circle-fill' : 'error-warning-fill' }}"></i>
            {{ strtoupper($payment->status) }}
        </span>
        {{-- ✅ BARU: Badge sumber (Mahasiswa / Alumni) --}}
        @if($isManual)
            <span class="chip source"><i class="ri-user-star-line"></i> ALUMNI / EKSTERNAL</span>
        @else
            <span class="chip source"><i class="ri-user-3-line"></i> MAHASISWA</span>
        @endif
        <span class="chip date"><i class="ri-calendar-line"></i> {{ now()->translatedFormat('d F Y') }}</span>
    </div>

    <div class="watermark"><i class="ri-graduation-cap-line"></i></div>

    <div class="body">

        {{-- ═══ INFO PEMBAYAR (AMAN: fallback ke manual_name/manual_nim) ═══ --}}
        <div class="info">
            <div class="item">
                <div class="ic"><i class="ri-{{ $isManual ? 'user-star-line' : 'user-3-line' }}"></i></div>
                <div>
                    <div class="lb">{{ $isManual ? 'Nama Pembayar (Alumni)' : 'Nama Mahasiswa' }}</div>
                    <div class="vl">{{ strtoupper($payment->display_name) }}</div>
                </div>
            </div>
            <div class="item">
                <div class="ic"><i class="ri-id-card-line"></i></div>
                <div>
                    <div class="lb">{{ $isManual ? 'NIM / No. Identitas' : 'NIM' }}</div>
                    <div class="vl">{{ $payment->display_nim }}</div>
                </div>
            </div>
            <div class="item">
                <div class="ic gold"><i class="ri-graduation-cap-line"></i></div>
                <div>
                    <div class="lb">Program Diploma</div>
                    <div class="vl">{{ strtoupper($payment->program_display) }}</div>
                </div>
            </div>
            <div class="item">
                <div class="ic gold"><i class="ri-bank-line"></i></div>
                <div>
                    <div class="lb">Bank / Tempat Pembayaran</div>
                    <div class="vl">{{ strtoupper($payment->payment_channel ?? 'KANTOR SIHI') }}</div>
                </div>
            </div>
        </div>

        {{-- ═══ TABEL RINCIAN ═══ --}}
        <table class="rincian">
            <thead>
                <tr><th style="width:60%;">Uraian Pembayaran</th><th class="amt">Nominal</th></tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    <tr>
                        <td>{{ strtoupper($it['title'] ?? 'PEMBAYARAN') }}</td>
                        <td class="amt">Rp {{ number_format($it['amount'] ?? 0, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ strtoupper($payment->title) }}</td>
                        <td class="amt">Rp {{ number_format($payment->amount, 2, ',', '.') }}</td>
                    </tr>
                @endforelse
                <tr class="total">
                    <td><i class="ri-calculator-line"></i> JUMLAH PEMBAYARAN</td>
                    <td class="amt">Rp {{ number_format($payment->amount, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ═══ TERBILANG ═══ --}}
        <div class="terbilang">
            <i class="ri-vip-diamond-fill"></i> TERBILANG: {{ strtoupper(trim(terbilang($payment->amount))) }} RUPIAH
        </div>

        {{-- ═══ CATATAN + TANDA TANGAN ═══ --}}
        <div class="footer-row">
            <div class="note">
                <b>PERHATIAN:</b>
                <ol>
                    <li>Cetak dan bawalah slip ini saat melakukan pembayaran via teller bank atau ATM, paling lambat tanggal jatuh tempo.</li>
                    <li>Resi / bukti pembayaran harap disimpan sebagai bukti pembayaran yang sah.</li>
                    <li>Slip yang dicetak ulang tanpa stempel & tanda tangan petugas dianggap tidak berlaku.</li>
                </ol>
            </div>
            <div class="sign">
                Subang, {{ now()->translatedFormat('d F Y') }}<br>
                Petugas Keuangan,
                <div class="box">STEMPEL</div>
                <span class="name">{{ auth('elearning')->user()->name }}</span>
            </div>
        </div>

        {{-- ═══ BARCODE ═══ --}}
        <div class="barcode-wrap">
            <div class="barcode"></div>
            <div class="bc-num">{{ $payment->slip_number ?? 'SIHI' }}</div>
        </div>

        <div class="elec">Dokumen ini dibuat secara elektronik oleh Sistem E-Learning SIHI • {{ now()->format('d/m/Y H:i') }}</div>
    </div>
</div>

</body>
</html>