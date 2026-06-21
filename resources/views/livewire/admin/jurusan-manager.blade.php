<div wire:key="jurusan-manager-component" class="news-wire-component">
    {{-- Search & Filter Bar --}}
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text"
                       class="form-control"
                       placeholder="Cari program jurusan..."
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
                <i class="ri-add-fill align-bottom"></i> Tambah Program Jurusan
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmJurusanBulkDelete()">
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
                        <a href="#" wire:click.prevent="sortByColumn('nama')" class="text-body text-decoration-none">
                            Nama Program Keahlian @if($sortBy === 'nama') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col" style="width: 120px;">
                        <a href="#" wire:click.prevent="sortByColumn('kode')" class="text-body text-decoration-none">
                            Kode @if($sortBy === 'kode') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Ketua Jurusan / Ka. Prodi</th>
                    <th scope="col" class="text-center">Akreditasi</th>
                    <th scope="col">Kurikulum</th>
                    <th scope="col">Kompetensi Keahlian</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 160px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $item)
                    @php
                        $skills = $kompetensiKeahlian->get($item->id) ?? collect();
                    @endphp
                    <tr wire:key="program-{{ $item->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($programs->currentPage() - 1) * $programs->perPage() + $loop->iteration }}</td>
                        <td class="text-center">
                            @if($item->logo)
                                <img src="{{ asset('storage/' . $item->logo) }}"
                                     alt="{{ $item->nama }}"
                                     class="rounded"
                                     style="width: 44px; height: 44px; object-fit: contain; cursor: pointer;"
                                     onclick="openJurusanPreviewModal('{{ asset('storage/' . $item->logo) }}')">
                            @else
                                <div class="avatar-xs mx-auto">
                                    <span class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="ri-book-2-line"></i>
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary">{{ $item->nama }}</strong>
                            <div class="text-muted small">Singkatan: {{ $item->singkatan }}</div>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary fs-11">{{ $item->kode }}</span>
                        </td>
                        <td>
                            @if($item->kepalaProdi)
                                <span><i class="ri-user-star-line text-secondary align-middle me-1"></i>{{ $item->kepalaProdi->name }}</span>
                            @elseif($item->ka_prodi)
                                <span><i class="ri-user-star-line text-secondary align-middle me-1"></i>{{ $item->ka_prodi }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->akreditasi)
                                <span class="badge bg-{{ $item->akreditasi === 'A' ? 'success' : ($item->akreditasi === 'B' ? 'warning' : 'secondary') }}-subtle 
                                                   text-{{ $item->akreditasi === 'A' ? 'success' : ($item->akreditasi === 'B' ? 'warning' : 'secondary') }}">
                                    {{ $item->akreditasi }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->kurikulum)
                                <span class="badge bg-info-subtle text-info">{{ $item->kurikulum }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            @if($skills->isNotEmpty())
                                <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                    @foreach($skills as $sk)
                                        <span class="badge bg-soft-success text-success" style="font-size: 10px; white-space: normal;">{{ $sk->data1 }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small">-</span>
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
                                    <i class="ri-information-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openEditModal({{ $item->id }})" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmJurusanDelete({{ $item->id }}, '{{ $item->nama }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2 text-muted">Belum ada data Program Jurusan</h5>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3 px-3">
        <div class="text-muted small">
            Menampilkan {{ $programs->firstItem() ?? 0 }} sampai {{ $programs->lastItem() ?? 0 }} dari {{ $programs->total() }} data
        </div>
        <div>
            {{ $programs->links() }}
        </div>
    </div>

    {{-- Add/Edit Modal --}}
    @if($showModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body p-0">
                    <form wire:submit.prevent="save" autocomplete="off">
                        {{-- Cover Banner --}}
                        <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #0ab39c 0%, #405189 100%);">
                            <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                <div class="flex-grow-1">
                                    <h5 class="modal-title text-white fw-semibold">
                                        <i class="ri-book-2-line me-2"></i>
                                        {{ $editMode ? 'Edit Program Jurusan' : 'Tambah Program Jurusan Baru' }}
                                    </h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)" onclick="window.dispatchEvent(new Event('close-fasilitas-modal'))"></button>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="row g-3">
                                {{-- Logo Jurusan --}}
                                <div class="col-md-4 text-center border-end">
                                    <label class="form-label d-block fw-semibold">Logo Jurusan</label>
                                    <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 150px;">
                                        @if ($logo)
                                            <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                                        @elseif ($existingLogo)
                                            <img src="{{ asset('storage/' . $existingLogo) }}" class="img-thumbnail" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                                        @else
                                            <div class="rounded border bg-light d-flex flex-column justify-content-center align-items-center w-100 h-100 text-muted">
                                                <i class="ri-image-2-line fs-1"></i>
                                                <span class="small">Belum Ada Logo</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control form-control-sm" wire:model="logo" accept="image/*">
                                    <div wire:loading wire:target="logo" class="text-muted small mt-1">Mengupload logo...</div>
                                    @error('logo') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Form Fields --}}
                                <div class="col-md-8">
                                    {{-- Tabs for organizing fields --}}
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-3" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#jurusan-tab-identitas" role="tab"><i class="ri-profile-line me-1"></i> Identitas</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#jurusan-tab-profil" role="tab"><i class="ri-file-text-line me-1"></i> Profil</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#jurusan-tab-kontak" role="tab"><i class="ri-contacts-line me-1"></i> Kontak & Media</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        {{-- TAB: Identitas --}}
                                        <div class="tab-pane active" id="jurusan-tab-identitas" role="tabpanel">
                                            <div class="row g-3">
                                                {{-- Kode --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Kode Program <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('form.kode') is-invalid @enderror"
                                                           wire:model="form.kode" placeholder="Contoh: RPL">
                                                    @error('form.kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Singkatan --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Singkatan <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('form.singkatan') is-invalid @enderror"
                                                           wire:model="form.singkatan" placeholder="Contoh: RPL">
                                                    @error('form.singkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Nama --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Nama Program Keahlian <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('form.nama') is-invalid @enderror"
                                                           wire:model="form.nama" placeholder="Contoh: Rekayasa Perangkat Lunak">
                                                    @error('form.nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Ketua Jurusan / Ka. Prodi --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Ketua Jurusan / Ka. Prodi</label>
                                                    <div class="position-relative">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" 
                                                                   placeholder="Cari nama atau NIP guru..."
                                                                   wire:model.live.debounce.300ms="kaProdiSearch"
                                                                   @if($selectedKaProdiId) disabled @endif>
                                                            @if($selectedKaProdiId)
                                                                <button type="button" class="btn btn-outline-danger" wire:click="clearKaProdi">
                                                                    <i class="ri-close-line"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(!empty($kaProdiSearchResults))
                                                            <div class="position-absolute start-0 end-0 bg-white border rounded shadow-lg z-3 mt-1" style="max-height: 200px; overflow-y: auto;">
                                                                @foreach($kaProdiSearchResults as $teacher)
                                                                    <a href="javascript:void(0);" 
                                                                       class="d-block p-2 text-decoration-none border-bottom text-dark hover-bg-light"
                                                                       wire:click="selectKaProdi({{ $teacher['id'] }}, '{{ addslashes($teacher['name']) }}')">
                                                                        <div class="fw-semibold">{{ $teacher['name'] }}</div>
                                                                        <small class="text-muted">NIP: {{ $teacher['nip'] ?: '-' }}</small>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @error('form.ka_prodi') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </div>

                                                {{-- Akreditasi --}}
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Akreditasi</label>
                                                    <select class="form-select" wire:model="form.akreditasi">
                                                        <option value="">-- Pilih --</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="Unggul">Unggul</option>
                                                        <option value="Baik Sekali">Baik Sekali</option>
                                                        <option value="Baik">Baik</option>
                                                        <option value="Tidak Terakreditasi">Belum</option>
                                                    </select>
                                                </div>

                                                {{-- Tahun Berdiri --}}
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Tahun Berdiri</label>
                                                    <input type="number" class="form-control @error('form.tahun_berdiri') is-invalid @enderror"
                                                           wire:model="form.tahun_berdiri" placeholder="2000" min="1900" max="2099">
                                                    @error('form.tahun_berdiri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Kurikulum --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Kurikulum</label>
                                                    <select class="form-select" wire:model="form.kurikulum">
                                                        <option value="">-- Pilih Kurikulum --</option>
                                                        @foreach($kurikulumOptions as $opt)
                                                            <option value="{{ $opt['data1'] }}">{{ $opt['data1'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Kompetensi Keahlian (Multi-select) --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Kompetensi Keahlian</label>
                                                    <div wire:ignore>
                                                        <select id="jurusan-kompetensi-select" class="form-select" multiple>
                                                            @foreach($kompetensiKeahlianOptions as $opt)
                                                                <option value="{{ $opt['id'] }}">{{ $opt['data1'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Deskripsi Singkat --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Deskripsi Singkat <small class="text-muted fw-normal">(tampil di hero jurusan, maks 500 karakter)</small></label>
                                                    <textarea class="form-control @error('form.deskripsi_singkat') is-invalid @enderror"
                                                              wire:model="form.deskripsi_singkat" rows="3"
                                                              placeholder="Ringkasan singkat tentang program keahlian ini..." maxlength="500"></textarea>
                                                    @error('form.deskripsi_singkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Banner Upload --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Banner Jurusan <small class="text-muted fw-normal">(gambar hero, maks 4MB)</small></label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if ($banner)
                                                            <img src="{{ $banner->temporaryUrl() }}" class="rounded" style="height: 60px; object-fit: cover;">
                                                        @elseif ($existingBanner)
                                                            <img src="{{ asset('storage/' . $existingBanner) }}" class="rounded" style="height: 60px; object-fit: cover;">
                                                        @endif
                                                        <input type="file" class="form-control form-control-sm" wire:model="banner" accept="image/*" style="max-width: 300px;">
                                                        <div wire:loading wire:target="banner" class="text-muted small">Mengupload...</div>
                                                    </div>
                                                    @error('banner') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TAB: Profil --}}
                                        <div class="tab-pane" id="jurusan-tab-profil" role="tabpanel">
                                            <div class="row g-3">
                                                {{-- Visi --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Visi</label>
                                                    <textarea class="form-control" wire:model="form.visi" rows="3" placeholder="Visi program keahlian..."></textarea>
                                                </div>

                                                {{-- Misi --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Misi <small class="text-muted fw-normal">(satu poin per baris)</small></label>
                                                    <textarea class="form-control" wire:model="form.misi" rows="5" placeholder="Baris 1: Misi pertama&#10;Baris 2: Misi kedua&#10;..."></textarea>
                                                </div>

                                                {{-- Tujuan --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Tujuan <small class="text-muted fw-normal">(satu poin per baris)</small></label>
                                                    <textarea class="form-control" wire:model="form.tujuan" rows="4" placeholder="Baris 1: Tujuan pertama&#10;..."></textarea>
                                                </div>

                                                {{-- Profil Lulusan --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Profil Lulusan</label>
                                                    <textarea class="form-control" wire:model="form.profil_lulusan" rows="4" placeholder="Deskripsi kompetensi yang dimiliki lulusan program ini..."></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TAB: Kontak & Media --}}
                                        <div class="tab-pane" id="jurusan-tab-kontak" role="tabpanel">
                                            <div class="row g-3">
                                                {{-- Email --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Email Jurusan</label>
                                                    <input type="email" class="form-control @error('form.email') is-invalid @enderror"
                                                           wire:model="form.email" placeholder="jurusan@sekolah.sch.id">
                                                    @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Phone --}}
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Telepon / WhatsApp</label>
                                                    <input type="text" class="form-control @error('form.phone') is-invalid @enderror"
                                                           wire:model="form.phone" placeholder="0812-xxxx-xxxx">
                                                    @error('form.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                {{-- Video URL --}}
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">URL Video Profil <small class="text-muted fw-normal">(YouTube / Vimeo)</small></label>
                                                    <input type="url" class="form-control @error('form.video_url') is-invalid @enderror"
                                                           wire:model="form.video_url" placeholder="https://www.youtube.com/watch?v=...">
                                                    @error('form.video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Deskripsi Detail (CKEditor) — Full width below --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Deskripsi Detail Jurusan</label>
                                    <div wire:ignore>
                                        <div id="jurusan-ckeditor"
                                             data-ckeditor-upload-url="/admin/news/upload-image"
                                             data-ckeditor-content="{{ $form['deskripsi'] ?? '' }}"></div>
                                    </div>
                                    <textarea class="d-none" id="fasilitas-text1-hidden" wire:model="form.deskripsi"></textarea>
                                    @error('form.deskripsi') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Status Aktif --}}
                                <div class="col-md-12">
                                    <div class="form-check form-switch form-switch-md">
                                        <input class="form-check-input" type="checkbox" id="jurusanIsActive" wire:model="form.is_active">
                                        <label class="form-check-label fw-semibold" for="jurusanIsActive">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-light" wire:click="$set('showModal', false)" onclick="window.dispatchEvent(new Event('close-fasilitas-modal'))">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line align-middle me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- Detail Info Modal --}}
    @if($showInfoModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title text-white" id="jurusanInfoModalLabel">
                        <i class="ri-information-line me-2 align-middle"></i> Detail Program Jurusan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                </div>
                <div class="modal-body p-0">
                    @if($selectedItem)
                        <div class="text-center py-4 bg-light border-bottom">
                            @if($selectedItem->logo)
                                <img src="{{ asset('storage/' . $selectedItem->logo) }}" alt="{{ $selectedItem->nama }}" class="img-thumbnail rounded" style="max-height: 100px; max-width: 80%; object-fit: contain;">
                            @else
                                <div class="avatar-md mx-auto">
                                    <span class="avatar-title rounded bg-soft-primary text-primary fs-1">
                                        <i class="ri-book-2-line"></i>
                                    </span>
                                </div>
                            @endif
                            <h4 class="mt-3 mb-0">{{ $selectedItem->nama }}</h4>
                            <p class="text-muted mb-0">Kode: {{ $selectedItem->kode }} | Singkatan: {{ $selectedItem->singkatan }}</p>
                        </div>
                        <div class="p-3">
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 45%">Ketua Jurusan</th>
                                                <td>: 
                                                    @if($selectedItem->kepalaProdi)
                                                        {{ $selectedItem->kepalaProdi->name }}
                                                    @else
                                                        {{ $selectedItem->ka_prodi ?: '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Akreditasi</th>
                                                <td>: 
                                                    @if($selectedItem->akreditasi)
                                                        <span class="badge bg-success-subtle text-success">Akreditasi {{ $selectedItem->akreditasi }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kurikulum</th>
                                                <td>: {{ $selectedItem->kurikulum ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tahun Berdiri</th>
                                                <td>: {{ $selectedItem->tahun_berdiri ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>: 
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
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 40%">Email</th>
                                                <td>: 
                                                    @if($selectedItem->email)
                                                        <a href="mailto:{{ $selectedItem->email }}">{{ $selectedItem->email }}</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Telepon</th>
                                                <td>: {{ $selectedItem->phone ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Video Profil</th>
                                                <td>: 
                                                    @if($selectedItem->video_url)
                                                        <a href="{{ $selectedItem->video_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;">Link Video</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kompetensi</th>
                                                <td>: 
                                                    @php
                                                        $associatedSkills = $kompetensiKeahlian->get($selectedItem->id) ?? collect();
                                                    @endphp
                                                    @if($associatedSkills->isNotEmpty())
                                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                                            @foreach($associatedSkills as $sk)
                                                                <span class="badge bg-soft-success text-success" style="font-size: 10px;">{{ $sk->data1 }}</span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($selectedItem->deskripsi_singkat)
                                <div class="mt-3 pt-2 border-top">
                                    <h6 class="fw-semibold text-primary">Deskripsi Singkat:</h6>
                                    <p class="text-muted small mb-0">{{ $selectedItem->deskripsi_singkat }}</p>
                                </div>
                            @endif

                            @if($selectedItem->visi || $selectedItem->misi)
                                <div class="mt-3 pt-2 border-top">
                                    <h6 class="fw-semibold text-primary">Visi & Misi:</h6>
                                    @if($selectedItem->visi)
                                        <div class="mb-2">
                                            <strong>Visi:</strong>
                                            <p class="text-muted small mb-1">{!! nl2br(e($selectedItem->visi)) !!}</p>
                                        </div>
                                    @endif
                                    @if($selectedItem->misi)
                                        <div>
                                            <strong>Misi:</strong>
                                            <ul class="text-muted small mb-0 ps-3">
                                                @foreach(explode("\n", $selectedItem->misi) as $misiLine)
                                                    @if(trim($misiLine))
                                                        <li>{{ trim($misiLine) }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($selectedItem->tujuan || $selectedItem->profil_lulusan)
                                <div class="mt-3 pt-2 border-top">
                                    <h6 class="fw-semibold text-primary">Tujuan & Profil Lulusan:</h6>
                                    @if($selectedItem->tujuan)
                                        <div class="mb-2">
                                            <strong>Tujuan:</strong>
                                            <ul class="text-muted small mb-1 ps-3">
                                                @foreach(explode("\n", $selectedItem->tujuan) as $tujuanLine)
                                                    @if(trim($tujuanLine))
                                                        <li>{{ trim($tujuanLine) }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if($selectedItem->profil_lulusan)
                                        <div>
                                            <strong>Profil Lulusan:</strong>
                                            <p class="text-muted small mb-0">{!! nl2br(e($selectedItem->profil_lulusan)) !!}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            @if($selectedItem->deskripsi)
                                <div class="mt-3 pt-2 border-top">
                                    <h6 class="fw-semibold text-primary">Deskripsi Detail (Fasilitas & Penunjang):</h6>
                                    <div class="bg-light p-3 rounded border text-muted small" style="max-height: 250px; overflow-y: auto;">
                                        {!! $selectedItem->deskripsi !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="$set('showInfoModal', false)">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    {{-- Logo Preview Modal --}}
    <div class="modal fade" id="jurusanPreviewModal" tabindex="-1" aria-labelledby="jurusanPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body text-center p-0">
                    <img id="jurusanPreviewImage" src="" class="img-fluid rounded shadow" style="max-height: 85vh;">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/libs/ckeditor5/build/ckeditor.js') }}"></script>
<script>
(function () {
    let jurusanEditorInstance = null;
    let isDestroyingJurusanEditor = false;
    let choicesInstance = null;
 
     function initJurusanEditor(initialContent) {
         const el = document.getElementById('jurusan-ckeditor');
         if (!el || jurusanEditorInstance || isDestroyingJurusanEditor) return;
 
         if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
             DKApps.initCKEditor('jurusan-ckeditor', initialContent || '', '/admin/news/upload-image')
                 .then(function(editor) {
                     jurusanEditorInstance = editor;
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
                     console.error('Failed to init jurusan CKEditor:', error);
                 });
         }
     }
 
     function destroyJurusanEditor() {
         if (!jurusanEditorInstance || isDestroyingJurusanEditor) return;
 
         const instance = jurusanEditorInstance;
         jurusanEditorInstance = null;
         isDestroyingJurusanEditor = true;
 
         if (!instance.sourceElement || !instance.sourceElement.isConnected) {
             isDestroyingJurusanEditor = false;
             return;
         }
 
         Promise.resolve(instance.destroy())
             .catch(err => {
                 console.warn('Skipping jurusan CKEditor destroy:', err);
             })
             .finally(() => {
                 isDestroyingJurusanEditor = false;
             });
     }
 
     window.addEventListener('open-fasilitas-modal', (event) => {
         const data = event.detail[0] || event.detail || {};
         const content = data.content || '';
         const selectedSkills = data.kompetensiKeahlian || [];
         setTimeout(() => {
             initJurusanEditor(content);

             // Initialize Choices.js for Kompetensi Keahlian select
             const selectEl = document.getElementById('jurusan-kompetensi-select');
             if (selectEl) {
                 if (choicesInstance) {
                     choicesInstance.destroy();
                     choicesInstance = null;
                 }

                 // Sync values
                 Array.from(selectEl.options).forEach(option => {
                     option.selected = selectedSkills.map(String).includes(option.value.toString());
                 });

                 choicesInstance = new Choices(selectEl, {
                     removeItemButton: true,
                     placeholder: true,
                     placeholderValue: 'Pilih Kompetensi Keahlian',
                     itemSelectText: ''
                 });

                 if (selectedSkills.length > 0) {
                     choicesInstance.setChoiceByValue(selectedSkills.map(String));
                 }

                 selectEl.addEventListener('change', function(e) {
                     const selected = choicesInstance.getValue(true);
                     const selectedStr = Array.isArray(selected) ? selected.map(String) : (selected ? [String(selected)] : []);
                     const componentId = selectEl.closest('[wire\\:id]').getAttribute('wire:id');
                     if (componentId && window.Livewire) {
                         window.Livewire.find(componentId).set('kompetensiKeahlianSelected', selectedStr);
                     }
                 });
             }
         }, 250);
     });
 
     window.addEventListener('close-fasilitas-modal', () => {
         destroyJurusanEditor();
         if (choicesInstance) {
             choicesInstance.destroy();
             choicesInstance = null;
         }
     });

    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-fasilitas-modal', () => {
            destroyJurusanEditor();
            if (choicesInstance) {
                choicesInstance.destroy();
                choicesInstance = null;
            }
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

    window.openJurusanPreviewModal = function(src) {
        document.getElementById('jurusanPreviewImage').src = src;
        var modal = new bootstrap.Modal(document.getElementById('jurusanPreviewModal'));
        modal.show();
    };

    window.confirmJurusanDelete = function(id, name) {
        const message = `Program Jurusan "${name}" akan dihapus secara permanen beserta file logonya!`;
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    const $component = document.querySelector('[wire\\:id]');
                    if ($component && window.Livewire) {
                        window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
                    }
                }
            });
        } else if (confirm(`Hapus program jurusan "${name}"?`)) {
            const $component = document.querySelector('[wire\\:id]');
            if ($component && window.Livewire) {
                window.Livewire.find($component.getAttribute('wire:id')).call('delete', id);
            }
        }
    };

    window.confirmJurusanBulkDelete = function() {
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
