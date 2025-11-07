@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>
            <h4 class="mb-0">Tambah Data Rayon</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('rayon.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_rayon" class="form-label">ID Rayon</label>
                    <input type="text" class="form-control" id="id_rayon" name="id_rayon" value="{{ $new }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_rayon" class="form-label">Nama Rayon</label>
                    <input type="text" class="form-control @error('nama_rayon') is-invalid @enderror" id="nama_rayon" name="nama_rayon" value="{{ old('nama_rayon') }}" placeholder="Masukkan nama rayon..." required>
                    @error('nama_rayon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pembimbing_id" class="form-label">Pembimbing</label>
                    <select name="pembimbing_id" id="pembimbing_id" class="form-select">
                        <option value="">-- Pilih Pembimbing --</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->nip }}">{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nomor_ruangan" class="form-label">Nomor Ruangan</label>
                    <input type="text" name="nomor_ruangan" id="nomor_ruangan" class="form-control" placeholder="Masukkan nomor ruangan">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('rayon.index') }}" class="btn btn-secondary">
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