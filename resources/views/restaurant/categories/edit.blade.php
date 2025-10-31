{{-- resources/views/restaurant/categories/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría: ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Volver a la lista de categorías --}}
                    <a href="{{ route('categories.index', $menu) }}" class="text-sm text-indigo-600 hover:text-indigo-800 mb-4 block">
                        &larr; Volver a Categorías
                    </a>

                    {{-- Formulario de edición: Usamos el método PUT para actualizar --}}
                    <form method="POST" action="{{ route('categories.update', [$menu, $category]) }}" class="mb-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="order" :value="__('Orden de Visualización')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $category->order)" required />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $category->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <hr class="my-6 border-gray-200">

                    {{-- Formulario para Eliminar Categoría --}}
                    <form method="POST" action="{{ route('categories.destroy', [$menu, $category]) }}">
                        @csrf
                        @method('DELETE')

                        <x-danger-button class="mt-4" onclick="return confirm('¿Estás seguro de que deseas eliminar la categoría {{ $category->name }}? Se eliminarán todos los platos asociados.')">
                            {{ __('Eliminar Categoría') }}
                        </x-danger-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
