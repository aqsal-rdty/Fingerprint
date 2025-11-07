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
        <i class="bi bi-mortarboard-fill"></i> Edit Jurusan
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Jurusan > <span class="fa-angle-right fa"></span> Edit Jurusan
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Jurusan: {{ $jurusan->nama_jurusan }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_jurusan" class="form-label">ID Jurusan</label>
                    <input type="text" class="form-control" id="id_jurusan" value="{{ $jurusan->id_jurusan }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                    <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="{{ $jurusan->nama_jurusan }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('jurusan.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection