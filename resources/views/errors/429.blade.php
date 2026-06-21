@extends('errors.layout')

@section('title', '429 - Terlalu Banyak Permintaan')

@section('content')
    <div class="error-icon">
        <i class="ri-spam-2-line"></i>
    </div>
    
    <div class="error-code">429</div>
    
    <h1 class="error-title">Terlalu Banyak Permintaan</h1>
    
    <p class="error-message">
        Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Silakan tunggu beberapa saat sebelum mencoba lagi.
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
