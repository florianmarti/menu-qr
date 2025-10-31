{{-- resources/views/restaurant/menus/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Menús') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('menus.create') }}"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                            Crear Nuevo Menú
                        </a>
                    </div>

                    @if ($menus->isEmpty())
                        <p>Aún no tienes menús creados.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach ($menus as $menu)
                                <li class="py-4 flex justify-between items-center">
                                    {{-- BLOQUE PRINCIPAL (Nombre y Descripción) --}}
                                    <div>
                                        <p class="text-lg font-semibold">{{ $menu->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $menu->description }}</p>
                                    </div>

                                    {{-- BLOQUE DE ACCIONES (Ver y Editar) --}}
                                    <div>
                                        {{-- ¡CORRECCIÓN! El enlace "Ver" ahora apunta al índice de categorías --}}
                                        <a href="{{ route('categories.index', $menu) }}"
                                            class="text-indigo-500 hover:text-indigo-600 mr-4">Ver</a>

                                        <a href="{{ route('menus.edit', $menu) }}"
                                            class="text-green-500 hover:text-green-600">Editar</a>

                                        <a href="{{ route('menus.qr', $menu) }}"
                                            class="text-purple-500 hover:text-purple-600">Ver QR</a>
                                        {{-- NUEVO ENLACE --}}
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
