<div wire:key="user-manager-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, username, atau email..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <div wire:ignore>
                <select id="roleFilter" 
                        class="form-select choices-init-hide" 
                        data-choices
                        data-choices-search-false>
                    <option value="all" {{ $roleFilter == 'all' ? 'selected' : '' }}>Semua Role</option>
                    <option value="SuperAdmin" {{ $roleFilter == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                    <option value="Admin" {{ $roleFilter == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Operator" {{ $roleFilter == 'Operator' ? 'selected' : '' }}>Operator</option>
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
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah User
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

    <!-- Table -->
    <div class="table-responsive table-card mb-2 mt-2 border border-top-dashed">
        <table class="table align-middle table-nowrap mb-0 table-striped table-sm">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 80px;">
                        <a href="#" wire:click.prevent="sortByColumn('id')" class="text-body text-decoration-none">
                            ID
                            @if($sortBy === 'id') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 80px;">Foto</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('name')" class="text-body text-decoration-none">
                            Nama @if($sortBy === 'name') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('username')" class="text-body text-decoration-none">
                            Username @if($sortBy === 'username') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col" style="width: 120px;">
                        <a href="#" wire:click.prevent="sortByColumn('role')" class="text-body text-decoration-none">
                            Role @if($sortBy === 'role') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === auth()->id())
                                <span class="badge bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @if($user->role === 'Admin')
                                @if($user->jurusan)
                                    <span class="badge bg-primary-subtle text-primary">{{ $user->jurusan->nama }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Belum Ditentukan</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $roleBadge = match($user->role) {
                                    'SuperAdmin' => 'danger',
                                    'Admin'      => 'warning',
                                    default      => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $roleBadge }}">{{ $user->role }}</span>
                        </td>
                        <td class="text-center">
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($user->id !== auth()->id())
                                    @if($user->is_active)
                                        <button type="button" class="btn btn-sm btn-warning" wire:click="toggleStatus({{ $user->id }})" title="Nonaktifkan">
                                            <i class="ri-close-circle-line"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-success" wire:click="toggleStatus({{ $user->id }})" title="Aktifkan">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </button>
                                    @endif
                                @endif
                                <button type="button" class="btn btn-sm btn-info" wire:click="openPasswordModal({{ $user->id }})" title="Ubah Password">
                                    <i class="ri-lock-password-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openEditModal({{ $user->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                @if($user->id !== auth()->id() && $user->role !== 'SuperAdmin')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Hapus">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-user-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data user</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users && $users->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <div wire:ignore style="min-width: 60px;">
                        <select id="perPageFilter" class="form-select form-select-sm choices-init-hide per-page-select" data-choices data-choices-search-false>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
                <span class="text-muted">|</span>
                <div class="text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} / {{ $users->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $users->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- ══════════════════════════════════════════════════════ -->
    <!-- Add / Edit Modal                                       -->
    <!-- ══════════════════════════════════════════════════════ -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="user-form">

                            <!-- Cover Banner -->
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-user-settings-line me-2"></i>
                                            {{ $editMode ? 'Edit User' : 'Tambah User Baru' }}
                                        </h5>
                                        @if($editMode && $editedUserRole === 'SuperAdmin')
                                            <small class="text-white opacity-75"><i class="ri-shield-star-line me-1"></i>Super Administrator — role terkunci</small>
                                        @endif
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
                                            <div class="avatar-title bg-light rounded-circle border border-3 border-white shadow-sm" style="overflow:hidden;">
                                                <img id="avatar-preview"
                                                     src="{{ $photo ? $photo->temporaryUrl() : ($editMode && $currentPhoto ? asset('storage/' . $currentPhoto) : asset('assets/admin/images/users/user-dummy-img.jpg')) }}"
                                                     class="rounded-circle"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                        </div>
                                        <!-- Upload Button -->
                                        <label for="user-photo-trigger" class="position-absolute bottom-0 end-0 mb-1 me-1 cursor-pointer" title="Ubah foto profil">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                    <i class="ri-camera-line" style="font-size: 13px;"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="user-photo-trigger" class="d-none" accept="image/png,image/jpeg,image/webp">
                                        <!-- Hidden input untuk base64 hasil crop -->
                                        <input type="hidden" wire:model="form.photo_cropped" id="photo-cropped-input">
                                    </div>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem;">
                                        <i class="ri-crop-line me-1"></i>Klik foto untuk upload
                                    </p>
                                    @error('photo') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                </div>

                                <!-- Form Fields -->
                                <div class="row g-3">
                                    <!-- Username -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.username') is-invalid @enderror"
                                               wire:model="form.username" placeholder="Masukkan username">
                                        @error('form.username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Nama Lengkap -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.name') is-invalid @enderror"
                                               wire:model="form.name" placeholder="Masukkan nama lengkap">
                                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control @error('form.email') is-invalid @enderror"
                                               wire:model="form.email" placeholder="Masukkan email">
                                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No. Telepon</label>
                                        <input type="text" class="form-control @error('form.phone') is-invalid @enderror"
                                               wire:model="form.phone" placeholder="Masukkan no. telepon">
                                        @error('form.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Password (Create Only) -->
                                    @if(!$editMode)
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('form.password') is-invalid @enderror"
                                                   wire:model="form.password" placeholder="Minimal 6 karakter">
                                            @error('form.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('form.password_confirmation') is-invalid @enderror"
                                                   wire:model="form.password_confirmation" placeholder="Ulangi password">
                                            @error('form.password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endif

                                    <!-- Role -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                        @if($editMode && $editedUserRole === 'SuperAdmin')
                                            {{-- SuperAdmin: role terkunci, tidak bisa diubah --}}
                                            <div class="input-group">
                                                <span class="input-group-text bg-danger-subtle">
                                                    <i class="ri-shield-star-line text-danger"></i>
                                                </span>
                                                <input type="text" class="form-control fw-semibold" value="SuperAdmin" readonly disabled>
                                            </div>
                                            <div class="form-text text-muted">
                                                <i class="ri-information-line me-1"></i>Role SuperAdmin tidak dapat diubah.
                                            </div>
                                        @else
                                            <select class="form-select @error('form.role') is-invalid @enderror"
                                                    wire:model.live="form.role">
                                                <option value="">-- Pilih Role --</option>
                                                @if(!$editMode || auth()->user()->isSuperAdmin())
                                                    <option value="SuperAdmin">SuperAdmin</option>
                                                @endif
                                                <option value="Admin">Admin (Jurusan)</option>
                                                <option value="Operator">Operator</option>
                                            </select>
                                            @error('form.role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @endif
                                    </div>

                                    @if(($form['role'] ?? '') === 'Admin')
                                        <!-- Jurusan Selection -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
                                            <select class="form-select @error('form.jurusan_id') is-invalid @enderror"
                                                    wire:model="form.jurusan_id">
                                                <option value="">-- Pilih Jurusan --</option>
                                                @foreach($jurusans as $jur)
                                                    <option value="{{ $jur->id }}">{{ $jur->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('form.jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endif

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="isActive">User Aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah User' }}</span>
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

    <!-- ══════════════════════════════════════════════════════ -->
    <!-- Image Cropper Modal                                    -->
    <!-- ══════════════════════════════════════════════════════ -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ri-crop-line me-2"></i>Crop Foto Profil</h5>
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

    <!-- Change Password Modal -->
    @if($showPasswordModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="ri-lock-password-line me-2"></i>Ubah Password</h5>
                        <button type="button" class="btn-close" wire:click="$set('showPasswordModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="changePassword">
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-1"></i>Password minimal 6 karakter.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('passwordForm.new_password') is-invalid @enderror"
                                       wire:model="passwordForm.new_password" placeholder="Masukkan password baru">
                                @error('passwordForm.new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('passwordForm.new_password_confirmation') is-invalid @enderror"
                                       wire:model="passwordForm.new_password_confirmation" placeholder="Konfirmasi password baru">
                                @error('passwordForm.new_password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showPasswordModal', false)">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Ubah Password</span>
                                <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Mengubah...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>



@push('scripts')
<script src="{{ asset('assets/admin/libs/cropperjs/cropper.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/user-manager.js') }}"></script>
<script>
(function () {
    let cropper = null;

    // Buka file picker saat label diklik
    document.addEventListener('click', function (e) {
        if (e.target.closest('#user-photo-trigger-label') || e.target.closest('[for="user-photo-trigger"]')) {
            // handled by label
        }
    });

    // Saat file dipilih → tampilkan modal cropper
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'user-photo-trigger') {
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
            // Reset input agar file yang sama bisa dipilih lagi
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

    // Cleanup saat modal user ditutup
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-modal', () => {
            const photoInput = document.getElementById('photo-cropped-input');
            if (photoInput) photoInput.value = '';
            if (cropper) { cropper.destroy(); cropper = null; }
        });
    });
})();
</script>
@endpush
