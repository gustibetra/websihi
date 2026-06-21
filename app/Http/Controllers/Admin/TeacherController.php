<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(
        private TeacherService $teacherService
    ) {}

    /**
     * Display a listing of teachers
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);
        $jurusanId = null;
        if (auth()->user()->isAdminJurusan()) {
            $jurusanId = auth()->user()->jurusan_id;
        }

        $result = $this->teacherService->getAll($search, $perPage, $jurusanId);

        if ($result['success']) {
            return view('admin.teachers.index', [
                'teachers' => $result['data'],
                'search' => $search,
            ]);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created teacher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:male,female',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'nip' => 'nullable|string|max:30',
            'jenis' => 'required|in:guru,tendik',
            'jabatan' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:150',
            'pendidikan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,Honorer,GTT',
            'jurusan_id' => 'nullable|exists:programs,id',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->teacherService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', $result['message']);
        }

        return back()
            ->withInput()
            ->with('error', $result['message']);
    }

    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        $result = $this->teacherService->getById($id);

        if ($result['success'] && auth()->user()->isAdminJurusan() && $result['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($result['success']) {
            return view('admin.teachers.show', [
                'teacher' => $result['data'],
            ]);
        }

        return redirect()
            ->route('admin.teachers.index')
            ->with('error', $result['message']);
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit($id)
    {
        $result = $this->teacherService->getById($id);

        if (!$result['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('error', $result['message']);
        }

        $teacher = $result['data'];
        if (auth()->user()->isAdminJurusan() && $teacher->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.teachers.edit', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:male,female',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'nip' => 'nullable|string|max:30',
            'jenis' => 'required|in:guru,tendik',
            'jabatan' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:150',
            'pendidikan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'nullable|in:PNS,PPPK,Honorer,GTT',
            'jurusan_id' => 'nullable|exists:programs,id',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $resultGet = $this->teacherService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->teacherService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', $result['message']);
        }

        return back()
            ->withInput()
            ->with('error', $result['message']);
    }

    /**
     * Remove the specified teacher
     */
    public function destroy($id)
    {
        $resultGet = $this->teacherService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->teacherService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
