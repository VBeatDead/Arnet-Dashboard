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
                                            <div class="chart-container items-center">
                                                <div id="barChart-{{ $data['device'] }}-1" style="height: 400px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="chart-container items-center">
                                                <div id="barChart-{{ $data['device'] }}-2" style="height: 400px;"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
    <script>
        const chartData = @json($chartData);

        function renderBarChart(data, chartId, isPercentage = false) {
            var chartDom = document.getElementById(chartId);
            var myChart = echarts.init(chartDom);
            var option;

            let chartValues = isPercentage ? [
                data.percentages.underfive.toFixed(2),
                data.percentages.morethanfive.toFixed(2),
                data.percentages.morethanten.toFixed(2)
            ] : [
                data.underfive,
                data.morethanfive,
                data.morethanten
            ];

            option = {
                title: {
                    text: isPercentage ? 'Percentage of ' + data.device : 'Count of ' + data.device,
                    left: 'center'
                },
                tooltip: {},
                xAxis: {
                    type: 'category',
                    data: ['Under 5', '5-10', '10+']
                },
                yAxis: {
                    type: 'value',
                    axisLabel: {
                        formatter: isPercentage ? '{value}%' : '{value}'
                    }
                },
                series: [{
                    name: 'Values',
                    type: 'bar',
                    data: chartValues,
                    itemStyle: {
                        color: function(params) {
                            var colorList = ['#FF6384', '#36A2EB', '#FFCE56'];
                            return colorList[params.dataIndex]
                        }
                    },
                    label: {
                        show: true,
                        position: 'top',
                        formatter: function(params) {
                            return isPercentage ? params.value + '%' : params.value;
                        }
                    }
                }]
            };

            option && myChart.setOption(option);
        }

        chartData.forEach(data => {
            renderBarChart(data, `barChart-${data.device}-1`);
            renderBarChart(data, `barChart-${data.device}-2`, true);
        });
    </script>
@endsection
