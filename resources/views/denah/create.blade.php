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

    @if (session()->has('fileError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('fileError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="p-5 bg-gray-100">
        <form action="{{ route('storedenah') }}" method="post" enctype="multipart/form-data" id="denahForm">
            @csrf
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="sto_id" class="block text-lg font-medium text-gray-700 mb-2">STO Location</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="sto_id" id="sto_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $location)
                                <div class="item" data-value="{{ $location->id }}"
                                    {{ old('sto_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="room_id" class="block text-lg font-medium text-gray-700 mb-2">Room Type</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="room_id" id="room_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($room as $roomType)
                                <div class="item" data-value="{{ $roomType->id }}"
                                    {{ old('room_id') == $roomType->id ? 'selected' : '' }}>
                                    {{ $roomType->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="file" class="block text-lg font-medium text-gray-700 mb-2">Upload Files</label>
                    <div x-data="{ files: [] }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{ 'h-auto': files.length > 0, 'h-32': files.length === 0 }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg">
                                <input type="file" id="file" name="file[]" accept=".vsd, .png, .jpg, .jpeg"
                                    x-ref="fileInput"
                                    @change="files = Array.from($refs.fileInput.files); updateContainerSize($refs.fileInput.files)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-gray-500 pointer-events-none" x-show="files.length === 0">Drag & Drop files
                                    here or click to upload</p>
                                <template x-if="files.length > 0">
                                    <div class="w-full flex flex-row items-center justify-center space-x-4">
                                        <template x-for="(file, index) in files" :key="index">
                                            <div class="flex flex-col items-center space-y-2">
                                                <template x-if="file.name.endsWith('.vsd')">
                                                    <div class="w-full flex flex-col items-center p-3">
                                                        <div class="w-16 h-16 mb-4">
                                                            <img src="{{ asset('img/attachment.png') }}" alt="Uploaded File"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                                <template x-if="!file.name.endsWith('.vsd')">
                                                    <div class="flex flex-col items-center space-y-2">
                                                        <img :src="URL.createObjectURL(file)" alt="Preview"
                                                            class="w-full object-contain rounded-lg"
                                                            x-on:load="updatePreviewHeight"
                                                            :style="{ maxHeight: '480px' };">
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">File types must be .vsd, .png, .jpg, .jpeg.</div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="window.location='{{ route('viewdenah') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </form>
        <x-libs type="form" />
        <script>
            $('.ui.dropdown').dropdown();

            function updatePreviewHeight(event) {
                const img = event.target;
                const container = img.closest('.relative');
                container.style.height = `${img.offsetHeight}px`;
            }

            function updateContainerSize(files) {
                if (files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = function() {
                            const container = document.querySelector('.relative');
                            container.style.height = `${this.height}px`;
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(files[0]);
                }
            }
        </script>
    </main>
@endsection
