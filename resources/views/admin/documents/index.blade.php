@extends('layouts.admin')

@section('title', 'Dokumen')
@section('page-title', 'Dokumen')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Dokumen</h5>
        <a href="#" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Dokumen
        </a>
    </div>
    <div class="card-body">
        <p class="text-muted">Halaman CRUD dokumen akan ditampilkan di sini.</p>
    </div>
</div>
@endsection

