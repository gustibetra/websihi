<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElearningAttendance;
use App\Models\ElearningUser;
use App\Services\SimpleXlsxReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ElearningUserController extends Controller
{
    public function index()
    {
        $users = ElearningUser::orderBy('role')->orderBy('name')->get();

        $stats = [
            'staff'     => $users->where('role', 'staff')->count(),
            'mahasiswa' => $users->where('role', 'mahasiswa')->count(),
            'aktif'     => $users->where('is_active', true)->count(),
            'nonaktif'  => $users->where('is_active', false)->count(),
        ];

        return view('admin.elearning.users', compact('users', 'stats'));
    }

    // ═══════════════════════════════════════════════════════
    // ✅ STORE: Buat akun manual
    // ═══════════════════════════════════════════════════════
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:elearning_users,email',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:staff,mahasiswa',
            'staff_type' => 'nullable|in:pengajar,administrasi,keuangan,direktur,wakil_direktur',
        ], [
            'email.unique' => 'Email sudah terdaftar. Gunakan email lain.',
        ]);

        try {
            ElearningUser::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'role'        => $request->role,
                'staff_type'  => $request->role === 'staff' ? ($request->staff_type ?: 'pengajar') : null,
                'nomor_induk' => $request->nomor_induk,
                'program'     => $request->role === 'mahasiswa' ? $request->program : null,
                'is_active'   => true,
            ]);

            return back()->with('success', 'Akun "' . $request->name . '" berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat akun: ' . $e->getMessage())->withInput();
        }
    }

    // ═══════════════════════════════════════════════════════
    // ✅ UPDATE: Edit akun
    // ═══════════════════════════════════════════════════════
    public function update(Request $request, $id)
    {
        $user = ElearningUser::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('elearning_users', 'email')->ignore($user->id)],
            'role'       => 'required|in:staff,mahasiswa',
            'password'   => 'nullable|string|min:6',
            'staff_type' => 'nullable|in:pengajar,administrasi,keuangan,direktur,wakil_direktur',
        ]);

        try {
            $data = [
                'name'        => $request->name,
                'email'       => $request->email,
                'role'        => $request->role,
                'staff_type'  => $request->role === 'staff' ? ($request->staff_type ?: 'pengajar') : null,
                'nomor_induk' => $request->nomor_induk,
                'program'     => $request->role === 'mahasiswa' ? $request->program : null,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            return back()->with('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    public function toggle($id)
    {
        $user = ElearningUser::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status akun diubah menjadi ' . ($user->is_active ? 'AKTIF' : 'NONAKTIF') . '.');
    }

    public function destroy($id)
    {
        ElearningUser::findOrFail($id)->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }

    // ═══════════════════════════════════════════════════════
    // ✅ IMPORT EXCEL / CSV → AKUN MAHASISWA OTOMATIS
    // ═══════════════════════════════════════════════════════
    public function import(Request $request)
    {
        // ✅ Validasi TANPA mimes (CSV Indonesia sering terdeteksi text/plain)
        $request->validate([
            'file' => 'required|file|max:10240',
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.file'     => 'File tidak valid.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        $file = $request->file('file');
        $ext  = strtolower($file->getClientOriginalExtension());

        // Cek ekstensi (bukan MIME type)
        if (!in_array($ext, ['xlsx', 'csv', 'xls'])) {
            return back()->with('error',
                'Format tidak didukung: <strong>.' . ($ext ?: '(tanpa ekstensi)') . '</strong>. Gunakan file <code>.xlsx</code> atau <code>.csv</code>.');
        }

        if ($ext === 'xls') {
            return back()->with('error',
                '⚠️ File .xls (Excel 97-2003) tidak didukung. Buka di Excel → File → Save As → pilih <strong>"CSV UTF-8"</strong> → upload ulang.');
        }

        if ($ext === 'xlsx' && !class_exists(\ZipArchive::class)) {
            return back()->with('error',
                '⚠️ Server belum mendukung .xlsx. Buka di Excel → File → Save As → pilih <strong>"CSV UTF-8"</strong> → upload ulang.');
        }

        // ── Baca file ──
        try {
            $rows = ($ext === 'csv')
                ? $this->readCsv($file)
                : SimpleXlsxReader::read($file->getRealPath());
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }

        if (count($rows) === 0) {
            return back()->with('error', 'File kosong. Pastikan ada baris data.');
        }

        // ── Deteksi kolom dari header (fleksibel) ──
        $header = array_map(fn($h) => strtolower(trim((string) $h)), $rows[0]);

        $find = function (array $keys) use ($header) {
            // 1) Exact match
            foreach ($keys as $k) {
                $i = array_search($k, $header);
                if ($i !== false) return $i;
            }
            // 2) Contains match
            foreach ($keys as $k) {
                foreach ($header as $i => $h) {
                    if ($h !== '' && str_contains($h, $k)) return $i;
                }
            }
            return null;
        };

        $iNama  = $find(['nama lengkap', 'nama', 'name']);
        $iNim   = $find(['nim', 'nomor induk', 'nip', 'no induk']);
        $iEmail = $find(['email', 'e-mail', 'surat elektronik']);
        $iProg  = $find(['program', 'jurusan', 'prodi', 'program studi']);
        $iPass  = $find(['password', 'pass', 'sandi', 'kata sandi']);

        // Jika tidak ada header sama sekali → fallback urutan kolom
        $hasHeader = ($iNama !== null) || ($iNim !== null);
        if (!$hasHeader) {
            // Default: NIM, Nama, Password
            $iNim = 0; $iNama = 1; $iEmail = 2; $iProg = 3; $iPass = 4;
        }

        $dataRows = $hasHeader ? array_slice($rows, 1) : $rows;

        $created = 0;
        $skipped = 0;
        $errors  = [];

        foreach ($dataRows as $idx => $r) {
            // Ambil nilai (aman walau kolom tidak ada)
            $nama    = trim((string) ($r[$iNama]  ?? ''));
            $nim     = trim((string) ($r[$iNim]   ?? ''));
            $email   = trim((string) ($r[$iEmail] ?? ''));
            $program = trim((string) ($r[$iProg]  ?? ''));
            $pass    = trim((string) ($r[$iPass]  ?? ''));

            // ✅ Lewati baris kosong (seperti ";;" di file Anda)
            if ($nama === '' && $nim === '') {
                $skipped++;
                continue;
            }

            // Nama wajib
            if ($nama === '') {
                $skipped++;
                continue;
            }

            // Email kosong → otomatis dari NIM atau index
            if ($email === '') {
                $prefix = $nim ?: 'mhs' . now()->format('YmdHis') . ($idx + 1);
                $email  = $prefix . '@student.sihi.ac.id';
            }

            // Password kosong → default
            if ($pass === '') {
                $pass = 'sihi1234';
            }

            // ✅ Cek duplikat (email ATAU NIM sudah ada)
            $dupQuery = ElearningUser::where('email', $email);
            if ($nim !== '') {
                $dupQuery->orWhere('nomor_induk', $nim);
            }
            if ($dupQuery->exists()) {
                $skipped++;
                continue;
            }

            try {
                ElearningUser::create([
                    'name'        => $nama,
                    'email'       => $email,
                    'password'    => Hash::make($pass),
                    'role'        => 'mahasiswa',
                    'staff_type'  => null,
                    'nomor_induk' => $nim !== '' ? $nim : null,
                    'program'     => $program !== '' ? $program : null,
                    'is_active'   => true,
                ]);
                $created++;
            } catch (\Throwable $e) {
                $errors[] = "Baris " . ($idx + 2) . " ($nama): " . $e->getMessage();
            }
        }

        // Pesan sukses informatif (support HTML)
        $pesan = "✅ Import selesai: <strong>{$created}</strong> akun mahasiswa berhasil dibuat, <strong>{$skipped}</strong> baris dilewati (duplikat/kosong). Password default: <code>sihi1234</code>";
        if (!empty($errors)) {
            $pesan .= '<br><small class="text-warning">⚠️ ' . count($errors) . ' baris gagal: ' . implode(' | ', array_slice($errors, 0, 3)) . '</small>';
        }

        return back()->with('success', $pesan);
    }

    // ═══════════════════════════════════════════════════════
    // ✅ READ CSV: Deteksi pemisah otomatis ( ; , \t )
    // ═══════════════════════════════════════════════════════
    /**
     * Membaca file CSV dengan deteksi pemisah otomatis.
     * Mendukung CSV dari Excel Indonesia (pakai ;) maupun CSV standar (,).
     */
    private function readCsv($file): array
    {
        $path = $file->getRealPath();

        // ── Deteksi pemisah dari baris pertama yang berisi ──
        $delim = ',';
        $h = @fopen($path, 'r');
        if ($h) {
            while (($line = fgets($h)) !== false) {
                $line = trim($line);
                if ($line === '') continue;
                $counts = [
                    ';'  => substr_count($line, ';'),
                    ','  => substr_count($line, ','),
                    "\t" => substr_count($line, "\t"),
                ];
                arsort($counts);
                $best = array_key_first($counts);
                if ($counts[$best] > 0) {
                    $delim = $best;
                }
                break;
            }
            fclose($h);
        }

        // ── Baca semua baris ──
        $rows = [];
        $h = @fopen($path, 'r');
        if ($h) {
            while (($line = fgetcsv($h, 0, $delim)) !== false) {
                // Skip jika line === [null] atau ['']
                if ($line === [null] || $line === ['']) continue;
                // Skip jika SEMUA kolom kosong (baris seperti ";;;")
                $allEmpty = true;
                foreach ($line as $cell) {
                    if (trim((string) $cell) !== '') {
                        $allEmpty = false;
                        break;
                    }
                }
                if ($allEmpty) continue;
                $rows[] = $line;
            }
            fclose($h);
        }

        // ── Hapus BOM UTF-8 di sel pertama (jika ada) ──
        if (!empty($rows)) {
            $rows[0][0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) ($rows[0][0] ?? ''));
        }

        return $rows;
    }

    // ═══════════════════════════════════════════════════════
    // ✅ TEMPLATE CSV: Download contoh file
    // ═══════════════════════════════════════════════════════
    public function template()
    {
        $csv = "NIM,NAMA,PASSWORD\n"
             . "2306700001,Budi Santoso,sihi1234\n"
             . "2306700002,Siti Aminah,sihi1235\n";

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template-import-mahasiswa.csv"',
        ]);
    }

    // ═══════════════════════════════════════════════════════
    // MONITOR ABSENSI — KHUSUS STAFF SAJA
    // ═══════════════════════════════════════════════════════
    public function absensi(Request $request)
    {
        $date = $request->query('date') ?: now()->toDateString();

        $users = ElearningUser::where('role', 'staff')
            ->where('is_active', true)
            ->orderBy('staff_type')
            ->orderBy('name')
            ->get();

        $staffIds    = $users->pluck('id');
        $attendances = ElearningAttendance::where('date', $date)
            ->whereIn('user_id', $staffIds)
            ->get()
            ->keyBy('user_id');

        $hadir = 0; $telat = 0; $belum = 0;
        foreach ($users as $u) {
            $a = $attendances->get($u->id);
            if ($a) {
                $a->status === 'Terlambat' ? $telat++ : $hadir++;
            } else {
                $belum++;
            }
        }

        return view('admin.elearning.absensi', compact('users', 'attendances', 'date', 'hadir', 'telat', 'belum'));
    }

    public function destroyAbsensi($id)
    {
        $absen = ElearningAttendance::findOrFail($id);

        $user = ElearningUser::find($absen->user_id);
        if (!$user || $user->role !== 'staff') {
            return back()->with('error', 'Tidak dapat menghapus absensi mahasiswa dari panel ini.');
        }

        $nama = $user->name ?? 'Unknown';
        $absen->delete();

        return back()->with('success', 'Catatan absen ' . $nama . ' berhasil dihapus (koreksi).');
    }
}