<?php

namespace App\Http\Controllers;

use App\Models\Keterlambatan;
use Illuminate\Http\Request;

class KeterlambatanController extends Controller
{
    public function index()
    {
        $keterlambatan = Keterlambatan::orderBy('tanggal', 'desc')->get();
        return view('keterlambatan.index', compact('keterlambatan'));
    }
}