@extends('layouts.admin')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Detail Berita</h4>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line align-middle me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line align-middle me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <h2 class="mb-3">{{ $news->title }}</h2>

                        <!-- Meta Info -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($news->category)
                                <span class="badge bg-info">{{ $news->category->data1 }}</span>
                            @endif
                            @if($news->period)
                                <span class="badge bg-secondary">{{ $news->period }}</span>
                            @else
                                <span class="badge bg-light text-dark">Umum</span>
                            @endif
                            @if($news->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($news->status == 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span class="badge bg-secondary">Archived</span>
                            @endif
                            @if($news->is_featured)
                                <span class="badge bg-warning text-dark">
                                    <i class="ri-star-fill"></i> Featured
                                </span>
                            @endif
                        </div>

                        <!-- Image -->
                        @if($news->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid rounded">
                            </div>
                        @endif

                        <!-- Excerpt -->
                        @if($news->excerpt)
                            <div class="alert alert-light mb-4">
                                <p class="mb-0 fw-semibold">{{ $news->excerpt }}</p>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="mb-4">
                            <div class="ql-editor">
                                {!! $news->content !!}
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($news->tags)
                            <div class="mb-4">
                                <h6>Tags:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $news->tags) as $tag)
                                        <span class="badge bg-light text-dark">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- File Attachment -->
                        @if($news->file)
                            <div class="mb-4">
                                <h6>Lampiran:</h6>
                                <a href="{{ asset('storage/' . $news->file) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="ri-file-line me-1"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Status Card -->
                        <div class="card border mb-3">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Informasi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td width="40%"><strong>Status:</strong></td>
                                        <td>
                                            @if($news->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($news->status == 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-secondary">Archived</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Featured:</strong></td>
                                        <td>
                                            @if($news->is_featured)
                                                <i class="ri-check-line text-success"></i> Ya
                                            @else
                                                <i class="ri-close-line text-muted"></i> Tidak
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategori:</strong></td>
                                        <td>{{ $news->category ? $news->category->data1 : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Period:</strong></td>
                                        <td>{{ $news->period ?? 'Umum' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penulis:</strong></td>
                                        <td>{{ $news->author ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sumber:</strong></td>
                                        <td>{{ $news->source ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Published:</strong></td>
                                        <td>{{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Views:</strong></td>
                                        <td>{{ number_format($news->view_count ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shares:</strong></td>
                                        <td>{{ number_format($news->share_count ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $news->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diupdate:</strong></td>
                                        <td>{{ $news->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- SEO Card -->
                        @if($news->meta_title || $news->meta_description)
                            <div class="card border mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">SEO</h5>
                                </div>
                                <div class="card-body">
                                    @if($news->meta_title)
                                        <div class="mb-3">
                                            <strong>Meta Title:</strong>
                                            <p class="mb-0 small">{{ $news->meta_title }}</p>
                                        </div>
                                    @endif
                                    @if($news->meta_description)
                                        <div class="mb-0">
                                            <strong>Meta Description:</strong>
                                            <p class="mb-0 small">{{ $news->meta_description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Aksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary">
                                        <i class="ri-pencil-line me-1"></i> Edit Berita
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="ri-delete-bin-line me-1"></i> Hapus Berita
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Quill Editor CSS for content display -->
<link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush

