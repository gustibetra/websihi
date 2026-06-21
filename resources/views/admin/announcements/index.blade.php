@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <h4 class="card-title mb-0">Daftar Pengumuman</h4>
            </div>
            <div class="card-body">
                <livewire:admin.announcement-manager />
            </div>
        </div>
    </div>
</div>
@endsection
