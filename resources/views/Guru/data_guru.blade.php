@extends('layouts.app')

@section('content')
<div class="container mt-4">
        <h3 class="mb-3" style="color: #6c757d;">
            <i class="bi bi-person-badge"></i> Data Guru
        </h3>
        <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
            Fingerprint > <span class="fa-angle-right fa"></span> Data Guru
        </p>
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Guru</h5>
            <div class="d-flex align-items-center gap-2">
                <input type="text" id="searchGuru" class="form-control form-control-sm" placeholder="Cari guru...">
                <a href="{{ route('guru.create') }}" class="btn btn-primary btn-circle">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered align-middle" id="tableGuru">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>No WA</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guru as $index => $g)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $g->nip }}</td>
                            <td>{{ $g->nama }}</td>
                            <td>{{ $g->statuss }}</td>
                            <td>{{ $g->no_wa }}</td>
                            <td class="text-center">
                                <a href="{{ route('guru.edit', ['nip' => $g->nip]) }}" 
                                    class="btn btn-outline-primary btn-sm" 
                                    title="Edit Guru">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('guru.destroy', $g->nip) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data guru.</td>
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
<script>
    function searchTable(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        input.addEventListener('keyup', () => {
            const filter = input.value.toLowerCase();
            const rows = table.getElementsByTagName('tr');
            for (let i = 1; i < rows.length; i++) {
                const rowText = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowText.includes(filter) ? '' : 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        searchTable('searchGuru', 'tableGuru');
    });
</script>
@endsection