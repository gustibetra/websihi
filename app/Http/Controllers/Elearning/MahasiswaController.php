<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\ElearningAttendance;
use App\Models\ElearningCourse;
use App\Models\ElearningExam;
use App\Models\ElearningExamSubmission;
use App\Models\ElearningMaterial;
use App\Models\ElearningPayment;
use App\Models\ElearningDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    private function user() { return Auth::guard('elearning')->user(); }

    private function coursesQuery()
    {
        $user = $this->user();
        return ElearningCourse::where('is_active', true)
            ->where(fn($q) => $q->whereNull('program')->orWhere('program', $user->program));
    }

    private function absenOpen(): bool
    {
        $s = Common::where('table_name', 'elearning_settings')->where('key1', 'absen_mahasiswa')->first();
        return $s && $s->data1 === '1';
    }

    // ═══════════════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════════════
    public function dashboard()
    {
        $user = $this->user();
        $courseIds = $this->coursesQuery()->pluck('id');

        $absenHariIni = ElearningAttendance::where('user_id', $user->id)->where('date', now()->toDateString())->first();
        $materiCount  = ElearningMaterial::whereIn('course_id', $courseIds)->count();
        $kelasCount   = $courseIds->count();
        $tunggakan    = ElearningPayment::where('student_id', $user->id)->where('status', 'Tunggakan')->count();
        $absenOpen    = $this->absenOpen();

        $sudahSubmit = ElearningExamSubmission::where('student_id', $user->id)->pluck('exam_id');
        $openExams = ElearningExam::whereIn('course_id', $courseIds)->with('course')->get()
            ->filter(fn($e) => $e->isOpen() && !$sudahSubmit->contains($e->id));

        return view('elearning.mahasiswa.dashboard', compact('absenHariIni', 'materiCount', 'kelasCount', 'tunggakan', 'absenOpen', 'openExams'));
    }

    // ═══════════════════════════════════════════════════════
    // RUANG ABSENSI
    // ═══════════════════════════════════════════════════════
    public function absen()
    {
        $user = $this->user();
        $absenHariIni = ElearningAttendance::where('user_id', $user->id)
            ->where('date', now()->toDateString())->first();
        $riwayat = ElearningAttendance::where('user_id', $user->id)
            ->orderByDesc('date')->take(30)->get();
        $absenOpen = $this->absenOpen();

        return view('elearning.mahasiswa.absen', compact('absenHariIni', 'riwayat', 'absenOpen'));
    }

    public function storeAbsen(Request $request)
    {
        if (!$this->absenOpen()) return back()->with('error', 'Absensi belum dibuka oleh staff pengajar.');

        $row = ElearningAttendance::firstOrCreate(
            ['user_id' => $this->user()->id, 'date' => now()->toDateString()],
            ['status' => 'Hadir']
        );

        if ($row->check_in) return back()->with('error', 'Anda sudah check-in hari ini.');

        $row->check_in = now()->format('H:i');
        $row->status = now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';
        $row->save();

        return back()->with('success', 'Check-in berhasil! Kehadiran Anda tercatat. Selamat belajar! 🎉');
    }

    // ═══════════════════════════════════════════════════════
    // ✅ ABSEN MURNI SCAN KTM FISIK (MAHASISWA)
    // ═══════════════════════════════════════════════════════
    public function scanAbsen(Request $request)
    {
        $user = $this->user();
        $code = trim((string) $request->input('code'));

        // Cek absensi mahasiswa sedang dibuka oleh pengajar
        if (!$this->absenOpen()) {
            return response()->json(['ok' => false, 'msg' => 'Absensi mahasiswa saat ini DITUTUP.']);
        }

        if ($code === '') {
            return response()->json(['ok' => false, 'msg' => 'Scan tidak terbaca. Silakan ulangi.']);
        }

        // ✅ Cocokkan KTM dengan NIM akun login (contoh NIM: 2623033)
        $nim = trim((string) $user->nomor_induk);
        $codeClean = preg_replace('/[^0-9A-Za-z]/', '', $code);
        $nimClean  = preg_replace('/[^0-9A-Za-z]/', '', $nim);

        if ($nimClean === '' || ($codeClean !== $nimClean && !str_ends_with($codeClean, $nimClean))) {
            return response()->json(['ok' => false,
                'msg' => 'KTM tidak cocok dengan akun Anda (kode terbaca: ' . $code . '). Gunakan KTM Anda sendiri!']);
        }

        // ✅ OTOMATIS in / out
        $today = now()->toDateString();
        $row = ElearningAttendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['status' => 'Hadir']
        );

        if (!$row->check_in) {
            $row->check_in = now()->format('H:i');
            $row->status   = now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';
            $row->save();
            return response()->json(['ok' => true, 'msg' => 'CHECK-IN tercatat ' . $row->check_in . ' — ' . $row->status, 'data' => $row]);
        }

        if (!$row->check_out) {
            $row->check_out = now()->format('H:i');
            $row->save();
            return response()->json(['ok' => true, 'msg' => 'CHECK-OUT tercatat ' . $row->check_out . '.', 'data' => $row]);
        }

        return response()->json(['ok' => false, 'msg' => 'Absen hari ini sudah lengkap (check-in & check-out).']);
    }

    // ═══════════════════════════════════════════════════════
    // RUANG MATERI
    // ═══════════════════════════════════════════════════════
    public function materi()
    {
        $courses = $this->coursesQuery()->with('materials')->get();
        return view('elearning.mahasiswa.materi', compact('courses'));
    }

    // ═══ RUANG BERKAS ═══
    public function berkas()
    {
        $documents = ElearningDocument::where('student_id', $this->user()->id)
            ->orderByDesc('created_at')->get();

        return view('elearning.mahasiswa.berkas', compact('documents'));
    }

    public function storeBerkas(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'drive_link' => 'required|url',
            'notes'      => 'nullable|string|max:1000',
        ], [
            'drive_link.required' => 'Link Google Drive wajib diisi.',
            'drive_link.url'      => 'Format link tidak valid. Pastikan diawali https://',
        ]);

        ElearningDocument::create([
            'student_id'   => $this->user()->id,
            'title'        => $request->title,
            'category'     => $request->category,
            'drive_link'   => $request->drive_link,
            'notes'        => $request->notes,
            'status'       => 'Menunggu',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Berkas berhasil dikirim ke staff Administrasi & Keuangan. 📨');
    }

    public function destroyBerkas($id)
    {
        $doc = ElearningDocument::where('student_id', $this->user()->id)->findOrFail($id);
        $doc->delete();

        return back()->with('success', 'Berkas "' . $doc->title . '" dihapus.');
    }

    // ═══════════════════════════════════════════════════════
    // RUANG KELAS (ujian & tugas)
    // ═══════════════════════════════════════════════════════
    public function kelas()
    {
        $courses = $this->coursesQuery()->withCount('exams')->get();
        return view('elearning.mahasiswa.kelas', compact('courses'));
    }

    public function kelasShow($id)
    {
        try {
            $course = ElearningCourse::with('exams')->findOrFail($id);

            $mySubmissions = ElearningExamSubmission::where('student_id', $this->user()->id)
                ->get()
                ->keyBy('exam_id');

            return view('elearning.mahasiswa.kelas-show', compact('course', 'mySubmissions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('elearning.mahasiswa.kelas')
                ->with('error', 'Kelas tidak ditemukan.');
        } catch (\Throwable $e) {
            Log::error('mahasiswa.kelasShow error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat halaman kelas: ' . $e->getMessage());
        }
    }

    public function submitUjian(Request $request, $id)
    {
        try {
            $exam = ElearningExam::findOrFail($id);
            $user = $this->user();

            if (!$exam->isOpen()) {
                return back()->with('error', 'Ujian/tugas belum dibuka atau sudah ditutup.');
            }

            if (ElearningExamSubmission::where('exam_id', $id)->where('student_id', $user->id)->exists()) {
                return back()->with('error', 'Anda sudah mengumpulkan jawaban untuk ujian/tugas ini.');
            }

            $request->validate([
                'drive_link' => 'required|url',
            ], [
                'drive_link.required' => 'Link Google Drive wajib diisi.',
                'drive_link.url'      => 'Format link tidak valid. Pastikan diawali https://',
            ]);

            ElearningExamSubmission::create([
                'exam_id'      => $id,
                'student_id'   => $user->id,
                'drive_link'   => $request->drive_link,
                'submitted_at' => now(),
            ]);

            return back()->with('success', 'Jawaban/tugas berhasil dikumpulkan! Semoga mendapat nilai terbaik. 🎉');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Ujian/tugas tidak ditemukan.');
        } catch (\Throwable $e) {
            Log::error('submitUjian error: ' . $e->getMessage() . ' | Student: ' . ($this->user()->id ?? '?'));
            return back()->with('error', 'Gagal mengumpulkan jawaban: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════
    // PEMBAYARAN
    // ═══════════════════════════════════════════════════════
    public function pembayaran()
    {
        $payments = ElearningPayment::where('student_id', $this->user()->id)->orderByDesc('created_at')->get();
        return view('elearning.mahasiswa.pembayaran', compact('payments'));
    }

    // ═══ KIRIM BUKTI PEMBAYARAN (via Google Drive) ═══
    public function submitBukti(Request $request, $id)
    {
        $user    = $this->user();
        $payment = ElearningPayment::where('student_id', $user->id)->findOrFail($id);

        $request->validate([
            'payment_proof_link' => 'required|url',
            'proof_type'         => 'required|in:Lunas,Cicilan',
            'proof_note'         => 'nullable|string|max:1000',
        ], [
            'payment_proof_link.required' => 'Link Google Drive wajib diisi.',
            'payment_proof_link.url'      => 'Format link tidak valid. Pastikan diawali https://',
        ]);

        $payment->update([
            'payment_proof_link' => $request->payment_proof_link,
            'proof_type'         => $request->proof_type,
            'proof_note'         => $request->proof_note,
            'proof_submitted_at' => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim! Staff keuangan akan memverifikasinya. ✅');
    }
}