@extends('layouts.app')

@section('title', 'Denah STO')

@section('content')

<!-- TABLE -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Data Denah STO</h6>
                <div>
                    <a href="/form" class="btn btn-primary mb-4 mt-3">
                        <i class="bi bi-plus me-3"></i>Tambah Denah STO
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100" id="example">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Lokasi STO</th>
                                <th>Denah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($denahs as $index => $denah)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $denah->lokasi_sto }}</td>
                                    <td class="text-center">
                                        <img src="data:image/jpeg;base64,{{ base64_encode($denah->denah) }}" alt="Denah" style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger">Delete</button>
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
<!-- END OF TABLE -->

@endsection
