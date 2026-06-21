@extends('layouts.admin')

@section('title', 'Berita')
@section('page-title', 'Berita')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header border border-bottom-dashed" id="news-table-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Daftar Berita
                        <span class="news-loading-indicator d-none">
                            <span class="spinner-border spinner-border-sm text-primary ms-2" role="status" style="vertical-align: middle; width: 1rem; height: 1rem;">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h4>
                    <div class="d-flex gap-2 align-items-center" id="news-header-buttons">
                        <!-- Bulk Action Buttons -->
                        <div class="bulk-actions-group d-none" id="bulkActionsGroup">
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-outline-success btn-sm"
                                        id="bulkPublishedBtn"
                                        title="Set Published">
                                    <i class="ri-checkbox-circle-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-warning btn-sm"
                                        id="bulkDraftBtn"
                                        title="Set Draft">
                                    <i class="ri-draft-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        id="bulkArchivedBtn"
                                        title="Set Archived">
                                    <i class="ri-archive-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-info btn-sm"
                                        id="bulkFeaturedBtn"
                                        title="Toggle Featured">
                                    <i class="ri-star-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm"
                                        id="bulkDeleteBtn"
                                        title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.news.create') }}" 
                               class="btn btn-primary btn-sm" 
                               title="Tambah Berita">
                                <i class="ri-add-line"></i>
                            </a>
                            <button type="button" 
                                    id="toggleFilterBtn"
                                    class="btn btn-outline-primary btn-sm"
                                    title="Tampilkan Filter"
                                    onclick="window.dispatchEvent(new CustomEvent('toggle-news-filters', { detail: { show: true } }))">
                                <i class="ri-filter-3-line"></i>
                            </button>
                            <!-- <button type="button" 
                                    class="btn btn-outline-success btn-sm"
                                    title="Export Data">
                                <i class="ri-download-2-line"></i>
                            </button> -->
                        </div>
                        <button type="button" 
                                id="closeFilterBtn"
                                class="btn btn-sm btn-outline-danger d-none"
                                title="Sembunyikan Filter"
                                onclick="window.dispatchEvent(new CustomEvent('toggle-news-filters', { detail: { show: false } }))">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <livewire:admin.news-wire />
            </div>
        </div>
    </div>
</div>



@endsection
