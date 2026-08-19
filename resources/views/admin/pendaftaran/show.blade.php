@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Detail Pendaftar</h4>
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary"><i class="feather-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Data Lengkap Pendaftar</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><small class="text-muted d-block">Nama Lengkap</small><strong>{{ $p->nama_lengkap }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Jenis Kelamin</small><strong>{{ $p->jenis_kelamin }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Tanggal Lahir</small><strong>{{ $p->tgl_lahir }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Asal Sekolah</small><strong>{{ $p->asal_sekolah }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Tahun Lulus</small><strong>{{ $p->tahun_lulus }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Jurusan Saat Sekolah</small><strong>{{ $p->jurusan_sekolah ?: '-' }}</strong></div>
                        <div class="col-12"><small class="text-muted d-block">Alamat Rumah</small><strong>{{ $p->alamat_rumah }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">No WhatsApp</small><strong>{{ $p->no_whatsapp }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">No Orang Tua</small><strong>{{ $p->no_ortu ?: '-' }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Email</small><strong>{{ $p->email }}</strong></div>
                        <div class="col-md-6"><small class="text-muted d-block">Program Dipilih</small><span class="badge bg-primary">{{ $p->program }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Status Pendaftaran</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pendaftaran.update-status', $p->id) }}">
                        @csrf @method('PUT')
                        <label class="form-label small text-muted">Ubah Status</label>
                        <select name="status" class="form-select mb-3">
                            @foreach(['Baru', 'Diterima', 'Ditolak'] as $s)
                                <option value="{{ $s }}" {{ $p->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary w-100">Simpan Status</button>
                    </form>
                    <hr>
                    <small class="text-muted">Terdaftar pada: {{ $p->created_at->format('d M Y, H:i') }} WIB</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection