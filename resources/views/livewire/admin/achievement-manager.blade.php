<div wire:key="achievement-manager-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari prestasi, peraih, penyelenggara..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="typeFilter">
                <option value="all">Semua Tipe</option>
                <option value="siswa">Siswa</option>
                <option value="sekolah">Sekolah</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="jurusanFilter" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                @if(!auth()->user()->isAdminJurusan())
                    <option value="all">Semua Jurusan</option>
                    <option value="umum">Umum (Umum/Semua)</option>
                @endif
                @foreach($jurusans as $jur)
                    <option value="{{ $jur->id }}">{{ $jur->data1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" wire:model.live="kategoriFilter">
                <option value="all">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->data1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1.5" style="width: 12.5%;">
            <select class="form-select" wire:model.live="tingkatFilter">
                <option value="all">Tingkat</option>
                @foreach($tingkats as $ting)
                    <option value="{{ $ting->id }}">{{ $ting->data1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col text-end">
            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Prestasi
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
                <button type="button" class="btn btn-sm btn-soft-danger" onclick="confirmAchievementBulkDelete()">
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
                    <th scope="col" style="width: 90px;">Foto</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('title')" class="text-body text-decoration-none">
                            Nama Prestasi / Lomba @if($sortBy === 'title') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Peraih / Pemenang</th>
                    <th scope="col">Kategori & Tingkat</th>
                    <th scope="col">
                        <a href="#" wire:click.prevent="sortByColumn('date')" class="text-body text-decoration-none">
                            Tanggal Perolehan @if($sortBy === 'date') <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i> @endif
                        </a>
                    </th>
                    <th scope="col">Berita Terkait</th>
                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                    <th scope="col" style="width: 180px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achievements as $ach)
                    <tr wire:key="achievement-{{ $ach->id }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $ach->id }}" wire:model.live="selectedItems">
                            </div>
                        </td>
                        <td>{{ ($achievements->currentPage() - 1) * $achievements->perPage() + $loop->iteration }}</td>
                        <td>
                            @php
                                $photoPaths = array_filter(explode(';', $ach->photo));
                                $firstPhoto = !empty($photoPaths) ? reset($photoPaths) : null;
                            @endphp
                            @if($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto) }}" 
                                     alt="{{ $ach->title }}" 
                                     class="rounded cursor-pointer"
                                     style="width: 60px; height: 45px; object-fit: cover;"
                                     onclick="openPreviewModal('{{ asset('storage/' . $firstPhoto) }}')">
                            @else
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="ri-trophy-line"></i>
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $ach->type === 'siswa' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }}">
                                {{ ucfirst($ach->type) }}
                            </span>
                        </td>
                        <td>
                            @if($ach->jurusan)
                                <span class="badge bg-info-subtle text-info">{{ $ach->jurusan->nama }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Umum</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary">{{ $ach->title }}</strong>
                            @if($ach->organizer)
                                <br><small class="text-muted">Penyelenggara: {{ $ach->organizer }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $ach->achiever }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info-subtle text-info me-1">{{ $ach->kategori?->data1 ?? '-' }}</span>
                            <span class="badge bg-success-subtle text-success">{{ $ach->tingkat?->data1 ?? '-' }}</span>
                        </td>
                        <td>
                            {{ $ach->date ? $ach->date->format('d M, Y') : '-' }}
                        </td>
                        <td>
                            @if($ach->news)
                                <a href="{{ route('admin.news.index', ['search' => $ach->news_id]) }}" class="badge bg-primary-subtle text-primary text-wrap" style="max-width: 150px;" title="Lihat Berita">
                                    <i class="ri-link"></i> {{ $ach->news->title }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($ach->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if($ach->is_active)
                                    <button type="button" class="btn btn-sm btn-warning" wire:click="toggleStatus({{ $ach->id }})" title="Nonaktifkan">
                                        <i class="ri-close-circle-line"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-success" wire:click="toggleStatus({{ $ach->id }})" title="Aktifkan">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-info" wire:click="openInfoModal({{ $ach->id }})" title="Detail">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="openEditModal({{ $ach->id }})" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAchievementDelete({{ $ach->id }}, '{{ addslashes($ach->title) }}')" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ri-trophy-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data prestasi</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($achievements && $achievements->count() > 0)
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
                    Menampilkan {{ $achievements->firstItem() }} - {{ $achievements->lastItem() }} / {{ $achievements->total() }} rows
                </div>
            </div>
            <div class="pagination-wrap hstack gap-2">
                {{ $achievements->links('vendor.pagination.bootstrap-5-always') }}
            </div>
        </div>
    @endif

    <!-- Add / Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-body p-0">
                        <form wire:submit.prevent="save" autocomplete="off" id="achievement-form">
                            <!-- Cover Banner -->
                            <div class="modal-team-cover position-relative mb-0 rounded-top overflow-hidden" style="height: 110px; background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);">
                                <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                    <div class="flex-grow-1">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-trophy-line me-2"></i>
                                            {{ $editMode ? 'Edit Prestasi' : 'Tambah Prestasi Baru' }}
                                        </h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4">
                                <!-- Form Fields -->
                                <div class="row g-3">
                                    <!-- Tipe Prestasi -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold d-block">Tipe Prestasi <span class="text-danger">*</span></label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="type" id="type_siswa" value="siswa" wire:model.live="form.type">
                                            <label class="btn btn-outline-primary" for="type_siswa"><i class="ri-user-line me-1"></i>Siswa / Murid</label>
                                            
                                            <input type="radio" class="btn-check" name="type" id="type_sekolah" value="sekolah" wire:model.live="form.type">
                                            <label class="btn btn-outline-primary" for="type_sekolah"><i class="ri-building-line me-1"></i>Sekolah / Jurusan</label>
                                        </div>
                                        @error('form.type') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Nama Lomba / Prestasi -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Nama Lomba / Prestasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('form.title') is-invalid @enderror"
                                               wire:model="form.title" placeholder="Misal: Juara 1 Lomba LKS Web Technologies Tingkat Nasional">
                                        @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Peraih / Pemenang Conditional -->
                                    @if(($form['type'] ?? 'siswa') === 'siswa')
                                        <!-- SISWA SECTION (Autocomplete Multi-select) -->
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Pilih Siswa Peraih <span class="text-danger">*</span> <small class="text-muted">(Bisa pilih lebih dari satu)</small></label>
                                            <div class="position-relative">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-user-search-line"></i></span>
                                                    <input type="text" class="form-control" placeholder="Tulis nama siswa untuk mencari..."
                                                           wire:model.live.debounce.300ms="studentSearch">
                                                </div>
                                                <!-- Autocomplete student search list -->
                                                @if(!empty($studentSearchResults))
                                                    <ul class="list-group position-absolute w-100 shadow-lg" style="top: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 9999;">
                                                        @foreach($studentSearchResults as $st)
                                                            <li class="list-group-item list-group-item-action cursor-pointer py-2"
                                                                style="cursor: pointer;"
                                                                wire:click="selectStudent({{ $st['id'] }}, '{{ addslashes($st['name']) }}')">
                                                                {{ $st['name'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                            <!-- Selected Students List -->
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @forelse($selectedStudents as $st)
                                                    <span class="badge bg-primary text-white p-2 d-flex align-items-center fs-12">
                                                        <i class="ri-user-line me-1"></i> {{ $st['name'] }}
                                                        <a href="javascript:void(0)" wire:click="removeSelectedStudent({{ $st['id'] }})" class="text-white ms-2" title="Hapus">
                                                            <i class="ri-close-fill font-bold fs-14"></i>
                                                        </a>
                                                    </span>
                                                @empty
                                                    <span class="text-muted small italic"><i class="ri-information-line me-1"></i>Belum ada siswa terpilih. Cari nama siswa di atas.</span>
                                                @endforelse
                                            </div>
                                            @error('selectedStudents') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Jurusan Siswa -->
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Jurusan / Program Keahlian</label>
                                            <div wire:ignore>
                                                <select id="form-student-jurusan-select" class="form-select" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                                    @if(!auth()->user()->isAdminJurusan())
                                                        <option value="">Umum (Semua Jurusan)</option>
                                                    @endif
                                                    @foreach($jurusans as $jur)
                                                        <option value="{{ $jur->id }}" {{ ($form['jurusan_id'] ?? '') == $jur->id ? 'selected' : '' }}>{{ $jur->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-text text-muted">Pilih jurusan asal siswa peraih prestasi, atau biarkan "Umum" jika prestasinya bersifat umum/sekolah.</div>
                                            @error('form.jurusan_id') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                        </div>
                                    @else
                                        <!-- SEKOLAH / JURUSAN SECTION -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Tipe Peraih <span class="text-danger">*</span></label>
                                            <select class="form-select" wire:model.live="achieverSekolahType">
                                                <option value="sekolah">Sekolah (Umum)</option>
                                                <option value="jurusan">Program Jurusan</option>
                                            </select>
                                        </div>

                                        @if($achieverSekolahType === 'jurusan')
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Pilih Jurusan <span class="text-danger">*</span></label>
                                                <div wire:ignore>
                                                    <select id="form-jurusan-select" class="form-select" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                                        @if(!auth()->user()->isAdminJurusan())
                                                            <option value="">Pilih Program Keahlian / Jurusan</option>
                                                        @endif
                                                        @foreach($jurusans as $jur)
                                                            <option value="{{ $jur->id }}" {{ $selectedJurusanId == $jur->id ? 'selected' : '' }}>{{ $jur->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('selectedJurusanId') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                            </div>
                                        @else
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Nama Instansi / Sekolah <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="form.achiever" placeholder="Contoh: SMKN 1 Cimahi">
                                                @error('form.achiever') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        @endif
                                    @endif

                                    <!-- Kategori -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                        <div wire:ignore>
                                            <select id="form-kategori-select" class="form-select">
                                                <option value="">Pilih Kategori</option>
                                                @foreach($kategoris as $kat)
                                                    <option value="{{ $kat->id }}" {{ ($form['kategori_id'] ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->data1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.kategori_id') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tingkatan -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tingkat Prestasi <span class="text-danger">*</span></label>
                                        <div wire:ignore>
                                            <select id="form-tingkat-select" class="form-select">
                                                <option value="">Pilih Tingkat</option>
                                                @foreach($tingkats as $ting)
                                                    <option value="{{ $ting->id }}" {{ ($form['tingkat_id'] ?? '') == $ting->id ? 'selected' : '' }}>{{ $ting->data1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.tingkat_id') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Penyelenggara -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Penyelenggara</label>
                                        <input type="text" class="form-control @error('form.organizer') is-invalid @enderror"
                                               wire:model="form.organizer" placeholder="Misal: Puspresnas, Kemendikbudristek">
                                        @error('form.organizer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tanggal Perolehan -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Perolehan</label>
                                        <div wire:ignore>
                                            <input type="text" 
                                                   id="achievement-date-picker" 
                                                   class="form-control"
                                                   data-provider="flatpickr" 
                                                   data-date-format="d M, Y"
                                                   placeholder="Pilih Tanggal Perolehan"
                                                   readonly>
                                        </div>
                                        @error('form.date') <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Berita Terkait -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Berita Terkait</label>
                                        <div class="position-relative">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-article-line"></i></span>
                                                <input type="text" class="form-control" placeholder="Cari berita berdasarkan judul atau ID..."
                                                       wire:model.live.debounce.300ms="newsSearch"
                                                       @if($selectedNewsId) disabled @endif>
                                                @if($selectedNewsId)
                                                    <button class="btn btn-danger" type="button" wire:click="clearSelectedNews">
                                                        <i class="ri-close-line"></i> Batal Pilih
                                                    </button>
                                                @endif
                                            </div>
                                            <!-- Suggestions list -->
                                            @if(!empty($newsSearchResults))
                                                <ul class="list-group position-absolute w-100 shadow-lg" style="top: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 9999;">
                                                    @foreach($newsSearchResults as $res)
                                                        <li class="list-group-item list-group-item-action cursor-pointer py-2"
                                                            style="cursor: pointer;"
                                                            wire:click="selectNews({{ $res['id'] }}, '{{ addslashes($res['title']) }}')">
                                                            <small class="text-primary fw-semibold">ID: {{ $res['id'] }}</small> — {{ $res['title'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        @if($selectedNewsId)
                                            <div class="mt-2 text-success" style="font-size: 0.85rem;">
                                                <i class="ri-checkbox-circle-fill me-1"></i> Terpilih: <strong>{{ $selectedNewsTitle }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Deskripsi / Detail Prestasi</label>
                                        <textarea class="form-control @error('form.description') is-invalid @enderror" 
                                                  wire:model="form.description" rows="3" placeholder="Jelaskan rincian prestasi, anggota tim, dll."></textarea>
                                        @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Gambar Prestasi (Multiple images upload - like facilities) -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Dokumentasi Photo <small class="text-muted">(Bisa upload beberapa)</small></label>
                                        <input type="file" class="form-control" wire:model="achievementPhotos" multiple accept="image/*">
                                        @error('achievementPhotos.*') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                        
                                        <!-- Preview New Images -->
                                        @if($achievementPhotos)
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($achievementPhotos as $img)
                                                    <div class="position-relative">
                                                        <img src="{{ $img->temporaryUrl() }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Preview Existing Images -->
                                        @if(!empty($existingPhotos))
                                            <div class="d-flex flex-wrap gap-2 mt-3 p-2 bg-light border rounded">
                                                <p class="w-100 mb-1 small fw-medium text-dark">Foto Terunggah:</p>
                                                @foreach($existingPhotos as $index => $imgPath)
                                                    <div class="position-relative">
                                                        <a href="javascript:void(0)" onclick="openPreviewModal('{{ asset('storage/' . $imgPath) }}')">
                                                            <img src="{{ asset('storage/' . $imgPath) }}" class="img-thumbnail border-secondary" style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>
                                                        <button type="button" wire:click="removePhoto({{ $index }})" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle p-1" style="width: 24px; height: 24px; line-height: 1;">
                                                            <i class="ri-close-line fs-14"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Status Tampil</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="isActive" wire:model="form.is_active">
                                            <label class="form-check-label" for="isActive">Tampilkan di Publik</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="hstack gap-2 justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">Batal</button>
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ $editMode ? 'Simpan Perubahan' : 'Tambah Prestasi' }}</span>
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

    <!-- Info Detail Modal -->
    @if($showInfoModal && $selectedAchievement)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white"><i class="ri-trophy-line me-2"></i>Detail Informasi Prestasi</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5 text-center mb-3">
                                @php
                                    $detailPhotos = array_filter(explode(';', $selectedAchievement->photo));
                                @endphp
                                @if(!empty($detailPhotos))
                                    <div class="row g-2">
                                        @foreach($detailPhotos as $dp)
                                            <div class="col-6">
                                                <img src="{{ asset('storage/' . $dp) }}" class="img-fluid rounded border shadow-sm cursor-pointer" style="height: 100px; width: 100%; object-fit: cover;" onclick="openPreviewModal('{{ asset('storage/' . $dp) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="avatar-title rounded bg-soft-primary text-primary p-5 fs-24 text-center">
                                        <i class="ri-trophy-line" style="font-size: 64px;"></i>
                                        <p class="fs-14 mt-2 mb-0">Tidak ada foto dokumentasi</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h4 class="fw-bold mb-1 text-primary">{{ $selectedAchievement->title }}</h4>
                                <p class="text-muted mb-3">
                                    Tipe: <span class="badge bg-secondary me-2">{{ ucfirst($selectedAchievement->type) }}</span>
                                    Peraih: <span class="badge bg-dark fs-12">{{ $selectedAchievement->achiever }}</span>
                                </p>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width: 35%;" class="bg-light">Kategori</th>
                                                <td>{{ $selectedAchievement->kategori?->data1 ?? '-' }}</td>
                                            </tr>
                                            @if($selectedAchievement->jurusan)
                                            <tr>
                                                <th class="bg-light">Jurusan</th>
                                                <td>{{ $selectedAchievement->jurusan->nama }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th class="bg-light">Tingkatan</th>
                                                <td>{{ $selectedAchievement->tingkat?->data1 ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Penyelenggara</th>
                                                <td>{{ $selectedAchievement->organizer ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Tanggal Perolehan</th>
                                                <td>{{ $selectedAchievement->date ? $selectedAchievement->date->format('d F Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Berita Terkait</th>
                                                <td>
                                                    @if($selectedAchievement->news)
                                                        <a href="{{ route('admin.news.index', ['search' => $selectedAchievement->news_id]) }}" class="fw-semibold">
                                                            ID: {{ $selectedAchievement->news_id }} - {{ $selectedAchievement->news->title }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($selectedAchievement->description)
                            <div class="mt-3">
                                <h6 class="fw-semibold text-primary"><i class="ri-file-text-line me-1"></i>Deskripsi Tambahan:</h6>
                                <div class="bg-light p-2 rounded border border-dashed" style="white-space: pre-wrap;">{{ $selectedAchievement->description }}</div>
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

    <!-- Lightbox Modal for Photo Preview -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img id="modalPreviewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    let kategoriChoices = null;
    let tingkatChoices = null;
    let jurusanChoices = null;
    let studentJurusanChoices = null;
    let datePicker = null;

    function initChoices() {
        // Kategori Choices
        const katEl = document.getElementById('form-kategori-select');
        if (katEl) {
            if (katEl._choicesInstance) katEl._choicesInstance.destroy();
            kategoriChoices = new Choices(katEl, {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Pilih Kategori',
                searchPlaceholderValue: 'Cari kategori...',
                itemSelectText: '',
                shouldSort: false
            });
            katEl._choicesInstance = kategoriChoices;
            katEl.addEventListener('change', function(e) {
                const componentId = katEl.closest('[wire\\:id]').getAttribute('wire:id');
                if (componentId && window.Livewire) {
                    window.Livewire.find(componentId).set('form.kategori_id', e.target.value);
                }
            });
            const componentId = katEl.closest('[wire\\:id]').getAttribute('wire:id');
            if (componentId && window.Livewire) {
                const val = window.Livewire.find(componentId).get('form.kategori_id') || '';
                kategoriChoices.setChoiceByValue(String(val));
            }
        }

        // Tingkat Choices
        const tingEl = document.getElementById('form-tingkat-select');
        if (tingEl) {
            if (tingEl._choicesInstance) tingEl._choicesInstance.destroy();
            tingkatChoices = new Choices(tingEl, {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Pilih Tingkat',
                searchPlaceholderValue: 'Cari tingkat...',
                itemSelectText: '',
                shouldSort: false
            });
            tingEl._choicesInstance = tingkatChoices;
            tingEl.addEventListener('change', function(e) {
                const componentId = tingEl.closest('[wire\\:id]').getAttribute('wire:id');
                if (componentId && window.Livewire) {
                    window.Livewire.find(componentId).set('form.tingkat_id', e.target.value);
                }
            });
            const componentId = tingEl.closest('[wire\\:id]').getAttribute('wire:id');
            if (componentId && window.Livewire) {
                const val = window.Livewire.find(componentId).get('form.tingkat_id') || '';
                tingkatChoices.setChoiceByValue(String(val));
            }
        }

        // Jurusan Choices
        const jurEl = document.getElementById('form-jurusan-select');
        if (jurEl) {
            if (jurEl._choicesInstance) jurEl._choicesInstance.destroy();
            jurusanChoices = new Choices(jurEl, {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Pilih Jurusan',
                searchPlaceholderValue: 'Cari jurusan...',
                itemSelectText: '',
                shouldSort: false
            });
            jurEl._choicesInstance = jurusanChoices;
            jurEl.addEventListener('change', function(e) {
                const componentId = jurEl.closest('[wire\\:id]').getAttribute('wire:id');
                if (componentId && window.Livewire) {
                    window.Livewire.find(componentId).set('selectedJurusanId', e.target.value);
                }
            });
            const componentId = jurEl.closest('[wire\\:id]').getAttribute('wire:id');
            if (componentId && window.Livewire) {
                const val = window.Livewire.find(componentId).get('selectedJurusanId') || '';
                jurusanChoices.setChoiceByValue(String(val));
            }
        }

        // Student Jurusan Choices
        const studJurEl = document.getElementById('form-student-jurusan-select');
        if (studJurEl) {
            if (studJurEl._choicesInstance) studJurEl._choicesInstance.destroy();
            studentJurusanChoices = new Choices(studJurEl, {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Pilih Jurusan',
                searchPlaceholderValue: 'Cari jurusan...',
                itemSelectText: '',
                shouldSort: false
            });
            studJurEl._choicesInstance = studentJurusanChoices;
            studJurEl.addEventListener('change', function(e) {
                const componentId = studJurEl.closest('[wire\\:id]').getAttribute('wire:id');
                if (componentId && window.Livewire) {
                    window.Livewire.find(componentId).set('form.jurusan_id', e.target.value);
                }
            });
            const componentId = studJurEl.closest('[wire\\:id]').getAttribute('wire:id');
            if (componentId && window.Livewire) {
                const val = window.Livewire.find(componentId).get('form.jurusan_id') || '';
                studentJurusanChoices.setChoiceByValue(String(val));
            }
        }
    }

    function initDatePicker() {
        const el = document.getElementById('achievement-date-picker');
        if (!el) return;
        
        if (el._flatpickr) {
            el._flatpickr.destroy();
            el._flatpickr = null;
        }
        
        if (typeof flatpickr !== 'undefined') {
            datePicker = flatpickr(el, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd M, Y',
                disableMobile: true,
                onChange: function(selectedDates, dateStr) {
                    const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
                    if (componentId && window.Livewire) {
                        window.Livewire.find(componentId).set('form.date', dateStr);
                    }
                }
            });
            el._flatpickr = datePicker;
            
            // Set initial value
            const componentId = el.closest('[wire\\:id]').getAttribute('wire:id');
            if (componentId && window.Livewire) {
                const dateVal = window.Livewire.find(componentId).get('form.date');
                if (dateVal) {
                    datePicker.setDate(dateVal, false);
                } else {
                    datePicker.clear(false);
                }
            }
        }
    }

    window.addEventListener('open-modal', () => {
        setTimeout(() => {
            initChoices();
            initDatePicker();
        }, 180);
    });

    document.addEventListener('livewire:initialized', function () {
        Livewire.on('close-modal', () => {
            if (kategoriChoices) { kategoriChoices.destroy(); kategoriChoices = null; }
            if (tingkatChoices) { tingkatChoices.destroy(); tingkatChoices = null; }
            if (jurusanChoices) { jurusanChoices.destroy(); jurusanChoices = null; }
            if (studentJurusanChoices) { studentJurusanChoices.destroy(); studentJurusanChoices = null; }
            if (datePicker) { datePicker.destroy(); datePicker = null; }
        });

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

    window.confirmAchievementDelete = function (id, title) {
        const message = `Data Prestasi "${title}" akan dihapus secara permanen!`;
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

    window.confirmAchievementBulkDelete = function () {
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

    window.openPreviewModal = function(src) {
        document.getElementById('modalPreviewImage').src = src;
        var previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        previewModal.show();
    }
})();
</script>
@endpush
