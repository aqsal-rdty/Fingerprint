@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3" style="color: #6c757d;"><i class="bi bi-person-badge"></i> Tambah Data Guru</h3>
    <p class="animated fadeInDown" style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Fingerprint > <span class="fa-angle-right fa"></span> Data Guru > Create Guru
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Form Tambah Guru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="statuss" class="form-label">Status</label>
                    <select name="statuss" id="statuss" class="form-select @error('statuss') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" {{ old('statuss') == '1' ? 'selected' : '' }}>1</option>
                        <option value="0" {{ old('statuss') == '0' ? 'selected' : '' }}>0</option>
                    </select>
                    @error('statuss')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection