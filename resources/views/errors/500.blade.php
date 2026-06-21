@extends('errors.layout')

@section('title', '500 - Kesalahan Server')

@section('content')
    <div class="error-icon">
        <i class="ri-tools-line"></i>
    </div>
    
    <div class="error-code">500</div>
    
    <h1 class="error-title">Kesalahan Server</h1>
    
    <p class="error-message">
        Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang bekerja untuk memperbaikinya. Silakan coba lagi nanti.
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
