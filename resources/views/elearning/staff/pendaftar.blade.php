@extends('layouts.elearning')
@section('title', 'Data Pendaftar')
@section('content')

@php
    // ✅ Statistik pendaftar
    $total    = $pendaftar->count();
    $baru     = $pendaftar->where('status', 'Baru')->count();
    $diproses = $pendaftar->where('status', 'Diproses')->count();
    $diterima = $pendaftar->where('status', 'Diterima')->count();
    $ditolak  = $pendaftar->where('status', 'Ditolak')->count();

    // ✅ Helper: format nomor WA jadi link wa.me (aman jika null/kosong)
    $formatWA = function ($no) {
        if (empty($no)) return null;
        $clean = preg_replace('/[^0-9]/', '', $no);
        if (str_starts_with($clean, '0')) $clean = '62' . substr($clean, 1);
        return $clean;
    };

    // ✅ Map status → warna badge
    $statusColors = [
        'Baru'     => 'bg-warning-subtle text-warning',
        'Diproses' => 'bg-info-subtle text-info',
        'Diterima' => 'bg-success-subtle text-success',
        'Ditolak'  => 'bg-danger-subtle text-danger',
    ];
@endphp

@if(session('success'))<div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-file-list-3-line text-primary"></i> Data Pendaftar</h4>
        <p class="text-muted small mb-0">Kelola data pendaftar siswa/mahasiswa baru dari website</p>
    </div>
    <a href="{{ route('elearning.staff.pendaftar.export') }}" class="btn btn-sm btn-success fw-bold">
        <i class="ri-download-2-line me-1"></i> Export CSV
    </a>
</div>

{{-- ═══ STATISTIK PENDAFTAR ═══ --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-primary">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-group-line"></i></div>
            <div><div class="text-muted small">Total Pendaftar</div><div class="fw-bold fs-5 text-primary">{{ $total }}</div></div>
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-warning">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FFFBEB;color:#D97706;font-size:20px;"><i class="ri-sparkling-line"></i></div>
            <div><div class="text-muted small">Baru</div><div class="fw-bold fs-5 text-warning">{{ $baru }}</div></div>
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-success">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-user-follow-line"></i></div>
            <div><div class="text-muted small">Diterima</div><div class="fw-bold fs-5 text-success">{{ $diterima }}</div></div>
        </div>
    </div></div>
    <div class="col-md-3 col-6"><div class="el-card card p-3 border-start border-4 border-danger">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-user-unfollow-line"></i></div>
            <div><div class="text-muted small">Ditolak</div><div class="fw-bold fs-5 text-danger">{{ $ditolak }}</div></div>
        </div>
    </div></div>
</div>

{{-- ═══ TABEL DATA ═══ --}}
<div class="el-card card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h6 class="fw-bold mb-0"><i class="ri-list-check-2 text-primary me-1"></i> Daftar Pendaftar ({{ $total }})</h6>
        <input type="text" id="searchPendaftar" class="form-control form-control-sm" style="max-width:260px;" placeholder="🔍 Cari nama / email / sekolah...">
    </div>
    <div class="table-responsive">
        <table class="table align-middle small mb-0" id="tablePendaftar">
            <thead class="table-light">
                <tr><th>Nama</th><th>Kontak</th><th>Asal Sekolah</th><th>Program</th><th>Tahun</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($pendaftar as $r)
                @php
                    $waNum = $formatWA($r->no_whatsapp);
                    $status = $r->status ?? 'Baru';
                    $badgeClass = $statusColors[$status] ?? 'bg-secondary-subtle text-secondary';
                    // Escape nama untuk JS confirm (hindari kutip pecahkan string)
                    $safeNama = addslashes($r->nama_lengkap ?? 'Unknown');
                @endphp
                <tr>
                    <td>
                        <div class="fw-bold">{{ $r->nama_lengkap ?? '-' }}</div>
                        <small class="text-muted">{{ $r->jenis_kelamin ?? '-' }}</small>
                        <div class="text-muted" style="font-size:11px;">
                            <i class="ri-calendar-line me-1"></i>{{ $r->created_at?->format('d M Y') ?? '-' }}
                        </div>
                    </td>
                    <td>
                        @if($waNum)
                            <a href="https://wa.me/{{ $waNum }}" target="_blank" class="text-success small fw-bold text-decoration-none">
                                <i class="ri-whatsapp-line me-1"></i>{{ $r->no_whatsapp }}
                            </a>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                        <div class="text-muted small">{{ $r->email ?? '-' }}</div>
                    </td>
                    <td>{{ $r->asal_sekolah ?? '-' }}</td>
                    <td><span class="badge bg-primary-subtle text-primary">{{ $r->program ?? '-' }}</span></td>
                    <td>{{ $r->tahun_lulus ?? '-' }}</td>
                    <td>
                        {{-- ✅ FORM UPDATE STATUS (otomatis submit saat select berubah) --}}
                        <form method="POST" action="{{ route('elearning.staff.pendaftar.status', $r->id) }}" class="d-inline auto-submit-form">
                            @csrf @method('PUT')
                            <div class="d-flex gap-1 align-items-center">
                                <select name="status" class="form-select form-select-sm auto-submit-select">
                                    @foreach(['Baru', 'Diproses', 'Diterima', 'Ditolak'] as $s)
                                        <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary" title="Simpan status"><i class="ri-save-line"></i></button>
                            </div>
                        </form>
                        {{-- ✅ Badge status berwarna --}}
                        <div class="mt-1">
                            <span class="badge {{ $badgeClass }}" style="font-size:10px;">{{ $status }}</span>
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#detailModal{{ $r->id }}" title="Detail">
                                <i class="ri-eye-line"></i>
                            </button>
                            <form method="POST" action="{{ route('elearning.staff.pendaftar.destroy', $r->id) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus data pendaftar &quot;{{ $safeNama }}&quot;?\nTindakan ini permanen!');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- ═══ MODAL DETAIL PENDAFTAR ═══ --}}
                <div class="modal fade" id="detailModal{{ $r->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;">
                            <div class="modal-header text-white" style="background:linear-gradient(90deg,#1F57ED,#7A5CF0);">
                                <h6 class="modal-title fw-bold"><i class="ri-user-3-line me-2"></i>Detail Pendaftar</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    {{-- Identitas --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Data Pribadi</h6>
                                            <div class="mb-2"><small class="text-muted">Nama Lengkap</small><div class="fw-bold">{{ $r->nama_lengkap ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Jenis Kelamin</small><div class="fw-bold">{{ $r->jenis_kelamin ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Tanggal Lahir</small><div class="fw-bold">{{ $r->tgl_lahir ? \Carbon\Carbon::parse($r->tgl_lahir)->translatedFormat('d M Y') : '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Alamat Rumah</small><div class="fw-bold">{{ $r->alamat_rumah ?? '-' }}</div></div>
                                        </div>
                                    </div>
                                    {{-- Kontak --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Kontak</h6>
                                            <div class="mb-2"><small class="text-muted">Email</small><div class="fw-bold">{{ $r->email ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">No. WhatsApp</small>
                                                <div class="fw-bold">
                                                    @if($waNum)
                                                        <a href="https://wa.me/{{ $waNum }}" target="_blank" class="text-success text-decoration-none">
                                                            <i class="ri-whatsapp-line me-1"></i>{{ $r->no_whatsapp }}
                                                        </a>
                                                    @else — @endif
                                                </div>
                                            </div>
                                            <div class="mb-2"><small class="text-muted">No. Orang Tua</small><div class="fw-bold">{{ $r->no_ortu ?? '-' }}</div></div>
                                        </div>
                                    </div>
                                    {{-- Akademik --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Data Akademik</h6>
                                            <div class="mb-2"><small class="text-muted">Asal Sekolah</small><div class="fw-bold">{{ $r->asal_sekolah ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Jurusan Sekolah</small><div class="fw-bold">{{ $r->jurusan_sekolah ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Tahun Lulus</small><div class="fw-bold">{{ $r->tahun_lulus ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Program Dipilih</small><div class="fw-bold"><span class="badge bg-primary-subtle text-primary">{{ $r->program ?? '-' }}</span></div></div>
                                        </div>
                                    </div>
                                    {{-- Status & Waktu --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Status & Waktu</h6>
                                            <div class="mb-2"><small class="text-muted">Status Saat Ini</small><div><span class="badge {{ $badgeClass }}">{{ $status }}</span></div></div>
                                            <div class="mb-2"><small class="text-muted">Tanggal Mendaftar</small><div class="fw-bold">{{ $r->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}</div></div>
                                            <div class="mb-2"><small class="text-muted">Terakhir Diupdate</small><div class="fw-bold">{{ $r->updated_at?->translatedFormat('d M Y, H:i') ?? '-' }}</div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                                @if($waNum)
                                    <a href="https://wa.me/{{ $waNum }}" target="_blank" class="btn btn-sm btn-success fw-bold">
                                        <i class="ri-whatsapp-line me-1"></i> Hubungi via WA
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">
                    <i class="ri-inbox-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                    Belum ada data pendaftar masuk dari website.
                </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Pencarian realtime
    document.getElementById('searchPendaftar').addEventListener('input', function(){
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tablePendaftar tbody tr').forEach(function(tr){
            tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // Auto-submit saat select status berubah (opsional, untuk UX cepat)
    // document.querySelectorAll('.auto-submit-select').forEach(function(sel){
    //     sel.addEventListener('change', function(){ this.form.submit(); });
    // });
</script>
@endpush
@endsection