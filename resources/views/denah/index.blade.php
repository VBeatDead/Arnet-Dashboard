<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Denah STO')

@section('content')

    <!-- TABLE -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-uppercase">Data Denah STO</h6>
                    <div>
                        <a href="/adddenah" class="btn btn-primary mb-4 mt-3">
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
                        @foreach ($denah as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->name }}</td>
                            <td>
                                @if($d->converted_image)
                                    @php
                                        $convertedImageUrl = asset($d->converted_image);
                                    @endphp
                                    <img src="{{ $convertedImageUrl }}" alt="{{ $d->name }}" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                @else
                                    <a href="{{ asset($d->file) }}" title="Download" class="btn btn-primary" download><i class="bi bi-download"></i></a>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('denah.edit', $d->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger h-20" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="handleDelete({{ $d->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF TABLE -->

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>

            <div class="modal-footer">                
                <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- END OF DELETE MODAL -->

@endsection
<script>
    const handleDelete = (id) => document.querySelector('#deleteModal .modal-footer a').href = 'denah/d' + id;
</script>