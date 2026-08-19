<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use App\Models\ElearningUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('elearning')->check()) {
            return $this->redirectToDashboard();
        }
        return view('elearning.login');
    }

    /**
     * Login menggunakan NIP (staff) / NIM (mahasiswa)
     */
    public function login(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|string',
            'password'    => 'required|string|min:6',
        ], [
            'nomor_induk.required' => 'NIP / NIM wajib diisi.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 6 karakter.',
        ]);

        // Cari akun berdasarkan NIP/NIM
        $user = ElearningUser::where('nomor_induk', trim($request->nomor_induk))->first();

        if (!$user) {
            return back()->withInput($request->only('nomor_induk'))
                ->withErrors(['nomor_induk' => 'NIP/NIM tidak terdaftar. Silakan hubungi admin.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput($request->only('nomor_induk'))
                ->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        if (!$user->is_active) {
            return back()->withInput($request->only('nomor_induk'))
                ->withErrors(['nomor_induk' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.']);
        }

        Auth::guard('elearning')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    public function logout(Request $request)
    {
        Auth::guard('elearning')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('elearning.login')->with('success', 'Anda telah berhasil keluar.');
    }

    private function redirectToDashboard()
    {
        $user = Auth::guard('elearning')->user();
        return redirect()->route($user->role === 'staff' ? 'elearning.staff.dashboard' : 'elearning.mahasiswa.dashboard');
    }
}