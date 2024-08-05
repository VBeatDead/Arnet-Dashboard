@extends('layouts.app')

@section('title', 'Telkom | Edit Document')

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
        <form action="{{ route('document.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Device Name</label>
                    <input type="text" id="name" name="name" value="{{ $surat->name }}" class="form-control">
                </div>

                <div class="mb-4">
                    <label for="type_id" class="block text-lg font-medium text-gray-700 mb-2">Type</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="type_id" id="type_id" value="{{ $surat->type_id }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($type as $t)
                                <div class="item" data-value="{{ $t->id }}"
                                    {{ $t->id == $surat->type_id ? 'selected' : '' }}>
                                    {{ $t->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="brand" class="block text-lg font-medium text-gray-700 mb-2">Brand</label>
                    <input type="text" id="brand" name="brand" value="{{ $surat->brand }}" class="form-control">
                </div>

                <div class="mb-4">
                    <label for="serial" class="block text-lg font-medium text-gray-700 mb-2">Serial Number</label>
                    <input type="text" id="serial" name="serial" value="{{ $surat->serial }}" class="form-control">
                </div>

                <div class="mb-4">
                    <label for="first_sto_id" class="block text-lg font-medium text-gray-700 mb-2">First STO</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="first_sto_id" id="first_sto_id" value="{{ $surat->first_sto_id }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $s)
                                <div class="item" data-value="{{ $s->id }}"
                                    {{ $s->id == $surat->first_sto_id ? 'selected' : '' }}>
                                    {{ $s->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="last_sto_id" class="block text-lg font-medium text-gray-700 mb-2">Last STO</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="last_sto_id" id="last_sto_id" value="{{ $surat->last_sto_id }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $s)
                                <div class="item" data-value="{{ $s->id }}"
                                    {{ $s->id == $surat->last_sto_id ? 'selected' : '' }}>
                                    {{ $s->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Evidence Field -->
                <div class="mb-4">
                    <label for="evidence" class="block text-lg font-medium text-gray-700 mb-2">Evidence</label>
                    <div x-data="{ files: [], hasPreviousFile: {{ $surat->evidence ? 'true' : 'false' }} }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{
                                'h-auto': files.length > 0 || hasPreviousFile,
                                'h-32': files.length === 0 && !hasPreviousFile
                            }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg overflow-hidden">
                                <input type="file" id="evidence" name="evidence" accept="image/png, image/jpeg"
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
                                                <template x-if="file.name.endsWith('.pdf')">
                                                    <div class="w-full flex flex-col items-center p-3">
                                                        <div class="w-16 h-16 mb-4">
                                                            <img src="{{ asset('img/attachment.png') }}"
                                                                alt="Uploaded File" class="w-full h-full object-cover">
                                                        </div>
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                                <template x-if="!file.name.endsWith('.pdf')">
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
                                @if ($surat->evidence)
                                    <template x-if="files.length === 0">
                                        <div class="w-full flex flex-col items-center">
                                            <img src="{{ asset('storage/uploads/evidence/' . basename($surat->evidence)) }}"
                                                alt="Previous File" class="w-full object-contain rounded-lg"
                                                style="max-height: 480px;">
                                            <p class="text-gray-700 text-sm">{{ basename($surat->evidence) }}</p>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="italic text-gray-500 text-sm mt-1">File type must be .png or .jpg</div>
                </div>

                <!-- Berita Acara Field -->
                <div class="mb-4">
                    <label for="berita_acara" class="block text-lg font-medium text-gray-700 mb-2">Berita Acara</label>
                    <div x-data="{ files: [], hasPreviousFile: {{ $surat->ba ? 'true' : 'false' }} }"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{
                                'h-auto': files.length > 0 || hasPreviousFile,
                                'h-32': files.length === 0 && !hasPreviousFile
                            }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg overflow-hidden">
                                <input type="file" id="berita_acara" name="berita_acara"
                                    accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    x-ref="fileInput" @change="files = Array.from($refs.fileInput.files);"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-gray-500 pointer-events-none"
                                    x-show="files.length === 0 && !hasPreviousFile">Drag & Drop files here or click to
                                    upload</p>
                                <template x-if="files.length > 0">
                                    <div class="w-full flex flex-row items-center justify-center space-x-4">
                                        <template x-for="(file, index) in files" :key="index">
                                            <div class="flex flex-col items-center space-y-2">
                                                <template x-if="file.name.endsWith('.pdf')">
                                                    <div class="w-full flex flex-col items-center p-3">
                                                        <div class="w-16 h-16 mb-4">
                                                            <img src="{{ asset('img/attachment.png') }}"
                                                                alt="Uploaded File" class="w-full h-full object-cover">
                                                        </div>
                                                        <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                                    </div>
                                                </template>
                                                <template x-if="!file.name.endsWith('.pdf')">
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
                                @if ($surat->ba)
                                    <template x-if="files.length === 0">
                                        <div class="w-full flex flex-col items-center p-3">
                                            <img src="{{ asset('img/attachment.png') }}" alt="Previous File"
                                                class="w-16 h-16 object-cover mb-4" style="max-height: 200px;">
                                            <p class="text-gray-700 text-sm">{{ basename($surat->ba) }}</p>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="italic text-gray-500 text-sm mt-1">File type must be .pdf or .docx</div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-lg font-medium text-gray-700 mb-2">Status</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="status" id="status" value="{{ $surat->status }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="belum scrap"
                                {{ $surat->status == 'belum scrap' ? 'selected' : '' }}>Belum Scrap</div>
                            <div class="item" data-value="scrap" {{ $surat->status == 'scrap' ? 'selected' : '' }}>
                                Scrap</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4" id="yearInput"
                    style="{{ $surat->status == 'scrap' ? 'display: block;' : 'display: none;' }}">
                    <label for="tahun" class="block text-lg font-medium text-gray-700 mb-2">Tahun Scrap</label>
                    <input type="text" id="tahun" name="tahun" value="{{ $surat->additional }}"
                        class="form-control">
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <a href="{{ route('viewdocument') }}" class="btn btn-secondary btn-lg">Cancel</a>
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

            document.getElementById('status').addEventListener('change', function() {
                const yearInput = document.getElementById('yearInput');
                yearInput.style.display = this.value === 'scrap' ? 'block' : 'none';
            });
        </script>
    </main>
@endsection
