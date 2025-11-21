@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3 class="mb-3" style="color: #6c757d;">
        <i class="bi bi-fingerprint"></i> Data Mesin Fingerprint Guru
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Fingerprint > <span class="fa-angle-right fa"></span> Guru
    </p>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Mesin Guru</h5>
            <div class="d-flex align-items-center gap-2">
                <input type="text" id="searchMesin" class="form-control form-control-sm" placeholder="Cari mesin...">
                <a href="{{ route('fingerprintguru_create') }}" class="btn btn-primary btn-circle" title="Tambah Mesin Guru">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered align-middle" id="tableMesin">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>IP Address</th>
                        <th>Comkey</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $value)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $value->ip }}</td>
                            <td>{{ $value->comkey }}</td>
                            <td class="text-center">
                                <span class="badge {{ $value->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $value->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($value->status == 1)
                                    <a href="{{ route('fingerprintguru_deactive', ['id' => $value->id]) }}" 
                                    class="btn btn-outline-warning btn-sm" title="Non Aktifkan">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @else
                                    <a href="{{ route('fingerprintguru_active', ['id' => $value->id]) }}" 
                                    class="btn btn-outline-success btn-sm" title="Aktifkan">
                                        <i class="bi bi-check-circle"></i>
                                    </a>
                                @endif

                                <a href="{{ route('fingerprintguru_check', ['id' => $value->id]) }}" 
                                class="btn btn-outline-info btn-sm" title="Cek Koneksi">
                                    <i class="bi bi-wifi"></i>
                                </a>

                                <a href="{{ route('fingerprintguru_edit', ['id' => $value->id]) }}" 
                                class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="{{ route('fingerprintguru_delete', ['id' => $value->id]) }}" 
                                class="btn btn-outline-danger btn-sm" title="Hapus"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data mesin guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<style>
    .btn-circle {
        width: 42px;
        height: 40px;
        border-radius: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 100px;
        color: #fff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.25s ease-in-out;
    }

    .btn-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 14px rgba(0, 123, 255, 0.4);
    }

    .alert {
        animation: fadeInDown 0.5s ease-in-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

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
        searchTable('searchMesin', 'tableMesin');
    });
</script>