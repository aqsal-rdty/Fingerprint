@extends('layouts.layoutguru')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-3 text-secondary">
        <i class="bi bi-journal-check"></i> Detail Rekap Kehadiran Semua Guru
    </h3>
    <p class="text-secondary small ms-3">
        Fingerprint > <i class="fa fa-angle-right"></i> Detail Rekap Kehadiran Semua Guru
    </p>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form method="GET" action="{{ route('guru.detail_rekapsemua') }}" class="row g-3 align-items-end mb-4">
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

            @if($from && $to)
                <div class="table-responsive">
                    <table id="table-user" class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th class="text-start">Nama</th>
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
            @else
                <div class="text-center text-muted mt-4">
                    <i class="bi bi-calendar-range fs-1 d-block mb-2"></i>
                    Silakan pilih rentang tanggal terlebih dahulu untuk menampilkan data.
                </div>
            @endif

        </div>
    </div>
</div>

<script src="{{ asset('asset/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table-user').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "language": {
                "search": "Cari:",
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
@endsection