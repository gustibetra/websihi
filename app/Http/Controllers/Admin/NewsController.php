<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        private NewsService $newsService
    ) {}

    /**
     * Display a listing of news
     */
    public function index()
    {
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new news
     */
    public function create()
    {
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }
        
        return view('admin.news.create', [
            'categories' => CommonHelper::getCategories(),
            'periods' => CommonHelper::getPeriods(),
            'jurusans' => $jurusans,
        ]);
    }

    /**
     * Store a newly created news
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'author' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'period' => 'nullable|string|max:50',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'source' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Add created_by (later from auth)
        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $this->processTags($validated['tags'] ?? null);

        $result = $this->newsService->create($validated);

        return $result['success']
            ? redirect()->route('admin.news.index')->with('success', $result['message'])
            : back()->withInput()->with('error', $result['message']);
    }

    /**
     * Display the specified news
     */
    public function show($id)
    {
        $result = $this->newsService->getById($id);

        if ($result['success'] && auth()->user()->isAdminJurusan() && $result['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        return $result['success']
            ? view('admin.news.show', ['news' => $result['data']])
            : redirect()->route('admin.news.index')->with('error', $result['message']);
    }

    /**
     * Show the form for editing the specified news
     */
    public function edit($id)
    {
        $result = $this->newsService->getById($id);

        if (!$result['success']) {
            return redirect()
                ->route('admin.news.index')
                ->with('error', $result['message']);
        }

        $news = $result['data'];
        if (auth()->user()->isAdminJurusan() && $news->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.news.edit', [
            'news' => $news,
            'categories' => CommonHelper::getCategories(),
            'periods' => CommonHelper::getPeriods(),
            'jurusans' => $jurusans,
        ]);
    }

    /**
     * Update the specified news
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $id,
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'author' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'period' => 'nullable|string|max:50',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'source' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'delete_image' => 'nullable|boolean',
            'delete_file' => 'nullable|boolean',
        ]);

        $resultGet = $this->newsService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        // Add updated_by
        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        // Handle image deletion flag
        if ($request->input('delete_image') == '1') {
            $validated['delete_image'] = true;
        }

        // Handle file deletion flag
        if ($request->input('delete_file') == '1') {
            $validated['delete_file'] = true;
        }

        $this->processTags($validated['tags'] ?? null);

        $result = $this->newsService->update($id, $validated);

        return $result['success']
            ? redirect()->route('admin.news.index')->with('success', $result['message'])
            : back()->withInput()->with('error', $result['message']);
    }

    /**
     * Remove the specified news
     */
    public function destroy($id)
    {
        $resultGet = $this->newsService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->newsService->delete($id);

        return $result['success']
            ? redirect()->route('admin.news.index')->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }

    /**
     * Upload image for CKEditor5 or FilePond
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('upload');
        $path = $file->store('news', 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'url' => $url,
            'path' => $path
        ]);
    }

    /**
     * Upload file attachment
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'filepond' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('filepond');
        $path = $file->store('news/files', 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'url' => $url,
            'path' => $path
        ]);
    }

    /**
     * Process comma separated tags and store new ones to common table
     */
    private function processTags(?string $tagsString): void
    {
        if (empty($tagsString)) {
            return;
        }

        $tagsArray = array_map('trim', explode(',', $tagsString));
        foreach ($tagsArray as $tagName) {
            if (!empty($tagName)) {
                $existing = \App\Models\Common::where('table_name', 'tag_konten')
                    ->where('data1', $tagName)
                    ->first();
                if (!$existing) {
                    $idGen = app(\App\Services\CommonIdGeneratorService::class);
                    $key = $idGen->generateId('tag_konten');
                    \App\Models\Common::create([
                        'table_name' => 'tag_konten',
                        'key1' => $key,
                        'data1' => $tagName,
                        'is_active' => true,
                        'created_by' => auth()->id() ?? 1,
                    ]);
                }
            }
        }
    }
}
