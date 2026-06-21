@extends('errors.layout')

@section('title', '419 - Sesi Kadaluarsa')

@section('content')
    <div class="error-icon">
        <i class="ri-time-line"></i>
    </div>
    
    <div class="error-code">419</div>
    
    <h1 class="error-title">Sesi Kadaluarsa</h1>
    
    <p class="error-message">
        Sesi Anda telah berakhir karena tidak ada aktivitas dalam waktu yang lama. Silakan muat ulang halaman dan coba lagi.
    </p>
    
    <div class="error-buttons">
        <a href="javascript:location.reload()" class="error-btn">
            <i class="ri-refresh-line"></i>
            Muat Ulang Halaman
        </a>
        <a href="{{ url('/') }}" class="error-btn error-btn-secondary">
            <i class="ri-home-4-line"></i>
            Kembali ke Beranda
        </a>
    </div>
@endsection
