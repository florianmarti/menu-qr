{{-- resources/views/admin/users/index.blade.php --}}
<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Usuarios') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('Ver, editar y administrar todas las cuentas de clientes.') }}
    </x-slot>

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Nombre
                        </th>

                        {{-- Oculto en móvil, visible en tablet ('md') y superior --}}
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Restaurante Asignado
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
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                {{--
                                  Mostramos el email apilado solo en móvil
                                  (se oculta en 'md' y superior, donde 'Restaurante' aparece)
                                --}}
                                <div class="text-sm text-gray-500 dark:text-gray-400 md:hidden">
                                    {{ $user->email }}
                                </div>
                            </td>

                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $user->restaurant->name ?? 'N/A' }}
                            </td>

                            <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Editar Usuario">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">No hay usuarios (clientes) registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-4 bg-white rounded-b-lg shadow-lg dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
