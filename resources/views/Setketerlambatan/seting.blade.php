@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-4 text-secondary">
        <i class="bi bi-clock-history"></i> Seting Keterlambatan Guru
    </h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('seting.keterlambatan.store') }}" method="POST">
                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Guru</label>
                        <select name="nip" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->nip }}">{{ $g->nama }} ({{ $g->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Maksimal Terlambat</label>
                        <input type="time" name="jam_terlambat" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jam Maksimal Pulang</label>
                        <input type="time" name="jam_pulang" class="form-control">
                    </div>

                </div>

                <div class="mt-3">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Simpan Seting
                    </button>
                </div>

            </form>

        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">

            <h5 class="mb-3 fw-bold">Data Seting Keterlambatan</h5>

            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Jam Keterlambatan</th>
                        <th>Jam Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($seting as $s)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->nip }}</td>
                        <td>{{ $s->jam_terlambat }}</td>
                        <td>{{ $s->jam_pulang ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session("success") }}',
    confirmButtonText: 'OK',
    confirmButtonColor: '#4da3ff'
});
</script>
@endif
@endsection