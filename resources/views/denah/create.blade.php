<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Create New Layout')

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

    <?php if (session()->has('fileError')) :?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('fileError') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <main class="bd-main p-3 bg-light">

        <form action="/storedenah" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="sto_id" class="form-label">
                          STO Location
                        </label>
                        <select class="form-select" id="sto_id" name="sto_id">
                        <option value="">Choose...</option>
                          <?php foreach ($sto as $sto) : ?>
                            <option value="<?= $sto->id ?>" <?= old('sto_id') == $sto->id ? 'selected' : '' ?>><?= $sto->subtype?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="room_id" class="form-label">
                          Room Type
                        </label>
                        <select class="form-select" id="room_id" name="room_id">
                        <option value="">Choose...</option>
                          <?php foreach ($room as $room) : ?>
                            <option value="<?= $room->id ?>" <?= old('room_id') == $room->id ? 'selected' : '' ?>><?= $room->subtype?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file">
                        <div class="itali">
                            <span>File type must be .vsd, png, jpg, jpeg</span>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    <button type="button" class="btn btn-secondary btn-lg" onclick="window.location='{{ route('viewdenah') }}'">Cancel</button>
                </div>
            </div>
            <!-- END OF ACTION BUTTONS -->

        </form>

        <!-- <div class="bg-danger" style="height: 100vh;"></div> -->
    </main>

@endsection
