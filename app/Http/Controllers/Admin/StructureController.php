<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    /**
     * Display structure management page
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        if (!$type) {
            $type = auth()->user()->isAdminJurusan() ? 'organisasi' : 'sekolah';
        }
        
        if (auth()->user()->isAdminJurusan()) {
            if (in_array($type, ['sekolah', 'yayasan'])) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        return view('admin.structure.index', [
            'type' => $type
        ]);
    }
    
    /**
     * Display members management page for specific structure
     */
    public function members($id)
    {
        $structure = \App\Models\Common::where('table_name', 'structure')->findOrFail($id);
        
        if (auth()->user()->isAdminJurusan()) {
            // Check type
            if (in_array($structure->data5, ['sekolah', 'yayasan'])) {
                abort(403, 'Unauthorized action.');
            }
            // Check jurusan
            if ($structure->data3 != auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        return view('admin.structure.members', [
            'structureId' => $id
        ]);
    }
}

