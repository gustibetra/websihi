<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function __construct(
        private CommonService $commonService
    ) {}

    /**
     * Display a listing of common data by table name
     */
    public function index(Request $request)
    {
        $tableName = $request->get('table_name', 'news_category');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $result = $this->commonService->getByTableName($tableName);

        if ($result['success']) {
            $data = $result['data'];
            
            // Apply search filter
            if ($search) {
                $data = $data->filter(function ($item) use ($search) {
                    return stripos($item->data1 ?? '', $search) !== false ||
                           stripos($item->key1 ?? '', $search) !== false;
                });
            }

            // Paginate manually
            $currentPage = $request->get('page', 1);
            $items = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $data->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('admin.commons.index', [
                'commons' => $paginated,
                'tableName' => $tableName,
                'search' => $search,
            ]);
        }

        return view('admin.commons.index', [
            'commons' => collect([]),
            'tableName' => $tableName,
            'search' => $search,
            'error' => $result['message'] ?? null,
        ]);
    }

    /**
     * Show the form for creating a new common data
     */
    public function create(Request $request)
    {
        $tableName = $request->get('table_name', 'news_category');
        return view('admin.commons.create', ['tableName' => $tableName]);
    }

    /**
     * Store a newly created common data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_name' => 'required|string|max:50',
            'key1' => 'nullable|string|max:100',
            'key2' => 'nullable|string|max:100',
            'key3' => 'nullable|string|max:100',
            'data1' => 'nullable|string|max:255',
            'data2' => 'nullable|string|max:255',
            'data3' => 'nullable|string|max:255',
            'data4' => 'nullable|string|max:255',
            'data5' => 'nullable|string|max:255',
            'data6' => 'nullable|string|max:255',
            'data7' => 'nullable|string|max:255',
            'data8' => 'nullable|string|max:255',
            'data9' => 'nullable|string|max:255',
            'data10' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;

        $result = $this->commonService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.commons.index', ['table_name' => $validated['table_name']])
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    /**
     * Display the specified common data
     */
    public function show($id)
    {
        $result = $this->commonService->getById($id);

        if ($result['success']) {
            return view('admin.commons.show', ['common' => $result['data']]);
        }

        return redirect()->route('admin.commons.index')->with('error', $result['message']);
    }

    /**
     * Show the form for editing the specified common data
     */
    public function edit($id)
    {
        $result = $this->commonService->getById($id);

        if ($result['success']) {
            return view('admin.commons.edit', ['common' => $result['data']]);
        }

        return redirect()->route('admin.commons.index')->with('error', $result['message']);
    }

    /**
     * Update the specified common data
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'table_name' => 'required|string|max:50',
            'key1' => 'nullable|string|max:100',
            'key2' => 'nullable|string|max:100',
            'key3' => 'nullable|string|max:100',
            'data1' => 'nullable|string|max:255',
            'data2' => 'nullable|string|max:255',
            'data3' => 'nullable|string|max:255',
            'data4' => 'nullable|string|max:255',
            'data5' => 'nullable|string|max:255',
            'data6' => 'nullable|string|max:255',
            'data7' => 'nullable|string|max:255',
            'data8' => 'nullable|string|max:255',
            'data9' => 'nullable|string|max:255',
            'data10' => 'nullable|string|max:255',
        ]);

        $validated['updated_by'] = auth()->id() ?? 1;

        $result = $this->commonService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.commons.index', ['table_name' => $validated['table_name']])
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    /**
     * Remove the specified common data
     */
    public function destroy($id)
    {
        // Get common data first to know table_name for redirect
        $result = $this->commonService->getById($id);
        $tableName = $result['success'] ? $result['data']->table_name : 'news_category';

        $deleteResult = $this->commonService->delete($id);

        if ($deleteResult['success']) {
            return redirect()
                ->route('admin.commons.index', ['table_name' => $tableName])
                ->with('success', $deleteResult['message']);
        }

        return redirect()
            ->route('admin.commons.index', ['table_name' => $tableName])
            ->with('error', $deleteResult['message']);
    }
}
