@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>
            <h4 class="mb-0">Tambah Data Rombel</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('rombel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_rombel" class="form-label">ID Rombel</label>
                    <input type="text" class="form-control" id="id_rombel" name="id_rombel" value="{{ $new }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_rombel" class="form-label">Nama Rombel</label>
                    <input type="text" class="form-control @error('nama_rombel') is-invalid @enderror" id="nama_rombel" name="nama_rombel" value="{{ old('nama_rombel') }}" placeholder="Masukkan nama Rombel..." required>
                    @error('nama_rombel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select class="form-select @error('id_jurusan') is-invalid @enderror" id="id_jurusan" name="id_jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->id_jurusan }}" {{ old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('rombel.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection