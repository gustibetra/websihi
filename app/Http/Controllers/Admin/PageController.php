<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        private PageService $pageService
    ) {}

    public function index()
    {
        return view('admin.pages.index');
    }

    public function create()
    {
        $lookupService = app(\App\Services\LookupService::class);
        $periods = $lookupService->getPeriods();
        
        // Get all active structures with period relation
        $structuresQuery = \App\Models\Common::where('table_name', 'structure')
            ->where('is_active', true);
        
        if (auth()->user()->isAdminJurusan()) {
            $structuresQuery->where('data3', auth()->user()->jurusan_id)
                ->whereIn('data5', ['organisasi', 'ekskul', 'kepanitiaan']);
        }
        
        $structures = $structuresQuery->with(['period' => function($query) {
                $query->select('id', 'data1'); // data1 is period name like "2024-2029"
            }])
            ->orderBy('data1')
            ->get();
        
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }
        
        return view('admin.pages.form', compact('periods', 'structures', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:150|unique:pages,slug',
            'subtitle' => 'nullable|string|max:255',
            'page_type' => 'required|in:page,structure',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'structure_common_id' => 'nullable|exists:common,id',
            'structure_type' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Validate structure fields
        if ($request->page_type === 'structure') {
            if (empty($request->structure_type)) {
                return back()->withInput()->withErrors(['structure_type' => 'Tipe struktur wajib dipilih untuk tipe halaman Structure']);
            }
            
            // If "show all" is not checked, structure_common_id is required
            if (!$request->has('show_all_structures') && empty($request->structure_common_id)) {
                return back()->withInput()->withErrors(['structure_common_id' => 'Pilih struktur spesifik atau centang "Tampilkan Semua Struktur"']);
            }
            
            // If "show all" is checked, clear structure_common_id
            if ($request->has('show_all_structures')) {
                $validated['structure_common_id'] = null;
            }
        } else {
            // Clear structure fields if not structure type
            $validated['structure_type'] = null;
            $validated['structure_common_id'] = null;
        }

        $validated['is_public'] = $request->has('is_public');
        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->pageService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.pages.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->pageService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.pages.index')->with('error', $result['message']);
        }

        $page = $result['data'];
        if (auth()->user()->isAdminJurusan() && $page->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $lookupService = app(\App\Services\LookupService::class);
        $periods = $lookupService->getPeriods();
        
        // Get all active structures with period relation
        $structuresQuery = \App\Models\Common::where('table_name', 'structure')
            ->where('is_active', true);
            
        if (auth()->user()->isAdminJurusan()) {
            $structuresQuery->where('data3', auth()->user()->jurusan_id)
                ->whereIn('data5', ['organisasi', 'ekskul', 'kepanitiaan']);
        }
        
        $structures = $structuresQuery->with(['period' => function($query) {
                $query->select('id', 'data1'); // data1 is period name like "2024-2029"
            }])
            ->orderBy('data1')
            ->get();

        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.pages.form', [
            'page' => $page,
            'periods' => $periods,
            'structures' => $structures,
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:150|unique:pages,slug,' . $id,
            'subtitle' => 'nullable|string|max:255',
            'page_type' => 'required|in:page,structure',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'structure_common_id' => 'nullable|exists:common,id',
            'structure_type' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Validate structure fields
        if ($request->page_type === 'structure') {
            if (empty($request->structure_type)) {
                return back()->withInput()->withErrors(['structure_type' => 'Tipe struktur wajib dipilih untuk tipe halaman Structure']);
            }
            
            // If "show all" is not checked, structure_common_id is required
            if (!$request->has('show_all_structures') && empty($request->structure_common_id)) {
                return back()->withInput()->withErrors(['structure_common_id' => 'Pilih struktur spesifik atau centang "Tampilkan Semua Struktur"']);
            }
            
            // If "show all" is checked, clear structure_common_id
            if ($request->has('show_all_structures')) {
                $validated['structure_common_id'] = null;
            }
        } else {
            // Clear structure fields if not structure type
            $validated['structure_type'] = null;
            $validated['structure_common_id'] = null;
        }

        $resultGet = $this->pageService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated['is_public'] = $request->has('is_public');
        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->pageService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.pages.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $resultGet = $this->pageService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->pageService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.pages.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
    
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pages/images', $filename, 'public');
            
            $url = asset('storage/' . $path);
            
            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }
        
        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'No file uploaded']
        ], 400);
    }
}
