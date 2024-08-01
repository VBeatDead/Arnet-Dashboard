<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Add Document')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('fileError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('fileError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="bd-main p-3 bg-light">
        <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Device Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select" id="type_id" name="type_id">
                            <option value="">Choose...</option>
                            @foreach ($type as $t)
                                <option value="{{ $t->id }}" {{ old('type_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                            value="{{ old('brand') }}">
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial" name="serial"
                            value="{{ old('serial') }}">
                    </div>
                    <div class="mb-3">
                        <label for="first_sto_id" class="form-label">First STO</label>
                        <select class="form-select" id="first_sto_id" name="first_sto_id">
                            <option value="">Choose...</option>
                            @foreach ($sto as $s)
                                <option value="{{ $s->id }}" {{ old('first_sto_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="last_sto_id" class="form-label">Last STO</label>
                        <select class="form-select" id="last_sto_id" name="last_sto_id">
                            <option value="">Choose...</option>
                            @foreach ($sto as $s)
                                <option value="{{ $s->id }}" {{ old('last_sto_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="evidence" class="form-label">Evidence</label>
                        <input class="form-control" type="file" id="evidence" name="evidence"
                            accept="image/png, image/jpeg">
                        <div class="italic">
                            <span>File type must be .png or .jpg</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="berita_acara" class="form-label">Berita Acara</label>
                        <input class="form-control" type="file" id="berita_acara" name="berita_acara"
                            accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <div class="italic">
                            <span>File type must be .pdf or .docx</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" onchange="toggleYearInput()">
                            <option value="">Choose...</option>
                            <option value="belum scrap" {{ old('status') == 'belum scrap' ? 'selected' : '' }}>Belum Scrap
                            </option>
                            <option value="scrap" {{ old('status') == 'scrap' ? 'selected' : '' }}>Scrap</option>
                        </select>
                    </div>
                    <div class="mb-3" id="yearInput" style="display: none;">
                        <label for="tahun" class="form-label">Tahun Scrap</label>
                        <input type="text" class="form-control" id="tahun" name="tahun"
                            value="{{ old('tahun') }}">
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                        <button type="button" class="btn btn-secondary btn-lg"
                            onclick="window.location='{{ route('document.index') }}'">Cancel</button>
                    </div>
                </div>
                <!-- END OF ACTION BUTTONS -->
        </form>
    </main>

    <script>
        function toggleYearInput() {
            var status = document.getElementById('status').value;
            var yearInput = document.getElementById('yearInput');
            if (status === 'scrap') {
                yearInput.style.display = 'block';
            } else {
                yearInput.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleYearInput();
        });
    </script>

@endsection
