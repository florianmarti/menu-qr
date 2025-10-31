{{-- resources/views/restaurant/categories/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías del Menú: ') . $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('menus.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mb-4 block">
                        &larr; Volver a Menús
                    </a>

                    <div class="mb-4 flex justify-between items-center">
                        {{-- Enlace para crear una nueva categoría --}}
                        <a href="{{ route('categories.create', $menu) }}"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                            Añadir Nueva Categoría
                        </a>
                    </div>

                    @if ($categories->isEmpty())
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p>Este menú aún no tiene categorías. ¡Añade la primera!</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-200 mt-4">
                            @foreach ($categories as $category)
                                <li class="py-4 flex justify-between items-center">
                                    <div>
                                        <p class="text-lg font-semibold">{{ $category->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                    </div>
                                    <div>
                                        {{-- CORRECCIÓN: Apuntamos al índice de Items, pasando Menu y Category --}}
                                        <a href="{{ route('items.index', [$menu, $category]) }}"
                                            class="text-indigo-500 hover:text-indigo-600 mr-4">Ver Platos</a>
                                        <a href="{{ route('categories.edit', [$menu, $category]) }}"
                                            class="text-green-500 hover:text-green-600">Editar</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
