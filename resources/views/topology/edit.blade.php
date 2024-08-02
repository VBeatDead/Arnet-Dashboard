@extends('layouts.app')

@section('title', 'Telkom | Edit Topology')

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

    <main class="bd-main p-3 bg-light">
        <form action="{{ route('topology.update', $topology->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".png, .jpg, .jpeg">
                        <div class="itali">
                            <span>File type must be png, jpg, jpeg</span>
                        </div>
                        @if ($topology->file)
                            <p>Current File: <a href="{{ asset('storage/uploads/topology/' . $topology->file) }}"
                                    download>{{ $topology->file }}</a></p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="device_id" class="form-label">Device Type</label>
                        <select class="form-select" id="device_id" name="device_id">
                            <option value="">Choose...</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}"
                                    {{ $topology->device_id == $device->id ? 'selected' : '' }}>
                                    {{ $device->subtype }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-lg">Update</button>
                    <button type="button" class="btn btn-secondary btn-lg"
                        onclick="window.location='{{ route('topology.index') }}'">Cancel</button>
                </div>
            </div>
            <!-- END OF ACTION BUTTONS -->
        </form>
    </main>
@endsection
