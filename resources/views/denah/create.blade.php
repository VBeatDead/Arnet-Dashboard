<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Tambah Denah')

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

    <form action="/storedenah" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama File</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File</label>
                    <input class="form-control" type="file" id="file" name="file" >
                </div>
                {{-- <div class="text-center">
                    <img src="./img/geo-alt.svg" id="preview" alt="Placeholder File" width="500" class="img-thumbnail mb-3">
                </div> --}}
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

    <!-- <div class="bg-danger" style="height: 100vh;"></div> -->
</main>

@endsection