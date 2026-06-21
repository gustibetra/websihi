@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas Sekolah')
@section('page-title', 'Fasilitas')
@section('breadcrumb-parent', 'Data Sekolah')
@section('breadcrumb-current', 'Fasilitas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="ri-home-office-line me-2 text-success"></i>Daftar Fasilitas Sekolah
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.fasilitas-manager')
            </div>
        </div>
    </div>
</div>
@endsection
