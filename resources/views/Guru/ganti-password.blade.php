@extends('layouts.guru')

@section('content')
<div class="container mt-5" style="max-width: 450px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">
                <i class="bi bi-lock fs-3 text-primary"></i>
                <span class="ms-2">Ganti Password</span>
            </h4>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('guru.password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_baru_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Simpan Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection