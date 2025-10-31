{{-- resources/views/admin/subscriptions/index.blade.php --}}
<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Gestión de Suscripciones') }}
    </x-slot>
    <x-slot name="subtitle">
        {{ __('Ver el estado de todos los clientes y sus planes.') }}
    </x-slot>

    <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Restaurante
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Plan
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            Vence
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($subscriptions as $subscription)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $subscription->user->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $subscription->user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $subscription->user->restaurant->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                                {{ $subscription->plan_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Lógica de estado (ejemplo) --}}
                                @if ($subscription->status === 'active')
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $subscription->expires_at ? $subscription->expires_at->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="flex items-center justify-end gap-3 px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Editar Suscripción">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-lg text-gray-500 dark:text-gray-400">No hay suscripciones registradas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($subscriptions->hasPages())
            <div class="p-4 bg-white rounded-b-lg shadow-lg dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
