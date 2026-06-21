@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Edit Berita</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-check-line me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $news->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug URL</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $news->slug) }}" placeholder="auto-generate-dari-judul">
                                <small class="text-muted">URL-friendly version. Auto-generate dari judul, atau edit manual.</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                <div id="editor" data-ckeditor data-ckeditor-upload-url="/admin/news/upload-image" data-ckeditor-content="{{ old('content', $news->content) }}"></div>
                                <textarea name="content" id="content" class="d-none" required>{{ old('content', $news->content) }}</textarea>
                                <div id="contentError" class="text-danger small" style="display: none;">Konten wajib diisi.</div>
                                @error('content')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Ringkasan</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" maxlength="500">{{ old('excerpt', $news->excerpt) }}</textarea>
                                <small class="text-muted">Maksimal 500 karakter</small>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SEO Section -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">SEO Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $news->meta_title) }}" maxlength="255">
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $news->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Status -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Publish</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 d-block">
                                        <label for="news_status" class="form-label d-block">Status <span class="text-danger">*</span></label>
                                        <select class="form-select d-block @error('status') is-invalid @enderror" id="news_status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="archived" {{ old('status', $news->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Kategori</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
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
                                                <option value="{{ $j->id }}" {{ old('jurusan_id', $news->jurusan_id) == $j->id ? 'selected' : '' }}>
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
                                        <label for="period" class="form-label">Period</label>
                                        <select class="form-select @error('period') is-invalid @enderror" id="period" name="period">
                                            <option value="">Umum (Tidak terikat period)</option>
                                            @foreach($periods as $period)
                                                <option value="{{ $period->data1 }}" {{ old('period', $news->period) == $period->data1 ? 'selected' : '' }}>
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
                                    @if($news->image)
                                        <div class="mb-3 text-center" id="existingImageContainer">
                                            <img src="{{ asset('storage/' . $news->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                            <p class="text-muted small mt-2">Gambar saat ini</p>
                                            <button type="button" class="btn btn-sm btn-danger mt-2" id="deleteExistingImage" data-news-id="{{ $news->id }}">
                                                <i class="ri-delete-bin-line"></i> Hapus Gambar
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <div class="alert alert-info" role="alert">
                                        <strong>Info:</strong> Max file size: <b>2 MB</b>. Format: JPG, PNG, GIF.
                                    </div>
                                    
                                    <div class="news-form-image-preview-container mb-3">
                                        <img id="imagePreview" class="news-form-image-preview" src="" alt="Preview">
                                        <button type="button" class="news-form-remove-image" id="removeImage">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    
                                    <div id="imageInputContainer" style="display: {{ $news->image ? 'none' : 'block' }};">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <input type="hidden" id="deleteImageFlag" name="delete_image" value="0">
                                </div>
                            </div>

                            <!-- File Attachment -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Lampiran</h5>
                                </div>
                                <div class="card-body">
                                    @if($news->file)
                                        <div class="mb-3" id="existingFileContainer">
                                            <label class="form-label fw-medium">File Saat Ini:</label>
                                            <div class="alert alert-secondary d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center flex-grow-1">
                                                    <i class="ri-file-text-line me-2 fs-4"></i>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-medium">{{ basename($news->file) }}</div>
                                                        <small class="text-muted">File existing</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ asset('storage/' . $news->file) }}" class="btn btn-sm btn-info" download title="Download">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" id="deleteExistingFile" data-news-id="{{ $news->id }}" title="Hapus">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="alert alert-success" role="alert">
                                        <strong>Info:</strong> Max file size: <b>5 MB</b>. Format: PDF, DOC, DOCX.
                                    </div>
                                    
                                    <div id="fileInfo" class="alert alert-secondary mb-3" style="display: none;">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-file-text-line me-2 fs-4"></i>
                                            <div>
                                                <div id="fileName" class="fw-medium"></div>
                                                <small id="fileSize" class="text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="fileInputContainer" style="display: {{ $news->file ? 'none' : 'block' }};">
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <input type="hidden" id="deleteFileFlag" name="delete_file" value="0">
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Informasi Tambahan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Penulis</label>
                                        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $news->author) }}" maxlength="100">
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="source" class="form-label">Sumber</label>
                                        <input type="text" class="form-control @error('source') is-invalid @enderror" id="source" name="source" value="{{ old('source', $news->source) }}" maxlength="255">
                                        @error('source')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags', $news->tags) }}" data-choices data-choices-removeItem placeholder="Ketik dan tekan Enter untuk menambah tag">
                                        <small class="text-muted">Tekan Enter setelah mengetik tag</small>
                                        @error('tags')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        
                                        <!-- Recommended Tags -->
                                        <div class="mt-3">
                                            <label class="form-label small text-muted">Rekomendasi Tags:</label>
                                            <div class="d-flex flex-wrap gap-2" id="recommendedTags">
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Kesiswaan">Kesiswaan</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Kurikulum">Kurikulum</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Prestasi">Prestasi</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="PPDB">PPDB</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="OSIS">OSIS</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Prakerin">Prakerin</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Lomba">Lomba</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Pramuka">Pramuka</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Kegiatan Sekolah">Kegiatan Sekolah</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary tag-suggestion" data-tag="Ujian">Ujian</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary" id="cancelBtn">Batal</a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="d-flex align-items-center">
                                        <i class="ri-save-line align-middle me-1"></i>
                                        <span>Update Berita</span>
                                    </span>
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
<script src="{{ asset('assets/admin/js/pages/news-form.js') }}"></script>
@endsection
