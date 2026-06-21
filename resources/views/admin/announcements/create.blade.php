@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Tambah Pengumuman Baru</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-check-line me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" id="announcementForm" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generate-dari-judul">
                                <small class="text-muted">Auto-generate dari judul</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                <div id="editor" data-ckeditor data-ckeditor-upload-url="/admin/announcements/upload-image" data-ckeditor-content="{{ old('content', '') }}"></div>
                                <textarea name="content" id="content" class="d-none">{{ old('content') }}</textarea>
                                <div id="contentError" class="text-danger small" style="display: none;">Konten wajib diisi.</div>
                                @error('content')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Ringkasan</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Status -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_public">Publik</label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Period -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Kategori & Periode</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->data1 }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jurusan_id" class="form-label">Jurusan</label>
                                        <select class="form-select @error('jurusan_id') is-invalid @enderror" id="jurusan_id" name="jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                            @if(!auth()->user()->isAdminJurusan())
                                                <option value="">Umum (Semua Jurusan)</option>
                                            @endif
                                            @foreach($jurusans as $j)
                                                <option value="{{ $j->id }}" {{ old('jurusan_id', auth()->user()->jurusan_id) == $j->id ? 'selected' : '' }}>
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

                                    <div class="mb-0">
                                        <label for="period" class="form-label">Periode</label>
                                        <select class="form-select @error('period') is-invalid @enderror" id="period" name="period">
                                            <option value="">Umum</option>
                                            @foreach($periods as $period)
                                                <option value="{{ $period->data1 }}" {{ old('period') == $period->data1 ? 'selected' : '' }}>
                                                    {{ $period->data1 }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Gambar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="news-form-image-preview-container mb-3">
                                        <img id="imagePreview" class="news-form-image-preview" src="" alt="Preview">
                                        <button type="button" class="news-form-remove-image" id="removeImage">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    <small class="text-muted">Max: 2MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attachment -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Lampiran</h5>
                                </div>
                                <div class="card-body">
                                    <div id="fileInfo" class="alert alert-secondary mb-3" style="display: none;">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-file-text-line me-2 fs-4"></i>
                                            <div>
                                                <div id="fileName" class="fw-medium"></div>
                                                <small id="fileSize" class="text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Max: 5MB</small>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="ri-save-line me-1"></i> Simpan Pengumuman
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('assets/admin/js/pages/announcement-form.js') }}"></script>
@endsection
