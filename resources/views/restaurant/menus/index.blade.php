<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Menús') }}
    </x-slot>

    <x-slot name="subtitle">
        Aquí puedes crear, editar y organizar todos tus menús.
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('menus.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
            <i class="fas fa-plus"></i>
            Crear Nuevo Menú
        </a>
    </x-slot>

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Descripción
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Estado
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($menus as $menu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $menu->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ Str::limit($menu->description, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($menu->is_active)
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="flex items-center justify-end gap-3 px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('categories.index', $menu) }}" class="text-blue-500 hover:text-blue-700" title="Ver Categorías">
                                    <i class="fas fa-list"></i>
                                </a>
                                <a href="{{ route('menus.edit', $menu) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar Menú">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('menus.qr', $menu) }}" class="text-gray-600 hover:text-gray-900" title="Ver QR">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                                {{-- <form action="{{ route('menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type.submit" class="text-red-600 hover:text-red-900" title="Eliminar Menú">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">Aún no tienes menús creados.</p>
                                <p class="mt-2 text-sm text-gray-400">Haz clic en "Crear Nuevo Menú" para empezar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
