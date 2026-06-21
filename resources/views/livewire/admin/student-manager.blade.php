<div wire:key="student-manager-component" class="news-wire-component">
    <style>
        #cropperModal .cropper-view-box,
        #cropperModal .cropper-face {
            border-radius: 0 !important;
        }
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
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, NIS, NISN..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="kelasFilter">
                <option value="all">Semua Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->data1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="statusFilter">
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-5 text-end">
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Siswa
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div wire:ignore class="flash-message-success" data-message="{{ session('message') }}"></div>
    @endif
    @if (session()->has('error'))
        <div wire:ignore class="flash-message-error" data-message="{{ session('error') }}"></div>
    @endif

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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmStudentBulkDelete()">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </div>
    </div>
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
                            Nama @if($sortBy === 'name') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">NIS / NISN</th>
                    <th scope="col">Kelas / Jurusan</th>
                    <th scope="col">Gender</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr wire:key="student-{{ $student->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $student->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" 
                                     alt="{{ $student->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $student->name }}</strong>
                        </td>
                        <td>
                            NIS: {{ $student->nis ?? '-' }} <br>
                            NISN: {{ $student->nisn ?? '-' }}
                        </td>
                        <td>
                            Kelas: {{ $student->kelas ? $student->kelas->data1 : '-' }} <br>
                            Jurusan: {{ $student->jurusan ? $student->jurusan->nama : '-' }}
                        </td>
                        <td>
                            <span class="badge {{ $student->gender == 'male' ? 'bg-info-subtle text-info' : 'bg-danger-subtle text-danger' }}">
                                {{ $student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($student->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($student->is_active)
                                    <button type="button" class="btn btn-sm btn-soft-warning" wire:click="toggleStatus({{ $student->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-soft-success" wire:click="toggleStatus({{ $student->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-soft-info" wire:click="openInfoModal({{ $student->id }})" title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-primary" wire:click="openEditModal({{ $student->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmStudentDelete({{ $student->id }}, '{{ addslashes($student->name) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-user-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data siswa</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($students && $students->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                        <option value="8">8</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <span class="text-muted">|</span>
                <div class="text-muted">
                    Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} / {{ $students->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $students->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Add / Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="student-form">
                            <!-- Cover Banner -->
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-user-settings-line me-2"></i>
                                            {{ $editMode ? 'Edit Siswa' : 'Tambah Siswa Baru' }}
                                        </h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <!-- Avatar Cropper Section -->
                                <div class="text-center mb-3 mt-n4">
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
                                        <label for="student-photo-trigger" class="position-absolute bottom-0 end-0 mb-n1 cursor-pointer" style="right: calc(50% - 45px); z-index: 10;" title="Ubah foto profil">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                    <i class="ri-camera-line" style="font-size: 13px;"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="student-photo-trigger" class="d-none" accept="image/png,image/jpeg,image/webp">
                                        <!-- Hidden input untuk base64 hasil crop -->
                                        <input type="hidden" wire:model="form.photo_cropped" id="photo-cropped-input">
                                    </div>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem;">
                                        <i class="ri-crop-line me-1"></i>Klik ikon kamera untuk upload (Wajib)
                                    </p>
                                    @error('photo') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                </div>

                                <!-- Form Fields -->
                                <div class="row g-3">
                                    <!-- Nama -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.name') is-invalid @enderror"
                                               wire:model="form.name" placeholder="Nama lengkap siswa">
                                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Jenis Kelamin <span class="text-danger">*</span></label>
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

                                    <!-- NIS -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NIS</label>
                                        <input type="text" class="form-control @error('form.nis') is-invalid @enderror"
                                               wire:model="form.nis" placeholder="Nomor Induk Siswa">
                                        @error('form.nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- NISN -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NISN</label>
                                        <input type="text" class="form-control @error('form.nisn') is-invalid @enderror"
                                               wire:model="form.nisn" placeholder="Nomor Induk Siswa Nasional">
                                        @error('form.nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jurusan</label>
                                        <select class="form-select @error('form.jurusan_id') is-invalid @enderror" wire:model.live="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                            @if(!auth()->user()->isAdminJurusan())
                                                <option value="">-- Pilih Jurusan --</option>
                                            @endif
                                            @foreach($jurusansList as $jurusan)
                                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Kelas -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kelas</label>
                                        <select class="form-select @error('form.kelas_id') is-invalid @enderror" wire:model="form.kelas_id" {{ empty($form['jurusan_id']) ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach($formKelas as $kelas)
                                                <option value="{{ $kelas->id }}">{{ $kelas->data1 }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tempat Lahir -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('form.birth_place') is-invalid @enderror"
                                               wire:model="form.birth_place" placeholder="Tempat lahir">
                                        @error('form.birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tanggal Lahir -->
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

                                    <!-- No Telepon -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">No. Telepon / HP</label>
                                        <input type="text" class="form-control @error('form.phone') is-invalid @enderror"
                                               wire:model="form.phone" placeholder="No telepon">
                                        @error('form.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control @error('form.email') is-invalid @enderror"
                                               wire:model="form.email" placeholder="Email siswa">
                                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="isActive">Siswa Aktif</label>
                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control @error('form.address') is-invalid @enderror" 
                                                  wire:model="form.address" rows="2" placeholder="Alamat lengkap siswa"></textarea>
                                        @error('form.address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Deskripsi Prestasi / Organisasi -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Prestasi / Organisasi / Keterangan</label>
                                        <textarea class="form-control @error('form.description') is-invalid @enderror" 
                                                  wire:model="form.description" rows="3" placeholder="Contoh: Ketua OSIS 2025/2026, Juara 1 Lomba Web Design Tingkat Provinsi..."></textarea>
                                        @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Siswa' }}</span>
                                        <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...</span>
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
                    <h5 class="modal-title"><i class="ri-crop-line me-2"></i>Crop Foto Siswa</h5>
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

    <!-- Info Detail Modal -->
    @if($showInfoModal && $selectedStudent)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white"><i class="ri-user-line me-2"></i>Detail Informasi Siswa</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            @if($selectedStudent->photo)
                                <img src="{{ asset('storage/' . $selectedStudent->photo) }}" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="avatar-lg mx-auto">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-24">
                                        {{ strtoupper(substr($selectedStudent->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-1">{{ $selectedStudent->name }}</h4>
                        <p class="text-muted mb-3">
                            Kelas: {{ $selectedStudent->kelas ? $selectedStudent->kelas->data1 : '-' }} | 
                            Jurusan: {{ $selectedStudent->jurusan ? $selectedStudent->jurusan->nama : '-' }}
                        </p>

                        <div class="text-start table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%;" class="bg-light">NIS / NISN</th>
                                        <td>{{ $selectedStudent->nis ?? '-' }} / {{ $selectedStudent->nisn ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jenis Kelamin</th>
                                        <td>{{ $selectedStudent->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">TTL</th>
                                        <td>
                                            @if($selectedStudent->birth_place || $selectedStudent->birth_date)
                                                {{ $selectedStudent->birth_place ?? '-' }}, {{ $selectedStudent->birth_date ? $selectedStudent->birth_date->format('d F Y') : '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">No. Telepon / HP</th>
                                        <td>{{ $selectedStudent->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Email</th>
                                        <td>{{ $selectedStudent->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Alamat</th>
                                        <td>{{ $selectedStudent->address ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status Tampil</th>
                                        <td>
                                            @if($selectedStudent->is_active)
                                                <span class="badge bg-success">Aktif / Ditampilkan</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif / Disembunyikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($selectedStudent->description)
                            <div class="text-start mt-3">
                                <h6 class="fw-semibold text-primary"><i class="ri-award-line me-1"></i>Prestasi & Organisasi:</h6>
                                <div class="bg-light p-2 rounded border border-dashed" style="white-space: pre-wrap;">{{ $selectedStudent->description }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showInfoModal', false)">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

@push('scripts')
<script src="{{ asset('assets/admin/libs/cropperjs/cropper.min.js') }}"></script>
<script>
(function () {
    let cropper = null;

    // Saat file dipilih → tampilkan modal cropper
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'student-photo-trigger') {
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

    let birthDatePicker = null;

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
            initDatePicker();
        }, 100);
    });

    // Cleanup saat modal ditutup
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-modal', () => {
            const photoInput = document.getElementById('photo-cropped-input');
            if (photoInput) photoInput.value = '';
            if (cropper) { cropper.destroy(); cropper = null; }
            if (birthDatePicker) {
                birthDatePicker.destroy();
                birthDatePicker = null;
            }
        });

        // Global Event listener for toasts
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

    window.confirmStudentDelete = function (id, name) {
        const message = `Data Siswa "${name}" akan dihapus secara permanen!`;
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    const $component = document.querySelector('[wire\\:id]');
                    if ($component && window.Livewire) {
                        window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                    }
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus data siswa "${name}"?`)) {
                const $component = document.querySelector('[wire\\:id]');
                if ($component && window.Livewire) {
                    window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                }
            }
        }
    };

    window.confirmStudentBulkDelete = function () {
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
