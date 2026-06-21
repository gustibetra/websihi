<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GalleryService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $galleryService
    ) {}

    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryFilter = $request->get('category');
        $jurusanFilter = $request->get('jurusan');

        if (auth()->user()->isAdminJurusan()) {
            $jurusanFilter = auth()->user()->jurusan_id;
        }

        $result = $this->galleryService->getAll($search, 15, $categoryFilter, $jurusanFilter);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        $lookupService = app(\App\Services\LookupService::class);
        $categories = $lookupService->getCollection('kategori_galeri');
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.galleries.index', [
            'galleries' => $result['data'],
            'search' => $search,
            'categoryFilter' => $categoryFilter,
            'jurusanFilter' => $jurusanFilter,
            'categories' => $categories,
            'jurusans' => $jurusans,
        ]);
    }

    public function create()
    {
        $lookupService = app(\App\Services\LookupService::class);
        $categories = $lookupService->getCollection('kategori_galeri');
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.galleries.form', [
            'gallery' => null,
            'categories' => $categories,
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'nullable|string|max:150|unique:galleries,slug',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:common,id',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if (isset($validated['category_id']) && $validated['category_id'] == '') {
            $validated['category_id'] = null;
        }
        if (isset($validated['jurusan_id']) && $validated['jurusan_id'] == '') {
            $validated['jurusan_id'] = null;
        }

        $validated['upload_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->galleryService->create($validated);

        if ($result['success']) {
            return redirect()->route('admin.galleries.index')->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->galleryService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.galleries.index')->with('error', $result['message']);
        }

        $gallery = $result['data'];
        if (auth()->user()->isAdminJurusan() && $gallery->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $lookupService = app(\App\Services\LookupService::class);
        $categories = $lookupService->getCollection('kategori_galeri');
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('admin.galleries.form', [
            'gallery' => $gallery,
            'categories' => $categories,
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'slug' => 'nullable|string|max:150|unique:galleries,slug,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:common,id',
            'jurusan_id' => 'nullable|integer|exists:programs,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $resultGet = $this->galleryService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        if (array_key_exists('category_id', $validated) && $validated['category_id'] == '') {
            $validated['category_id'] = null;
        }
        if (array_key_exists('jurusan_id', $validated) && $validated['jurusan_id'] == '') {
            $validated['jurusan_id'] = null;
        }

        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->galleryService->update($id, $validated);

        if ($result['success']) {
            return redirect()->route('admin.galleries.edit', $id)->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $resultGet = $this->galleryService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->galleryService->delete($id);

        return $result['success']
            ? redirect()->route('admin.galleries.index')->with('success', $result['message'])
            : back()->with('error', $result['message']);
    }

    public function destroyImage($id)
    {
        $image = \App\Models\GalleryImage::with('gallery')->find($id);
        if ($image && $image->gallery && auth()->user()->isAdminJurusan() && $image->gallery->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->galleryService->deleteImage($id);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}