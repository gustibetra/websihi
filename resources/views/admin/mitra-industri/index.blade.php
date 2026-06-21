@extends('layouts.admin')

@section('title', 'Manajemen Mitra DU/DI')
@section('page-title', 'Mitra DU/DI')
@section('breadcrumb-parent', 'Data Sekolah')
@section('breadcrumb-current', 'Mitra DU/DI')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="ri-building-2-line me-2 text-primary"></i>Daftar Mitra Dunia Usaha / Dunia Industri (DU/DI)
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.mitra-industri-manager')
            </div>
        </div>
    </div>
</div>
@endsection
