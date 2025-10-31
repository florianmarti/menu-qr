<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Códigos QR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="mb-6 text-gray-600 dark:text-gray-400">
                        Aquí puedes ver todos tus menús y acceder rápidamente al código QR de cada uno para imprimirlo o compartirlo.
                    </p>

                    @if ($menus->isEmpty())
                        {{-- Mensaje si no hay menús --}}
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg" role="alert">
                            <p class="font-bold">No tienes menús</p>
                            <p>Aún no has creado ningún menú. <a href="{{ route('menus.index') }}" class="font-bold underline">Ve a Gestión de Menús</a> para empezar.</p>
                        </div>
                    @else
                        {{-- Lista de menús --}}
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($menus as $menu)
                                <li class="py-4 flex justify-between items-center">
                                    {{-- BLOQUE PRINCIPAL (Nombre y Descripción) --}}
                                    <div>
                                        <p class="text-lg font-semibold">{{ $menu->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $menu->description }}</p>
                                    </div>

                                    {{-- BLOQUE DE ACCIONES (Ver QR) --}}
                                    <div>
                                        <a href="{{ route('menus.qr', $menu) }}"
                                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                                            Ver QR
                                        </a>
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
