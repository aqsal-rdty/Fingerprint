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
            'jam_pulang' => 'nullable',
        ]);

        $cek = DB::table('seting_keterlambatan')->where('nip', $request->nip)->first();
        $data = [
            'jam_terlambat' => $request->jam_terlambat,
            'jam_pulang' => $request->jam_pulang,
            'updated_at' => now()
        ];

        if ($cek) {
            DB::table('seting_keterlambatan')->where('nip', $request->nip)->update($data);
        } else {
            $data['nip'] = $request->nip;
            $data['created_at'] = now();
            DB::table('seting_keterlambatan')->insert($data);
        }

        return back()->with('success', 'Seting keterlambatan dan jam pulang berhasil disimpan!');
    }

}