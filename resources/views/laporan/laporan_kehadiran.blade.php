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

    <h3 class="mb-3 text-secondary">
        <i class="bi bi-clipboard-data"></i> Laporan Kehadiran
    </h3>
    <p class="text-muted" style="font-size: 14px; margin-left: 37px;">
        Fingerprint > <span class="fa fa-angle-right"></span> Laporan Kehadiran
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-journal-text me-2"></i>
            <h5 class="mb-0">Form Laporan Kehadiran</h5>
        </div>
        
        <div class="card-body" style="background-color: #fafafa;">
            <div class="mb-5">
                <h5 class="text-secondary mb-3">
                    <i class="bi bi-calendar-day me-2 text-primary"></i>Laporan Harian
                </h5>
                <form method="POST" action="{{ route('laporan_harian') }}" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input type="date" class="form-control" required name="input_tanggal">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Rombel</label>
                        <select class="form-select mdb-select" name="input_rombel" required>
                            <option selected disabled>Pilih Rombel</option>
                            @foreach ($rombel as $r)
                                <option value="{{ $r->id_rombel }}">{{ $r->nama_rombel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>

            <hr>

            <div class="mt-4">
                <h5 class="text-secondary mb-3">
                    <i class="bi bi-calendar-month me-2 text-primary"></i>Laporan Bulanan
                </h5>
                <form method="POST" action="{{ route('laporan_bulanan') }}" class="row g-3">
                    @csrf
                    @php
                        $index_bulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Bulan</label>
                        <select class="form-select mdb-select" name="input_bulan" required>
                            <option selected disabled>Pilih Bulan</option>
                            @for($bln = 1; $bln <= 12; $bln++)
                                <option value="{{ $bln }}">{{ $index_bulan[$bln] }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tahun</label>
                        <select class="form-select mdb-select" name="input_tahun" required>
                            <option selected disabled>Pilih Tahun</option>
                            @for($thn = date("Y"); $thn >= 1996; $thn--)
                                <option value="{{ $thn }}">{{ $thn }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Rombel</label>
                        <select class="form-select mdb-select" name="input_rombel" required>
                            <option selected disabled>Pilih Rombel</option>
                            @foreach ($rombel as $r)
                                <option value="{{ $r->id_rombel }}">{{ $r->nama_rombel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('asset_footer')
<script src="{{ url('asset/js/plugins/jquery.knob.js') }}"></script>
<script src="{{ url('asset/js/plugins/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ url('asset/js/plugins/jquery.mask.min.js') }}"></script>
<script src="{{ url('asset/js/plugins/select2.full.min.js') }}"></script>
<script src="{{ url('asset/js/mdb.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.mdb-select').material_select();
    $('.dateAnimate').bootstrapMaterialDatePicker({ weekStart: 1, time: false, animation: true });
  });
  $(document).ready(function(){
    $('.mdb-select').material_select();
  });
</script>
@endsection

<style>
    .card {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    h5 i {
        transition: transform 0.3s ease;
    }

    h5:hover i {
        transform: rotate(-8deg);
    }

    .form-control,
    .form-select {
        padding: 6px 10px;
        font-size: 14px;
    }

    label.form-label {
        font-size: 13px;
    }

    button.btn {
        font-size: 14px;
        padding: 6px 14px;
    }
</style>