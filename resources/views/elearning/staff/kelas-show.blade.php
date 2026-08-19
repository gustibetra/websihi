@extends('layouts.elearning')
@section('title', 'Kelola: ' . $course->title)
@section('content')

@if(session('success'))
    <div class="alert alert-success py-2 small"><i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger py-2 small"><i class="ri-error-warning-line me-1"></i>{{ session('error') }}</div>
@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-book-2-line text-primary"></i> {{ $course->title }}</h4>
        <p class="text-muted small mb-0">{{ $course->program ?: 'Semua Program' }} • {{ $course->description }}</p>
    </div>
    <a href="{{ route('elearning.staff.kelas') }}" class="btn btn-sm btn-light"><i class="ri-arrow-left-line me-1"></i> Kembali</a>
</div>

<div class="row g-4">
    {{-- ═══ KOLOM MATERI ═══ --}}
    <div class="col-lg-6">
        <div class="el-card card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="ri-folder-upload-line text-success me-1"></i> Kirim Materi Harian</h6>
            <form method="POST" action="{{ route('elearning.staff.materi.store', $course->id) }}" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-2">
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Judul materi (wajib)" required>
                </div>
                <div class="mb-2">
                    <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Catatan / deskripsi materi (opsional)"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <input type="file" name="file" class="form-control form-control-sm" required>
                    <button class="btn btn-sm btn-success fw-bold text-nowrap"><i class="ri-send-plane-line me-1"></i> Kirim</button>
                </div>
                <small class="text-muted">Max 10MB (PDF, PPT, DOC, video, dll)</small>
            </form>

            <h6 class="fw-bold mb-2">Materi Terkirim ({{ $course->materials->count() }})</h6>
            <div class="list-group list-group-flush">
                @forelse($course->materials as $m)
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div class="me-2" style="min-width:0;">
                            <div class="fw-bold small text-truncate">{{ $m->title }}</div>
                            <small class="text-muted">{{ $m->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div class="d-flex gap-1 text-nowrap">
                            <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="btn btn-sm btn-light" title="Unduh">
                                <i class="ri-download-2-line"></i>
                            </a>
                            <form method="POST" action="{{ route('elearning.staff.materi.destroy', $m->id) }}"
                                  onsubmit="return confirm('Hapus materi &quot;{{ $m->title }}&quot;?\nFile akan dihapus permanen dari server.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus materi">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small text-center py-3">Belum ada materi terkirim.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══ KOLOM UJIAN ═══ --}}
    <div class="col-lg-6">
        <div class="el-card card p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="ri-edit-2-line text-primary me-1"></i> Buat & Buka Ujian / Tugas</h6>
            
            {{-- ✅ Tambah enctype agar bisa upload file --}}
            <form method="POST" action="{{ route('elearning.staff.ujian.store', $course->id) }}" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-2">
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Judul ujian/tugas (wajib)" required>
                </div>
                <div class="mb-2">
                    <select name="type" class="form-select form-select-sm">
                        <option value="ujian">📝 Ujian</option>
                        <option value="tugas">📚 Tugas</option>
                    </select>
                </div>
                <div class="mb-2">
                    <textarea name="instructions" class="form-control form-control-sm" rows="2" placeholder="Instruksi pengerjaan (opsional)"></textarea>
                </div>

                {{-- ✅ BARU: Input file soal --}}
                <div class="mb-2">
                    <label class="small text-muted mb-1 d-block">
                        <i class="ri-attachment-2 me-1"></i> File Soal (opsional — PDF/DOC/PPT/ZIP, max 10MB)
                    </label>
                    <input type="file" name="soal" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar,.jpg,.jpeg,.png">
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="small text-muted">Waktu Mulai</label>
                        <input type="datetime-local" name="start_at" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="small text-muted">Waktu Selesai</label>
                        <input type="datetime-local" name="end_at" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_open" value="1" id="openNow">
                    <label class="form-check-label small" for="openNow">Buka ujian SEKARANG (abaikan jadwal)</label>
                </div>
                <button class="btn btn-sm btn-primary fw-bold w-100"><i class="ri-add-line me-1"></i> Simpan Ujian/Tugas</button>
            </form>

            <h6 class="fw-bold mb-2">Daftar Ujian & Jawaban Mahasiswa</h6>
            @forelse($course->exams as $exam)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="badge {{ ($exam->type ?? 'ujian') === 'tugas' ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary' }}">
                                {{ ucfirst($exam->type ?? 'ujian') }}
                            </span>
                            <strong class="small">{{ $exam->title }}</strong>
                        </div>
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('elearning.staff.ujian.toggle', $exam->id) }}">
                                @csrf
                                <button class="btn btn-sm {{ $exam->isOpen() ? 'btn-success' : 'btn-secondary' }} fw-bold">
                                    {{ $exam->isOpen() ? '● TERBUKA' : '○ TERTUTUP' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('elearning.staff.ujian.destroy', $exam->id) }}"
                                  onsubmit="return confirm('Hapus ujian &quot;{{ $exam->title }}&quot; beserta SEMUA jawaban mahasiswa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus ujian">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <small class="text-muted d-block mb-2">
                        <i class="ri-time-line me-1"></i>
                        {{ $exam->start_at?->format('d/m/Y H:i') ?? 'Belum diatur' }} 
                        — 
                        {{ $exam->end_at?->format('d/m/Y H:i') ?? 'Belum diatur' }}
                    </small>

                    {{-- ✅ BARU: BLOK FILE SOAL (Lihat / Hapus / Upload Susulan) --}}
                    <div class="mb-3 p-2 rounded" style="background:#f8f9fa;">
                        @if($exam->soal_path)
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <a href="{{ asset('storage/' . $exam->soal_path) }}" target="_blank" 
                                   class="btn btn-sm btn-primary flex-grow-1 text-start">
                                    <i class="ri-file-pdf-2-line me-1"></i> 
                                    <span class="small">Lihat/Unduh File Soal</span>
                                </a>
                                <form method="POST" action="{{ route('elearning.staff.ujian.soal.destroy', $exam->id) }}"
                                      onsubmit="return confirm('Hapus file soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus file soal">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="small text-muted mt-1">
                                <i class="ri-information-line me-1"></i>
                                File soal sudah diupload. Klik tombol merah untuk menghapus dan mengganti dengan file baru.
                            </div>
                        @else
                            <form method="POST" action="{{ route('elearning.staff.ujian.soal', $exam->id) }}" 
                                  enctype="multipart/form-data" class="d-flex gap-2 align-items-end">
                                @csrf
                                <div class="flex-grow-1">
                                    <label class="small text-muted mb-1 d-block">
                                        <i class="ri-upload-2-line me-1"></i> Upload file soal susulan
                                    </label>
                                    <input type="file" name="soal" class="form-control form-control-sm" required
                                           accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar,.jpg,.jpeg,.png">
                                </div>
                                <button class="btn btn-sm btn-success fw-bold text-nowrap">
                                    <i class="ri-upload-2-line me-1"></i> Upload
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Jawaban masuk --}}
                    @forelse($exam->submissions as $sub)
                        <div class="bg-light rounded-3 p-2 mb-2">
                            <div class="d-flex justify-content-between small">
                                <strong>{{ $sub->student?->name ?? '(Mahasiswa terhapus)' }}</strong>
                                <span class="text-muted">{{ $sub->submitted_at?->format('d/m H:i') ?? '-' }}</span>
                            </div>

                            @if($sub->drive_link)
                                <a href="{{ $sub->drive_link }}" target="_blank" class="small d-inline-block mt-1 fw-bold text-primary">
                                    <i class="ri-google-drive-line me-1"></i>Buka Jawaban di Google Drive
                                </a>
                            @endif
                            @if($sub->answer)
                                <p class="small mb-1 mt-1">{{ \Illuminate\Support\Str::limit($sub->answer, 150) }}</p>
                            @endif
                            @if($sub->file_path)
                                <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="small"><i class="ri-attachment-2 me-1"></i>Lihat file jawaban</a>
                            @endif

                            <form method="POST" action="{{ route('elearning.staff.nilai.store', $sub->id) }}" class="row g-1 mt-1">
                                @csrf
                                <div class="col-3"><input type="number" name="score" min="0" max="100" class="form-control form-control-sm" placeholder="Nilai" value="{{ $sub->score }}" required></div>
                                <div class="col-6"><input type="text" name="feedback" class="form-control form-control-sm" placeholder="Feedback (opsional)" value="{{ $sub->feedback }}"></div>
                                <div class="col-3"><button class="btn btn-sm btn-primary w-100">Simpan Nilai</button></div>
                            </form>
                        </div>
                    @empty
                        <div class="text-muted small text-center py-2">Belum ada jawaban masuk.</div>
                    @endforelse
                </div>
            @empty
                <div class="text-muted small text-center py-3">Belum ada ujian untuk kelas ini.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection