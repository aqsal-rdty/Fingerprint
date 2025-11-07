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

    <h3 class="mb-3" style="color: #6c757d;">
        <i class="bi bi-fingerprint"></i> Edit Mesin Fingerprint
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Fingerprint > <span class="fa-angle-right fa"></span> Edit Mesin
    </p>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('fingerprint_update', ['id' => $fingerprint->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="ip" class="form-label">IP Address</label>
                    <input type="text" name="ip" id="ip" class="form-control" value="{{ old('ip', $fingerprint->ip) }}" required>
                </div>

                <div class="mb-3">
                    <label for="comkey" class="form-label">Comkey</label>
                    <input type="text" name="comkey" id="comkey" class="form-control" value="{{ old('comkey', $fingerprint->comkey) }}" required>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi', $fingerprint->lokasi) }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="1" {{ $fingerprint->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $fingerprint->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                    <a href="{{ route('fingerprint_index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
