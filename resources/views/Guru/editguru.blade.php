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
        <i class="bi bi-person-badge"></i> Edit Guru
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Guru > <span class="fa-angle-right fa"></span> Edit Guru
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Guru: {{ $guru->nama }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.update', ['nip' => $guru->nip]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{ $guru->nip }}">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $guru->nama }}">
                </div>

                <div class="mb-3">
                    <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa" 
                           value="{{ old('no_wa', $guru->no_wa) }}" placeholder="Contoh: 6281234567890">
                </div>

                <div class="mb-3">
                    <label for="statuss" class="form-label">Status</label>
                    <select class="form-select" name="statuss" id="statuss">
                        <option value="1" {{ $guru->statuss == 1 ? 'selected' : '' }}>1</option>
                        <option value="0" {{ $guru->statuss == 0 ? 'selected' : '' }}>0</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection