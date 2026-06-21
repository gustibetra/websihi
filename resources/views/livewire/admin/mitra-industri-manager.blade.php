<div wire:key="mitra-industri-manager-component" class="news-wire-component">
    {{-- Search & Filter Bar --}}
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text"
                       class="form-control"
                       placeholder="Cari nama mitra atau bidang industri..."
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
                <i class="ri-add-fill align-bottom"></i> Tambah Mitra DU/DI
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmMitraBulkDelete()">
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
                    <th scope="col" style="width: 70px;" class="text-center">Logo</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('data1')" class="text-body text-decoration-none">
                            Nama Mitra @if($sortBy === 'data1') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Bidang Industri</th>
                    <th scope="col">Jenis Kerjasama</th>
                    <th scope="col">Kontak</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 160px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mitra as $item)
                    @php
                        $jkIds = !empty($item->data6) ? array_filter(explode(';', $item->data6)) : [];
                        $jkList = !empty($jkIds) ? \DB::table('common')->where('table_name', 'jenis_kerjasama')->whereIn('id', $jkIds)->get() : collect();
                    @endphp
                    <tr wire:key="mitra-{{ $item->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($mitra->currentPage() - 1) * $mitra->perPage() + $loop->iteration }}</td>
                        <td class="text-center">
                            @if($item->data3)
                                <img src="{{ asset('storage/' . $item->data3) }}"
                                     alt="{{ $item->data1 }}"
                                     class="rounded"
                                     style="width: 44px; height: 44px; object-fit: contain;">
                            @else
                                <div class="avatar-xs mx-auto">
                                    <span class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="ri-building-2-line"></i>
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary">{{ $item->data1 }}</strong>
                            @if($item->data2)
                                <br><a href="{{ $item->data2 }}" target="_blank" class="text-muted small"><i class="ri-global-line"></i> Website</a>
                            @endif
                        </td>
                        <td>
                            @if($item->data4)
                                <span class="badge bg-info-subtle text-info">{{ $item->data4 }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($jkList->count() > 0)
                                <div class="d-flex flex-wrap gap-1" style="max-width: 200px;">
                                    @foreach($jkList as $jk)
                                        <span class="badge bg-soft-success text-success" style="font-size: 10px; white-space: normal;">{{ $jk->data1 }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->data5)
                                <small><i class="ri-phone-line"></i> {{ $item->data5 }}</small>
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
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmMitraDelete({{ $item->id }}, '{{ addslashes($item->data1) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-building-2-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Belum ada data mitra DU/DI</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($mitra && $mitra->count() > 0)
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
                    Menampilkan {{ $mitra->firstItem() }} - {{ $mitra->lastItem() }} / {{ $mitra->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $mitra->links('vendor.pagination.bootstrap-5-always') }}
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
                            {{-- Cover Banner --}}
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #f06548 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-building-2-line me-2"></i>
                                            {{ $editMode ? 'Edit Mitra DU/DI' : 'Tambah Mitra DU/DI Baru' }}
                                        </h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)"></button>
                                    </div>
                                </div>
                            </div>

                            {{-- Logo Section --}}
                            <div class="text-center mt-n4 mb-3">
                                <div class="position-relative d-inline-block">
                                    <div style="width: 90px; height: 90px; margin: 0 auto; background: #fff; border-radius: 12px; border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.15); overflow: hidden;">
                                        @if($logo)
                                            <img src="{{ $logo->temporaryUrl() }}" style="width: 100%; height: 100%; object-fit: contain;">
                                        @elseif($existingLogo)
                                            <img src="{{ asset('storage/' . $existingLogo) }}" style="width: 100%; height: 100%; object-fit: contain;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                <i class="ri-building-2-line text-muted fs-24"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <label for="mitra-logo-input" class="position-absolute bottom-0 end-0 mb-n1 cursor-pointer" style="right: calc(50% - 45px); z-index: 10;" title="Upload logo">
                                        <div class="avatar-xs">
                                            <div class="avatar-title bg-primary rounded-circle text-white shadow">
                                                <i class="ri-camera-line" style="font-size: 13px;"></i>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" id="mitra-logo-input" class="d-none" wire:model="logo" accept="image/*">
                                </div>
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem;"><i class="ri-image-line me-1"></i>Upload Logo Mitra</p>
                                @error('logo') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                            </div>

                            <div class="px-4 pb-4">
                                <div class="row g-3">
                                    {{-- Nama Mitra --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Nama Mitra <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.data1') is-invalid @enderror"
                                               wire:model="form.data1" placeholder="Nama perusahaan / industri">
                                        @error('form.data1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Bidang Industri (Choices single-select from common data) --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bidang Industri</label>
                                        <div wire:ignore>
                                            <select id="mitra-bidang-industri" class="form-select">
                                                <option value="">-- Pilih Bidang Industri --</option>
                                                @foreach($bidangIndustriOptions as $bi)
                                                    <option value="{{ $bi->data1 }}"
                                                        {{ ($form['data4'] ?? '') === $bi->data1 ? 'selected' : '' }}>
                                                        {{ $bi->data1 }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Website --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Website</label>
                                        <input type="url" class="form-control @error('form.data2') is-invalid @enderror"
                                               wire:model="form.data2" placeholder="https://contoh.com">
                                        @error('form.data2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Kontak --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Telepon / Kontak</label>
                                        <input type="text" class="form-control"
                                               wire:model="form.data5" placeholder="Nomor telepon perusahaan">
                                    </div>

                                    {{-- Jenis Kerjasama (Choices multi-select) --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jenis Kerjasama</label>
                                        <div wire:ignore>
                                            <select id="mitra-jenis-kerjasama" class="form-select" multiple>
                                                @foreach($jenisKerjasamaOptions as $jk)
                                                    <option value="{{ $jk->id }}"
                                                        {{ in_array($jk->id, $form['jenis_kerjasama'] ?? []) ? 'selected' : '' }}>
                                                        {{ $jk->data1 }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control" wire:model="form.text2" rows="2" placeholder="Alamat lengkap perusahaan"></textarea>
                                    </div>

                                    {{-- Deskripsi Singkat --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Deskripsi / Profil Singkat</label>
                                        <textarea class="form-control" wire:model="form.text3" rows="3" placeholder="Profil singkat tentang mitra"></textarea>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status Kerjasama</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="mitraIsActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="mitraIsActive">Aktif / Tampilkan</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Mitra' }}</span>
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
        @php
            $selJkIds = !empty($selectedItem->data6) ? array_filter(explode(';', $selectedItem->data6)) : [];
            $selJkList = !empty($selJkIds) ? \DB::table('common')->where('table_name', 'jenis_kerjasama')->whereIn('id', $selJkIds)->get() : collect();
        @endphp
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header" style="background: linear-gradient(135deg, #405189 0%, #f06548 100%);">
                        <h5 class="modal-title text-white"><i class="ri-building-2-line me-2"></i>Detail Mitra DU/DI</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            @if($selectedItem->data3)
                                <img src="{{ asset('storage/' . $selectedItem->data3) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: contain;">
                            @else
                                <div class="avatar-lg mx-auto">
                                    <span class="avatar-title rounded bg-soft-primary text-primary fs-24">
                                        <i class="ri-building-2-line"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-1">{{ $selectedItem->data1 }}</h4>
                        @if($selectedItem->data4)
                            <p class="text-muted">Bidang: <strong>{{ $selectedItem->data4 }}</strong></p>
                        @endif

                        <div class="text-start table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%;" class="bg-light">Website</th>
                                        <td>
                                            @if($selectedItem->data2)
                                                <a href="{{ $selectedItem->data2 }}" target="_blank">{{ $selectedItem->data2 }}</a>
                                            @else -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Telepon</th>
                                        <td>{{ $selectedItem->data5 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Alamat</th>
                                        <td>{{ $selectedItem->text2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jenis Kerjasama</th>
                                        <td>
                                            @if($selJkList->count() > 0)
                                                @foreach($selJkList as $jk)
                                                    <span class="badge bg-success-subtle text-success me-1">{{ $jk->data1 }}</span>
                                                @endforeach
                                            @else -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($selectedItem->text3)
                            <div class="text-start mt-2">
                                <h6 class="fw-semibold text-primary">Profil Mitra:</h6>
                                <p class="text-muted">{{ $selectedItem->text3 }}</p>
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
<script>
(function () {
    let mitraChoicesJK = null;      // Jenis Kerjasama (multi)
    let mitraChoicesBI = null;      // Bidang Industri (single)

    function initMitraChoices(jenisKerjasamaSelected, bidangIndustriSelected) {
        // --- Jenis Kerjasama (multi-select) ---
        const elJK = document.getElementById('mitra-jenis-kerjasama');
        if (elJK) {
            if (mitraChoicesJK) { mitraChoicesJK.destroy(); mitraChoicesJK = null; }

            if (typeof Choices !== 'undefined') {
                // Sync selected before init
                Array.from(elJK.options).forEach(option => {
                    option.selected = (jenisKerjasamaSelected || []).map(String).includes(option.value.toString());
                });

                mitraChoicesJK = new Choices(elJK, {
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Pilih Jenis Kerjasama',
                    searchEnabled: true,
                    searchPlaceholderValue: 'Cari...',
                    itemSelectText: ''
                });

                if (jenisKerjasamaSelected && jenisKerjasamaSelected.length > 0) {
                    mitraChoicesJK.setChoiceByValue(jenisKerjasamaSelected.map(String));
                }

                elJK.addEventListener('change', function () {
                    const selected = mitraChoicesJK.getValue(true);
                    const selectedStr = Array.isArray(selected) ? selected.map(String) : (selected ? [String(selected)] : []);
                    const componentEl = elJK.closest('[wire\\:id]');
                    if (componentEl && window.Livewire) {
                        window.Livewire.find(componentEl.getAttribute('wire:id')).set('form.jenis_kerjasama', selectedStr);
                    }
                });
            }
        }

        // --- Bidang Industri (single-select with search) ---
        const elBI = document.getElementById('mitra-bidang-industri');
        if (elBI) {
            if (mitraChoicesBI) { mitraChoicesBI.destroy(); mitraChoicesBI = null; }

            if (typeof Choices !== 'undefined') {
                // Sync selected before init
                if (bidangIndustriSelected) {
                    Array.from(elBI.options).forEach(opt => {
                        opt.selected = opt.value === bidangIndustriSelected;
                    });
                }

                mitraChoicesBI = new Choices(elBI, {
                    removeItemButton: false,
                    placeholder: true,
                    placeholderValue: '-- Pilih Bidang Industri --',
                    searchEnabled: true,
                    searchPlaceholderValue: 'Cari bidang industri...',
                    itemSelectText: ''
                });

                if (bidangIndustriSelected) {
                    mitraChoicesBI.setChoiceByValue(bidangIndustriSelected);
                }

                elBI.addEventListener('change', function () {
                    const selected = mitraChoicesBI.getValue(true);
                    const componentEl = elBI.closest('[wire\\:id]');
                    if (componentEl && window.Livewire) {
                        window.Livewire.find(componentEl.getAttribute('wire:id')).set('form.data4', selected || '');
                    }
                });
            }
        }
    }

    window.addEventListener('open-mitra-modal', (event) => {
        const data = event.detail[0] || event.detail || {};
        const jenisKerjasama = data.jenisKerjasama || [];
        const bidangIndustri = data.bidangIndustri || '';
        setTimeout(() => {
            initMitraChoices(jenisKerjasama, bidangIndustri);
        }, 200);
    });

    document.addEventListener('livewire:initialized', function () {
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

    window.confirmMitraDelete = function (id, name) {
        const message = `Mitra "${name}" akan dihapus secara permanen!`;
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    const $component = document.querySelector('[wire\\:id]');
                    if ($component && window.Livewire) {
                        window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                    }
                }
            });
        } else if (confirm(`Hapus mitra "${name}"?`)) {
            const $component = document.querySelector('[wire\\:id]');
            if ($component && window.Livewire) {
                window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
            }
        }
    };

    window.confirmMitraBulkDelete = function () {
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
