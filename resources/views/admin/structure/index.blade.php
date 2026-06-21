@extends('layouts.admin')

@section('title', 'Manajemen Struktur')
@section('page-title', 'Manajemen Struktur')
@section('breadcrumb-parent', 'Struktur')
@section('breadcrumb-current', 'Manajemen Struktur')

@section('content')
<div class="row">
    @livewire('admin.structure-manager', ['type' => $type])
</div>
@endsection

