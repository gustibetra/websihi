@extends('errors.layout')

@section('title', '403 - Akses Ditolak')

@section('content')
    <div class="error-icon">
        <i class="ri-lock-line"></i>
    </div>
    
    <div class="error-code">403</div>
    
    <h1 class="error-title">Akses Ditolak</h1>
    
    <p class="error-message">
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
    </p>
    
    <div class="error-buttons">
        <a href="{{ url('/') }}" class="error-btn">
            <i class="ri-home-4-line"></i>
            Kembali ke Beranda
        </a>
        <a href="javascript:history.back()" class="error-btn error-btn-secondary">
            <i class="ri-arrow-left-line"></i>
            Halaman Sebelumnya
        </a>
    </div>
@endsection
