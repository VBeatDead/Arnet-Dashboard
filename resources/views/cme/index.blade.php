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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-uppercase mb-0">CME Potential</h5>
                        <a href="{{ route('addcme') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Insert New CME Potential
                        </a>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <p>Last updated:
                                {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M Y H:i:s') : 'Never' }}
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered w-100">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>STO</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grandtotal as $index => $data)
                                    <tr data-bs-toggle="collapse" data-bs-target="#collapse-{{ $data['id'] }}"
                                        aria-expanded="false" aria-controls="collapse-{{ $data['id'] }}"
                                        style="cursor: pointer">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $data['sto'] }}</td>
                                        <td class="text-center">{{ $data['total'] }}</td>
                                        <td class="text-center"><i class="bi bi-chevron-down"></i></td>
                                    </tr>
                                    <tr id="collapse-{{ $data['id'] }}" class="collapse">
                                        <td colspan="4">
                                            <div class="chart-container d-flex justify-content-center align-items-center"
                                                style="height:70vh; width:100%">
                                                <div id="chart-{{ $data['id'] }}" style="height:100%; width:100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.0.2/dist/echarts.min.js"></script>
    <script>
        const chartData = @json($chartData);

        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const stoId = this.getAttribute('data-bs-target').replace('#collapse-', '');
                const collapseElement = document.querySelector(this.getAttribute('data-bs-target'));
                if (!collapseElement.classList.contains('show')) {
                    renderChart(stoId);
                }
            });
        });

        function renderChart(stoId) {
            const data = chartData.find(item => item.id === parseInt(stoId));
            if (data) {
                const chartDom = document.getElementById(`chart-${stoId}`);
                const myChart = echarts.init(chartDom);
                const option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left'
                    },
                    series: [{
                        name: 'Devices',
                        type: 'pie',
                        radius: ['0%', '80%'],
                        label: {
                            show: true,
                            position: 'outside',
                            formatter: '{b}: {c} ({d}%)'
                        },
                        data: data.values.map((value, index) => ({
                            value: value,
                            name: data.labels[index],
                            itemStyle: {
                                color: data.colors[index]
                            }
                        })),
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                };
                myChart.setOption(option);
                myChart.on('click', function(params) {
                    const typeId = data.type[params.dataIndex];
                    window.location.href = `/cme/${stoId}/${typeId}`;
                });
            }
        }
    </script>
@endsection
