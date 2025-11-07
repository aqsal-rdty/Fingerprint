<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\siswa;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['rayon', 'rombel', 'jurusan'])->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();

        return view('Master.index', compact('siswa', 'jurusan', 'rayon', 'rombel'));
    }

    public function create()
    {
        $last = Jurusan::orderBy('id_jurusan', 'desc')->first();

        if ($last) {
            $num = (int) substr($last->id_jurusan, 1);
            $new = 'J' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new = 'J0001';
        }

        while (Jurusan::where('id_jurusan', $new)->exists()) {
            $num++;
            $new = 'J' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        }

        return view('master.createjurusan', compact('new'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jurusan' => 'required|unique:jurusan,id_jurusan',
            'nama_jurusan' => 'required',
        ]);

        Jurusan::create([
            'id_jurusan' => $request->id_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Data Jurusan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('master.editjurusan', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Data Jurusan berhasil diperbarui!');
    }

}
