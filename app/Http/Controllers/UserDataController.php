<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\FingerprintGuru as FPG;
use App\Models\KehadiranGuru as GR;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Guru;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function __construct() {
        ini_set('max_execution_time', 0);
    }

   public function sinkronguru()
    {
        $fp = FPG::where('status', 1)->orderBy('ip')->get();

        if ($fp->isEmpty()) {
            Log::warning("Tidak ada mesin absensi aktif");
            return false;
        }

        $today = date('Y-m-d');

        foreach ($fp as $value) {
            try {
                $zk = new ZKTeco($value->ip);

                if ($zk->connect()) {
                    $logs = $zk->getAttendance();

                    foreach ($logs as $log) {
                        $nip = $log['id'];
                        $datetime = $log['timestamp'];
                        $tanggal = date('Y-m-d', strtotime($datetime));
                        $waktu = date('H:i:s', strtotime($datetime));

                        if ($tanggal != $today) continue;

                        $exists = GR::where('nip', $nip)
                            ->where('tanggal', $tanggal)
                            ->first();

                        if (!$exists) {
                            $absen = GR::create([
                                'nip'     => $nip,
                                'tanggal' => $tanggal,
                                'waktu'   => $waktu,
                                'status'  => 1,
                                'wa_sent' => false
                            ]);

                            // Ambil data guru
                            $guru = Guru::where('nip', $nip)->first();

                            if ($guru && $guru->no_wa) {

                                $nomor = $this->formatNomorWhatsApp($guru->no_wa);
                                $hari = $this->hariIndonesia(date('l', strtotime($tanggal)));
                                $tanggalPesan = $this->bulanIndonesia($tanggal);

                                $pesan = "📌 SMK WIKRAMA BOGOR
                                Hallo, {$guru->nama}.
                                Kehadiran Anda pada hari {$hari}, {$tanggalPesan} pukul {$waktu}.
                                Terima kasih.";

                                try {

                                    sleep(3);
                                    $this->kirimWA($nomor, $pesan);

                                    $absen->update(['wa_sent' => true]);

                                } catch (\Exception $e) {
                                    Log::error("WA Error: " . $e->getMessage());
                                }
                            }

                        }

                        else {
                            if ($waktu >= "16:00:00" && $exists->pulang == null) {
                                $exists->update([
                                    'pulang' => $waktu
                                ]);
                            }
                        }

                    }

                    $zk->disconnect();
                } else {
                    Log::error("Gagal terhubung ke mesin dengan IP: " . $value->ip);
                }

            } catch (\Exception $e) {
                Log::error("Error koneksi ke mesin {$value->ip}: " . $e->getMessage());
            }
        }

        return true;
    }

    public function indexguru()
    {
        $this->sinkronguru();

        $tanggal = date('Y-m-d');

        $absensi = Guru::join('kehadiranguru', 'kehadiranguru.nip', '=', 'guru.nip')
            ->where('kehadiranguru.tanggal', $tanggal)
            ->orderBy('guru.nama', 'asc')
            ->get();

        $tidakhadir = Guru::whereNotIn('guru.nip', function ($q) use ($tanggal) {
                $q->select('nip')
                    ->from('kehadiranguru')
                    ->where('tanggal', $tanggal);
            })
            ->leftJoin('keterangan_guru', function ($join) use ($tanggal) {
                $join->on('guru.nip', '=', 'keterangan_guru.nip')
                    ->where('keterangan_guru.tanggal', '=', $tanggal);
            })
            ->select('guru.nip', 'guru.nama', 'keterangan_guru.keterangan')
            ->orderBy('guru.nama', 'asc')
            ->get();

        return view('guru.index', compact('absensi', 'tidakhadir'));
    }

    public function refreshKehadiran()
    {
        $guru = Guru::orderBy('nama', 'asc')->get();
        $kehadiran = Guru::join('kehadiranguru', 'kehadiranguru.nip', '=', 'guru.nip')
            ->select('guru.nama', 'kehadiranguru.waktu', 'kehadiranguru.pulang', 'guru.nip')
            ->where('kehadiranguru.tanggal', date('Y-m-d'))
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json([
            'kehadiran' => $kehadiran,
            'guru' => $guru
        ]);
    }

    public function DetailRekapSemua(Request $request)
    {
      $dari = date('Y-m-d', strtotime($request->dari));
      $sampai = date('Y-m-d', strtotime($request->sampai));
      $request->session()->put('dari',$dari);
      $request->session()->put('sampai',$sampai);

      $qw_kehadiran = DB::table('qw_kehadiranguru')->where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->get()->all();
      return view('guru.detail_rekapsemua', ['qw_hadir' => $qw_kehadiran, 'from' => $dari, 'to' => $sampai]);
    }

    public function ListRKG(Request $request, $nip)
    {
      $nip_pegawai = $nip;
      $dari = date('Y-m-d', strtotime($request->dari));
      $sampai = date('Y-m-d', strtotime($request->sampai));
      $request->session()->put('tanggal1',$dari);
      $request->session()->put('tanggal2',$sampai);

      $qw_kehadiran = DB::table('qw_kehadiranguru')->where('nip', $nip)->where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->get();

      return view('guru.detail_rekap', ['qw_hadir' => $qw_kehadiran, 'from' => $dari, 'to' => $sampai, 'nip_pegawai' => $nip_pegawai]);
    }

    public function RekapKehadiranGuru()
    {
        $guru = Guru::get()->all();
        return view('guru.rekapabsen', ['guru' => $guru]);
    }

    public function gurutidakhadir()
    {
      $guru = Guru::where('status', '1')->get();
      $absensi = Guru::where('status', '1')->join('kehadiranguru','kehadiranguru.nip', '=', 'guru.nip')->orderBy('nama', 'asc')->get();
      $tidakhadir = Guru::where('status', '1')->join('ketidakhadiranguru','ketidakhadiranguru.nip', '=', 'guru.nip')->where('ketidakhadiranguru.tanggal', date('Y-m-d'))->get();
      
      return view('guru.tidakhadir')
      ->with('kehadiran', $absensi)
      ->with('guru', $guru)
      ->with('tidakhadir', $tidakhadir);
    }

    public function keterlambatan()
    {
        $date = date("Y-m-d");
        $time = '07:01:00';
        $convert = strtotime($time);
        $newTime = date('H:i:s', $convert);
        $time2 = '16:00:00';
        $convert2 = strtotime($time2);
        $backTime = date('H:i:s', $convert2);

        $guru = Guru::with('kehadiran', 'keterlambatan')->whereHas('kehadiran', function ($q) use($date, $newTime, $backTime) {
            $q->whereDate('tanggal', $date)->whereTime('waktu', '>', $newTime)->whereTime('waktu', '<', $backTime);
        })
        ->get();

        return view('guru.keterlambatan')->with('guru', $guru)->with('date', $date);
    }

    public function rekapBulan(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $kehadiran = GR::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $guru = Guru::all();

        $rekap = [];

        foreach ($guru as $g) {

            $absenGuru = $kehadiran->where('nip', $g->nip);

            $absenMasuk = $absenGuru->filter(function ($absen) {
                return strtotime($absen->waktu) < strtotime('12:00:00');
            });

            $totalTepat = $absenMasuk->filter(function ($absen) {
                return strtotime($absen->waktu) <= strtotime('07:00:00');
            })->count();

            $totalTelat = $absenMasuk->filter(function ($absen) {
                return strtotime($absen->waktu) > strtotime('07:00:00');
            })->count();

            $rekap[] = [
                'nama' => $g->nama,
                'total_tepat' => $totalTepat,
                'total_telat' => $totalTelat,
            ];
        }

        return view('guru.rekapbulan', compact('rekap', 'bulan', 'tahun'));
    }

    public function RekapSemua()
    {
      return view('guru.rekapsemua');
    }

    public function _checkExistsguru($pin, $tanggal, $status)
    {
      $userData = GR::where('nip', $pin)->where('tanggal', $tanggal)->where('status', '=', $status)->get();
      return $userData;
    }

    private function _ParseData($data, $p1, $p2)
    {
        $data = explode($p1, $data);
        if (count($data) > 1) {
            $data = explode($p2, $data[1]);
            return $data[0];
        }
        return '';
    }

    private function hariIndonesia($day)
    {
        $hari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];

        return $hari[$day] ?? $day;
    }

    private function bulanIndonesia($tanggal)
    {
        $bulanInggris = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $bln = date('F', strtotime($tanggal));
        $tgl = date('d', strtotime($tanggal));
        $thn = date('Y', strtotime($tanggal));

        return $tgl . ' ' . ($bulanInggris[$bln] ?? $bln) . ' ' . $thn;
    }

    private function formatNomorWhatsApp($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);
        if (substr($nomor, 0, 1) == '0') {
            $nomor = '62' . substr($nomor, 1);
        }
        if (substr($nomor, 0, 2) == '62') {
            return $nomor;
        }
        return '62' . $nomor;
    }

    private function kirimWA($nomor, $pesan)
    {
        $url = 'http://localhost:3000/send-message';
        $data = [
            'phoneNumber' => $nomor,
            'message' => $pesan
        ];

        try {
            Log::info("Mengirim pesan ke {$nomor}: {$pesan}");
            $response = Http::post($url, $data);

            if ($response->successful()) {
                Log::info("Pesan berhasil dikirim ke {$nomor}");
                return true;
            } else {
                Log::error("Gagal kirim. Status: ".$response->status());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error kirim WA: " . $e->getMessage());
            return false;
        }
    }

    // public function testKirimPesan($nomor)
    // {
    //     $nomor = $this->formatNomorWhatsApp($nomor);
    //     $pesan = "Hallo, Acep Rahmat.\nKehadiran Anda pada hari " . date('l') . ", " . date('d F Y') . " yaitu pukul 06:42:04.\nTerima kasih.";
    //     $result = $this->kirimPesanFonnte($nomor, $pesan);
    //     if ($result) {
    //         return "Pesan berhasil terkirim ke {$nomor}";
    //     } else {
    //         return "Pesan gagal terkirim ke {$nomor}";
    //     }
    // }
}