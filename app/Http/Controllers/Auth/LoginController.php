<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // Cek kredensial admin manual (bisa diubah sesuai kebutuhan)
        if ($username === 'admin' && $password === 'admin123') {
            Session::put('is_admin', true);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Session::forget('is_admin');
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}