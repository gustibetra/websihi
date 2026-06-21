@extends('layouts.admin')

@section('title', 'Manajemen Halaman')
@section('page-title', 'Manajemen Halaman')
@section('breadcrumb-parent', 'Konten')
@section('breadcrumb-current', 'Halaman')

@section('content')
<div class="row structure-page">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Manajemen Halaman
                        <span wire:loading.delay class="ms-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" style="vertical-align: middle; width: 1rem; height: 1rem;">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.page-manager')
            </div>
        </div>
    </div>
</div>
@endsection
