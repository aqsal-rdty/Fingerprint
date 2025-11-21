@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-secondary text-start">
        <i class="bi bi-info-circle"></i> Keterangan Guru
    </h3>
    <p class="text-secondary small ms-1 text-start">
        Fingerprint > <i class="fa fa-angle-right"></i> Keterangan Guru ({{ date('d M Y') }})
    </p>

    <a href="{{ route('keteranganguru.semua') }}" class="btn btn-primary">
        <i class="bi bi-list-check me-1"></i> Lihat Semua Keterangan
    </a>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i> Daftar Guru yang Belum Hadir</h5>
        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Guru</th>
                        <th style="width:150px;">Keterangan</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($tidakhadir as $t)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $t->nama }}</td>
                            <td class="text-center">
                                {{ $t->keterangan ?? '-' }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('keteranganguru.update', $t->nip) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')

                                    <select name="keterangan" class="form-select form-select-sm d-inline-block w-auto keteranganSelect" required>
                                        <option value="">Pilih</option>
                                        <option value="Sakit" {{ $t->keterangan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="Izin" {{ $t->keterangan == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Tugas" {{ $t->keterangan == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                        <option value="Cuti" {{ str_starts_with($t->keterangan, 'Cuti') ? 'selected' : '' }}>Cuti</option>
                                        <option value="Tanpa Keterangan" {{ $t->keterangan == 'Tanpa Keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                                    </select>

                                    <input type="text"
                                        name="cuti_detail"
                                        class="form-control form-control-sm cutiInput"
                                        placeholder="Cuti apa?"
                                        style="display:none; width:160px;"
                                        value="{{ str_starts_with($t->keterangan, 'Cuti -') ? trim(substr($t->keterangan, 6)) : '' }}">

                                    <button type="submit" class="btn btn-outline-primary btn-sm ms-1">
                                        <i class="bi bi-save"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="bi bi-check2-all me-1"></i> Semua guru sudah hadir
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("tr").forEach(row => {
        const select = row.querySelector(".keteranganSelect");
        const cutiInput = row.querySelector(".cutiInput");
        if (!select || !cutiInput) return;

        if (select.value === "Cuti") {
            cutiInput.style.display = "block";
            cutiInput.required = true;
        }

        select.addEventListener("change", () => {
            if (select.value === "Cuti") {
                cutiInput.style.display = "block";
                cutiInput.required = true;
            } else {
                cutiInput.style.display = "none";
                cutiInput.required = false;
                cutiInput.value = "";
            }
        });
    });
});
</script>
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