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
        <i class="bi bi-collection-fill"></i> Edit Rombel
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Rombel > <span class="fa-angle-right fa"></span> Edit Rombel
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Rombel: {{ $rombel->nama_rombel }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('rombel.update', $rombel->id_rombel) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_rombel" class="form-label">ID Rombel</label>
                    <input type="text" class="form-control" id="id_rombel" value="{{ $rombel->id_rombel }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="nama_rombel" class="form-label">Nama Rombel</label>
                    <input type="text" class="form-control" id="nama_rombel" name="nama_rombel" value="{{ $rombel->nama_rombel }}">
                </div>

                <div class="mb-3">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select class="form-select" id="id_jurusan" name="id_jurusan">
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id_jurusan }}" {{ $rombel->id_jurusan == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('rombel.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
