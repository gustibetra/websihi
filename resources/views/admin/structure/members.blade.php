@extends('layouts.admin')

@section('title', 'Kelola Anggota')
@section('page-title', 'Kelola Anggota Struktur')
@section('breadcrumb-parent', 'Struktur')
@section('breadcrumb-current', 'Kelola Anggota')

@section('content')
<div class="row">
    @livewire('admin.structure-member-manager', ['structureId' => $structureId])
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('assets/admin/js/pages/structure-member-manager.js') }}"></script>
@endpush

