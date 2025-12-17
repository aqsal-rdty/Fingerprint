@extends('layouts.guru')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-secondary"><i class="bi bi-journal-check"></i> Rekap Kehadiran Saya</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="table-rekap" class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th style="width:5%;">No</th>
                            <th class="text-start">Nama</th>
                            <th style="width:15%;">Waktu</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:15%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($qw_hadir as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="text-start">{{ $data->nama }}</td>
                                <td>{{ $data->waktu }}</td>
                                <td>{{ $data->tanggal }}</td>
                                <td>
                                    @php
                                        $timeKeluar = $data->jam_pulang ? strtotime($data->jam_pulang) : strtotime('16:00:00');
                                        $waktu = strtotime($data->waktu);
                                        $jamTerlambat = $data->jam_terlambat ? strtotime($data->jam_terlambat) : strtotime('07:01:00');

                                        if ($waktu > $jamTerlambat && $waktu < $timeKeluar) {
                                            echo 'Telat';
                                        } elseif ($waktu <= $jamTerlambat) {
                                            echo 'Tepat';
                                        } else {
                                            echo 'Pulang';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data kehadiran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#table-rekap').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false, // hapus search
        "ordering": true,
        "info": true,
        "language": {
            "zeroRecords": "Tidak ada data yang cocok",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data tersedia",
            "paginate": {
                "next": "›",
                "previous": "‹"
            }
        }
    });
});
</script>

<style>
    #table-rekap th, #table-rekap td {
        vertical-align: middle !important;
        padding: 10px;
    }
    #table-rekap tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
    #table-rekap th {
        text-align: center;
    }
</style>
@endsection