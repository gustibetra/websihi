<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('elearning.profile', ['user' => Auth::guard('elearning')->user()]);
    }

    /**
 * ✅ Update foto profil — maks 5MB
 */
public function updatePhoto(Request $request)
{
    $request->validate([
        // ✅ 5120 KB = 5MB (sebelumnya 2048 = 2MB)
        'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
    ], [
        'photo.required'  => 'Pilih file foto terlebih dahulu.',
        'photo.image'     => 'File harus berupa gambar.',
        'photo.mimes'     => 'Format yang didukung: JPG, JPEG, PNG, WEBP.',
        'photo.max'       => 'Ukuran foto maksimal 5MB. File Anda terlalu besar.',
    ]);

    $user = auth('elearning')->user();

    // Hapus foto lama dari storage agar tidak menumpuk
    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
    }

    // Simpan foto baru dengan nama asli (dibersihkan)
    $ext  = $request->file('photo')->getClientOriginalExtension() ?: $request->file('photo')->guessExtension();
    $base = preg_replace('/[^A-Za-z0-9\-_]+/', '-', pathinfo($request->file('photo')->getClientOriginalName(), PATHINFO_FILENAME));
    $name = ($base !== '' ? $base : 'foto-' . $user->id) . '-' . now()->format('Ymd-His') . '.' . $ext;

    $user->update([
        'photo' => $request->file('photo')->storeAs('elearning/profiles', $name, 'public'),
    ]);

    return back()->with('success', 'Foto profil berhasil diperbarui! 📸');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::guard('elearning')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Password berhasil diubah.');
    }
}