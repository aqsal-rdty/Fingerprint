<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\siswa;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['rayon', 'rombel', 'jurusan'])->get();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('Master.index', compact('siswa', 'rayon', 'rombel', 'jurusan'));
    }
    public function create()
    {
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        $last = Rombel::orderBy('id_rombel', 'desc')->first();

        if ($last) {
            $num = (int) substr($last->id_rombel, 2);
            $new = 'RB' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $new = 'RB001';
        }

        while (Rombel::where('id_rombel', $new)->exists()) {
            $num++;
            $new = 'RB' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('master.createrombel', compact('new', 'jurusan',));
    }

    public function store(Request $request)
    {
        $request->validate( [
            'id_rombel' => 'required|unique:rombel,id_rombel',
            'nama_rombel' => 'required',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ]);

        Rombel::create([
            'id_rombel' => $request->id_rombel,
            'nama_rombel' => $request->nama_rombel,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with('success', 'Data Rombel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rombel = Rombel::findOrFail($id);
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('master.editrombel', compact('rombel', 'jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rombel' => 'required',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ]);

        $rombel = Rombel::findOrFail($id);
        $rombel->update([
            'nama_rombel' => $request->nama_rombel,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with('success', 'Data Rombel berhasil diupdate!');
    }
    public function destroy($id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->delete();

        return redirect()->route('rombel.index')->with('success', 'Data Rombel berhasil dihapus!');
    }
}
