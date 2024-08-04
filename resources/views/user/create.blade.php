@extends('layouts.app')

@section('title', 'Telkom | Add User')

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

    <?php if (session()->has('fileError')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('fileError') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <main class="p-5 bg-gray-100">
        <form action="/storeuser" method="post" enctype="multipart/form-data">
            @csrf
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="form-control block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-lg font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}"
                        class="form-control block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-lg font-medium text-gray-700 mb-2">Role</label>
                    <select id="role" name="role"
                        class="form-select block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option>Choose...</option>
                        <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>User</option>
                    </select>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="window.location='{{ route('viewuser') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </form>
    </main>
    <x-libs type="form" />
@endsection
