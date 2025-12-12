<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapGuruExport;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('nama', 'asc')->get();
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
            'no_wa' => 'required|string|max:20'
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
            'no_wa' => 'nullable|string|max:20'
        ]);

        $guru->nip = $request->input('nip');
        $guru->nama = $request->input('nama');
        $guru->statuss = $request->input('statuss');
        $guru->no_wa = $request->input('no_wa');
        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($nip)
    {
        $guru = Guru::findOrFail($nip);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
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
                ->leftJoin('seting_keterlambatan', 'seting_keterlambatan.nip', '=', 'guru.nip')
                ->select('guru.nama', 'kehadiranguru.tanggal', 'kehadiranguru.waktu', 'seting_keterlambatan.jam_terlambat', 'seting_keterlambatan.jam_pulang')
                ->whereBetween('kehadiranguru.tanggal', [$from, $to])
                ->orderBy('kehadiranguru.tanggal', 'desc')
                ->get();
        }

        return view('Guru.detail_rekapsemua', compact('qw_hadir', 'from', 'to'));
    }

    public function rekapAbsensi()
    {
        $guru = Guru::orderBy('nama', 'asc')->get();

        return view('Guru.rekapabsen', compact('guru'));
    }

    public function LihatRekap($nip, Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $query = DB::table('kehadiranguru')
            ->join('guru', 'kehadiranguru.nip', '=', 'guru.nip')
            ->leftJoin('keterlambatan', function ($join) {
                $join->on('kehadiranguru.tanggal', '=', 'keterlambatan.tanggal')
                    ->on('kehadiranguru.nip', '=', 'keterlambatan.nip');
            })
            ->leftJoin('seting_keterlambatan', 'seting_keterlambatan.nip', '=', 'guru.nip')
            ->select('kehadiranguru.*', 'guru.nama', 'keterlambatan.keterangan', 'seting_keterlambatan.jam_terlambat', 'seting_keterlambatan.jam_pulang')
            ->where('kehadiranguru.nip', $nip)
            ->orderBy('kehadiranguru.tanggal', 'desc');

        if ($from && $to) {
            $query->whereBetween('kehadiranguru.tanggal', [$from, $to]);
        }

        $qw_hadir = $query->get();

        return view('Guru.lihat_rekap', [
            'qw_hadir' => $qw_hadir,
            'nip_pegawai' => $nip,
            'from' => $from ?? '',
            'to' => $to ?? ''
        ]);
    }

    public function exportExcel($nip_pegawai, Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        return Excel::download(new RekapGuruExport($nip_pegawai, $from, $to), 'Rekap_Absensi_Guru_'.$nip_pegawai.'.xlsx');
    }
    public function keterangan()
    {
        $tanggalHariIni = date('Y-m-d');

        $hadir = DB::table('kehadiranguru')
            ->where('tanggal', $tanggalHariIni)
            ->pluck('nip')
            ->toArray();

        $tidakhadir = DB::table('guru')
            ->whereNotIn('guru.nip', $hadir)
            ->leftJoin('keterangan_guru', function($join) use ($tanggalHariIni) {
                $join->on('guru.nip', '=', 'keterangan_guru.nip')
                    ->where('keterangan_guru.tanggal', '=', $tanggalHariIni);
                })
            ->select('guru.nip', 'guru.nama', 'keterangan_guru.keterangan')
            ->get();

        return view('keterangan.keteranganguru', compact('tidakhadir'));
    }
    public function updateketerangan(Request $request, $nip)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'cuti_detail' => 'nullable|string|max:255'
        ]);

        $ket = $request->keterangan;

        if ($ket === 'Cuti') {
            $ket = 'Cuti - ' . $request->cuti_detail;
        }

        DB::table('keterangan_guru')->updateOrInsert(
            [
                'nip' => $nip,
                'tanggal' => date('Y-m-d')
            ],
            [
                'keterangan' => $ket,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Keterangan berhasil diperbarui.');
    }

    public function semuaKeterangan()
    {
        $data = DB::table('keterangan_guru')
            ->join('guru', 'guru.nip', '=', 'keterangan_guru.nip')
            ->select('guru.nip', 'guru.nama', 'keterangan_guru.keterangan', 'keterangan_guru.tanggal')
            ->orderBy('keterangan_guru.tanggal', 'desc')
            ->orderBy('guru.nama', 'asc')
            ->get();

        return view('keterangan.semua_keterangan', compact('data'));
    }

    public function kehadiran(Request $request)
    {
        $from = $request->from ?? date('Y-m-d');
        $to   = $request->to   ?? date('Y-m-d');

        $query = DB::table('kehadiranguru')
            ->join('guru', 'guru.nip', '=', 'kehadiranguru.nip')
            ->leftJoin('seting_keterlambatan', 'seting_keterlambatan.nip', '=', 'guru.nip')
            ->select('guru.nama', 'kehadiranguru.waktu', 'kehadiranguru.tanggal', 'seting_keterlambatan.jam_terlambat', 'seting_keterlambatan.jam_pulang')
            ->orderBy('kehadiranguru.tanggal', 'asc')
            ->whereBetween('kehadiranguru.tanggal', [$from, $to]);

        $qw_hadir = $query->get();

        return view('kehadiran.hadir', compact('from', 'to', 'qw_hadir'));
    }

}