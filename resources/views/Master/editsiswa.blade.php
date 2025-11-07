@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3 class="mb-3" style="color: #6c757d;">
        <i class="bi bi-person-fill"></i> Edit Siswa
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Siswa > <span class="fa-angle-right fa"></span> Edit Siswa
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Siswa: {{ $siswa->nama }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.update', ['nis' => $siswa->nis]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" value="{{ $siswa->nis }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $siswa->nama }}">
                </div>

                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}">
                </div>

                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk">
                        <option value="L" {{ $siswa->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $siswa->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{ $siswa->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="id_rayon" class="form-label">Rayon</label>
                    <select class="form-select" id="id_rayon" name="id_rayon">
                        @foreach($rayon as $r)
                            <option value="{{ $r->id_rayon }}" {{ $siswa->id_rayon == $r->id_rayon ? 'selected' : '' }}>
                                {{ $r->nama_rayon }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_rombel" class="form-label">Rombel</label>
                    <select class="form-select" id="id_rombel" name="id_rombel">
                        @foreach($rombel as $rb)
                            <option value="{{ $rb->id_rombel }}" {{ $siswa->id_rombel == $rb->id_rombel ? 'selected' : '' }}>
                                {{ $rb->nama_rombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select class="form-select" id="id_jurusan" name="id_jurusan">
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id_jurusan }}" {{ $siswa->id_jurusan == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection