<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('nip', 'asc')->get();
        return view('guru.data_guru', compact('guru'));
    }

    public function create()
    {
        return view('guru.createguru');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama' => 'required|string|max:255',
            'statuss' => 'required|string|max:50',
        ]);

        Guru::create($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($nip)
    {
        $guru = Guru::findOrFail($nip);
        return view('guru.editguru', compact('guru'));
    }

    public function update(Request $request, $nip)
    {
        $guru = Guru::findOrFail($nip);

        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $guru->nip . ',nip',
            'nama' => 'required|string|max:255',
            'statuss' => 'required|in:0,1',
        ]);

        $guru->nip = $request->input('nip');
        $guru->nama = $request->input('nama');
        $guru->statuss = $request->input('statuss');
        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function dashboard()
    {
        $guru = Guru::all();
        $today = date('Y-m-d');

        $kehadiran = DB::table('kehadiranguru')
            ->join('guru', 'kehadiranguru.nip', '=', 'guru.nip')
            ->select('kehadiranguru.*', 'guru.nama')
            ->whereDate('kehadiranguru.tanggal', $today)
            ->get();

        return view('Guru.index', compact('guru', 'kehadiran'));
    }

    public function rekapSemua(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $qw_hadir = collect();

        if ($from && $to) {
            $qw_hadir = DB::table('kehadiranguru')
                ->join('guru', 'guru.nip', '=', 'kehadiranguru.nip')
                ->select('guru.nama', 'kehadiranguru.tanggal', 'kehadiranguru.waktu')
                ->whereBetween('kehadiranguru.tanggal', [$from, $to])
                ->orderBy('kehadiranguru.tanggal', 'desc')
                ->get();
        }

        return view('Guru.detail_rekapsemua', compact('qw_hadir', 'from', 'to'));
    }

}