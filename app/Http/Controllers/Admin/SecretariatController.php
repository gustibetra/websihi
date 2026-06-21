<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SecretariatService;
use Illuminate\Http\Request;

class SecretariatController extends Controller
{
    public function __construct(
        private SecretariatService $secretariatService
    ) {}

    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $result = $this->secretariatService->getAll($search, $perPage);

        if ($result['success']) {
            return view('admin.secretariat.index', [
                'secretariat' => $result['data'],
                'search' => $search,
            ]);
        }

        return back()->with('error', $result['message']);
    }

    public function create()
    {
        return view('admin.secretariat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'position' => 'nullable|string|max:100',
            'division' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;

        $result = $this->secretariatService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.secretariat.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function show($id)
    {
        $result = $this->secretariatService->getById($id);

        if ($result['success']) {
            return view('admin.secretariat.show', ['secretariat' => $result['data']]);
        }

        return redirect()->route('admin.secretariat.index')->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->secretariatService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.secretariat.index')->with('error', $result['message']);
        }

        return view('admin.secretariat.edit', ['secretariat' => $result['data']]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'position' => 'nullable|string|max:100',
            'division' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['updated_by'] = auth()->id() ?? 1;

        $result = $this->secretariatService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.secretariat.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $result = $this->secretariatService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.secretariat.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
