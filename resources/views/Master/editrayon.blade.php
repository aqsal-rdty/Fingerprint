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
        <i class="bi bi-geo-alt-fill"></i> Edit Rayon
    </h3>
    <p style="color: #6c757d; font-size: 14px; margin-left: 37px;">
        Master Data > <span class="fa-angle-right fa"></span> Edit Rayon
    </p>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Rayon: {{ $rayon->nama_rayon }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('rayon.update', $rayon->id_rayon) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_rayon" class="form-label">Nama Rayon</label>
                    <input type="text" class="form-control" id="nama_rayon" name="nama_rayon" value="{{ $rayon->nama_rayon }}">
                </div>

                <div class="mb-3">
                    <label for="pembimbing_id" class="form-label">Pembimbing</label>
                    <select class="form-select" name="pembimbing_id" id="pembimbing_id">
                        <option value="">-- Pilih Pembimbing --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->nip }}" {{ $rayon->pembimbing_id == $g->nip ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nomor_ruangan" class="form-label">Nomor Ruangan</label>
                    <input type="text" class="form-control" id="nomor_ruangan" name="nomor_ruangan" value="{{ $rayon->nomor_ruangan }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('rayon.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection