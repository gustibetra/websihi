@extends('layouts.admin')

@section('title', 'Manajemen Struktural Yayasan')
@section('page-title', 'Struktural Yayasan')
@section('breadcrumb-parent', 'SDM')
@section('breadcrumb-current', 'Struktural Yayasan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Daftar Jajaran Struktural Yayasan
                        <span wire:loading.delay class="ms-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" style="vertical-align: middle; width: 1rem; height: 1rem;">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('admin.structural-member-manager')
            </div>
        </div>
    </div>
</div>
@endsection
