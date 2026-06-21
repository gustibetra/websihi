<div wire:key="announcement-manager-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="categoryFilter" 
                        class="form-select">
                    <option value="all" {{ $categoryFilter == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryFilter == $category->id ? 'selected' : '' }}>
                            {{ $category->data1 }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="jurusanFilter" 
                        class="form-select" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                    @if(!auth()->user()->isAdminJurusan())
                        <option value="all" {{ $jurusanFilter == 'all' ? 'selected' : '' }}>Semua Jurusan/Umum</option>
                        <option value="umum" {{ $jurusanFilter == 'umum' ? 'selected' : '' }}>Umum</option>
                    @endif
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ $jurusanFilter == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }} ({{ $j->singkatan }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="periodFilter" 
                        class="form-select">
                    <option value="all" {{ $periodFilter == 'all' ? 'selected' : '' }}>Semua Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->data1 }}" {{ $periodFilter == $period->data1 ? 'selected' : '' }}>
                            {{ $period->data1 }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="statusFilter" 
                        class="form-select">
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $statusFilter == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-soft-primary btn-sm">
                <i class="ri-add-fill align-bottom"></i> Tambah
            </a>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="alert alert-info mb-3" id="bulkActionsBar" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="selectedCount">0</strong> pengumuman dipilih
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-primary" onclick="handleBulkUpdateStatus(1)">
                    <i class="ri-checkbox-circle-line"></i> Aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="handleBulkUpdateStatus(0)">
                    <i class="ri-close-circle-line"></i> Nonaktifkan
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="handleBulkDelete()">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div wire:ignore class="flash-message-success" data-message="{{ session('message') }}"></div>
    @endif

    @if (session()->has('error'))
        <div wire:ignore class="flash-message-error" data-message="{{ session('error') }}"></div>
    @endif

    <!-- Table -->
    <div class="table-responsive table-card mb-2 mt-2 border border-top-dashed">
        <table class="table align-middle table-nowrap mb-0 table-striped table-sm">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 50px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                        </div>
                    </th>
                    <th scope="col" style="width: 80px;">
                        <a href="#" wire:click.prevent="sortByColumn('id')" class="text-body text-decoration-none">
                            ID
                            @if($sortBy === 'id')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('title')" class="text-body text-decoration-none">
                            Judul
                            @if($sortBy === 'title')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 150px;">Kategori</th>
                    {{-- Hidden for now - may be used later
                    <th scope="col" style="width: 180px;">
                        <a href="#" wire:click.prevent="sortByColumn('start_date')" class="text-body text-decoration-none">
                            Tanggal Mulai
                            @if($sortBy === 'start_date')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    --}}
                    <th scope="col" style="width: 120px;">Periode</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 200px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                    <tr wire:key="announcement-{{ $announcement->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input announcement-checkbox" type="checkbox" value="{{ $announcement->id }}" data-announcement-id="{{ $announcement->id }}">
                            </div>
                        </td>
                        <td>{{ $announcement->id }}</td>
                        <td>
                            <strong>{{ $announcement->title }}</strong>
                            @if($announcement->excerpt)
                                <br><small class="text-muted">{{ Str::limit($announcement->excerpt, 60) }}</small>
                            @endif
                        </td>
                        <td>
                             @if($announcement->category)
                                 <span class="badge bg-info-subtle text-info">{{ $announcement->category->data1 }}</span>
                             @else
                                 -
                             @endif
                             @if($announcement->jurusan)
                                 <div class="mt-1">
                                     <span class="badge bg-warning-subtle text-warning">{{ $announcement->jurusan->singkatan }}</span>
                                 </div>
                             @else
                                 <div class="mt-1">
                                     <span class="badge bg-light text-dark">Umum</span>
                                 </div>
                             @endif
                        </td>
                        {{-- Hidden for now - may be used later
                        <td>
                            @if($announcement->start_date)
                                {{ $announcement->start_date->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        --}}
                        <td>{{ $announcement->period ?? '-' }}</td>
                        <td class="text-center">
                            @if($announcement->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($announcement->is_active)
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-warning" 
                                            wire:click="toggleStatus({{ $announcement->id }})"
                                            title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-success" 
                                            wire:click="toggleStatus({{ $announcement->id }})"
                                            title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" 
                                        class="btn btn-sm btn-soft-secondary" 
                                        wire:click="openInfoModal({{ $announcement->id }})"
                                        title="Info Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                   class="btn btn-sm btn-soft-primary" 
                                   title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-danger" 
                                        onclick="confirmDelete({{ $announcement->id }}, '{{ $announcement->title }}')"
                                        title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-megaphone-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data pengumuman</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($announcements && $announcements->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <div wire:ignore style="min-width: 60px;">
                        <select id="perPageFilter" 
                                class="form-select form-select-sm per-page-select">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">|</span>
                <div class="text-muted">
                    Menampilkan {{ $announcements->firstItem() }} - {{ $announcements->lastItem() }} / {{ $announcements->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $announcements->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif


    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0">
                    <div class="modal-body">
                        <form wire:submit.prevent="save" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="px-1 pt-1">
                                        <!-- Cover Image -->
                                        <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                                            <img src="{{ asset('assets/admin/images/small/img-9.jpg') }}" alt="" class="img-fluid">
                                            
                                            <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                                <div class="flex-grow-1">
                                                    <h5 class="modal-title text-white">
                                                        @if($editMode)
                                                            Edit Pengumuman
                                                        @else
                                                            Tambah Pengumuman Baru
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Fields in 2 Columns -->
                                    <div class="row mt-3">
                                        <!-- Left Column -->
                                        <div class="col-md-8">
                                            <!-- Title -->
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control @error('form.title') is-invalid @enderror" 
                                                       id="title"
                                                       wire:model.blur="form.title"
                                                       placeholder="Masukkan judul pengumuman">
                                                @error('form.title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Slug -->
                                            <div class="mb-3">
                                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control @error('form.slug') is-invalid @enderror" 
                                                       id="slug"
                                                       wire:model.blur="form.slug"
                                                       placeholder="slug-url">
                                                <small class="text-muted">Auto-generate dari judul, atau edit manual</small>
                                                @error('form.slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Content with CKEditor -->
                                            <div class="mb-3">
                                                <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                                <div id="editor" data-ckeditor data-ckeditor-upload-url="/admin/announcements/upload-image" data-ckeditor-content="{{ $form['content'] ?? '' }}"></div>
                                                <textarea name="content" id="content" class="d-none" wire:model="form.content">{{ $form['content'] ?? '' }}</textarea>
                                                <div id="contentError" class="text-danger small" style="display: none;">Konten wajib diisi.</div>
                                                @error('form.content')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Excerpt -->
                                            <div class="mb-3">
                                                <label for="excerpt" class="form-label">Ringkasan</label>
                                                <textarea class="form-control" 
                                                          id="excerpt"
                                                          wire:model="form.excerpt"
                                                          rows="2"
                                                          placeholder="Masukkan ringkasan singkat"></textarea>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-4">
                                            <!-- Category -->
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Kategori</label>
                                                <select class="form-select" 
                                                        id="category_id"
                                                        wire:model="form.category_id">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->data1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Jurusan -->
                                            <div class="mb-3">
                                                <label for="jurusan_id" class="form-label">Jurusan</label>
                                                <select class="form-select" 
                                                        id="jurusan_id"
                                                        wire:model="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                                    @if(!auth()->user()->isAdminJurusan())
                                                        <option value="">Umum (Semua Jurusan)</option>
                                                    @endif
                                                    @foreach($jurusans as $j)
                                                        <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->singkatan }})</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Period -->
                                            <div class="mb-3">
                                                <label for="period" class="form-label">Periode</label>
                                                <select class="form-select" 
                                                        id="period"
                                                        wire:model="form.period">
                                                    <option value="">Pilih Periode</option>
                                                    @foreach($periods as $period)
                                                        <option value="{{ $period->key1 }}">{{ $period->key1 }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        {{-- Hidden for now - may be used later
                                        <!-- Start Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                                            <input type="date" 
                                                   class="form-control @error('form.start_date') is-invalid @enderror" 
                                                   id="start_date"
                                                   wire:model="form.start_date">
                                            @error('form.start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- End Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                                            <input type="date" 
                                                   class="form-control @error('form.end_date') is-invalid @enderror" 
                                                   id="end_date"
                                                   wire:model="form.end_date">
                                            @error('form.end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        --}}


                                            <!-- Image Upload -->
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Gambar</label>
                                                <input type="file" 
                                                       class="form-control @error('image') is-invalid @enderror" 
                                                       id="image"
                                                       wire:model="image"
                                                       accept="image/*">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if($currentImage && !$image)
                                                    <small class="text-muted">Current: {{ basename($currentImage) }}</small>
                                                @endif
                                            </div>

                                            <!-- Attachment Upload -->
                                            <div class="mb-3">
                                                <label for="attachment" class="form-label">Lampiran</label>
                                                <input type="file" 
                                                       class="form-control @error('attachment') is-invalid @enderror" 
                                                       id="attachment"
                                                       wire:model="attachment">
                                                @error('attachment')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if($currentAttachment && !$attachment)
                                                    <small class="text-muted">Current: {{ basename($currentAttachment) }}</small>
                                                @endif
                                            </div>

                                            <!-- Status Checkboxes -->
                                            <div class="mb-3">
                                                <label class="form-label d-block">Status</label>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           id="is_public"
                                                           wire:model="form.is_public">
                                                    <label class="form-check-label" for="is_public">
                                                        Publik
                                                    </label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           id="is_active"
                                                           wire:model="form.is_active">
                                                    <label class="form-check-label" for="is_active">
                                                        Aktif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-soft-success" wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                @if($editMode)
                                                    Update Pengumuman
                                                @else
                                                    Tambah Pengumuman
                                                @endif
                                            </span>
                                            <span wire:loading>
                                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                                Menyimpan...
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
        <div class="modal-backdrop fade show"></div>
    @endif


    <!-- Info Modal -->
    @if($showInfoModal && $selectedAnnouncement)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-megaphone-line me-2"></i>Informasi Detail Pengumuman
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mb-3">{{ $selectedAnnouncement->title }}</h4>
                                
                                <!-- Image Section -->
                                @if($selectedAnnouncement->image)
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label text-muted small">Gambar:</label>
                                            <div class="border rounded p-2">
                                                <img src="{{ asset('storage/' . $selectedAnnouncement->image) }}" 
                                                     alt="Gambar Pengumuman" 
                                                     class="img-fluid rounded"
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <td width="30%" class="text-muted"><i class="ri-hashtag me-2"></i>ID</td>
                                                <td><strong>{{ $selectedAnnouncement->id }}</strong></td>
                                            </tr>
                                            @if($selectedAnnouncement->category)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-price-tag-3-line me-2"></i>Kategori</td>
                                                    <td><span class="badge bg-info-subtle text-info">{{ $selectedAnnouncement->category->data1 }}</span></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted"><i class="ri-git-branch-line me-2"></i>Jurusan</td>
                                                <td>
                                                    @if($selectedAnnouncement->jurusan)
                                                        <span class="badge bg-warning-subtle text-warning">{{ $selectedAnnouncement->jurusan->nama }} ({{ $selectedAnnouncement->jurusan->singkatan }})</span>
                                                    @else
                                                        <span class="badge bg-light text-dark">Umum</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- Hidden for now - may be used later
                                            <tr>
                                                <td class="text-muted"><i class="ri-calendar-line me-2"></i>Tanggal Mulai</td>
                                                <td>
                                                    @if($selectedAnnouncement->start_date)
                                                        {{ $selectedAnnouncement->start_date->format('d M Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($selectedAnnouncement->end_date)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-calendar-line me-2"></i>Tanggal Selesai</td>
                                                    <td>{{ $selectedAnnouncement->end_date->format('d M Y') }}</td>
                                                </tr>
                                            @endif
                                            --}}
                                            @if($selectedAnnouncement->period)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-calendar-line me-2"></i>Periode</td>
                                                    <td><span class="badge bg-info-subtle text-info">{{ $selectedAnnouncement->period }}</span></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted"><i class="ri-checkbox-circle-line me-2"></i>Status</td>
                                                <td>
                                                    @if($selectedAnnouncement->is_active)
                                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                                    @endif
                                                    @if($selectedAnnouncement->is_public)
                                                        <span class="badge bg-info-subtle text-info">Publik</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($selectedAnnouncement->attachment)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-attachment-line me-2"></i>Lampiran</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $selectedAnnouncement->attachment) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-soft-primary">
                                                            <i class="ri-download-line me-1"></i>
                                                            Download File
                                                        </a>
                                                        <small class="text-muted d-block mt-1">{{ basename($selectedAnnouncement->attachment) }}</small>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($selectedAnnouncement->excerpt)
                                                <tr>
                                                    <td colspan="2"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted"><i class="ri-file-list-line me-2"></i>Ringkasan</td>
                                                    <td>{{ $selectedAnnouncement->excerpt }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedAnnouncement->content)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-file-text-line me-2"></i>Konten</td>
                                                    <td>{!! $selectedAnnouncement->content !!}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-secondary" wire:click="$set('showInfoModal', false)">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

@push('scripts')
<!-- Load CKEditor library -->
<script src="{{ asset('assets/admin/libs/ckeditor5/build/ckeditor.js') }}"></script>
<!-- Announcement Manager Script -->
<script src="{{ asset('assets/admin/js/pages/announcement-manager.js') }}"></script>
@endpush
