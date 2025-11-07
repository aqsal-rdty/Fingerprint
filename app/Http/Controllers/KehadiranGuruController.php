<?php

namespace App\Http\Controllers;

use App\Models\KehadiranGuru;
use Illuminate\Http\Request;

class KehadiranGuruController extends Controller
{
    public function index()
    {
        $kehadiran = KehadiranGuru::orderBy('tanggal', 'desc')->get();
        return view('kehadiranguru.index', compact('kehadiran'));
    }
}