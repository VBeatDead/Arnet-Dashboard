  <!-- resources/views/dashboard.blade.php -->
  @extends('layouts.app')

  @section('title', 'Telkom | Create New Topology')

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

          <form action="/storetopology" method="post" enctype="multipart/form-data">
              
              <div class="card mb-3">
                  <div class="card-body">
                      <div class="mb-3">
                          <label for="file" class="form-label">File</label>
                          <input class="form-control" type="file" id="file" name="file">
                          <div class="itali">
                              <span>File type must be png, jpg, jpeg</span>
                          </div>
                      </div>
                        <div class="mb-3">
                          <label for="device_id" class="form-label">
                            Device Type
                          </label>
                          <select class="form-select" id="room_id" name="room_id">
                          <option value="">Choose...</option>
                         
                          </select>
                        </div>
                  </div>
              </div>

              <!-- ACTION BUTTONS -->
              <div class="card">
                  <div class="card-body">
                      <button type="submit" class="btn btn-primary btn-lg">Save</button>
                      <button type="button" class="btn btn-secondary btn-lg" onclick="window.location='{{ route('topology.index') }}'">Cancel</button>
                  </div>
              </div>
              <!-- END OF ACTION BUTTONS -->

          </form>

          <!-- <div class="bg-danger" style="height: 100vh;"></div> -->
      </main>

  @endsection
