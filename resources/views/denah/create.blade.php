@extends('layouts.app')

@section('title', 'Tambah Denah STO')

@section('content')

<main class="bd-main p-3 bg-light">

    <form action="{{ route('denah.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>
                <div class="text-center">
                    <img src="./img/geo-alt.svg" id="preview" alt="Placeholder Image" width="500" class="img-thumbnail mb-3">
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                <a href="./dashboard" class="btn btn-secondary btn-lg">Cancel</a>
            </div>
        </div>
        <!-- END OF ACTION BUTTONS -->

    </form>

</main>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
