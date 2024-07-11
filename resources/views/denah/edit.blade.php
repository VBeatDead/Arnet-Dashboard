<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Edit Denah')

@section('content')
<main class="bd-main p-3 bg-light">
    <form action="{{ route('denah.update', $denah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $denah->name }}">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/' . $denah->image) }}" id="preview" alt="Placeholder Image" width="500" class="img-thumbnail mb-3">
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                <button type="reset" class="btn btn-secondary btn-lg">Cancel</button>
            </div>
        </div>
        <!-- END OF ACTION BUTTONS -->

    </form>
</main>
@endsection
