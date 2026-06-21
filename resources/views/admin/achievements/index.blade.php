@extends('layouts.admin')

@section('title', 'Manajemen Prestasi')
@section('page-title', 'Prestasi')
@section('breadcrumb-parent', 'Data Sekolah')
@section('breadcrumb-current', 'Prestasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="ri-trophy-line me-2 text-warning"></i>Daftar Prestasi Sekolah &amp; Siswa
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.achievement-manager')
            </div>
        </div>
    </div>
</div>
@endsection
