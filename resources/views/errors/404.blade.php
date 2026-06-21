@extends('errors.layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="error-icon">
        <i class="ri-search-line"></i>
    </div>
    
    <div class="error-code">404</div>
    
    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
    
    <p class="error-message">
        Maaf, halaman yang Anda cari tidak dapat ditemukan. Halaman mungkin telah dipindahkan atau dihapus.
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
