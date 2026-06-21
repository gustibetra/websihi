@extends('layouts.admin')

@section('title', 'Agenda')
@section('page-title', 'Agenda')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Daftar Agenda
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <livewire:admin.agenda-manager />
            </div>
        </div>
    </div>
</div>
@endsection
