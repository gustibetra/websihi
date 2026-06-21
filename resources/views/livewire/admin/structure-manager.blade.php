<div wire:key="structure-manager-component" class="structure-page full-height">
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 mb-n4 p-2">
        <!-- Sidebar -->
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <div class="mb-3">
                    <h5 class="fw-semibold mb-3">Jenis Struktur</h5>
                </div>

                <div class="px-4 mx-n4" data-simplebar style="height: calc(100vh - 400px);">
                    <ul class="to-do-menu list-unstyled" id="structure-menu">
                        <!-- Organisasi Sekolah -->
                        @if(!auth()->user()->isAdminJurusan())
                        <li>
                            <a href="#" wire:click.prevent="selectType('sekolah')" 
                               class="nav-link fs-13 {{ $selectedType === 'sekolah' ? 'active' : '' }}">
                                <i class="ri-building-line align-middle me-2"></i>
                                Organisasi Sekolah
                            </a>
                        </li>
                        @endif

                        <!-- Organisasi Siswa -->
                        <li>
                            <a href="#" wire:click.prevent="selectType('organisasi')" 
                               class="nav-link fs-13 {{ $selectedType === 'organisasi' ? 'active' : '' }}">
                                <i class="ri-group-line align-middle me-2"></i>
                                Organisasi Siswa (OSIS)
                            </a>
                        </li>

                        <!-- Ekstrakurikuler -->
                        <li>
                            <a href="#" wire:click.prevent="selectType('ekskul')" 
                               class="nav-link fs-13 {{ $selectedType === 'ekskul' ? 'active' : '' }}">
                                <i class="ri-basketball-line align-middle me-2"></i>
                                Ekstrakurikuler
                            </a>
                        </li>

                        <!-- Kepanitiaan -->
                        <li>
                            <a href="#" wire:click.prevent="selectType('kepanitiaan')" 
                               class="nav-link fs-13 {{ $selectedType === 'kepanitiaan' ? 'active' : '' }}">
                                <i class="ri-team-line align-middle me-2"></i>
                                Kepanitiaan
                            </a>
                        </li>

                        <!-- Struktur Yayasan -->
                        @if(!auth()->user()->isAdminJurusan())
                        <li>
                            <a href="#" wire:click.prevent="selectType('yayasan')" 
                               class="nav-link fs-13 {{ $selectedType === 'yayasan' ? 'active' : '' }}">
                                <i class="ri-building-3-line align-middle me-2"></i>
                                Struktur Yayasan
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!--end sidebar-->

        <!-- Main Content -->
        <div class="file-manager-content w-100 p-4 pb-0">
            <div class="row mb-4">
                <div class="col-auto order-1 d-block d-lg-none">
                    <button type="button" class="btn btn-soft-success btn-icon btn-sm fs-16 file-menu-btn">
                        <i class="ri-menu-2-fill align-bottom"></i>
                    </button>
                </div>
                <div class="col-sm order-3 order-sm-2 mt-3 mt-sm-0">
                    <h5 class="fw-semibold mb-0">
                        {{ $this->getTypeTitle() }}
                        <span wire:loading.delay class="ms-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h5>
                </div>
            </div>

            <!-- Flash Message -->
            @if (session()->has('message'))
                <div wire:ignore class="flash-message-success" data-message="{{ session('message') }}"></div>
            @endif

            @if (session()->has('error'))
                <div wire:ignore class="flash-message-error" data-message="{{ session('error') }}"></div>
            @endif

            <!-- Content Area -->
            <div class="todo-content position-relative px-4 mx-n4" id="structure-content">
                <!-- Search & Filter Bar -->
                <div class="row mb-4 align-items-center g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ri-search-line"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Cari nama struktur..." 
                                   wire:model.live.debounce.300ms="search">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div wire:ignore>
                            <select id="periodFilter" 
                                    class="form-select choices-init-hide" 
                                    data-choices
                                    data-choices-search-false>
                                <option value="all" {{ $periodFilter == 'all' ? 'selected' : '' }}>Semua Periode</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period['id'] }}" {{ $periodFilter == $period['id'] ? 'selected' : '' }}>
                                        {{ $period['data1'] }}
                                    </option>
                                @endforeach
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
                        <button class="btn btn-soft-primary btn-sm" type="button" wire:click="openCreateModal">
                            <i class="ri-add-fill align-bottom"></i> Tambah {{ $this->getTypeTitle() }}
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive table-card mb-2 mt-2 border border-top-dashed">
                    <table class="table align-middle table-nowrap mb-0 table-striped table-sm">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 100px;">
                                    <a href="#" wire:click.prevent="sortByColumn('key1')" class="text-body text-decoration-none">
                                        ID
                                        @if($sortBy === 'key1')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" wire:click.prevent="sortByColumn('data1')" class="text-body text-decoration-none">
                                        Nama
                                        @if($sortBy === 'data1')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" style="width: 150px;">Periode</th>
                                <th scope="col" style="width: 150px;">Jurusan Terkait</th>
                                <th scope="col" style="width: 100px;">Anggota</th>
                                <th scope="col" style="width: 100px;" class="text-center">Status</th>
                                <th scope="col" style="width: 250px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($structures as $structure)
                                <tr wire:key="structure-{{ $structure->id }}">
                                    <td><strong>{{ $structure->key1 }}</strong></td>
                                    <td>
                                        <strong>{{ $structure->data1 }}</strong>
                                        @if($structure->text1)
                                            <br><small class="text-muted">{{ Str::limit($structure->text1, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $period = collect($periods)->firstWhere('id', $structure->data2);
                                        @endphp
                                        @if($period)
                                            <span class="badge bg-info">{{ $period['data1'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $jurusan = collect($jurusans)->firstWhere('id', $structure->data3);
                                        @endphp
                                        @if($jurusan)
                                            <span class="badge bg-primary">{{ $jurusan['data2'] }}</span>
                                        @else
                                            <span class="text-muted">Umum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $memberCount = \App\Models\StructureMember::where('common_id', $structure->id)->count();
                                        @endphp
                                        <span class="badge bg-success">
                                            {{ $memberCount }} Orang
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($structure->data4 === '1')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.structure.members', $structure->id) }}" 
                                               class="btn btn-sm btn-info"
                                               title="Kelola Anggota">
                                                <i class="ri-team-line"></i> Kelola Anggota
                                            </a>
                                            @if($structure->data4 === '1')
                                                <button type="button" 
                                                        class="btn btn-sm btn-warning" 
                                                        wire:click="toggleStatus({{ $structure->id }})"
                                                        title="Nonaktifkan">
                                                    <i class="ri-close-circle-line"></i>
                                                </button>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        wire:click="toggleStatus({{ $structure->id }})"
                                                        title="Aktifkan">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </button>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary" 
                                                    wire:click="openEditModal({{ $structure->id }})"
                                                    title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $structure->id }}, '{{ $structure->data1 }}')"
                                                    title="Hapus">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ri-organization-chart" style="font-size: 48px;"></i>
                                            <p class="mt-2 mb-0">Tidak ada data {{ $this->getTypeTitle() }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($structures && $structures->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                                <div wire:ignore style="min-width: 60px;">
                                    <select id="perPageFilter" 
                                            class="form-select form-select-sm choices-init-hide per-page-select" 
                                            data-choices
                                            data-choices-search-false>
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <span class="text-muted">|</span>
                            
                            <div class="text-muted">
                                Menampilkan {{ $structures->firstItem() }} - {{ $structures->lastItem() }} / {{ $structures->total() }} rows
                            </div>
                        </div>
                        <div class="pagination-wrap hstack gap-2">
                            {{ $structures->links('vendor.pagination.bootstrap-5-always') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $editMode ? 'Edit ' . $this->getTypeTitle() : 'Tambah ' . $this->getTypeTitle() }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Nama Struktur -->
                                <div class="col-md-12 mb-3">
                                    <label for="nama" class="form-label">Nama {{ $this->getTypeTitle() }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('form.data1') is-invalid @enderror" 
                                           id="nama"
                                           wire:model="form.data1"
                                           placeholder="Masukkan nama {{ $this->getTypeTitle() }}">
                                    @error('form.data1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Periode -->
                                <div class="col-md-12 mb-3">
                                    <label for="period" class="form-label">Periode / Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select class="form-select @error('form.data2') is-invalid @enderror" 
                                            id="period"
                                            wire:model="form.data2">
                                        <option value="">Pilih Periode</option>
                                        @foreach($periods as $period)
                                            <option value="{{ $period['id'] }}">
                                                {{ $period['data1'] }}
                                                @if($period['data4'] === '1')
                                                    (Aktif)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.data2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Jurusan Terkait -->
                                <div class="col-md-12 mb-3">
                                    <label for="jurusan" class="form-label">Jurusan Terkait (Opsional)</label>
                                    <select class="form-select @error('form.data3') is-invalid @enderror" 
                                            id="jurusan"
                                            wire:model="form.data3" {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}>
                                        @if(!auth()->user()->isAdminJurusan())
                                            <option value="">Umum (Tidak Terkait Jurusan Spesifik)</option>
                                        @endif
                                        @foreach($jurusans as $jur)
                                            <option value="{{ $jur['id'] }}">{{ $jur['data1'] }} ({{ $jur['data2'] }})</option>
                                        @endforeach
                                    </select>
                                    @error('form.data3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Deskripsi / Detail</label>
                                    <textarea class="form-control @error('form.text1') is-invalid @enderror" 
                                              wire:model="form.text1"
                                              rows="4"
                                              placeholder="Detail informasi (opsional)"></textarea>
                                    @error('form.text1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select @error('form.data4') is-invalid @enderror" 
                                            wire:model="form.data4">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    @error('form.data4')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    {{ $editMode ? 'Update' : 'Simpan' }}
                                </span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                    Menyimpan...
                                </span>
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
<script src="{{ asset('assets/admin/js/pages/structure-manager.js') }}"></script>
@endpush
