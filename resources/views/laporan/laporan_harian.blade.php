@extends('layouts.app')

@section('content')
@php
use App\Models\Kehadiran;
use App\Models\Ketidakhadiran;
@endphp

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="text-secondary">
                <i class="bi bi-clipboard-check"></i> Laporan Harian
            </h3>
            <p class="text-muted" style="font-size: 14px;">
                Fingerprint > <span class="fa fa-angle-right"></span> Laporan Harian
            </p>
        </div>
        <div>
            <form method="post" action="/print_harian/{{ $rombel }}/{{ $tanggal }}" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-success">
                    <i class="bi bi-printer-fill"></i> Print
                </button>
            </form>
            <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i> Data Kehadiran Tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-laporan" class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 70px;">NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Rombel</th>
                            <th>Rayon</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $r)
                            @php
                                $hadir = Kehadiran::where('nis', $r->nis)->where('tanggal', $tanggal)->count();
                                $tidakhadir_count = Ketidakhadiran::where('nis', $r->nis)->where('tanggal', $tanggal)->count();
                            @endphp

                            @if ($hadir > 0)
                                <tr>
                                    <td>{{ $r->nis }}</td>
                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->jk }}</td>
                                    <td>{{ $r->rombel }}</td>
                                    <td>{{ $r->nama_rayon }}</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                </tr>
                            @elseif ($tidakhadir_count > 0)
                                @php
                                    $tidakhadir = Ketidakhadiran::where('nis', $r->nis)->where('tanggal', $tanggal)->first();
                                @endphp
                                <tr>
                                    <td>{{ $r->nis }}</td>
                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->jk }}</td>
                                    <td>{{ $r->rombel }}</td>
                                    <td>{{ $r->nama_rayon }}</td>
                                    <td><span class="badge bg-danger">{{ ucfirst($tidakhadir->keterangan) }}</span></td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $r->nis }}</td>
                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->jk }}</td>
                                    <td>{{ $r->rombel }}</td>
                                    <td>{{ $r->nama_rayon }}</td>
                                    <td><span class="badge bg-secondary">Belum diinput</span></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('asset_footer')
<script src="{{ url('asset/js/plugins/jquery.datatables.min.js') }}"></script>
<script src="{{ url('asset/js/plugins/datatables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable-laporan').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "zeroRecords": "Tidak ada data yang cocok."
            },
            "pageLength": 10,
            "order": []
        });
    });
</script>
@endsection

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }
    table th, table td {
        font-size: 14px;
    }
    table th {
        background-color: #e9f3ff !important;
    }
</style>