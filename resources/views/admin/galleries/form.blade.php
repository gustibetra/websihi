@extends('layouts.admin')

@section('title', isset($gallery) ? 'Edit Gallery' : 'Tambah Gallery')
@section('page-title', isset($gallery) ? 'Edit Gallery' : 'Tambah Gallery')

@push('styles')
<style>
    .gallery-upload-dropzone {
        border: 1.5px dashed #cbd5e1;
        border-radius: 16px;
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        padding: 14px;
    }

    .gallery-upload-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(126px, 1fr));
        gap: 12px;
    }

    .gallery-upload-preview-item {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
    }

    .gallery-upload-preview-media {
        aspect-ratio: 4 / 5;
        overflow: hidden;
        background: #e5e7eb;
    }

    .gallery-upload-preview-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-upload-preview-body {
        padding: 8px;
    }

    .gallery-upload-preview-name {
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
        margin-bottom: 6px;
    }

    .gallery-upload-preview-meta {
        font-size: 10px;
        color: #6b7280;
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 8px;
    }

    .gallery-upload-preview-remove {
        width: 100%;
        border: 0;
        background: #fee2e2;
        color: #b91c1c;
        border-radius: 9px;
        padding: 6px 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .gallery-current-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(132px, 1fr));
        gap: 12px;
    }

    .gallery-current-image-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 8px;
        background: #fff;
    }

    .gallery-current-image-remove {
        width: 100%;
        padding: 6px 8px;
        font-size: 11px;
    }
</style>
@endpush

@section('content')
@php
    $isEdit = isset($gallery) && $gallery;
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h4 class="card-title mb-0">{{ $isEdit ? 'Edit Gallery' : 'Tambah Gallery Baru' }}</h4>
                        @if($isEdit)
                            <p class="text-muted mb-0 mt-1">Gallery dibuat oleh {{ $gallery->user->name ?? '-' }} pada {{ $gallery->created_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ri-arrow-left-line me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ $isEdit ? route('admin.galleries.update', $gallery->id) : route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $gallery->title ?? '') }}"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $gallery->slug ?? '') }}"
                                       placeholder="auto-generate-dari-judul">
                                <small class="text-muted">Slug dipakai untuk URL publik, bisa dikosongkan agar dibuat otomatis.</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="6">{{ old('description', $gallery->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card border">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                    <h5 class="card-title mb-0 fs-6">Gambar Saat Ini</h5>
                                    @if($isEdit)
                                        <span class="badge bg-primary">{{ $gallery->images_count }} foto</span>
                                    @endif
                                </div>
                                <div class="card-body py-3">
                                    @if($isEdit)
                                        <div class="gallery-current-images-grid">
                                            @forelse($gallery->images as $image)
                                                <div>
                                                    <div class="gallery-current-image-card h-100">
                                                        <div style="aspect-ratio: 4 / 5; overflow: hidden; border-radius: 10px; background: #f3f4f6;">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                 alt="{{ $gallery->title }}"
                                                                 loading="lazy"
                                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger gallery-current-image-remove"
                                                                    form="delete-image-form-{{ $image->id }}"
                                                                    onclick="return confirm('Hapus gambar ini?');">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-muted">Belum ada gambar.</div>
                                            @endforelse
                                        </div>
                                    @else
                                        <div class="text-muted">Gambar yang diupload akan tampil di bagian ini setelah tersimpan.</div>
                                    @endif
                                </div>
                            </div>

                            @if($isEdit)
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Gambar Tambahan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-muted">Gunakan area upload di bawah untuk menambahkan foto baru ke gallery ini.</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-6">Upload Gambar</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="alert alert-info mb-3 py-2 px-3 small">
                                        Disarankan resolusi 1200 x 1500 px dengan rasio 4:5 agar semua kartu terlihat seragam. Format: JPG, PNG, GIF, WEBP. Max 4 MB per file.
                                    </div>
                                    <div class="gallery-upload-dropzone mb-3">
                                        <label for="images" class="form-label fw-semibold mb-2">Upload gambar</label>
                                        <input type="file"
                                               class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                               id="images"
                                               name="images[]"
                                               accept="image/*"
                                               multiple>
                                        <small class="text-muted d-block mt-2">Anda bisa pilih file beberapa kali sebelum menyimpan. File akan masuk ke daftar preview di bawah.</small>
                                    </div>
                                    @error('images')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('images.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div class="mb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fs-6">Preview upload</h6>
                                            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="clearGalleryUploads">Kosongkan</button>
                                        </div>
                                        <div id="galleryUploadPreview" class="gallery-upload-preview-grid"></div>
                                        <div id="galleryUploadEmpty" class="text-muted small mt-2">Belum ada file yang dipilih.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kategori & Jurusan Card -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-6">Kategori & Jurusan</h5>
                                </div>
                                <div class="card-body py-3">
                                    <!-- Kategori -->
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id"
                                                name="category_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        {{ old('category_id', $gallery->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->data1 }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="mb-0">
                                        <label for="jurusan_id" class="form-label">Jurusan</label>
                                        <select class="form-select @error('jurusan_id') is-invalid @enderror" 
                                                id="jurusan_id"
                                                name="jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                            @if(!auth()->user()->isAdminJurusan())
                                                <option value="">Umum (Semua Jurusan)</option>
                                            @endif
                                            @foreach($jurusans as $j)
                                                <option value="{{ $j->id }}"
                                                        {{ old('jurusan_id', $gallery->jurusan_id ?? auth()->user()->jurusan_id) == $j->id ? 'selected' : '' }}>
                                                    {{ $j->nama }} ({{ $j->singkatan }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if(auth()->user()->isAdminJurusan())
                                            <input type="hidden" name="jurusan_id" value="{{ auth()->user()->jurusan_id }}">
                                        @endif
                                        @error('jurusan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card border mt-3">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-6">Ringkasan</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Judul</span>
                                        <span class="fw-semibold text-end">{{ old('title', $gallery->title ?? '-') ?: '-' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Gambar</span>
                                        <span class="fw-semibold">{{ $isEdit ? $gallery->images_count : 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Upload By</span>
                                        <span class="fw-semibold text-end">{{ $gallery->user->name ?? auth()->user()->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-light btn-sm">Batal</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="ri-save-line me-1"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Gallery' }}
                        </button>
                    </div>
                </form>

                @if($isEdit)
                    @foreach($gallery->images as $image)
                        <form id="delete-image-form-{{ $image->id }}" action="{{ route('admin.galleries.images.destroy', $image->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<template id="galleryUploadPreviewTemplate">
    <div class="gallery-upload-preview-item">
        <div class="gallery-upload-preview-media">
            <img src="" alt="Preview" loading="lazy">
        </div>
        <div class="gallery-upload-preview-body">
            <div class="gallery-upload-preview-name"></div>
            <div class="gallery-upload-preview-meta">
                <span class="gallery-upload-preview-size"></span>
            </div>
            <button type="button" class="gallery-upload-preview-remove">Hapus</button>
        </div>
    </div>
</template>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('images');
    const previewGrid = document.getElementById('galleryUploadPreview');
    const previewEmpty = document.getElementById('galleryUploadEmpty');
    const clearButton = document.getElementById('clearGalleryUploads');
    const template = document.getElementById('galleryUploadPreviewTemplate');
    const selectedFiles = [];

    function fileKey(file) {
        return [file.name, file.size, file.lastModified].join('__');
    }

    function humanFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function syncInputFiles() {
        const transfer = new DataTransfer();
        selectedFiles.forEach(function (entry) {
            transfer.items.add(entry.file);
        });
        fileInput.files = transfer.files;
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';

        if (!selectedFiles.length) {
            previewEmpty.classList.remove('d-none');
            clearButton.classList.add('d-none');
            return;
        }

        previewEmpty.classList.add('d-none');
        clearButton.classList.remove('d-none');

        selectedFiles.forEach(function (entry) {
            const fragment = template.content.cloneNode(true);
            const card = fragment.querySelector('.gallery-upload-preview-item');
            const img = fragment.querySelector('img');
            const name = fragment.querySelector('.gallery-upload-preview-name');
            const size = fragment.querySelector('.gallery-upload-preview-size');
            const removeButton = fragment.querySelector('.gallery-upload-preview-remove');

            img.src = entry.previewUrl;
            name.textContent = entry.file.name;
            size.textContent = humanFileSize(entry.file.size);

            removeButton.addEventListener('click', function () {
                const index = selectedFiles.findIndex(function (item) {
                    return item.key === entry.key;
                });

                if (index !== -1) {
                    URL.revokeObjectURL(selectedFiles[index].previewUrl);
                    selectedFiles.splice(index, 1);
                    syncInputFiles();
                    renderPreviews();
                }
            });

            previewGrid.appendChild(fragment);
        });
    }

    fileInput.addEventListener('change', function () {
        Array.from(this.files || []).forEach(function (file) {
            const key = fileKey(file);

            if (selectedFiles.some(function (entry) { return entry.key === key; })) {
                return;
            }

            selectedFiles.push({
                key: key,
                file: file,
                previewUrl: URL.createObjectURL(file),
            });
        });

        syncInputFiles();
        renderPreviews();
    });

    fileInput.addEventListener('click', function () {
        this.value = '';
    });

    clearButton.addEventListener('click', function () {
        selectedFiles.forEach(function (entry) {
            URL.revokeObjectURL(entry.previewUrl);
        });
        selectedFiles.length = 0;
        syncInputFiles();
        renderPreviews();
    });

    renderPreviews();
});
</script>
@endpush
