<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeteranganGuruController extends Controller
{
    public function index()
    {
        return view('Guru.keteranganguru');
    }
}
