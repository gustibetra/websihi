<?php

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    NewsController,
    TeacherController,
    EventController,
    AnnouncementController,
    GalleryController,
    PageController,
    SettingController,
    SecurityController,
    CommonController,
    CommonDataController,
    UserController,
    SystemSettingController
};

// Public Site Routes
Route::prefix('site')->name('site.')->group(function () {
    Route::get('/', function () { return view('site.home'); })->name('home');
    Route::get('/members', function () { return view('site.members.index'); })->name('members.index');
    Route::get('/fractions', function () { return view('site.fractions.index'); })->name('fractions.index');
    Route::get('/news', function () { return view('site.news.index'); })->name('news.index');
    Route::get('/agendas', function () { return view('site.agendas.index'); })->name('agendas.index');
    
    Route::get('/documents', [FrontendController::class, 'documentsIndex'])->name('documents.index');
    Route::get('/alumni', [FrontendController::class, 'alumniIndex'])->name('alumni.index');
    Route::get('/testimoni_alumni', [FrontendController::class, 'testimoniAlumni'])->name('alumni.testimonials');
    Route::get('/organisasi', [FrontendController::class, 'organisasiIndex'])->name('organisasi.index');
    Route::get('/organisasi/{id}', [FrontendController::class, 'organisasiShow'])->name('organisasi.show');
    Route::get('/ekstrakurikuler', [FrontendController::class, 'ekskulIndex'])->name('ekskul.index');
    Route::get('/ekstrakurikuler/{id}', [FrontendController::class, 'ekskulShow'])->name('ekskul.show');
    Route::get('/fasilitas', [FrontendController::class, 'fasilitasIndex'])->name('fasilitas.index');
    Route::get('/fasilitas/{slug}', [FrontendController::class, 'fasilitasShow'])->name('fasilitas.show');
    Route::get('/mitra-industri', [FrontendController::class, 'mitraIndex'])->name('mitra.index');
    Route::get('/mitra-industri/{slug}', [FrontendController::class, 'mitraDetail'])->name('mitra.detail');
    Route::get('/pelatihan-kerja', [FrontendController::class, 'pelatihanKerjaIndex'])->name('pelatihan-kerja.index');
    Route::get('/pelatihan-kerja/{key1}', [FrontendController::class, 'pelatihanKerjaDetail'])->name('pelatihan-kerja.detail');
    Route::get('/pendaftaran', [FrontendController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [FrontendController::class, 'pendaftaranStore'])->name('pendaftaran.store');
});

// Redirects
Route::redirect('/download', '/site/documents');
Route::redirect('/documents', '/site/documents');
Route::redirect('/alumni', '/site/alumni');
Route::redirect('/testimoni_alumni', '/site/testimoni_alumni');
Route::redirect('/organisasi', '/site/organisasi');
Route::redirect('/ekstrakurikuler', '/site/ekstrakurikuler');
Route::redirect('/fasilitas', '/site/fasilitas');
Route::redirect('/mitra', '/site/mitra-industri');
Route::redirect('/pelatihan-kerja', '/site/pelatihan-kerja');
Route::redirect('/daftar', '/site/pendaftaran');
Route::redirect('/pendaftaran', '/site/pendaftaran');
Route::redirect('/career', '/karir');
Route::redirect('/lowongan', '/karir');
Route::redirect('/lowongan-kerja', '/karir');

Route::get('/test-header', fn() => view('test-header'));

if (config('app.debug')) {
    Route::prefix('test-error')->group(function () {
        Route::get('/404', fn() => abort(404));
        Route::get('/403', fn() => abort(403));
        Route::get('/401', fn() => abort(401));
        Route::get('/419', fn() => abort(419));
        Route::get('/429', fn() => abort(429));
        Route::get('/500', fn() => abort(500));
        Route::get('/503', fn() => abort(503));
        Route::get('/generic/{code}', fn($code) => abort($code));
    });
}

// Auth Routes
Route::get('/universe', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/universe', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

foreach (['/login','/admin','/administrator','/wp-admin','/admin/login','/backend','/dashboard'] as $p) {
    Route::get($p, fn() => abort(404));
}

// ═══════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // ── Konten Publik ──
    Route::resource('news', NewsController::class);
    Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('news.upload-image');
    Route::post('news/upload-file', [NewsController::class, 'uploadFile'])->name('news.upload-file');
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('events', EventController::class);
    Route::get('/agendas', [EventController::class, 'index'])->name('agendas.index');
    Route::resource('pages', PageController::class);
    Route::post('/pages/upload-image', [PageController::class, 'uploadImage'])->name('pages.upload-image');
    Route::resource('galleries', GalleryController::class);
    Route::delete('galleries/images/{id}', [GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');

    // ── SuperAdmin Only ──
    Route::middleware(\App\Http\Middleware\IsSuperAdmin::class)->group(function () {
        Route::get('/jurusan', fn() => view('admin.jurusan.index'))->name('jurusan.index');
        Route::get('/structural-members', fn() => view('admin.structural.index'))->name('structural.index');
        Route::get('/mitra-industri', fn() => view('admin.mitra-industri.index'))->name('mitra-industri.index');
        Route::get('/fasilitas', fn() => view('admin.fasilitas.index'))->name('fasilitas.index');

        Route::get('/common-data', [CommonDataController::class, 'index'])->name('common-data.index');
        Route::get('/common-data/{tableName}', [CommonDataController::class, 'show'])->name('common-data.show');
        Route::post('/common-data', [CommonDataController::class, 'store'])->name('common-data.store');
        Route::put('/common-data/{id}', [CommonDataController::class, 'update'])->name('common-data.update');
        Route::delete('/common-data/{id}', [CommonDataController::class, 'destroy'])->name('common-data.destroy');

        // ✅ HALAMAN PENGATURAN (dengan ALIAS URL lama)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/setting', fn() => redirect()->route('admin.settings.index'));
        Route::get('/pengaturan', fn() => redirect()->route('admin.settings.index'));
        Route::get('/pengaturan-frontend', fn() => redirect()->route('admin.settings.index'));
        Route::get('/pengaturan-website', fn() => redirect()->route('admin.settings.index'));
        Route::get('/frontend-settings', fn() => redirect()->route('admin.settings.index'));

        Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('system-settings.index');
        Route::put('/system-settings', [SystemSettingController::class, 'update'])->name('system-settings.update');

        Route::resource('users', UserController::class);

        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::put('/security/settings', [SecurityController::class, 'updateSettings'])->name('security.settings.update');
        Route::get('/security/logs', [SecurityController::class, 'logs'])->name('security.logs');
    });

    Route::post('profile/change-password', [UserController::class, 'changeOwnPassword'])->name('profile.change-password');
    Route::resource('teachers', TeacherController::class);

    Route::get('/students', fn() => view('admin.students.index'))->name('students.index');
    Route::get('/alumni-member', fn() => view('admin.alumni.index'))->name('alumni.index');
    Route::get('/testimonials', fn() => view('admin.testimonials.index'))->name('testimonials.index');
    Route::get('/achievements', fn() => view('admin.achievements.index'))->name('achievements.index');
    Route::get('/downloads', fn() => view('admin.downloads.index'))->name('downloads.index');

    Route::get('/structures', [App\Http\Controllers\Admin\StructureController::class, 'index'])->name('structure.index');
    Route::get('/structures/{id}/members', [App\Http\Controllers\Admin\StructureController::class, 'members'])->name('structure.members');

    // ── Pendaftaran ──
    Route::get('/pendaftaran', [App\Http\Controllers\Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/export', [App\Http\Controllers\Admin\PendaftaranController::class, 'export'])->name('pendaftaran.export');
    Route::get('/pendaftaran/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}/status', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
    Route::delete('/pendaftaran/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // ── E-Learning (Admin) — 1 blok saja, TIDAK DUPlikat ──
    Route::get('/elearning/users', [App\Http\Controllers\Admin\ElearningUserController::class, 'index'])->name('elearning.users');
    Route::post('/elearning/users', [App\Http\Controllers\Admin\ElearningUserController::class, 'store'])->name('elearning.users.store');
    Route::put('/elearning/users/{id}', [App\Http\Controllers\Admin\ElearningUserController::class, 'update'])->name('elearning.users.update');
    Route::post('/elearning/users/{id}/toggle', [App\Http\Controllers\Admin\ElearningUserController::class, 'toggle'])->name('elearning.users.toggle');
    Route::delete('/elearning/users/{id}', [App\Http\Controllers\Admin\ElearningUserController::class, 'destroy'])->name('elearning.users.destroy');
    Route::post('/elearning/users/import', [App\Http\Controllers\Admin\ElearningUserController::class, 'import'])->name('elearning.users.import');
    Route::get('/elearning/users/template', [App\Http\Controllers\Admin\ElearningUserController::class, 'template'])->name('elearning.users.template');
    Route::get('/elearning/absensi', [App\Http\Controllers\Admin\ElearningUserController::class, 'absensi'])->name('elearning.absensi');
    Route::delete('/elearning/absensi/{id}', [App\Http\Controllers\Admin\ElearningUserController::class, 'destroyAbsensi'])->name('elearning.absensi.destroy');
});

// ═══════════════════════════════════════════════════
// FRONTEND PUBLIC
// ═══════════════════════════════════════════════════
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/site', [FrontendController::class, 'home'])->name('site');
Route::get('/berita', [FrontendController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [FrontendController::class, 'beritaShow'])->name('berita.show');
Route::get('/agenda', [FrontendController::class, 'agendaIndex'])->name('agenda.index');
Route::get('/agenda/{slug}', [FrontendController::class, 'agendaShow'])->name('agenda.show');
Route::get('/api/events-by-month', [FrontendController::class, 'getEventsByMonth'])->name('api.events.by-month');
Route::get('/pengumuman', [FrontendController::class, 'pengumumanIndex'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [FrontendController::class, 'pengumumanShow'])->name('pengumuman.show');
Route::get('/gallery', [FrontendController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/gallery/{slug}', [FrontendController::class, 'galleryShow'])->name('gallery.show');
Route::get('/jurusan', [FrontendController::class, 'jurusanIndex'])->name('jurusan.index');
Route::get('/jurusan/{kode}', [FrontendController::class, 'jurusanSpace'])->name('jurusan.space');
Route::get('/jurusan/{kode}/{pageSlug}', [FrontendController::class, 'jurusanSpacePage'])->name('jurusan.space.page');
Route::get('/page/{slug}', [FrontendController::class, 'pageShow'])->name('page.show');
Route::get('/struktur/{slug}', [FrontendController::class, 'strukturShow'])->name('struktur.show');
Route::get('/prestasi', [FrontendController::class, 'prestasiIndex'])->name('prestasi.index');
Route::get('/prestasi/{id}', [FrontendController::class, 'prestasiShow'])->name('prestasi.show');
Route::get('/skill', [FrontendController::class, 'skillIndex'])->name('skill.index');
Route::get('/skill/{id}', [FrontendController::class, 'skillShow'])->name('skill.show');
Route::get('/karir', [FrontendController::class, 'karirIndex'])->name('karir.index');
Route::post('/karir/apply', [FrontendController::class, 'karirApply'])->name('karir.apply');
Route::get('/kontak', [FrontendController::class, 'kontakShow'])->name('kontak.show');

// ═══════════════════════════════════════════════════
// E-LEARNING (Staff & Mahasiswa)
// ═══════════════════════════════════════════════════
Route::prefix('elearning')->name('elearning.')->group(function () {
    Route::get('/', function () {
        return auth('elearning')->check()
            ? redirect()->route(auth('elearning')->user()->role === 'staff' ? 'elearning.staff.dashboard' : 'elearning.mahasiswa.dashboard')
            : redirect()->route('elearning.login');
    });

    Route::get('/login',  [App\Http\Controllers\Elearning\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Elearning\AuthController::class, 'login']);
    Route::post('/logout',[App\Http\Controllers\Elearning\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:elearning')->group(function () {
        Route::get('/profile', [App\Http\Controllers\Elearning\ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/photo', [App\Http\Controllers\Elearning\ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::post('/profile/password', [App\Http\Controllers\Elearning\ProfileController::class, 'updatePassword'])->name('profile.password');

        // ═══ STAFF ═══
        Route::prefix('staff')->name('staff.')
            ->middleware(\App\Http\Middleware\ElearningRole::class . ':staff')
            ->group(function () {
                Route::get('/dashboard', [App\Http\Controllers\Elearning\StaffController::class, 'dashboard'])->name('dashboard');
                Route::get('/absen',  [App\Http\Controllers\Elearning\StaffController::class, 'absen'])->name('absen');
                Route::post('/absen', [App\Http\Controllers\Elearning\StaffController::class, 'storeAbsen'])->name('absen.store');
                Route::get('/absen/mahasiswa', [App\Http\Controllers\Elearning\StaffController::class, 'absenMahasiswa'])->name('absen.mahasiswa');
                Route::delete('/absen/mahasiswa/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyAbsenMahasiswa'])->name('absen.mahasiswa.destroy');
                Route::post('/absen/toggle-mahasiswa', [App\Http\Controllers\Elearning\StaffController::class, 'toggleAbsenMahasiswa'])->name('absen.toggle-mahasiswa');
                Route::post('/absen/scan', [App\Http\Controllers\Elearning\StaffController::class, 'scanAbsen'])->name('absen.scan');
                Route::get('/pembayaran',  [App\Http\Controllers\Elearning\StaffController::class, 'pembayaran'])->name('pembayaran');
                Route::post('/pembayaran', [App\Http\Controllers\Elearning\StaffController::class, 'storePembayaran'])->name('pembayaran.store');
                Route::post('/pembayaran/{id}/lunas', [App\Http\Controllers\Elearning\StaffController::class, 'markLunas'])->name('pembayaran.lunas');
                Route::delete('/pembayaran/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyPembayaran'])->name('pembayaran.destroy');
                Route::delete('/pembayaran/{id}/bukti', [App\Http\Controllers\Elearning\StaffController::class, 'destroyBukti'])->name('pembayaran.bukti.destroy');
                Route::get('/pembayaran/slip/create', [App\Http\Controllers\Elearning\StaffController::class, 'slipCreate'])->name('pembayaran.slip.create');
                Route::post('/pembayaran/slip', [App\Http\Controllers\Elearning\StaffController::class, 'slipStore'])->name('pembayaran.slip.store');
                Route::get('/pembayaran/{id}/slip', [App\Http\Controllers\Elearning\StaffController::class, 'slipShow'])->name('pembayaran.slip');
                Route::get('/kelas',  [App\Http\Controllers\Elearning\StaffController::class, 'kelas'])->name('kelas');
                Route::post('/kelas', [App\Http\Controllers\Elearning\StaffController::class, 'storeKelas'])->name('kelas.store');
                Route::get('/kelas/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'kelasShow'])->name('kelas.show');
                Route::delete('/kelas/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyKelas'])->name('kelas.destroy');
                Route::post('/kelas/{id}/materi', [App\Http\Controllers\Elearning\StaffController::class, 'storeMateri'])->name('materi.store');
                Route::delete('/materi/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyMateri'])->name('materi.destroy');
                Route::post('/kelas/{id}/ujian',  [App\Http\Controllers\Elearning\StaffController::class, 'storeUjian'])->name('ujian.store');
                Route::post('/ujian/{id}/toggle', [App\Http\Controllers\Elearning\StaffController::class, 'toggleUjian'])->name('ujian.toggle');
                Route::post('/ujian/{id}/soal',   [App\Http\Controllers\Elearning\StaffController::class, 'uploadSoal'])->name('ujian.soal');
                Route::delete('/ujian/{id}/soal', [App\Http\Controllers\Elearning\StaffController::class, 'destroySoal'])->name('ujian.soal.destroy');
                Route::get('/berkas', [App\Http\Controllers\Elearning\StaffController::class, 'berkas'])->name('berkas');
                Route::post('/berkas/{id}/review', [App\Http\Controllers\Elearning\StaffController::class, 'reviewBerkas'])->name('berkas.review');
                Route::delete('/berkas/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyBerkas'])->name('berkas.destroy');
                Route::get('/berkas-alumni', [App\Http\Controllers\Elearning\StaffController::class, 'berkasAlumni'])->name('berkas.alumni');
                Route::post('/berkas-alumni/{id}/review', [App\Http\Controllers\Elearning\StaffController::class, 'reviewBerkasAlumni'])->name('berkas.alumni.review');
                Route::delete('/berkas-alumni/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyBerkasAlumni'])->name('berkas.alumni.destroy');
                Route::get('/loker', [App\Http\Controllers\Elearning\StaffController::class, 'loker'])->name('loker');
                Route::post('/loker', [App\Http\Controllers\Elearning\StaffController::class, 'storeLoker'])->name('loker.store');
                Route::post('/loker/{id}/toggle', [App\Http\Controllers\Elearning\StaffController::class, 'updateLoker'])->name('loker.toggle');
                Route::delete('/loker/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyLoker'])->name('loker.destroy');
                Route::delete('/ujian/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyUjian'])->name('ujian.destroy');
                Route::post('/submission/{id}/nilai', [App\Http\Controllers\Elearning\StaffController::class, 'storeNilai'])->name('nilai.store');

                // ═══════════════════════════════════════════════════════
                // ✅ DIREKTUR LEMBAGA — Monitor Absensi Staff
                // ═══════════════════════════════════════════════════════
                Route::get('/monitor-absensi', [App\Http\Controllers\Elearning\StaffController::class, 'monitorAbsensi'])->name('absensi.monitor');
                Route::delete('/monitor-absensi/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyAbsensiStaff'])->name('absensi.monitor.destroy');

                // ═══════════════════════════════════════════════════════
                // ✅ WAKIL DIREKTUR — Data Pendaftar
                // ═══════════════════════════════════════════════════════
                Route::get('/data-pendaftar', [App\Http\Controllers\Elearning\StaffController::class, 'pendaftar'])->name('pendaftar');
                Route::get('/data-pendaftar/export', [App\Http\Controllers\Elearning\StaffController::class, 'exportPendaftar'])->name('pendaftar.export');
                Route::put('/data-pendaftar/{id}/status', [App\Http\Controllers\Elearning\StaffController::class, 'updateStatusPendaftar'])->name('pendaftar.status');
                Route::delete('/data-pendaftar/{id}', [App\Http\Controllers\Elearning\StaffController::class, 'destroyPendaftar'])->name('pendaftar.destroy');
            });

        // ═══ MAHASISWA ═══
        Route::prefix('mahasiswa')->name('mahasiswa.')
            ->middleware(\App\Http\Middleware\ElearningRole::class . ':mahasiswa')
            ->group(function () {
                Route::get('/dashboard', [App\Http\Controllers\Elearning\MahasiswaController::class, 'dashboard'])->name('dashboard');
                Route::get('/absen',  [App\Http\Controllers\Elearning\MahasiswaController::class, 'absen'])->name('absen');
                Route::post('/absen', [App\Http\Controllers\Elearning\MahasiswaController::class, 'storeAbsen'])->name('absen.store');
                Route::post('/absen/scan', [App\Http\Controllers\Elearning\MahasiswaController::class, 'scanAbsen'])->name('absen.scan');
                Route::get('/materi', [App\Http\Controllers\Elearning\MahasiswaController::class, 'materi'])->name('materi');
                Route::get('/pembayaran', [App\Http\Controllers\Elearning\MahasiswaController::class, 'pembayaran'])->name('pembayaran');
                Route::post('/pembayaran/{id}/bukti', [App\Http\Controllers\Elearning\MahasiswaController::class, 'submitBukti'])->name('pembayaran.bukti');
                Route::get('/kelas', [App\Http\Controllers\Elearning\MahasiswaController::class, 'kelas'])->name('kelas');
                Route::get('/kelas/{id}', [App\Http\Controllers\Elearning\MahasiswaController::class, 'kelasShow'])->name('kelas.show');
                Route::post('/ujian/{id}/submit', [App\Http\Controllers\Elearning\MahasiswaController::class, 'submitUjian'])->name('ujian.submit');
                Route::get('/berkas',    [App\Http\Controllers\Elearning\MahasiswaController::class, 'berkas'])->name('berkas');
                Route::post('/berkas',   [App\Http\Controllers\Elearning\MahasiswaController::class, 'storeBerkas'])->name('berkas.store');
                Route::delete('/berkas/{id}', [App\Http\Controllers\Elearning\MahasiswaController::class, 'destroyBerkas'])->name('berkas.destroy');
            });
    });
});

// Artisan Routes
Route::prefix('d1k4')->group(function () {
    $checkToken = function () {
        if (request()->query('token') !== env('CMD_TOKEN', '@Mirror98')) abort(404);
    };
    
    Route::get('/cc', function () use ($checkToken) { $checkToken(); try { \Artisan::call('cache:clear'); \Artisan::call('config:clear'); \Artisan::call('route:clear'); \Artisan::call('view:clear'); return response()->json(['success' => true, 'message' => 'All cache cleared!']); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/opt', function () use ($checkToken) { $checkToken(); try { \Artisan::call('optimize'); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/sl', function () use ($checkToken) { $checkToken(); try { \Artisan::call('storage:link'); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/mig', function () use ($checkToken) { $checkToken(); try { \Artisan::call('migrate', ['--force' => true]); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/seed', function () use ($checkToken) { $checkToken(); try { \Artisan::call('db:seed', ['--force' => true]); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/up', function () use ($checkToken) { $checkToken(); try { \Artisan::call('up'); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/down', function () use ($checkToken) { $checkToken(); try { \Artisan::call('down'); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/key', function () use ($checkToken) { $checkToken(); try { \Artisan::call('key:generate', ['--force' => true]); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
    Route::get('/vc', function () use ($checkToken) { $checkToken(); try { \Artisan::call('view:clear'); \Artisan::call('view:cache'); return response()->json(['success' => true]); } catch (\Exception $e) { return response()->json(['success' => false, 'error' => $e->getMessage()], 500); } });
});