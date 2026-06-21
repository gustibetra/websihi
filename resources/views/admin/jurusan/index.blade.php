@extends('layouts.admin')

@section('title', 'Manajemen Program Jurusan')
@section('page-title', 'Program Jurusan')
@section('breadcrumb-parent', 'Data Sekolah')
@section('breadcrumb-current', 'Program Jurusan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="ri-book-2-line me-2 text-primary"></i>Daftar Program Keahlian / Jurusan
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.jurusan-manager')
            </div>
        </div>
    </div>
</div>
@endsection
