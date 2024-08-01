@extends('layouts.app')

@section('title', 'Telkom | Document')

@section('content')

@if (session()->has('errors'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
        @foreach (session('errors') as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Core Potential</h6>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <a href="{{ route('addcore') }}" class="btn btn-primary mb-4 mt-3">
                            <i class="bi bi-plus me-3"></i>Insert New Core Potential
                        </a>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Chart
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('core.index') }}">Bar Chart</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Menampilkan tanggal dan waktu terakhir diperbarui -->
                @php
                $lastUpdated = DB::table('cores')->max('last_updated');
                @endphp

                @if($lastUpdated)
                <p class="text-muted">Last updated: {{ \Carbon\Carbon::parse($lastUpdated)->format('d M Y, H:i:s') }}</p>
                @endif

                <div class="row">
                    @foreach ($chartData as $data)
                    @if ($data['ccount'] != 0 || $data['good'] != 0 || $data['bad'] != 0 || $data['used'] != 0 || $data['total'] != 0)
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="chart-container" style="position: relative; height:40vh; width:40vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <h6 class="text-center font-weight-bold mb-2">Pie Chart for {{ $data['ruas'] }}</h6>
                                    <canvas id="chart-{{ $loop->index }}"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData);
        chartData.forEach((data, index) => {
            if (data.ccount != 0 || data.good != 0 || data.bad != 0 || data.used != 0) {
                const ctx = document.getElementById(`chart-${index}`).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Kabel', 'Good', 'Bad', 'Used'],
                        datasets: [{
                            data: [data.ccount, data.good, data.bad, data.used],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)',
                               
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var percentage = (context.raw / data.total) * 100;
                                        return percentage.toFixed(2) + '%';
                                    }
                                }
                            },
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
