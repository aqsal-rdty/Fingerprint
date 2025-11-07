@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3 class="mb-3" style="color: #6c757d;"><i class="bi bi-database"></i> Master Data</h3>
    <p class="animated fadeInDown" style="color: #6c757d; font-size: 14px; margin-left: 37px;">Fingerprint > <span class="fa-angle-right fa"></span> Master Data</p>
    
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-4" id="masterTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa" type="button" role="tab">
                <i class="bi bi-person-fill"></i> Data Siswa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rayon-tab" data-bs-toggle="tab" data-bs-target="#rayon" type="button" role="tab">
                <i class="bi bi-geo-alt-fill"></i> Data Rayon
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rombel-tab" data-bs-toggle="tab" data-bs-target="#rombel" type="button" role="tab">
                <i class="bi bi-collection-fill"></i> Data Rombel
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="jurusan-tab" data-bs-toggle="tab" data-bs-target="#jurusan" type="button" role="tab">
                <i class="bi bi-mortarboard-fill"></i> Data Jurusan
            </button>
        </li>
    </ul>

    <div class="tab-content" id="masterTabsContent">
        <div class="tab-pane fade show active" id="siswa" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Siswa</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="searchSiswa" class="form-control form-control-sm" placeholder="Cari siswa...">
                        <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-circle">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle" id="tableSiswa">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>JK</th>
                                <th>Alamat</th>
                                <th>Jurusan</th>
                                <th>Rombel</th>
                                <th>Rayon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ $s->tempat_lahir }}</td>
                                    <td>{{ $s->tanggal_lahir }}</td>
                                    <td>{{ $s->jk }}</td>
                                    <td>{{ $s->alamat }}</td>
                                    <td>{{ $s->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $s->rombel->nama_rombel ?? '-' }}</td>
                                    <td>{{ $s->rayon->nama_rayon ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('siswa.edit', $s->nis) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('siswa.destroy', $s->nis) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Tidak ada data siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="rayon" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Rayon</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="searchRayon" class="form-control form-control-sm" placeholder="Cari rayon...">
                        <a href="{{ route('rayon.create') }}" class="btn btn-primary btn-circle">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle" id="tableRayon">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Rayon</th>
                                <th>Pembimbing</th>
                                <th>Nomor Ruangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rayon as $index => $r)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $r->nama_rayon }}</td>
                                    <td>{{ $r->pembimbing->nama ?? '-' }}</td>
                                    <td>{{ $r->nomor_ruangan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('rayon.edit', $r->id_rayon) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rayon.destroy', $r->id_rayon) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data rayon.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="rombel" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Rombel</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="searchRombel" class="form-control form-control-sm" placeholder="Cari rombel...">
                        <a href="{{ route('rombel.create') }}" class="btn btn-primary btn-circle">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle" id="tableRombel">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th>Rombel</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rombel as $index => $RB)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $RB->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $RB->nama_rombel }}</td>
                                    <td>
                                        <a href="{{ route('rombel.edit', $RB->id_rombel) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rombel.destroy', $RB->id_rombel) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data Rombel.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="jurusan" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Jurusan</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="searchJurusan" class="form-control form-control-sm" placeholder="Cari jurusan...">
                        <a href="{{ route('jurusan.create') }}" class="btn btn-primary btn-circle">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered align-middle" id="tableJurusan">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jurusan as $index => $j)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $j->nama_jurusan }}</td>
                                    <td>
                                        <a href="{{ route('jurusan.edit', $j->id_jurusan) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data jurusan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #fff; 
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.25s ease-in-out;
    }

    .btn-circle:hover {
        transform: scale(1.12);
        box-shadow: 0 5px 14px rgba(0, 123, 255, 0.4);
    }

    .btn-circle i {
        font-weight: 900;
    }
    .alert {
        animation: fadeInDown 0.5s ease-in-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        searchTable('searchSiswa', 'tableSiswa');
        searchTable('searchRayon', 'tableRayon');
        searchTable('searchRombel', 'tableRombel');
        searchTable('searchJurusan', 'tableJurusan');
    });
</script>
@endsection
