@extends('layouts.admin')

@section('title', isset($page) ? 'Edit Halaman' : 'Tambah Halaman')
@section('page-title', isset($page) ? 'Edit Halaman' : 'Tambah Halaman')
@section('breadcrumb-parent', 'Halaman')
@section('breadcrumb-current', isset($page) ? 'Edit' : 'Tambah')

@section('content')
<form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      id="pageForm">
    @csrf
    @if(isset($page))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Halaman</h5>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title"
                               name="title"
                               value="{{ old('title', $page->title ?? '') }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug"
                               name="slug"
                               value="{{ old('slug', $page->slug ?? '') }}"
                               required>
                        <small class="text-muted">Auto-generate dari judul, atau edit manual</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Sub Judul</label>
                        <input type="text" 
                               class="form-control" 
                               id="subtitle"
                               name="subtitle"
                               value="{{ old('subtitle', $page->subtitle ?? '') }}">
                    </div>

                    <!-- Page Type -->
                    <div class="mb-3">
                        <label class="form-label">Tipe Halaman <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="page_type" 
                                       id="type_page" 
                                       value="page"
                                       {{ old('page_type', $page->page_type ?? 'page') === 'page' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_page">
                                    <i class="ri-file-text-line"></i> Page (Konten Biasa)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="page_type" 
                                       id="type_structure" 
                                       value="structure"
                                       {{ old('page_type', $page->page_type ?? '') === 'structure' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_structure">
                                    <i class="ri-organization-chart"></i> Structure (Link ke Struktur)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Content (for blog type) -->
                    <div class="mb-3" id="content_section">
                        <label for="content" class="form-label">Konten <span class="text-danger content-required">*</span></label>
                        <div id="editor" 
                             data-ckeditor 
                             data-ckeditor-upload-url="{{ route('admin.pages.upload-image') }}" 
                             data-ckeditor-content="{{ old('content', $page->content ?? '') }}"></div>
                        <textarea name="content" id="content" class="d-none">{{ old('content', $page->content ?? '') }}</textarea>
                        @error('content')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Structure Selection (for structure type) -->
                    <div class="mb-3 d-none" id="structure_section">
                        <div class="alert alert-info">
                            <i class="ri-information-line"></i> 
                            <strong>Mode Structure:</strong> Pilih tipe struktur, lalu pilih struktur spesifik atau tampilkan semua struktur dengan tipe tersebut.
                        </div>

                        <!-- Tipe Struktur -->
                        <div class="mb-3">
                            <label for="structure_type" class="form-label">Tipe Struktur <span class="text-danger">*</span></label>
                            <select class="form-select @error('structure_type') is-invalid @enderror" 
                                    id="structure_type"
                                    name="structure_type">
                                <option value="">-- Pilih Tipe Struktur --</option>
                                <option value="yayasan" {{ old('structure_type', $page->structure_type ?? '') === 'yayasan' ? 'selected' : '' }}>Struktur Yayasan</option>
                                <option value="sekolah" {{ old('structure_type', $page->structure_type ?? '') === 'sekolah' ? 'selected' : '' }}>Organisasi Sekolah</option>
                                <option value="organisasi" {{ old('structure_type', $page->structure_type ?? '') === 'organisasi' ? 'selected' : '' }}>Organisasi Siswa</option>
                                <option value="ekskul" {{ old('structure_type', $page->structure_type ?? '') === 'ekskul' ? 'selected' : '' }}>Ekstrakurikuler</option>
                                <option value="kepanitiaan" {{ old('structure_type', $page->structure_type ?? '') === 'kepanitiaan' ? 'selected' : '' }}>Kepanitiaan</option>
                            </select>
                            @error('structure_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilih Struktur Spesifik -->
                        <div class="mb-3">
                            <label for="structure_common_id" class="form-label">Pilih Struktur <span class="text-danger" id="structure_required">*</span></label>
                            <select class="form-select @error('structure_common_id') is-invalid @enderror" 
                                    id="structure_common_id"
                                    name="structure_common_id">
                                <option value="">-- Pilih Struktur --</option>
                                @foreach($structures ?? [] as $structure)
                                    <option value="{{ $structure->id }}"
                                            data-type="{{ $structure->data5 }}"
                                            data-period="{{ $structure->period->data1 ?? '' }}"
                                            {{ old('structure_common_id', $page->structure_common_id ?? '') == $structure->id ? 'selected' : '' }}>
                                        {{ $structure->data1 }} @if($structure->period) - {{ $structure->period->data1 }} @endif ({{ ucfirst($structure->data5) }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Daftar struktur akan difilter berdasarkan tipe dan periode yang dipilih</small>
                            @error('structure_common_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Checkbox Tampilkan Semua -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="show_all_structures" 
                                       name="show_all_structures"
                                       value="1"
                                       {{ old('show_all_structures', (isset($page) && !$page->structure_common_id && $page->structure_type) ? '1' : '') ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_all_structures">
                                    <strong>Tampilkan Semua Struktur</strong> dengan tipe yang dipilih
                                </label>
                            </div>
                            <small class="text-muted">Jika dicentang, halaman akan menampilkan semua struktur dengan tipe yang dipilih (struktur spesifik tidak perlu dipilih)</small>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control" 
                                  id="excerpt"
                                  name="excerpt"
                                  rows="3">{{ old('excerpt', $page->excerpt ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Period Card -->
            <div class="card border">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Periode</h5>
                </div>
                <div class="card-body">
                    <label for="period_select" class="form-label">Periode</label>
                    <select class="form-select @error('period') is-invalid @enderror" 
                            id="period_select"
                            name="period">
                        <option value="">Pilih Periode (Opsional)</option>
                        @foreach($periods ?? [] as $period)
                            <option value="{{ $period->data1 }}"
                                    {{ old('period', $page->period ?? '') === $period->data1 ? 'selected' : '' }}>
                                {{ $period->data1 }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Periode untuk halaman ini</small>
                    @error('period')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Jurusan Card -->
            <div class="card border mt-3">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Jurusan</h5>
                </div>
                <div class="card-body">
                    <label for="jurusan_id" class="form-label">Jurusan</label>
                    <select class="form-select @error('jurusan_id') is-invalid @enderror" 
                            id="jurusan_id"
                            name="jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                        @if(!auth()->user()->isAdminJurusan())
                            <option value="">Umum (Semua Jurusan)</option>
                        @endif
                        @foreach($jurusans ?? [] as $j)
                            <option value="{{ $j->id }}"
                                    {{ old('jurusan_id', $page->jurusan_id ?? auth()->user()->jurusan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }} ({{ $j->singkatan }})
                            </option>
                        @endforeach
                    </select>
                    @if(auth()->user()->isAdminJurusan())
                        <input type="hidden" name="jurusan_id" value="{{ auth()->user()->jurusan_id }}">
                    @endif
                    <small class="text-muted">Tentukan jika halaman ini spesifik jurusan</small>
                    @error('jurusan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Status Card -->
            <div class="card border mt-3">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_public"
                                   name="is_public"
                                   value="1"
                                   {{ old('is_public', $page->is_public ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">
                                Publik
                            </label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Card -->
            <div class="card border">
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
                    
                    @if(isset($page) && $page->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $page->image) }}" class="img-thumbnail" style="max-height: 100px;">
                            <p class="text-muted small mt-1">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image"
                           name="image"
                           accept="image/*">
                    <small class="text-muted">Max: 2MB</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Attachment Card -->
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
                    
                    @if(isset($page) && $page->attachment)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $page->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="ri-file-line"></i> {{ basename($page->attachment) }}
                            </a>
                        </div>
                    @endif
                    <input type="file" 
                           class="form-control @error('attachment') is-invalid @enderror" 
                           id="attachment"
                           name="attachment"
                           accept=".pdf,.doc,.docx">
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
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="ri-save-line me-1"></i> {{ isset($page) ? 'Update Halaman' : 'Simpan Halaman' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/pages/page-form.js') }}"></script>
@endpush
