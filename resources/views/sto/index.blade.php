@extends('layouts.app')

@section('title', 'Telkom | STO')

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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase">STO</h5>
                        <button type="button" class="btn btn-primary mb-4 mt-3" data-bs-toggle="modal"
                            data-bs-target="#createSTOModal">
                            <i class="bi bi-plus me-3"></i>Create New STO Location
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Room Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stos as $sto)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sto->subtype }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editSTOModal" data-id="{{ $sto->id }}"
                                                data-name="{{ $sto->subtype }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            @if ($user->role == '0')
                                                <button title="Delete" class="btn btn-danger" data-id="{{ $sto->id }}"
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

    <!-- CREATE STO MODAL -->
    <div class="modal fade" id="createSTOModal" tabindex="-1" aria-labelledby="createSTOModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSTOModalLabel">Create New STO Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/storesto" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>
                        <div id="popbtn">
                            <button type="button" id="cencl" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF CREATE STO MODAL -->

    <!-- EDIT STO MODAL -->
    <div class="modal fade" id="editSTOModal" tabindex="-1" aria-labelledby="editSTOModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSTOModalLabel">Edit STO Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSTOForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editSTOId">
                        <div class="mb-4">
                            <label for="editSTOName" class="form-label">Name</label>
                            <input type="text" id="editSTOName" name="name"
                                class="form-control block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>
                        <div id="popbtn" class="d-flex justify-between">
                            <button id="cencl" type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT STO MODAL -->

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
                        <div id="popbtn">
                            <button id="cencl" type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
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

            var action = "{{ route('deletesto', ':id') }}";
            action = action.replace(':id', id);

            deleteForm.action = action;
            deleteIdInput.value = id;
        });

        var editSTOModal = document.getElementById('editSTOModal');
        editSTOModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');

            var editForm = document.getElementById('editSTOForm');
            var editSTOIdInput = document.getElementById('editSTOId');
            var editSTONameInput = document.getElementById('editSTOName');

            var action = "{{ route('sto.update', ':id') }}";
            action = action.replace(':id', id);

            editForm.action = action;
            editSTOIdInput.value = id;
            editSTONameInput.value = name;
        });
    });
</script>
