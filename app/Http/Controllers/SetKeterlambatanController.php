<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetKeterlambatanController extends Controller
{
    public function index() {
        $guru = DB::table('guru')->get();

        $seting = DB::table('seting_keterlambatan')
            ->join('guru', 'guru.nip', '=', 'seting_keterlambatan.nip')
            ->select('seting_keterlambatan.*', 'guru.nama')
            ->get();

        return view('setketerlambatan.seting', compact('guru', 'seting'));
    }

    public function store(Request $request) {
        $request->validate([
            'nip' => 'required',
            'jam_terlambat' => 'required',
        ]);

        $cek = DB::table('seting_keterlambatan')->where('nip', $request->nip)->first();

        if ($cek) {
            DB::table('seting_keterlambatan')->where('nip', $request->nip)->update([
                'jam_terlambat' => $request->jam_terlambat,
                'updated_at' => now()
            ]);
        } else {
            DB::table('seting_keterlambatan')->insert([
                'nip' => $request->nip,
                'jam_terlambat' => $request->jam_terlambat,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Seting keterlambatan berhasil disimpan!');
    }
}
