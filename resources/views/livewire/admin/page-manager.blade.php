<div wire:key="page-manager-component" class="page-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari halaman..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="typeFilter" 
                        class="form-select choices-init-hide"
                        data-choices
                        data-choices-search-false>
                    <option value="all" {{ $typeFilter == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="page" {{ $typeFilter == 'page' ? 'selected' : '' }}>Page</option>
                    <option value="structure" {{ $typeFilter == 'structure' ? 'selected' : '' }}>Structure</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="jurusanFilter" 
                        class="form-select choices-init-hide"
                        data-choices
                        data-choices-search-false>
                    <option value="all" {{ $jurusanFilter == 'all' ? 'selected' : '' }}>Semua Jurusan/Umum</option>
                    <option value="umum" {{ $jurusanFilter == 'umum' ? 'selected' : '' }}>Umum</option>
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
                        class="form-select choices-init-hide"
                        data-choices
                        data-choices-search-false>
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
                        class="form-select choices-init-hide" 
                        data-choices
                        data-choices-search-false>
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $statusFilter == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-soft-primary btn-sm w-100">
                <i class="ri-add-fill align-bottom"></i> Tambah Halaman
            </a>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="alert alert-info mb-3" id="bulkActionsBar" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="selectedCount">0</strong> halaman dipilih
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
                    <th scope="col" style="width: 120px;">Tipe</th>
                    <th scope="col" style="width: 180px;">Struktur</th>
                    <th scope="col" style="width: 150px;">Jurusan</th>
                    <th scope="col" style="width: 120px;">Periode</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 200px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr wire:key="page-{{ $page->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input page-checkbox" type="checkbox" value="{{ $page->id }}" data-page-id="{{ $page->id }}">
                            </div>
                        </td>
                        <td>{{ $page->id }}</td>
                        <td>
                            <strong>{{ $page->title }}</strong>
                            @if($page->subtitle)
                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($page->subtitle, 60) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($page->page_type === 'page')
                                <span class="badge bg-primary-subtle text-primary">Page</span>
                            @else
                                <span class="badge bg-info-subtle text-info">Structure</span>
                            @endif
                        </td>
                        <td>
                            @if($page->page_type === 'structure')
                                @if($page->structure_common_id && $page->structure)
                                    <small class="text-muted">{{ $page->structure->data1 }}</small>
                                @else
                                    <small class="text-muted">Semua {{ ucfirst($page->structure_type) }}</small>
                                  @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                             @if($page->jurusan)
                                 <span class="badge bg-warning-subtle text-warning">{{ $page->jurusan->singkatan }}</span>
                             @else
                                 <span class="badge bg-light text-dark">Umum</span>
                             @endif
                        </td>
                        <td>{{ $page->period ?? '-' }}</td>
                        <td class="text-center">
                            @if($page->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" 
                                        class="btn btn-sm btn-soft-info" 
                                        wire:click="openInfoModal({{ $page->id }})"
                                        title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                @if($page->is_active)
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-warning" 
                                            wire:click="toggleStatus({{ $page->id }})"
                                            title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-success" 
                                            wire:click="toggleStatus({{ $page->id }})"
                                            title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <a href="{{ route('admin.pages.edit', $page->id) }}" 
                                   class="btn btn-sm btn-soft-primary" 
                                   title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-danger" 
                                        onclick="confirmDelete({{ $page->id }}, '{{ addslashes($page->title) }}')"
                                        title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-file-list-3-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data halaman</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pages && $pages->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <div wire:ignore style="min-width: 60px;">
                        <select id="perPageFilter" 
                                class="form-select form-select-sm choices-init-hide per-page-select" 
                                data-choices
                                data-choices-search-false>
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
                    Menampilkan {{ $pages->firstItem() }} - {{ $pages->lastItem() }} / {{ $pages->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $pages->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Info Modal -->
    @if($showInfoModal && $selectedPage)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-eye-line me-2"></i> Detail Halaman
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Judul:</label>
                                <p>{{ $selectedPage->title }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Slug:</label>
                                <p><code>{{ $selectedPage->slug }}</code></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Halaman:</label>
                                <p>
                                    @if($selectedPage->page_type === 'page')
                                        <span class="badge bg-primary-subtle text-primary">Page</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info">Structure</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jurusan:</label>
                                <p>
                                    @if($selectedPage->jurusan)
                                        <span class="badge bg-warning-subtle text-warning">{{ $selectedPage->jurusan->nama }} ({{ $selectedPage->jurusan->singkatan }})</span>
                                    @else
                                        <span class="badge bg-light text-dark">Umum</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Periode:</label>
                                <p>{{ $selectedPage->period ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p>
                                    @if($selectedPage->is_active)
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                    @endif
                                    @if($selectedPage->is_public)
                                        <span class="badge bg-info-subtle text-info ms-1">Publik</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning ms-1">Private</span>
                                    @endif
                                </p>
                            </div>
                            @if($selectedPage->subtitle)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Sub Judul:</label>
                                    <p>{{ $selectedPage->subtitle }}</p>
                                </div>
                            @endif
                            @if($selectedPage->excerpt)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Ringkasan:</label>
                                    <p>{{ $selectedPage->excerpt }}</p>
                                </div>
                            @endif
                            @if($selectedPage->page_type === 'page' && $selectedPage->content)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Konten:</label>
                                    <div class="border p-3 rounded bg-light" style="max-height: 300px; overflow-y: auto;">
                                        {!! $selectedPage->content !!}
                                    </div>
                                </div>
                            @endif
                            @if($selectedPage->page_type === 'structure')
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Konfigurasi Structure:</label>
                                    <ul class="list-unstyled">
                                        <li><strong>Tipe Struktur:</strong> {{ ucfirst($selectedPage->structure_type) }}</li>
                                        @if($selectedPage->structure_common_id && $selectedPage->structure)
                                            <li><strong>Struktur Spesifik:</strong> {{ $selectedPage->structure->data1 }}</li>
                                        @else
                                            <li><strong>Mode:</strong> Tampilkan Semua Struktur dengan tipe {{ ucfirst($selectedPage->structure_type) }}</li>
                                        @endif
                                        @if($selectedPage->period)
                                            <li><strong>Periode:</strong> {{ $selectedPage->period }}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if($selectedPage->image)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Gambar:</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $selectedPage->image) }}" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                            @if($selectedPage->attachment)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Lampiran:</label>
                                    <div>
                                        <a href="{{ asset('storage/' . $selectedPage->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="ri-file-line"></i> Lihat Lampiran
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <strong>Dibuat:</strong> {{ $selectedPage->created_at->format('d M Y H:i') }}
                                    @if($selectedPage->creator)
                                        oleh {{ $selectedPage->creator->name }}
                                    @endif
                                    <br>
                                    <strong>Diupdate:</strong> {{ $selectedPage->updated_at->format('d M Y H:i') }}
                                    @if($selectedPage->updater)
                                        oleh {{ $selectedPage->updater->name }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.pages.edit', $selectedPage->id) }}" class="btn btn-primary">
                            <i class="ri-pencil-line me-1"></i> Edit Halaman
                        </a>
                        <button type="button" class="btn btn-secondary" wire:click="$set('showInfoModal', false)">
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
<script src="{{ asset('assets/admin/js/pages/page-manager.js') }}"></script>
@endpush
