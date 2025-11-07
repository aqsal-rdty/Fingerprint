@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>
            <h4 class="mb-0">Tambah Data Jurusan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('jurusan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_jurusan" class="form-label">ID Jurusan</label>
                    <input type="text" class="form-control" id="id_jurusan" name="id_jurusan" value="{{ $new }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                    <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" placeholder="Masukkan nama jurusan..." required>
                    @error('nama_jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">
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