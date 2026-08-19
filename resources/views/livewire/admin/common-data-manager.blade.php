<div class="common-data-page full-height">
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 mb-n4 p-2">
        <!-- Sidebar -->
        @if(!$hideSidebar)
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <div class="mb-3">
                    <h5 class="fw-semibold mb-3">Master Data Sekolah</h5>
                </div>

                <div class="px-4 mx-n4" data-simplebar style="height: calc(100vh - 250px);">
                    <ul class="to-do-menu list-unstyled" id="categorylist-data">
                        <!-- Data Akademik -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#akademikMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['period', 'tingkat_kelas', 'kelas', 'kompetensi_keahlian', 'kurikulum']) ? 'active' : '' }}">
                                <i class="ri-book-open-line align-middle me-2"></i>
                                Data Akademik
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['period', 'tingkat_kelas', 'kelas', 'kompetensi_keahlian', 'kurikulum']) ? 'show' : '' }}" 
                                 id="akademikMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('period')"
                                           class="{{ $selectedData === 'period' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-calendar-todo-line align-middle fs-15 text-primary"></i> Tahun Ajaran / Periode
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('tingkat_kelas')"
                                           class="{{ $selectedData === 'tingkat_kelas' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-stack-line align-middle fs-15 text-info"></i> Tingkat Kelas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kelas')"
                                           class="{{ $selectedData === 'kelas' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-slideshow-3-line align-middle fs-15 text-success"></i> Kelas / Rombel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kompetensi_keahlian')"
                                           class="{{ $selectedData === 'kompetensi_keahlian' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-git-branch-line align-middle fs-15 text-warning"></i> Kompetensi Keahlian
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kurikulum')"
                                           class="{{ $selectedData === 'kurikulum' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-file-list-3-line align-middle fs-15 text-secondary"></i> Kurikulum
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Struktur Organisasi -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#structureMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['structure-sekolah', 'structure-organisasi', 'structure-ekskul', 'structure-kepanitiaan', 'jabatan_organisasi', 'divisi']) ? 'active' : '' }}">
                                <i class="ri-organization-chart align-middle me-2"></i>
                                Struktur Institusi
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['structure-sekolah', 'structure-organisasi', 'structure-ekskul', 'structure-kepanitiaan', 'jabatan_organisasi', 'divisi']) ? 'show' : '' }}" 
                                 id="structureMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('structure-sekolah')"
                                           class="{{ $selectedData === 'structure-sekolah' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-building-line align-middle fs-15 text-success"></i> Organisasi Sekolah
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('structure-organisasi')"
                                           class="{{ $selectedData === 'structure-organisasi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-group-line align-middle fs-15 text-danger"></i> Struktural Institute
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('structure-ekskul')"
                                           class="{{ $selectedData === 'structure-ekskul' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-basketball-line align-middle fs-15 text-warning"></i> Ekstrakurikuler
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('structure-kepanitiaan')"
                                           class="{{ $selectedData === 'structure-kepanitiaan' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-team-line align-middle fs-15 text-info"></i> Kepanitiaan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('jabatan_organisasi')"
                                           class="{{ $selectedData === 'jabatan_organisasi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-user-star-line align-middle fs-15 text-secondary"></i> Jabatan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('divisi')"
                                           class="{{ $selectedData === 'divisi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-git-merge-line align-middle fs-15 text-success"></i> Seksi Bidang / Divisi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Hubungan Industri -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#hubinMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['mitra_industri', 'jenis_kerjasama', 'bidang_industri']) ? 'active' : '' }}">
                                <i class="ri-briefcase-line align-middle me-2"></i>
                                Hubungan Industri
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['mitra_industri', 'jenis_kerjasama', 'bidang_industri']) ? 'show' : '' }}" 
                                 id="hubinMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    {{-- Mitra DU/DI moved to dedicated sidebar link --}}
                                    {{--
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('mitra_industri')"
                                           class="{{ $selectedData === 'mitra_industri' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-building-4-line align-middle fs-15 text-primary"></i> Mitra Industri (DU/DI)
                                        </a>
                                    </li>
                                    --}}
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('jenis_kerjasama')"
                                           class="{{ $selectedData === 'jenis_kerjasama' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-links-line align-middle fs-15 text-success"></i> Jenis Kerjasama
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('bidang_industri')"
                                           class="{{ $selectedData === 'bidang_industri' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-global-line align-middle fs-15 text-info"></i> Bidang Industri
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Profil Tambahan -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#tambahanMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['fasilitas', 'sertifikasi', 'program_unggulan', 'kategori_prestasi', 'tingkatan_prestasi', 'faq']) ? 'active' : '' }}">
                                <i class="ri-award-line align-middle me-2"></i>
                                Profil Tambahan
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['fasilitas', 'sertifikasi', 'program_unggulan', 'kategori_prestasi', 'tingkatan_prestasi', 'faq']) ? 'show' : '' }}" 
                                 id="tambahanMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    {{-- Fasilitas Sekolah moved to dedicated sidebar link --}}
                                    {{--
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('fasilitas')"
                                           class="{{ $selectedData === 'fasilitas' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-hotel-line align-middle fs-15 text-success"></i> Fasilitas Sekolah
                                        </a>
                                    </li>
                                    --}}
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('sertifikasi')"
                                           class="{{ $selectedData === 'sertifikasi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-award-line align-middle fs-15 text-primary"></i> Sertifikasi
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('program_unggulan')"
                                           class="{{ $selectedData === 'program_unggulan' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-vip-crown-line align-middle fs-15 text-warning"></i> Program Unggulan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_prestasi')"
                                           class="{{ $selectedData === 'kategori_prestasi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-trophy-line align-middle fs-15 text-danger"></i> Kategori Prestasi
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('tingkatan_prestasi')"
                                           class="{{ $selectedData === 'tingkatan_prestasi' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-bar-chart-fill align-middle fs-15 text-secondary"></i> Tingkatan Prestasi
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('faq')"
                                           class="{{ $selectedData === 'faq' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-question-answer-line align-middle fs-15 text-info"></i> Frequently Asked Questions (FAQ)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Alumni -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#alumniMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['status_alumni', 'bidang_pekerjaan']) ? 'active' : '' }}">
                                <i class="ri-graduation-cap-line align-middle me-2"></i>
                                Alumni
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['status_alumni', 'bidang_pekerjaan']) ? 'show' : '' }}" 
                                 id="alumniMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('status_alumni')"
                                           class="{{ $selectedData === 'status_alumni' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-user-follow-line align-middle fs-15 text-primary"></i> Status Alumni
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('bidang_pekerjaan')"
                                           class="{{ $selectedData === 'bidang_pekerjaan' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-briefcase-line align-middle fs-15 text-success"></i> Bidang Pekerjaan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Media & Publikasi -->
                        <li>
                            <a data-bs-toggle="collapse" 
                               href="#categoryMenu" 
                               class="nav-link fs-13 {{ in_array($selectedData, ['kategori_berita', 'kategori_event', 'kategori_pengumuman', 'kategori_download', 'kategori_galeri', 'tag_konten', 'news_category', 'event_category', 'announcement_category']) ? 'active' : '' }}">
                                <i class="ri-folder-line align-middle me-2"></i>
                                Media & Publikasi
                            </a>
                            <div class="collapse {{ in_array($selectedData, ['kategori_berita', 'kategori_event', 'kategori_pengumuman', 'kategori_download', 'kategori_galeri', 'tag_konten', 'news_category', 'event_category', 'announcement_category']) ? 'show' : '' }}" 
                                 id="categoryMenu">
                                <ul class="mb-0 sub-menu list-unstyled ps-3 vstack gap-2 mb-2">
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_berita')"
                                           class="{{ in_array($selectedData, ['kategori_berita', 'news_category']) ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-newspaper-line align-middle fs-15 text-primary"></i> Kategori Berita
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_event')"
                                           class="{{ in_array($selectedData, ['kategori_event', 'event_category']) ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-calendar-event-line align-middle fs-15 text-secondary"></i> Kategori Event
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_pengumuman')"
                                           class="{{ in_array($selectedData, ['kategori_pengumuman', 'announcement_category']) ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-notification-3-line align-middle fs-15 text-info"></i> Kategori Pengumuman
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_download')"
                                           class="{{ $selectedData === 'kategori_download' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-download-line align-middle fs-15 text-warning"></i> Kategori Unduhan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('kategori_galeri')"
                                           class="{{ $selectedData === 'kategori_galeri' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-image-line align-middle fs-15 text-success"></i> Kategori Galeri
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" wire:click.prevent="selectData('tag_konten')"
                                           class="{{ $selectedData === 'tag_konten' ? 'text-primary fw-semibold' : '' }}">
                                            <i class="ri-price-tag-3-line align-middle fs-15 text-danger"></i> Tag Konten
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
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
                        {{ $this->getDataTitle() }}
                        <span wire:loading.delay class="ms-2">
                            <span class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>
                    </h5>
                </div>
            </div>

            @if($selectedData)
                <!-- Filter Bar -->
                <div class="p-3 bg-body-secondary rounded mb-4">
                    <div class="row g-2">
                        <div class="col-lg-auto" wire:ignore>
                            <select class="form-control" id="sortSelect">
                                <option value="">Sort By</option>
                                <option value="key1-asc" {{ $sortBy === 'key1' && $sortDirection === 'asc' ? 'selected' : '' }}>ID (A-Z)</option>
                                <option value="key1-desc" {{ $sortBy === 'key1' && $sortDirection === 'desc' ? 'selected' : '' }}>ID (Z-A)</option>
                                <option value="data1-asc" {{ $sortBy === 'data1' && $sortDirection === 'asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="data1-desc" {{ $sortBy === 'data1' && $sortDirection === 'desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            </select>
                        </div>
                        <div class="col-lg">
                            <div class="search-box">
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control search" placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-auto">
                            <button class="btn btn-primary" type="button" wire:click="openCreateModal">
                                <i class="ri-add-fill align-bottom"></i> Add Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
                    <div class="todo-task" id="todo-task">
                        <div class="table-responsive">
                            <table class="table align-middle position-relative table-nowrap">
                                <thead class="table-active">
                                    <tr>
                                        @if($selectedData === 'period')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Period</th>
                                            <th scope="col" width="150">Tanggal Mulai</th>
                                            <th scope="col" width="150">Tanggal Selesai</th>
                                            <th scope="col" width="130" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'tingkat_kelas')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Tingkat</th>
                                            <th scope="col" width="100">Urutan</th>
                                            <th scope="col" width="130" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'kelas')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Kelas</th>
                                            <th scope="col" width="150">Tingkat Kelas</th>
                                            <th scope="col">Jurusan</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'kompetensi_keahlian')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Kompetensi Keahlian</th>
                                            <th scope="col">Jurusan</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'kurikulum')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Kurikulum</th>
                                            <th scope="col" width="120">Tahun</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'mitra_industri')
                                            <th scope="col" width="80">ID</th>
                                            <th scope="col" width="80" class="text-center">Logo</th>
                                            <th scope="col">Nama Mitra</th>
                                            <th scope="col" width="150">Bidang Industri</th>
                                            <th scope="col" width="200">Jenis Kerjasama</th>
                                            <th scope="col" width="150">Website/Kontak</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'faq')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Pertanyaan</th>
                                            <th scope="col">Jawaban</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'fasilitas')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama Fasilitas</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col" width="120">Kapasitas</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'sertifikasi')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col" width="80" class="text-center">Logo</th>
                                            <th scope="col">Nama Sertifikasi</th>
                                            <th scope="col">Lembaga Penerbit</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif($selectedData === 'program_unggulan')
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col" width="100" class="text-center">Image</th>
                                            <th scope="col">Nama Program</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @elseif(str_starts_with($selectedData, 'structure-'))
                                            <th scope="col" width="100">ID</th>
                                            @if(in_array($selectedData, ['structure-organisasi', 'structure-ekskul']))
                                                <th scope="col" width="80" class="text-center">Logo</th>
                                            @endif
                                            <th scope="col">Nama Organisasi</th>
                                            <th scope="col" width="150">Periode</th>
                                            <th scope="col" width="200">Jurusan Terkait</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @else
                                            <th scope="col" width="100">ID</th>
                                            <th scope="col">Nama / Kategori</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col" width="100" class="text-center">Status</th>
                                            <th scope="col" width="150" class="text-center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="data-list">
                                    @if($data && $data->count() > 0)
                                        @foreach($data as $item)
                                            <tr wire:key="item-{{ $item->id }}">
                                                @if($selectedData === 'period')
                                                    <td>{{ $item->key1 }}</td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->date1 ? \Carbon\Carbon::parse($item->date1)->format('d M Y') : '-' }}</td>
                                                    <td>{{ $item->date2 ? \Carbon\Carbon::parse($item->date2)->format('d M Y') : '-' }}</td>
                                                @elseif($selectedData === 'tingkat_kelas')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->data2 ?? '-' }}</td>
                                                @elseif($selectedData === 'kelas')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td><strong>{{ $item->data1 }}</strong></td>
                                                    <td>
                                                        @php
                                                            $tingkat = \DB::table('common')->where('table_name', 'tingkat_kelas')->where('id', $item->data2)->first();
                                                        @endphp
                                                        {{ $tingkat ? $tingkat->data1 : ($item->data2 ?? '-') }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jurusan = \DB::table('programs')->where('id', $item->data3)->first();
                                                        @endphp
                                                        @if($jurusan)
                                                            <span class="badge bg-primary">{{ $jurusan->nama }}</span>
                                                        @else
                                                            <span class="text-muted">Umum</span>
                                                        @endif
                                                    </td>
                                                @elseif($selectedData === 'kompetensi_keahlian')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jurusan = \DB::table('programs')->where('id', $item->data2)->first();
                                                        @endphp
                                                        @if($jurusan)
                                                            <span class="badge bg-primary">{{ $jurusan->nama }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                @elseif($selectedData === 'kurikulum')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->data4 ?? '-' }}</td>
                                                @elseif($selectedData === 'mitra_industri')
                                                    <td>{{ $item->key1 }}</td>
                                                    <td class="text-center">
                                                        @if($item->data3)
                                                            <img src="{{ asset('storage/' . $item->data3) }}" 
                                                                 alt="{{ $item->data1 }}" 
                                                                 class="rounded"
                                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                                        @else
                                                            <div class="avatar-xs mx-auto">
                                                                <span class="avatar-title rounded bg-soft-secondary text-secondary">
                                                                    <i class="ri-building-line"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                    </td>
                                                    <td>
                                                        {{ $item->data4 ?? '-' }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($item->data6))
                                                            @php
                                                                $jkIds = array_filter(explode(';', $item->data6));
                                                                $jkList = \DB::table('common')->where('table_name', 'jenis_kerjasama')->whereIn('id', $jkIds)->get();
                                                            @endphp
                                                            @if($jkList->count() > 0)
                                                                <div class="d-flex flex-wrap gap-1" style="max-width: 200px;">
                                                                    @foreach($jkList as $jk)
                                                                        <span class="badge bg-soft-info text-info" style="font-size: 10px; white-space: normal;">{{ $jk->data1 }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->data2)<a href="{{ $item->data2 }}" target="_blank"><i class="ri-global-line"></i> Web</a><br>@endif
                                                        @if($item->data5)<small><i class="ri-phone-line"></i> {{ $item->data5 }}</small>@endif
                                                    </td>
                                                @elseif($selectedData === 'faq')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                    </td>
                                                    <td class="text-wrap" style="max-width: 350px; white-space: normal;">
                                                        {{ $item->text1 ? Str::limit(strip_tags($item->text1), 120) : '-' }}
                                                    </td>
                                                @elseif($selectedData === 'fasilitas')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->data2 ?? '-' }}</td>
                                                    <td>{{ $item->data4 ?? '-' }}</td>
                                                @elseif($selectedData === 'sertifikasi')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td class="text-center">
                                                        @if($item->data3)
                                                            <img src="{{ asset('storage/' . $item->data3) }}" 
                                                                 alt="{{ $item->data1 }}" 
                                                                 class="rounded"
                                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                                        @else
                                                            <div class="avatar-xs mx-auto">
                                                                <span class="avatar-title rounded bg-soft-secondary text-secondary">
                                                                    <i class="ri-award-line"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->data4 ?? '-' }}</td>
                                                @elseif($selectedData === 'program_unggulan')
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td class="text-center">
                                                        @if($item->data3)
                                                            <img src="{{ asset('storage/' . $item->data3) }}" 
                                                                 alt="{{ $item->data1 }}" 
                                                                 class="rounded"
                                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                                        @else
                                                            <div class="avatar-xs mx-auto">
                                                                <span class="avatar-title rounded bg-soft-secondary text-secondary">
                                                                    <i class="ri-star-line"></i>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                        @if($item->text1)
                                                            <br><small class="text-muted">{{ Str::limit($item->text1, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->data4 ?? '-' }}</td>
                                                @elseif(str_starts_with($selectedData, 'structure-'))
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    @if(in_array($selectedData, ['structure-organisasi', 'structure-ekskul']))
                                                    <td class="text-center">
                                                        @if($item->data6)
                                                            <img src="{{ asset('storage/' . $item->data6) }}" 
                                                                 alt="{{ $item->data1 }}" 
                                                                 class="rounded-circle"
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="avatar-xs mx-auto">
                                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                    {{ substr($item->data1, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    @endif
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $period = \DB::table('common')->where('table_name', 'period')->where('id', $item->data2)->first();
                                                        @endphp
                                                        @if($period)
                                                            <span class="badge bg-primary">{{ $period->data1 }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jurusan = \DB::table('programs')->where('id', $item->data3)->first();
                                                        @endphp
                                                        @if($jurusan)
                                                            <span class="badge bg-soft-primary text-primary">{{ $jurusan->nama }}</span>
                                                        @else
                                                            <span class="text-muted">Umum / Semua Jurusan</span>
                                                        @endif
                                                    </td>
                                                @else
                                                    <!-- Simple/Legacy standard columns -->
                                                    <td><span class="badge bg-info">{{ $item->key1 }}</span></td>
                                                    <td>
                                                        <strong>{{ $item->data1 }}</strong>
                                                    </td>
                                                    <td>{{ $item->text1 ? Str::limit($item->text1, 50) : '-' }}</td>
                                                @endif
                                                
                                                <!-- General Status Column -->
                                                <td class="text-center">
                                                    @if($item->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>

                                                <!-- Action Column -->
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
                                                        
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->data1) }}')" title="Hapus">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center p-4">
                                                <div class="text-muted">
                                                    <i class="ri-inbox-archive-line" style="font-size: 3rem;"></i>
                                                    <p class="mb-0 mt-2">Tidak ada data {{ $this->getDataTitle() }} ditemukan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($data && $data->count() > 0 && method_exists($data, 'links'))
                        <!-- Pagination matching User module layout -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                                    <div wire:ignore style="min-width: 65px;">
                                        <select id="perPageFilter" class="form-select form-select-sm choices-init-hide per-page-select" data-choices data-choices-search-false>
                                            <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="text-muted">|</span>
                                <div class="text-muted" style="font-size: 0.875rem;">
                                    Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} / {{ $data->total() }} rows
                                </div>
                            </div>
                            <div class="pagination-wrap hstack gap-2">
                                {{ $data->links('vendor.pagination.bootstrap-5-always') }}
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center text-muted">
                        <i class="ri-folder-line" style="font-size: 4rem;"></i>
                        <h5 class="mt-3">Pilih Kategori Data</h5>
                        <p>Pilih kategori di sidebar untuk mengelola data</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog {{ in_array($selectedData, ['period', 'tingkat_kelas', 'kelas', 'kompetensi_keahlian', 'kurikulum', 'mitra_industri', 'fasilitas', 'sertifikasi', 'program_unggulan']) || str_starts_with($selectedData, 'structure-') ? 'modal-lg' : '' }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">
                        {{ $editMode ? 'Edit' : 'Tambah' }} {{ $this->getDataTitle() }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body" wire:key="modal-body-{{ $selectedData }}">
                        @if($selectedData === 'period')
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Nama Tahun Ajaran / Periode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Tahun Ajaran 2023/2024">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6" wire:ignore wire:key="period-date1-col">
                                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date1Input" placeholder="Pilih Tanggal">
                                    @error('form.date1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6" wire:ignore wire:key="period-date2-col">
                                    <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date2Input" placeholder="Pilih Tanggal">
                                    @error('form.date2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Tambahan</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Informasi tambahan terkait periode ini"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'tingkat_kelas')
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Nama Tingkat Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Kelas X">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Urutan Sorting <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" wire:model="form.data2" placeholder="Contoh: 1">
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'kelas')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: X RPL 1">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select" wire:model="form.data2">
                                        <option value="">-- Pilih Tingkat --</option>
                                        @foreach($tingkatKelas as $tk)
                                            <option value="{{ $tk['id'] }}">{{ $tk['data1'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Jurusan (Program Keahlian)</label>
                                    <select class="form-select" wire:model="form.data3">
                                        <option value="">-- Umum / Tanpa Jurusan --</option>
                                        @foreach($jurusans as $jur)
                                            <option value="{{ $jur['id'] }}">{{ $jur['data1'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data3') <span class="text-danger small">{{ $message }}</span> @enderror
                                    <small class="text-muted">Pilih jurusan jika kelas ini spesifik untuk satu jurusan.</small>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi / Ruang Kelas</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="2" placeholder="Masukkan lokasi kelas, dsb (opsional)"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'kompetensi_keahlian')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Kompetensi Keahlian <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Pemrograman Web">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jurusan Terkait <span class="text-danger">*</span></label>
                                    <select class="form-select" wire:model="form.data2">
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach($jurusans as $jur)
                                            <option value="{{ $jur['id'] }}">{{ $jur['data1'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'kurikulum')
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Nama Kurikulum <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Kurikulum Merdeka">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tahun Implementasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data4" placeholder="Contoh: 2022">
                                    @error('form.data4') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'mitra_industri')
                            <div class="row g-3">
                                <div class="col-md-12 text-center mb-3">
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                                    @elseif ($editMode && !empty($form['data3']))
                                        <img src="{{ asset('storage/' . $form['data3']) }}" alt="Logo" class="img-thumbnail" style="height: 100px;">
                                    @else
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-light text-muted rounded">
                                                <i class="ri-image-add-line fs-24"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <input type="file" class="form-control d-none" id="logoUpload" wire:model="logo" accept="image/*">
                                        <label for="logoUpload" class="btn btn-sm btn-secondary">Pilih Logo Mitra</label>
                                    </div>
                                    @error('logo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Nama Mitra / Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: PT. Teknologi Bangsa">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bidang Industri</label>
                                    <select class="form-select" wire:model="form.data4">
                                        <option value="">-- Pilih Bidang Industri --</option>
                                        @php
                                            $bidangIndustriList = \DB::table('common')->where('table_name', 'bidang_industri')->where('is_active', true)->orderBy('data1')->get();
                                        @endphp
                                        @foreach($bidangIndustriList as $bi)
                                            <option value="{{ $bi->data1 }}">{{ $bi->data1 }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data4') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Website</label>
                                    <input type="url" class="form-control" wire:model="form.data2" placeholder="Contoh: https://example.com">
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Kontak / Telepon</label>
                                    <input type="text" class="form-control" wire:model="form.data5" placeholder="Contoh: 021-123456">
                                    @error('form.data5') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Jenis Kerjasama <span class="text-danger">*</span> <small class="text-muted">(Bisa pilih lebih dari satu)</small></label>
                                    <div wire:ignore>
                                        <select class="form-control" id="jenisKerjasamaSelect" multiple>
                                            @php
                                                $jenisKerjasamaList = \DB::table('common')->where('table_name', 'jenis_kerjasama')->where('is_active', true)->orderBy('data1')->get();
                                            @endphp
                                            @foreach($jenisKerjasamaList as $jk)
                                                <option value="{{ $jk->id }}">{{ $jk->data1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('form.jenis_kerjasama') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" wire:model="form.text2" rows="2" placeholder="Alamat kantor perusahaan"></textarea>
                                    @error('form.text2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Profil / Deskripsi Perusahaan</label>
                                    <textarea class="form-control" wire:model="form.text3" rows="3" placeholder="Jelaskan mengenai perusahaan ini secara umum..."></textarea>
                                    @error('form.text3') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Kerjasama / MoU</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Jelaskan bentuk kerjasama yang terjalin..."></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'faq')
                                                            <div class="row g-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Apa saja syarat pendaftaran PPDB?">
                                                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Jawaban <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" wire:model="form.text1" rows="5" placeholder="Tulis jawaban lengkap di sini..."></textarea>
                                                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                        @elseif($selectedData === 'fasilitas')
                                                            <div class="row g-3">
                                                                <div class="col-md-12">
                                    <label class="form-label">Nama Fasilitas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Laboratorium Komputer 1">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" wire:model="form.data2" placeholder="Contoh: Gedung B Lantai 2">
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kapasitas</label>
                                    <input type="text" class="form-control" wire:model="form.data4" placeholder="Contoh: 36 Siswa">
                                    @error('form.data4') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Tambahan</label>
                                     <div wire:ignore>
                                         <div id="fasilitas-editor"
                                              data-ckeditor-upload-url="/admin/news/upload-image"
                                              data-ckeditor-content="{{ $form['text1'] ?? '' }}"></div>
                                     </div>
                                    <textarea class="d-none"
                                              name="text1"
                                              id="fasilitas-text1"
                                              wire:model="form.text1">{{ $form['text1'] ?? '' }}</textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Gambar Fasilitas <small class="text-muted">(Bisa pilih lebih dari satu)</small></label>
                                    <input type="file" class="form-control" wire:model="fasilitasImages" multiple accept="image/*">
                                    @error('fasilitasImages.*') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                    
                                    <!-- Preview New Images -->
                                    @if($fasilitasImages)
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @foreach($fasilitasImages as $img)
                                                <div class="position-relative">
                                                    <img src="{{ $img->temporaryUrl() }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Preview Existing Images -->
                                    @if(!empty($existingFasilitasImages))
                                        <div class="d-flex flex-wrap gap-2 mt-3 p-2 bg-light border rounded">
                                            <p class="w-100 mb-1 small fw-medium">Gambar Tersimpan:</p>
                                            @foreach($existingFasilitasImages as $index => $imgPath)
                                                <div class="position-relative">
                                                    <a href="javascript:void(0)" onclick="openPreviewModal('{{ asset('storage/' . $imgPath) }}')">
                                                        <img src="{{ asset('storage/' . $imgPath) }}" class="img-thumbnail border-secondary" style="width: 80px; height: 80px; object-fit: cover;">
                                                    </a>
                                                    <button type="button" wire:click="removeFasilitasImage({{ $index }})" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle p-1" style="width: 24px; height: 24px; line-height: 1;">
                                                        <i class="ri-close-line fs-14"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($selectedData === 'sertifikasi')
                            <div class="row g-3">
                                <div class="col-md-12 text-center mb-3">
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                                    @elseif ($editMode && !empty($form['data3']))
                                        <img src="{{ asset('storage/' . $form['data3']) }}" alt="Logo" class="img-thumbnail" style="height: 100px;">
                                    @else
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-light text-muted rounded">
                                                <i class="ri-award-line fs-24"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <input type="file" class="form-control d-none" id="sertifikasiLogoUpload" wire:model="logo" accept="image/*">
                                        <label for="sertifikasiLogoUpload" class="btn btn-sm btn-secondary">Pilih Logo Sertifikasi</label>
                                    </div>
                                    @error('logo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Nama Sertifikasi / Kompetensi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Mikrotik MTCNA">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lembaga Penerbit / Sertifikasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data4" placeholder="Contoh: Mikrotik / BNSP">
                                    @error('form.data4') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Sertifikasi</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi sertifikasi (opsional)"></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif($selectedData === 'program_unggulan')
                            <div class="row g-3">
                                <div class="col-md-12 text-center mb-3">
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                                    @elseif ($editMode && !empty($form['data3']))
                                        <img src="{{ asset('storage/' . $form['data3']) }}" alt="Banner" class="img-thumbnail" style="height: 100px;">
                                    @else
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-light text-muted rounded">
                                                <i class="ri-star-line fs-24"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <input type="file" class="form-control d-none" id="programLogoUpload" wire:model="logo" accept="image/*">
                                        <label for="programLogoUpload" class="btn btn-sm btn-secondary">Pilih Banner / Icon</label>
                                    </div>
                                    @error('logo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Nama Program Unggulan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: Teaching Factory">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori Program <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data4" placeholder="Contoh: Akademik / Kerjasama Industri">
                                    @error('form.data4') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi Program</label>
                                    <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi program unggulan..."></textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @elseif(str_starts_with($selectedData, 'structure-'))
                            <div class="row g-3">
                                @if(in_array($selectedData, ['structure-organisasi', 'structure-ekskul']))
                                <div class="col-md-12 text-center mb-2">
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-thumbnail rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    @elseif ($editMode && !empty($form['data6']))
                                        <img src="{{ asset('storage/' . $form['data6']) }}" alt="Logo" class="img-thumbnail rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-light text-muted rounded-circle">
                                                <i class="ri-image-add-line fs-24"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <input type="file" class="form-control d-none" id="strukturLogoUpload" wire:model="logo" accept="image/*">
                                        <label for="strukturLogoUpload" class="btn btn-sm btn-secondary">Pilih Logo / Ikon</label>
                                    </div>
                                    @error('logo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label">Nama Organisasi / Struktur <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="form.data1" placeholder="Contoh: OSIS Masa Bakti 2023/2024">
                                    @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tahun Ajaran / Periode Terkait <span class="text-danger">*</span></label>
                                    <select class="form-select" wire:model="form.data2">
                                        <option value="">-- Pilih Periode --</option>
                                        @foreach($periods as $p)
                                            <option value="{{ $p['id'] }}">{{ $p['data1'] }} {{ $p['data4'] == '1' ? '(Aktif)' : '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data2') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Berlaku Untuk Jurusan</label>
                                    <select class="form-select" wire:model="form.data3">
                                        <option value="">-- Umum / Semua Jurusan --</option>
                                        @foreach($jurusans as $jur)
                                            <option value="{{ $jur['id'] }}">{{ $jur['data1'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.data3') <span class="text-danger small">{{ $message }}</span> @enderror
                                    <small class="text-muted">Jika organisasi spesifik untuk satu jurusan (Misal: Himpunan Mahasiswa Jurusan RPL), silakan pilih.</small>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi / Tentang</label>
                                    <div wire:ignore>
                                        <div id="structure-editor"
                                             data-ckeditor-upload-url="/admin/news/upload-image"
                                             data-ckeditor-content="{{ $form['text1'] ?? '' }}"></div>
                                    </div>
                                    <textarea class="d-none"
                                              name="text1"
                                              id="structure-text1"
                                              wire:model="form.text1">{{ $form['text1'] ?? '' }}</textarea>
                                    @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Nama {{ $this->getDataTitle() }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="form.data1" placeholder="Masukkan nama...">
                                @error('form.data1') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" wire:model="form.text1" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                                @error('form.text1') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="mb-3 mt-3">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <input class="form-check-input code-switcher" type="checkbox" id="statusSwitch" 
                                       wire:model="form.is_active">
                                <label class="form-label text-muted" for="statusSwitch">Tampilkan Data Ini (Aktif di Sistem)</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal for Facility Images -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
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

    @push('scripts')
    <script src="{{ asset('assets/admin/libs/ckeditor5/build/ckeditor.js') }}"></script>
    <script>
        let choicesInstance = null;
        let fasilitasEditorInstance = null;
        let structureEditorInstance = null;
        let date1Picker = null;
        let date2Picker = null;

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal', (eventData) => {
                var modal = new bootstrap.Modal(document.getElementById('dataModal'));
                modal.show();

                // Wait for DOM
                setTimeout(() => {
                    // Initialize Flatpickr for Period dates
                    const date1El = document.getElementById('date1Input');
                    const date2El = document.getElementById('date2Input');
                    
                    if (date1El) {
                        if (date1El._flatpickr) {
                            date1El._flatpickr.destroy();
                        }
                        date1Picker = flatpickr(date1El, {
                            dateFormat: 'Y-m-d',
                            altInput: true,
                            altFormat: 'd M, Y',
                            disableMobile: true,
                            defaultDate: @this.get('form.date1') || null,
                            onChange: function(selectedDates, dateStr) {
                                @this.set('form.date1', dateStr);
                            }
                        });
                        date1El._flatpickr = date1Picker;
                    }
                    
                    if (date2El) {
                        if (date2El._flatpickr) {
                            date2El._flatpickr.destroy();
                        }
                        date2Picker = flatpickr(date2El, {
                            dateFormat: 'Y-m-d',
                            altInput: true,
                            altFormat: 'd M, Y',
                            disableMobile: true,
                            defaultDate: @this.get('form.date2') || null,
                            onChange: function(selectedDates, dateStr) {
                                @this.set('form.date2', dateStr);
                            }
                        });
                        date2El._flatpickr = date2Picker;
                    }

                    // Init CKEditor for Fasilitas
                    const editorElement = document.getElementById('fasilitas-editor');
                    if (editorElement && !fasilitasEditorInstance) {
                        const uploadUrl = '/admin/news/upload-image';
                        const initialContent = @this.get('form.text1') || '';
                        if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
                            DKApps.initCKEditor('fasilitas-editor', initialContent, uploadUrl)
                                .then(function(editor) {
                                    fasilitasEditorInstance = editor;
                                    editor.model.document.on('change:data', () => {
                                        const content = editor.getData();
                                        const textarea = document.getElementById('fasilitas-text1');
                                        if (textarea) {
                                            textarea.value = content;
                                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                        }
                                    });
                                })
                                .catch(function(error) {
                                    console.error('Failed to initialize CKEditor for Fasilitas:', error);
                                });
                        }
                    }

                    // Init CKEditor for Structure
                    const structEditorElement = document.getElementById('structure-editor');
                    if (structEditorElement && !structureEditorInstance) {
                        const uploadUrl = '/admin/news/upload-image';
                        const initialContent = @this.get('form.text1') || '';
                        if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
                            DKApps.initCKEditor('structure-editor', initialContent, uploadUrl)
                                .then(function(editor) {
                                    structureEditorInstance = editor;
                                    editor.model.document.on('change:data', () => {
                                        const content = editor.getData();
                                        const textarea = document.getElementById('structure-text1');
                                        if (textarea) {
                                            textarea.value = content;
                                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                        }
                                    });
                                })
                                .catch(function(error) {
                                    console.error('Failed to initialize CKEditor for Structure:', error);
                                });
                        }
                    }
                    var selectEl = document.getElementById('jenisKerjasamaSelect');
                    if (selectEl) {
                        // Destroy previous Choices instance if it exists
                        if (choicesInstance) {
                            choicesInstance.destroy();
                            choicesInstance = null;
                        }

                        // Sync selected values from Livewire to options
                        const detail = eventData[0] || {};
                        const selectedValues = detail.jenisKerjasama || [];
                        Array.from(selectEl.options).forEach(option => {
                            option.selected = selectedValues.map(String).includes(option.value.toString());
                        });

                        // Initialize Choices
                        choicesInstance = new Choices(selectEl, {
                            removeItemButton: true,
                            placeholder: true,
                            placeholderValue: 'Pilih Jenis Kerjasama',
                            itemSelectText: ''
                        });

                        // Explicitly set selected values via Choices API
                        if (selectedValues.length > 0) {
                            choicesInstance.setChoiceByValue(selectedValues.map(String));
                        }

                        // Listen to changes
                        selectEl.addEventListener('change', function(e) {
                            var selected = choicesInstance.getValue(true);
                            var selectedStr = Array.isArray(selected) ? selected.map(String) : (selected ? [String(selected)] : []);
                            @this.set('form.jenis_kerjasama', selectedStr);
                        });
                    }
                }, 180);
            });

            Livewire.on('show-toast', (data) => {
                const toastData = data[0] || data;
                var modalEl = document.getElementById('dataModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal && toastData.type === 'success') {
                    modal.hide();
                }
                
                if (typeof showToast === 'function') {
                    showToast(toastData.message, toastData.type);
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: toastData.type,
                        title: toastData.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    alert(toastData.message);
                }
            });

            // Destroy choices, flatpickr and editor when modal is hidden to avoid leaks
            var modalEl = document.getElementById('dataModal');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    if (fasilitasEditorInstance) {
                        const instance = fasilitasEditorInstance;
                        fasilitasEditorInstance = null;
                        if (instance.sourceElement && instance.sourceElement.isConnected) {
                            Promise.resolve(instance.destroy()).catch(err => {
                                console.warn('Skipping CKEditor destroy:', err);
                            });
                        }
                    }
                    if (structureEditorInstance) {
                        const instance = structureEditorInstance;
                        structureEditorInstance = null;
                        if (instance.sourceElement && instance.sourceElement.isConnected) {
                            Promise.resolve(instance.destroy()).catch(err => {
                                console.warn('Skipping CKEditor destroy:', err);
                            });
                        }
                    }
                    if (choicesInstance) {
                        choicesInstance.destroy();
                        choicesInstance = null;
                    }
                    if (date1Picker) {
                        date1Picker.destroy();
                        date1Picker = null;
                    }
                    if (date2Picker) {
                        date2Picker.destroy();
                        date2Picker = null;
                    }
                });
            }
        });

        window.confirmDelete = function(id, name) {
            const message = `Data "${name}" akan dihapus secara permanen!`;
            
            if (typeof showDeleteConfirm === 'function') {
                showDeleteConfirm(message).then((result) => {
                    if (result.isConfirmed) {
                        const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                        Livewire.find(componentId).call('delete', id);
                    }
                });
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                        Livewire.find(componentId).call('delete', id);
                    }
                });
            } else if (confirm(`Apakah Anda yakin ingin menghapus data "${name}"?`)) {
                const componentId = document.querySelector('[wire\\:id]').getAttribute('wire:id');
                Livewire.find(componentId).call('delete', id);
            }
        }

        window.openPreviewModal = function(src) {
            document.getElementById('modalPreviewImage').src = src;
            var previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            previewModal.show();
        }
    </script>
    @endpush
</div>
