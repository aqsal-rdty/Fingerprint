<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
    

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session 'is_admin' ada
        if (!Session::get('is_admin')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}