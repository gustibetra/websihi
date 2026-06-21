@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('breadcrumb-parent', 'Pengaturan')
@section('breadcrumb-current', 'Pengaturan Institusi')

@section('content')
<div class="row">
    @livewire('admin.settings-manager')
</div>
@endsection


