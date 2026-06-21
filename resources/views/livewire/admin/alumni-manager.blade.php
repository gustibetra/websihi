<div wire:key="alumni-manager-component" class="news-wire-component">
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

    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, tahun lulus, tempat kerja..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="jurusanFilter" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                @if(!auth()->user()->isAdminJurusan())
                    <option value="all">Semua Jurusan</option>
                @endif
                @foreach($jurusansList as $jurusan)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="inspiratifFilter">
                <option value="all">Semua Kategori</option>
                <option value="yes">Alumni Inspiratif</option>
                <option value="no">Alumni Biasa</option>
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
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Alumni
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmAlumniBulkDelete()">
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
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('tahun_lulus')" class="text-body text-decoration-none">
                            Lulusan @if($sortBy === 'tahun_lulus') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Status Alumni</th>
                    <th scope="col">Tempat Kerja & Jabatan / Detail</th>
                    <th scope="col" style="width: 120px;" class="text-center">Inspiratif</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $item)
                    <tr wire:key="alumni-{{ $item->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($alumni->currentPage() - 1) * $alumni->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($item->photo)
                                <img src="{{ asset('storage/' . $item->photo) }}" 
                                     alt="{{ $item->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-xs">
                                     <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                     </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->name }}</strong>
                        </td>
                        <td>{{ $item->tahun_lulus }}</td>
                        <td>{{ $item->jurusan ? $item->jurusan->nama : '-' }}</td>
                        <td>
                            <span class="badge bg-info-subtle text-info">
                                {{ $item->status_alumni ?? 'Belum Terdata' }}
                            </span>
                        </td>
                        <td>
                            @if($item->tempat_kerja)
                                <strong>{{ $item->tempat_kerja }}</strong> 
                                @if($item->jabatan)
                                    <span class="text-muted">({{ $item->jabatan }})</span>
                                @endif
                                @if($item->bidang_pekerjaan)
                                    <br><span class="badge bg-light text-dark font-size-11">{{ $item->bidang_pekerjaan }}</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->is_inspiratif)
                                <span class="badge bg-success-subtle text-success cursor-pointer" wire:click="toggleInspiratif({{ $item->id }})" title="Klik untuk ubah status">
                                    <i class="ri-star-fill me-1"></i>Inspiratif
                                </span>
                            @else
                                <span class="badge bg-light text-muted cursor-pointer border" wire:click="toggleInspiratif({{ $item->id }})" title="Klik untuk jadikan inspiratif">
                                    Biasa
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($item->is_active)
                                    <button type="button" class="btn btn-sm btn-soft-warning" wire:click="toggleStatus({{ $item->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-soft-success" wire:click="toggleStatus({{ $item->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-soft-info" wire:click="openInfoModal({{ $item->id }})" title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-primary" wire:click="openEditModal({{ $item->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmAlumniDelete({{ $item->id }}, '{{ addslashes($item->name) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-user-star-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data alumni</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($alumni && $alumni->count() > 0)
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
                    Menampilkan {{ $alumni->firstItem() }} - {{ $alumni->lastItem() }} / {{ $alumni->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $alumni->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Add / Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="alumni-form">
                            <!-- Cover Banner -->
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-user-star-line me-2"></i>
                                            {{ $editMode ? 'Edit Alumni' : 'Tambah Alumni Baru' }}
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
                                            <div class="avatar-title bg-light rounded-circle border border-3 border-white shadow-sm" style="overflow:hidden; width: 100px; height: 100px; margin: 0 auto;">
                                                <img id="avatar-preview"
                                                     src="{{ !empty($form['photo_cropped']) ? $form['photo_cropped'] : ($photo ? $photo->temporaryUrl() : ($editMode && $currentPhoto ? asset('storage/' . $currentPhoto) : asset('assets/admin/images/users/user-dummy-img.jpg'))) }}"
                                                     class="rounded-circle"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                        </div>
                                        <!-- Upload Button -->
                                        <label for="alumni-photo-trigger" class="position-absolute bottom-0 end-0 mb-1 me-1 cursor-pointer" style="left: 60px;" title="Ubah foto">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                    <i class="ri-camera-line" style="font-size: 13px;"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="alumni-photo-trigger" class="d-none" accept="image/png,image/jpeg,image/webp">
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
                                               wire:model="form.name" placeholder="Nama lengkap alumni">
                                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Gender (Custom Radio Button Compact) -->
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

                                    <!-- Tahun Lulus -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tahun Lulus <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.tahun_lulus') is-invalid @enderror"
                                               wire:model="form.tahun_lulus" placeholder="Contoh: 2020">
                                        @error('form.tahun_lulus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Jurusan / Kompetensi Keahlian</label>
                                        <select class="form-select @error('form.jurusan_id') is-invalid @enderror" wire:model="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                            @if(!auth()->user()->isAdminJurusan())
                                                <option value="">-- Pilih Jurusan --</option>
                                            @endif
                                            @foreach($jurusansList as $jurusan)
                                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Status Alumni -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Status Alumni <span class="text-danger">*</span></label>
                                        <select class="form-select @error('form.status_alumni') is-invalid @enderror" wire:model.live="form.status_alumni">
                                            <option value="">-- Pilih Status Alumni --</option>
                                            @foreach($statusAlumniList as $status)
                                                <option value="{{ $status->data1 }}">{{ $status->data1 }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.status_alumni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Bidang Pekerjaan (Conditional: Bekerja / Bekerja & Kuliah) -->
                                    @php
                                        $currStatus = $form['status_alumni'] ?? '';
                                        $isWorking = in_array($currStatus, ['Bekerja', 'Bekerja dan Kuliah']);
                                        $isStudying = $currStatus === 'Kuliah';
                                        
                                        $tempatKerjaLabel = 'Tempat Kerja / Instansi / Kampus';
                                        $tempatKerjaPlaceholder = 'Contoh: PT Astra Honda Motor, ITB';
                                        if ($isWorking) {
                                            $tempatKerjaLabel = 'Tempat Kerja / Perusahaan';
                                            $tempatKerjaPlaceholder = 'Contoh: PT Astra Honda Motor';
                                        } elseif ($isStudying) {
                                            $tempatKerjaLabel = 'Nama Kampus / Universitas';
                                            $tempatKerjaPlaceholder = 'Contoh: Institut Teknologi Bandung';
                                        }
                                        
                                        $jabatanLabel = 'Jabatan / Jurusan Kuliah';
                                        $jabatanPlaceholder = 'Contoh: Senior Engineer, Mahasiswa S1';
                                        if ($isWorking) {
                                            $jabatanLabel = 'Jabatan / Posisi';
                                            $jabatanPlaceholder = 'Contoh: Senior Engineer';
                                        } elseif ($isStudying) {
                                            $jabatanLabel = 'Jurusan / Program Studi';
                                            $jabatanPlaceholder = 'Contoh: Teknik Informatika';
                                        }
                                    @endphp

                                    @if($isWorking)
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bidang Pekerjaan <span class="text-danger">*</span></label>
                                        <select class="form-select @error('form.bidang_pekerjaan') is-invalid @enderror" wire:model="form.bidang_pekerjaan">
                                            <option value="">-- Pilih Bidang Pekerjaan --</option>
                                            @foreach($bidangPekerjaanList as $bp)
                                                <option value="{{ $bp->data1 }}">{{ $bp->data1 }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.bidang_pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    @endif

                                    <!-- Tempat Kerja -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ $tempatKerjaLabel }}</label>
                                        <input type="text" class="form-control @error('form.tempat_kerja') is-invalid @enderror"
                                               wire:model="form.tempat_kerja" placeholder="{{ $tempatKerjaPlaceholder }}">
                                        @error('form.tempat_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Jabatan -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ $jabatanLabel }}</label>
                                        <input type="text" class="form-control @error('form.jabatan') is-invalid @enderror"
                                               wire:model="form.jabatan" placeholder="{{ $jabatanPlaceholder }}">
                                        @error('form.jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tempat Lahir -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('form.birth_place') is-invalid @enderror"
                                               wire:model="form.birth_place" placeholder="Tempat lahir">
                                        @error('form.birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tanggal Lahir (Flatpickr) -->
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
                                               wire:model="form.email" placeholder="Email alumni">
                                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Status Tampil & Kategori Inspiratif -->
                                    <div class="col-md-6">
                                         <label class="form-label fw-semibold d-block">Pengaturan Tampilan</label>
                                         <div class="d-flex gap-4 mt-2">
                                             <div class="form-check form-switch">
                                                 <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                                 <label class="form-check-label" for="isActive">Alumni Aktif</label>
                                             </div>
                                             <div class="form-check form-switch">
                                                 <input class="form-check-input" type="checkbox" id="isInspiratif" wire:model="form.is_inspiratif">
                                                 <label class="form-check-label" for="isInspiratif">Alumni Inspiratif</label>
                                             </div>
                                         </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control @error('form.address') is-invalid @enderror" 
                                                  wire:model="form.address" rows="2" placeholder="Alamat lengkap"></textarea>
                                        @error('form.address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Testimoni / Pengalaman -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Testimoni / Kisah Sukses / Kesan-Pesan</label>
                                        <textarea class="form-control @error('form.testimoni') is-invalid @enderror" 
                                                  wire:model="form.testimoni" rows="3" placeholder="Bagikan kisah sukses, inspirasi, atau pesan untuk adik kelas..."></textarea>
                                        @error('form.testimoni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Alumni' }}</span>
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
                    <h5 class="modal-title"><i class="ri-crop-line me-2"></i>Crop Foto Alumni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="max-height: 360px; overflow: hidden; background: #1a1a2e; border-radius: 8px;">
                        <img id="cropper-image" src="" style="max-width: 100%; display: block;">
                    </div>
                    <p class="text-muted mt-3 mb-0" style="font-size: 0.8rem;">
                        <i class="ri-drag-move-line me-1"></i>Geser & zoom untuk menyesuaikan area crop (rasio 1:1)
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
    @if($showInfoModal && $selectedAlumni)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white"><i class="ri-user-star-line me-2"></i>Detail Informasi Alumni</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            @if($selectedAlumni->photo)
                                <img src="{{ asset('storage/' . $selectedAlumni->photo) }}" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="avatar-lg mx-auto">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-24">
                                        {{ strtoupper(substr($selectedAlumni->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-1">{{ $selectedAlumni->name }}</h4>
                        <p class="text-muted mb-3">
                            Alumni Tahun Lulus: <strong>{{ $selectedAlumni->tahun_lulus }}</strong> | 
                            Jurusan: {{ $selectedAlumni->jurusan ? $selectedAlumni->jurusan->nama : '-' }}
                        </p>

                        <div class="text-start table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%;" class="bg-light">Jenis Kelamin</th>
                                        <td>{{ $selectedAlumni->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status Alumni</th>
                                        <td>{{ $selectedAlumni->status_alumni ?? 'Belum Terdata' }}</td>
                                    </tr>
                                    @if($selectedAlumni->bidang_pekerjaan)
                                    <tr>
                                        <th class="bg-light">Bidang Pekerjaan</th>
                                        <td>{{ $selectedAlumni->bidang_pekerjaan }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th class="bg-light">Tempat Kerja / Kampus</th>
                                        <td>{{ $selectedAlumni->tempat_kerja ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jabatan / Prodi</th>
                                        <td>{{ $selectedAlumni->jabatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">TTL</th>
                                        <td>
                                            @if($selectedAlumni->birth_place || $selectedAlumni->birth_date)
                                                {{ $selectedAlumni->birth_place ?? '-' }}, {{ $selectedAlumni->birth_date ? $selectedAlumni->birth_date->format('d F Y') : '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">No. Telepon / HP</th>
                                        <td>{{ $selectedAlumni->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Email</th>
                                        <td>{{ $selectedAlumni->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kategori Alumni</th>
                                        <td>
                                            @if($selectedAlumni->is_inspiratif)
                                                <span class="badge bg-success"><i class="ri-star-fill me-1"></i>Alumni Inspiratif</span>
                                            @else
                                                <span class="badge bg-secondary">Alumni Biasa</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($selectedAlumni->testimoni)
                            <div class="text-start mt-3">
                                <h6 class="fw-semibold text-primary"><i class="ri-discuss-line me-1"></i>Testimoni & Kisah Sukses:</h6>
                                <div class="bg-light p-2 rounded border border-dashed" style="white-space: pre-wrap; font-style: italic;">"{{ $selectedAlumni->testimoni }}"</div>
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
        if (e.target && e.target.id === 'alumni-photo-trigger') {
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
                        aspectRatio: 1,          // 1:1 crop
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
                width: 400,
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

    window.confirmAlumniDelete = function (id, name) {
        const message = `Data Alumni "${name}" akan dihapus secara permanen!`;
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
            if (confirm(`Apakah Anda yakin ingin menghapus data alumni "${name}"?`)) {
                const $component = document.querySelector('[wire\\:id]');
                if ($component && window.Livewire) {
                    window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                }
            }
        }
    };

    window.confirmAlumniBulkDelete = function () {
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
