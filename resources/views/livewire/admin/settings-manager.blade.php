<div class="settings-page full-height">
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 mb-n4 p-2">
        <!-- Sidebar -->
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <div class="mb-3">
                    <h5 class="fw-semibold mb-3">Pengaturan</h5>
                </div>

                <div class="px-4 mx-n4" data-simplebar style="height: calc(100vh - 400px);">
                    <ul class="to-do-menu list-unstyled" id="settings-menu">
                        <!-- Pengaturan Institusi -->
                        <li>
                            <a href="#" wire:click.prevent="selectSection('institution')" 
                               class="nav-link fs-13 {{ $selectedSection === 'institution' ? 'active' : '' }}">
                                <i class="ri-building-line align-middle me-2"></i>
                                Pengaturan Institusi
                            </a>
                        </li>

                        <!-- Pengaturan Frontend -->
                        <li>
                            <a href="#" wire:click.prevent="selectSection('frontend')" 
                               class="nav-link fs-13 {{ $selectedSection === 'frontend' ? 'active' : '' }}">
                                <i class="ri-layout-line align-middle me-2"></i>
                                Pengaturan Frontend
                            </a>
                        </li>

                        <!-- Pengaturan Sistem -->
                        <li>
                            <a href="#" wire:click.prevent="selectSection('system')" 
                               class="nav-link fs-13 {{ $selectedSection === 'system' ? 'active' : '' }}">
                                <i class="ri-computer-line align-middle me-2"></i>
                                Pengaturan Sistem
                            </a>
                        </li>
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
                        {{ $this->getSectionTitle() }}
                        <span wire:loading.delay class="ms-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h5>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ri-check-line me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Content Area -->
            <div class="todo-content position-relative px-4 mx-n4" id="settings-content">
                @if($selectedSection === 'institution')
                    <!-- Pengaturan Institusi Form -->
                    <div class="card">
                        <div class="card-body">
                            <form wire:submit.prevent="save">
                                <div class="row g-3">
                                    <!-- Nama Institusi -->
                                    <div class="col-md-12">
                                        <label class="form-label">Nama Institusi <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('institution_name') is-invalid @enderror" 
                                               wire:model="institution_name" 
                                               required>
                                        @error('institution_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-12">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" 
                                                  wire:model="address" 
                                                  rows="3"></textarea>
                                    </div>

                                    <!-- Telepon, Fax, Email, Website -->
                                    <div class="col-md-3">
                                        <label class="form-label">Telepon</label>
                                        <input type="text" class="form-control" wire:model="phone">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Fax</label>
                                        <input type="text" class="form-control" wire:model="fax">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               wire:model="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Website</label>
                                        <input type="url" 
                                               class="form-control @error('website') is-invalid @enderror" 
                                               wire:model="website">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="col-12">
                                        <label class="form-label">Deskripsi Institusi</label>
                                        <textarea class="form-control" wire:model="description" rows="4"></textarea>
                                    </div>

                                    <!-- Visi -->
                                    <div class="col-12">
                                        <label class="form-label">Visi</label>
                                        <textarea class="form-control" wire:model="vision" rows="3"></textarea>
                                    </div>

                                    <!-- Misi -->
                                    <div class="col-12">
                                        <label class="form-label">Misi</label>
                                        <textarea class="form-control" wire:model="mission" rows="4"></textarea>
                                    </div>

                                    <!-- Google Maps -->
                                    <div class="col-12">
                                        <label class="form-label">Google Maps Embed</label>
                                        <textarea class="form-control" wire:model="google_map" rows="3" placeholder="<iframe src=..."></textarea>
                                        <small class="text-muted">Paste embed code dari Google Maps</small>
                                    </div>

                                    <!-- Active Period -->
                                    <div class="col-md-6">
                                        <label class="form-label">Periode Aktif</label>
                                        <input type="text" class="form-control" wire:model="active_period" placeholder="2024-2029">
                                        <small class="text-muted">Format: YYYY-YYYY</small>
                                    </div>

                                    <!-- Social Media -->
                                    <div class="col-12 mt-3">
                                        <h6 class="fw-semibold mb-3">Social Media</h6>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Facebook URL</label>
                                        <input type="url" class="form-control" wire:model="facebook" placeholder="https://facebook.com/...">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Instagram URL</label>
                                        <input type="url" class="form-control" wire:model="instagram" placeholder="https://instagram.com/...">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Twitter URL</label>
                                        <input type="url" class="form-control" wire:model="twitter" placeholder="https://twitter.com/...">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">YouTube URL</label>
                                        <input type="url" class="form-control" wire:model="youtube" placeholder="https://youtube.com/...">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">WhatsApp Number</label>
                                        <input type="text" class="form-control" wire:model="whatsapp" placeholder="628123456789">
                                        <small class="text-muted">Format: 628xxx (tanpa +)</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Link PPDB</label>
                                        <input type="url" class="form-control" wire:model="ppdb_link" placeholder="https://ppdb.example.com">
                                        <small class="text-muted">Link pendaftaran siswa baru</small>
                                    </div>

                                    <!-- Logo (Original) -->
                                    <div class="col-md-4">
                                        <label class="form-label">Logo (Ukuran Asli)</label>
                                        <input type="file" class="form-control" wire:model="tempLogo" accept="image/*">
                                        <small class="text-muted">Ukuran maksimal: 2MB. Format: JPG, PNG</small>
                                        
                                        <div wire:loading wire:target="tempLogo" class="mt-2">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Uploading...</span>
                                            </div>
                                            <span class="ms-2">Uploading...</span>
                                        </div>

                                        @if($tempLogo)
                                            <div class="mt-2">
                                                <img src="{{ $tempLogo->temporaryUrl() }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 100px;">
                                            </div>
                                        @elseif($setting && $setting->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $setting->logo) }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Logo Square (1:1) -->
                                    <div class="col-md-4">
                                        <label class="form-label">Logo Square (1:1)</label>
                                        <input type="file" class="form-control" wire:model="tempLogoSquare" accept="image/*">
                                        <small class="text-muted">Ukuran maksimal: 2MB. Rasio 1:1 (200x200px)</small>
                                        
                                        <div wire:loading wire:target="tempLogoSquare" class="mt-2">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Uploading...</span>
                                            </div>
                                            <span class="ms-2">Uploading...</span>
                                        </div>

                                        @if($tempLogoSquare)
                                            <div class="mt-2">
                                                <img src="{{ $tempLogoSquare->temporaryUrl() }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 100px;">
                                            </div>
                                        @elseif($setting && $setting->logo_square)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $setting->logo_square) }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Favicon -->
                                    <div class="col-md-4">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" class="form-control" wire:model="tempFavicon" accept="image/*">
                                        <small class="text-muted">Ukuran maksimal: 1MB. Format: ICO, PNG (32x32px)</small>
                                        
                                        <div wire:loading wire:target="tempFavicon" class="mt-2">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Uploading...</span>
                                            </div>
                                            <span class="ms-2">Uploading...</span>
                                        </div>

                                        @if($tempFavicon)
                                            <div class="mt-2">
                                                <img src="{{ $tempFavicon->temporaryUrl() }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 32px;">
                                            </div>
                                        @elseif($setting && $setting->favicon)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $setting->favicon) }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 32px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="save">
                                            <i class="ri-save-line align-middle me-1"></i> Simpan Pengaturan
                                        </span>
                                        <span wire:loading wire:target="save">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Menyimpan...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                @elseif($selectedSection === 'frontend')
                    <!-- Pengaturan Frontend - Tabs -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $selectedSubTab === 'menu' ? 'active' : '' }}" 
                                       wire:click.prevent="$set('selectedSubTab', 'menu')" 
                                       href="javascript:void(0);" id="menu-tab-link">
                                        <i class="ri-menu-line me-1"></i> Menu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $selectedSubTab === 'home' ? 'active' : '' }}" 
                                       wire:click.prevent="$set('selectedSubTab', 'home')" 
                                       href="javascript:void(0);">
                                        <i class="ri-home-line me-1"></i> Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $selectedSubTab === 'menu_jurusan' ? 'active' : '' }}" 
                                       wire:click.prevent="$set('selectedSubTab', 'menu_jurusan')" 
                                       href="javascript:void(0);">
                                        <i class="ri-layout-masonry-line me-1"></i> Menu Jurusan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $selectedSubTab === 'theme_seo' ? 'active' : '' }}" 
                                       wire:click.prevent="$set('selectedSubTab', 'theme_seo')" 
                                       href="javascript:void(0);">
                                        <i class="ri-palette-line me-1"></i> SEO
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $selectedSubTab === 'social_media' ? 'active' : '' }}" 
                                       wire:click.prevent="$set('selectedSubTab', 'social_media')" 
                                       href="javascript:void(0);">
                                        <i class="ri-share-line me-1"></i> Social Media
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" wire:key="frontend-tabs-content">
                                <!-- Menu Tab -->
                                @if($selectedSubTab === 'menu')
                                    <div class="tab-pane active show" id="menu-tab" role="tabpanel" wire:key="menu-tab-pane">
                                        <livewire:admin.menu-manager wire:key="menu-manager-comp" />
                                    </div>
                                @endif

                                <!-- Menu Jurusan Tab -->
                                @if($selectedSubTab === 'menu_jurusan')
                                    <div class="tab-pane active show" id="menu-jurusan-tab" role="tabpanel" wire:key="menu-jurusan-tab-pane">
                                        @if(is_null($selectedJurusanKode))
                                            {{-- Program picker --}}
                                            <div class="mb-3">
                                                <h6 class="fw-semibold text-muted mb-3"><i class="ri-layout-masonry-line me-1"></i> Pilih Program Jurusan</h6>
                                                <div class="row g-3">
                                                    @foreach($programs as $prog)
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="card border shadow-none h-100 cursor-pointer"
                                                                 wire:click="selectJurusanMenu('{{ strtolower($prog->kode) }}')"
                                                                 style="cursor:pointer; transition: box-shadow .2s;"
                                                                 onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'"
                                                                 onmouseout="this.style.boxShadow=''"
                                                            >
                                                                <div class="card-body text-center py-4">
                                                                    @if($prog->logo)
                                                                        <img src="{{ asset('storage/'.$prog->logo) }}" alt="" style="width:56px;height:56px;object-fit:contain;margin-bottom:10px;">
                                                                    @else
                                                                        <div style="width:56px;height:56px;border-radius:12px;background:var(--vz-primary-bg-subtle);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                                                            <i class="ri-book-open-line fs-24 text-primary"></i>
                                                                        </div>
                                                                    @endif
                                                                    <h6 class="fw-semibold mb-1 fs-13">{{ $prog->nama }}</h6>
                                                                    <span class="badge bg-primary-subtle text-primary">{{ $prog->kode }}</span>
                                                                    @php
                                                                        $jurusanMenuCount = \App\Models\Menu::where('location', 'jurusan_'.strtolower($prog->kode))->whereNull('parent_id')->count();
                                                                    @endphp
                                                                    <div class="mt-2">
                                                                        <small class="text-muted">{{ $jurusanMenuCount }} menu</small>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-transparent text-center py-2">
                                                                    <span class="text-primary fs-12"><i class="ri-settings-3-line me-1"></i>Kelola Menu</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            {{-- Jurusan menu manager --}}
                                            @php
                                                $activeJurusan = $programs->firstWhere('kode', strtoupper($selectedJurusanKode));
                                            @endphp
                                            <div class="d-flex align-items-center gap-3 mb-4">
                                                <button class="btn btn-sm btn-light" wire:click="selectJurusanMenu(null)">
                                                    <i class="ri-arrow-left-line me-1"></i> Kembali ke Daftar
                                                </button>
                                                @if($activeJurusan)
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if($activeJurusan->logo)
                                                            <img src="{{ asset('storage/'.$activeJurusan->logo) }}" style="width:28px;height:28px;object-fit:contain;">
                                                        @else
                                                            <i class="ri-book-open-line text-primary"></i>
                                                        @endif
                                                        <h6 class="mb-0 fw-semibold">{{ $activeJurusan->nama }}</h6>
                                                        <span class="badge bg-primary-subtle text-primary">{{ $activeJurusan->kode }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <livewire:admin.menu-manager 
                                                :initialLocation="'jurusan_' . $selectedJurusanKode"
                                                wire:key="menu-jurusan-{{ $selectedJurusanKode }}"
                                            />
                                        @endif
                                    </div>
                                @endif

                                <!-- Home Tab -->
                                @if($selectedSubTab === 'home')
                                    <div class="tab-pane active show" id="home-tab" role="tabpanel" wire:key="home-tab-pane">
                                    @if(empty($editingSectionKey))
                                        <div class="table-responsive">
                                            <table class="table table-align-middle table-nowrap mb-0">
                                                <thead class="table-light text-muted">
                                                    <tr>
                                                        <th scope="col" style="width: 80px;">Urutan</th>
                                                        <th scope="col">Nama Section</th>
                                                        <th scope="col" style="width: 120px;">Status</th>
                                                        <th scope="col" style="width: 150px;" class="text-end">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($homeSections as $sec)
                                                        <tr wire:key="section-row-{{ $sec['id'] }}">
                                                            <td>
                                                                <div class="d-flex align-items-center gap-1">
                                                                    <button type="button" 
                                                                            class="btn btn-icon btn-sm btn-ghost-secondary"
                                                                            wire:click="moveSectionUp({{ $sec['id'] }})"
                                                                            title="Pindahkan ke atas">
                                                                        <i class="ri-arrow-up-line"></i>
                                                                    </button>
                                                                    <button type="button" 
                                                                            class="btn btn-icon btn-sm btn-ghost-secondary"
                                                                            wire:click="moveSectionDown({{ $sec['id'] }})"
                                                                            title="Pindahkan ke bawah">
                                                                        <i class="ri-arrow-down-line"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="fw-semibold">{{ $sec['data1'] }}</span>
                                                                <small class="text-muted d-block">Key: {{ $sec['key1'] }}</small>
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" 
                                                                           type="checkbox" 
                                                                           role="switch" 
                                                                           id="sec-switch-{{ $sec['id'] }}"
                                                                           {{ $sec['is_active'] ? 'checked' : '' }}
                                                                           wire:click="toggleSectionActive({{ $sec['id'] }})">
                                                                    <label class="form-check-label" for="sec-switch-{{ $sec['id'] }}">
                                                                        @if($sec['is_active'])
                                                                            <span class="badge bg-success-subtle text-success">Aktif</span>
                                                                        @else
                                                                            <span class="badge bg-danger-subtle text-danger">Nonaktif</span>
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                @if(in_array($sec['key1'], ['hero_banner', 'sambutan', 'statistik', 'karya_siswa', 'school_life']))
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-light" 
                                                                            wire:click="editSection('{{ $sec['key1'] }}')">
                                                                        <i class="ri-edit-line align-middle me-1"></i> Edit Konten
                                                                    </button>
                                                                @else
                                                                    @php
                                                                        $redirectUrl = '#';
                                                                        switch($sec['key1']) {
                                                                            case 'program_keahlian':
                                                                                $redirectUrl = route('admin.jurusan.index');
                                                                                break;
                                                                            case 'program_unggulan':
                                                                                $redirectUrl = route('admin.common-data.index', ['data' => 'program_unggulan']);
                                                                                break;
                                                                            case 'mitra_industri':
                                                                                $redirectUrl = route('admin.mitra-industri.index');
                                                                                break;
                                                                            case 'prestasi_siswa':
                                                                                $redirectUrl = route('admin.achievements.index', ['type' => 'siswa']);
                                                                                break;
                                                                            case 'prestasi_sekolah':
                                                                                $redirectUrl = route('admin.achievements.index', ['type' => 'sekolah']);
                                                                                break;
                                                                            case 'berita_terbaru':
                                                                                $redirectUrl = route('admin.news.index');
                                                                                break;
                                                                            case 'agenda_event':
                                                                                $redirectUrl = route('admin.events.index');
                                                                                break;
                                                                            case 'galeri':
                                                                                $redirectUrl = route('admin.galleries.index');
                                                                                break;
                                                                            case 'alumni_berprestasi':
                                                                                $redirectUrl = route('admin.alumni.index');
                                                                                break;
                                                                            case 'testimoni':
                                                                                $redirectUrl = route('admin.testimonials.index');
                                                                                break;
                                                                            case 'ppdb':
                                                                                $redirectUrl = route('admin.common-data.index', ['data' => 'ppdb']);
                                                                                break;
                                                                            case 'fasilitas':
                                                                                $redirectUrl = route('admin.fasilitas.index');
                                                                                break;
                                                                            case 'faq':
                                                                                $redirectUrl = route('admin.common-data.index', ['data' => 'faq']);
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    <a href="{{ $redirectUrl }}" class="btn btn-sm btn-soft-primary">
                                                                        <i class="ri-external-link-line align-middle me-1"></i> Buka Modul
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <h5 class="fw-semibold mb-0">Mengedit Konten: <span class="text-primary">{{ $editingSectionData['data1'] }}</span></h5>
                                            <button type="button" class="btn btn-sm btn-light" wire:click="cancelEditSection">
                                                <i class="ri-arrow-left-line align-middle me-1"></i> Kembali ke List
                                            </button>
                                        </div>

                                        @if($editingSectionKey === 'hero_banner')
                                            <!-- HERO BANNER CRUD AND CONFIG -->
                                            <div class="row g-3" wire:key="hero-banner-crud-pane">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                        <h6 class="fw-semibold mb-0 text-primary"><i class="ri-slideshow-4-line me-1 align-middle"></i> Kelola Slide Hero Banner</h6>
                                                        @if(!$showBannerForm)
                                                            <button type="button" class="btn btn-sm btn-success" wire:click="openAddBanner">
                                                                <i class="ri-add-line align-middle me-1"></i> Tambah Slide Baru
                                                            </button>
                                                        @endif
                                                    </div>

                                                    @if($showBannerForm)
                                                        <div class="card border bg-light shadow-none mb-4" wire:key="hero-banner-form">
                                                            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-2">
                                                                <h6 class="fw-semibold mb-0 fs-13">{{ $bannerEditMode ? 'Edit Slide Banner' : 'Tambah Slide Baru' }}</h6>
                                                                <button type="button" class="btn-close" wire:click="$set('showBannerForm', false)"></button>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row g-3">
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Teks Motivasi (Headline) <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control form-control-sm" wire:model="banner_motivation" placeholder="Contoh: Mewujudkan Generasi Unggul dan Berkarakter" required>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Teks Detail (Sub-headline)</label>
                                                                        <textarea class="form-control form-control-sm" wire:model="banner_detail" rows="3" placeholder="Deskripsi atau sub-headline penjelas..."></textarea>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Teks Tombol (opsional)</label>
                                                                        <input type="text" class="form-control form-control-sm" wire:model="banner_button_text" placeholder="Contoh: Selengkapnya">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">URL Tombol (opsional)</label>
                                                                        <input type="text" class="form-control form-control-sm" wire:model="banner_url" placeholder="Contoh: # atau /profil">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Foto / Gambar Banner</label>
                                                                        <input type="file" class="form-control form-control-sm" wire:model="tempBannerPhoto" accept="image/*">
                                                                        <small class="text-muted d-block mt-1">Ukuran optimal: 1920x1080px (Rasio 16:9), Max: 2MB</small>
                                                                        
                                                                        <div wire:loading wire:target="tempBannerPhoto" class="mt-2">
                                                                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                                                            <span class="ms-2">Uploading...</span>
                                                                        </div>

                                                                        @if($tempBannerPhoto)
                                                                            <div class="mt-2">
                                                                                <span class="text-success d-block mb-1 fs-12">Preview Foto Baru:</span>
                                                                                <img src="{{ $tempBannerPhoto->temporaryUrl() }}" class="img-thumbnail" style="max-height: 120px;">
                                                                            </div>
                                                                        @elseif($existingBannerPhoto)
                                                                            <div class="mt-2">
                                                                                <span class="text-muted d-block mb-1 fs-12">Foto Sekarang:</span>
                                                                                <img src="{{ asset('storage/' . $existingBannerPhoto) }}" class="img-thumbnail" style="max-height: 120px;">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" id="bannerStatus" wire:model="banner_status">
                                                                            <label class="form-check-label" for="bannerStatus">Tampilkan di Slider (Aktif)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 mt-3 text-end border-top pt-2">
                                                                        <button type="button" class="btn btn-sm btn-ghost-secondary me-2" wire:click="$set('showBannerForm', false)">Batal</button>
                                                                        <button type="button" class="btn btn-sm btn-success" wire:click.prevent="saveBanner">Simpan Slide</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-align-middle table-nowrap mb-0 border">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th scope="col" style="width: 120px;">Foto</th>
                                                                    <th scope="col">Headline / Sub-headline</th>
                                                                    <th scope="col">Tombol & Link</th>
                                                                    <th scope="col" style="width: 100px;">Status</th>
                                                                    <th scope="col" class="text-end" style="width: 100px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($bannerList as $b)
                                                                    <tr wire:key="banner-row-{{ $b['id'] }}">
                                                                        <td>
                                                                            @if(!empty($b['data2']))
                                                                                <img src="{{ asset('storage/' . $b['data2']) }}" class="rounded" style="width: 80px; height: 45px; object-fit: cover;">
                                                                            @else
                                                                                <span class="badge bg-light text-muted">No Image</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-wrap">
                                                                            <div class="fw-semibold">{{ $b['data1'] }}</div>
                                                                            <small class="text-muted d-block text-truncate" style="max-width: 300px;">{{ $b['text1'] }}</small>
                                                                        </td>
                                                                        <td>
                                                                            @if($b['data3'])
                                                                                <span class="badge bg-primary-subtle text-primary">{{ $b['data3'] }}</span>
                                                                                <small class="text-muted d-block text-truncate" style="max-width: 150px;">{{ $b['data4'] }}</small>
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" 
                                                                                    class="btn btn-sm py-0 {{ $b['is_active'] ? 'btn-soft-success' : 'btn-soft-danger' }}"
                                                                                    wire:click.prevent="toggleBannerActive({{ $b['id'] }})">
                                                                                {{ $b['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                                                            </button>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <button type="button" class="btn btn-sm btn-icon btn-ghost-primary" wire:click.prevent="editBanner({{ $b['id'] }})"><i class="ri-edit-line"></i></button>
                                                                            <button type="button" class="btn btn-sm btn-icon btn-ghost-danger" wire:click.prevent="deleteBanner({{ $b['id'] }})"><i class="ri-delete-bin-line"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center text-muted py-3">Belum ada slide banner yang ditambahkan.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <form wire:submit.prevent="saveSectionContent" wire:key="standard-section-form">
                                                <div class="row g-3">
                                                    @if($editingSectionKey === 'sambutan')
                                                        <!-- SAMBUTAN KEPALA SEKOLAH FORM -->
                                                        <div class="col-md-12">
                                                            <label class="form-label">Judul Section (misal: Sambutan Kepala Sekolah)</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data5">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama Kepala Sekolah</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data3">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Jabatan (misal: Kepala Sekolah)</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data4">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Kata Kunci Utama 1 (Poin Penting 1)</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data6" placeholder="Kurikulum Berorientasi Industri">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Kata Kunci Utama 2 (Poin Penting 2)</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data7" placeholder="Lulusan Siap Kerja & Wirausaha">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Isi Sambutan</label>
                                                            <textarea class="form-control" wire:model="editingSectionData.text1" rows="6" placeholder="Isi pesan sambutan kepala sekolah"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Foto Kepala Sekolah (Portrait)</label>
                                                            <input type="file" class="form-control" wire:model="tempPhoto1" accept="image/*">
                                                            <small class="text-muted d-block mt-1">Ukuran optimal: 500x600px, Max: 2MB</small>

                                                            <div wire:loading wire:target="tempPhoto1" class="mt-2">
                                                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                                                <span class="ms-2">Uploading...</span>
                                                            </div>

                                                            @if($tempPhoto1)
                                                                <div class="mt-3">
                                                                    <span class="text-success d-block mb-1">Preview Foto Baru:</span>
                                                                    <img src="{{ $tempPhoto1->temporaryUrl() }}" class="img-thumbnail" style="max-height: 150px;">
                                                                </div>
                                                            @elseif(!empty($editingSectionData['data2']))
                                                                <div class="mt-3">
                                                                    <span class="text-muted d-block mb-1">Foto Sekarang:</span>
                                                                    <img src="{{ asset('storage/' . $editingSectionData['data2']) }}" class="img-thumbnail" style="max-height: 150px;">
                                                                </div>
                                                            @endif
                                                        </div>

                                                    @elseif($editingSectionKey === 'statistik')
                                                        <!-- STATISTIK SEKOLAH FORM -->
                                                        <div class="col-12">
                                                            <div class="alert alert-light alert-border-left border-primary text-primary" role="alert">
                                                                <i class="ri-information-line me-2"></i> Tulis angka statistik secara langsung pada kolom nilai (contoh: 1,200+ atau 85).
                                                            </div>
                                                        </div>
                                                        <!-- Stat 1 -->
                                                        <div class="col-md-6 border-end pb-3">
                                                            <h6 class="fw-semibold text-primary mb-2">Statistik 1</h6>
                                                            <div class="mb-2">
                                                                <label class="form-label">Nama/Label</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data2" placeholder="Siswa Aktif">
                                                            </div>
                                                            <div>
                                                                <label class="form-label">Nilai/Angka</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data3" placeholder="1,200+">
                                                            </div>
                                                        </div>
                                                        <!-- Stat 2 -->
                                                        <div class="col-md-6 pb-3">
                                                            <h6 class="fw-semibold text-primary mb-2">Statistik 2</h6>
                                                            <div class="mb-2">
                                                                <label class="form-label">Nama/Label</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data4" placeholder="Pendidik & Staf">
                                                            </div>
                                                            <div>
                                                                <label class="form-label">Nilai/Angka</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data5" placeholder="85">
                                                            </div>
                                                        </div>
                                                        <!-- Stat 3 -->
                                                        <div class="col-md-6 border-end pt-3">
                                                            <h6 class="fw-semibold text-primary mb-2">Statistik 3</h6>
                                                            <div class="mb-2">
                                                                <label class="form-label">Nama/Label</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data6" placeholder="Program Keahlian">
                                                            </div>
                                                            <div>
                                                                <label class="form-label">Nilai/Angka</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data7" placeholder="3">
                                                            </div>
                                                        </div>
                                                        <!-- Stat 4 -->
                                                        <div class="col-md-6 pt-3">
                                                            <h6 class="fw-semibold text-primary mb-2">Statistik 4</h6>
                                                            <div class="mb-2">
                                                                <label class="form-label">Nama/Label</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data8" placeholder="Mitra Industri">
                                                            </div>
                                                            <div>
                                                                <label class="form-label">Nilai/Angka</label>
                                                                <input type="text" class="form-control" wire:model="editingSectionData.data9" placeholder="50+">
                                                            </div>
                                                        </div>

                                                    @elseif($editingSectionKey === 'karya_siswa')
                                                        <!-- KARYA SISWA SUB-CRUD AND CONFIG -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Judul Section (Header)</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.data2">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Subtitle Section</label>
                                                            <input type="text" class="form-control" wire:model="editingSectionData.text1">
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <div class="border-top pt-3 d-flex align-items-center justify-content-between mb-3">
                                                                <h6 class="fw-semibold mb-0 text-primary"><i class="ri-folder-open-line me-1 align-middle"></i> Kelola Daftar Karya & Projek Siswa</h6>
                                                                @if(!$showKaryaForm)
                                                                    <button type="button" class="btn btn-sm btn-success" wire:click="openAddKarya">
                                                                        <i class="ri-add-line align-middle me-1"></i> Tambah Karya Baru
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            @if($showKaryaForm)
                                                                <div class="card border bg-light shadow-none mb-3" wire:key="karya-siswa-form">
                                                                    <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-2">
                                                                        <h6 class="fw-semibold mb-0 fs-13">{{ $karyaEditMode ? 'Edit Karya Siswa' : 'Tambah Karya Baru' }}</h6>
                                                                        <button type="button" class="btn-close" wire:click="$set('showKaryaForm', false)"></button>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-12">
                                                                                <label class="form-label">Judul Karya / Projek <span class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control form-control-sm" wire:model="karya_judul" required>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-label">Deskripsi Singkat Karya</label>
                                                                                <textarea class="form-control form-control-sm" wire:model="karya_deskripsi" rows="3"></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Jurusan / Program Keahlian</label>
                                                                                <select class="form-select form-select-sm" wire:model="karya_jurusan_id">
                                                                                    <option value="">-- Pilih Jurusan (Opsional) --</option>
                                                                                    @foreach($programs as $p)
                                                                                        <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->singkatan ?: $p->kode }})</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Kaitkan ke Berita Terkait</label>
                                                                                @if($selectedNews)
                                                                                    <div class="input-group input-group-sm">
                                                                                        <span class="input-group-text bg-success-subtle text-success">#{{ $selectedNews->id }}</span>
                                                                                        <input type="text" class="form-control form-control-sm" value="{{ Str::limit($selectedNews->title, 40) }}" readonly>
                                                                                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click="clearSelectedNews">Hapus Tautan</button>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="position-relative">
                                                                                        <div class="input-group input-group-sm">
                                                                                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                                                                                            <input type="text" 
                                                                                                   class="form-control form-control-sm" 
                                                                                                   placeholder="Ketik ID atau judul berita..." 
                                                                                                   wire:model.live.debounce.300ms="newsSearch">
                                                                                        </div>
                                                                                        @if(!empty($newsSearch))
                                                                                            <ul class="dropdown-menu show w-100 shadow-sm border mt-1" style="position: absolute; z-index: 1050; max-height: 200px; overflow-y: auto;">
                                                                                                @forelse($newsResults as $n)
                                                                                                    <li>
                                                                                                        <a class="dropdown-item py-2 text-wrap" href="#" wire:click.prevent="selectNews({{ $n->id }})">
                                                                                                            <span class="badge bg-light text-dark me-1">#{{ $n->id }}</span>
                                                                                                            {{ Str::limit($n->title, 55) }}
                                                                                                        </a>
                                                                                                    </li>
                                                                                                @empty
                                                                                                    <li class="dropdown-item text-muted disabled">Tidak ada berita ditemukan</li>
                                                                                                @endforelse
                                                                                            </ul>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-label">Foto / Gambar Karya</label>
                                                                                <input type="file" class="form-control form-control-sm" wire:model="tempKaryaPhoto" accept="image/*">
                                                                                
                                                                                <div wire:loading wire:target="tempKaryaPhoto" class="mt-2">
                                                                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                                                                    <span class="ms-2">Uploading...</span>
                                                                                </div>

                                                                                @if($tempKaryaPhoto)
                                                                                    <div class="mt-2">
                                                                                        <img src="{{ $tempKaryaPhoto->temporaryUrl() }}" class="img-thumbnail" style="max-height: 100px;">
                                                                                    </div>
                                                                                @elseif($existingKaryaPhoto)
                                                                                    <div class="mt-2">
                                                                                        <img src="{{ asset('storage/' . $existingKaryaPhoto) }}" class="img-thumbnail" style="max-height: 100px;">
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input" type="checkbox" role="switch" id="karyaStatus" wire:model="karya_status">
                                                                                    <label class="form-check-label" for="karyaStatus">Tampilkan di Beranda (Aktif)</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 mt-3 text-end border-top pt-2">
                                                                                <button type="button" class="btn btn-sm btn-ghost-secondary me-2" wire:click="$set('showKaryaForm', false)">Batal</button>
                                                                                <button type="button" class="btn btn-sm btn-success" wire:click.prevent="saveKarya">Simpan Karya</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-align-middle table-nowrap mb-0 border">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Foto</th>
                                                                            <th scope="col">Judul Karya</th>
                                                                            <th scope="col">Jurusan</th>
                                                                            <th scope="col">Status</th>
                                                                            <th scope="col" class="text-end">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($karyaList as $k)
                                                                            <tr wire:key="karya-row-{{ $k['id'] }}">
                                                                                <td>
                                                                                    @if(!empty($k['data2']))
                                                                                        <img src="{{ asset('storage/' . $k['data2']) }}" class="rounded" style="width: 50px; height: 35px; object-fit: cover;">
                                                                                    @else
                                                                                        <span class="badge bg-light text-muted">No Image</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="fw-semibold text-wrap">{{ $k['data1'] }}</td>
                                                                                <td>
                                                                                    @php 
                                                                                        $j = $programs->firstWhere('id', $k['data3']);
                                                                                    @endphp
                                                                                    {{ $j ? ($j->singkatan ?: $j->kode) : '-' }}
                                                                                </td>
                                                                                <td>
                                                                                    <button type="button" 
                                                                                            class="btn btn-sm py-0 {{ $k['is_active'] ? 'btn-soft-success' : 'btn-soft-danger' }}"
                                                                                            wire:click.prevent="toggleKaryaActive({{ $k['id'] }})">
                                                                                        {{ $k['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                                                                    </button>
                                                                                </td>
                                                                                <td class="text-end">
                                                                                    <button type="button" class="btn btn-sm btn-icon btn-ghost-primary" wire:click.prevent="editKarya({{ $k['id'] }})"><i class="ri-edit-line"></i></button>
                                                                                    <button type="button" class="btn btn-sm btn-icon btn-ghost-danger" wire:click.prevent="deleteKarya({{ $k['id'] }})"><i class="ri-delete-bin-line"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="5" class="text-center text-muted py-3">Belum ada karya siswa yang ditambahkan.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                     @elseif($editingSectionKey === 'school_life')
                                                         <!-- SCHOOL LIFE FORM -->
                                                         <div class="col-md-6">
                                                             <label class="form-label">Subtitle Section (misal: School Life)</label>
                                                             <input type="text" class="form-control" wire:model="editingSectionData.data4">
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label class="form-label">Judul Section (misal: Kehidupan Sekolah)</label>
                                                             <input type="text" class="form-control" wire:model="editingSectionData.data5">
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label class="form-label">Badge Nilai (Floating, misal: 99%)</label>
                                                             <input type="text" class="form-control" wire:model="editingSectionData.data6">
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label class="form-label">Badge Keterangan (Floating, misal: Puas)</label>
                                                             <input type="text" class="form-control" wire:model="editingSectionData.data7">
                                                         </div>
                                                         <div class="col-md-12">
                                                             <label class="form-label">Video URL (Youtube/Vimeo)</label>
                                                             <input type="url" class="form-control" wire:model="editingSectionData.data3" placeholder="https://www.youtube.com/watch?v=...">
                                                         </div>
                                                         
                                                         <div class="col-md-12">
                                                             <label class="form-label">Foto / Thumbnail Video</label>
                                                             <input type="file" class="form-control" wire:model="tempPhoto1" accept="image/*">
                                                             <small class="text-muted d-block mt-1">Ukuran optimal: 800x600px, Max: 2MB</small>

                                                             <div wire:loading wire:target="tempPhoto1" class="mt-2">
                                                                 <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                                                 <span class="ms-2">Uploading...</span>
                                                             </div>

                                                             @if($tempPhoto1)
                                                                 <div class="mt-3">
                                                                     <span class="text-success d-block mb-1">Preview Foto Baru:</span>
                                                                     <img src="{{ $tempPhoto1->temporaryUrl() }}" class="img-thumbnail" style="max-height: 150px;">
                                                                 </div>
                                                             @elseif(!empty($editingSectionData['data2']))
                                                                 <div class="mt-3">
                                                                     <span class="text-muted d-block mb-1">Foto Sekarang:</span>
                                                                     <img src="{{ asset('storage/' . $editingSectionData['data2']) }}" class="img-thumbnail" style="max-height: 150px;">
                                                                 </div>
                                                             @endif
                                                         </div>

                                                         <!-- Features list -->
                                                         <div class="col-12 mt-4">
                                                             <h6 class="fw-semibold text-primary border-bottom pb-2">Daftar Fitur / Keunggulan (Maksimal 3)</h6>
                                                         </div>

                                                         <!-- Feature 1 -->
                                                         <div class="col-md-4 border-end">
                                                             <h6 class="fw-semibold text-secondary">Fitur 1</h6>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Judul</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data8" placeholder="Flexible Classes">
                                                             </div>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Icon Class (Feather Icon)</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data9" placeholder="feather-heart">
                                                             </div>
                                                             <div>
                                                                 <label class="form-label fs-12">Deskripsi</label>
                                                                 <textarea class="form-control form-control-sm" wire:model="editingSectionData.text1" rows="3"></textarea>
                                                             </div>
                                                         </div>

                                                         <!-- Feature 2 -->
                                                         <div class="col-md-4 border-end">
                                                             <h6 class="fw-semibold text-secondary">Fitur 2</h6>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Judul</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data10" placeholder="Learn From Anywhere">
                                                             </div>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Icon Class (Feather Icon)</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data11" placeholder="feather-book">
                                                             </div>
                                                             <div>
                                                                 <label class="form-label fs-12">Deskripsi</label>
                                                                 <textarea class="form-control form-control-sm" wire:model="editingSectionData.text2" rows="3"></textarea>
                                                             </div>
                                                         </div>

                                                         <!-- Feature 3 -->
                                                         <div class="col-md-4">
                                                             <h6 class="fw-semibold text-secondary">Fitur 3</h6>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Judul</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data12" placeholder="Skill-Based Learning">
                                                             </div>
                                                             <div class="mb-2">
                                                                 <label class="form-label fs-12">Icon Class (Feather Icon)</label>
                                                                 <input type="text" class="form-control form-control-sm" wire:model="editingSectionData.data13" placeholder="feather-award">
                                                             </div>
                                                             <div>
                                                                 <label class="form-label fs-12">Deskripsi</label>
                                                                 <textarea class="form-control form-control-sm" wire:model="editingSectionData.text3" rows="3"></textarea>
                                                             </div>
                                                         </div>
                                                     @endif
                                                </div>

                                                <div class="mt-4 border-top pt-3 text-end">
                                                    <button type="button" class="btn btn-ghost-secondary me-2" wire:click="cancelEditSection">Batal</button>
                                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveSectionContent">
                                                        <span wire:loading.remove wire:target="saveSectionContent">
                                                            <i class="ri-save-line align-middle me-1"></i> Simpan Konten Section
                                                        </span>
                                                        <span wire:loading wire:target="saveSectionContent">
                                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                                            Menyimpan...
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    </div>
                                @endif

                                <!-- Tampilan & SEO Tab -->
                                @if($selectedSubTab === 'theme_seo')
                                    <div class="tab-pane active show" id="theme-seo-tab" role="tabpanel" wire:key="theme-seo-tab-pane">
                                        <form wire:submit.prevent="saveSeoSettings">
                                            <div class="row g-4">
                                                <!-- Meta Data Section -->
                                                <div class="col-lg-8 border-end pe-lg-4">
                                                    <h5 class="card-title mb-4"><i class="ri-search-eye-line align-bottom text-primary me-2"></i> Pengaturan Optimasi SEO</h5>
                                                    
                                                    <div class="row g-3">
                                                        <!-- Judul Meta -->
                                                        <div class="col-12">
                                                            <label class="form-label font-system fw-medium">Judul Meta (Title Tag) <span class="text-danger">*</span></label>
                                                            <input type="text" 
                                                                   class="form-control @error('seo_meta_title') is-invalid @enderror" 
                                                                   wire:model="seo_meta_title" 
                                                                   placeholder="Contoh: Portal Resmi SMK Negeri 1 Jakarta">
                                                            @error('seo_meta_title')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">Akan ditampilkan pada tab browser dan hasil pencarian Google.</small>
                                                        </div>

                                                        <!-- Deskripsi Meta -->
                                                        <div class="col-12">
                                                            <label class="form-label fw-medium">Deskripsi Meta (Meta Description)</label>
                                                            <textarea class="form-control @error('seo_meta_description') is-invalid @enderror" 
                                                                      wire:model="seo_meta_description" 
                                                                      rows="4" 
                                                                      placeholder="Tuliskan rangkuman singkat sekolah untuk snippet pencarian Google..."></textarea>
                                                            @error('seo_meta_description')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">Rekomendasi panjang deskripsi berkisar antara 150-160 karakter agar optimal.</small>
                                                        </div>

                                                        <!-- Kata Kunci Meta -->
                                                        <div class="col-12">
                                                            <label class="form-label fw-medium">Kata Kunci Meta (Keywords)</label>
                                                            <input type="text" 
                                                                   class="form-control @error('seo_meta_keywords') is-invalid @enderror" 
                                                                   wire:model="seo_meta_keywords" 
                                                                   placeholder="Contoh: smk, sekolah, ppdb, vokasi, jakarta">
                                                            @error('seo_meta_keywords')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">Pisahkan setiap kata kunci menggunakan tanda koma (,).</small>
                                                        </div>
                                                    </div>

                                                    <h5 class="card-title mt-5 mb-4"><i class="ri-line-chart-line align-bottom text-primary me-2"></i> Integrasi Google</h5>
                                                    
                                                    <div class="row g-3">
                                                        <!-- Google Analytics ID -->
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-medium">Google Analytics Measurement ID (G-ID)</label>
                                                            <input type="text" 
                                                                   class="form-control @error('seo_google_analytics') is-invalid @enderror" 
                                                                   wire:model="seo_google_analytics" 
                                                                   placeholder="G-XXXXXXXXXX">
                                                            @error('seo_google_analytics')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">ID Pengukuran Google Analytics 4 (GA4).</small>
                                                        </div>

                                                        <!-- Google Site Verification Code -->
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-medium">Google Site Verification Code</label>
                                                            <input type="text" 
                                                                   class="form-control @error('seo_google_verification') is-invalid @enderror" 
                                                                   wire:model="seo_google_verification" 
                                                                   placeholder="Kode verifikasi Google Search Console">
                                                            @error('seo_google_verification')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">Isi bagian nilai atribut content tag verifikasi.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Open Graph / OG Image Upload Section -->
                                                <div class="col-lg-4 ps-lg-4">
                                                    <h5 class="card-title mb-4"><i class="ri-share-forward-line align-bottom text-primary me-2"></i> Gambar Sharing Sosial</h5>
                                                    
                                                    <div class="card border shadow-none">
                                                        <div class="card-body text-center">
                                                            <label class="form-label d-block text-start fw-medium">Gambar Share (Open Graph Image)</label>
                                                            
                                                            <!-- Preview Section -->
                                                            @if($tempOgImage)
                                                                <div class="mb-3 border rounded p-2 bg-light">
                                                                    <img src="{{ $tempOgImage->temporaryUrl() }}" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">
                                                                    <div class="mt-2"><span class="badge bg-warning">Pratinjau Baru</span></div>
                                                                </div>
                                                            @elseif($seo_og_image)
                                                                <div class="mb-3 border rounded p-2 bg-light">
                                                                    <img src="{{ asset('storage/' . $seo_og_image) }}" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">
                                                                    <div class="mt-2"><span class="badge bg-success">Gambar Aktif</span></div>
                                                                </div>
                                                            @else
                                                                <div class="mb-3 border border-dashed rounded p-4 bg-light d-flex flex-column align-items-center justify-content-center" style="min-height: 180px;">
                                                                    <i class="ri-image-add-line fs-36 text-muted mb-2"></i>
                                                                    <span class="text-muted fs-12">Belum ada gambar diset</span>
                                                                </div>
                                                            @endif

                                                            <div class="mt-3">
                                                                <input type="file" 
                                                                       class="form-control @error('tempOgImage') is-invalid @enderror" 
                                                                       id="seo_og_image_input" 
                                                                       wire:model="tempOgImage" 
                                                                       accept="image/*">
                                                                @error('tempOgImage')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <small class="text-muted mt-2 d-block text-start">Rekomendasi ukuran gambar: 1200 x 630 piksel.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 border-top pt-3 text-end">
                                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveSeoSettings">
                                                    <span wire:loading.remove wire:target="saveSeoSettings">
                                                        <i class="ri-save-line align-middle me-1"></i> Simpan SEO Settings
                                                    </span>
                                                    <span wire:loading wire:target="saveSeoSettings">
                                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                                        Menyimpan...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                                <!-- Social Media Tab -->
                                @if($selectedSubTab === 'social_media')
                                    <div class="tab-pane active show" id="social-media-tab" role="tabpanel" wire:key="social-media-tab-pane">
                                        <form wire:submit.prevent="saveSocialMediaSettings">
                                            <div class="alert alert-info">
                                                <i class="ri-information-line me-2"></i>
                                                Silakan isi tautan profil dan kode embed untuk setiap media sosial. Kode embed biasanya berupa tag <code>&lt;iframe&gt;</code>, widget, atau kode embed resmi yang disediakan oleh masing-masing platform (misal: Youtube Share -> Embed).
                                            </div>

                                            <div class="row g-4">
                                                <!-- Instagram Card -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                                                                    <i class="ri-instagram-line text-danger fs-20"></i> Instagram
                                                                </h6>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="showInstagram" wire:model="social_show_instagram">
                                                                    <label class="form-check-label text-muted" for="showInstagram">Tampilkan di Beranda</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Link Profil Instagram</label>
                                                                <input type="url" class="form-control form-control-sm" placeholder="https://instagram.com/username" wire:model="social_instagram_url">
                                                            </div>
                                                            <div>
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Kode Embed Postingan/Feed Instagram</label>
                                                                <textarea class="form-control form-control-sm" rows="4" placeholder="Masukkan tag blockquote / iframe embed instagram..." wire:model="social_instagram_embed"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- YouTube Card -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                                                                    <i class="ri-youtube-line text-danger fs-20"></i> YouTube
                                                                </h6>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="showYoutube" wire:model="social_show_youtube">
                                                                    <label class="form-check-label text-muted" for="showYoutube">Tampilkan di Beranda</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Link Channel / Video YouTube</label>
                                                                <input type="url" class="form-control form-control-sm" placeholder="https://youtube.com/channel/..." wire:model="social_youtube_url">
                                                            </div>
                                                            <div>
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Kode Embed Video YouTube (Iframe)</label>
                                                                <textarea class="form-control form-control-sm" rows="4" placeholder='Contoh: <iframe src="https://www.youtube.com/embed/XXXX" ...></iframe>' wire:model="social_youtube_embed"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Facebook Card -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                                                                    <i class="ri-facebook-box-line text-primary fs-20"></i> Facebook
                                                                </h6>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="showFacebook" wire:model="social_show_facebook">
                                                                    <label class="form-check-label text-muted" for="showFacebook">Tampilkan di Beranda</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Link Halaman / Profil Facebook</label>
                                                                <input type="url" class="form-control form-control-sm" placeholder="https://facebook.com/page-name" wire:model="social_facebook_url">
                                                            </div>
                                                            <div>
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Kode Embed Postingan/Page Plugin Facebook</label>
                                                                <textarea class="form-control form-control-sm" rows="4" placeholder="Masukkan kode iframe / SDK Facebook Page Plugin..." wire:model="social_facebook_embed"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- TikTok Card -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <h6 class="card-title mb-0 d-flex align-items-center gap-2">
                                                                    <i class="ri-music-fill text-dark fs-20"></i> TikTok
                                                                </h6>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" id="showTiktok" wire:model="social_show_tiktok">
                                                                    <label class="form-check-label text-muted" for="showTiktok">Tampilkan di Beranda</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Link Profil / Video TikTok</label>
                                                                <input type="url" class="form-control form-control-sm" placeholder="https://tiktok.com/@username" wire:model="social_tiktok_url">
                                                            </div>
                                                            <div>
                                                                <label class="form-label text-muted" style="font-size: 12px; font-weight: 500;">Kode Embed Video TikTok</label>
                                                                <textarea class="form-control form-control-sm" rows="4" placeholder="Masukkan kode embed video/feed TikTok..." wire:model="social_tiktok_embed"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 border-top pt-3 text-end">
                                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveSocialMediaSettings">
                                                    <span wire:loading.remove wire:target="saveSocialMediaSettings">
                                                        <i class="ri-save-line align-middle me-1"></i> Simpan Pengaturan Social Media
                                                    </span>
                                                    <span wire:loading wire:target="saveSocialMediaSettings">
                                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                                        Menyimpan...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    


                @elseif($selectedSection === 'system')
                    <!-- Pengaturan Sistem -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pengaturan Keamanan Sistem</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="ri-alert-line me-2"></i>
                                <strong>Perhatian:</strong> Perubahan pengaturan keamanan akan langsung mempengaruhi akses ke sistem. 
                                Pastikan Anda memahami dampak dari setiap pengaturan.
                            </div>
                            
                            <form wire:submit.prevent="saveSecuritySettings">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <h6 class="fw-semibold mb-3">Security Features</h6>
                                    </div>
                                    
                                    <!-- IP Filtering -->
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check form-switch form-switch-lg mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           wire:model="ip_filtering_enabled"
                                                           id="ipFiltering">
                                                    <label class="form-check-label" for="ipFiltering">
                                                        <strong>IP Filtering</strong>
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    Filter akses berdasarkan geolocation. Hanya IP dari Indonesia yang diizinkan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- User Agent Filtering -->
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check form-switch form-switch-lg mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           wire:model="user_agent_filtering_enabled"
                                                           id="userAgentFiltering">
                                                    <label class="form-check-label" for="userAgentFiltering">
                                                        <strong>User Agent Filtering</strong>
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    Block request dari Postman, cURL, Wget, dan tools sejenis untuk prevent API abuse.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Rate Limiting -->
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check form-switch form-switch-lg mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           wire:model="rate_limiting_enabled"
                                                           id="rateLimiting">
                                                    <label class="form-check-label" for="rateLimiting">
                                                        <strong>Rate Limiting</strong>
                                                    </label>
                                                </div>
                                                <small class="text-muted d-block mb-2">
                                                    Batasi jumlah request per IP untuk prevent abuse.
                                                </small>
                                                <div class="mt-2">
                                                    <label class="form-label mb-1">Max Requests per Hour</label>
                                                    <input type="number" 
                                                           class="form-control form-control-sm" 
                                                           wire:model="rate_limit_per_hour"
                                                           min="10" 
                                                           max="1000"
                                                           style="max-width: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Security Logging -->
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check form-switch form-switch-lg mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           wire:model="security_logging_enabled"
                                                           id="securityLogging">
                                                    <label class="form-check-label" for="securityLogging">
                                                        <strong>Security Logging</strong>
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    Log semua aktivitas keamanan (blocked requests, failed login, dll) ke database.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Disable Devtools -->
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check form-switch form-switch-lg mb-2">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           wire:model="disable_devtools"
                                                           id="disableDevtools">
                                                    <label class="form-check-label" for="disableDevtools">
                                                        <strong>Disable Developer Tools</strong>
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    Mencegah pengguna membuka inspect element (F12, Klik Kanan, Ctrl+Shift+I/J/C) pada halaman publik.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="saveSecuritySettings">
                                            <i class="ri-save-line align-middle me-1"></i> Simpan Pengaturan
                                        </span>
                                        <span wire:loading wire:target="saveSecuritySettings">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Menyimpan...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
