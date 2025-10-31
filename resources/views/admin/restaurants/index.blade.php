 
<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Restaurantes') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('Ver, editar y administrar todas las cuentas de restaurantes.') }}
    </x-slot>

    {{-- <x-slot name="actions"> ... </x-slot> --}}

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        {{--
          NOTA: Se elimina 'overflow-x-auto' del div contenedor
          para que la tabla se ajuste al 100% del ancho.
        --}}
        <div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Restaurante
                        </th>

                        {{-- Oculto en móvil y tablet, visible en desktop ('lg') --}}
                        <th scope="col" class="hidden lg:table-cell px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Dueño
                        </th>

                        {{-- Oculto en móvil, visible en tablet ('md') y superior --}}
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Menús
                        </th>

                        {{-- Oculto en móvil y tablet, visible en desktop ('lg') --}}
                        <th scope="col" class="hidden lg:table-cell px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Registrado
                        </th>

                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($restaurants as $restaurant)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $restaurant->name }}</div>
                                {{--
                                  Mostramos el ID y el Dueño apilados solo en móvil
                                  (se oculta en 'lg' y superior)
                                --}}
                                <div class="text-sm text-gray-500 dark:text-gray-400 lg:hidden">
                                    ID: {{ $restaurant->id }} | Dueño: {{ $restaurant->user->name ?? 'N/A' }}
                                </div>
                            </td>

                            <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->user->name ?? 'N/A' }}
                            </td>

                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->menus->count() }}
                            </td>

                            <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Editar Restaurante">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="text-red-600 hover:text-red-900" title="Suspender">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">No hay restaurantes registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($restaurants->hasPages())
            <div class="p-4 bg-white rounded-b-lg shadow-lg dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $restaurants->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
