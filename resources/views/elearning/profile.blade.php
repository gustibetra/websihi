@extends('layouts.elearning')
@section('title', 'Profil Saya')
@section('content')

<h4 class="fw-bold mb-4"><i class="ri-user-settings-line text-primary"></i> Profil Saya</h4>

<div class="row g-4">
    {{-- Kartu Foto --}}
    <div class="col-lg-4">
        <div class="el-card card p-4 text-center h-100">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;border:4px solid #EEF2FF;">
            @else
                <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3" style="width:110px;height:110px;background:linear-gradient(135deg,#FFD166,#06D6A0);font-size:38px;font-weight:800;color:#13294B;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
            <span class="badge bg-primary-subtle text-primary mb-2">{{ ucfirst($user->role) }}{{ $user->staff_type ? ' • ' . ucfirst($user->staff_type) : '' }}</span>
            <div class="small text-muted mb-3">{{ $user->nomor_induk ?? '-' }}</div>

            <form method="POST" action="{{ route('elearning.profile.photo') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo" class="form-control form-control-sm mb-2" accept="image/*" required>
                <button class="btn btn-sm btn-primary w-100 fw-bold"><i class="ri-camera-line me-1"></i> Ganti Foto Profil</button>
            </form>
        </div>
    </div>

    {{-- Info & Password --}}
    <div class="col-lg-8">
        <div class="el-card card p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="ri-id-card-line text-primary me-1"></i> Informasi Akun</h6>
            <div class="row g-3 small">
                <div class="col-md-6"><div class="text-muted">Nama Lengkap</div><div class="fw-bold">{{ $user->name }}</div></div>
                <div class="col-md-6"><div class="text-muted">NIP / NIM</div><div class="fw-bold">{{ $user->nomor_induk ?? '-' }}</div></div>
                <div class="col-md-6"><div class="text-muted">Email</div><div class="fw-bold">{{ $user->email ?? '-' }}</div></div>
                <div class="col-md-6"><div class="text-muted">Role</div><div class="fw-bold">{{ ucfirst($user->role) }}</div></div>
            </div>
            <div class="alert alert-info py-2 small mt-3 mb-0"><i class="ri-information-line me-1"></i> Untuk mengubah nama / NIP / NIM, silakan hubungi admin.</div>
        </div>

        <div class="el-card card p-4">
            <h6 class="fw-bold mb-3"><i class="ri-lock-password-line text-primary me-1"></i> Ganti Password</h6>
            @if($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('elearning.profile.password') }}" class="row g-3">
                @csrf
                <div class="col-12"><label class="form-label small fw-bold">Password Saat Ini *</label>
                    <input type="password" name="current_password" class="form-control form-control-sm" required></div>
                <div class="col-md-6"><label class="form-label small fw-bold">Password Baru *</label>
                    <input type="password" name="password" class="form-control form-control-sm" minlength="6" required></div>
                <div class="col-md-6"><label class="form-label small fw-bold">Konfirmasi Password Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-sm" required></div>
                <div class="col-12"><button class="btn btn-sm btn-primary fw-bold"><i class="ri-save-line me-1"></i> Simpan Password Baru</button></div>
            </form>
        </div>
    </div>
</div>
@endsection