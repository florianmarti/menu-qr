<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Código QR para el Menú: ') . $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">

                    {{-- Enlace Volver --}}
                    <a href="{{ route('menus.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mb-6 block">
                        &larr; Volver a la lista de Menús
                    </a>

                    <h3 class="text-lg font-medium mb-4">Escanea este código QR para ver el menú:</h3>

                    {{-- Mostrar el QR Code (como SVG inline) --}}
                    <div class="inline-block p-4 border rounded-lg bg-white">
                        {!! $qrCodeSvg !!}
                    </div>

                    <p class="mt-4 text-sm text-gray-600">
                        O visita directamente:
                        <a href="{{ $publicUrl }}" target="_blank" class="text-blue-500 hover:underline">{{ $publicUrl }}</a>
                    </p>

                    {{-- Podrías añadir un botón de descarga aquí en el futuro --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
