@extends('layouts.admin')

@section('title', 'Common Data Management')
@section('page-title', 'Common Data Management')
@section('breadcrumb-parent', 'Manajemen Data')
@section('breadcrumb-current', 'Common Data')

@section('content')
<div class="row">
                @livewire('admin.common-data-manager', ['data' => request('data')])
</div>
@endsection
