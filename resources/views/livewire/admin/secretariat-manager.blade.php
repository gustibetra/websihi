<div wire:key="secretariat-manager-component" class="secretariat-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, NIP, jabatan..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="divisionFilter" 
                        class="form-select">
                    <option value="all" {{ $divisionFilter == 'all' ? 'selected' : '' }}>Semua Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->data1 }}" {{ $divisionFilter == $division->data1 ? 'selected' : '' }}>
                            {{ $division->data1 }}
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
        <div class="col-md-5 text-end">
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-soft-primary" type="button" wire:click="openCreateModal">
                    <i class="ri-add-fill align-bottom"></i> Tambah Anggota
                </button>
                <!-- <button class="btn btn-soft-success" type="button" onclick="exportSecretariats()">
                    <i class="ri-file-excel-2-line align-bottom"></i> Export
                </button>
                <button class="btn btn-soft-info" type="button" onclick="openImportModal()">
                    <i class="ri-file-upload-line align-bottom"></i> Import
                </button> -->
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="alert alert-info mb-3" id="bulkActionsBar" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong id="selectedCount">0</strong> data dipilih
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
                    <th scope="col" style="width: 80px;">Foto</th>
                    <th scope="col" style="width: 170px;">
                        <a href="#" wire:click.prevent="sortByColumn('name')" class="text-body text-decoration-none">
                            Nama
                            @if($sortBy === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 120px;">NIP</th>
                    <th scope="col" style="width: 150px;">Jabatan</th>
                    <th scope="col" style="width: 150px;">Divisi</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 200px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($secretariats as $secretariat)
                    <tr wire:key="secretariat-{{ $secretariat->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input secretariat-checkbox" type="checkbox" value="{{ $secretariat->id }}" data-secretariat-id="{{ $secretariat->id }}">
                            </div>
                        </td>
                        <td>
                            @if($secretariat->photo)
                                <img src="{{ asset('storage/' . $secretariat->photo) }}" 
                                     alt="{{ $secretariat->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($secretariat->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $secretariat->name }}</strong>
                            @if($secretariat->contact)
                                <br><small class="text-muted">{{ $secretariat->contact }}</small>
                            @endif
                        </td>
                        <td>{{ $secretariat->nip ?? '-' }}</td>
                        <td>{{ $secretariat->position ?? '-' }}</td>
                        <td>{{ $secretariat->division ?? '-' }}</td>
                        <td class="text-center">
                            @if($secretariat->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($secretariat->is_active)
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-warning" 
                                            wire:click="toggleStatus({{ $secretariat->id }})"
                                            title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-sm btn-soft-success" 
                                            wire:click="toggleStatus({{ $secretariat->id }})"
                                            title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" 
                                        class="btn btn-sm btn-soft-secondary" 
                                        wire:click="openInfoModal({{ $secretariat->id }})"
                                        title="Info Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-primary" 
                                        wire:click="openEditModal({{ $secretariat->id }})"
                                        title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-soft-danger" 
                                        onclick="confirmDelete({{ $secretariat->id }}, '{{ $secretariat->name }}')"
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
                                <i class="ri-user-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data sekretariat</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($secretariats && $secretariats->count() > 0)
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
                    Menampilkan {{ $secretariats->firstItem() }} - {{ $secretariats->lastItem() }} / {{ $secretariats->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $secretariats->links('vendor.pagination.bootstrap-5-always') }}
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
                                                            Edit Anggota Sekretariat
                                                        @else
                                                            Tambah Anggota Sekretariat
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Avatar Upload -->
                                    <div class="text-center mb-4 mt-n5 pt-2">
                                        <div class="position-relative d-inline-block">
                                            <div class="position-absolute bottom-0 end-0">
                                                <label for="secretariat-photo-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Pilih Foto">
                                                    <div class="avatar-xs cursor-pointer">
                                                        <div class="avatar-title bg-light border rounded-circle text-muted">
                                                            <i class="ri-image-fill"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input class="form-control d-none" 
                                                       id="secretariat-photo-input" 
                                                       type="file" 
                                                       wire:model="photo"
                                                       accept="image/png, image/gif, image/jpeg">
                                            </div>
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-light rounded-circle">
                                                    @if($photo)
                                                        <img src="{{ $photo->temporaryUrl() }}" 
                                                             class="avatar-md rounded-circle h-auto" 
                                                             style="object-fit: cover; width: 100%; height: 100%;" />
                                                    @elseif($currentPhoto)
                                                        <img src="{{ asset('storage/' . $currentPhoto) }}" 
                                                             class="avatar-md rounded-circle h-auto" 
                                                             style="object-fit: cover; width: 100%; height: 100%;" />
                                                    @else
                                                        <img src="{{ asset('assets/admin/images/users/user-dummy-img.jpg') }}" 
                                                             class="avatar-md rounded-circle h-auto" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @error('photo')
                                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Form Fields in 2 Columns -->
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('form.name') is-invalid @enderror" 
                                                   id="name"
                                                   wire:model="form.name"
                                                   placeholder="Masukkan nama lengkap">
                                            @error('form.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- NIP -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nip" class="form-label">NIP</label>
                                            <input type="text" 
                                                   class="form-control @error('form.nip') is-invalid @enderror" 
                                                   id="nip"
                                                   wire:model="form.nip"
                                                   placeholder="Masukkan NIP">
                                            @error('form.nip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Position -->
                                        <div class="col-md-6 mb-3">
                                            <label for="position" class="form-label">Jabatan</label>
                                            <select class="form-select @error('form.position') is-invalid @enderror" 
                                                    id="position"
                                                    wire:model="form.position">
                                                <option value="">Pilih Jabatan</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->data1 }}">{{ $position->data1 }}</option>
                                                @endforeach
                                            </select>
                                            @error('form.position')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Division -->
                                        <div class="col-md-6 mb-3">
                                            <label for="division" class="form-label">Divisi</label>
                                            <select class="form-select @error('form.division') is-invalid @enderror" 
                                                    id="division"
                                                    wire:model="form.division">
                                                <option value="">Pilih Divisi</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->data1 }}">{{ $division->data1 }}</option>
                                                @endforeach
                                            </select>
                                            @error('form.division')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Contact -->
                                        <div class="col-md-6 mb-3">
                                            <label for="contact" class="form-label">Kontak</label>
                                            <input type="text" 
                                                   class="form-control @error('form.contact') is-invalid @enderror" 
                                                   id="contact"
                                                   wire:model="form.contact"
                                                   placeholder="Masukkan no. telepon/email">
                                            @error('form.contact')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Status</label>
                                            <div class="form-check form-switch" style="padding-top: 0.5rem;">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="isActive"
                                                       wire:model="form.is_active">
                                                <label class="form-check-label" for="isActive">
                                                    Aktif
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-12 mb-3">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('form.address') is-invalid @enderror" 
                                                      id="address"
                                                      wire:model="form.address"
                                                      rows="2"
                                                      placeholder="Masukkan alamat"></textarea>
                                            @error('form.address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Deskripsi</label>
                                            <textarea class="form-control @error('form.description') is-invalid @enderror" 
                                                      id="description"
                                                      wire:model="form.description"
                                                      rows="3"
                                                      placeholder="Masukkan deskripsi"></textarea>
                                            @error('form.description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                                    Update Data
                                                @else
                                                    Tambah Data
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
    @if($showInfoModal && $selectedSecretariat)
        <div class="modal fade show">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-user-line me-2"></i>Informasi Detail Sekretariat
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Photo Section -->
                            <div class="col-md-4 text-center mb-3">
                                @if($selectedSecretariat->photo)
                                    <img src="{{ asset('storage/' . $selectedSecretariat->photo) }}" 
                                         alt="{{ $selectedSecretariat->name }}" 
                                         class="img-fluid rounded"
                                         style="max-height: 300px; object-fit: cover;">
                                @else
                                    <div class="avatar-xl mx-auto mb-3">
                                        <span class="avatar-title rounded bg-soft-primary text-primary fs-1">
                                            {{ strtoupper(substr($selectedSecretariat->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    @if($selectedSecretariat->is_active)
                                        <span class="badge bg-success-subtle text-success fs-6">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary fs-6">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Info Section -->
                            <div class="col-md-8">
                                <h4 class="mb-3">{{ $selectedSecretariat->name }}</h4>
                                
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            @if($selectedSecretariat->nip)
                                                <tr>
                                                    <td width="40%" class="text-muted"><i class="ri-hashtag me-2"></i>NIP</td>
                                                    <td><strong>{{ $selectedSecretariat->nip }}</strong></td>
                                                </tr>
                                            @endif
                                            @if($selectedSecretariat->position)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-briefcase-line me-2"></i>Jabatan</td>
                                                    <td>{{ $selectedSecretariat->position }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedSecretariat->division)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-building-line me-2"></i>Divisi</td>
                                                    <td>{{ $selectedSecretariat->division }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedSecretariat->contact)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-phone-line me-2"></i>Kontak</td>
                                                    <td>{{ $selectedSecretariat->contact }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedSecretariat->address)
                                                <tr>
                                                    <td class="text-muted"><i class="ri-home-line me-2"></i>Alamat</td>
                                                    <td>{{ $selectedSecretariat->address }}</td>
                                                </tr>
                                            @endif
                                            @if($selectedSecretariat->description)
                                                <tr>
                                                    <td colspan="2"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted"><i class="ri-file-text-line me-2"></i>Deskripsi</td>
                                                    <td>{{ $selectedSecretariat->description }}</td>
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
<script src="{{ asset('assets/admin/js/pages/secretariat-manager.js') }}"></script>
@endpush
