@extends('layouts.app')

@section('title', 'Telkom | Add Document')

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
        <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="documentForm">
            @csrf
            <div class="bg-white shadow-lg rounded-lg p-6 mb-5">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Device Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label for="type_id" class="block text-lg font-medium text-gray-700 mb-2">Type</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="type_id" id="type_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($type as $t)
                                <div class="item" data-value="{{ $t->id }}"
                                    {{ old('type_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="brand" class="block text-lg font-medium text-gray-700 mb-2">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}">
                </div>

                <div class="mb-4">
                    <label for="serial" class="block text-lg font-medium text-gray-700 mb-2">Serial Number</label>
                    <input type="text" class="form-control" id="serial" name="serial" value="{{ old('serial') }}">
                </div>

                <div class="mb-4">
                    <label for="first_sto_id" class="block text-lg font-medium text-gray-700 mb-2">First STO</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="first_sto_id" id="first_sto_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $s)
                                <div class="item" data-value="{{ $s->id }}"
                                    {{ old('first_sto_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="last_sto_id" class="block text-lg font-medium text-gray-700 mb-2">Last STO</label>
                    <div class="ui fluid search selection dropdown">
                        <input type="hidden" name="last_sto_id" id="last_sto_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            @foreach ($sto as $s)
                                <div class="item" data-value="{{ $s->id }}"
                                    {{ old('last_sto_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->subtype }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="evidence" class="block text-lg font-medium text-gray-700 mb-2">Evidence</label>
                    <div x-data="{ evidenceFiles: [] }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{ 'h-auto': evidenceFiles.length > 0, 'h-32': evidenceFiles.length === 0 }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg">
                                <input type="file" id="evidence" name="evidence" accept="image/png, image/jpeg"
                                    x-ref="evidenceInput"
                                    @change="evidenceFiles = Array.from($refs.evidenceInput.files); updateEvidenceContainerSize($refs.evidenceInput.files)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-gray-500 pointer-events-none" x-show="evidenceFiles.length === 0">Drag & Drop
                                    files here or click to upload</p>
                                <template x-if="evidenceFiles.length > 0">
                                    <div class="w-full flex flex-row items-center justify-center space-x-4">
                                        <template x-for="(file, index) in evidenceFiles" :key="index">
                                            <div class="flex flex-col items-center space-y-2 p-3">
                                                <img :src="URL.createObjectURL(file)" alt="Preview"
                                                    class="w-full object-contain rounded-lg"
                                                    x-on:load="updatePreviewHeight" :style="{ maxHeight: '480px' };">
                                                <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="italic text-gray-500 text-sm mt-1">File type must be .png or .jpg</div>
                </div>

                <div class="mb-4">
                    <label for="berita_acara" class="block text-lg font-medium text-gray-700 mb-2">Berita Acara</label>
                    <div x-data="{ beritaAcaraFiles: [] }"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="flex flex-col items-center">
                            <div :class="{ 'h-auto': beritaAcaraFiles.length > 0, 'h-32': beritaAcaraFiles.length === 0 }"
                                class="relative w-full flex items-center justify-center border-2 border-gray-300 rounded-lg">
                                <input type="file" id="berita_acara" name="berita_acara"
                                    accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    x-ref="beritaAcaraInput"
                                    @change="beritaAcaraFiles = Array.from($refs.beritaAcaraInput.files); updateBeritaAcaraContainerSize($refs.beritaAcaraInput.files)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-gray-500 pointer-events-none" x-show="beritaAcaraFiles.length === 0">Drag &
                                    Drop files here or click to upload</p>
                                <template x-if="beritaAcaraFiles.length > 0">
                                    <div class="w-full flex flex-row items-center justify-center space-x-4">
                                        <template x-for="(file, index) in beritaAcaraFiles" :key="index">
                                            <div class="flex flex-col items-center space-y-2 p-3">
                                                <div class="w-16 h-16 mb-4">
                                                    <img src="{{ asset('img/attachment.png') }}" alt="Uploaded File"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <p class="text-gray-700 text-sm" x-text="file.name"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="italic text-gray-500 text-sm mt-1">File type must be .pdf or .docx</div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-lg font-medium text-gray-700 mb-2">Status</label>
                    <div class="ui fluid selection dropdown" x-data="{ status: '{{ old('status') }}' }" @change="toggleYearInput()">
                        <input type="hidden" name="status" id="status" x-model="status">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choose...</div>
                        <div class="menu">
                            <div class="item" data-value="">Choose...</div>
                            <div class="item" data-value="belum scrap"
                                {{ old('status') == 'belum scrap' ? 'selected' : '' }}>Belum Scrap</div>
                            <div class="item" data-value="scrap" {{ old('status') == 'scrap' ? 'selected' : '' }}>Scrap
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4" x-show="status === 'scrap'" id="yearInput" style="display: none;">
                    <label for="tahun" class="block text-lg font-medium text-gray-700 mb-2">Tahun Scrap</label>
                    <input type="text" class="form-control" id="tahun" name="tahun"
                        value="{{ old('tahun') }}">
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-3 flex justify-between space-x-4">
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="window.location='{{ route('document.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </form>
        <x-libs type="form" />
        <script>
            $('.ui.dropdown').dropdown();

            function toggleYearInput() {
                var status = document.getElementById('status').value;
                var yearInput = document.getElementById('yearInput');
                if (status === 'scrap') {
                    yearInput.style.display = 'block';
                } else {
                    yearInput.style.display = 'none';
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                toggleYearInput();
            });

            function updatePreviewHeight(event) {
                const img = event.target;
                const container = img.closest('.relative');
                container.style.height = `${img.offsetHeight}px`;
            }

            function updateEvidenceContainerSize(files) {
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

            function updateBeritaAcaraContainerSize(files) {
                if (files.length > 0) {
                    const container = document.querySelector('.relative');
                    container.style.height = 'auto';
                }
            }
        </script>
    </main>
@endsection
