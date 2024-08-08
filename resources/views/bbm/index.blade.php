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
                        <a href="{{ route('bbm.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Insert New BBM
                        </a>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-bordered w-100">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>STO</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($availableStos) > 0)
                                    @foreach ($availableStos as $index => $sto)
                                        <tr data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}"
                                            aria-expanded="false" aria-controls="collapse-{{ $index }}"
                                            style="cursor: pointer">
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $sto['name'] }}</td>
                                            <td class="text-center"><i class="bi bi-chevron-down"></i></td>
                                        </tr>
                                        <tr id="collapse-{{ $index }}" class="collapse">
                                            <td colspan="3">
                                                <div class="chart-container d-flex justify-content-center align-items-center"
                                                    style="height:70vh; width:100%">
                                                    <div id="chart-{{ $index }}" style="height:100%; width:100%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No data available in table</td>
                                    </tr>
                                @endif
                            </tbody>
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
        const stoNames = @json($availableStos);

        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const stoIndex = this.getAttribute('data-bs-target').replace('#collapse-', '');
                const collapseElement = document.querySelector(this.getAttribute('data-bs-target'));
                if (!collapseElement.classList.contains('show')) {
                    renderChart(stoIndex);
                }
            });
        });

        function renderChart(stoIndex) {
            const stoId = stoNames[stoIndex].id;
            const data = chartData.filter(item => item.sto_id == parseInt(stoId));
            const stoName = stoNames[stoIndex].name;

            if (data.length > 0) {
                const dates = data.map(item => item.date);
                const totals = data.map(item => item.total_bbm);

                const chartDom = document.getElementById(`chart-${stoIndex}`);
                const myChart = echarts.init(chartDom);
                const option = {
                    title: {
                        text: `BBM Data for ${stoName}`,
                        left: 'center',
                        textStyle: {
                            fontSize: 18,
                            fontWeight: 'bold',
                            color: '#333'
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: dates,
                        name: 'Date',
                        boundaryGap: false,
                        axisLine: {
                            lineStyle: {
                                color: '#333'
                            }
                        },
                        axisLabel: {
                            color: '#666'
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Total BBM/Liter',
                        axisLine: {
                            lineStyle: {
                                color: '#333'
                            }
                        },
                        axisLabel: {
                            color: '#666'
                        }
                    },
                    series: [{
                        name: 'Total BBM/Liter',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        itemStyle: {
                            color: '#ff6f61'
                        },
                        lineStyle: {
                            width: 3
                        },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: 'rgba(255, 111, 97, 0.3)'
                                },
                                {
                                    offset: 1,
                                    color: 'rgba(255, 111, 97, 0)'
                                }
                            ])
                        },
                        data: totals
                    }]
                };
                myChart.setOption(option);

            } else {
                document.getElementById(`chart-${stoIndex}`).innerHTML = '<p>No data available for the selected STO.</p>';
            }
        }
    </script>
@endsection
