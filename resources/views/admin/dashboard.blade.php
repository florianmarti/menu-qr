<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Panel de Administración') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('Bienvenido, Administrador. Aquí tienes un resumen del sistema.') }}
    </x-slot>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-blue-500 bg-blue-100 rounded-full">
                <i class="text-xl fas fa-store"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Restaurantes</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $restaurantCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-green-500 bg-green-100 rounded-full">
                <i class="text-xl fas fa-users"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuarios (Clientes)</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $userCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-yellow-500 bg-yellow-100 rounded-full">
                <i class="text-xl fas fa-book"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Menús Creados</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $menuCount }}</dd>
            </div>
        </div>
        <div class="flex items-center gap-4 p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 h-12 text-indigo-500 bg-indigo-100 rounded-full">
                <i class="text-xl fas fa-credit-card"></i>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Suscripciones (Pronto)</dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $subscriptionCount }}</dd>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-2">

        <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Restaurantes Recientes</h3>
                {{-- <a href="#" class="text-sm font-medium text-blue-500 hover:underline">Ver Todos</a> --}}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Restaurante</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Dueño</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($recentRestaurants as $restaurant)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $restaurant->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $restaurant->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">No hay restaurantes registrados.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Usuarios Recientes</h3>
                {{-- <a href="#" class="text-sm font-medium text-blue-500 hover:underline">Ver Todos</a> --}}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($recentUsers as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">No hay usuarios (clientes) registrados.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-dashboard-layout>
