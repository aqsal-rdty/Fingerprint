@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3" style="color: #6c757d;">
        <i class="bi bi-fingerprint"></i> Tambah Mesin Fingerprint Guru
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Fingerprint > <span class="fa-angle-right fa"></span> Tambah Mesin
    </p>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('fingerprintguru_store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="ip" class="form-label">IP Address</label>
                    <input type="text" class="form-control" id="ip" name="ip" placeholder="Masukkan IP Address" required>
                </div>

                <div class="mb-3">
                    <label for="comkey" class="form-label">Comkey</label>
                    <input type="text" class="form-control" id="comkey" name="comkey" placeholder="Masukkan Comkey" required>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('fingerprintguru_index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
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