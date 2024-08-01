<!-- resources/views/surat/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Edit Room Type')

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
    <form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $room->subtype }}">
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    <a href="{{ route('viewroom') }}" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </div>
            <!-- END OF ACTION BUTTONS -->
    </form>
</main>
@endsection