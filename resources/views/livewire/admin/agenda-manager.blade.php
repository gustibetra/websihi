<div wire:key="agenda-manager-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari agenda..." 
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
            <button class="btn btn-soft-primary btn-sm w-100" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Agenda
            </button>
        </div>
    </div>


    <!-- Bulk Actions Bar -->
    <div class="alert alert-info mb-3" id="bulkActionsBar" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="selectedCount">0</strong> agenda dipilih
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
                    <th scope="col" style="width: 200px;">Lokasi</th>
                    <th scope="col" style="width: 180px;">
                        <a href="#" wire:click.prevent="sortByColumn('start_datetime')" class="text-body text-decoration-none">
                            Waktu Mulai
                            @if($sortBy === 'start_datetime')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 150px;">Kategori</th>
                    <th scope="col" style="width: 100px;">Periode</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 200px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendas as $agenda)
                    <tr wire:key="agenda-{{ $agenda->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input agenda-checkbox" type="checkbox" value="{{ $agenda->id }}" data-agenda-id="{{ $agenda->id }}">
                            </div>
                        </td>
                        <td>{{ $agenda->id }}</td>
                        <td>
                            <strong>{{ $agenda->title }}</strong>
                            @if($agenda->excerpt)
                                <br><small class="text-muted">{{ Str::limit($agenda->excerpt, 60) }}</small>
                            @endif
                        </td>
                        <td>{{ $agenda->location ?? '-' }}</td>
                        <td>
                            @if($agenda->start_datetime)
                                {{ $agenda->start_datetime->format('d M Y, H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                             @if($agenda->category)
                                 <span class="badge bg-info-subtle text-info">{{ $agenda->category->data1 }}</span>
                             @else
                                 -
                             @endif
                             @if($agenda->jurusan)
                                 <div class="mt-1">
                                     <span class="badge bg-warning-subtle text-warning">{{ $agenda->jurusan->singkatan }}</span>
                                 </div>
                             @else
                                 <div class="mt-1">
                                     <span class="badge bg-light text-dark">Umum</span>
                                 </div>
                             @endif
                        </td>
                        <td>{{ $agenda->period ?? '-' }}</td>
                        <td class="text-center">
                            @if($agenda->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($agenda->is_active)
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-warning" 
                                            wire:click="toggleStatus({{ $agenda->id }})"
                                            title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-success" 
                                            wire:click="toggleStatus({{ $agenda->id }})"
                                            title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" 
                                        class="btn btn-sm btn-soft-secondary" 
                                        wire:click="openInfoModal({{ $agenda->id }})"
                                        title="Info Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-primary" 
                                        wire:click="openEditModal({{ $agenda->id }})"
                                        title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-danger" 
                                        onclick="confirmDelete({{ $agenda->id }}, '{{ $agenda->title }}')"
                                        title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-calendar-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data agenda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($agendas && $agendas->count() > 0)
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
                    Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }} / {{ $agendas->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $agendas->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif


    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                                            Edit Agenda
                                                        @else
                                                            Tambah Agenda Baru
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
                                        <!-- Title -->
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('form.title') is-invalid @enderror" 
                                                   id="title"
                                                   wire:model.live="form.title"
                                                   placeholder="Masukkan judul agenda">
                                            @error('form.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Slug -->
                                        <div class="col-md-12 mb-3">
                                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('form.slug') is-invalid @enderror" 
                                                   id="slug"
                                                   wire:model="form.slug"
                                                   placeholder="slug-url">
                                            @error('form.slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Location -->
                                        <div class="col-md-6 mb-3">
                                            <label for="location" class="form-label">Lokasi</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="location"
                                                   wire:model="form.location"
                                                   placeholder="Masukkan lokasi">
                                        </div>

                                        <!-- Period -->
                                        <div class="col-md-6 mb-3">
                                            <label for="period" class="form-label">Periode</label>
                                            <select class="form-select" 
                                                    id="period"
                                                    wire:model="form.period">
                                                <option value="">Pilih Periode</option>
                                                @foreach($periods as $period)
                                                    <option value="{{ $period->data1 }}">{{ $period->data1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6 mb-3">
                                            <label for="category_id" class="form-label">Kategori</label>
                                            <select class="form-select @error('form.category_id') is-invalid @enderror" 
                                                    id="category_id"
                                                    wire:model="form.category_id">
                                                <option value="">Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->data1 }}</option>
                                                @endforeach
                                            </select>
                                            @error('form.category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Jurusan -->
                                        <div class="col-md-6 mb-3">
                                            <label for="jurusan_id" class="form-label">Jurusan</label>
                                            <select class="form-select @error('form.jurusan_id') is-invalid @enderror" 
                                                    id="jurusan_id"
                                                    wire:model="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                                @if(!auth()->user()->isAdminJurusan())
                                                    <option value="">Umum (Semua Jurusan)</option>
                                                @endif
                                                @foreach($jurusans as $j)
                                                    <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->singkatan }})</option>
                                                @endforeach
                                            </select>
                                            @error('form.jurusan_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Start DateTime -->
                                        <div class="col-md-6 mb-3">
                                            <label for="start_datetime" class="form-label">Waktu Mulai</label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('form.start_datetime') is-invalid @enderror" 
                                                   id="start_datetime"
                                                   wire:model="form.start_datetime">
                                            @error('form.start_datetime')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- End DateTime -->
                                        <div class="col-md-6 mb-3">
                                            <label for="end_datetime" class="form-label">Waktu Selesai</label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('form.end_datetime') is-invalid @enderror" 
                                                   id="end_datetime"
                                                   wire:model="form.end_datetime">
                                            @error('form.end_datetime')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Speaker -->
                                        <div class="col-md-6 mb-3">
                                            <label for="speaker" class="form-label">Pembicara</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="speaker"
                                                   wire:model="form.speaker"
                                                   placeholder="Masukkan nama pembicara">
                                        </div>

                                        <!-- Organizer -->
                                        <div class="col-md-6 mb-3">
                                            <label for="organizer" class="form-label">Penyelenggara</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="organizer"
                                                   wire:model="form.organizer"
                                                   placeholder="Masukkan penyelenggara">
                                        </div>

                                        <!-- Excerpt -->
                                        <div class="col-md-12 mb-3">
                                            <label for="excerpt" class="form-label">Ringkasan</label>
                                            <textarea class="form-control" 
                                                      id="excerpt"
                                                      wire:model="form.excerpt"
                                                      rows="2"
                                                      placeholder="Masukkan ringkasan singkat"></textarea>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Deskripsi</label>
                                            <div id="editor"
                                                 data-ckeditor
                                                 data-ckeditor-upload-url="/admin/news/upload-image"
                                                 data-ckeditor-content="{{ $form['description'] ?? '' }}"></div>
                                            <textarea class="d-none"
                                                      name="description"
                                                      id="description"
                                                      wire:model="form.description">{{ $form['description'] ?? '' }}</textarea>
                                            @error('form.description')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="col-md-4 mb-3">
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

                                        <!-- Banner Upload -->
                                        <div class="col-md-4 mb-3">
                                            <label for="banner" class="form-label">Banner</label>
                                            <input type="file" 
                                                   class="form-control @error('banner') is-invalid @enderror" 
                                                   id="banner"
                                                   wire:model="banner"
                                                   accept="image/*">
                                            @error('banner')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($currentBanner && !$banner)
                                                <small class="text-muted">Current: {{ basename($currentBanner) }}</small>
                                            @endif
                                        </div>

                                        <!-- Attachment Upload -->
                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Status</label>
                                            <div class="form-check form-switch" style="padding-top: 0.5rem;">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_public"
                                                       wire:model="form.is_public">
                                                <label class="form-check-label" for="is_public">
                                                    Publik
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">&nbsp;</label>
                                            <div class="form-check form-switch" style="padding-top: 0.5rem;">
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

                                    <!-- Buttons -->
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-soft-success" wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                @if($editMode)
                                                    Update Agenda
                                                @else
                                                    Tambah Agenda
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
    @if($showInfoModal && $selectedAgenda)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-calendar-line me-2"></i>Informasi Detail Agenda
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mb-3">{{ $selectedAgenda->title }}</h4>
                                
                                <!-- Images Section -->
                                @if($selectedAgenda->image || $selectedAgenda->banner)
                                    <div class="row mb-3">
                                        @if($selectedAgenda->image)
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label text-muted small">Gambar:</label>
                                                <div class="border rounded p-2">
                                                    <img src="{{ asset('storage/' . $selectedAgenda->image) }}" 
                                                         alt="Gambar Agenda" 
                                                         class="img-fluid rounded"
                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                </div>
                                            </div>
                                        @endif
                                        @if($selectedAgenda->banner)
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label text-muted small">Banner:</label>
                                                <div class="border rounded p-2">
                                                    <img src="{{ asset('storage/' . $selectedAgenda->banner) }}" 
                                                         alt="Banner Agenda" 
                                                         class="img-fluid rounded"
                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <td width="30%" class="text-muted"><i class="ri-hashtag me-2"></i>ID</td>
                                                <td><strong>{{ $selectedAgenda->id }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="ri-map-pin-line me-2"></i>Lokasi</td>
                                                <td>{{ $selectedAgenda->location ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="ri-time-line me-2"></i>Waktu Mulai</td>
                                                <td>
                                                    @if($selectedAgenda->start_datetime)
                                                        {{ $selectedAgenda->start_datetime->format('d M Y, H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="ri-time-line me-2"></i>Waktu Selesai</td>
                                                <td>
                                                    @if($selectedAgenda->end_datetime)
                                                        {{ $selectedAgenda->end_datetime->format('d M Y, H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($selectedAgenda->speaker)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-user-voice-line me-2"></i>Pembicara</td>
                                                    <td>{{ $selectedAgenda->speaker }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedAgenda->organizer)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-team-line me-2"></i>Penyelenggara</td>
                                                    <td>{{ $selectedAgenda->organizer }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedAgenda->category)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-price-tag-3-line me-2"></i>Kategori</td>
                                                    <td><span class="badge bg-info-subtle text-info">{{ $selectedAgenda->category->data1 }}</span></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted"><i class="ri-git-branch-line me-2"></i>Jurusan</td>
                                                <td>
                                                    @if($selectedAgenda->jurusan)
                                                        <span class="badge bg-warning-subtle text-warning">{{ $selectedAgenda->jurusan->nama }} ({{ $selectedAgenda->jurusan->singkatan }})</span>
                                                    @else
                                                        <span class="badge bg-light text-dark">Umum</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($selectedAgenda->period)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-calendar-line me-2"></i>Periode</td>
                                                    <td><span class="badge bg-info-subtle text-info">{{ $selectedAgenda->period }}</span></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted"><i class="ri-checkbox-circle-line me-2"></i>Status</td>
                                                <td>
                                                    @if($selectedAgenda->is_active)
                                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                                    @endif
                                                    @if($selectedAgenda->is_public)
                                                        <span class="badge bg-info-subtle text-info">Publik</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($selectedAgenda->attachment)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-attachment-line me-2"></i>Lampiran</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $selectedAgenda->attachment) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-soft-primary">
                                                            <i class="ri-download-line me-1"></i>
                                                            Download File
                                                        </a>
                                                        <small class="text-muted d-block mt-1">{{ basename($selectedAgenda->attachment) }}</small>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($selectedAgenda->excerpt)
                                                <tr>
                                                    <td colspan="2"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted"><i class="ri-file-list-line me-2"></i>Ringkasan</td>
                                                    <td>{{ $selectedAgenda->excerpt }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedAgenda->description)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-file-text-line me-2"></i>Deskripsi</td>
                                                    <td>{{ $selectedAgenda->description }}</td>
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
<script src="{{ asset('assets/admin/libs/ckeditor5/build/ckeditor.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/agenda-manager.js') }}"></script>
@endpush
