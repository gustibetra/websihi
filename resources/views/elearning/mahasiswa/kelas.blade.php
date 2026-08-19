@extends('layouts.elearning')
@section('title', 'Ruang Kelas')
@section('content')

<style>
    .kls-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);transition:.3s;overflow:hidden;}
    .kls-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(0,0,0,.12);}
    .kls-top{height:8px;background:linear-gradient(90deg,#1F57ED,#7A5CF0);}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-edit-2-line text-primary"></i> Ruang Kelas</h4>
        <p class="text-muted small mb-0">Lihat soal ujian & tugas, lalu kumpulkan jawaban melalui link Google Drive</p>
    </div>
</div>

<div class="row g-4">
    @forelse($courses as $c)
        <div class="col-md-4 col-sm-6">
            <div class="kls-card card h-100">
                <div class="kls-top"></div>
                <div class="card-body p-4">
                    <span class="badge bg-primary-subtle text-primary mb-2">{{ $c->program ?? 'Semua Program' }}</span>
                    <h6 class="fw-bold mb-1">{{ $c->title }}</h6>
                    <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($c->description, 60) ?: 'Kelas pembelajaran.' }}</p>
                    <div class="d-flex gap-3 small text-muted mb-3">
                        <span><i class="ri-edit-2-line text-primary me-1"></i>{{ $c->exams_count }} ujian/tugas</span>
                    </div>
                    <a href="{{ route('elearning.mahasiswa.kelas.show', $c->id) }}" class="btn btn-sm btn-primary w-100 fw-bold">
                        Lihat Soal & Kumpulkan <i class="ri-arrow-right-line ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card p-5 text-center text-muted" style="border:none;border-radius:20px;">
            <i class="ri-book-open-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
            Belum ada kelas tersedia.
        </div></div>
    @endforelse
</div>
@endsection