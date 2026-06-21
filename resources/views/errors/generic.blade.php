@extends('errors.layout')

@section('title', $code ?? '500' . ' - Terjadi Kesalahan')

@section('content')
    <div class="error-icon">
        <i class="ri-error-warning-line"></i>
    </div>
    
    <div class="error-code">{{ $code ?? '500' }}</div>
    
    <h1 class="error-title">{{ $title ?? 'Terjadi Kesalahan' }}</h1>
    
    <p class="error-message">
        {{ $message ?? 'Maaf, terjadi kesalahan yang tidak terduga. Silakan coba lagi nanti atau hubungi administrator.' }}
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
