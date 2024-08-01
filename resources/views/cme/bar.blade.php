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
                <div>
                    <a href="{{ route('addcore') }}" class="btn btn-primary mb-4 mt-3">
                        <i class="bi bi-plus me-3"></i>Insert New Core Potential
                    </a>
                </div>
                {{-- Render Charts --}}
                <div class="row">
                    @foreach ($chartData as $data)
                        @if ($data['underfive'] != 0 || $data['morethanfive'] != 0 || $data['morethanten'] != 0)
                            <div class="col-12 col-md-6 mb-4">
                                <div class="card chart-card">
                                    <div class="card-body">
                                        <div class="chart-container" style="position: relative; height:40vh; width:100%">
                                            <h6 class="text-center font-weight-bold mb-2">{{ $data['name'] }} -- ({{$data['device']}})
                                            </h6>
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
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);

        chartData.forEach((data, index) => {
            if (data.underfive != 0 || data.morethanfive != 0 || data.morethanten != 0) {
                const ctx = document.getElementById(`chart-${index}`).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['<5 Year', '>5 Year <10', '>10 Year'],
                        datasets: [{
                            label: '',
                            data: [data.underfive, data.morethanfive, data.morethanten],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    });
</script>


@endsection