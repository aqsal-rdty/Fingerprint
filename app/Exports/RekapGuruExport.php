<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class RekapGuruExport implements FromView
{
    protected $nip_pegawai;
    protected $from;
    protected $to;

    public function __construct($nip_pegawai, $from = null, $to = null)
    {
        $this->nip_pegawai = $nip_pegawai;
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        $query = DB::table('kehadiranguru')
            ->join('guru', 'guru.nip', '=', 'kehadiranguru.nip')
            ->select('guru.nama', 'kehadiranguru.tanggal', 'kehadiranguru.waktu', 'kehadiranguru.status')
            ->where('kehadiranguru.nip', $this->nip_pegawai);

        if ($this->from && $this->to) {
            $query->whereBetween('kehadiranguru.tanggal', [$this->from, $this->to]);
        }

        $data = $query->orderBy('kehadiranguru.tanggal', 'asc')->get();

        return view('Guru.export_excel', [
            'data' => $data
        ]);
    }
}
