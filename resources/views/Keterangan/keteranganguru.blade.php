{{-- @extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 text-secondary text-start">
        <i class="bi bi-info-circle"></i> Keterangan Guru
    </h3>
    <p class="text-secondary small ms-1 text-start">
        Fingerprint > <i class="fa fa-angle-right"></i> Keterangan Guru
    </p>

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
                                <form action="{{ route('keteranganguru.update', $t->nip) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="keterangan" class="form-select form-select-sm d-inline-block w-auto" required>
                                        <option value="">Pilih</option>
                                        <option value="Sakit" {{ $t->keterangan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="Izin" {{ $t->keterangan == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    </select>
                                    <button type="submit" class="btn btn-success btn-sm ms-1">
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

    {{-- <div class="mt-3">
        <a href="{{ route('guru.kehadiran') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div> --}}
</div>
@endsection --}}