@extends('layouts.app')

@section('title', 'Telkom | Edit Topology')

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

    <main class="p-5 bg-gray-100">
        <form action="{{ route('topology.update', $topology->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="file" class="block text-lg font-medium text-gray-700 mb-2">Upload File</label>
                    <div x-data="{ file: null }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg">
                            <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg" x-ref="fileInput"
                                @change="file = $refs.fileInput.files[0]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <p class="text-gray-500 pointer-events-none p-20" x-show="!file">Drag & Drop file here or click
                                to
                                upload</p>
                            <template x-if="file">
                                <div class="w-full flex flex-col items-center">
                                    <img :src="URL.createObjectURL(file)" alt="Preview"
                                        class="w-full object-contain rounded-lg" :style="{ maxHeight: '480px' }">
                                    <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">File type must be png, jpg, jpeg.</div>
                    @if ($topology->file)
                        <p class="mt-2">Current File: <a href="{{ asset('storage/uploads/topology/' . $topology->file) }}"
                                download class="text-blue-500">{{ $topology->file }}</a></p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="device_id" class="block text-lg font-medium text-gray-700 mb-2">Device Type</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="device_id" id="device_id"
                            value="{{ old('device_id', $topology->device_id) }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($devices as $device)
                                <div class="item" data-value="{{ $device->id }}">
                                    {{ $device->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="window.location='{{ route('topology.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg">Update</button>
            </div>
        </form>
        <x-libs type="form" />
        <script>
            $('.ui.dropdown').dropdown();
        </script>
    </main>
@endsection
