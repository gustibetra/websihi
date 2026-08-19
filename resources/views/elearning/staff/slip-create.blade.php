@extends('layouts.elearning')
@section('title', 'Buat Slip Pembayaran')
@section('content')

@if($errors->any())
    <div class="alert alert-danger py-2 small">
        <i class="ri-error-warning-line me-1"></i>{{ $errors->first() }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-printer-line text-primary"></i> Buat Slip Pembayaran</h4>
        <p class="text-muted small mb-0">Isi data pembayar (mahasiswa aktif / alumni / eksternal) → slip siap cetak</p>
    </div>
    <a href="{{ route('elearning.staff.pembayaran') }}" class="btn btn-sm btn-light">← Kembali</a>
</div>

<div class="el-card card p-4" style="max-width:860px;">
    <form method="POST" action="{{ route('elearning.staff.pembayaran.slip.store') }}">
        @csrf

        {{-- ═══ INFO PEMBAYAR ═══ --}}
        <div class="p-3 rounded-3 mb-3" style="background:#F0F9FF;border:1px solid #BAE6FD;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="ri-user-settings-line text-info"></i>
                <strong class="small text-info">DATA PEMBAYAR</strong>
            </div>
            <small class="text-muted">Ketik nama bebas (mahasiswa aktif, alumni, atau pembayar eksternal). Jika cocok dengan mahasiswa terdaftar, sistem otomatis menautkan akunnya.</small>
        </div>

        <div class="row g-3">
            {{-- ✅ INPUT MANUAL: Nama Lengkap --}}
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nama Lengkap Pembayar <span class="text-danger">*</span></label>
                <input type="text" id="namaInput" name="manual_name" list="listMahasiswa"
                       class="form-control form-control-sm"
                       placeholder="Ketik nama (mahasiswa / alumni / eksternal)..."
                       value="{{ old('manual_name') }}" required autocomplete="off">
                <datalist id="listMahasiswa">
                    @foreach($students as $s)
                        <option value="{{ $s->name }}" data-nim="{{ $s->nomor_induk }}" data-program="{{ $s->program }}"></option>
                    @endforeach
                </datalist>
                <small class="text-muted"><i class="ri-quill-pen-line me-1"></i>Input manual — bisa nama alumni/eksternal yang tidak terdaftar.</small>
            </div>

            {{-- ✅ INPUT MANUAL: NIM --}}
            <div class="col-md-6">
                <label class="form-label small fw-bold">NIM (opsional)</label>
                <input type="text" id="nimInput" name="manual_nim"
                       class="form-control form-control-sm"
                       placeholder="Contoh: 2306700080"
                       value="{{ old('manual_nim') }}">
                <small class="text-muted">Diisi otomatis jika nama cocok dengan mahasiswa terdaftar.</small>
            </div>

            {{-- Program Diploma --}}
            <div class="col-md-6">
                <label class="form-label small fw-bold">Program Diploma</label>
                <input type="text" name="program" id="programInput"
                       class="form-control form-control-sm"
                       placeholder="Contoh: Perhotelan"
                       value="{{ old('program') }}">
            </div>

            {{-- Judul Tagihan --}}
            <div class="col-md-6">
                <label class="form-label small fw-bold">Judul Tagihan <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-sm"
                       placeholder="Contoh: Uang Kuliah Tunggal (UKT) Semester 1"
                       value="{{ old('title') }}" required>
            </div>

            {{-- Tempat / Bank Pembayaran --}}
            <div class="col-md-6">
                <label class="form-label small fw-bold">Tempat / Bank Pembayaran</label>
                <input type="text" name="payment_channel" class="form-control form-control-sm"
                       placeholder="Contoh: BANK BNI / Kantor SIHI"
                       value="{{ old('payment_channel') }}">
            </div>

            {{-- Jatuh Tempo --}}
            <div class="col-md-3">
                <label class="form-label small fw-bold">Jatuh Tempo</label>
                <input type="date" name="due_date" class="form-control form-control-sm"
                       value="{{ old('due_date') }}">
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label class="form-label small fw-bold">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="Lunas" {{ old('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Tunggakan" {{ old('status') === 'Tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                </select>
            </div>

            {{-- ═══ RINCIAN BIAYA DINAMIS ═══ --}}
            <div class="col-12 mt-3">
                <label class="form-label small fw-bold">Rincian Biaya</label>
                <div id="items">
                    <div class="row g-2 mb-2 item-row">
                        <div class="col-md-6"><input type="text" name="item_title[]" class="form-control form-control-sm" placeholder="Uraian (cth: SPP Semester 1)"></div>
                        <div class="col-md-4"><input type="number" name="item_amount[]" class="form-control form-control-sm item-amount" placeholder="Nominal (Rp)" oninput="recalcTotal()"></div>
                        <div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.item-row').remove(); recalcTotal();"><i class="ri-delete-bin-line"></i></button></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light" onclick="addItemRow()">
                    <i class="ri-add-line me-1"></i> Tambah Rincian
                </button>
                <div class="mt-3 p-2 rounded-3 d-flex justify-content-between align-items-center" style="background:#EEF2FF;">
                    <strong class="small">TOTAL:</strong>
                    <strong id="totalPreview" class="text-primary">Rp 0</strong>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="col-12">
                <button type="submit" class="btn btn-primary fw-bold px-4">
                    <i class="ri-printer-line me-1"></i> Simpan & Buat Slip
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Data mahasiswa untuk auto-fill (jika nama cocok)
    const students = @json($students->map(fn($s) => [
        'name' => $s->name,
        'nim' => $s->nomor_induk ?? '',
        'program' => $s->program ?? ''
    ]));

    function addItemRow() {
        const wrap = document.getElementById('items');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 item-row';
        row.innerHTML = `
            <div class="col-md-6"><input type="text" name="item_title[]" class="form-control form-control-sm" placeholder="Uraian biaya"></div>
            <div class="col-md-4"><input type="number" name="item_amount[]" class="form-control form-control-sm item-amount" placeholder="Nominal (Rp)" oninput="recalcTotal()"></div>
            <div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.item-row').remove(); recalcTotal();"><i class="ri-delete-bin-line"></i></button></div>`;
        wrap.appendChild(row);
    }

    function recalcTotal() {
        let t = 0;
        document.querySelectorAll('.item-amount').forEach(i => t += parseFloat(i.value || 0));
        document.getElementById('totalPreview').textContent = 'Rp ' + t.toLocaleString('id-ID');
    }

    // ✅ Auto-fill NIM & Program jika nama cocok dengan mahasiswa terdaftar
    document.getElementById('namaInput').addEventListener('change', function () {
        const nama = this.value.trim().toLowerCase();
        if (!nama) return;

        const found = students.find(s => (s.name || '').toLowerCase() === nama);
        if (found) {
            const nim   = document.getElementById('nimInput');
            const prog  = document.getElementById('programInput');

            // Hanya auto-fill jika field masih kosong (jangan timpa input manual user)
            if (!nim.value  && found.nim)     nim.value  = found.nim;
            if (!prog.value && found.program) prog.value = found.program;

            // Feedback visual: tampilkan info singkat
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('auto-match')) {
                const badge = document.createElement('small');
                badge.className = 'auto-match text-success d-block mt-1';
                badge.innerHTML = '<i class="ri-checkbox-circle-line me-1"></i>Cocok dengan mahasiswa terdaftar — akan ditautkan otomatis.';
                this.insertAdjacentElement('afterend', badge);
            }
        } else {
            // Hapus feedback jika nama tidak cocok (pembayaran alumni/eksternal)
            const badge = this.nextElementSibling;
            if (badge && badge.classList.contains('auto-match')) badge.remove();
        }
    });

    // Trigger check saat halaman load (jika ada old input)
    document.getElementById('namaInput').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection