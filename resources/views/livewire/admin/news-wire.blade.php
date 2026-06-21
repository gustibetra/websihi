<div wire:key="news-wire-component" class="news-wire-component">
    <!-- Search & Filter Bar -->
    <div class="row mb-4 align-items-center g-2">
        <div class="col-md-{{ $showAllFilters ? '2' : '4' }}">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       placeholder="Cari berita..." 
                       wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="col-md-{{ $showAllFilters ? '2' : '3' }}">
            <div wire:ignore>
                <select id="statusFilter" 
                        class="form-select choices-init-hide" 
                        data-choices
                        data-choices-search-false>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ $status == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-{{ $showAllFilters ? '2' : '3' }}">
            <div wire:ignore>
                <select id="jurusanFilter" 
                        class="form-select choices-init-hide" 
                        data-choices
                        data-choices-search-true>
                    <option value="">Semua Jurusan/Umum</option>
                    <option value="umum" {{ $jurusanFilter == 'umum' ? 'selected' : '' }}>Umum (Tanpa Jurusan)</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ $jurusanFilter == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }} ({{ $j->singkatan }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($showAllFilters)
            <div class="col-md-2" wire:key="categories-filter">
                <div wire:ignore>
                    <!-- Categories Multiple Select -->
                    <select id="categoriesFilter" 
                            class="form-select choices-init-hide" 
                            multiple
                            data-choices
                            data-choices-multiple-remove
                            data-choices-search-true>
                        @foreach($categoriesList as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, $categories) ? 'selected' : '' }}>
                                {{ $category->data1 }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2" wire:key="periods-filter">
                <div wire:ignore>
                    <!-- Periods Multiple Select -->
                    <select id="periodsFilter" 
                            class="form-select choices-init-hide" 
                            multiple
                            data-choices
                            data-choices-multiple-remove
                            data-choices-search-true>
                        @foreach($periodsList as $periodItem)
                            <option value="{{ $periodItem->data1 }}" {{ in_array($periodItem->data1, $periods) ? 'selected' : '' }}>
                                {{ $periodItem->data1 }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2" wire:key="daterange-filter">
                <div wire:ignore>
                    <!-- Date Range -->
                    <input type="text" 
                           id="dateRangeFilter" 
                           class="form-control" 
                           data-provider="flatpickr"
                           data-date-format="d M, Y"
                           data-range-date="true"
                           data-alt-format="d M, Y"
                           placeholder="Tanggal Terbit"
                           readonly>
                </div>
            </div>
        @else
            <div class="col-md-2">
                <!-- Spacer untuk alignment -->
            </div>
        @endif
    </div>


    <!-- Flash Message akan ditampilkan dengan toast via JavaScript -->
    @if (session()->has('message'))
        <div wire:ignore class="flash-message-success" data-message="{{ session('message') }}"></div>
    @endif

    @if (session()->has('error'))
        <div wire:ignore class="flash-message-error" data-message="{{ session('error') }}"></div>
    @endif

    <!-- Table -->
    <div class="table-responsive table-card mb-2 mt-2 border border-top-dashed">
        <table class="table align-middle table-nowrap mb-0 table-striped table-sm" >
            <thead class="table-light text-muted">
                <tr>
                    <th scope="col" style="width: 40px;">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="checkAll" 
                                   @checked($selectAll)
                                   wire:key="select-all-checkbox">
                        </div>
                    </th>
                    <th class="sort" data-sort="id">
                        <a href="javascript:void(0);" wire:click="sortBy('id')" class="text-muted text-decoration-none">
                            No
                            @if($sortBy === 'id')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th class="sort" data-sort="title">
                        <a href="javascript:void(0);" wire:click="sortBy('title')" class="text-muted text-decoration-none">
                            Judul
                            @if($sortBy === 'title')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th class="sort" data-sort="category">Kategori</th>
                    <th class="sort" data-sort="period">Period</th>
                    <th class="sort" data-sort="status">
                        <a href="javascript:void(0);" wire:click="sortBy('status')" class="text-muted text-decoration-none">
                            Status
                            @if($sortBy === 'status')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                    <th class="sort" data-sort="featured">Featured</th>
                    <th class="sort" data-sort="views">Views</th>
                    <th class="sort" data-sort="published_at">
                        <a href="javascript:void(0);" wire:click="sortBy('published_at')" class="text-muted text-decoration-none">
                            Tanggal
                            @if($sortBy === 'published_at')
                                <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                @forelse($news as $item)
                    <tr wire:key="news-row-{{ $item->id }}">
                        <th scope="row">
                            <div class="form-check">
                                @php
                                    $itemId = (int)$item->id;
                                    $selectedItemsArray = is_array($selectedItems ?? []) 
                                        ? array_map('intval', array_filter($selectedItems, 'is_numeric'))
                                        : [];
                                    $isSelected = in_array($itemId, $selectedItemsArray, true);
                                @endphp
                                <input class="form-check-input checkbox-item" 
                                       type="checkbox" 
                                       name="chk_child" 
                                       value="{{ $itemId }}"
                                       data-item-id="{{ $itemId }}"
                                       @checked($isSelected)
                                       wire:key="checkbox-{{ $itemId }}-{{ $isSelected ? 'checked' : 'unchecked' }}">
                            </div>
                        </th>
                        <td class="id">
                            <a href="{{ route('admin.news.show', $item->id) }}" class="fw-medium link-primary">#{{ $item->id }}</a>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="flex-grow-1 tasks_name">
                                    <div class="d-flex align-items-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="rounded me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="ri-image-line text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($item->title, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($item->excerpt ?? '', 40) }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ms-4 d-flex align-items-center">
                                    <ul class="list-inline tasks-list-menu mb-0 row-actions" style="opacity: 0; transition: opacity 0.2s;">
                                        <li class="list-inline-item">
                                            <a href="{{ route('admin.news.show', $item->id) }}" class="text-muted">
                                                <i class="ri-eye-fill me-2"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ route('admin.news.edit', $item->id) }}" class="text-muted">
                                                <i class="ri-pencil-fill me-2"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" 
                                               onclick="confirmDelete({{ $item->id }})"
                                               class="text-muted">
                                                <i class="ri-delete-bin-fill me-2"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="category">
                            @if($item->category)
                                <span class="badge bg-info-subtle text-info">{{ $item->category->data1 }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                            @if($item->jurusan)
                                <div class="mt-1">
                                    <span class="badge bg-warning-subtle text-warning">{{ $item->jurusan->singkatan }}</span>
                                </div>
                            @else
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark">Umum</span>
                                </div>
                            @endif
                        </td>
                        <td class="period">
                            @if($item->period)
                                <span class="badge bg-secondary-subtle text-secondary">{{ $item->period }}</span>
                            @else
                                <span class="text-muted">Umum</span>
                            @endif
                        </td>
                        <td class="status">
                            @if($item->status == 'published')
                                <span class="badge bg-success-subtle text-success text-uppercase">Published</span>
                            @elseif($item->status == 'draft')
                                <span class="badge bg-warning-subtle text-warning text-uppercase">Draft</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary text-uppercase">Archived</span>
                            @endif
                        </td>
                        <td class="featured">
                            <button type="button" 
                                    class="btn btn-sm btn-link p-0"
                                    wire:click="toggleFeatured({{ $item->id }})"
                                    title="{{ $item->is_featured ? 'Remove from featured' : 'Add to featured' }}">
                                <i class="ri-star-{{ $item->is_featured ? 'fill text-warning' : 'line text-muted' }}" style="font-size: 1.2em;"></i>
                            </button>
                        </td>
                        <td class="views">
                            <span class="badge bg-light text-dark">{{ number_format($item->view_count ?? 0) }}</span>
                        </td>
                        <td class="published_at">
                            <small>
                                <div>{{ $item->published_at ? $item->published_at->format('d M, Y') : '-' }}</div>
                                <div class="text-muted">{{ $item->published_at ? $item->published_at->format('H:i') : '' }}</div>
                            </small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="noresult">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Tidak Ada Data</h5>
                                    <p class="text-muted mb-0">Tidak ada berita yang ditemukan.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination & Row Count -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <!-- Show Row Count Filter -->
            <div class="d-flex align-items-center gap-2">
                <label for="perPageFilter" class="text-muted mb-0" style="font-size: 0.875rem;">Show:</label>
                <div wire:ignore style="min-width: 60px;">
                    <select id="perPageFilter" 
                            class="form-select form-select-sm choices-init-hide per-page-select" 
                            data-choices
                            data-choices-search-false>
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                        <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
            </div>
            
            <span class="text-muted">|</span>
            
            <div class="text-muted">
                @if($news->total() > 0)
                    Menampilkan {{ $news->firstItem() }} - {{ $news->lastItem() }} / {{ $news->total() }} rows
                @else
                    Tidak ada data
                @endif
            </div>
            
            <!-- Filter Active Badges -->
            @php
                $hasActiveFilters = !empty($categories) || !empty($periods) || ($dateFrom && $dateTo) || $jurusanFilter;
            @endphp
            @if($hasActiveFilters)
                <span class="text-muted">|</span>
                <small class="text-muted">Filter Aktif:</small>
                @if(!empty($categories))
                    @php
                        $categoriesMap = $categoriesList->keyBy('id');
                    @endphp
                    @foreach($categories as $categoryId)
                        @php
                            $selectedCategory = $categoriesMap->get($categoryId);
                        @endphp
                        @if($selectedCategory)
                            <span class="badge bg-info">
                                Kategori: {{ $selectedCategory->data1 }}
                                <button type="button" 
                                        class="btn-close btn-close-white ms-1" 
                                        style="font-size: 0.7em;"
                                        wire:click="removeCategory({{ $categoryId }})"
                                        aria-label="Remove"></button>
                            </span>
                        @endif
                    @endforeach
                @endif
                @if($jurusanFilter)
                    @php
                        $selectedJurusan = $jurusanFilter === 'umum' ? null : $jurusans->firstWhere('id', $jurusanFilter);
                    @endphp
                    <span class="badge bg-warning text-dark">
                        Jurusan: {{ $selectedJurusan ? $selectedJurusan->singkatan : 'Umum' }}
                        <button type="button" 
                                class="btn-close btn-close-white ms-1" 
                                style="font-size: 0.7em;"
                                wire:click="$set('jurusanFilter', '')"
                                aria-label="Remove"></button>
                    </span>
                @endif
                @if(!empty($periods))
                    @foreach($periods as $selectedPeriod)
                        <span class="badge bg-secondary">
                            Period: {{ $selectedPeriod }}
                            <button type="button" 
                                    class="btn-close btn-close-white ms-1" 
                                    style="font-size: 0.7em;"
                                    wire:click="removePeriod('{{ $selectedPeriod }}')"
                                    aria-label="Remove"></button>
                        </span>
                    @endforeach
                @endif
                @if($dateFrom && $dateTo)
                    <span class="badge bg-primary">
                        Tanggal: {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
                        <button type="button" 
                                class="btn-close btn-close-white ms-1" 
                                style="font-size: 0.7em;"
                                wire:click="clearDateRange()"
                                aria-label="Remove"></button>
                    </span>
                @endif
                <button type="button" 
                        class="btn btn-sm btn-outline-secondary"
                        wire:click="clearAllFilters()">
                    <i class="ri-close-line me-1"></i>Clear All
                </button>
            @endif
        </div>
        <div class="pagination-wrap hstack gap-2">
            {{ $news->links('vendor.pagination.bootstrap-5-always') }}
        </div>
    </div>
</div>



@push('scripts')
<script src="{{ asset('assets/admin/js/pages/news-wire.js') }}"></script>
@endpush
