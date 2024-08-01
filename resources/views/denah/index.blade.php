<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | STO Layout')

@section('content')

<?php if (session()->has('errors')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="m-0">
        <?php    foreach (session('errors') as $error): ?>
        <li><?= $error ?></li>
        <?php    endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;

if (session()->has('success')):?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


<!-- TABLE -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-uppercase">STO Layout Data</h6>
                <div>
                    <a href="/adddenah" class="btn btn-primary mb-4 mt-3">
                        <i class="bi bi-plus me-3"></i>Create New STO Layout
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100" id="table">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>STO Location</th>
                                <th>Room Type</th>
                                <th>Preview</th>
                                <th>File Download
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-arrow-down-square-fill"></i>
                                        VSD &
                                        <i class="bi bi-arrow-down-square-fill img"></i>
                                        IMG</small>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($denah as $d)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $d->sto->subtype }}</td>
                                                            <td>{{ $d->room->subtype }}</td>
                                                            <td>
                                                                @php
                                                                    $convertedImageUrl = $d->converted_image
                                                                        ? asset($d->converted_image)
                                                                        : null;
                                                                @endphp
                                                                @if ($convertedImageUrl)
                                                                    <a href="javascript:void(0);" onclick="showImage('{{ $convertedImageUrl }}')">
                                                                        <img src="{{ $convertedImageUrl }}" alt="{{ $d->sto->subtype }}"
                                                                            class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                                                    </a>
                                                                @else
                                                                    <img src="public\img\403-error-forbidden-animate.svg" alt="No image available"
                                                                        class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                                                @endif
                                                            </td>
                                                            @if ($d->file)
                                                                <td><a href="{{ asset($d->file) }}" title="Download VSD" class="btn btn-info"
                                                                        download><i class="bi bi-download"></i></a>
                                                                    <a href="{{ asset($d->converted_image) }}" title="Download IMG"
                                                                        class="btn btn-success  " download><i class="bi bi-download"></i></a>
                                                                </td>
                                                            @else
                                                                <td><a href="{{ asset($d->converted_image) }}" title="Download IMG"
                                                                        class="btn btn-success  " download><i class="bi bi-download"></i></a></td>
                                                            @endif  
                                                          <td class="text-center">
                                                                <a href="{{ route('denah.edit', $d->id) }}" class="btn btn-warning">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                @if ($user->role == '0')
                                                                <button title="Delete" class="btn btn-danger" data-id="{{ $d->id }}"
                                                                data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                                                class="bi bi-trash"></i></button>
                                                                @endif
                                                                {{-- <button type="button" class="btn btn-danger h-20" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal" onclick="handleDelete({{ $d->id }})">
                                                                    <i class="bi bi-trash"></i>
                                                                </button> --}}
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

{{-- IMAGE OVERLAY --}}
<div id="imageOverlay" class="image-overlay" style="display: none;">
    <span class="close-btn" onclick="closeImageOverlay()">&times;</span>
    <img id="overlayImage" src="" class="overlay-image">
</div>
{{-- END OF IMAGE OVERLAY --}}

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
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END OF DELETE MODAL -->



@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');

            var deleteForm = document.getElementById('deleteForm');
            var deleteIdInput = document.getElementById('deleteId');

            var action = "{{ route('denah.destroy', ':id') }}";
            action = action.replace(':id', id);

            deleteForm.action = action;
            deleteIdInput.value = id;
        });
    });

    function showImage(imageUrl) {
        document.getElementById('overlayImage').src = imageUrl;
        document.getElementById('imageOverlay').style.display = "block";
    }

    function closeImageOverlay() {
        document.getElementById('imageOverlay').style.display = "none";
    }
</script>