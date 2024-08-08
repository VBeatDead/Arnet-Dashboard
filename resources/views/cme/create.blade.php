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

    <main class="p-5 bg-gray-100">
        <form action="{{ route('cme.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div>
                    <label for="file" class="block text-lg font-medium text-gray-700 mb-2">Upload File</label>
                    <div x-data="{ file: null }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg">
                            <input type="file" id="file" name="file" accept=".xlsx" x-ref="fileInput"
                                @change="file = $refs.fileInput.files[0]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <p class="text-gray-500 pointer-events-none p-20" x-show="!file">Drag & Drop file here or click
                                to upload</p>
                            <template x-if="file">
                                <div class="w-full flex flex-col items-center p-3">
                                    <div class="w-16 h-16 mb-4">
                                        <img src="{{ asset('img/attachment.png') }}" alt="Uploaded File"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">File type must be Excel format (.xlsx).</div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="window.location='{{ route('cme.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </form>
    </main>
    <x-libs type="form" />
@endsection
