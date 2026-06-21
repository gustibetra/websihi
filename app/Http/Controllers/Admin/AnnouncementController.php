<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __construct(
        private AnnouncementService $announcementService
    ) {}

    public function index()
    {
        return view('admin.announcements.index');
    }

    public function indexOld(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $result = $this->announcementService->getAll($search, $perPage);

        if ($result['success']) {
            return view('admin.announcements.index', [
                'announcements' => $result['data'],
                'search' => $search,
            ]);
        }

        return back()->with('error', $result['message']);
    }

    public function create()
    {
        $lookupService = app(\App\Services\LookupService::class);
        $categories = $lookupService->getCollection('kategori_pengumuman');
        $periods = $lookupService->getCollection('period');
        
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }
        
        return view('admin.announcements.create', compact('categories', 'periods', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:150|unique:announcement,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'nullable|exists:common,id',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'period' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_public'] = $request->has('is_public');
        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->announcementService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.announcements.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function show($id)
    {
        $result = $this->announcementService->getById($id);

        if ($result['success'] && auth()->user()->isAdminJurusan() && $result['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($result['success']) {
            return view('admin.announcements.show', ['announcement' => $result['data']]);
        }

        return redirect()->route('admin.announcements.index')->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->announcementService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.announcements.index')->with('error', $result['message']);
        }

        $announcement = $result['data'];
        if (auth()->user()->isAdminJurusan() && $announcement->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $lookupService = app(\App\Services\LookupService::class);
        $categories = $lookupService->getCollection('kategori_pengumuman');
        $periods = $lookupService->getCollection('period');
        
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'categories' => $categories,
            'periods' => $periods,
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:150|unique:announcement,slug,' . $id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'nullable|exists:common,id',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'period' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $resultGet = $this->announcementService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated['is_public'] = $request->has('is_public');
        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->announcementService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.announcements.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $resultGet = $this->announcementService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->announcementService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.announcements.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
