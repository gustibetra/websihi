@extends('errors.layout')

@section('title', '401 - Tidak Terautentikasi')

@section('content')
    <div class="error-icon">
        <i class="ri-user-forbid-line"></i>
    </div>
    
    <div class="error-code">401</div>
    
    <h1 class="error-title">Tidak Terautentikasi</h1>
    
    <p class="error-message">
        Anda harus login terlebih dahulu untuk mengakses halaman ini. Silakan login dengan akun Anda.
    </p>
    
    <div class="error-buttons">
        <a href="{{ route('login') }}" class="error-btn">
            <i class="ri-login-box-line"></i>
            Login
        </a>
        <a href="{{ url('/') }}" class="error-btn error-btn-secondary">
            <i class="ri-home-4-line"></i>
            Kembali ke Beranda
        </a>
    </div>
@endsection
