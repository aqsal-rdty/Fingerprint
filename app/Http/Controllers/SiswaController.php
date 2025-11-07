<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['rayon', 'rombel', 'jurusan'])->orderBy('nis', 'asc')->get();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('master.index', compact('siswa', 'rayon', 'rombel', 'jurusan'));
    }

    public function create()
    {
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        $last = Siswa::orderBy('nis', 'desc')->first();
        if ($last) {
            $num = (int) substr($last->nis, 2);
            $new = 'S' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new = 'S0001';
        }

        while (Siswa::where('nis', $new)->exists()) {
            $num++;
            $new = 'S' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        }

        return view('master.createsiswa', compact('new', 'rayon', 'rombel', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'alamat' => 'required',
            'id_rayon' => 'required|exists:rayon,id_rayon',
            'id_rombel' => 'required|exists:rombel,id_rombel',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jk' => $request->jk,
            'alamat' => $request->alamat,
            'id_rayon' => $request->id_rayon,
            'id_rombel' => $request->id_rombel,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $rayon = Rayon::orderBy('id_rayon', 'asc')->get();
        $rombel = Rombel::orderBy('id_rombel', 'asc')->get();
        $jurusan = Jurusan::orderBy('id_jurusan', 'asc')->get();

        return view('master.editsiswa', compact('siswa', 'rayon', 'rombel', 'jurusan'));
    }

    public function update(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'alamat' => 'required',
            'id_rayon' => 'required|exists:rayon,id_rayon',
            'id_rombel' => 'required|exists:rombel,id_rombel',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jk' => $request->jk,
            'alamat' => $request->alamat,
            'id_rayon' => $request->id_rayon,
            'id_rombel' => $request->id_rombel,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }
    public function destroy($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
