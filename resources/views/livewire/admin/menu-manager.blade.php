<div wire:key="menu-manager-component" class="menu-wire-component">
    <!-- Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-3">
            <select id="locationFilter" 
                    class="form-select"
                    wire:model.live="locationFilter">
                <option value="header">Header Menu</option>
                <option value="footer">Footer Menu</option>
                @foreach($programs as $prog)
                    <option value="jurusan_{{ strtolower($prog->kode) }}">Menu Jurusan — {{ $prog->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-9 text-end">
            <button class="btn btn-soft-primary btn-sm" type="button" wire:click="openCreateModal">
                <i class="ri-add-fill align-bottom"></i> Tambah Menu
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

    <!-- Menu List -->
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                <strong>Drag & Drop</strong> untuk mengubah urutan menu. Menu dapat memiliki sub-menu (child).
            </div>

            @if($menus->count() > 0)
                <div class="menu-list-container">
                    <div id="menuList" class="menu-sortable-list">
                    @foreach($menus as $menu)
                        <div class="menu-item card mb-2" data-id="{{ $menu->id }}">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-drag-move-2-line fs-20 text-muted cursor-move"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            @if($menu->children->count() > 0)
                                                <i class="ri-arrow-down-s-line collapse-toggle collapsed me-1" 
                                                   id="toggle-{{ $menu->id }}"
                                                   onclick="event.stopPropagation(); var w=document.getElementById('child-wrapper-{{ $menu->id }}'); if(w){w.classList.toggle('collapsed'); this.classList.toggle('collapsed');}"></i>
                                            @endif
                                            @if($menu->icon)
                                                <i class="{{ $menu->icon }} me-1"></i>
                                            @endif
                                            {{ $menu->title }}
                                            @if($menu->link_type === 'group')
                                                <span class="badge bg-secondary-subtle text-secondary ms-2">Group</span>
                                            @endif
                                            @if($menu->children->count() > 0)
                                                <span class="badge bg-info-subtle text-info ms-2">{{ $menu->children->count() }} sub-menu</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">
                                            @if($menu->link_type === 'page' && $menu->page)
                                                <i class="ri-file-line"></i> Page: {{ $menu->page->title }}
                                            @elseif($menu->link_type === 'structure' && $menu->structure)
                                                <i class="ri-organization-chart"></i> Structure: {{ $menu->structure->data1 }}
                                            @elseif($menu->link_type === 'route')
                                                <i class="ri-route-line"></i> Route: {{ $menu->custom_url }}
                                            @elseif($menu->link_type === 'url')
                                                <i class="ri-link"></i> URL: {{ $menu->custom_url }}
                                            @elseif($menu->link_type === 'group')
                                                <i class="ri-folder-line"></i> Group Menu
                                            @endif
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($menu->is_active)
                                            <span class="badge bg-success-subtle text-success me-2">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary me-2">Nonaktif</span>
                                        @endif
                                        
                                        <div class="btn-group btn-group-sm">
                                            @if($menu->is_active)
                                                <button type="button" 
                                                        class="btn btn-soft-warning" 
                                                        wire:click="toggleStatus({{ $menu->id }})"
                                                        title="Nonaktifkan">
                                                    <i class="ri-close-circle-line"></i>
                                                </button>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-soft-success" 
                                                        wire:click="toggleStatus({{ $menu->id }})"
                                                        title="Aktifkan">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </button>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-soft-secondary" 
                                                    wire:click="openInfoModal({{ $menu->id }})"
                                                    title="Info">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-soft-primary" 
                                                    wire:click="openEditModal({{ $menu->id }})"
                                                    title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-soft-danger" 
                                                    onclick="confirmDelete({{ $menu->id }}, '{{ $menu->title }}')"
                                                    title="Hapus">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Child Menus (Recursive) -->
                                @if($menu->children->count() > 0)
                                    <div class="mt-3 ps-3 child-menu-wrapper collapsed" id="child-wrapper-{{ $menu->id }}" wire:ignore.self>
                                        <div class="child-menu-list">
                                            @foreach($menu->children as $child)
                                                @include('livewire.admin.partials.menu-item', ['menu' => $child, 'level' => 1])
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ri-menu-line" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Belum ada menu. Klik tombol "Tambah Menu" untuk membuat menu baru.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            @if($editMode)
                                Edit Menu
                            @else
                                Tambah Menu Baru
                            @endif
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Judul Menu <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('form.title') is-invalid @enderror" 
                                           id="title"
                                           wire:model="form.title"
                                           placeholder="Masukkan judul menu">
                                    @error('form.title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('form.location') is-invalid @enderror" 
                                            id="location"
                                            wire:model="form.location">
                                        <option value="header">Header Menu</option>
                                        <option value="footer">Footer Menu</option>
                                        @if(isset($programs) && $programs->count())
                                            <optgroup label="── Menu Jurusan ──">
                                                @foreach($programs as $prog)
                                                    <option value="jurusan_{{ strtolower($prog->kode) }}">Menu Jurusan — {{ $prog->nama }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                                    @error('form.location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Parent Menu -->
                                <div class="col-md-6 mb-3">
                                    <label for="parent_id" class="form-label">Parent Menu</label>
                                    <select class="form-select" 
                                            id="parent_id"
                                            wire:model="form.parent_id">
                                        <option value="">Tidak ada (Menu Utama)</option>
                                        @foreach($parentMenus as $parent)
                                            <option value="{{ $parent->id }}">{{ str_repeat('—', $parent->level) }} {{ $parent->title }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih parent jika ini adalah sub-menu (bisa multi-level)</small>
                                </div>

                                <!-- Link Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="link_type" class="form-label">Tipe Link <span class="text-danger">*</span></label>
                                    <select class="form-select @error('form.link_type') is-invalid @enderror" 
                                            id="link_type"
                                            wire:model.live="form.link_type">
                                        <option value="page">Link ke Page</option>
                                        <option value="structure">Link ke Structure</option>
                                        <option value="route">Link ke Route</option>
                                        <option value="url">Custom URL</option>
                                        <option value="group">Group (Tanpa Link)</option>
                                    </select>
                                    @error('form.link_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Page Selection (if link_type = page) -->
                                @if(isset($form['link_type']) && $form['link_type'] === 'page')
                                    <div class="col-md-12 mb-3">
                                        <label for="page_id" class="form-label">Pilih Page</label>
                                        <select class="form-select @error('form.page_id') is-invalid @enderror" 
                                                id="page_id"
                                                wire:model="form.page_id">
                                            <option value="">Pilih Page</option>
                                            @foreach($pages as $page)
                                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.page_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Structure Selection (if link_type = structure) -->
                                @if(isset($form['link_type']) && $form['link_type'] === 'structure')
                                    <div class="col-md-12 mb-3">
                                        <label for="page_id" class="form-label">Pilih Halaman Structure</label>
                                        <select class="form-select @error('form.page_id') is-invalid @enderror" 
                                                id="page_id"
                                                wire:model="form.page_id">
                                            <option value="">Pilih Halaman Structure</option>
                                            @foreach($structurePages as $structurePage)
                                                <option value="{{ $structurePage->id }}">{{ $structurePage->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.page_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Halaman dengan tipe Structure</small>
                                    </div>
                                @endif

                                <!-- Route (if link_type = route) -->
                                @if(isset($form['link_type']) && $form['link_type'] === 'route')
                                    <div class="col-md-12 mb-3">
                                        <label for="custom_url" class="form-label">Route Path</label>
                                        <input type="text" 
                                               class="form-control @error('form.custom_url') is-invalid @enderror" 
                                               id="custom_url"
                                               wire:model="form.custom_url"
                                               placeholder="/berita atau /tentang-kami">
                                        @error('form.custom_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Contoh: /berita, /anggota, /tentang-kami (tanpa domain)</small>
                                    </div>
                                @endif

                                <!-- Custom URL (if link_type = url) -->
                                @if(isset($form['link_type']) && $form['link_type'] === 'url')
                                    <div class="col-md-12 mb-3">
                                        <label for="custom_url" class="form-label">Custom URL</label>
                                        <input type="text" 
                                               class="form-control @error('form.custom_url') is-invalid @enderror" 
                                               id="custom_url"
                                               wire:model="form.custom_url"
                                               placeholder="https://example.com">
                                        @error('form.custom_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">URL lengkap dengan https://</small>
                                    </div>
                                @endif

                                <!-- Icon -->
                                <div class="col-md-6 mb-3">
                                    <label for="icon" class="form-label">Icon (Remix Icon)</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="icon"
                                           wire:model="form.icon"
                                           placeholder="ri-home-line">
                                    <small class="text-muted">Contoh: ri-home-line, ri-user-line</small>
                                </div>

                                <!-- CSS Class -->
                                <div class="col-md-6 mb-3">
                                    <label for="css_class" class="form-label">CSS Class</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="css_class"
                                           wire:model="form.css_class"
                                           placeholder="custom-class">
                                </div>

                                <!-- Checkboxes -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active"
                                               wire:model="form.is_active">
                                        <label class="form-check-label" for="is_active">
                                            Menu Aktif
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="open_new_tab"
                                               wire:model="form.open_new_tab">
                                        <label class="form-check-label" for="open_new_tab">
                                            Buka di Tab Baru
                                        </label>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" 
                                              id="description"
                                              wire:model="form.description"
                                              rows="2"
                                              placeholder="Deskripsi menu (opsional)"></textarea>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-light" wire:click="$set('showModal', false)">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        @if($editMode)
                                            Update Menu
                                        @else
                                            Tambah Menu
                                        @endif
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
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Info Modal -->
    @if($showInfoModal && $selectedMenu)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-information-line me-2"></i>Detail Menu
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showInfoModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td width="40%" class="text-muted">Judul</td>
                                    <td><strong>{{ $selectedMenu->title }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Lokasi</td>
                                    <td><span class="badge bg-primary-subtle text-primary">{{ ucfirst($selectedMenu->location) }}</span></td>
                                </tr>
                                @if($selectedMenu->parent)
                                    <tr>
                                        <td class="text-muted">Parent Menu</td>
                                        <td>{{ $selectedMenu->parent->title }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Tipe Link</td>
                                    <td><span class="badge bg-info-subtle text-info">{{ ucfirst($selectedMenu->link_type) }}</span></td>
                                </tr>
                                @if($selectedMenu->link_type === 'page' && $selectedMenu->page)
                                    <tr>
                                        <td class="text-muted">Page</td>
                                        <td>{{ $selectedMenu->page->title }}</td>
                                    </tr>
                                @elseif($selectedMenu->link_type === 'structure' && $selectedMenu->structure)
                                    <tr>
                                        <td class="text-muted">Structure</td>
                                        <td>{{ $selectedMenu->structure->data1 }}</td>
                                    </tr>
                                @elseif($selectedMenu->link_type === 'route')
                                    <tr>
                                        <td class="text-muted">Route</td>
                                        <td><code>{{ $selectedMenu->custom_url }}</code></td>
                                    </tr>
                                @elseif($selectedMenu->link_type === 'url')
                                    <tr>
                                        <td class="text-muted">URL</td>
                                        <td><code>{{ $selectedMenu->custom_url }}</code></td>
                                    </tr>
                                @endif
                                @if($selectedMenu->icon)
                                    <tr>
                                        <td class="text-muted">Icon</td>
                                        <td><i class="{{ $selectedMenu->icon }}"></i> {{ $selectedMenu->icon }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>
                                        @if($selectedMenu->is_active)
                                            <span class="badge bg-success-subtle text-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($selectedMenu->children->count() > 0)
                                    <tr>
                                        <td class="text-muted">Sub-Menu</td>
                                        <td>{{ $selectedMenu->children->count() }} item</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showInfoModal', false)">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>



@assets
<script src="{{ asset('assets/admin/libs/sortablejs/Sortable.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/menu-manager.js') }}"></script>
@endassets
