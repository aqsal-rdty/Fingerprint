@extends('layouts.guru')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-secondary">
        <i class="bi bi-journal-check"></i> Rekap Kehadiran Saya
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="table-rekap" class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">Tanggal</th>
                            <th style="width:35%">Jam Datang</th>
                            <th style="width:20%">Jam Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($qw_hadir as $no => $row)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $row->tanggal }}</td>

                                <td>
                                    {{ $row->jam_datang }}

                                    @if($row->jam_datang <= $row->jam_terlambat)
                                        <span class="badge bg-success ms-1">Tepat</span>
                                    @else
                                        <span class="badge bg-danger ms-1">Telat</span>
                                    @endif
                                </td>

                                <td>{{ $row->jam_pulang }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted">Tidak ada data kehadiran</td>
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
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        language: {
            zeroRecords: "Tidak ada data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                next: "›",
                previous: "‹"
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
</style>
@endsection
