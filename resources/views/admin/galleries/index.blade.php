@extends('layouts.admin')

@section('title', 'Gallery')
@section('page-title', 'Gallery')

@push('styles')
<style>
/* ── Gallery Admin — Professional Layout ── */
.gallery-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.gallery-filter-chips {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    flex: 1;
}

.gallery-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.18s ease;
}
.gallery-chip:hover {
    border-color: var(--vz-primary);
    color: var(--vz-primary);
    background: rgba(var(--vz-primary-rgb), 0.05);
}
.gallery-chip.active {
    background: var(--vz-primary);
    border-color: var(--vz-primary);
    color: #fff;
}
.gallery-chip i { font-size: 13px; }

/* Grid card — a bit taller, better proportions */
.ga-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #f1f5f9;
    aspect-ratio: 3 / 4;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}
.ga-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }

.ga-card-img {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.ga-card-empty {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    color: #94a3b8;
}

.ga-card-overlay {
    position: absolute;
    inset: auto 0 0 0;
    background: linear-gradient(0deg, rgba(15,23,42,0.92) 0%, rgba(15,23,42,0) 100%);
    padding: 12px 10px 10px;
}
.ga-card-badges { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 5px; }
.ga-card-title {
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 6px;
}
.ga-card-actions { display: flex; gap: 4px; }
.ga-card-actions .btn { padding: 3px 8px; font-size: 11px; border-radius: 6px; }

/* Stats bar */
.gallery-stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 20px;
}
.gallery-stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
}
.gallery-stat-value { font-weight: 700; color: #1e293b; font-size: 15px; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            {{-- Card Header --}}
            <div class="card-header border-bottom-dashed">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mb-0">
                            <i class="ri-image-2-line me-2 text-primary align-middle"></i>Daftar Gallery
                        </h4>
                        <p class="text-muted mb-0 mt-1" style="font-size:13px;">Kelola album galeri dokumentasi sekolah</p>
                    </div>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Tambah Gallery
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- ── Filter Toolbar ── --}}
                <form method="GET" action="{{ route('admin.galleries.index') }}" id="galleryFilterForm" class="mb-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ri-search-line text-muted"></i></span>
                                <input type="text"
                                       name="search"
                                       class="form-control border-start-0 ps-0"
                                       placeholder="Cari judul gallery..."
                                       value="{{ $search }}"
                                       style="font-size:13px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <select name="category" class="form-select" style="font-size:13px;"
                                    onchange="document.getElementById('galleryFilterForm').submit()">
                                <option value="all">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $categoryFilter == $category->id ? 'selected' : '' }}>
                                        {{ $category->data1 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <select name="jurusan" class="form-select" style="font-size:13px;"
                                    {{ auth()->user()->isAdminJurusan() ? 'disabled' : '' }}
                                    onchange="document.getElementById('galleryFilterForm').submit()">
                                <option value="all">Semua Jurusan</option>
                                <option value="umum" {{ $jurusanFilter == 'umum' ? 'selected' : '' }}>Umum</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}" {{ $jurusanFilter == $j->id ? 'selected' : '' }}>
                                        {{ $j->singkatan ?? $j->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @if(auth()->user()->isAdminJurusan())
                                <input type="hidden" name="jurusan" value="{{ auth()->user()->jurusan_id }}">
                            @endif
                        </div>

                        <div class="col-md-2 col-lg-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100" style="font-size:13px;">
                                <i class="ri-filter-3-line me-1"></i> Filter
                            </button>
                            @if($search || ($categoryFilter && $categoryFilter !== 'all') || ($jurusanFilter && $jurusanFilter !== 'all'))
                                <a href="{{ route('admin.galleries.index') }}" class="btn btn-light w-100" style="font-size:13px;">
                                    <i class="ri-close-line me-1"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Stats bar --}}
                <div class="gallery-stats">
                    <div class="gallery-stat-item">
                        <i class="ri-image-2-line text-primary"></i>
                        <span class="gallery-stat-value">{{ $galleries->total() }}</span>
                        <span>Album ditemukan</span>
                    </div>
                    @if($search || ($categoryFilter && $categoryFilter !== 'all') || ($jurusanFilter && $jurusanFilter !== 'all'))
                        <div class="gallery-stat-item text-warning">
                            <i class="ri-filter-3-line"></i>
                            <span>Filter aktif</span>
                        </div>
                    @endif
                </div>

                {{-- Gallery Grid --}}
                <div class="row g-4">
                    @forelse($galleries as $gallery)
                        @php $coverPath = $gallery->coverImage->image_path ?? null; @endphp
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 shadow-sm border border-light-subtle rounded-3 overflow-hidden">
                                {{-- Image --}}
                                <div class="position-relative bg-light" style="height: 180px; overflow: hidden;">
                                    @if($coverPath)
                                        <img src="{{ asset('storage/' . $coverPath) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $gallery->title }}" loading="lazy">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                            <i class="ri-image-line fs-1"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Image Badge (Kategori & Jurusan) --}}
                                    <div class="position-absolute top-0 start-0 p-2 d-flex flex-wrap gap-1" style="z-index: 5;">
                                        @if($gallery->category)
                                            <span class="badge bg-primary text-white" style="font-size: 10px;">{{ $gallery->category->data1 }}</span>
                                        @endif
                                        @if($gallery->jurusan)
                                            <span class="badge bg-warning text-dark" style="font-size: 10px;">{{ $gallery->jurusan->singkatan }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white" style="font-size: 10px;">Umum</span>
                                        @endif
                                    </div>
                                    
                                    {{-- Photo Count Badge --}}
                                    <div class="position-absolute bottom-0 end-0 m-2" style="z-index: 5;">
                                        <span class="badge bg-dark bg-opacity-75 text-white" style="font-size: 11px;">
                                            <i class="ri-image-line me-1"></i> {{ $gallery->images_count ?? $gallery->images->count() }} Foto
                                        </span>
                                    </div>
                                </div>
                                
                                {{-- Content --}}
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title text-dark fw-semibold mb-2" style="font-size: 14px; line-height: 1.4; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $gallery->title }}
                                        </h5>
                                        <p class="text-muted small mb-0"><i class="ri-time-line me-1"></i> {{ $gallery->created_at->format('d M Y') }}</p>
                                    </div>
                                    
                                    {{-- Actions --}}
                                    <div class="d-flex gap-2 mt-3 pt-2 border-top">
                                        <a href="{{ route('gallery.show', $gallery->slug) }}"
                                           class="btn btn-sm btn-outline-primary flex-grow-1" target="_blank" title="Lihat Publik">
                                            <i class="ri-external-link-line me-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="gallery-delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger js-gallery-delete"
                                                    data-gallery-title="{{ $gallery->title }}" title="Hapus">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 text-muted border rounded-4 bg-light">
                                <i class="ri-image-2-line" style="font-size:48px; opacity:.3; display:block; margin-bottom:10px;"></i>
                                <strong style="font-size:15px; color:#475569;">Belum Ada Gallery</strong>
                                <p class="mb-0 mt-1" style="font-size:13px;">
                                    @if($search || ($categoryFilter && $categoryFilter !== 'all') || ($jurusanFilter && $jurusanFilter !== 'all'))
                                        Tidak ada gallery sesuai filter. <a href="{{ route('admin.galleries.index') }}">Reset filter</a>
                                    @else
                                        Mulai dengan menambahkan album gallery pertama.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $galleries->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-gallery-delete').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const title = this.getAttribute('data-gallery-title') || 'gallery ini';

            const confirmDelete = window.NotifAlert && typeof window.NotifAlert.deleteConfirm === 'function'
                ? window.NotifAlert.deleteConfirm(`Hapus ${title}?`, null)
                : Promise.resolve(window.confirm(`Hapus ${title}?`));

            confirmDelete.then(function (result) {
                if (result === true || result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
