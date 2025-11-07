<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;

use App\Models\FingerprintMachine as FP;   

class FPController extends Controller
{
    public function index()
    {
        $fp = FP::orderBy('ip')->get();
        return view('fp.index', ['data' => $fp]);
    }

    public function create()
    {
        return view('fp.create');
    }

    public function store(Request $r,)
    {
        $fp = new FP;
        $fp->ip = $r->input('ip');
        $fp->comkey = $r->input('comkey');
        $fp->status = $r->input('status');
        $fp->lokasi = $r->input('lokasi');
        $fp->save();
        return redirect()->route('fingerprint_index');
    }

    public function edit($id)
    {
         $fingerprint = FP::findOrFail($id);
        return view('fp.edit', compact('fingerprint'));
    }

    public function update(Request $r, $id)
    {
        $fp = FP::findOrFail($id);
        $fp->ip = $r->input('ip');
        $fp->comkey = $r->input('comkey');
        $fp->status = $r->input('status');
        $fp->lokasi = $r->input('lokasi');
        $fp->save();
        return redirect()->route('fingerprint_index');
    }

    public function delete($id)
    {
        FP::find($id)->delete();
        return redirect()->route('fingerprint_index');
    }

    public function check_connection($id)
    {
        $mesin = FP::find($id);

        if (!$mesin) {
            return redirect()->route('fingerprint_index')
                ->with('error', 'Mesin tidak ditemukan!');
        }

        $IP = $mesin->ip;

        $connect = @fsockopen($IP, '80', $errno, $errstr, 1);

        if ($connect) {
            return "Mesin Terkoneksi! <br> <a href='" . route('fingerprint_index') . "'>Kembali</a>";
        } else {
            return "Mesin Tidak Terkoneksi! <br> <a href='" . route('fingerprint_index') . "'>Kembali</a>";
        }
    }

    public function active($id)
    {
        $mesin = FP::find($id);

        if (!$mesin) {
            return redirect()->route('fingerprintguru_index')
                ->with('error', 'Mesin tidak ditemukan!');
        }

        $mesin->status = 1;
        $mesin->save();

        return redirect()->route('fingerprintguru_index')
            ->with('success', 'Mesin berhasil diaktifkan.');
    }

    public function deactive($id)
    {
        $mesin = FP::find($id);

        if (!$mesin) {
            return redirect()->route('fingerprintguru_index')
                ->with('error', 'Mesin tidak ditemukan!');
        }

        $mesin->status = 0;
        $mesin->save();

        return redirect()->route('fingerprintguru_index')
            ->with('success', 'Mesin berhasil dinonaktifkan.');
    }
}