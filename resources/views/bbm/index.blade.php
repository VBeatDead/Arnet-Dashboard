@extends('layouts.app')

@section('title', 'BBM Data')

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
                        <h5 class="card-title text-uppercase mb-0">BBM Data for Malang</h5>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-bordered w-100">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th>STO ID</th>
                                    <th>STO Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($availableStos as $id => $name)
                                    <tr data-bs-toggle="collapse" data-bs-target="#collapse-{{ $id }}"
                                        aria-expanded="false" aria-controls="collapse-{{ $id }}"
                                        style="cursor: pointer">
                                        <td class="text-center">{{ $id }}</td>
                                        <td>{{ $name }}</td>
                                        <td class="text-center"><i class="bi bi-chevron-down"></i></td>
                                    </tr>
                                    <tr id="collapse-{{ $id }}" class="collapse">
                                        <td colspan="3">
                                            <div class="chart-container d-flex justify-content-center align-items-center"
                                                style="height:70vh; width:100%">
                                                <div id="chart-{{ $id }}" style="height:100%; width:100%"></div>
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

    <!-- Include ECharts library -->
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
            const data = chartData.filter(item => item.sto_id == parseInt(stoId));
            if (data.length > 0) {
                const dates = data.map(item => item.date);
                const totals = data.map(item => item.total_bbm);

                const chartDom = document.getElementById(`chart-${stoId}`);
                const myChart = echarts.init(chartDom);
                const option = {
                    title: {
                        text: `BBM Data for STO ID: ${stoId}`
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: {
                        type: 'category',
                        data: dates,
                        name: 'Date',
                        boundaryGap: false
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Total BBM'
                    },
                    series: [{
                        name: 'Total BBM',
                        type: 'line',
                        data: totals
                    }]
                };

                myChart.setOption(option);
            } else {
                document.getElementById(`chart-${stoId}`).innerHTML = '<p>No data available for the selected STO.</p>';
            }
        }
    </script>
@endsection
