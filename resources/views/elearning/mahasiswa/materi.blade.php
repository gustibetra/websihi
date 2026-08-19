@extends('layouts.elearning')
@section('title', 'Ruang Materi')
@section('content')

<style>
    .mat-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);overflow:hidden;}
    .mat-head{background:linear-gradient(135deg,#1F57ED,#7A5CF0);color:#fff;padding:18px 24px;}
    .mat-file{display:flex;align-items:center;gap:14px;padding:14px 24px;border-top:1px solid #F1F5F9;transition:.2s;}
    .mat-file:hover{background:#F8FAFF;}
    .mat-file .fic{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-folder-download-line text-primary"></i> Ruang Materi</h4>
        <p class="text-muted small mb-0">Unduh materi pembelajaran yang dibagikan oleh staff pengajar</p>
    </div>
    <input type="text" id="matSearch" class="form-control form-control-sm" style="max-width:240px;" placeholder="🔍 Cari materi...">
</div>

<div class="row g-4">
    @forelse($courses as $c)
        @if($c->materials->count() > 0)
        <div class="col-lg-6 mat-col">
            <div class="mat-card card h-100">
                <div class="mat-head d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:rgba(255,255,255,.15);font-size:20px;"><i class="ri-book-open-line"></i></div>
                    <div>
                        <div class="fw-bold">{{ $c->title }}</div>
                        <small style="opacity:.8;">{{ $c->materials->count() }} materi • {{ $c->program ?? 'Semua Program' }}</small>
                    </div>
                </div>
                @foreach($c->materials as $m)
                    <div class="mat-file">
                        <div class="fic" style="background:#EEF2FF;color:#1F57ED;"><i class="ri-file-text-line"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $m->title }}</div>
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($m->description, 50) ?: 'Materi pembelajaran' }} • {{ $m->created_at->format('d M Y') }}</small>
                        </div>
                        <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="btn btn-sm btn-success fw-bold text-nowrap">
                            <i class="ri-download-2-line me-1"></i> Unduh
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @empty
        <div class="col-12"><div class="card mat-card p-5 text-center text-muted">
            <i class="ri-folder-open-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
            Belum ada materi yang dibagikan.
        </div></div>
    @endforelse
</div>

@push('scripts')
<script>
    document.getElementById('matSearch').addEventListener('input', function(){
        const q = this.value.toLowerCase();
        document.querySelectorAll('.mat-col').forEach(function(col){
            col.style.display = col.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection