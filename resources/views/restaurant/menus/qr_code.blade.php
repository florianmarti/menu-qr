<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Código QR') }}
    </x-slot>

    <x-slot name="subtitle">
        {{ __('Mostrando el código para el menú: ') }} <span class="font-semibold">{{ $menu->name }}</span>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('restaurant.qr.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i>
            {{ __('Volver a Códigos QR') }}
        </a>
    </x-slot>

    <div class="max-w-md mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="p-6 text-center">

                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Escanea este código') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Tus clientes pueden escanear esto para ver el menú.') }}
                </p>

                <div class="inline-block p-4 my-6 bg-white border rounded-lg shadow-inner">
                    {!! $qrCodeSvg !!}
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('O visita directamente:') }}
                    </p>
                    <a href="{{ $publicUrl }}" target="_blank" class="text-blue-500 hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                        {{ $publicUrl }}
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-center px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-lg">
                {{--
                  Este botón usa JavaScript simple (window.print())
                  para abrir el diálogo de impresión del navegador.
                --}}
                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    <i class="fas fa-print"></i>
                    {{ __('Imprimir QR') }}
                </button>
            </div>
        </div>
    </div>
</x-dashboard-layout>
