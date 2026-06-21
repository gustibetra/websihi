<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransparencyService;
use Illuminate\Http\Request;

class TransparencyController extends Controller
{
    public function __construct(
        private TransparencyService $transparencyService
    ) {}

    public function index(Request $request)
    {
        $type = $request->get('type');
        $year = $request->get('year');
        $perPage = $request->get('per_page', 15);

        $result = $this->transparencyService->getAll($type, $year, $perPage);

        if ($result['success']) {
            return view('admin.transparency.index', [
                'transparency' => $result['data'],
                'type' => $type,
                'year' => $year,
            ]);
        }

        return back()->with('error', $result['message']);
    }

    public function create()
    {
        return view('admin.transparency.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:anggaran,kinerja',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'year' => 'nullable|integer|min:2000|max:2100',
            'period' => 'nullable|string|max:50',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;

        $result = $this->transparencyService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.transparency.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function show($id)
    {
        $result = $this->transparencyService->getById($id);

        if ($result['success']) {
            return view('admin.transparency.show', ['transparency' => $result['data']]);
        }

        return redirect()->route('admin.transparency.index')->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->transparencyService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.transparency.index')->with('error', $result['message']);
        }

        return view('admin.transparency.edit', ['transparency' => $result['data']]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:anggaran,kinerja',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'year' => 'nullable|integer|min:2000|max:2100',
            'period' => 'nullable|string|max:50',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['updated_by'] = auth()->id() ?? 1;

        $result = $this->transparencyService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.transparency.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $result = $this->transparencyService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.transparency.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
