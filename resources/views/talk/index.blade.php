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
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-300">Video
                                    Seleccionado</h5>
                            </div>
                            <h2 class="text-xl font-bold mb-4 dark:text-white">Video</h2>
                            <video id="videoElement" class="w-full rounded-lg" controls>
                                <source id="video_source" src="{{ asset('storage/videos/p6fe5hcOk3gRNeR1.mp4') }}"
                                    type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div
                        class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Lista de Videos
                            </h5>
                            <a href="{{ route('talks.create') }}"
                                class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                Agregar
                            </a>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($talks as $talk)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 relative">
                                                <img class="w-8 h-8 rounded-full" {{-- src="{{ json_decode($video->user_data)->thumbnail_url }}" --}}
                                                    src="{{ asset('storage/' . $talk->image->image_path) }}"
                                                    alt="Neil image">
                                                <div
                                                    class="overlay w-8 h-8 rounded-full flex items-center justify-center absolute top-0 left-0 bg-black bg-opacity-50 invisible opacity-0 transition-opacity">
                                                    <button class="play-button text-white text-xl"
                                                        onclick="play({{ $talk->id }})">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $talk->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{-- Fecha: {{  Carbon\Carbon::parse($video['created_at']) }} --}}
                                                    Fecha: {{ $talk->created_at }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('talks.destroy', $talk->id) }}"
                                                    class="text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                                    Eliminar
                                                </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
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

        var video = document.getElementById('video_source');
        var repro = document.getElementById('videoElement');

        async function play(id) {

            await axios.get(`/talks/${id}`)
                .then(response => {
                    // Maneja la respuesta exitosa aquí
                    console.log('Respuesta exitosa:', response.data);
                    if (response.data.error) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        };
                        toastr.error("" + response.data.error);
                    } else {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        };
                        toastr.error("" + response.data.path);
                        video.src = "{{ asset('storage') }}" + "/" + response.data.path;
                        repro.load();
                    }
                })
                .catch(error => {
                    // Maneja los errores aquí
                    console.error('Error:', error);
                });

        }
    </script>
@endpush
