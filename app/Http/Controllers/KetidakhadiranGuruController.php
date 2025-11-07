<?php

namespace App\Http\Controllers;

use App\Models\KetidakhadiranGuru;
use Illuminate\Http\Request;

class KetidakhadiranGuruController extends Controller
{
    public function index()
    {
        $ketidakhadiran = KetidakhadiranGuru::orderBy('tanggal', 'desc')->get();
        return view('ketidakhadiranguru.index', compact('ketidakhadiran'));
    }
}
