@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-900">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg dark:bg-gray-800">
            <div class="container mx-auto px-4 py-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 id="title" class="text-3xl font-bold dark:text-gray-300">D-ID Pruebas</h1>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white dark:bg-gray-800">
                        <div
                            class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-300">Agregar Imagen
                                </h5>
                            </div>
                            <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="w-full border rounded mb-3 p-4 bg-white dark:bg-gray-700 dark:text-gray-300">
                                    <h1 class="text-xl font-bold mb-4">Cargar Imagen</h1>
                                    <div id="drag-zone" class="border-dashed border-2 border-gray-400 rounded p-2 min-h-40"
                                        @drop.prevent="handleDrop" @dragover.prevent="handleDragOver">
                                        <input ref="fileInput" type="file" @change="handleFileChange" id="file-input"
                                            name="image" class="hidden">
                                        <label for="file-input">
                                            <img v-if="!image" src="https://via.placeholder.com/100"
                                                alt="Drag and drop or click to upload an image"
                                                class="w-64 cursor-pointer">
                                            <img v-else :src="image" alt="Uploaded Image"
                                                class="w-full object-cover cursor-pointer">
                                        </label>
                                    </div>
                                </div>

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="name">Nombre</label>
                                <input
                                    class="mb-3 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    name="name" id="name" type="text">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="description">Descripcion</label>
                                <x-textarea name="description" id="content" rows="3"></x-textarea>
                                <x-button type="submit">Agregar</x-button>
                            </form>

                        </div>
                    </div>
                    <div
                        class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Lista de Imagenes
                            </h5>
                            <a  class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                Agregar
                            </a>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($images as $image)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 relative">
                                                <img class="w-8 h-8 rounded-full" src="{{ asset('storage/'.$image->image_path) }}"
                                                    alt="Neil image">
                                                <div
                                                    class="overlay w-8 h-8 rounded-full flex items-center justify-center absolute top-0 left-0 bg-black bg-opacity-50 invisible opacity-0 transition-opacity">
                                                    <button class="play-button text-white text-xl">
                                                        <i class="fa-solid fa-download"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $image->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{-- Fecha: {{  Carbon\Carbon::parse($video['created_at']) }} --}}
                                                    Fecha: {{ $image->updated_at }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <x-link-edit
                                                    href="{{ route('images.edit', $image->id) }}">Editar</x-link-edit>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlayList = document.querySelectorAll(".overlay");

            overlayList.forEach((overlay) => {
                const image = overlay.closest(".flex-shrink-0");
                const playButton = overlay.querySelector(".play-button");

                image.addEventListener("mouseenter", () => {
                    overlay.classList.remove("invisible");
                    overlay.classList.add("visible");
                    overlay.classList.remove("opacity-0");
                    overlay.classList.add("opacity-100");
                });

                image.addEventListener("mouseleave", () => {
                    overlay.classList.remove("visible");
                    overlay.classList.add("invisible");
                    overlay.classList.remove("opacity-100");
                    overlay.classList.add("opacity-0");
                });
            });
        });

        function playVideo(path) {
            document.getElementById('video_source').src = path;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#drag-zone',
            data() {
                return {
                    image: null
                };
            },
            methods: {
                handleFileChange(event) {
                    const file = event.target.files[0];
                    this.previewImage(file);
                },
                previewImage(file) {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.image = reader.result;
                    };
                },
                handleDrop(event) {
                    event.preventDefault();
                    const file = event.dataTransfer.files[0];
                    this.previewImage(file);
                },
                handleDragOver(event) {
                    event.preventDefault();
                },
            }
        });
    </script>
@endpush
