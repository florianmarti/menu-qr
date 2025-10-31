<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> {{-- Added dark mode --}}
            {{ __('Añadir Nuevo Plato a: ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> {{-- Added dark mode --}}
                <div class="p-6 text-gray-900 dark:text-gray-100"> {{-- Added dark mode --}}

                    {{-- Enlace Volver --}}
                    <a href="{{ route('items.index', ['menu' => $menu, 'category' => $category]) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 mb-4 block">
                        &larr; Volver a Platos de la Categoría: {{ $category->name }}
                    </a>

                    {{-- Formulario - Añadido enctype --}}
                    <form method="POST" action="{{ route('items.store', ['menu' => $menu, 'category' => $category]) }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Nombre del Plato --}}
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre del Plato')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        {{-- Precio --}}
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Precio')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        {{-- Campo de Imagen --}}
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Imagen del Plato (Opcional)')" />
                            <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 dark:file:bg-indigo-800 file:text-indigo-700 dark:file:text-indigo-200
                                hover:file:bg-indigo-100 dark:hover:file:bg-indigo-700" accept="image/jpeg,image/png,image/gif,image/svg+xml"/>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Recomendado: JPG, PNG, GIF, SVG. Tamaño máximo: 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        {{-- Disponibilidad --}}
                        <div class="mb-4 flex items-center">
                            <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', '1') == '1' ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <x-input-label for="is_available" :value="__('Plato Disponible')" class="ml-2" />
                            <x-input-error class="mt-2" :messages="$errors->get('is_available')" />
                        </div>

                        {{-- >>>>>>>>>>>> CHECKBOX MOSTRAR IMAGEN <<<<<<<<<<<<<< --}}
                        <div class="mb-6 flex items-center">
                            <input id="show_image" name="show_image" type="checkbox" value="1" {{ old('show_image', '1') == '1' ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <x-input-label for="show_image" :value="__('Mostrar Imagen en el Menú Público')" class="ml-2" />
                            <x-input-error class="mt-2" :messages="$errors->get('show_image')" />
                        </div>
                        {{-- >>>>>>>>>>>>>>>>> FIN CHECKBOX MOSTRAR IMAGEN <<<<<<<<<<<<<<< --}}

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Guardar Plato') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
