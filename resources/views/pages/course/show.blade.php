@extends('layouts.master')
@section('main')
<div class="title d-flex align-items-center">
    <a href="{{ route('course.index') }}" class="text-decoration-none">
        <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Grafik Pertumbuhan</span>
</div>
<div class="content-wrapper">
    <div class="row same-height">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-body">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    const ctx = document.getElementById('chart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? []) !!},
            datasets: [{
                label: 'Grafik pertumbuhan',
                data: {!! json_encode($data ?? []) !!},
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection