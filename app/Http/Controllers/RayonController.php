<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\siswa;
use App\Models\Guru;

class RayonController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['rayon', 'rombel', 'jurusan'])->get();
        $rayon = Rayon::with('pembimbing')->orderBy('id_rayon', 'asc')->get();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('Master.index', compact('siswa', 'rayon', 'rombel', 'jurusan'));
    }

    public function create()
    {
        $last = Rayon::orderBy('id_rayon', 'desc')->first();
        $new = $last ? 'R' . str_pad((int) substr($last->id_rayon, 1) + 1, 4, '0', STR_PAD_LEFT) : 'R0001';
        $guru = Guru::all();

        return view('master.createrayon', compact('new', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rayon' => 'required|unique:rayon,id_rayon',
            'nama_rayon' => 'required',
            'pembimbing_id' => 'nullable|exists:guru,nip',
            'nomor_ruangan' => 'nullable|string',
        ]);

        Rayon::create([
            'id_rayon' => $request->id_rayon,
            'nama_rayon' => $request->nama_rayon,
            'pembimbing_id' => $request->pembimbing_id,
            'nomor_ruangan' => $request->nomor_ruangan,
        ]);

        return redirect()->route('rayon.index')->with('success', 'Data Rayon berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rayon = Rayon::findOrFail($id);
        $guru = Guru::all();
        return view('master.editrayon', compact('rayon', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $rayon = Rayon::findOrFail($id);

        $request->validate([
            'nama_rayon' => 'required',
            'pembimbing_id' => 'nullable|exists:guru,nip',
            'nomor_ruangan' => 'nullable|string',
        ]);

        $rayon->update([
            'nama_rayon' => $request->nama_rayon,
            'pembimbing_id' => $request->pembimbing_id,
            'nomor_ruangan' => $request->nomor_ruangan,
        ]);

        return redirect()->route('rayon.index')->with('success', 'Data Rayon berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $rayon = Rayon::findOrFail($id);
        $rayon->delete();

        return redirect()->route('rayon.index')->with('success', 'Data Rayon berhasil dihapus!');
    }
}