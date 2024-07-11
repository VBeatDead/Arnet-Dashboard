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
                    @php
                        $convertedImageUrl = $denah->converted_image ? asset($denah->converted_image) : null;
                    @endphp
                    @if ($convertedImageUrl)
                        <a href="javascript:void(0);" onclick="showImage('{{ $convertedImageUrl }}')">
                            <img src="{{ $convertedImageUrl }}" alt="{{ $denah->name }}" class="img-fluid"
                                style="max-width: 100%; max-height: 100%">
                        </a>
                    @else
                        <img src="public\img\403-error-forbidden-animate.svg" alt="No image available" class="img-fluid"
                            style="max-width: 100%; max-height: 100%">
                    @endif
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
