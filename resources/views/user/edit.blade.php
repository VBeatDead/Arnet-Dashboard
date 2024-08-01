<!-- resources/views/surat/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Telkom | Edit User')

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
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter new password">
                    <small class="form-text text-muted">Leave blank if you do not want to change the password.</small>
                </div>
                <div>
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option>Choose...</option>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>User</option>
                    </select>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    <a href="{{ route('viewuser') }}" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </div>
            <!-- END OF ACTION BUTTONS -->
    </form>
</main>
@endsection