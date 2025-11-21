@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-secondary text-start">
        <i class="bi bi-list-check"></i> Semua Keterangan Guru
    </h3>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i> Riwayat Keterangan</h5>
        </div>

        <div class="card-body p-3">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($data as $d)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $d->nama }}</td>
                            <td class="text-center">{{ $d->keterangan }}</td>
                            <td class="text-center">{{ date('d M Y', strtotime($d->tanggal)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="bi bi-info-circle"></i> Belum ada data keterangan guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('keteranganguru.index') }}" class="btn btn-primary mt-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection