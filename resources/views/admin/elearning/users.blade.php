@extends('layouts.admin')
@section('title', 'Akun E-Learning')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="ri-graduation-cap-line text-primary"></i> Kelola Akun E-Learning</h4>
            <p class="text-muted small mb-0">Buat & kelola akun Staff dan Mahasiswa</p>
        </div>
        <div class="d-flex gap-2">
            {{-- ✅ BARU: Tombol Import Excel --}}
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="ri-file-excel-2-line me-1"></i> Import Excel
            </button>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#formCreate"><i class="ri-add-line me-1"></i> Buat Akun</button>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success py-2 small d-flex align-items-center gap-2">
            <i class="ri-checkbox-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2 small d-flex align-items-center gap-2">
            <i class="ri-error-warning-fill"></i> <strong>Gagal:</strong> {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2 small d-flex align-items-center gap-2">
            <i class="ri-error-warning-fill"></i>
            <div>
                <strong>Validasi gagal:</strong>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#EEF2FF;color:#1F57ED;font-size:20px;"><i class="ri-user-star-line"></i></div>
            <div><div class="text-muted small">Staff</div><div class="fw-bold">{{ $stats['staff'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#ECFDF5;color:#059669;font-size:20px;"><i class="ri-graduation-cap-line"></i></div>
            <div><div class="text-muted small">Mahasiswa</div><div class="fw-bold">{{ $stats['mahasiswa'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#F0FDF4;color:#16A34A;font-size:20px;"><i class="ri-checkbox-circle-line"></i></div>
            <div><div class="text-muted small">Aktif</div><div class="fw-bold">{{ $stats['aktif'] }}</div></div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card border-0 shadow-sm p-3"><div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#FEF2F2;color:#DC2626;font-size:20px;"><i class="ri-forbid-line"></i></div>
            <div><div class="text-muted small">Nonaktif</div><div class="fw-bold">{{ $stats['nonaktif'] }}</div></div>
        </div></div></div>
    </div>

    {{-- FORM BUAT AKUN --}}
    <div class="collapse mb-4 {{ $errors->any() || session('error') ? 'show' : '' }}" id="formCreate">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="ri-user-add-line text-success me-1"></i> Form Akun Baru</h6>
                <form method="POST" action="{{ route('admin.elearning.users.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Nama Lengkap *</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Email *</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Password *</label>
                        <input type="text" name="password" class="form-control form-control-sm" minlength="6" value="{{ old('password') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Role *</label>
                        <select name="role" id="formRole" class="form-select form-select-sm" required onchange="toggleStaffType()">
                            <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="staffTypeWrap">
                        <label class="form-label small fw-bold">Tipe Staff (jika staff)</label>
                        <select name="staff_type" class="form-select form-select-sm">
                            <option value="">—</option>
                            <option value="pengajar" {{ old('staff_type') === 'pengajar' ? 'selected' : '' }}>Pengajar</option>
                            <option value="administrasi" {{ in_array(old('staff_type'), ['administrasi', 'keuangan']) ? 'selected' : '' }}>Administrasi & Keuangan</option>
                            <option value="direktur" {{ old('staff_type') === 'direktur' ? 'selected' : '' }}>Direktur Lembaga</option>
                            <option value="wakil_direktur" {{ old('staff_type') === 'wakil_direktur' ? 'selected' : '' }}>Wakil Direktur</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">NIM / NIP</label>
                        <input type="text" name="nomor_induk" class="form-control form-control-sm" value="{{ old('nomor_induk') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Program (mahasiswa)</label>
                        <input type="text" name="program" class="form-control form-control-sm" placeholder="Contoh: Perhotelan" value="{{ old('program') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-success fw-bold">
                            <i class="ri-save-line me-1"></i> Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel Akun --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h6 class="fw-bold mb-0"><i class="ri-list-check-2 text-primary me-1"></i> Daftar Akun ({{ $users->count() }})</h6>
                {{-- ✅ BARU: pencarian akun --}}
                <input type="text" id="accSearch" class="form-control form-control-sm" style="max-width:240px;" placeholder="🔍 Cari nama / email / NIM...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small" id="accTable">
                    <thead class="table-light">
                        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Keterangan</th><th>NIM/NIP</th><th>Status</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td class="fw-bold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge {{ $u->role === 'staff' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }}">{{ ucfirst($u->role) }}</span></td>
                            <td>
                                @if($u->role === 'staff')
                                    @php
                                        $label = [
                                            'pengajar'       => 'Pengajar',
                                            'administrasi'   => 'Administrasi & Keuangan',
                                            'keuangan'       => 'Administrasi & Keuangan',
                                            'direktur'       => 'Direktur Lembaga',
                                            'wakil_direktur' => 'Wakil Direktur',
                                        ];
                                    @endphp
                                    {{ $label[$u->staff_type] ?? ucfirst($u->staff_type ?? '-') }}
                                @else
                                    {{ $u->program ?? '-' }}
                                @endif
                            </td>
                            <td>{{ $u->nomor_induk ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.elearning.users.toggle', $u->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm {{ $u->is_active ? 'btn-soft-success' : 'btn-soft-danger' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</button>
                                </form>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{ $u->id }}"><i class="ri-edit-line"></i></button>
                                <form method="POST" action="{{ route('admin.elearning.users.destroy', $u->id) }}" class="d-inline" onsubmit="return confirm('Hapus akun {{ $u->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editModal{{ $u->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.elearning.users.update', $u->id) }}">
                                        @csrf @method('PUT')
                                        <div class="modal-header"><h6 class="modal-title fw-bold">Edit Akun: {{ $u->name }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <div class="modal-body">
                                            <div class="mb-2"><label class="form-label small fw-bold">Nama</label>
                                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $u->name }}" required></div>
                                            <div class="mb-2"><label class="form-label small fw-bold">Email</label>
                                                <input type="email" name="email" class="form-control form-control-sm" value="{{ $u->email }}" required></div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6"><label class="form-label small fw-bold">Role</label>
                                                    <select name="role" class="form-select form-select-sm">
                                                        <option value="mahasiswa" {{ $u->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                        <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                                    </select></div>
                                                <div class="col-6"><label class="form-label small fw-bold">Tipe Staff</label>
                                                    <select name="staff_type" class="form-select form-select-sm">
                                                        <option value="">—</option>
                                                        <option value="pengajar" {{ $u->staff_type === 'pengajar' ? 'selected' : '' }}>Pengajar</option>
                                                        <option value="administrasi" {{ in_array($u->staff_type, ['administrasi', 'keuangan']) ? 'selected' : '' }}>Administrasi & Keuangan</option>
                                                        <option value="direktur" {{ $u->staff_type === 'direktur' ? 'selected' : '' }}>Direktur Lembaga</option>
                                                        <option value="wakil_direktur" {{ $u->staff_type === 'wakil_direktur' ? 'selected' : '' }}>Wakil Direktur</option>
                                                    </select></div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6"><label class="form-label small fw-bold">NIM/NIP</label>
                                                    <input type="text" name="nomor_induk" class="form-control form-control-sm" value="{{ $u->nomor_induk }}"></div>
                                                <div class="col-6"><label class="form-label small fw-bold">Program</label>
                                                    <input type="text" name="program" class="form-control form-control-sm" value="{{ $u->program }}"></div>
                                            </div>
                                            <div class="mb-2"><label class="form-label small fw-bold">Password Baru (kosongkan jika tidak diubah)</label>
                                                <input type="text" name="password" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-sm btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada akun. Klik "Buat Akun" atau "Import Excel".</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ═══ MODAL IMPORT EXCEL / CSV ═══ --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.elearning.users.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title fw-bold"><i class="ri-file-excel-2-line me-2"></i>Import Akun Mahasiswa dari Excel / CSV</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- INFO FORMAT --}}
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="ri-information-line me-1"></i>
                        <strong>Format kolom:</strong> Nama Lengkap, NIM, Email, Program, Password
                        <ul class="mb-0 mt-1 ps-3">
                            <li>Email kosong → otomatis dibuat <code>nim@student.sihi.ac.id</code></li>
                            <li>Password kosong → default <code>sihi1234</code></li>
                            <li>Baris duplikat (email/NIM sama) otomatis dilewati</li>
                        </ul>
                    </div>

                    {{-- ⚠️ HINT: XLSX BUTUH ZIP --}}
                    @if(!class_exists(\ZipArchive::class))
                        <div class="alert alert-warning py-2 small mb-3">
                            <i class="ri-error-warning-line me-1"></i>
                            <strong>File .xlsx saat ini belum didukung server.</strong>
                            Gunakan <strong>.CSV</strong> (lihat panduan di bawah) atau aktifkan <code>extension=zip</code> di php.ini.
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- KOLOM KIRI: FORM UPLOAD --}}
                        <div class="col-md-6">
                            <h6 class="fw-bold small mb-2"><i class="ri-upload-cloud-line me-1 text-success"></i> 1. Upload File</h6>
                            <div class="mb-3">
                                <input type="file" name="file" class="form-control form-control-sm" accept=".xlsx,.csv,.xls" required>
                                <small class="text-muted">Format: <strong>.xlsx</strong> atau <strong>.csv</strong> (maks 10MB)</small>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.elearning.users.template') }}" class="btn btn-sm btn-outline-success">
                                    <i class="ri-download-2-line me-1"></i> Unduh Template CSV
                                </a>
                            </div>

                            <div class="mt-3 p-2 rounded-3" style="background:#F0F9FF; border:1px dashed #BAE6FD;">
                                <small class="text-info">
                                    <i class="ri-lightbulb-line me-1"></i>
                                    <strong>Tip:</strong> File CSV lebih aman & lebih cepat diproses.
                                </small>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: PANDUAN SAVE AS CSV --}}
                        <div class="col-md-6">
                            <h6 class="fw-bold small mb-2"><i class="ri-question-line me-1 text-primary"></i> 2. Cara Konversi Excel → CSV</h6>
                            <ol class="small ps-3 mb-0" style="line-height:1.8;">
                                <li>Buka file <strong>.xlsx</strong> Anda di <strong>Microsoft Excel</strong></li>
                                <li>Klik menu <strong>File → Save As</strong> (atau tekan <kbd>F12</kbd>)</li>
                                <li>Di kotak "Save as type", pilih:
                                    <br><code style="background:#FEF3C7;padding:2px 6px;border-radius:4px;">CSV UTF-8 (Comma delimited) (*.csv)</code>
                                </li>
                                <li>Klik <strong>Save</strong></li>
                                <li>Upload file <code>.csv</code> yang baru dibuat di form ini ✅</li>
                            </ol>
                            <div class="mt-2 p-2 rounded-3 small" style="background:#ECFDF5; border:1px solid #A7F3D0;">
                                <i class="ri-checkbox-circle-line text-success me-1"></i>
                                <strong>Keuntungan CSV:</strong> selalu didukung server, tanpa perlu aktifkan ekstensi tambahan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-success fw-bold"><i class="ri-upload-cloud-line me-1"></i> Import Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleStaffType() {
        const role = document.getElementById('formRole').value;
        const wrap = document.getElementById('staffTypeWrap');
        wrap.style.display = (role === 'staff') ? 'block' : 'none';
    }
    toggleStaffType();

    // ✅ Pencarian akun realtime
    document.getElementById('accSearch').addEventListener('input', function(){
        const q = this.value.toLowerCase();
        document.querySelectorAll('#accTable tbody tr').forEach(function(tr){
            tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection