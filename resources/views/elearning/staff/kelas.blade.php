@extends('layouts.elearning')
@section('title', 'Kelas Saya')
@section('content')

{{-- Alert Success / Error --}}
@if(session('success'))
    <div class="alert alert-success py-2 small mb-3">
        <i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger py-2 small mb-3">
        <i class="ri-error-warning-line me-1"></i>{{ session('error') }}
    </div>
@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-book-open-line text-primary"></i> Ruang Kelas</h4>
        <p class="text-muted small mb-0">Buat kelas, kirim materi harian, dan buka ujian untuk mahasiswa</p>
    </div>
</div>

{{-- Form Buat Kelas --}}
<div class="el-card card mb-4">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="ri-add-circle-line text-success me-1"></i> Buka Kelas Baru</h6>
        <form method="POST" action="{{ route('elearning.staff.kelas.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label small fw-bold">Nama Kelas / Mata Kuliah <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-sm" placeholder="Contoh: Room Division 101" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Program (opsional)</label>
                <input type="text" name="program" class="form-control form-control-sm" placeholder="Kosongkan = semua program">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Deskripsi</label>
                <input type="text" name="description" class="form-control form-control-sm" placeholder="Deskripsi singkat kelas">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-sm btn-success w-100 fw-bold">+ Buat</button>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Kelas --}}
<div class="row g-3">
    @forelse($courses as $c)
        <div class="col-md-4 col-sm-6">
            <div class="el-card card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge bg-primary-subtle text-primary">{{ $c->program ?: 'Semua Program' }}</span>
                    <small class="text-muted">{{ $c->created_at->format('d/m/Y') }}</small>
                </div>
                <h6 class="fw-bold mb-1">{{ $c->title }}</h6>
                <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($c->description, 60) ?: 'Tanpa deskripsi.' }}</p>
                <div class="d-flex gap-3 small text-muted mb-3">
                    <span><i class="ri-folder-line text-success me-1"></i>{{ $c->materials_count }} materi</span>
                    <span><i class="ri-edit-line text-primary me-1"></i>{{ $c->exams_count }} ujian</span>
                </div>

                {{-- ✅ TOMBOL KELOLA + HAPUS (BARU) --}}
                <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('elearning.staff.kelas.show', $c->id) }}" class="btn btn-sm btn-primary flex-grow-1 fw-bold">
                        <i class="ri-settings-3-line me-1"></i> Kelola Kelas
                    </a>

                    {{-- ✅ TOMBOL HAPUS KELAS --}}
                    <form method="POST" action="{{ route('elearning.staff.kelas.destroy', $c->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus kelas &quot;{{ $c->title }}&quot;?\n\n⚠️ Semua materi, ujian, dan jawaban mahasiswa di dalamnya akan dihapus PERMANEN dari server.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus kelas">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="el-card card p-5 text-center text-muted">
                <i class="ri-book-open-line" style="font-size:48px; opacity:.3;"></i>
                <p class="mt-3 mb-0">Belum ada kelas. Buat kelas pertama Anda di form atas.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection