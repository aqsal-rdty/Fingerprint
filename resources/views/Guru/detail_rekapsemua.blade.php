@extends('layouts.layoutguru')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-3 text-secondary">
        <i class="bi bi-journal-check"></i> Detail Rekap Kehadiran Semua Guru
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th class="text-start">Nama</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($qw_hadir as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $row->nama }}</td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->jam_masuk }}</td>
                                <td>{{ $row->jam_pulang }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">
                                    Tidak ada data kehadiran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection