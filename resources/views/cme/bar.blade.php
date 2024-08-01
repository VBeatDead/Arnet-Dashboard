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
                                                <canvas id="barChart-{{ $data['device'] }}"></canvas>
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
        const chartData = @json($chartData);

        function renderBarChart(data) {
            const ctx = document.getElementById(`barChart-${data.device}`).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Under 5', '5-10', '10+'],
                    datasets: [{
                        label: data.device,
                        data: [data.underfive, data.morethanfive, data.morethanten],
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                }
            });
        }
        chartData.forEach(data => {
            renderBarChart(data);
        });
    </script>

@endsection
