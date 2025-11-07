@extends('layouts.layoutguru')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-3 text-secondary text-start">
        <i class="bi bi-calendar-check"></i> Rekap Absensi Bulanan
    </h3>
    <p class="text-secondary small ms-3 text-start">
        Fingerprint > <i class="fa fa-angle-right"></i> Rekap Absensi Bulanan
    </p>

    <div class="card shadow-sm border-0">

        <div class="card-body">
            <form action="{{ route('guru.rekapbulanan') }}" method="GET" class="row g-3 align-items-end mb-4">
                <div class="col-md-3">
                    <label for="bulan" class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ (isset($bulan) && $i == $bulan) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tahun" class="form-label fw-semibold">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control"
                           value="{{ $tahun ?? date('Y') }}" min="2000" max="2050">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table id="table-rekap" class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th class="text-start">Nama Guru</th>
                            <th>Bulan</th>
                            <th>Tepat</th>
                            <th>Telat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($rekap) && count($rekap) > 0)
                            @foreach($rekap as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $r['nama'] ?? '-' }}</td>
                                    <td>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</td>
                                    <td>{{ $r['total_tepat'] ?? 0 }}</td>
                                    <td>{{ $r['total_telat'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted">Silakan pilih bulan dan tahun untuk menampilkan data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('asset/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table-rekap').DataTable({
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