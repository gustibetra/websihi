<div wire:key="teacher-manager-component" class="news-wire-component">
    <style>
        #cropperModal .cropper-view-box,
        #cropperModal .cropper-face {
            border-radius: 0 !important;
        }
    </style>
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, nip, bidang studi..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="jenisFilter">
                <option value="all">Semua Jenis</option>
                <option value="guru">Guru</option>
                <option value="tendik">Tenaga Kependidikan</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="statusKepegawaianFilter">
                <option value="all">Semua Status Pegawai</option>
                <option value="PNS">PNS</option>
                <option value="PPPK">PPPK</option>
                <option value="Honorer">Honorer</option>
                <option value="DTT">DTT</option>
                <option value="DTS">DTS</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="statusFilter">
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-soft-primary" type="button" wire:click="openCreateModal">
                    <i class="ri-add-fill align-bottom"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    @if(count($selectedItems) > 0)
    <div class="alert alert-info mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ count($selectedItems) }}</strong> data dipilih
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-soft-primary" wire:click="bulkUpdateStatus(1)">
                    <i class="ri-checkbox-circle-line"></i> Aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-soft-warning" wire:click="bulkUpdateStatus(0)">
                    <i class="ri-close-circle-line"></i> Nonaktifkan
                </button>
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmTeacherBulkDelete()">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

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
                            <input class="form-check-input" type="checkbox" wire:model.live="selectAll" wire:click="toggleSelectAll">
                        </div>
                    </th>
                    <th scope="col" style="width: 60px;">No</th>
                    <th scope="col" style="width: 80px;">Foto</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('name')" class="text-body text-decoration-none">
                            Nama / NIP
                            @if($sortBy === 'name')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">Jenis / Jabatan</th>
                    <th scope="col">Status Kepegawaian</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" style="width: 150px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr wire:key="teacher-{{ $teacher->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $teacher->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                     alt="{{ $teacher->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $teacher->name }}</strong>
                            @if($teacher->nip)
                                <br><small class="text-muted">NIP: {{ $teacher->nip }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $teacher->jenis == 'guru' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }}">
                                {{ $teacher->jenis == 'guru' ? 'Guru' : 'Tenaga Kependidikan' }}
                            </span>
                            @if($teacher->jabatan)
                                <br><small class="text-muted">{{ $teacher->jabatan }}</small>
                            @endif
                            @if($teacher->bidang_studi)
                                <br><small class="text-muted">{{ $teacher->bidang_studi }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $teacher->status_kepegawaian ?? '-' }}
                        </td>
                        <td class="text-center">
                            @if($teacher->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($teacher->is_active)
                                    <button type="button" class="btn btn-sm btn-soft-warning" wire:click="toggleStatus({{ $teacher->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-soft-success" wire:click="toggleStatus({{ $teacher->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-soft-secondary" wire:click="openInfoModal({{ $teacher->id }})" title="Info Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-primary" wire:click="openEditModal({{ $teacher->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmTeacherDelete({{ $teacher->id }}, '{{ addslashes($teacher->name) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-user-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data guru/tendik</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($teachers && $teachers->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <div wire:ignore style="min-width: 60px;">
                        <select wire:model.live="perPage" class="form-select form-select-sm per-page-select">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">|</span>
                <div class="text-muted">
                    Menampilkan {{ $teachers->firstItem() }} - {{ $teachers->lastItem() }} / {{ $teachers->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $teachers->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0">
                    <!-- Cover Banner -->
                    <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                        <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                            <div class="flex-grow-1">
                                <h5 class="modal-title text-white fw-semibold">
                                    <i class="ri-user-2-line me-2"></i>
                                    {{ $editMode ? 'Edit Data Guru/Tendik' : 'Tambah Data Guru/Tendik Baru' }}
                                </h5>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)"></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="teacher-form">
                            <div class="px-4 pb-4">
                                <!-- Avatar Cropper Section -->
                                <div class="text-center mb-3 mt-4">
                                    <div class="position-relative d-inline-block">
                                        <!-- Avatar Preview -->
                                        <div class="user-avatar-lg" id="avatar-wrapper">
                                            <div class="avatar-title bg-light rounded border border-3 border-white shadow-sm" style="overflow:hidden; width: 90px; height: 120px; margin: 0 auto;">
                                                <img id="avatar-preview"
                                                     src="{{ !empty($form['photo_cropped']) ? $form['photo_cropped'] : ($photo ? $photo->temporaryUrl() : ($editMode && $currentPhoto ? asset('storage/' . $currentPhoto) : asset('assets/admin/images/users/user-dummy-img.jpg'))) }}"
                                                     class="rounded"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                        </div>
                                        <!-- Upload Button -->
                                        <label for="teacher-photo-trigger" class="position-absolute bottom-0 end-0 mb-n1 cursor-pointer" style="right: calc(50% - 45px); z-index: 10;" title="Ubah foto">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                    <i class="ri-camera-line" style="font-size: 13px;"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="teacher-photo-trigger" class="d-none" accept="image/png,image/jpeg,image/webp">
                                        <!-- Hidden input untuk base64 hasil crop -->
                                        <input type="hidden" wire:model="form.photo_cropped" id="photo-cropped-input">
                                    </div>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem;">
                                        <i class="ri-crop-line me-1"></i>Klik ikon kamera untuk upload foto (3x4)
                                    </p>
                                    @error('photo') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                </div>

                                <style>
                                    .gender-radio {
                                        display: none;
                                    }
                                    .gender-label {
                                        border: 1px solid #ced4da;
                                        border-radius: 0.25rem;
                                        padding: 6px 10px;
                                        cursor: pointer;
                                        display: block;
                                        transition: all 0.2s ease-in-out;
                                        width: 100%;
                                        font-size: 0.875rem;
                                    }
                                    .gender-label:hover {
                                        background-color: #f8f9fa;
                                    }
                                    .gender-radio:checked + .gender-label.male-label {
                                        border-color: #299cdb;
                                        background-color: rgba(41, 156, 219, 0.05);
                                        box-shadow: 0 0 0 0.15rem rgba(41, 156, 219, 0.25);
                                    }
                                    .gender-radio:checked + .gender-label.female-label {
                                        border-color: #f06548;
                                        background-color: rgba(240, 101, 72, 0.05);
                                        box-shadow: 0 0 0 0.15rem rgba(240, 101, 72, 0.25);
                                    }
                                </style>

                                <div class="row g-3">
                                    <!-- Row 1: Identitas & Posisi -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.name') is-invalid @enderror" wire:model="form.name">
                                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">NIP</label>
                                        <input type="text" class="form-control @error('form.nip') is-invalid @enderror" wire:model="form.nip">
                                        @error('form.nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                                        <select class="form-select @error('form.jenis') is-invalid @enderror" wire:model="form.jenis">
                                            <option value="guru">Guru</option>
                                            <option value="tendik">Tenaga Kependidikan</option>
                                        </select>
                                        @error('form.jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Row 2: Kepegawaian & Pendidikan -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <div wire:ignore>
                                            <select id="form-jabatan-select" class="form-select">
                                                <option value="">Pilih Jabatan</option>
                                                @foreach($jabatans as $jab)
                                                    <option value="{{ $jab->data1 }}" {{ ($form['jabatan'] ?? '') == $jab->data1 ? 'selected' : '' }}>{{ $jab->data1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.jabatan') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Status Kepegawaian</label>
                                        <select class="form-select @error('form.status_kepegawaian') is-invalid @enderror" wire:model="form.status_kepegawaian">
                                            <option value="">Pilih Status</option>
                                            <option value="PNS">PNS</option>
                                            <option value="PPPK">PPPK</option>
                                            <option value="DTY">DTY (Dosen Tetap Yayasan)</option>
                                            <option value="DTT">DTT (Dosen Tidak Tetap)</option>
                                            <option value="PTY">PTY (Pegawai Tetap Yayasan)</option>
                                            <option value="PTT">PTT (Pegawai Tidak Tetap)</option>
                                            <option value="Honorer">Honorer</option>
                                        </select>
                                        @error('form.status_kepegawaian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control @error('form.pendidikan') is-invalid @enderror" wire:model="form.pendidikan" placeholder="Contoh: S1 Teknik Informatika">
                                        @error('form.pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Row 3: Studi & Personal -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Bidang Studi <small class="text-muted">(Guru)</small></label>
                                        <div wire:ignore>
                                            <select id="form-bidangstudi-select" class="form-select" multiple data-choices-multiple-remove data-choices-search-true>
                                                @foreach($bidangStudis as $bs)
                                                    @php
                                                        $isSelected = is_array($form['bidang_studi'] ?? null) 
                                                            ? in_array($bs->data1, $form['bidang_studi']) 
                                                            : ($form['bidang_studi'] ?? '') == $bs->data1;
                                                    @endphp
                                                    <option value="{{ $bs->data1 }}" {{ $isSelected ? 'selected' : '' }}>{{ $bs->data1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.bidang_studi') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jurusan (Opsional)</label>
                                        <select class="form-select @error('form.jurusan_id') is-invalid @enderror" wire:model.live="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                            @if(!auth()->user()->isAdminJurusan())
                                                <option value="">Tidak ada / Umum</option>
                                            @endif
                                            @foreach($jurusans as $jurusan)
                                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control @error('form.email') is-invalid @enderror" wire:model="form.email">
                                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Row 4: Data Pribadi & Kontak -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('form.birth_place') is-invalid @enderror" wire:model="form.birth_place">
                                        @error('form.birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                                        <div wire:ignore>
                                            <input type="text" 
                                                   id="birth-date-picker" 
                                                   class="form-control"
                                                   data-provider="flatpickr" 
                                                   data-date-format="d M, Y"
                                                   placeholder="Pilih Tanggal Lahir"
                                                   readonly>
                                        </div>
                                        @error('form.birth_date') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">No. Telepon / HP</label>
                                        <input type="text" class="form-control @error('form.phone') is-invalid @enderror" wire:model="form.phone">
                                        @error('form.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Row 5: Gender & Settings -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Jenis Kelamin</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="radio" id="gender_male" wire:model="form.gender" value="male" class="gender-radio">
                                                <label for="gender_male" class="gender-label male-label mb-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-men-line text-info fs-16 me-2"></i>
                                                        <span class="fw-semibold">Laki-laki</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" id="gender_female" wire:model="form.gender" value="female" class="gender-radio">
                                                <label for="gender_female" class="gender-label female-label mb-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-women-line text-danger fs-16 me-2"></i>
                                                        <span class="fw-semibold">Perempuan</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @error('form.gender') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="isActive">Aktif</label>
                                        </div>
                                    </div>

                                    <!-- Row 6: Address & Description -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control @error('form.address') is-invalid @enderror" wire:model="form.address" rows="2"></textarea>
                                        @error('form.address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                                        <textarea class="form-control @error('form.description') is-invalid @enderror" wire:model="form.description" rows="2"></textarea>
                                        @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Simpan</span>
                                        <span wire:loading><span class="spinner-border spinner-border-sm"></span> Menyimpan...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Image Cropper Modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ri-crop-line me-2"></i>Crop Foto Guru/Tendik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="max-height: 360px; overflow: hidden; background: #1a1a2e; border-radius: 8px;">
                        <img id="cropper-image" src="" style="max-width: 100%; display: block;">
                    </div>
                    <p class="text-muted mt-3 mb-0" style="font-size: 0.8rem;">
                        <i class="ri-drag-move-line me-1"></i>Geser & zoom untuk menyesuaikan area crop (rasio 3:4)
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-crop-apply">
                        <i class="ri-check-line me-1"></i>Terapkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Modal -->
    @if($showInfoModal && $selectedTeacher)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">Detail Guru/Tendik</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if($selectedTeacher->photo)
                            <img src="{{ asset('storage/' . $selectedTeacher->photo) }}" class="rounded img-thumbnail mb-3" style="width: 90px; height: 120px; object-fit: cover;">
                        @else
                            <div class="avatar-xl mx-auto mb-3">
                                <span class="avatar-title rounded bg-soft-primary text-primary fs-1" style="display: flex; align-items: center; justify-content: center; width: 90px; height: 120px; margin: 0 auto;">
                                    {{ strtoupper(substr($selectedTeacher->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <h4>{{ $selectedTeacher->name }}</h4>
                        <p class="text-muted mb-1">{{ $selectedTeacher->nip ?? '-' }}</p>
                        <span class="badge {{ $selectedTeacher->jenis == 'guru' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }} mb-3">
                            {{ $selectedTeacher->jenis == 'guru' ? 'Guru' : 'Tenaga Kependidikan' }}
                        </span>

                        <table class="table table-sm table-borderless text-start mt-3">
                            <tr><td width="40%" class="text-muted">Jabatan:</td><td>{{ $selectedTeacher->jabatan ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Status Kepegawaian:</td><td>{{ $selectedTeacher->status_kepegawaian ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Pendidikan:</td><td>{{ $selectedTeacher->pendidikan ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Bidang Studi:</td><td>{{ $selectedTeacher->bidang_studi ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Jurusan:</td><td>{{ $selectedTeacher->jurusan ? $selectedTeacher->jurusan->nama : '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="$set('showInfoModal', false)">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    @push('scripts')
    <script src="{{ asset('assets/admin/libs/cropperjs/cropper.min.js') }}"></script>
    <script>
        (function () {
            let cropper = null;
            let jabatanChoices = null;
            let bidangStudiChoices = null;
            let birthDatePicker = null;

            // Saat file dipilih → tampilkan modal cropper
            document.addEventListener('change', function (e) {
                if (e.target && e.target.id === 'teacher-photo-trigger') {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        const cropperImg = document.getElementById('cropper-image');
                        if (!cropperImg) return;

                        cropperImg.src = ev.target.result;

                        // Buka modal cropper
                        const cropModal = new bootstrap.Modal(document.getElementById('cropperModal'));
                        cropModal.show();

                        // Init Cropper.js setelah modal tampil
                        document.getElementById('cropperModal').addEventListener('shown.bs.modal', function handler() {
                            if (cropper) {
                                cropper.destroy();
                                cropper = null;
                            }
                            cropper = new Cropper(cropperImg, {
                                aspectRatio: 3 / 4,          // 3:4 crop
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 0.9,
                                restore: false,
                                guides: false,
                                center: true,
                                highlight: false,
                                cropBoxMovable: false,
                                cropBoxResizable: false,
                                toggleDragModeOnDblclick: false,
                            });
                            this.removeEventListener('shown.bs.modal', handler);
                        });
                    };
                    reader.readAsDataURL(file);
                    e.target.value = '';
                }
            });

            // Tombol "Terapkan" crop
            document.addEventListener('click', function (e) {
                if (e.target && e.target.id === 'btn-crop-apply') {
                    if (!cropper) return;

                    const canvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 400,
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });

                    const base64 = canvas.toDataURL('image/jpeg', 0.92);

                    // Update preview avatar
                    const preview = document.getElementById('avatar-preview');
                    if (preview) preview.src = base64;

                    // Kirim base64 ke Livewire melalui hidden input
                    const hiddenInput = document.getElementById('photo-cropped-input');
                    if (hiddenInput) {
                        hiddenInput.value = base64;
                        hiddenInput.dispatchEvent(new Event('input'));
                    }

                    // Tutup modal cropper
                    bootstrap.Modal.getInstance(document.getElementById('cropperModal')).hide();

                    // Destroy cropper
                    cropper.destroy();
                    cropper = null;
                }
            });

            function initJabatanChoices() {
                const el = document.getElementById('form-jabatan-select');
                if (!el) return;
                
                if (el._choicesInstance) {
                    el._choicesInstance.destroy();
                    el._choicesInstance = null;
                }
                
                if (typeof Choices !== 'undefined') {
                    jabatanChoices = new Choices(el, {
                        searchEnabled: true,
                        placeholder: true,
                        placeholderValue: 'Pilih Jabatan',
                        searchPlaceholderValue: 'Cari jabatan...',
                        itemSelectText: '',
                        shouldSort: false
                    });
                    el._choicesInstance = jabatanChoices;
                    
                    el.addEventListener('change', function(e) {
                        const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                        if (componentId && window.Livewire) {
                            window.Livewire.find(componentId).set('form.jabatan', e.target.value);
                        }
                    });

                    // Set initial value from Livewire
                    const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                    if (componentId && window.Livewire) {
                        const val = window.Livewire.find(componentId).get('form.jabatan') || '';
                        jabatanChoices.setChoiceByValue(val);
                    }
                }
            }

            function initBidangStudiChoices() {
                const el = document.getElementById('form-bidangstudi-select');
                if (!el) return;
                
                if (el._choicesInstance) {
                    el._choicesInstance.destroy();
                    el._choicesInstance = null;
                }
                
                if (typeof Choices !== 'undefined') {
                    bidangStudiChoices = new Choices(el, {
                        removeItemButton: true,
                        searchEnabled: true,
                        placeholder: true,
                        placeholderValue: 'Pilih Bidang Studi',
                        searchPlaceholderValue: 'Cari bidang studi...',
                        itemSelectText: '',
                        shouldSort: false
                    });
                    el._choicesInstance = bidangStudiChoices;
                    
                    el.addEventListener('change', function(e) {
                        const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                        if (componentId && window.Livewire) {
                            const selectedValues = bidangStudiChoices.getValue(true) || [];
                            window.Livewire.find(componentId).set('form.bidang_studi', selectedValues);
                        }
                    });

                    // Set initial value from Livewire
                    const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                    if (componentId && window.Livewire) {
                        const val = window.Livewire.find(componentId).get('form.bidang_studi') || [];
                        const valArray = Array.isArray(val) ? val : (val ? [val] : []);
                        
                        // Clear active items first
                        bidangStudiChoices.removeActiveItems();
                        
                        setTimeout(() => {
                            valArray.forEach(v => {
                                try {
                                    bidangStudiChoices.setChoiceByValue(String(v));
                                } catch (err) {}
                            });
                        }, 50);
                    }
                }
            }

            function initDatePicker() {
                const el = document.getElementById('birth-date-picker');
                if (!el) return;
                
                if (el._flatpickr) {
                    el._flatpickr.destroy();
                    el._flatpickr = null;
                }
                
                if (typeof flatpickr !== 'undefined') {
                    birthDatePicker = flatpickr(el, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'd M, Y',
                        disableMobile: true,
                        onChange: function(selectedDates, dateStr) {
                            const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                            if (componentId && window.Livewire) {
                                window.Livewire.find(componentId).set('form.birth_date', dateStr);
                            }
                        }
                    });
                    el._flatpickr = birthDatePicker;
                    
                    // Set initial value from Livewire
                    const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                    if (componentId && window.Livewire) {
                        const dateVal = window.Livewire.find(componentId).get('form.birth_date');
                        if (dateVal) {
                            birthDatePicker.setDate(dateVal, false);
                        } else {
                            birthDatePicker.clear(false);
                        }
                    }
                }
            }

            window.addEventListener('open-modal', () => {
                setTimeout(() => {
                    initJabatanChoices();
                    initBidangStudiChoices();
                    initDatePicker();
                }, 100);
            });

            // Cleanup saat modal ditutup
            document.addEventListener('livewire:initialized', function () {
                Livewire.on('close-modal', () => {
                    const photoInput = document.getElementById('photo-cropped-input');
                    if (photoInput) photoInput.value = '';
                    if (cropper) { cropper.destroy(); cropper = null; }
                    
                    if (jabatanChoices) {
                        jabatanChoices.destroy();
                        jabatanChoices = null;
                    }
                    if (bidangStudiChoices) {
                        bidangStudiChoices.destroy();
                        bidangStudiChoices = null;
                    }
                    if (birthDatePicker) {
                        birthDatePicker.destroy();
                        birthDatePicker = null;
                    }
                });

                // Toast dispatch
                window.addEventListener('show-toast', function (event) {
                    const data = event.detail[0] || event.detail;
                    const type = data.type || 'info';
                    const message = data.message || 'Notification';
                    
                    if (typeof showToast === 'function') {
                        showToast(message, type);
                    } else if (typeof NotifAlert !== 'undefined' && typeof NotifAlert.toast === 'function') {
                        NotifAlert.toast(message, type);
                    } else {
                        alert(message);
                    }
                });
                
                Livewire.on('bulk-action-completed', () => {
                    // Uncheck select all
                    const selectAllCheck = document.querySelector('input[wire\\:model\\.live="selectAll"]');
                    if (selectAllCheck) selectAllCheck.checked = false;
                });
            });

            // SweetAlert Delete Confirmations
            window.confirmTeacherDelete = function (id, name) {
                const message = `Data Guru/Tendik "${name}" akan dihapus secara permanen!`;
                if (typeof showDeleteConfirm === 'function') {
                    showDeleteConfirm(message).then((result) => {
                        if (result.isConfirmed) {
                            const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                            Livewire.find(componentId).call('delete', id);
                        }
                    });
                } else {
                    if (confirm(`Apakah Anda yakin ingin menghapus data "${name}"?`)) {
                        const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                        Livewire.find(componentId).call('delete', id);
                    }
                }
            };

            window.confirmTeacherBulkDelete = function () {
                const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                const component = Livewire.find(componentId);
                const count = component.get('selectedItems').length;
                
                if (count === 0) {
                    if (typeof showError === 'function') {
                        showError('Pilih minimal satu data untuk dihapus');
                    } else {
                        alert('Pilih minimal satu data untuk dihapus');
                    }
                    return;
                }
                
                if (typeof showBulkDeleteConfirm === 'function') {
                    showBulkDeleteConfirm(count).then((result) => {
                        if (result.isConfirmed) {
                            component.call('bulkDelete');
                        }
                    });
                } else if (confirm(`Apakah Anda yakin ingin menghapus ${count} data terpilih?`)) {
                    component.call('bulkDelete');
                }
            };
        })();
    </script>
    @endpush
</div>
