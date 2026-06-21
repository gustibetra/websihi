@extends('errors.layout')

@section('title', '503 - Layanan Tidak Tersedia')

@section('content')
    <div class="error-icon">
        <i class="ri-time-line"></i>
    </div>
    
    <div class="error-code">503</div>
    
    <h1 class="error-title">Layanan Tidak Tersedia</h1>
    
    <p class="error-message">
        Website sedang dalam pemeliharaan atau mengalami gangguan sementara. Kami akan segera kembali. Terima kasih atas kesabaran Anda.
    </p>
    
    <div class="error-buttons">
        <a href="{{ url('/') }}" class="error-btn">
            <i class="ri-home-4-line"></i>
            Kembali ke Beranda
        </a>
        <a href="javascript:location.reload()" class="error-btn error-btn-secondary">
            <i class="ri-refresh-line"></i>
            Muat Ulang Halaman
        </a>
    </div>
@endsection
