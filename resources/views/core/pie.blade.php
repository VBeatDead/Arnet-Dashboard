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
                    <h5 class="card-title text-uppercase">Core Potential</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('addcore') }}" class="btn btn-primary mb-4 mt-3">
                                <i class="bi bi-plus me-3"></i>Insert New Core Potential
                            </a>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle mb-4 mt-3" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-pie-chart-fill"></i> Pie Chart
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('core.index') }}">Bar Chart</a></li>
                            </ul>
                        </div>
                    </div>

                    <p>Last updated:
                        {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M Y H:i:s') : 'Never' }}
                    </p>

                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text" id="search-addon">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="search" class="form-control" placeholder="Search by segment"
                                aria-describedby="search-addon">
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($chartData as $index => $data)
                            @if ($data['ccount'] != 0 || $data['good'] != 0 || $data['bad'] != 0 || $data['used'] != 0 || $data['total'] != 0)
                                <div class="col-12 col-md-6 mb-3 chart-item" data-segment="{{ $data['ruas'] }}">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <div class="chart-container"
                                                style="position: relative; height:40vh; width:40vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <h6 class="text-center font-weight-bold mb-2">Pie Chart for
                                                    {{ $data['ruas'] }}</h6>
                                                <div class="loading-spinner position-absolute top-50 start-50 translate-middle"
                                                    id="loading-{{ $index }}">
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                <canvas id="chart-{{ $loop->index }}" style="display:none;"></canvas>
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
            const searchInput = document.getElementById('search');
            const chartItems = document.querySelectorAll('.chart-item');

            function loadChart(index, data) {
                setTimeout(() => {
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
                                    enabled: false
                                },
                                legend: {
                                    display: true
                                },
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        var percentage = (value / data.total) * 100;
                                        return percentage.toFixed(2) !== '0.00' ? percentage
                                            .toFixed(2) + '%' : '';
                                    },
                                    color: 'black',
                                    font: (ctx) => {
                                        var value = ctx.dataset.data[ctx.dataIndex];
                                        var percentage = (value / data.total) * 100;
                                        return {
                                            weight: 'bold',
                                            size: '12',
                                            style: percentage < 5 ? 'normal' : 'normal'
                                        };
                                    },
                                    anchor: 'end',
                                    align: 'start',
                                    offset: 10,
                                    rotation: (ctx) => {
                                        var value = ctx.dataset.data[ctx.dataIndex];
                                        var percentage = (value / data.total) * 100;
                                        return percentage < 5 ? -85 : 0;
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });

                    document.getElementById(`loading-${index}`).style.display = 'none';
                    document.getElementById(`chart-${index}`).style.display = 'block';
                }, index * 10);
            }

            chartData.forEach((data, index) => {
                if (data.ccount != 0 || data.good != 0 || data.bad != 0 || data.used != 0) {
                    loadChart(index, data);
                }
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                chartItems.forEach(item => {
                    const segment = item.getAttribute('data-segment').toLowerCase();
                    if (segment.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
