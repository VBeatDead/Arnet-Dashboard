<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Surat')

@section('content')

<!-- TABLE -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Data Surat</h6>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END OF TABLE -->




@endsection