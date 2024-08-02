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
                    <h6 class="card-title text-uppercase">CME Potential</h6>
                    <div class="row">
                        @foreach ($chartData as $data)
                            @if ($data['underfive'] != 0 || $data['morethanfive'] != 0 || $data['morethanten'] != 0)
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $data['device'] }}</h5>
                                            <div class="chart-container items-center">
                                                <canvas id="barChart-{{ $data['device'] }}-1"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $data['device'] }}</h5>
                                            <div class="chart-container items-center">
                                                <canvas id="barChart-{{ $data['device'] }}-2"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const chartData = @json($chartData);

        function renderBarChart(data, chartId, isPercentage = false) {
            const ctx = document.getElementById(chartId).getContext('2d');
            let chartData = isPercentage ? [
                data.percentages.underfive.toFixed(2),
                data.percentages.morethanfive.toFixed(2),
                data.percentages.morethanten.toFixed(2)
            ] : [
                data.underfive,
                data.morethanfive,
                data.morethanten
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Under 5', '5-10', '10+'],
                    datasets: [{
                        label: isPercentage ? 'Percentage of ' + data.device : 'Count of ' + data.device,
                        data: chartData,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: isPercentage ? 50 : 1
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: false,
                        },
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: 14,
                            },
                            formatter: function(value, context) {
                                if (value > 0) {
                                    return isPercentage ? value + '%' : value;
                                } else {
                                    return null;
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        chartData.forEach(data => {
            renderBarChart(data, `barChart-${data.device}-1`);
            renderBarChart(data, `barChart-${data.device}-2`, true);
        });
    </script>
@endsection
