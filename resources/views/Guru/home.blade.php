@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body text-center py-5">
            <h4 class="card-title mb-3">
                <i class="bi bi-person-badge fs-3 text-primary"></i>
            </h4>
            <h4 class="card-text">Selamat datang, <strong>{{ auth()->user()->name }}</strong></h4>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3 text-secondary"><i class="bi bi-bar-chart-line"></i> Rekap Kehadiran Bulanan</h5>
            <canvas id="grafikKehadiran" height="120"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('grafikKehadiran').getContext('2d');
    const grafikKehadiran = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Tepat',
                    data: @json($dataTepat),
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Telat',
                    data: @json($dataTelat),
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection