@extends('layouts.elearning')
@section('title', 'Kelas: ' . $course->title)
@section('content')

<style>
    .exm-card{border:none;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.07);overflow:hidden;}
    .exm-head{padding:18px 24px;color:#fff;}
    .exm-head.ujian{background:linear-gradient(135deg,#1F57ED,#7A5CF0);}
    .exm-head.tugas{background:linear-gradient(135deg,#EA580C,#F59E0B);}
    .exm-drive{border:2px dashed #C7D2FE;border-radius:14px;background:#F8FAFF;padding:16px;}
    /* ✅ BARU: style untuk kotak download soal */
    .exm-soal{
        border:2px dashed #637FEA;
        border-radius:14px;
        background:linear-gradient(135deg,#EEF2FF 0%,#F5F3FF 100%);
        padding:14px 16px;
        margin-bottom:14px;
    }
    .exm-soal:hover{background:linear-gradient(135deg,#E0E7FF 0%,#EDE9FE 100%);transition:.3s;}
</style>

{{-- ✅ BARU: Alert Success / Error --}}
@if(session('success'))
    <div class="alert alert-success py-2 small mb-3" style="border-radius:12px;">
        <i class="ri-checkbox-circle-line me-1"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger py-2 small mb-3" style="border-radius:12px;">
        <i class="ri-error-warning-line me-1"></i>{{ session('error') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger py-2 small mb-3" style="border-radius:12px;">
        <i class="ri-error-warning-line me-1"></i>{{ $errors->first() }}
    </div>
@endif

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ri-book-2-line text-primary"></i> {{ $course->title }}</h4>
        <p class="text-muted small mb-0">{{ $course->program ?? 'Semua Program' }} • {{ $course->description }}</p>
    </div>
    <a href="{{ route('elearning.mahasiswa.kelas') }}" class="btn btn-sm btn-light"><i class="ri-arrow-left-line me-1"></i> Kembali</a>
</div>

<div class="row g-4">
    @forelse($course->exams as $exam)
        @php
            $my = $mySubmissions->get($exam->id);
            $tipe = $exam->type ?? 'ujian';
        @endphp
        <div class="col-lg-6">
            <div class="exm-card card h-100">
                {{-- Header Kartu --}}
                <div class="exm-head {{ $tipe === 'tugas' ? 'tugas' : 'ujian' }} d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-white bg-opacity-25 mb-1">
                            <i class="{{ $tipe === 'tugas' ? 'ri-file-list-3-line' : 'ri-edit-2-line' }} me-1"></i>
                            {{ ucfirst($tipe) }}
                        </span>
                        <h6 class="fw-bold mb-0">{{ $exam->title }}</h6>
                    </div>
                    <span class="badge {{ $exam->isOpen() ? 'bg-success' : 'bg-dark bg-opacity-25' }}">
                        {{ $exam->isOpen() ? '● DIBUKA' : '○ TERTUTUP' }}
                    </span>
                </div>

                {{-- Body Kartu --}}
                <div class="card-body p-4">

                    {{-- ✅ PERBAIKAN: Null-safe untuk tanggal (mencegah Error 500) --}}
                    <div class="small text-muted mb-2">
                        <i class="ri-time-line me-1"></i>
                        {{ $exam->start_at?->format('d/m/Y H:i') ?? 'Belum diatur' }}
                        —
                        {{ $exam->end_at?->format('d/m/Y H:i') ?? 'Belum diatur' }}
                    </div>

                    @if($exam->instructions)
                        <div class="p-3 rounded-3 mb-3 small" style="background:#F8FAFC;">
                            <i class="ri-information-line text-primary me-1"></i>{{ $exam->instructions }}
                        </div>
                    @endif

                    {{-- ✅ BARU: Tombol Download Soal (muncul jika staff upload file soal) --}}
                    @if($exam->soal_path)
                        <div class="exm-soal d-flex align-items-center justify-content-between gap-2">
                            <div style="min-width:0;" class="flex-grow-1">
                                <strong class="small d-block text-truncate" style="color:#4338CA;">
                                    <i class="ri-file-paper-2-line me-1"></i>
                                    Soal {{ ucfirst($tipe) }} Tersedia
                                </strong>
                                <small class="text-muted">Unduh soal terlebih dahulu, lalu kerjakan sesuai instruksi.</small>
                            </div>
                            <a href="{{ asset('storage/' . $exam->soal_path) }}" target="_blank"
                               class="btn btn-sm btn-primary fw-bold text-nowrap">
                                <i class="ri-download-2-line me-1"></i> Download
                            </a>
                        </div>
                    @endif

                    {{-- Kondisi Tampilan Berdasarkan Status Submission --}}
                    @if($my)
                        {{-- ✅ SUDAH MENGUMPULKAN --}}
                        <div class="p-3 rounded-3 text-center" style="background:#ECFDF5;">
                            <i class="ri-checkbox-circle-fill" style="font-size:40px;color:#059669;"></i>
                            <div class="fw-bold text-success mt-2">Jawaban Terkirim!</div>
                            <small class="text-muted">{{ $my->submitted_at?->format('d M Y, H:i') ?? '-' }}</small>
                            @if($my->drive_link)
                                <div class="mt-2">
                                    <a href="{{ $my->drive_link }}" target="_blank" class="btn btn-sm btn-light">
                                        <i class="ri-google-drive-line me-1"></i>Lihat Link Saya
                                    </a>
                                </div>
                            @endif
                            @if($my->score !== null)
                                <div class="mt-3 p-2 rounded-3 bg-white">
                                    <div class="small text-muted">Nilai Anda</div>
                                    <div class="fw-bold fs-4 text-primary">{{ $my->score }}</div>
                                    @if($my->feedback)<small class="text-muted fst-italic">"{{ $my->feedback }}"</small>@endif
                                </div>
                            @else
                                <small class="text-muted d-block mt-2">Menunggu penilaian pengajar ⏳</small>
                            @endif
                        </div>

                    @elseif($exam->isOpen())
                        {{-- ✅ FORM SUBMIT DRIVE --}}
                        <form method="POST" action="{{ route('elearning.mahasiswa.ujian.submit', $exam->id) }}">
                            @csrf
                            <div class="exm-drive mb-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ri-google-drive-line" style="font-size:22px;color:#1F57ED;"></i>
                                    <strong class="small">Kumpulkan via Google Drive</strong>
                                </div>
                                <ol class="small text-muted ps-3 mb-2">
                                    <li>Upload jawaban/tugas ke Google Drive Anda</li>
                                    <li>Atur akses: <em>"Anyone with the link"</em></li>
                                    <li>Paste link di bawah ini</li>
                                </ol>
                                <input type="url" name="drive_link" class="form-control form-control-sm"
                                       placeholder="https://drive.google.com/..." required
                                       value="{{ old('drive_link') }}">
                            </div>
                            <button class="btn btn-sm btn-primary w-100 fw-bold"
                                    onclick="return confirm('Kumpulkan jawaban? Setelah dikirim tidak bisa diubah.')">
                                <i class="ri-send-plane-line me-1"></i> Kumpulkan Jawaban
                            </button>
                        </form>

                    @else
                        {{-- BELUM DIBUKA / SUDAH DITUTUP --}}
                        <div class="text-center p-4 rounded-3" style="background:#F8FAFC;">
                            <i class="ri-lock-2-line" style="font-size:36px;color:#94A3B8;"></i>
                            <div class="small text-muted mt-2">Belum dibuka / sudah ditutup. Perhatikan jadwal di atas.</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card p-5 text-center text-muted" style="border:none;border-radius:20px;">
                <i class="ri-edit-2-line d-block mb-2" style="font-size:44px;opacity:.3;"></i>
                Belum ada ujian atau tugas untuk kelas ini.
            </div>
        </div>
    @endforelse
</div>
@endsection