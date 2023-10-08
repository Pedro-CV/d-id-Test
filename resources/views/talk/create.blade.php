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
                            class="w-full mb-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-300">Imagen
                                    Seleccionada</h5>
                            </div>
                            <div class="grid gap-4">
                                <div>
                                    <img id="1" class="selected_image h-auto max-w-full rounded-lg"
                                        src="https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg">
                                </div>
                                <hr class="my-4">
                                <div class="grid grid-cols-5 gap-4">
                                    @foreach ($images as $image)
                                        <div>
                                            <img id="image_{{ $image->id }}"
                                                class="h-full object-cover rounded-lg hover:border-2 hover:border-blue-600"
                                                src="{{ asset('storage/' . $image->image_path) }}"
                                                onclick="selectionImage('{{ $image->id }}', '{{ $image->image_uri }}', '{{ $image->image_path }}' )" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div
                        class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Agregar Video Talk
                            </h5>
                        </div>
                        <div class="flow-root">
                            <form action="{{ route('talks.store') }}" method="POST">
                                @csrf
                                <input type="text" id="id_image" name="id_image" value="1" hidden />
                                <input type="text" id="imageUrl" name="imageUrl" value="" hidden />
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="name">Nombre</label>
                                <input
                                    class="mb-3 w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600"
                                    name="name" id="name" type="text">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="name">Idioma</label>
                                <select
                                    class="mb-3 w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600"
                                    name="language">
                                    @foreach ($voices as $voice)
                                        <option value="{{ $voice->id }}">
                                            {{ $voice->language . ', ' . $voice->gender . ', ' . $voice->name }}</option>
                                    @endforeach
                                </select>

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="content">Descripcion</label>
                                <x-textarea name="content" id="content" rows="3"></x-textarea>

                                <div class="mb-4">
                                    <label for="items"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-200">Agregar
                                        Emociones</label>
                                    <ul id="items" class="space-y-2 mb-3">
                                        <li class="flex dark:text-gray-400">
                                            <span class="block w-1/3">N#Frames</span>
                                            <span class="block w-1/5">Intensidad</span>
                                            <span class="block w-1/3">Emocion</span>
                                        </li>
                                        <li>
                                            <input type="text" name="frames[]"
                                                class="p-1 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                                            <input type="number" max="1" min="0.1" step="0.01" name="intensity[]"
                                                class="w-16 p-1 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                                            <select name="emotions[]" id="emotion"
                                                class="p-1 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                                                <option value="surprise">Soprendido</option>
                                                <option value="happy">Feliz</option>
                                                <option value="neutral">Neutro</option>
                                                <option value="serious">Serio</option>
                                            </select>
                                            <button type="button"
                                                class="ml-1 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none eliminar-item">Eliminar</button>
                                        </li>
                                        <!-- Agregar más elementos aquí mediante JavaScript -->
                                    </ul>
                                    <button type="button" id="agregarItem"
                                        class="w-full mt-2 px-4 py-2 text-white border border-gray-300 border-2 border-dashed rounded hover:bg-green-600 focus:outline-none">Agregar
                                        Emocion</button>
                                </div>
                                <x-button type="submit">Agregar</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var dir = "{{ asset('storage') }}";
        var input_id = document.getElementById('id_image');
        var input_url = document.getElementById('imageUrl');

        function selectionImage(id, image_uri, image_path) {
            var selectedImage = document.querySelector(".selected_image");
            console.log(selectedImage.id);

            selectImage = document.getElementById('image_' + id);
            selectImage.classList.add("border-2");
            selectImage.classList.add("border-blue-600");

            unSelectImage = document.getElementById('image_' + selectedImage.id);
            unSelectImage.classList.remove("border-2");
            unSelectImage.classList.remove("border-blue-600");

            selectedImage.id = id;
            input_id.value = id;
            imageUrl.value = image_uri;
            selectedImage.src = dir + "/" + image_path;

        }
    </script>
    <script>
        const agregarItemButton = document.getElementById('agregarItem');
        const itemsList = document.getElementById('items');

        agregarItemButton.addEventListener('click', () => {
            const newItem = document.createElement('li');
            newItem.innerHTML = `
            <input type="text" name="frames[]" class="p-1 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
            <select name="emotions[]" id="emotion" class="p-1 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                <option value="surprise">Soprendido</option>
                <option value="happy">Feliz</option>
                <option value="neutral">Neutro</option>
                <option value="serious">Serio</option>
            </select>
            <button type="button" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none eliminar-item">Eliminar</button>
        `;
            itemsList.appendChild(newItem);
        });

        itemsList.addEventListener('click', (event) => {
            if (event.target.classList.contains('eliminar-item')) {
                event.target.parentNode.remove();
            }
        });
    </script>
@endpush
