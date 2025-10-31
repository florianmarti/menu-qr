{{-- resources/views/admin/restaurants/index.blade.php --}}
<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Restaurantes') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('Ver, editar y administrar todas las cuentas de restaurantes.') }}
    </x-slot>

    {{--
    <x-slot name="actions">
        <a href="#" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
            <i class="fas fa-plus"></i>
            Crear Restaurante
        </a>
    </x-slot>
    --}}

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Restaurante (ID)
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Dueño
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Menús
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
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
                                <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $restaurant->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{-- Contamos los menús (esto se puede optimizar luego con withCount) --}}
                                {{ $restaurant->menus->count() }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->created_at->format('d/m/Y') }}
                            </td>
                            <td class="flex items-center justify-end gap-3 px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Editar Restaurante">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900" title="Suspender">
                                    <i class="fas fa-ban"></i>
                                </a>
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
