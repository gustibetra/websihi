@extends('layouts.admin')

@section('title', 'Download Center')
@section('page-title', 'Download Center')
@section('breadcrumb-parent', 'Data Sekolah')
@section('breadcrumb-current', 'Download Center')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Download Center / Unduhan</h4>
            </div>
            <div class="card-body">
                @livewire('admin.download-manager')
            </div>
        </div>
    </div>
</div>
@endsection
