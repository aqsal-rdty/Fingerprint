@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3" style="color: #6c757d;"><i class="bi bi-fingerprint"></i> Tambah Mesin Fingerprint</h3>
        <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
            Fingerprint > <span class="fa-angle-right fa"></span> Mesin Absensi > Tambah Mesin
        </p>
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Form Tambah Mesin</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('fingerprint_store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="ip" class="form-label">IP Address</label>
                    <input type="text" name="ip" id="ip" class="form-control @error('ip') is-invalid @enderror" value="{{ old('ip') }}" placeholder="Masukkan IP Address" required>
                    @error('ip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comkey" class="form-label">Comkey</label>
                    <input type="text" name="comkey" id="comkey" class="form-control @error('comkey') is-invalid @enderror" value="{{ old('comkey') }}" placeholder="Masukkan Comkey" required>
                    @error('comkey')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Masukkan Lokasi Mesin" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('fingerprint_index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
