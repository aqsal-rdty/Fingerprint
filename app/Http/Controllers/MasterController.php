<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\Jurusan;

class MasterController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['rayon', 'rombel', 'jurusan'])->get();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('Master.index', compact('siswa', 'rayon', 'rombel', 'jurusan'));
    }
}