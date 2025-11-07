<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\FingerprintGuru as FP;

class FPGController extends Controller
{
    public function index()
    {
      $fp = FP::orderBy('ip')->get();
      return view('fpg.index', ['data' => $fp]);
    }

    public function create()
    {
      return view('fpg.create');
    }

    public function store(Request $r)
    {
      $fp = new FP;
      $fp->ip = $r->input('ip');
      $fp->comkey = $r->input('comkey');
      $fp->status = $r->input('status');
      $fp->save();
      return redirect()->route('fingerprintguru_index');
    }

    public function edit($id)
    {
      $mesin = FP::find($id);
      return view('fpg.edit', ['data' => $mesin]);
    }

    public function update(Request $r)
    {
      $id = $r->input('id');
      $fp = FP::find($id);
      $fp->ip = $r->input('ip');
      $fp->comkey = $r->input('comkey');
      $fp->status = $r->input('status');
      $fp->save();
      return redirect()->route('fingerprintguru_index');
    }

    public function delete($id)
    {
      FP::find($id)->delete();
      return redirect()->route('fingerprintguru_index');
    }

    public function check_connection($id)
    {
      $mesin = FP::find($id);
      $IP = $mesin->ip;

      $connect = @fsockopen($IP, '4370', $errno, $errstr, 1);
      if ($connect) {
        return "Mesin terkoneksi! <br> <a href='" . route('fingerprintguru_index') . "'>Kembali</a>";
      } else {
        return "Mesin tidak terkoneksi! <br> <a href='" . route('fingerprintguru_index') . "'>Kembali</a>";
      }
    }

    public function active($id)
    {
      $mesin = FP::find($id);
      $mesin->status = 1;
      $mesin->save();
      return redirect()->route('fingerprintguru_index');
    }

    public function deactive($id)
    {
      $mesin = FP::find($id);
      $mesin->status = 0;
      $mesin->save();
      return redirect()->route('fingerprintguru_index');
    }
}
