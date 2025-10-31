{{-- resources/views/restaurant/qr_placeholder.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generación de Códigos QR') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg">
                <p class="font-bold text-lg">Funcionalidad Pendiente</p>
                <p>Aquí implementaremos la generación y descarga de tu código QR. Por ahora, estamos trabajando en el CRUD de Categorías y Productos.</p>
                <a href="{{ route('restaurant.dashboard') }}" class="text-yellow-700 underline mt-2 block">Volver al Panel</a>
            </div>
        </div>
    </div>
</x-app-layout>
