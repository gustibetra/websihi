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
use App\Models\ElearningUser;
use App\Models\ElearningDocument;
use App\Models\ElearningJobApplication;
use App\Models\ElearningJobPosting;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    private function user()
    {
        return Auth::guard('elearning')->user();
    }

    private function requireStaffType(array $types)
    {
        if (!in_array($this->user()->staff_type, $types)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses fitur ini.');
        }
    }

    private function storeWithOriginalName($file, string $folder): string
    {
        $ext  = $file->getClientOriginalExtension() ?: $file->guessExtension();
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $base = preg_replace('/[^A-Za-z0-9\-_]+/', '-', $base);
        $base = trim($base, '-_');
        if ($base === '') {
            $base = 'file-' . now()->format('Ymd-His');
        }

        $name = $base . '.' . $ext;

        if (Storage::disk('public')->exists($folder . '/' . $name)) {
            $name = $base . '-' . now()->format('Ymd-His') . '.' . $ext;
        }

        return $file->storeAs($folder, $name, 'public');
    }

    // ═══════════════════════════════════════════════════════
    // DASHBOARD MURNI
    // ═══════════════════════════════════════════════════════
    public function dashboard()
    {
        $user = $this->user();
        $today = now()->toDateString();

        $absenHariIni = ElearningAttendance::where('user_id', $user->id)->where('date', $today)->first();

        $statsPengajar = [];
        if ($user->staff_type === 'pengajar') {
            $courseIds = ElearningCourse::where('owner_id', $user->id)->pluck('id');
            $statsPengajar = [
                'kelas'  => $courseIds->count(),
                'materi' => ElearningMaterial::whereIn('course_id', $courseIds)->count(),
                'ujian'  => ElearningExam::whereIn('course_id', $courseIds)->count(),
            ];
        }

        $statsAdminKeu = [];
        if (in_array($user->staff_type, ['administrasi', 'keuangan'])) {
            $statsAdminKeu = [
                'tunggakan'        => ElearningPayment::where('status', 'Tunggakan')->count(),
                'lunas'            => ElearningPayment::where('status', 'Lunas')->count(),
                'mahasiswa'        => ElearningUser::where('role', 'mahasiswa')->count(),
                'nominalTunggakan' => ElearningPayment::where('status', 'Tunggakan')->sum('amount'),
            ];
        }

        return view('elearning.staff.dashboard', compact('absenHariIni', 'statsPengajar', 'statsAdminKeu'));
    }

    // ═══════════════════════════════════════════════════════
    // RUANG ABSEN
    // ═══════════════════════════════════════════════════════
    public function absen()
    {
        $user = $this->user();
        $today = now()->toDateString();

        $absenHariIni = ElearningAttendance::where('user_id', $user->id)->where('date', $today)->first();
        $riwayat      = ElearningAttendance::where('user_id', $user->id)->orderByDesc('date')->take(30)->get();

        $absenMhs = Common::where('table_name', 'elearning_settings')
            ->where('key1', 'absen_mahasiswa')->first();
        $absenMahasiswaOpen = $absenMhs && $absenMhs->data1 === '1';

        return view('elearning.staff.absen', compact('absenHariIni', 'riwayat', 'absenMahasiswaOpen'));
    }

    public function storeAbsen(Request $request)
    {
        $user = $this->user();
        $today = now()->toDateString();

        $row = ElearningAttendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['status' => 'Hadir']
        );

        if ($request->type === 'in') {
            if ($row->check_in) return back()->with('error', 'Anda sudah check-in hari ini.');
            $row->check_in = now()->format('H:i');
            $row->status   = now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';
        } else {
            if (!$row->check_in) return back()->with('error', 'Lakukan check-in terlebih dahulu.');
            if ($row->check_out) return back()->with('error', 'Anda sudah check-out hari ini.');
            $row->check_out = now()->format('H:i');
        }

        $row->save();
        return back()->with('success', 'Absen berhasil tercatat.');
    }

    // ═══════════════════════════════════════════════════════
    // ✅ ABSEN MURNI SCAN KARTU FISIK SIHI (STAFF)
    // ═══════════════════════════════════════════════════════
    public function scanAbsen(Request $request)
    {
        $user = $this->user();
        $code = trim((string) $request->input('code'));

        if ($code === '') {
            return response()->json(['ok' => false, 'msg' => 'Scan tidak terbaca. Silakan ulangi.']);
        }

        // ✅ Cocokkan kode kartu dengan NIM/NIP akun yang login
        if (!$this->cardMatch($user, $code)) {
            return response()->json(['ok' => false,
                'msg' => 'Kartu tidak cocok dengan akun Anda (kode terbaca: ' . $code . '). Gunakan kartu Anda sendiri!']);
        }

        // ✅ OTOMATIS: belum in → check-in | sudah in & belum out → check-out
        $today = now()->toDateString();
        $row = ElearningAttendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['status' => 'Hadir']
        );

        if (!$row->check_in) {
            $row->check_in = now()->format('H:i');
            $row->status   = now()->format('H:i') > '08:00' ? 'Terlambat' : 'Hadir';
            $row->save();
            return response()->json(['ok' => true,
                'msg' => 'CHECK-IN tercatat ' . $row->check_in . ' — ' . $row->status, 'data' => $row]);
        }

        if (!$row->check_out) {
            $row->check_out = now()->format('H:i');
            $row->save();
            return response()->json(['ok' => true,
                'msg' => 'CHECK-OUT tercatat ' . $row->check_out . '. Selamat beristirahat!', 'data' => $row]);
        }

        return response()->json(['ok' => false, 'msg' => 'Absen hari ini sudah lengkap (check-in & check-out).']);
    }

    /** Cocokkan kode scan dengan NIM/NIP (toleran terhadap prefix kartu) */
    private function cardMatch($user, string $code): bool
    {
        $nim = trim((string) $user->nomor_induk);
        if ($nim === '') return false;

        $codeClean = preg_replace('/[^0-9A-Za-z]/', '', $code);
        $nimClean  = preg_replace('/[^0-9A-Za-z]/', '', $nim);

        return $codeClean === $nimClean || str_ends_with($codeClean, $nimClean);
    }

    public function toggleAbsenMahasiswa()
    {
        $this->requireStaffType(['pengajar']);

        $setting = Common::firstOrCreate(
            ['table_name' => 'elearning_settings', 'key1' => 'absen_mahasiswa'],
            ['data1' => '0']
        );

        $setting->data1 = $setting->data1 === '1' ? '0' : '1';
        $setting->save();

        return back()->with('success',
            $setting->data1 === '1'
                ? 'Absensi mahasiswa DIBUKA. Mahasiswa sekarang bisa check-in.'
                : 'Absensi mahasiswa ditutup. Mahasiswa tidak bisa check-in lagi.'
        );
    }

    public function absenMahasiswa()
    {
        $this->requireStaffType(['pengajar']);

        $today = now()->toDateString();
        $students = ElearningUser::where('role', 'mahasiswa')->orderBy('name')->get();
        $absenToday = ElearningAttendance::whereIn('user_id', $students->pluck('id'))
            ->where('date', $today)
            ->get()
            ->keyBy('user_id');

        $sudahAbsen = collect();
        $belumAbsen = collect();

        foreach ($students as $s) {
            if ($absenToday->has($s->id)) {
                $sudahAbsen->push((object) [
                    'student' => $s,
                    'absen'   => $absenToday->get($s->id),
                ]);
            } else {
                $belumAbsen->push($s);
            }
        }

        $sudahAbsen = $sudahAbsen->sortBy(fn($r) => $r->absen->check_in ?? '99:99')->values();
        $absenOpen = $this->absenOpenForStaff();

        return view('elearning.staff.absen-mahasiswa', compact('sudahAbsen', 'belumAbsen', 'absenOpen', 'today'));
    }

    private function absenOpenForStaff(): bool
    {
        $s = Common::where('table_name', 'elearning_settings')->where('key1', 'absen_mahasiswa')->first();
        return $s && $s->data1 === '1';
    }

    public function destroyAbsenMahasiswa($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $absen = ElearningAttendance::findOrFail($id);
            $owner = ElearningUser::find($absen->user_id);
            if (!$owner || $owner->role !== 'mahasiswa') {
                return back()->with('error', 'Absensi ini bukan milik mahasiswa.');
            }
            $nama    = $owner->name;
            $tanggal = $absen->date->format('d M Y');
            $absen->delete();
            return back()->with('success', 'Absensi ' . $nama . ' (' . $tanggal . ') berhasil dihapus. Mahasiswa kini berstatus BELUM ABSEN.');
        } catch (\Throwable $e) {
            Log::error('destroyAbsenMahasiswa error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus absensi: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════
    // RUANG PEMBAYARAN
    // ═══════════════════════════════════════════════════════
    public function pembayaran()
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $payments = ElearningPayment::with('student')->orderByDesc('created_at')->get();
        $students = ElearningUser::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('elearning.staff.pembayaran', compact('payments', 'students'));
    }

    public function storePembayaran(Request $request)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $request->validate([
            'student_id' => 'required|exists:elearning_users,id',
            'title'      => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
            'due_date'   => 'nullable|date',
        ]);
        ElearningPayment::create([
            'student_id' => $request->student_id,
            'title'      => $request->title,
            'amount'     => $request->amount,
            'due_date'   => $request->due_date,
            'status'     => 'Tunggakan',
        ]);
        return back()->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function markLunas($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        ElearningPayment::findOrFail($id)->update(['status' => 'Lunas', 'paid_at' => now()]);
        return back()->with('success', 'Pembayaran ditandai LUNAS.');
    }

    public function destroyPembayaran($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        try {
            $payment = ElearningPayment::findOrFail($id);
            $judul   = $payment->title;
            $payment->delete();
            return back()->with('success', 'Tagihan "' . $judul . '" berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('destroyPembayaran error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus tagihan: ' . $e->getMessage());
        }
    }

    public function destroyBukti($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        try {
            $payment = ElearningPayment::findOrFail($id);
            $payment->update([
                'payment_proof_link' => null, 'proof_type' => null,
                'proof_note' => null, 'proof_submitted_at' => null,
            ]);
            return back()->with('success', 'Bukti pembayaran dihapus. Mahasiswa dapat mengirim ulang.');
        } catch (\Throwable $e) {
            Log::error('destroyBukti error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus bukti: ' . $e->getMessage());
        }
    }

    // ═══ SLIP PEMBAYARAN ═══
    public function slipCreate()
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $students = ElearningUser::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('elearning.staff.slip-create', compact('students'));
    }

    public function slipStore(Request $request)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $request->validate([
            'manual_name' => 'required|string|max:255',
            'manual_nim'  => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'program'     => 'nullable|string|max:255',
        ], [
            'manual_name.required' => 'Nama pembayar wajib diisi.',
            'title.required'       => 'Judul tagihan wajib diisi.',
        ]);

        try {
            $details = []; $total = 0;
            foreach (($request->item_title ?? []) as $i => $t) {
                $amt = (float) ($request->item_amount[$i] ?? 0);
                if (trim((string) $t) === '' && $amt <= 0) continue;
                $details[] = ['title' => $t, 'amount' => $amt];
                $total += $amt;
            }

            if ($total <= 0) {
                return back()->withInput()->with('error', 'Total rincian biaya harus lebih dari Rp 0.');
            }

            $student = null;
            if ($request->filled('manual_nim')) {
                $student = ElearningUser::where('role', 'mahasiswa')
                    ->where('nomor_induk', trim($request->manual_nim))->first();
            }
            if (!$student) {
                $student = ElearningUser::where('role', 'mahasiswa')
                    ->whereRaw('LOWER(name) = ?', [strtolower(trim($request->manual_name))])->first();
            }

            $payment = ElearningPayment::create([
                'student_id'      => $student?->id,
                'manual_name'     => trim($request->manual_name),
                'manual_nim'      => trim($request->manual_nim),
                'title'           => $request->title,
                'program'         => $request->program ?: $student?->program,
                'amount'          => $total,
                'details'         => $details ?: null,
                'payment_channel' => $request->payment_channel,
                'due_date'        => $request->due_date,
                'status'          => $request->status ?? 'Lunas',
                'paid_at'         => ($request->status ?? 'Lunas') === 'Lunas' ? now() : null,
            ]);

            $payment->update([
                'slip_number' => 'SIHI/' . now()->format('Ymd') . '/' . str_pad($payment->id, 4, '0', STR_PAD_LEFT),
            ]);

            return redirect()->route('elearning.staff.pembayaran.slip', $payment->id)
                ->with('success', 'Slip pembayaran atas nama ' . $payment->display_name . ' berhasil dibuat.');
        } catch (\Throwable $e) {
            Log::error('slipStore error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan slip: ' . $e->getMessage());
        }
    }

    public function slipShow($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $payment = ElearningPayment::with('student')->findOrFail($id);
        return view('elearning.staff.slip', compact('payment'));
    }

    // ═══════════════════════════════════════════════════════
    // RUANG KELAS
    // ═══════════════════════════════════════════════════════
    public function kelas()
    {
        $this->requireStaffType(['pengajar']);
        $courses = ElearningCourse::withCount(['materials', 'exams'])
            ->where('owner_id', $this->user()->id)
            ->orderByDesc('created_at')->get();
        return view('elearning.staff.kelas', compact('courses'));
    }

    public function storeKelas(Request $request)
    {
        $this->requireStaffType(['pengajar']);
        $request->validate(['title' => 'required|string|max:255']);
        ElearningCourse::create([
            'title'       => $request->title,
            'program'     => $request->program,
            'description' => $request->description,
            'owner_id'    => $this->user()->id,
        ]);
        return back()->with('success', 'Kelas berhasil dibuat.');
    }

    public function kelasShow($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $course = ElearningCourse::with([
                'materials',
                'exams' => fn($q) => $q->orderBy('created_at', 'desc'),
                'exams.submissions' => fn($q) => $q->orderBy('submitted_at', 'desc'),
                'exams.submissions.student'
            ])->findOrFail($id);

            if ((int) $course->owner_id !== (int) $this->user()->id) abort(403, 'Anda tidak memiliki akses ke kelas ini.');
            return view('elearning.staff.kelas-show', compact('course'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('elearning.staff.kelas')->with('error', 'Kelas tidak ditemukan.');
        } catch (\Throwable $e) {
            Log::error('kelasShow error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat halaman: ' . $e->getMessage());
        }
    }

    public function destroyKelas($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $course = ElearningCourse::findOrFail($id);
            if ((int) $course->owner_id !== (int) $this->user()->id) return back()->with('error', 'Anda tidak memiliki izin menghapus kelas ini.');

            foreach ($course->materials as $materi) {
                if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) Storage::disk('public')->delete($materi->file_path);
            }
            foreach ($course->exams as $exam) {
                if ($exam->soal_path && Storage::disk('public')->exists($exam->soal_path)) Storage::disk('public')->delete($exam->soal_path);
            }
            $examIds = $course->exams()->pluck('id');
            if ($examIds->isNotEmpty()) ElearningExamSubmission::whereIn('exam_id', $examIds)->delete();

            $course->exams()->delete();
            $course->materials()->delete();
            $course->delete();
            return back()->with('success', 'Kelas "' . $course->title . '" beserta seluruh isinya berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }

    public function storeMateri(Request $request, $id)
    {
        $this->requireStaffType(['pengajar']);
        $course = ElearningCourse::findOrFail($id);
        if ((int) $course->owner_id !== (int) $this->user()->id) abort(403);
        $request->validate(['title' => 'required|string|max:255', 'file'  => 'required|file|max:10240']);
        ElearningMaterial::create([
            'course_id'   => $course->id, 'title' => $request->title,
            'description' => $request->description,
            'file_path'   => $this->storeWithOriginalName($request->file('file'), 'elearning/materi'),
        ]);
        return back()->with('success', 'Materi berhasil dikirim ke mahasiswa.');
    }

    public function destroyMateri($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $materi = ElearningMaterial::findOrFail($id);
            $course = ElearningCourse::findOrFail($materi->course_id);
            if ((int) $course->owner_id !== (int) $this->user()->id) return back()->with('error', 'Tidak punya izin.');
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) Storage::disk('public')->delete($materi->file_path);
            $materi->delete();
            return back()->with('success', 'Materi "' . $materi->title . '" berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus materi: ' . $e->getMessage());
        }
    }

    // ═══ RUANG BERKAS MAHASISWA ═══
    public function berkas()
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $documents = ElearningDocument::with('student')->orderByDesc('created_at')->get();
        return view('elearning.staff.berkas', compact('documents'));
    }

    public function reviewBerkas(Request $request, $id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $doc = ElearningDocument::findOrFail($id);
        $request->validate(['status' => 'required|in:Menunggu,Diverifikasi,Ditolak', 'feedback' => 'nullable|string|max:1000']);
        $doc->update(['status' => $request->status, 'feedback' => $request->feedback, 'reviewed_by' => $this->user()->id]);
        return back()->with('success', 'Status berkas "' . $doc->title . '" diperbarui.');
    }

    public function destroyBerkas($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        try {
            $doc = ElearningDocument::findOrFail($id);
            $doc->delete();
            return back()->with('success', 'Berkas "' . $doc->title . '" berhasil dihapus permanen.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus berkas: ' . $e->getMessage());
        }
    }

    // ═══ KELOLA LOKER ═══
    public function loker()
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $postings = ElearningJobPosting::orderByDesc('created_at')->get();
        return view('elearning.staff.loker', compact('postings'));
    }

    public function storeLoker(Request $request)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $request->validate([
            'company_name' => 'required|string|max:255', 'company_website' => 'nullable|url|max:255',
            'company_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', 'position' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:100', 'location' => 'nullable|string|max:255', 'description' => 'nullable|string|max:2000',
        ]);
        ElearningJobPosting::create([
            'company_name' => $request->company_name, 'company_website' => $request->company_website,
            'company_photo' => $request->hasFile('company_photo') ? $request->file('company_photo')->store('elearning/loker', 'public') : null,
            'position' => $request->position, 'employment_type' => $request->employment_type,
            'location' => $request->location, 'description' => $request->description, 'status' => 'open',
        ]);
        return back()->with('success', 'Loker "' . $request->position . '" berhasil dipublikasikan! 🎉');
    }

    public function updateLoker($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $posting = ElearningJobPosting::findOrFail($id);
        $posting->update(['status' => $posting->status === 'open' ? 'closed' : 'open']);
        return back()->with('success', 'Status loker "' . $posting->position . '" diperbarui.');
    }

    public function destroyLoker($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $posting = ElearningJobPosting::findOrFail($id);
        if ($posting->company_photo && Storage::disk('public')->exists($posting->company_photo)) Storage::disk('public')->delete($posting->company_photo);
        $posting->delete();
        return back()->with('success', 'Loker dihapus permanen.');
    }

    // ═══ RUANG BERKAS ALUMNI ═══
    public function berkasAlumni()
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $applications = ElearningJobApplication::orderByDesc('created_at')->get();
        return view('elearning.staff.berkas-alumni', compact('applications'));
    }

    public function reviewBerkasAlumni(Request $request, $id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $app = ElearningJobApplication::findOrFail($id);
        $request->validate(['status' => 'required|in:Baru,Diproses,Diterima,Ditolak']);
        $app->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran "' . $app->name . '" diperbarui.');
    }

    public function destroyBerkasAlumni($id)
    {
        $this->requireStaffType(['administrasi', 'keuangan']);
        $app = ElearningJobApplication::findOrFail($id);
        if ($app->cv_path && Storage::disk('public')->exists($app->cv_path)) Storage::disk('public')->delete($app->cv_path);
        $app->delete();
        return back()->with('success', 'Lamaran "' . $app->name . '" dihapus permanen.');
    }

    // ═══════════════════════════════════════════════════════
    // UJIAN & TUGAS
    // ═══════════════════════════════════════════════════════
    public function storeUjian(Request $request, $id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $course = ElearningCourse::findOrFail($id);
            if ((int) $course->owner_id !== (int) $this->user()->id) abort(403);
            $request->validate([
                'title' => 'required|string|max:255', 'type' => 'nullable|in:ujian,tugas',
                'soal' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240',
                'start_at' => 'nullable|date', 'end_at' => 'nullable|date|after:start_at',
            ]);
            ElearningExam::create([
                'course_id' => $course->id, 'title' => $request->title, 'type' => $request->input('type', 'ujian'),
                'instructions' => $request->instructions,
                'soal_path' => $request->hasFile('soal') ? $this->storeWithOriginalName($request->file('soal'), 'elearning/soal') : null,
                'start_at' => $request->start_at, 'end_at' => $request->end_at, 'is_open' => $request->boolean('is_open'),
            ]);
            return back()->with('success', ucfirst($request->input('type', 'ujian')) . ' berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal membuat ujian/tugas: ' . $e->getMessage());
        }
    }

    public function uploadSoal(Request $request, $id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $exam = ElearningExam::findOrFail($id);
            if ((int) $exam->course->owner_id !== (int) $this->user()->id) abort(403);
            $request->validate(['soal' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240']);
            if ($exam->soal_path && Storage::disk('public')->exists($exam->soal_path)) Storage::disk('public')->delete($exam->soal_path);
            $exam->update(['soal_path' => $this->storeWithOriginalName($request->file('soal'), 'elearning/soal')]);
            return back()->with('success', 'File soal berhasil diupload.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengupload soal: ' . $e->getMessage());
        }
    }

    public function destroySoal($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $exam = ElearningExam::findOrFail($id);
            if ((int) $exam->course->owner_id !== (int) $this->user()->id) abort(403);
            if ($exam->soal_path && Storage::disk('public')->exists($exam->soal_path)) Storage::disk('public')->delete($exam->soal_path);
            $exam->update(['soal_path' => null]);
            return back()->with('success', 'File soal berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus file soal: ' . $e->getMessage());
        }
    }

    public function toggleUjian($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $exam = ElearningExam::findOrFail($id);
            if ((int) $exam->course->owner_id !== (int) $this->user()->id) abort(403);
            $exam->update(['is_open' => !$exam->is_open]);
            return back()->with('success', $exam->is_open ? 'Ujian DIBUKA manual.' : 'Ujian ditutup.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengubah status ujian.');
        }
    }

    public function destroyUjian($id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $ujian = ElearningExam::findOrFail($id);
            if ((int) $ujian->course->owner_id !== (int) $this->user()->id) return back()->with('error', 'Tidak punya izin.');
            if ($ujian->soal_path && Storage::disk('public')->exists($ujian->soal_path)) Storage::disk('public')->delete($ujian->soal_path);
            $ujian->submissions()->delete();
            $ujian->delete();
            return back()->with('success', 'Ujian "' . $ujian->title . '" berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus ujian: ' . $e->getMessage());
        }
    }

    public function storeNilai(Request $request, $id)
    {
        $this->requireStaffType(['pengajar']);
        try {
            $submission = ElearningExamSubmission::with('exam.course')->findOrFail($id);
            if ((int) $submission->exam->course->owner_id !== (int) $this->user()->id) abort(403);
            $request->validate(['score' => 'required|integer|min:0|max:100', 'feedback' => 'nullable|string|max:1000']);
            $submission->update(['score' => $request->score, 'feedback' => $request->feedback ?? '']);
            return back()->with('success', 'Nilai berhasil disimpan.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyimpan nilai: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════
    // ✅ DIREKTUR LEMBAGA: MONITOR ABSENSI STAFF
    // ═══════════════════════════════════════════════════════
    public function monitorAbsensi(Request $request)
    {
        $this->requireStaffType(['direktur']);
        $date  = $request->query('date') ?: now()->toDateString();
        $users = ElearningUser::where('role', 'staff')->where('is_active', true)->orderBy('staff_type')->orderBy('name')->get();
        $attendances = ElearningAttendance::where('date', $date)->whereIn('user_id', $users->pluck('id'))->get()->keyBy('user_id');
        $hadir = 0; $telat = 0; $belum = 0;
        foreach ($users as $u) {
            $a = $attendances->get($u->id);
            if ($a) { $a->status === 'Terlambat' ? $telat++ : $hadir++; } else { $belum++; }
        }
        return view('elearning.staff.monitor-absensi', compact('users', 'attendances', 'date', 'hadir', 'telat', 'belum'));
    }

    public function destroyAbsensiStaff($id)
    {
        $this->requireStaffType(['direktur']);
        try {
            $absen = ElearningAttendance::findOrFail($id);
            $owner = ElearningUser::find($absen->user_id);
            if (!$owner || $owner->role !== 'staff') return back()->with('error', 'Hanya absensi staff yang dapat dikoreksi.');
            $absen->delete();
            return back()->with('success', 'Catatan absen ' . $owner->name . ' berhasil dikoreksi (dihapus).');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus catatan absen: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════
    // ✅ WAKIL DIREKTUR: DATA PENDAFTAR
    // ═══════════════════════════════════════════════════════
    public function pendaftar()
    {
        $this->requireStaffType(['wakil_direktur']);
        $pendaftar = Registration::orderByDesc('created_at')->get();
        return view('elearning.staff.pendaftar', compact('pendaftar'));
    }

    public function updateStatusPendaftar(Request $request, $id)
    {
        $this->requireStaffType(['wakil_direktur']);
        $r = Registration::findOrFail($id);
        $request->validate(['status' => 'required|in:Baru,Diproses,Diterima,Ditolak']);
        $r->update(['status' => $request->status]);
        return back()->with('success', 'Status pendaftar "' . $r->nama_lengkap . '" diperbarui menjadi ' . $request->status . '.');
    }

    public function destroyPendaftar($id)
    {
        $this->requireStaffType(['wakil_direktur']);
        try {
            $r = Registration::findOrFail($id);
            $r->delete();
            return back()->with('success', 'Data pendaftar "' . $r->nama_lengkap . '" dihapus permanen.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus data pendaftar: ' . $e->getMessage());
        }
    }

    public function exportPendaftar()
    {
        $this->requireStaffType(['wakil_direktur']);
        $rows = Registration::orderByDesc('created_at')->get();
        $csv = "Nama,Email,WhatsApp,Asal Sekolah,Program,Tahun Lulus,Status,Tanggal\n";
        foreach ($rows as $r) {
            $csv .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v ?? '') . '"', [
                $r->nama_lengkap, $r->email, $r->no_whatsapp, $r->asal_sekolah,
                $r->program, $r->tahun_lulus, $r->status ?? 'Baru', $r->created_at?->format('d/m/Y'),
            ])) . "\n";
        }
        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-pendaftar-' . now()->format('Ymd') . '.csv"',
        ]);
    }
}