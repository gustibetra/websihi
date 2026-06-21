@extends('layouts.admin')

@section('title', 'Pengaturan Keamanan')
@section('page-title', 'Pengaturan Keamanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Pengaturan Keamanan</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Pengaturan keamanan akan ditampilkan di sini.</p>
        <ul>
            <li>IP Filtering (On/Off)</li>
            <li>Security Headers</li>
            <li>User Agent Filtering</li>
            <li>Rate Limiting</li>
        </ul>
    </div>
</div>
@endsection

