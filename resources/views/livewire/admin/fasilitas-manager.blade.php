<div wire:key="fasilitas-manager-component" class="news-wire-component">
    {{-- Search & Filter Bar --}}
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text"
                       class="form-control"
                       placeholder="Cari nama atau lokasi fasilitas..."
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
                <i class="ri-add-fill align-bottom"></i> Tambah Fasilitas
            </button>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div wire:ignore class="flash-message-success" data-message="{{ session('message') }}"></div>
    @endif

    {{-- Bulk Actions Bar --}}
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmFasilitasBulkDelete()">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Table --}}
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
                        <a href="#" wire:click.prevent="sortByColumn('data1')" class="text-body text-decoration-none">
                            Nama Fasilitas @if($sortBy === 'data1') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kapasitas</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 160px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fasilitas as $item)
                    <tr wire:key="fasilitas-{{ $item->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($fasilitas->currentPage() - 1) * $fasilitas->perPage() + $loop->iteration }}</td>
                        <td>
                            @php
                                $photos = array_filter(explode(';', $item->data6 ?? ''));
                                $firstPhoto = !empty($photos) ? reset($photos) : null;
                            @endphp
                            @if($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto) }}"
                                     alt="{{ $item->data1 }}"
                                     class="rounded cursor-pointer"
                                     style="width: 50px; height: 40px; object-fit: cover;"
                                     onclick="openFasilitasPreviewModal('{{ asset('storage/' . $firstPhoto) }}')">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded bg-soft-success text-success">
                                        <i class="ri-home-office-line"></i>
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary">{{ $item->data1 }}</strong>
                            @php $photoCnt = count(array_filter(explode(';', $item->data6 ?? ''))); @endphp
                            @if($photoCnt > 1)
                                <br><small class="text-muted"><i class="ri-image-line"></i> {{ $photoCnt }} foto</small>
                            @endif
                        </td>
                        <td>{{ $item->data2 ?? '-' }}</td>
                        <td>
                            @if($item->data4)
                                <span class="badge bg-info-subtle text-info">{{ $item->data4 }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
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
                                <button type="button" class="btn btn-sm btn-info" wire:click="openInfoModal({{ $item->id }})" title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openEditModal({{ $item->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmFasilitasDelete({{ $item->id }}, '{{ addslashes($item->data1) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-home-office-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Belum ada data fasilitas</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($fasilitas && $fasilitas->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                        <option value="8">8</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <span class="text-muted">|</span>
                <div class="text-muted">
                    Menampilkan {{ $fasilitas->firstItem() }} - {{ $fasilitas->lastItem() }} / {{ $fasilitas->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $fasilitas->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    {{-- Add / Edit Modal --}}
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off">
                            {{-- Cover Banner (SDM style) --}}
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #0ab39c 0%, #405189 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-home-office-line me-2"></i>
                                            {{ $editMode ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru' }}
                                        </h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)" onclick="window.dispatchEvent(new Event('close-fasilitas-modal'))"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="row g-3">
                                    {{-- Nama Fasilitas --}}
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Nama Fasilitas <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.data1') is-invalid @enderror"
                                               wire:model="form.data1" placeholder="Contoh: Laboratorium Komputer">
                                        @error('form.data1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Kapasitas --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Kapasitas</label>
                                        <input type="text" class="form-control"
                                               wire:model="form.data4" placeholder="Contoh: 36 Orang">
                                    </div>

                                    {{-- Lokasi --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Lokasi</label>
                                        <input type="text" class="form-control"
                                               wire:model="form.data2" placeholder="Contoh: Gedung B Lantai 2">
                                    </div>

                                    {{-- Deskripsi (CKEditor) --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Deskripsi Fasilitas</label>
                                        <div wire:ignore>
                                            <div id="fasilitas-ckeditor"
                                                 data-ckeditor-upload-url="/admin/news/upload-image"
                                                 data-ckeditor-content="{{ $form['text1'] ?? '' }}"></div>
                                        </div>
                                        <textarea class="d-none" id="fasilitas-text1-hidden" wire:model="form.text1"></textarea>
                                        @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Gambar (Multiple) --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Gambar Fasilitas <small class="text-muted fw-normal">(Bisa upload beberapa)</small></label>
                                        <input type="file" class="form-control" wire:model="newImages" multiple accept="image/*">
                                        @error('newImages.*') <span class="text-danger small d-block">{{ $message }}</span> @enderror

                                        {{-- Preview new images --}}
                                        @if($newImages)
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($newImages as $img)
                                                    <img src="{{ $img->temporaryUrl() }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Preview existing images --}}
                                        @if(!empty($existingImages))
                                            <div class="d-flex flex-wrap gap-2 mt-3 p-2 bg-light border rounded">
                                                <p class="w-100 mb-1 small fw-medium text-dark">Foto Terunggah:</p>
                                                @foreach($existingImages as $index => $imgPath)
                                                    <div class="position-relative">
                                                        <a href="javascript:void(0)" onclick="openFasilitasPreviewModal('{{ asset('storage/' . $imgPath) }}')">
                                                            <img src="{{ asset('storage/' . $imgPath) }}" class="img-thumbnail border-secondary" style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>
                                                        <button type="button" wire:click="removeImage({{ $index }})" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle p-1" style="width: 24px; height: 24px; line-height: 1;">
                                                            <i class="ri-close-line fs-14"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status Tampil</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="fasilitasIsActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="fasilitasIsActive">Aktif / Tampilkan</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)" onclick="window.dispatchEvent(new Event('close-fasilitas-modal'))">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Fasilitas' }}</span>
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

    {{-- Info / Detail Modal --}}
    @if($showInfoModal && $selectedItem)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title text-white"><i class="ri-home-office-line me-2"></i>Detail Fasilitas</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $infPhotos = array_filter(explode(';', $selectedItem->data6 ?? ''));
                        @endphp
                        @if(!empty($infPhotos))
                            <div class="row g-2 mb-3">
                                @foreach($infPhotos as $ph)
                                    <div class="col-4 col-md-3">
                                        <img src="{{ asset('storage/' . $ph) }}" class="img-fluid rounded border shadow-sm cursor-pointer"
                                             style="height: 100px; width: 100%; object-fit: cover;"
                                             onclick="openFasilitasPreviewModal('{{ asset('storage/' . $ph) }}')">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <h4 class="fw-bold text-success mb-2">{{ $selectedItem->data1 }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%;" class="bg-light">Lokasi</th>
                                        <td>{{ $selectedItem->data2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kapasitas</th>
                                        <td>{{ $selectedItem->data4 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @if($selectedItem->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($selectedItem->text1)
                            <div class="mt-3">
                                <h6 class="fw-semibold text-success"><i class="ri-file-text-line me-1"></i>Deskripsi:</h6>
                                <div class="bg-light p-3 rounded border">
                                    {!! $selectedItem->text1 !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showInfoModal', false)">Tutup</button>
                        <button type="button" class="btn btn-primary" wire:click="openEditModal({{ $selectedItem->id }}); $set('showInfoModal', false)">
                            <i class="ri-pencil-line me-1"></i>Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    {{-- Photo Preview Modal --}}
    <div class="modal fade" id="fasilitasPreviewModal" tabindex="-1" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img id="fasilitasPreviewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/libs/ckeditor5/build/ckeditor.js') }}"></script>
<script>
(function () {
    let fasilitasEditorInstance = null;
    let isDestroyingFasilitasEditor = false;

    function initFasilitasEditor(initialContent) {
        const el = document.getElementById('fasilitas-ckeditor');
        if (!el || fasilitasEditorInstance || isDestroyingFasilitasEditor) return;

        if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
            DKApps.initCKEditor('fasilitas-ckeditor', initialContent || '', '/admin/news/upload-image')
                .then(function(editor) {
                    fasilitasEditorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        const content = editor.getData();
                        const textarea = document.getElementById('fasilitas-text1-hidden');
                        if (textarea) {
                            textarea.value = content;
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Failed to init fasilitas CKEditor:', error);
                });
        }
    }

    function destroyFasilitasEditor() {
        if (!fasilitasEditorInstance || isDestroyingFasilitasEditor) return;

        const instance = fasilitasEditorInstance;
        fasilitasEditorInstance = null;
        isDestroyingFasilitasEditor = true;

        if (!instance.sourceElement || !instance.sourceElement.isConnected) {
            isDestroyingFasilitasEditor = false;
            return;
        }

        Promise.resolve(instance.destroy())
            .catch(err => {
                console.warn('Skipping fasilitas CKEditor destroy:', err);
            })
            .finally(() => {
                isDestroyingFasilitasEditor = false;
            });
    }

    window.addEventListener('open-fasilitas-modal', (event) => {
        const data = event.detail[0] || event.detail || {};
        const content = data.content || '';
        setTimeout(() => {
            initFasilitasEditor(content);
        }, 250);
    });

    window.addEventListener('close-fasilitas-modal', () => {
        destroyFasilitasEditor();
    });

    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-fasilitas-modal', () => {
            destroyFasilitasEditor();
        });

        window.addEventListener('show-toast', function (event) {
            const data = event.detail[0] || event.detail;
            const type = data.type || 'info';
            const message = data.message || '';
            if (typeof showToast === 'function') {
                showToast(message, type);
            } else {
                alert(message);
            }
        });

        Livewire.on('bulk-action-completed', () => {
            const selectAllCheck = document.querySelector('input[wire\\:model\\.live="selectAll"]');
            if (selectAllCheck) selectAllCheck.checked = false;
        });
    });

    window.openFasilitasPreviewModal = function(src) {
        document.getElementById('fasilitasPreviewImage').src = src;
        var modal = new bootstrap.Modal(document.getElementById('fasilitasPreviewModal'));
        modal.show();
    };

    window.confirmFasilitasDelete = function(id, name) {
        const message = `Fasilitas "${name}" akan dihapus secara permanen!`;
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    const $component = document.querySelector('[wire\\:id]');
                    if ($component && window.Livewire) {
                        window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                    }
                }
            });
        } else if (confirm(`Hapus fasilitas "${name}"?`)) {
            const $component = document.querySelector('[wire\\:id]');
            if ($component && window.Livewire) {
                window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
            }
        }
    };

    window.confirmFasilitasBulkDelete = function() {
        const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
        const component = Livewire.find(componentId);
        const count = component.get('selectedItems').length;
        if (count === 0) {
            if (typeof showError === 'function') showError('Pilih minimal satu data untuk dihapus');
            return;
        }
        if (typeof showBulkDeleteConfirm === 'function') {
            showBulkDeleteConfirm(count).then((result) => {
                if (result.isConfirmed) component.call('bulkDelete');
            });
        } else if (confirm(`Hapus ${count} data terpilih?`)) {
            component.call('bulkDelete');
        }
    };
})();
</script>
@endpush
