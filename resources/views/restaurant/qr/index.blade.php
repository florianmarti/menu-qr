<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Códigos QR') }}
    </x-slot>

    <x-slot name="subtitle">
        Aquí puedes ver todos tus menús y acceder al código QR de cada uno.
    </x-slot>

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Nombre del Menú
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Descripción
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acción</span>
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
                                {{ Str::limit($menu->description, 60) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('menus.qr', $menu) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                                    <i class="fas fa-qrcode"></i>
                                    Ver QR
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- Mensaje si no hay menús --}}
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg max-w-md mx-auto" role="alert">
                                    <p class="font-bold">No tienes menús</p>
                                    <p>Aún no has creado ningún menú.
                                        <a href="{{ route('menus.index') }}" class="font-bold underline hover:text-blue-800">
                                            Ve a Gestión de Menús
                                        </a>
                                        para empezar.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
