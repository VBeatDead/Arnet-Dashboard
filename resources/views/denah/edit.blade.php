<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Edit Layout')

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

    <?php if (session()->has('unusual')) :?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('unusual') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <main class="bd-main p-3 bg-light">
        <form action="{{ route('denah.update', $denah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="sto_id" class="form-label">
                            STO Location
                        </label>
                        <select class="form-select" id="sto_id" name="sto_id">
                            <option value="">Choose...</option>
                            <?php foreach ($sto as $sto) : ?>
                            <option value="<?= $sto->id ?>" <?= $denah->sto_id == $sto->id ? 'selected' : '' ?>>
                                <?= $sto->subtype ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label">
                            Tipe Ruangan
                        </label>
                        <select class="form-select" id="room_id" name="room_id">
                            <option value="">Choose...</option>
                            <?php foreach ($room as $room) : ?>
                            <option value="<?= $room->id ?>" <?= $denah->room_id == $room->id ? 'selected' : '' ?>>
                                <?= $room->subtype ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file"
                            value="{{ $denah->file }}">
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            @php
                                $convertedImageUrl = $denah->converted_image ? asset($denah->converted_image) : null;
                            @endphp
                            @if ($convertedImageUrl)
                                <a href="javascript:void(0);" onclick="showImage('{{ $convertedImageUrl }}')">
                                    <img src="{{ $convertedImageUrl }}" alt="{{ $denah->name }}" class="img-fluid"
                                        style="max-width: 100%; max-height: 100%">
                                </a>
                            @else
                                <img src="public\img\403-error-forbidden-animate.svg" alt="No image available"
                                    class="img-fluid" style="max-width: 100%; max-height: 100%">
                            @endif
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            <a href="{{ route('viewdenah') }}" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>
                    </div>
                    <!-- END OF ACTION BUTTONS -->
        </form>
    </main>
@endsection
