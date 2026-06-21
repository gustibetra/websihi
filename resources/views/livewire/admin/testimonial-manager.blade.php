<div wire:key="testimonial-manager-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari nama, role, atau konten..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" wire:model.live="statusFilter">
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-5 text-end">
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Testimoni
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
                        <a href="#" wire:click.prevent="sortByColumn('role')" class="text-body text-decoration-none">
                            Role / Jabatan @if($sortBy === 'role') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 120px;">Rating</th>
                    <th scope="col">Kutipan Testimoni</th>
                    <th scope="col" style="width: 80px;" class="text-center">Order</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $item)
                    <tr wire:key="testimonial-{{ $item->id }}">
                        <td>{{ $item->id }}</td>
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
                        <td>{{ $item->role }}</td>
                        <td>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $item->rating)
                                        <i class="ri-star-fill"></i>
                                    @else
                                        <i class="ri-star-line text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>
                            <span class="text-muted" style="display: inline-block; max-width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->content }}">
                                "{{ $item->content }}"
                            </span>
                        </td>
                        <td class="text-center">{{ $item->order }}</td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($item->is_active)
                                    <button type="button" class="btn btn-sm btn-warning" wire:click="toggleStatus({{ $item->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-success" wire:click="toggleStatus({{ $item->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openEditModal({{ $item->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmTestimonialDelete({{ $item->id }}, '{{ addslashes($item->name) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-discuss-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data testimoni</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($testimonials && $testimonials->count() > 0)
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
                    Menampilkan {{ $testimonials->firstItem() }} - {{ $testimonials->lastItem() }} / {{ $testimonials->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $testimonials->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Add / Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="testimonial-form">
                            <!-- Cover Banner -->
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-discuss-line me-2"></i>
                                            {{ $editMode ? 'Edit Testimoni' : 'Tambah Testimoni Baru' }}
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
                                                     src="{{ $photo ? $photo->temporaryUrl() : ($editMode && $currentPhoto ? asset('storage/' . $currentPhoto) : asset('assets/admin/images/users/user-dummy-img.jpg')) }}"
                                                     class="rounded-circle"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                        </div>
                                        <!-- Upload Button -->
                                        <label for="testimonial-photo-trigger" class="position-absolute bottom-0 end-0 mb-1 me-1 cursor-pointer" style="left: 60px;" title="Ubah foto">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                    <i class="ri-camera-line" style="font-size: 13px;"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="testimonial-photo-trigger" class="d-none" accept="image/png,image/jpeg,image/webp">
                                        <!-- Hidden input untuk base64 hasil crop -->
                                        <input type="hidden" wire:model="form.photo_cropped" id="photo-cropped-input">
                                    </div>
                                    <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem;">
                                        <i class="ri-crop-line me-1"></i>Klik ikon kamera untuk upload (Opsional)
                                    </p>
                                    @error('photo') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                </div>

                                <!-- Form Fields -->
                                <div class="row g-3">
                                    <!-- Nama -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Pemberi Testimoni <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.name') is-invalid @enderror"
                                               wire:model="form.name" placeholder="Nama lengkap pemberi testimoni">
                                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Role / Jabatan / Identitas <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.role') is-invalid @enderror"
                                               wire:model="form.role" placeholder="Contoh: Alumni 2021, Kepala HRD PT Telkom">
                                        @error('form.role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Rating -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Rating Bintang <span class="text-danger">*</span></label>
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ri-star-{{ $i <= ($form['rating'] ?? 5) ? 'fill' : 'line' }} fs-24 text-warning cursor-pointer" 
                                                   wire:click="$set('form.rating', {{ $i }})"
                                                   title="{{ $i }} Bintang"
                                                   style="font-size: 1.5rem; transition: transform 0.1s; cursor: pointer;"
                                                   onmouseover="this.style.transform='scale(1.2)'"
                                                   onmouseout="this.style.transform='scale(1)'"></i>
                                            @endfor
                                        </div>
                                        @error('form.rating') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Urutan & Status -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Urutan Tampil</label>
                                        <input type="number" class="form-control @error('form.order') is-invalid @enderror"
                                               wire:model="form.order" placeholder="0">
                                        @error('form.order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="isActive">Aktif</label>
                                        </div>
                                    </div>

                                    <!-- Konten Testimoni -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Isi Testimoni <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('form.content') is-invalid @enderror" 
                                                  wire:model="form.content" rows="4" placeholder="Tuliskan testimoni di sini..."></textarea>
                                        @error('form.content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Testimoni' }}</span>
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
                    <h5 class="modal-title"><i class="ri-crop-line me-2"></i>Crop Foto Testimoni</h5>
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
</div>

@push('scripts')
<script src="{{ asset('assets/admin/libs/cropperjs/cropper.min.js') }}"></script>
<script>
(function () {
    let cropper = null;

    // Saat file dipilih → tampilkan modal cropper
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'testimonial-photo-trigger') {
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

    // Cleanup saat modal ditutup
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-modal', () => {
            const photoInput = document.getElementById('photo-cropped-input');
            if (photoInput) photoInput.value = '';
            if (cropper) { cropper.destroy(); cropper = null; }
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
    });

    window.confirmTestimonialDelete = function (id, name) {
        const message = `Data Testimoni dari "${name}" akan dihapus secara permanen!`;
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
            if (confirm(`Apakah Anda yakin ingin menghapus data "${name}"?`)) {
                const $component = document.querySelector('[wire\\:id]');
                if ($component && window.Livewire) {
                    window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                }
            }
        }
    };
})();
</script>
@endpush
