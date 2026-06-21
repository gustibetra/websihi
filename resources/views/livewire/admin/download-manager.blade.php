<div wire:key="download-manager-component" class="downloads-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari judul dokumen..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" wire:model.live="categoryFilter">
                <option value="all">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->data1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" wire:model.live="jurusanFilter" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                @if(!auth()->user()->isAdminJurusan())
                    <option value="all">Semua Jurusan</option>
                    <option value="umum">Umum (Umum/Semua)</option>
                @endif
                @foreach($jurusans as $jur)
                    <option value="{{ $jur->id }}">{{ $jur->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col text-end">
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Dokumen
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmDownloadBulkDelete()">
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
                    <th scope="col">Jurusan</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('title')" class="text-body text-decoration-none">
                            Judul Dokumen @if($sortBy === 'title') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Ukuran</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('created_at')" class="text-body text-decoration-none">
                            Tanggal Diunggah @if($sortBy === 'created_at') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($downloads as $dl)
                    <tr wire:key="download-{{ $dl->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $dl->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($downloads->currentPage() - 1) * $downloads->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($dl->jurusan)
                                <span class="badge bg-success-subtle text-success">{{ $dl->jurusan->nama }}</span>
                            @else
                                <span class="badge bg-primary-subtle text-primary">Umum / Semua</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-dark">{{ $dl->title }}</strong>
                            @if($dl->description)
                                <br><small class="text-muted text-wrap d-inline-block" style="max-width: 300px;">{{ Str::limit($dl->description, 60) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $dl->category?->data1 ?? '-' }}</span>
                        </td>
                        <td>
                            <code class="text-secondary">{{ $dl->file_size ?? '-' }}</code>
                        </td>
                        <td>
                            {{ $dl->created_at ? $dl->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="text-center">
                            @if($dl->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($dl->is_active)
                                    <button type="button" class="btn btn-sm btn-warning" wire:click="toggleStatus({{ $dl->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-success" wire:click="toggleStatus({{ $dl->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <a href="{{ asset('storage/' . $dl->file_path) }}" class="btn btn-sm btn-primary" target="_blank" download title="Download">
                                    <i class="ri-download-2-line"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-info" wire:click="openInfoModal({{ $dl->id }})" title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" wire:click="openEditModal({{ $dl->id }})" title="Edit">
                                    <i class="ri-pencil-fill"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDownloadDelete({{ $dl->id }}, '{{ addslashes($dl->title) }}')" title="Hapus">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="ri-file-warning-line fs-24 d-block mb-2 text-warning"></i>
                            Tidak ada data dokumen ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Menampilkan {{ $downloads->firstItem() ?? 0 }} sampai {{ $downloads->lastItem() ?? 0 }} dari {{ $downloads->total() }} data
        </div>
        <div>
            {{ $downloads->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade @if($showModal) show d-block @endif" tabindex="-1" style="background: rgba(0,0,0,0.5);" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title">{{ $editMode ? 'Edit Dokumen' : 'Tambah Dokumen Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Title -->
                            <div class="col-lg-12">
                                <label class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('form.title') is-invalid @enderror" placeholder="Contoh: Formulir Pendaftaran PPDB 2026" wire:model="form.title">
                                @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('form.category_id') is-invalid @enderror" wire:model="form.category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->data1 }}</option>
                                    @endforeach
                                </select>
                                @error('form.category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Jurusan -->
                            <div class="col-md-6">
                                <label class="form-label">Program Jurusan</label>
                                <select class="form-select @error('form.jurusan_id') is-invalid @enderror" wire:model="form.jurusan_id" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                    @if(!auth()->user()->isAdminJurusan())
                                        <option value="">Umum (Semua Jurusan)</option>
                                    @endif
                                    @foreach($jurusans as $jur)
                                        <option value="{{ $jur->id }}">{{ $jur->nama }}</option>
                                    @endforeach
                                </select>
                                @error('form.jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="col-lg-12">
                                <label class="form-label">File Dokumen <span class="text-danger">@if(!$editMode)*@endif</span></label>
                                <input type="file" class="form-control @error('fileUpload') is-invalid @enderror" wire:model="fileUpload">
                                <small class="text-muted d-block mt-1">Ukuran maksimal file: 20MB. Format didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, PNG, JPG, JPEG, TXT.</small>
                                
                                @if($editMode && $existingFilePath)
                                    <div class="mt-2 p-2 bg-light rounded d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="ri-file-line text-primary fs-18 align-middle me-1"></i>
                                            <span class="text-dark fw-medium">{{ basename($existingFilePath) }}</span>
                                            <span class="text-muted font-size-12">({{ $existingFileSize }})</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $existingFilePath) }}" target="_blank" class="btn btn-sm btn-soft-secondary">
                                            <i class="ri-eye-line align-middle"></i> Lihat
                                        </a>
                                    </div>
                                @endif

                                @error('fileUpload') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                
                                <!-- Uploading status -->
                                <div wire:loading wire:target="fileUpload" class="mt-2 text-info">
                                    <div class="spinner-border spinner-border-sm align-middle me-1" role="status"></div>
                                    Mengunggah file... mohon tunggu.
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-12">
                                <label class="form-label">Deskripsi / Catatan (Optional)</label>
                                <textarea class="form-control" rows="3" placeholder="Tambahkan penjelasan singkat tentang file ini..." wire:model="form.description"></textarea>
                            </div>

                            <!-- Is Active -->
                            <div class="col-lg-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="dlIsActive" wire:model="form.is_active">
                                    <label class="form-check-label" for="dlIsActive">Aktif (Tampilkan di halaman publik)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Modal -->
    <div class="modal fade @if($showInfoModal) show d-block @endif" tabindex="-1" style="background: rgba(0,0,0,0.5);" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title">Detail Dokumen</h5>
                    <button type="button" class="btn-close" wire:click="$set('showInfoModal', false)" aria-label="Close"></button>
                </div>
                @if($selectedDownload)
                    <div class="modal-body p-0">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 35%;">Judul</th>
                                    <td><strong>{{ $selectedDownload->title }}</strong></td>
                                </tr>
                                <tr>
                                    <th scope="row">Kategori</th>
                                    <td>{{ $selectedDownload->category?->data1 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jurusan</th>
                                    <td>{{ $selectedDownload->jurusan?->nama ?? 'Umum (Semua)' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">File</th>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-truncate" style="max-width: 200px;" title="{{ basename($selectedDownload->file_path) }}">
                                                {{ basename($selectedDownload->file_path) }}
                                            </span>
                                            <a href="{{ asset('storage/' . $selectedDownload->file_path) }}" class="btn btn-xs btn-primary ms-2" target="_blank" download>
                                                <i class="ri-download-line"></i> Download ({{ $selectedDownload->file_size }})
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Deskripsi</th>
                                    <td><p class="mb-0 text-muted">{{ $selectedDownload->description ?: 'Tidak ada deskripsi.' }}</p></td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>
                                        @if($selectedDownload->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Diunggah Oleh</th>
                                    <td>{{ $selectedDownload->creator?->name ?? 'System' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Waktu Unggah</th>
                                    <td>{{ $selectedDownload->created_at ? $selectedDownload->created_at->format('d M Y, H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Diupdate Oleh</th>
                                    <td>{{ $selectedDownload->updater?->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Waktu Update</th>
                                    <td>{{ $selectedDownload->updated_at ? $selectedDownload->updated_at->format('d M Y, H:i') : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showInfoModal', false)">Tutup</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    document.addEventListener('livewire:initialized', function () {
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
            const selectAllCheck = document.querySelector('input[wire\\:model\\.live="selectAll"]');
            if (selectAllCheck) selectAllCheck.checked = false;
        });
    });

    window.confirmDownloadDelete = function (id, title) {
        const message = `Dokumen "${title}" akan dihapus secara permanen!`;
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
            if (confirm(`Apakah Anda yakin ingin menghapus data "${title}"?`)) {
                const $component = document.querySelector('[wire\\:id]');
                if ($component && window.Livewire) {
                    window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                }
            }
        }
    };

    window.confirmDownloadBulkDelete = function () {
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
