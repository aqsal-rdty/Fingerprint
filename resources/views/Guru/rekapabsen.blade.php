@extends('layouts.layoutguru')

@section('content')
<div class="container-fluid mt-4">

    <h3 class="mb-2 text-secondary text-start">
        <i class="bi bi-person-badge"></i> Rekap Absensi Guru
    </h3>
    <p class="text-secondary small ms-3 text-start">
        Fingerprint > <i class="fa fa-angle-right"></i> Rekap Absensi Guru
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="text-center mb-4">
                <h3 class="fw-bold text-secondary">DAFTAR GURU SMK WIKRAMA BOGOR</h3>
            </div>

            @if($guru->isEmpty())
                <div class="text-center text-muted my-5">
                    <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                    <span>Belum ada data guru.</span>
                </div>
            @else
                <div class="table-responsive">
                    <table id="table-guru" class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th class="text-start">Nama Guru</th>
                                <th style="width: 120px;">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru as $index => $print)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start">{{ $print->nama }}</td>
                                    <td>
                                        <a href="{{ url('rekapkehadiran/'.$print->nip) }}" 
                                           class="btn btn-sm btn-primary d-flex align-items-center justify-content-center gap-1 mx-auto"
                                           style="width: 90px;">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
<script src="{{ asset('asset/js/jquery.min.js') }}"></script>
<script src="{{ asset('asset/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table-guru').DataTable({
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