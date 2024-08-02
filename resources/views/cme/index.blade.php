@extends('layouts.app')

@section('title', 'Telkom | CME Device')

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
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase mb-0">CME Potential</h5>
                        <a href="{{ route('addcme') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Insert New CME Potential
                        </a>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end pt-3">
                            <p>Last updated:
                                {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M Y H:i:s') : 'Never' }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">

                    <div class="accordion" id="stoAccordion">
                        @foreach ($grandtotal as $data)
                            <div class="accordion-item mb-2 rounded-lg shadow-lg">
                                <h2 class="accordion-header" id="heading-{{ $data['id'] }}">
                                    <button
                                        class="accordion-button collapsed d-flex justify-content-between align-items-center p-4 w-100 text-left"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $data['id'] }}" aria-expanded="false"
                                        aria-controls="collapse-{{ $data['id'] }}" data-sto-id="{{ $data['id'] }}"
                                        data-bg-id="{{ $data['id'] }}" style="background-color: #dc3545; color: white;">
                                        <span>{{ $data['sto'] }} (Total: {{ $data['total'] }})</span>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $data['id'] }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading-{{ $data['id'] }}" data-bs-parent="#stoAccordion"
                                    data-bg-id="{{ $data['id'] }}">
                                    <div class="accordion-body p-4">
                                        <div class="chart-container d-flex justify-content-center align-items-center"
                                            style="height:70vh; width:100%">
                                            <canvas id="chart-{{ $data['id'] }}"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const chartData = @json($chartData);

        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function() {
                const stoId = this.getAttribute('data-sto-id');
                const collapseElement = this.closest('.accordion-item').querySelector(
                    '.accordion-collapse');
                if (!collapseElement.classList.contains('show')) {
                    renderChart(stoId);
                }
            });
        });

        function renderChart(stoId) {
            const data = chartData.find(item => item.id === parseInt(stoId));
            if (data) {
                const ctx = document.getElementById(`chart-${stoId}`).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Devices',
                            data: data.values,
                            backgroundColor: data.colors,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    color: '#ffffff',
                                    font: {
                                        size: 15
                                    }
                                }
                            }
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                const chartElement = elements[0];
                                const index = chartElement.index;
                                const stoId = data.id;
                                const typeId = data.type[index];
                                window.location.href = `/cme/${stoId}/${typeId}`;
                            }
                        }
                    }
                });
            }
        }
    </script>
@endsection
