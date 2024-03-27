<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Lpm\UserRole;
use App\User;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function dologin(Request $request) {
        // validasi
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {

            // buat ulang session login
            $request->session()->regenerate();

            if (auth()->user()->role_id === 1) {
                return redirect()->intended('/lpm');
            } elseif(auth()->user()->role_id === 2)  {
                return redirect()->intended('/auditor');
            } elseif(auth()->user()->role_id === 3)  {
                return redirect()->intended('/fakultas');
            } else {
                return redirect()->intended('/rektorat');
            }
        }

        // jika email atau password salah
        // kirimkan session error
        return back()->with('error', 'email atau password salah');
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();
        return redirect()->intended('/');
    }
}
