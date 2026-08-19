<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ✅ TAMBAHAN: Untuk menghapus file fisik

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Fallback single image
            'images' => 'nullable|array', // ✅ BARU: Multi-image
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // ✅ BARU
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

        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $this->processTags($validated['tags'] ?? null);

        // ✅ LOGIKA MULTI-FOTO (Sebelum dikirim ke Service)
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('news', 'public');
            }
            $validated['image'] = json_encode($imagePaths);
        } elseif ($request->hasFile('image')) {
            // Fallback jika user masih pakai input single image lama
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

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
            'images' => 'nullable|array', // ✅ BARU
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // ✅ BARU
            'remove_images' => 'nullable|array', // ✅ BARU: Array index foto yang dihapus
            'remove_images.*' => 'integer',
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

        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $this->processTags($validated['tags'] ?? null);

        // ✅ LOGIKA UPDATE MULTI-FOTO
        $news = $resultGet['data'];
        $existingPaths = $news->images ?? []; // Mengambil array dari accessor Model

        // 1. Hapus foto yang dicentang "Hapus" di form edit
        if ($request->has('remove_images')) {
            foreach ((array) $request->input('remove_images') as $idx) {
                if (isset($existingPaths[$idx])) {
                    Storage::disk('public')->delete($existingPaths[$idx]);
                    unset($existingPaths[$idx]);
                }
            }
            $existingPaths = array_values($existingPaths); // Re-index array
        }

        // 2. Tambahkan foto baru yang diupload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $existingPaths[] = $file->store('news', 'public');
            }
        } elseif ($request->hasFile('image')) {
            // Fallback single image
            $existingPaths[] = $request->file('image')->store('news', 'public');
        }

        // 3. Handle checkbox "Hapus Semua" (delete_image)
        if ($request->input('delete_image') == '1') {
            foreach ($existingPaths as $p) {
                Storage::disk('public')->delete($p);
            }
            $validated['image'] = null;
        } else {
            // Simpan kembali sebagai JSON
            $validated['image'] = !empty($existingPaths) ? json_encode($existingPaths) : null;
        }

        // Handle file deletion flag (PDF/DOC)
        if ($request->input('delete_file') == '1') {
            $validated['delete_file'] = true;
        }

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

        // ✅ BONUS: Hapus file fisik saat berita dihapus permanen
        $news = $resultGet['data'];
        if (!empty($news->images)) {
            foreach ($news->images as $path) {
                Storage::disk('public')->delete($path);
            }
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