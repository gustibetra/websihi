<div wire:key="structure-member-manager" class="structure-member-manager">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border">
                <div>
                    <h4 class="mb-1 fw-semibold text-primary"><i class="ri-organization-chart me-2"></i>{{ $structure->data1 ?? 'Struktur' }}</h4>
                    <p class="text-muted mb-0">
                        <span class="me-3"><i class="ri-calendar-line me-1"></i> Periode: <strong>{{ $period }}</strong></span>
                        <span><i class="ri-team-line me-1"></i> Total: <strong>{{ $assignedMembers->count() }} Anggota</strong></span>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-soft-primary" wire:click="openCreateSectionModal">
                        <i class="ri-folder-add-line me-1"></i> Tambah Section
                    </button>
                    <a href="{{ route('admin.structure.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="ri-information-line me-2"></i>
        <strong>Panduan:</strong> 
        1. Buat <strong>Section</strong> terlebih dahulu di panel kanan jika belum ada.
        2. Tarik/klik anggota di panel kiri untuk ditambahkan ke section.
        3. Seret (drag) kartu anggota di panel kanan untuk mengurutkan atau memindahkan antar section.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <!-- Dual Panel -->
    <div class="row">
        <!-- Left Panel: Available Members -->
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fs-14">
                            <i class="ri-user-add-line me-2 text-primary"></i>Anggota Tersedia
                        </h5>
                        @if(count($selectedMembers) > 0)
                            <button type="button" class="btn btn-sm btn-primary" wire:click="openBulkModal">
                                <i class="ri-user-add-line me-1"></i>
                                Tambah Terpilih ({{ count($selectedMembers) }})
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- SDM Category Selection Tabs -->
                    <ul class="nav nav-pills nav-justified mb-3 bg-light p-1 rounded" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link fs-12 py-1.5 {{ $selectedSdmType === 'teacher' ? 'active' : '' }}" 
                                    wire:click="selectSdmType('teacher')" type="button">
                                Guru/Tendik
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fs-12 py-1.5 {{ $selectedSdmType === 'student' ? 'active' : '' }}" 
                                    wire:click="selectSdmType('student')" type="button">
                                Siswa
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fs-12 py-1.5 {{ $selectedSdmType === 'structural' ? 'active' : '' }}" 
                                    wire:click="selectSdmType('structural')" type="button">
                                Yayasan
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fs-12 py-1.5 {{ $selectedSdmType === 'alumni' ? 'active' : '' }}" 
                                    wire:click="selectSdmType('alumni')" type="button">
                                Alumni
                            </button>
                        </li>
                    </ul>

                    <!-- Filter & Search -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="ri-search-line"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Cari nama anggota..." 
                                   wire:model.live.debounce.300ms="searchAvailable">
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="selectAll"
                                   wire:model.live="selectAll">
                            <label class="form-check-label text-muted fs-12" for="selectAll">
                                Pilih Semua Halaman Ini
                            </label>
                        </div>
                    </div>

                    <!-- Available Members List -->
                    <div class="available-members-list" style="max-height: 600px; overflow-y: auto; padding-right: 4px;">
                        @forelse($availableMembers as $member)
                            <div class="member-item available-member p-2 mb-2 border rounded hover-shadow bg-white"
                                 wire:key="available-{{ $member->id }}"
                                 data-member-id="{{ $member->id }}"
                                 style="transition: all 0.2s;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 drag-handle me-2" style="cursor: move;">
                                        <i class="ri-drag-move-2-line text-muted"></i>
                                    </div>
                                    <div class="flex-shrink-0 me-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               wire:model.live="selectedMembers" 
                                               value="{{ $member->id }}"
                                               id="member-{{ $member->id }}">
                                    </div>
                                    
                                    <div class="flex-shrink-0">
                                        @if($member->photo)
                                            <img src="{{ asset('storage/' . $member->photo) }}" 
                                                 alt="{{ $member->name }}" 
                                                 class="rounded-circle"
                                                 style="width: 38px; height: 38px; object-fit: cover;">
                                        @else
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-11">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 fs-13 text-dark fw-medium">{{ $member->name }}</h6>
                                        <small class="text-muted fs-11">
                                            @if($selectedSdmType === 'teacher')
                                                {{ $member->jabatan ?? 'Guru/Staff' }}
                                            @elseif($selectedSdmType === 'student')
                                                NISN: {{ $member->nisn ?? '-' }}
                                            @elseif($selectedSdmType === 'structural')
                                                {{ $member->jabatan ?? 'Yayasan' }}
                                            @elseif($selectedSdmType === 'alumni')
                                                Lulus: {{ $member->tahun_lulus ?? '-' }}
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <div class="flex-shrink-0">
                                        <button type="button" 
                                                class="btn btn-sm btn-soft-primary btn-icon"
                                                wire:click="addMember({{ $member->id }})"
                                                title="Tambah ke Section">
                                            <i class="ri-add-line fs-14"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="ri-user-line text-muted" style="font-size: 40px;"></i>
                                <p class="text-muted mt-2 fs-12">Tidak ada anggota tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: Assigned Members grouped by Section -->
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fs-14">
                            <i class="ri-team-line me-2 text-success"></i>Anggota & Pembagian Section
                        </h5>
                        <div style="width: 200px;">
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   placeholder="Filter anggota..." 
                                   wire:model.live.debounce.300ms="searchAssigned">
                        </div>
                    </div>
                </div>
                <div class="card-body" style="background-color: #fcfcfc;">
                    
                    <!-- Sections List -->
                    @forelse($sections as $section)
                        <div class="section-card border rounded p-3 mb-3 bg-white shadow-sm" wire:key="section-card-{{ $section->id }}">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <h6 class="mb-0 fw-semibold text-dark fs-13">
                                    <i class="ri-folder-open-line text-warning me-2"></i>{{ $section->name }}
                                    <span class="badge bg-soft-secondary text-secondary ms-2">{{ $assignedMembers->where('section_id', $section->id)->count() }} Orang</span>
                                </h6>
                                <div class="dropdown">
                                    <button class="btn btn-ghost-secondary btn-icon btn-sm" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item fs-12" href="#" wire:click.prevent="openEditSectionModal({{ $section->id }})"><i class="ri-pencil-line me-2 align-bottom"></i> Rename</a></li>
                                        <li><a class="dropdown-item fs-12 text-danger" href="#" onclick="confirmDeleteSection({{ $section->id }}, '{{ $section->name }}')"><i class="ri-delete-bin-line me-2 align-bottom"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- List of members in this section -->
                            <div class="section-members-list p-1 rounded bg-light" 
                                 data-section-id="{{ $section->id }}"
                                 style="min-height: 60px; max-height: 400px; overflow-y: auto;">
                                
                                @php
                                    $membersInSection = $assignedMembers->where('section_id', $section->id);
                                @endphp
                                
                                @forelse($membersInSection as $structureMember)
                                    <div class="member-item assigned-member p-2 mb-2 border rounded bg-white"
                                         wire:key="assigned-{{ $structureMember->id }}"
                                         data-id="{{ $structureMember->id }}">
                                        <div class="d-flex align-items-center">
                                            <!-- Drag Handle -->
                                            <div class="flex-shrink-0 drag-handle me-2" style="cursor: move;">
                                                <i class="ri-drag-move-2-line text-muted"></i>
                                            </div>

                                            <!-- Photo -->
                                            <div class="flex-shrink-0">
                                                @php
                                                    $person = $structureMember->getPerson();
                                                @endphp
                                                @if($person && $person->photo)
                                                    <img src="{{ asset('storage/' . $person->photo) }}" 
                                                         alt="{{ $person->name }}" 
                                                         class="rounded-circle"
                                                         style="width: 34px; height: 34px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-10" style="width: 34px; height: 34px;">
                                                            {{ $person ? strtoupper(substr($person->name, 0, 1)) : '?' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 fs-13 text-dark fw-medium">{{ $person ? $person->name : 'Unknown' }}</h6>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <!-- Type Badge -->
                                                    @if($structureMember->member_type === \App\Models\Teacher::class)
                                                        <span class="badge bg-soft-success text-success fs-9 py-0.5">Guru/Tendik</span>
                                                    @elseif($structureMember->member_type === \App\Models\Student::class)
                                                        <span class="badge bg-soft-primary text-primary fs-9 py-0.5">Siswa</span>
                                                    @elseif($structureMember->member_type === \App\Models\StructuralMember::class)
                                                        <span class="badge bg-soft-warning text-warning fs-9 py-0.5">Yayasan</span>
                                                    @elseif($structureMember->member_type === \App\Models\Alumni::class)
                                                        <span class="badge bg-soft-info text-info fs-9 py-0.5">Alumni</span>
                                                    @endif
                                                    
                                                    <!-- Position Dropdown -->
                                                    <select class="form-select form-select-sm py-0.5 px-2 fs-10" 
                                                            style="width: auto; border: 1px dashed #ccc;"
                                                            wire:change="updatePosition({{ $structureMember->id }}, $event.target.value)">
                                                        <option value="">Pilih Jabatan</option>
                                                        @foreach($positions as $pos)
                                                            <option value="{{ $pos['name'] }}" 
                                                                    {{ $structureMember->position === $pos['name'] ? 'selected' : '' }}>
                                                                {{ $pos['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="flex-shrink-0 ms-2">
                                                <button type="button" 
                                                        class="btn btn-sm btn-soft-danger btn-icon btn-sm" 
                                                        onclick="confirmDeleteMember({{ $structureMember->id }}, '{{ $person ? addslashes($person->name) : 'anggota' }}')"
                                                        title="Hapus dari struktur">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-3 text-muted fs-11">
                                        <i class="ri-inbox-line me-1"></i>Section kosong, seret anggota ke sini.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 bg-white border rounded">
                            <i class="ri-folder-open-line text-muted" style="font-size: 44px;"></i>
                            <h6 class="mt-2 text-dark">Belum ada Section di struktur ini</h6>
                            <p class="text-muted fs-12 mb-3">Struktur membutuhkan minimal 1 section untuk dapat mengelompokkan anggota.</p>
                            <button type="button" class="btn btn-sm btn-primary" wire:click="openCreateSectionModal">
                                <i class="ri-add-line me-1"></i> Buat Section Pertama
                            </button>
                        </div>
                    @endforelse

                    <!-- Unassigned Members (in case some members do not belong to any section) -->
                    @php
                        $unassignedMembers = $assignedMembers->whereNull('section_id');
                    @endphp
                    @if($unassignedMembers->count() > 0)
                        <div class="section-card border border-danger rounded p-3 mb-3 bg-white shadow-sm" wire:key="section-card-unassigned">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <h6 class="mb-0 fw-semibold text-danger fs-13">
                                    <i class="ri-alert-line text-danger me-2"></i>Belum Memiliki Section (Seret ke salah satu section di atas)
                                    <span class="badge bg-soft-danger text-danger ms-2">{{ $unassignedMembers->count() }} Orang</span>
                                </h6>
                            </div>
                            <div class="section-members-list p-1 rounded bg-light" 
                                 data-section-id="unassigned"
                                 style="min-height: 60px;">
                                @foreach($unassignedMembers as $structureMember)
                                    <div class="member-item assigned-member p-2 mb-2 border rounded bg-white"
                                         wire:key="assigned-{{ $structureMember->id }}"
                                         data-id="{{ $structureMember->id }}">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 drag-handle me-2" style="cursor: move;">
                                                <i class="ri-drag-move-2-line text-muted"></i>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @php $person = $structureMember->getPerson(); @endphp
                                                @if($person && $person->photo)
                                                    <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-10" style="width: 34px; height: 34px;">
                                                            {{ $person ? strtoupper(substr($person->name, 0, 1)) : '?' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 fs-13 text-dark fw-medium">{{ $person ? $person->name : 'Unknown' }}</h6>
                                                <select class="form-select form-select-sm py-0.5 px-2 fs-10 mt-1" style="width: auto; border: 1px dashed #ccc;" wire:change="updatePosition({{ $structureMember->id }}, $event.target.value)">
                                                    <option value="">Pilih Jabatan</option>
                                                    @foreach($positions as $pos)
                                                        <option value="{{ $pos['name'] }}" {{ $structureMember->position === $pos['name'] ? 'selected' : '' }}>{{ $pos['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <button type="button" class="btn btn-sm btn-soft-danger btn-icon btn-sm" onclick="confirmDeleteMember({{ $structureMember->id }}, '{{ $person ? addslashes($person->name) : 'anggota' }}')">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Section Creation Modal -->
    @if($showSectionModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingSectionId ? 'Rename Section' : 'Tambah Section' }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showSectionModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="saveSection">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Section <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('sectionName') is-invalid @enderror" 
                                       wire:model="sectionName"
                                       placeholder="Contoh: Pengurus Inti, Bidang Humas, Anggota">
                                @error('sectionName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showSectionModal', false)">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Position Selection Modal (Single Add) -->
    @if($showPositionModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Section & Jabatan</h5>
                        <button type="button" class="btn-close" wire:click="$set('showPositionModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="savePosition">
                        <div class="modal-body">
                            <!-- Select Section -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Section <span class="text-danger">*</span></label>
                                <select class="form-select @error('selectedSectionId') is-invalid @enderror" 
                                        wire:model="selectedSectionId">
                                    <option value="">-- Pilih Section --</option>
                                    @foreach($sections as $sec)
                                        <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedSectionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Position -->
                            <div class="mb-3">
                                <label class="form-label">Jabatan di Organisasi <span class="text-danger">*</span></label>
                                <select class="form-select @error('selectedPosition') is-invalid @enderror" 
                                        wire:model="selectedPosition">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos['name'] }}">{{ $pos['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('selectedPosition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showPositionModal', false)">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Bulk Add Modal -->
    @if($showBulkModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bulk Tambah Anggota ({{ count($selectedMembers) }} Orang)</h5>
                        <button type="button" class="btn-close" wire:click="$set('showBulkModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="saveBulkMembers">
                        <div class="modal-body">
                            <!-- Select Section -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Section Tujuan <span class="text-danger">*</span></label>
                                <select class="form-select @error('bulkSectionId') is-invalid @enderror" 
                                        wire:model="bulkSectionId">
                                    <option value="">-- Pilih Section --</option>
                                    @foreach($sections as $sec)
                                        <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                                    @endforeach
                                </select>
                                @error('bulkSectionId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Position -->
                            <div class="mb-3">
                                <label class="form-label">Jabatan (Untuk Semua Terpilih) <span class="text-danger">*</span></label>
                                <select class="form-select @error('bulkPosition') is-invalid @enderror" 
                                        wire:model="bulkPosition">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos['name'] }}">{{ $pos['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('bulkPosition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showBulkModal', false)">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambahkan Semua</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Inline Styles -->
    <style>
    .hover-shadow:hover {
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075) !important;
        background-color: #fcfcfc !important;
    }
    .member-item {
        transition: all 0.2s;
    }
    .assigned-member.sortable-ghost {
        opacity: 0.4;
        background-color: #e9ecef !important;
        border: 2px dashed #999 !important;
    }
    .assigned-member.sortable-drag {
        opacity: 0.8;
    }
    </style>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/js/pages/structure-member-manager.js') }}"></script>
@endpush
