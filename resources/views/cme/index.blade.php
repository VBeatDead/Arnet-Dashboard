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
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-uppercase">CME Potential</h6>
                <div>
                    <a href="{{ route('addcme') }}" class="btn btn-primary mb-4 mt-3">
                        <i class="bi bi-plus me-3"></i>Insert New CME Potential
                    </a>
                </div>

                <!-- DOUGHNUT CHART -->
                 <div class="container-chart">
                     <div class="col-12 col-md-4 mb-3">
                         <div class="card chart-card">
                             <div class="card-body">
                                 <h3 class="mb-5 text-center">Potensial CME in Every</h3>
                                 <canvas id="doughnut-chart"></canvas>
                             </div>
                         </div>
                     </div>
                 </div>
                <!-- END OF DOUGHNUT CHART -->

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Doughnut Chart
        const grandtotal = @json($grandtotal);
        // Extract labels and data
        const ids = grandtotal.map(item => item.id);
        const labels = grandtotal.map(item => item.sto);
        const data = grandtotal.map(item => item.total);

        // Function to generate random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Generate colors based on data length
        const backgroundColors = data.map(() => getRandomColor());

        const ctx2 = document.getElementById('doughnut-chart');
        const doughnutChart = new Chart(ctx2, {
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const chartElement = elements[0];
                        const index = chartElement.index;
                        const id = ids[index];
                        window.location.href = `/cme/${id}`;
                    }
                }
            },
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: '',
                    data: data,
                    backgroundColor: backgroundColors
                }]
            }
        });
    });





</script>


@endsection