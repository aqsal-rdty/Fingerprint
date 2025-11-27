@extends('layouts.layoutguru')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/dataTables/css/dataTables.bootstrap.min.css') }}"/>

<div class="container-fluid mt-4">
    <h3 class="mb-2 text-secondary text-start">
        <i class="bi bi-calendar-check"></i> Rekap Absensi Guru
    </h3>
    <p class="text-secondary small ms-3 text-start">
        Fingerprint <i class="fa fa-angle-right mx-1"></i> Lihat Rekap Guru
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-header text-center fw-semibold bg-light">
            <h5 class="fw-bold text-secondary">DATA KEHADIRAN GURU</h5>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="history.back()" 
                    class="btn btn-primary d-flex align-items-center px-3 py-1 shadow-sm"
                    style="border-radius: 8px; font-size: 0.9rem;">
                    <i class="bi bi-arrow-left-short me-2"></i> Kembali
                </button>

                <form action="{{ url('excel/'.$nip_pegawai) }}" method="get">
                    <input type="hidden" name="from" value="{{ $from }}">
                    <input type="hidden" name="to" value="{{ $to }}">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </button>
                </form>
            </div>

            <form method="GET" action="{{ route('rekapkehadiran.lihat', $nip_pegawai) }}" class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table id="table-kehadiran" class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($qw_hadir as $print)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="text-start">{{ $print->nama }}</td>
                                <td>{{ $print->waktu }}</td>
                                <td>{{ $print->tanggal }}</td>
                                <td>
                                    @php
                                        $timeKeluar = strtotime('16:00:00');
                                        $waktu = strtotime($print->waktu);
                                        $jamTerlambat = $print->jam_terlambat ? strtotime($print->jam_terlambat) : strtotime('07:01:00');
                                        if ($waktu > $jamTerlambat && $waktu < $timeKeluar) {
                                            echo 'Telat';
                                            if ($print->keterangan) echo ' <small>('.$print->keterangan.')</small>';
                                        } elseif ($waktu <= $jamTerlambat) {
                                            echo 'Tepat';
                                        } else {
                                            echo 'Pulang';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(count($qw_hadir) == 0)
                    <div class="text-center text-muted mt-3">Tidak ada data kehadiran.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('asset/js/jquery.min.js') }}"></script>
<script src="{{ asset('asset/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table-kehadiran').DataTable({
            pageLength: 10,
            lengthChange: false,
            ordering: true,
            language: {
                search: "Cari:",
                zeroRecords: "Tidak ada data yang cocok",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                paginate: {
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>
@endsection