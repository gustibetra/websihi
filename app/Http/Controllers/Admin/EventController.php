<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(Request $request)
    {
        // Use Livewire component for agenda management
        return view('admin.agendas.index');
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'nullable|string|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'speaker' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->eventService->create($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.events.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function show($id)
    {
        $result = $this->eventService->getById($id);

        if ($result['success'] && auth()->user()->isAdminJurusan() && $result['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($result['success']) {
            return view('admin.events.show', ['event' => $result['data']]);
        }

        return redirect()->route('admin.events.index')->with('error', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->eventService->getById($id);

        if (!$result['success']) {
            return redirect()->route('admin.events.index')->with('error', $result['message']);
        }

        $event = $result['data'];
        if (auth()->user()->isAdminJurusan() && $event->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'nullable|string|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'speaker' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:5120',
            'is_public' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $resultGet = $this->eventService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated['updated_by'] = auth()->id() ?? 1;
        if (auth()->user()->isAdminJurusan()) {
            $validated['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $result = $this->eventService->update($id, $validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.events.index')
                ->with('success', $result['message']);
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function destroy($id)
    {
        $resultGet = $this->eventService->getById($id);
        if ($resultGet['success'] && auth()->user()->isAdminJurusan() && $resultGet['data']->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403, 'Unauthorized action.');
        }

        $result = $this->eventService->delete($id);

        if ($result['success']) {
            return redirect()
                ->route('admin.events.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
