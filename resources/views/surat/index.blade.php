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

    <!-- TABLE -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-uppercase">Documents</h6>
                    <div>
                        <a href="{{ route('adddocument') }}" class="btn btn-primary mb-4 mt-3">
                            <i class="bi bi-plus me-3"></i>Create New Document
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Device Name</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Serial Number</th>
                                    <th>First STO</th>
                                    <th>Last STO</th>
                                    <th>Evidence</th>
                                    <th>Berita Acara</th>
                                    <th>Status</th>
                                    <th>Tahun</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surat as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ optional($d->deviceType)->subtype }}</td>
                                        <td>{{ $d->brand }}</td>
                                        <td>{{ $d->serial }}</td>
                                        <td>{{ optional($d->stoFirst)->subtype }}</td>
                                        <td>{{ optional($d->stoLast)->subtype }}</td>
                                        <td>
                                            @php
                                                $evidence = $d->evidence ? asset('storage/' . $d->evidence) : null;
                                            @endphp
                                            @if ($evidence)
                                                <a href="javascript:void(0);" onclick="showImage('{{ $evidence }}')">
                                                    <img src="{{ $evidence }}" alt="{{ $d->name }}"
                                                        class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                                </a>
                                            @else
                                                <img src="{{ asset('img/no-image-available.png') }}"
                                                    alt="No image available" class="img-fluid"
                                                    style="max-width: 100px; max-height: 100px;">
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $pdf = $d->ba ? asset('storage/' . $d->ba) : null;
                                            @endphp
                                            @if ($pdf)
                                                <a href="javascript:void(0);" onclick="showPDF('{{ $pdf }}')"
                                                    class="btn btn-primary"><i class="bi bi-eye"></i></a>
                                            @else
                                                <button class="btn btn-secondary" disabled><i
                                                        class="bi bi-eye-slash"></i></button>
                                            @endif
                                        </td>
                                        <td>{{ $d->status }}</td>
                                        <td>{{ $d->status === 'scrap' ? $d->additional : '-' }}</td>
                                        <td>
                                            <a href="{{ route('document.edit', ['id' => $d->id]) }}"
                                                class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if ($user->role == '0')
                                            <button title="Delete" class="btn btn-danger" data-id="{{ $d->id }}"
                                                data-bs-toggle="modal" data-bs-target="#handleDelete"><i
                                                    class="bi bi-trash"></i></button>
                                            
                                            @endif
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

    {{-- IMAGE OVERLAY --}}
    <div id="imageOverlay" class="image-overlay" style="display: none;">
        <span class="close-btn" onclick="closeImageOverlay()">&times;</span>
        <img id="overlayImage" src="" class="overlay-image">
    </div>
    {{-- END OF IMAGE OVERLAY --}}

    <!-- DELETE MODAL -->
    <div class="modal fade" id="handleDelete">
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
    document.addEventListener('DOMContentLoaded', function() {
        var handleDelete = document.getElementById('handleDelete');
        handleDelete.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');

            var deleteForm = document.getElementById('deleteForm');
            var deleteIdInput = document.getElementById('deleteId');

            var action = "{{ route('document.destroy', ':id') }}";
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

    function showPDF(url) {
        window.open(url, '_blank');
    }
</script>
