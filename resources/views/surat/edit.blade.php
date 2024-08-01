<!-- resources/views/surat/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Edit Document')

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

    <?php if (session()->has('unusual')):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('unusual') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <main class="bd-main p-3 bg-light">
        <form action="{{ route('document.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Device Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $surat->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select" id="type_id" name="type_id">
                            <option value="">Choose...</option>
                            @foreach ($type as $t)
                                <option value="{{ $t->id }}" {{ $t->id == $surat-> type_id ? 'selected' : '' }}>
                                    {{ $t->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                            value="{{ $surat->brand }}">
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial" name="serial"
                            value="{{ $surat->serial }}">
                    </div>
                    <div class="mb-3">
                        <label for="first_sto_id" class="form-label">First STO</label>
                        <select class="form-select" id="first_sto_id" name="first_sto_id">
                            <option value="">Choose...</option>
                            @foreach ($sto as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $surat->first_sto_id ? 'selected' : '' }}>
                                    {{ $s->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="last_sto_id" class="form-label">Last STO</label>
                        <select class="form-select" id="last_sto_id" name="last_sto_id">
                            <option value="">Choose...</option>
                            @foreach ($sto as $s)
                                <option value="{{ $s->id }}" {{ $s->id == $surat->last_sto_id ? 'selected' : '' }}>
                                    {{ $s->subtype }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="evidence" class="form-label">Evidence</label>
                        <input class="form-control" type="file" id="evidence" name="evidence"
                            accept="image/png, image/jpeg">
                        @if ($surat->evidence)
                            <p>Current File: {{ basename($surat->evidence) }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="berita_acara" class="form-label">Berita Acara</label>
                        <input class="form-control" type="file" id="berita_acara" name="berita_acara"
                            accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        @if ($surat->ba)
                            <p>Current File: {{ basename($surat->ba) }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" onchange="toggleYearInput()">
                            @if($surat->status == "belum scrap")
                                <option value="belum scrap">Belum Scrap</option>
                                <option value="scrap">Scrap</option>
                            @elseif($surat->status == "scrap")
                                <option value="scrap">Scrap</option>
                                <option value="belum scrap">Belum Scrap
                            @endif
                        </select>
                    </div>
                    <div class="mb-3" id="yearInput" style="display: none;">
                        <label for="tahun" class="form-label">Tahun Scrap</label>
                        <input type="text" class="form-control" id="tahun" name="tahun"
                            value="{{ $surat->additional }}">
                    </div>
                </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                        <a href="{{ route('viewdocument') }}" class="btn btn-secondary btn-lg">Cancel</a>
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
