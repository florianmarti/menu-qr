<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    <x-slot name="subtitle">
        Bienvenido al panel de control de tu restaurante
    </x-slot>
    <x-slot name="actions">
        <a href="{{ route('menus.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
            <i class="fas fa-plus"></i>
            Nuevo Menú
        </a>
    </x-slot>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-blue-500 bg-blue-100 rounded-full">
                <i class="text-xl fas fa-book"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Menús Activos</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $menuCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-green-500 bg-green-100 rounded-full">
                <i class="text-xl fas fa-list"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Categorías</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $categoryCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-yellow-500 bg-yellow-100 rounded-full">
                <i class="text-xl fas fa-pizza-slice"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Platos</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $itemCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-indigo-500 bg-indigo-100 rounded-full">
                <i class="text-xl fas fa-qrcode"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Códigos QR (Menús)</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $qrCount }}</dd>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-3">

        <div class="overflow-hidden bg-white rounded-lg shadow-lg lg:col-span-2 dark:bg-gray-800">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Menús Recientes</h3>
                <a href="{{ route('menus.index') }}" class="text-sm font-medium text-blue-500 hover:underline">Ver Todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Categorías</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Estado</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        @forelse ($recentMenus as $menu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $menu->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($menu->description, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $menu->categories_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($menu->is_active)
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Activo</span>
                                @else
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Inactivo</span>
                                @endif
                            </td>
                            <td class="flex items-center justify-end gap-3 px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('menus.edit', $menu) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('menus.qr', $menu) }}" class="text-blue-600 hover:text-blue-900" title="Ver QR"><i class="fas fa-qrcode"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">Aún no tienes menús.</p>
                                <a href="{{ route('menus.create') }}" class="text-sm font-medium text-blue-500 hover:underline">¡Crea uno para empezar!</a>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Actividad Reciente</h3>
            </div>
            <div class="p-5">
                <ul class="space-y-4">

                    @forelse ($recentActivity as $activity)
                        {{--
                          ESTO ES UN EJEMPLO PARA CUANDO IMPLEMENTEMOS EL LOG DE ACTIVIDAD
                        <li class="flex gap-4">
                            <div class="flex items-center justify-center w-10 h-10 text-blue-500 bg-blue-100 rounded-full flex-shrink-0">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $activity->description }}</h4>
                                <time class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</time>
                            </div>
                        </li>
                        --}}
                    @empty
                        <li class="text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-history mr-2"></i>
                            No hay actividad reciente para mostrar.
                        </li>
                    @endforelse

                </ul>
            </div>
        </div>
        </div>

</x-dashboard-layout>
