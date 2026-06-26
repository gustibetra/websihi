<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Common;
use App\Models\Program;
use App\Models\Achievement;
use App\Models\Alumni;
use App\Models\Student;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Services\LookupService;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct(
        private LookupService $lookupService
    ) {}

    /**
     * Home page
     */
    public function home()
    {
        // 1. Get all active sections for the homepage ordered by order
        $sections = Common::where('table_name', 'home_section')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $activeKeys = $sections->pluck('key1')->toArray();

        // 2. Initialize variables conditionally based on active sections
        $heroBanners = collect();
        $latestNews = collect();
        $featuredNews = collect();
        $academicNews = collect();
        $activityNews = collect();
        $programKeahlian = collect();
        $programUnggulan = collect();
        $mitraIndustri = collect();
        $prestasiSiswa = collect();
        $prestasiSekolah = collect();
        $karyaSiswa = collect();
        $upcomingEvents = collect();
        $galleries = collect();
        $alumni = collect();
        $testimonials = collect();
        $setting = null;
        $fasilitas = collect();
        $faqs = collect();

        // Load data only if corresponding section is active
        if (in_array('hero_banner', $activeKeys)) {
            $heroBanners = Common::where('table_name', 'hero_banner_slide')
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->get();
        }

        if (in_array('program_keahlian', $activeKeys)) {
            $programKeahlian = Program::where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        if (in_array('program_unggulan', $activeKeys)) {
            $programUnggulan = Common::where('table_name', 'program_unggulan')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        if (in_array('mitra_industri', $activeKeys)) {
            $mitraIndustri = Common::where('table_name', 'mitra_industri')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        if (in_array('prestasi_siswa', $activeKeys)) {
            $prestasiSiswa = Achievement::where('type', 'siswa')
                ->where('is_active', true)
                ->orderBy('date', 'desc')
                ->take(6)
                ->get();
            
            $prestasiSekolah = Achievement::where('type', 'sekolah')
                ->where('is_active', true)
                ->orderBy('date', 'desc')
                ->take(6)
                ->get();
        }

        if (in_array('karya_siswa', $activeKeys)) {
            $karyaSiswa = Common::where('table_name', 'karya_siswa')
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->take(3)
                ->get();
        }

        if (in_array('berita_terbaru', $activeKeys)) {
            $latestNews = News::where('status', 'published')
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();

            $featuredNews = News::where('status', 'published')
                ->where('is_featured', true)
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();

            if ($featuredNews->isEmpty()) {
                $featuredNews = $latestNews;
            }

            $academicNews = News::where('status', 'published')
                ->whereHas('category', function($q) {
                    $q->where('table_name', 'kategori_berita')
                      ->where('data1', 'Akademik');
                })
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();

            $activityNews = News::where('status', 'published')
                ->whereHas('category', function($q) {
                    $q->where('table_name', 'kategori_berita')
                      ->where('data1', 'Kegiatan');
                })
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        }

        if (in_array('agenda_event', $activeKeys)) {
            $upcomingEvents = Event::where('is_active', true)
                ->whereYear('start_datetime', now()->year)
                ->whereMonth('start_datetime', now()->month)
                ->orderBy('start_datetime', 'asc')
                ->get();
        }

        if (in_array('galeri', $activeKeys)) {
            $galleryCategories = Common::where('table_name', 'kategori_galeri')
                ->where('is_active', true)
                ->get();

            $galleries = Gallery::with(['coverImage', 'images', 'category'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $galleryCategories = collect();
        }

        if (in_array('alumni_berprestasi', $activeKeys)) {
            $alumni = Alumni::where('is_active', true)
                ->orderBy('order')
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();
        }

        if (in_array('testimoni', $activeKeys)) {
            $testimonials = Testimonial::where('is_active', true)
                ->orderBy('order')
                ->orderBy('id', 'desc')
                ->get();
        }

        if (in_array('ppdb', $activeKeys)) {
            $setting = Setting::first();
        }

        if (in_array('fasilitas', $activeKeys)) {
            $fasilitas = Common::where('table_name', 'fasilitas')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        if (in_array('faq', $activeKeys)) {
            $faqs = Common::where('table_name', 'faq')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        }

        $socialMedia = null;
        if (in_array('social_media', $activeKeys)) {
            $socialMedia = Common::where('table_name', 'social_media_setting')
                ->where('key1', 'social_media_config')
                ->first();
        }

        return view('site.home', compact(
            'sections',
            'heroBanners',
            'latestNews',
            'featuredNews',
            'academicNews',
            'activityNews',
            'programKeahlian',
            'programUnggulan',
            'mitraIndustri',
            'prestasiSiswa',
            'prestasiSekolah',
            'karyaSiswa',
            'upcomingEvents',
            'galleries',
            'galleryCategories',
            'alumni',
            'testimonials',
            'setting',
            'fasilitas',
            'faqs',
            'socialMedia'
        ));
    }

    /**
     * Berita index
     */
    public function beritaIndex(Request $request)
    {
        $query = News::where('status', 'published');

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by period
        if ($request->filled('period')) {
            $query->where('period', $request->period);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('published_at', $request->year);
        }

        // Filter by featured
        if ($request->filled('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->where('tags', 'like', '%' . $request->tag . '%');
        }

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan_id', $request->jurusan);
        }

        // Filter by sorting
        $sort = $request->get('sort', 'terkini');
        if ($sort === 'populer') {
            $query->orderBy('view_count', 'desc');
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $news = $query->paginate(12)->withQueryString();
        
        // Get filter data using LookupService
        $categories = $this->lookupService->getCollection('kategori_berita');
        $periods = $this->lookupService->getPeriods();
        $years = \App\Models\News::selectRaw('YEAR(published_at) as year')
            ->distinct()
            ->whereNotNull('published_at')
            ->where('status', 'published')
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        $programs = \App\Models\Program::where('is_active', true)->orderBy('order')->get();
        
        return view('site.berita.index', compact('news', 'categories', 'periods', 'years', 'programs'));
    }

    /**
     * Berita detail
     */
    public function beritaShow($slug)
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        
        // Increment view count
        $news->increment('view_count');
        
        return view('site.berita.show', compact('news'));
    }

    /**
     * Agenda index
     */
    public function agendaIndex(Request $request)
    {
        $query = Event::where('is_active', true);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by period
        if ($request->filled('period')) {
            $query->where('period', $request->period);
        }

        // Filter by month (format: YYYY-MM)
        if ($request->filled('month')) {
            // Jika format YYYY-MM
            if (strpos($request->month, '-') !== false) {
                list($year, $month) = explode('-', $request->month);
                $query->whereYear('start_datetime', $year)
                      ->whereMonth('start_datetime', $month);
            } else {
                // Jika hanya bulan, gunakan tahun dari filter atau tahun sekarang
                $year = $request->filled('year') ? $request->year : date('Y');
                $query->whereYear('start_datetime', $year)
                      ->whereMonth('start_datetime', $request->month);
            }
        } elseif ($request->filled('year')) {
            // Filter by year saja jika tidak ada month
            $query->whereYear('start_datetime', $request->year);
        }

        // Filter by status (upcoming/past)
        if ($request->filled('status')) {
            if ($request->status == 'upcoming') {
                $query->where('start_datetime', '>=', now());
            } elseif ($request->status == 'past') {
                $query->where('end_datetime', '<', now());
            }
        }

        $events = $query->orderBy('start_datetime', 'desc')->paginate(12)->withQueryString();
        
        // Get filter data using LookupService
        $periods = $this->lookupService->getPeriods();
        $years = \App\Models\Event::selectRaw('YEAR(start_datetime) as year')
            ->distinct()
            ->whereNotNull('start_datetime')
            ->where('is_active', true)
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('site.agenda.index', compact('events', 'periods', 'years'));
    }

    /**
     * Agenda detail
     */
    public function agendaShow($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('site.agenda.show', compact('event'));
    }

    /**
     * Get events by month (AJAX)
     */
    public function getEventsByMonth(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        
        $events = Event::where('is_active', true)
            ->whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month)
            ->orderBy('start_datetime', 'asc')
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'start_datetime' => $event->start_datetime->format('Y-m-d H:i:s'),
                    'location' => $event->location,
                ];
            });
        
        return response()->json($events);
    }

    /**
     * Pengumuman index
     */
    public function pengumumanIndex(Request $request)
    {
        $query = Announcement::where('is_active', true);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by period
        if ($request->filled('period')) {
            $query->where('period', $request->period);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by status (active/expired)
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where(function($q) {
                    $q->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
                });
            } elseif ($request->status == 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        $announcements = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get filter data using LookupService
        $categories = $this->lookupService->getCollection('announcement_category');
        $periods = $this->lookupService->getPeriods();
        $years = \App\Models\Announcement::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->whereNotNull('created_at')
            ->where('is_active', true)
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('site.pengumuman.index', compact('announcements', 'categories', 'periods', 'years'));
    }

    /**
     * Pengumuman detail
     */
    public function pengumumanShow($slug)
    {
        $announcement = Announcement::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('site.pengumuman.show', compact('announcement'));
    }

    /**
     * Gallery index
     */
    public function galleryIndex(Request $request)
    {
        $categories = Common::where('table_name', 'kategori_galeri')
            ->where('is_active', true)
            ->get();

        $query = Gallery::query()
            ->with([
                'user',
                'coverImage',
                'images' => function ($query) {
                    $query->orderBy('sort_order')->orderBy('id');
                },
            ])
            ->withCount('images');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $galleries = $query->orderBy('created_at', 'desc')->paginate(16)->withQueryString();

        return view('site.gallery.index', compact('galleries', 'categories'));
    }

    /**
     * Gallery detail
     */
    public function galleryShow($slug)
    {
        $gallery = Gallery::query()
            ->with([
                'user',
                'images' => function ($query) {
                    $query->orderBy('sort_order')->orderBy('id');
                },
            ])
            ->withCount('images')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('site.gallery.show', compact('gallery'));
    }

    /**
     * Page detail (tipe page)
     */
    public function pageShow($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('page_type', 'page')
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('site.page.show', compact('page'));
    }

    /**
     * Struktur detail (tipe structure)
     */
    public function strukturShow($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('page_type', 'structure')
            ->where('is_active', true)
            ->firstOrFail();
        
        // Jika spesifik struktur (ada structure_common_id)
        if ($page->structure_common_id) {
            $structure = \App\Models\Common::findOrFail($page->structure_common_id);
            
            // Load sections and their members
            $sections = \App\Models\StructureSection::where('common_id', $structure->id)
                ->orderBy('order')
                ->get();
                
            foreach ($sections as $section) {
                $section->assigned_members = \App\Models\StructureMember::where('common_id', $structure->id)
                    ->where('section_id', $section->id)
                    ->where('is_active', true)
                    ->where('period', $page->period)
                    ->orderBy('order')
                    ->with('member')
                    ->get();
            }
            
            // Load unassigned members
            $unassignedMembers = \App\Models\StructureMember::where('common_id', $structure->id)
                ->whereNull('section_id')
                ->where('is_active', true)
                ->where('period', $page->period)
                ->orderBy('order')
                ->with('member')
                ->get();
            
            return view('site.struktur.show', compact('page', 'structure', 'sections', 'unassignedMembers'));
        }
        
        // Jika semua struktur berdasarkan tipe (dapil, komisi, fraksi, dll)
        
        // Cari period_id dari period string (untuk semua tipe struktur)
        $periodId = null;
        if ($page->period) {
            $periodData = \App\Models\Common::where('table_name', 'period')
                ->where('key1', $page->period)
                ->first();
            $periodId = $periodData ? $periodData->id : null;
        }
        
        $structuresQuery = \App\Models\Common::where('table_name', 'structure')
            ->where('key2', $page->structure_type);
        
        // Filter by period_id di data2 jika ada
        if ($periodId) {
            $structuresQuery->where('data2', $periodId);
        }
        
        $structures = $structuresQuery->orderBy('key1')->get();
        
        // Load sections and members for each structure
        foreach ($structures as $struct) {
            $struct->sections_data = \App\Models\StructureSection::where('common_id', $struct->id)
                ->orderBy('order')
                ->get();
                
            foreach ($struct->sections_data as $section) {
                $section->assigned_members = \App\Models\StructureMember::where('common_id', $struct->id)
                    ->where('section_id', $section->id)
                    ->where('is_active', true)
                    ->where('period', $page->period)
                    ->orderBy('order')
                    ->with('member')
                    ->get();
            }
            
            $struct->unassigned_members = \App\Models\StructureMember::where('common_id', $struct->id)
                ->whereNull('section_id')
                ->where('is_active', true)
                ->where('period', $page->period)
                ->orderBy('order')
                ->with('member')
                ->get();
        }
        
        return view('site.struktur.show', compact('page', 'structures'));
    }

    /**
     * Public Download Center / Documents Page
     */
    public function documentsIndex(Request $request)
    {
        $query = \App\Models\Download::where('is_active', true)->with(['category', 'jurusan']);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $jurusan = $request->jurusan;
            if ($jurusan === 'umum') {
                $query->whereNull('jurusan_id');
            } else {
                $query->where(function($q) use ($jurusan) {
                    $q->whereNull('jurusan_id')
                      ->orWhere('jurusan_id', $jurusan);
                });
            }
        }

        $downloads = $query->orderBy('created_at', 'desc')->paginate(12);

        // Fetch categories and programs for filters
        $categories = \App\Models\Common::where('table_name', 'kategori_download')
            ->where('is_active', true)
            ->get();
            
        $jurusans = \App\Models\Program::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('site.documents.index', compact('downloads', 'categories', 'jurusans'));
    }

    /**
     * Public Achievements (Prestasi) Page
     */
    public function prestasiIndex(Request $request)
    {
        $query = Achievement::where('is_active', true)->with(['jurusan', 'kategori', 'tingkat']);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('achiever', 'like', '%' . $request->search . '%')
                  ->orWhere('organizer', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type (siswa / sekolah)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }

        // Filter by tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat_id', $request->tingkat);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $achievements = $query->orderBy('date', 'desc')->paginate(10);

        // Fetch filters
        $categories = Common::where('table_name', 'kategori_prestasi')
            ->where('is_active', true)
            ->get();

        $tingkats = Common::where('table_name', 'tingkatan_prestasi')
            ->where('is_active', true)
            ->get();

        $years = Achievement::selectRaw('YEAR(date) as year')
            ->distinct()
            ->whereNotNull('date')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('site.prestasi.index', compact('achievements', 'categories', 'tingkats', 'years'));
    }

    /**
     * Public Achievement Detail
     */
    public function prestasiShow($id)
    {
        $achievement = Achievement::where('is_active', true)
            ->with(['jurusan', 'kategori', 'tingkat', 'news'])
            ->findOrFail($id);

        return view('site.prestasi.show', compact('achievement'));
    }

    /**
     * Public Projects (Karya Siswa) Page
     */
    public function projectIndex(Request $request)
    {
        $query = Common::where('table_name', 'karya_siswa')->where('is_active', true);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('data1', 'like', '%' . $request->search . '%')
                  ->orWhere('text1', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $query->where('data3', $request->jurusan);
        }

        $projects = $query->orderBy('id', 'desc')->paginate(9);

        // Fetch programs/jurusans for filter
        $jurusans = Program::where('is_active', true)->orderBy('order')->get();

        return view('site.project.index', compact('projects', 'jurusans'));
    }

    /**
     * Public Project Detail
     */
    public function projectShow($id)
    {
        $project = Common::where('table_name', 'karya_siswa')
            ->where('is_active', true)
            ->findOrFail($id);

        // Get program/jurusan if exists
        $jurusan = null;
        if ($project->data3) {
            $jurusan = Program::find($project->data3);
        }

        // Get linked news if exists
        $news = null;
        if ($project->data4) {
            $news = News::find($project->data4);
        }

        return view('site.project.show', compact('project', 'jurusan', 'news'));
    }

    /**
     * Public Alumni Directory Page
     */
    public function alumniIndex(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = \App\Models\Alumni::where('is_active', true)
            ->with('jurusan');

        if ($status && $status !== 'all') {
            if ($status === 'Lainnya') {
                $query->whereNotIn('status_alumni', ['Kuliah', 'Bekerja', 'Wirausaha']);
            } else {
                $query->where('status_alumni', $status);
            }
        }

        $alumni = $query->orderBy('tahun_lulus', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        $jurusans = Program::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('site.alumni.index', compact('alumni', 'jurusans', 'status'));
    }

    /**
     * Public Alumni Testimonials Page
     */
    public function testimoniAlumni(Request $request)
    {
        $alumni = \App\Models\Alumni::where('is_active', true)
            ->whereNotNull('testimoni')
            ->where('testimoni', '!=', '')
            ->with('jurusan')
            ->orderBy('tahun_lulus', 'desc')
            ->get();

        return view('site.alumni.testimoni', compact('alumni'));
    }


    /**
     * Public Organisasi Siswa Index
     */
    public function organisasiIndex(Request $request)
    {
        $structures = \App\Models\Common::where('table_name', 'structure')
            ->where('key2', 'organisasi')
            ->where('is_active', true)
            ->orderBy('data1', 'asc')
            ->get();

        return view('site.organisasi.index', compact('structures'));
    }

    /**
     * Public Organisasi Siswa Show
     */
    public function organisasiShow($id)
    {
        $structure = \App\Models\Common::where('table_name', 'structure')
            ->where('key2', 'organisasi')
            ->where('is_active', true)
            ->where('key1', $id)
            ->firstOrFail();

        // Get sections and members
        $sections = \App\Models\StructureSection::where('common_id', $structure->id)
            ->orderBy('order')
            ->get();
            
        foreach ($sections as $section) {
            $section->assigned_members = \App\Models\StructureMember::where('common_id', $structure->id)
                ->where('section_id', $section->id)
                ->where('is_active', true)
                ->orderBy('order')
                ->with('member')
                ->get();
        }

        $unassignedMembers = \App\Models\StructureMember::where('common_id', $structure->id)
            ->whereNull('section_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->with('member')
            ->get();

        return view('site.organisasi.show', compact('structure', 'sections', 'unassignedMembers'));
    }

    /**
     * Public Ekstrakurikuler Index
     */
    public function ekskulIndex(Request $request)
    {
        $structures = \App\Models\Common::where('table_name', 'structure')
            ->where('key2', 'ekskul')
            ->where('is_active', true)
            ->orderBy('data1', 'asc')
            ->get();

        return view('site.ekskul.index', compact('structures'));
    }

    /**
     * Public Ekstrakurikuler Show
     */
    public function ekskulShow($id)
    {
        $structure = \App\Models\Common::where('table_name', 'structure')
            ->where('key2', 'ekskul')
            ->where('is_active', true)
            ->where('key1', $id)
            ->firstOrFail();

        // Get sections and members
        $sections = \App\Models\StructureSection::where('common_id', $structure->id)
            ->orderBy('order')
            ->get();
            
        foreach ($sections as $section) {
            $section->assigned_members = \App\Models\StructureMember::where('common_id', $structure->id)
                ->where('section_id', $section->id)
                ->where('is_active', true)
                ->orderBy('order')
                ->with('member')
                ->get();
        }

        $unassignedMembers = \App\Models\StructureMember::where('common_id', $structure->id)
            ->whereNull('section_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->with('member')
            ->get();

        return view('site.ekskul.show', compact('structure', 'sections', 'unassignedMembers'));
    }

    /**
     * Jurusan Space — Listing all programs
     */
    public function jurusanIndex()
    {
        $programs = Program::where('is_active', true)->orderBy('order')->get();
        return view('site.jurusan.index', compact('programs'));
    }

    /**
     * Jurusan Space — Default / About page
     */
    public function jurusanSpace($kode)
    {
        $program = Program::where('is_active', true)
            ->where('kode', strtoupper($kode))
            ->firstOrFail();

        $jurusanMenu = \App\Models\Menu::with(['page', 'childrenRecursive.page'])
            ->where('location', 'jurusan_' . strtolower($kode))
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        // Recent news for this program
        $recentNews = News::where('status', 'published')
            ->where('jurusan_id', $program->id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Teachers in this program
        $teachers = \App\Models\Teacher::where('jurusan_id', $program->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->take(8)
            ->get();

        // Agenda / upcoming events for this program
        $agendaJurusan = Event::where('is_active', true)
            ->where('jurusan_id', $program->id)
            ->orderBy('start_datetime', 'asc')
            ->take(4)
            ->get();

        // Prestasi siswa for this program
        $prestasiJurusan = Achievement::where('is_active', true)
            ->where('jurusan_id', $program->id)
            ->where('type', 'siswa')
            ->orderBy('date', 'desc')
            ->take(6)
            ->get();

        // Project / karya siswa for this program (uses Common table)
        $projectJurusan = Common::where('table_name', 'karya_siswa')
            ->where('is_active', true)
            ->where('data3', $program->id)
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // Gallery albums for this program
        $galleryJurusan = Gallery::with('coverImage')
            ->where('jurusan_id', $program->id)
            ->latest()
            ->take(8)
            ->get();

        // Alumni with testimonials for this program
        $alumniJurusan = Alumni::where('is_active', true)
            ->where('jurusan_id', $program->id)
            ->whereNotNull('testimoni')
            ->where('testimoni', '!=', '')
            ->orderBy('order')
            ->take(6)
            ->get();

        return view('site.jurusan.space', compact(
            'program',
            'jurusanMenu',
            'recentNews',
            'teachers',
            'agendaJurusan',
            'prestasiJurusan',
            'projectJurusan',
            'galleryJurusan',
            'alumniJurusan',
        ));
    }

    /**
     * Jurusan Space — Specific page
     */
    public function jurusanSpacePage($kode, $pageSlug)
    {
        $program = Program::where('is_active', true)
            ->where('kode', strtoupper($kode))
            ->firstOrFail();

        $page = Page::where('slug', $pageSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $jurusanMenu = \App\Models\Menu::with(['page', 'childrenRecursive.page'])
            ->where('location', 'jurusan_' . strtolower($kode))
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('site.jurusan.space', compact('program', 'jurusanMenu', 'page'));
    }

    /**
     * Contact Info Page
     */
    public function kontakShow()
    {
        return view('site.contact.index');
    }
}
