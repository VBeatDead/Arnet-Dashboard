@extends('layouts.app')

@section('title', 'Telkom | Add CME Document')

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

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="bd-main p-3 bg-light">
        <form action="{{ route('cme.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">CME Potential</label>
                        <input class="form-control" type="file" id="file" name="file" >
                        <div class="italic">
                            <span>File type must be Excel format</span>
                        </div>
                    </div>
                    <!-- ACTION BUTTONS -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            <button type="button" class="btn btn-secondary btn-lg"
                                onclick="window.location='{{ route('cme.index') }}'">Cancel</button>
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
