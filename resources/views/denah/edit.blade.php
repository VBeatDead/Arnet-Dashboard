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

    @if (session()->has('unusual'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('unusual') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="p-5 bg-gray-100">
        <form action="{{ route('denah.update', $denah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="sto_id" class="block text-lg font-medium text-gray-700 mb-2">STO Location</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="sto_id" id="sto_id" value="{{ $denah->sto_id }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $location)
                                <div class="item" data-value="{{ $location->id }}"
                                    {{ $denah->sto_id == $location->id ? 'selected' : '' }}>
                                    {{ $location->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="room_id" class="block text-lg font-medium text-gray-700 mb-2">Room Type</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="room_id" id="room_id" value="{{ $denah->room_id }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($room as $roomType)
                                <div class="item" data-value="{{ $roomType->id }}"
                                    {{ $denah->room_id == $roomType->id ? 'selected' : '' }}>
                                    {{ $roomType->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="file" class="block text-lg font-medium text-gray-700 mb-2">Upload Files</label>
                    <div x-data="{ files: [], hasPreviousFile: {{ $denah->converted_image ? 'true' : 'false' }} }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{
                                'h-auto': files.length > 0 || hasPreviousFile,
                                'h-32': files.length === 0 && !
                                    hasPreviousFile
                            }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg overflow-hidden">
                                <input type="file" id="file" name="file[]" accept=".vsd, .png, .jpg, .jpeg"
                                    x-ref="fileInput"
                                    @change="files = Array.from($refs.fileInput.files); updateContainerSize($refs.fileInput.files)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-gray-500 pointer-events-none"
                                    x-show="files.length === 0 && !hasPreviousFile">Drag & Drop files here or click to
                                    upload</p>
                                <template x-if="files.length > 0">
                                    <div class="w-full flex flex-row items-center justify-center space-x-4">
                                        <template x-for="(file, index) in files" :key="index">
                                            <div class="flex flex-col items-center space-y-2">
                                                <template x-if="file.name.endsWith('.vsd')">
                                                    <div class="w-full flex flex-col items-center p-3">
                                                        <div class="w-16 h-16 mb-4">
                                                            <img src="{{ asset('img/attachment.png') }}"
                                                                alt="Uploaded File" class="w-full h-full object-cover">
                                                        </div>
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                                <template x-if="!file.name.endsWith('.vsd')">
                                                    <div class="flex flex-col items-center space-y-2">
                                                        <img :src="URL.createObjectURL(file)" alt="Preview"
                                                            class="w-full object-contain rounded-lg"
                                                            x-on:load="updateContainerSize"
                                                            :style="{ maxHeight: '480px' };">
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                @if ($denah->converted_image)
                                    <template x-if="files.length === 0">
                                        <div class="w-full flex flex-col items-center">
                                            <img src="{{ $denah->converted_image }}" alt="Previous File"
                                                class="w-full object-contain rounded-lg" style="max-height: 480px;">
                                            <p class="text-gray-700 text-sm">{{ basename($denah->converted_image) }}</p>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">File types must be .vsd, .png, .jpg, .jpeg.</div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <a href="{{ route('viewdenah') }}" class="btn btn-secondary btn-lg">Cancel</a>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </form>
        <x-libs type="form" />
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('fileUpload', () => ({
                    files: [],
                    updateContainerSize(files) {
                        if (files.length > 0) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const img = new Image();
                                img.onload = function() {
                                    const container = document.querySelector('.relative');
                                    container.style.height = `${this.height}px`;
                                    container.style.width = `${this.width}px`;
                                };
                                img.src = e.target.result;
                            };
                            reader.readAsDataURL(files[0]);
                        }
                    },
                    updateContainerSize(event) {
                        const img = event.target;
                        const container = img.closest('.relative');
                        container.style.height = `${img.naturalHeight}px`;
                        container.style.width = `${img.naturalWidth}px`;
                    }
                }));
            });

            $('.ui.dropdown').dropdown();
        </script>
    </main>
@endsection
