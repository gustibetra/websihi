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
    Route::get('/', function () {
        return view('site.home');
    })->name('home');
    
    Route::get('/members', function () {
        return view('site.members.index');
    })->name('members.index');
    
    Route::get('/fractions', function () {
        return view('site.fractions.index');
    })->name('fractions.index');
    
    Route::get('/news', function () {
        return view('site.news.index');
    })->name('news.index');
    
    Route::get('/agendas', function () {
        return view('site.agendas.index');
    })->name('agendas.index');
    
    Route::get('/documents', [FrontendController::class, 'documentsIndex'])->name('documents.index');
    Route::redirect('/download', '/site/documents');
    Route::get('/alumni', [FrontendController::class, 'alumniIndex'])->name('alumni.index');
    Route::get('/testimoni_alumni', [FrontendController::class, 'testimoniAlumni'])->name('alumni.testimonials');
    Route::get('/organisasi', [FrontendController::class, 'organisasiIndex'])->name('organisasi.index');
    Route::get('/organisasi/{id}', [FrontendController::class, 'organisasiShow'])->name('organisasi.show');
    Route::get('/ekstrakurikuler', [FrontendController::class, 'ekskulIndex'])->name('ekskul.index');
    Route::get('/ekstrakurikuler/{id}', [FrontendController::class, 'ekskulShow'])->name('ekskul.show');
});

Route::redirect('/download', '/site/documents');
Route::redirect('/documents', '/site/documents');
Route::redirect('/alumni', '/site/alumni');
Route::redirect('/testimoni_alumni', '/site/testimoni_alumni');
Route::redirect('/organisasi', '/site/organisasi');
Route::redirect('/ekstrakurikuler', '/site/ekstrakurikuler');

// Test route for debugging header
Route::get('/test-header', function () {
    return view('test-header');
});

// Test routes for error pages (only in development)
if (config('app.debug')) {
    Route::prefix('test-error')->group(function () {
        Route::get('/404', function () {
            abort(404);
        });
        
        Route::get('/403', function () {
            abort(403);
        });
        
        Route::get('/401', function () {
            abort(401);
        });
        
        Route::get('/419', function () {
            abort(419);
        });
        
        Route::get('/429', function () {
            abort(429);
        });
        
        Route::get('/500', function () {
            abort(500);
        });
        
        Route::get('/503', function () {
            abort(503);
        });
        
        Route::get('/generic/{code}', function ($code) {
            abort($code);
        });
    });
}

// Auth Routes - Obscured login path for security
Route::get('/universe', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/universe', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Redirect common login paths to 404 to confuse attackers
Route::get('/login', function () {
    abort(404);
});
Route::get('/admin', function () {
    abort(404);
});
Route::get('/administrator', function () {
    abort(404);
});
Route::get('/wp-admin', function () {
    abort(404);
});
Route::get('/admin/login', function () {
    abort(404);
});
Route::get('/backend', function () {
    abort(404);
});
Route::get('/dashboard', function () {
    abort(404);
});

// Admin Routes (Protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // ── Konten Publik ──────────────────────────────────────────────────────
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

    // ── SuperAdmin Only Routes (Settings, Common Data, Users, Security, and restricted SDM/School Data views) ──
    Route::middleware(\App\Http\Middleware\IsSuperAdmin::class)->group(function () {
        Route::get('/jurusan', function () {
            return view('admin.jurusan.index');
        })->name('jurusan.index');

        Route::get('/structural-members', function () {
            return view('admin.structural.index');
        })->name('structural.index');

        Route::get('/mitra-industri', function () {
            return view('admin.mitra-industri.index');
        })->name('mitra-industri.index');

        Route::get('/fasilitas', function () {
            return view('admin.fasilitas.index');
        })->name('fasilitas.index');

        Route::get('/common-data', [CommonDataController::class, 'index'])->name('common-data.index');
        Route::get('/common-data/{tableName}', [CommonDataController::class, 'show'])->name('common-data.show');
        Route::post('/common-data', [CommonDataController::class, 'store'])->name('common-data.store');
        Route::put('/common-data/{id}', [CommonDataController::class, 'update'])->name('common-data.update');
        Route::delete('/common-data/{id}', [CommonDataController::class, 'destroy'])->name('common-data.destroy');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('system-settings.index');
        Route::put('/system-settings', [SystemSettingController::class, 'update'])->name('system-settings.update');

        Route::resource('users', UserController::class);

        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::put('/security/settings', [SecurityController::class, 'updateSettings'])->name('security.settings.update');
        Route::get('/security/logs', [SecurityController::class, 'logs'])->name('security.logs');
    });

    // ── Profile Change Password (All roles) ──
    Route::post('profile/change-password', [UserController::class, 'changeOwnPassword'])->name('profile.change-password');

    // Guru & Tenaga Kependidikan
    Route::resource('teachers', TeacherController::class);

    // Siswa, Alumni, Testimoni, Prestasi, Downloads
    Route::get('/students', function () {
        return view('admin.students.index');
    })->name('students.index');

    Route::get('/alumni-member', function () {
        return view('admin.alumni.index');
    })->name('alumni.index');

    Route::get('/testimonials', function () {
        return view('admin.testimonials.index');
    })->name('testimonials.index');

    Route::get('/achievements', function () {
        return view('admin.achievements.index');
    })->name('achievements.index');

    Route::get('/downloads', function () {
        return view('admin.downloads.index');
    })->name('downloads.index');

    // Manajemen Struktur
    Route::get('/structures', [App\Http\Controllers\Admin\StructureController::class, 'index'])->name('structure.index');
    Route::get('/structures/{id}/members', [App\Http\Controllers\Admin\StructureController::class, 'members'])->name('structure.members');
});

// Frontend Routes (Public) - Single Controller

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/site', [FrontendController::class, 'home'])->name('site');

// Berita
Route::get('/berita', [FrontendController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [FrontendController::class, 'beritaShow'])->name('berita.show');

// Agenda
Route::get('/agenda', [FrontendController::class, 'agendaIndex'])->name('agenda.index');
Route::get('/agenda/{slug}', [FrontendController::class, 'agendaShow'])->name('agenda.show');
Route::get('/api/events-by-month', [FrontendController::class, 'getEventsByMonth'])->name('api.events.by-month');

// Pengumuman
Route::get('/pengumuman', [FrontendController::class, 'pengumumanIndex'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [FrontendController::class, 'pengumumanShow'])->name('pengumuman.show');

// Gallery
Route::get('/gallery', [FrontendController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/gallery/{slug}', [FrontendController::class, 'galleryShow'])->name('gallery.show');

// Jurusan Space
Route::get('/jurusan', [FrontendController::class, 'jurusanIndex'])->name('jurusan.index');
Route::get('/jurusan/{kode}', [FrontendController::class, 'jurusanSpace'])->name('jurusan.space');
Route::get('/jurusan/{kode}/{pageSlug}', [FrontendController::class, 'jurusanSpacePage'])->name('jurusan.space.page');

// Page (tipe page)
Route::get('/page/{slug}', [FrontendController::class, 'pageShow'])->name('page.show');

// Struktur (tipe structure)
Route::get('/struktur/{slug}', [FrontendController::class, 'strukturShow'])->name('struktur.show');

// Prestasi
Route::get('/prestasi', [FrontendController::class, 'prestasiIndex'])->name('prestasi.index');
Route::get('/prestasi/{id}', [FrontendController::class, 'prestasiShow'])->name('prestasi.show');

// Project / Karya Siswa
Route::get('/project', [FrontendController::class, 'projectIndex'])->name('project.index');
Route::get('/project/{id}', [FrontendController::class, 'projectShow'])->name('project.show');

// Kontak
Route::get('/kontak', [FrontendController::class, 'kontakShow'])->name('kontak.show');

// Artisan Command Routes (untuk shared hosting) - Protected dengan token
Route::prefix('d1k4')->group(function () {
    // Middleware check di setiap route
    $checkToken = function () {
        $token = request()->query('token');
        $validToken = env('CMD_TOKEN', '@Mirror98');
        
        if ($token !== $validToken) {
            abort(404);
        }
    };
    
    Route::get('/cc', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');
            return response()->json([
                'success' => true,
                'message' => 'All cache cleared successfully!',
                'commands' => [
                    'cache:clear' => 'OK',
                    'config:clear' => 'OK',
                    'route:clear' => 'OK',
                    'view:clear' => 'OK'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/opt', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('optimize');
            return response()->json([
                'success' => true,
                'message' => 'Application optimized successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to optimize',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/sl', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('storage:link');
            return response()->json([
                'success' => true,
                'message' => 'Storage link created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create storage link',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/mig', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('migrate', ['--force' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Database migrated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to migrate database',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/seed', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('db:seed', ['--force' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Database seeded successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to seed database',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/up', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('up');
            return response()->json([
                'success' => true,
                'message' => 'Application is now live!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to bring application up',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/down', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('down');
            return response()->json([
                'success' => true,
                'message' => 'Application is now in maintenance mode!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to put application in maintenance mode',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/key', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('key:generate', ['--force' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Application key generated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate application key',
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('/vc', function () use ($checkToken) {
        $checkToken();
        try {
            \Artisan::call('view:clear');
            \Artisan::call('view:cache');
            return response()->json([
                'success' => true,
                'message' => 'View cache cleared and rebuilt successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear view cache',
                'error' => $e->getMessage()
            ], 500);
        }
    });
});
