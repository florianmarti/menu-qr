<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control de ') }} {{ Auth::user()->restaurant->name ?? 'tu Restaurante' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de Bienvenida (Opcional) --}}
            {{-- Puedes descomentar esto si quieres un saludo --}}
            {{-- <div class="mb-8 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded-lg shadow" role="alert">
                <p class="font-bold text-lg">¡Bienvenido, {{ Auth::user()->name }}!</p>
                <p>Gestiona tu menú digital y códigos QR desde aquí.</p>
            </div> --}}

            {{-- Mensajes Flash (Success/Error) --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Tarjeta 1: Gestión de Menús (Azul) --}}
                <a href="{{ route('menus.index') }}" class="block p-6 bg-white dark:bg-gray-800 border-t-4 border-blue-600 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 ease-in-out">
                    <div class="flex items-center mb-3">
                        <span class="text-4xl text-blue-500 mr-4"><i class="fas fa-book-open"></i></span>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Gestión de Menús</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Crea, edita y organiza tus menús, categorías y platos.</p>
                </a>

                {{-- Tarjeta 2: Código QR y Publicación (Verde) --}}
                {{-- Verifica que la ruta 'restaurant.qr.index' esté definida en web.php --}}
                <a href="{{ route('restaurant.qr.index') }}" class="block p-6 bg-white dark:bg-gray-800 border-t-4 border-green-500 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 ease-in-out">
                    <div class="flex items-center mb-3">
                        <span class="text-4xl text-green-500 mr-4"><i class="fas fa-qrcode"></i></span>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Códigos QR</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Genera y gestiona los códigos QR para tus menús.</p>
                </a>

                {{-- Tarjeta 3: Configuración del Perfil/Restaurante (Amarillo) --}}
                <a href="{{ route('profile.edit') }}" class="block p-6 bg-white dark:bg-gray-800 border-t-4 border-yellow-500 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 ease-in-out">
                    <div class="flex items-center mb-3">
                        <span class="text-4xl text-yellow-500 mr-4"><i class="fas fa-store-alt"></i></span>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Configuración</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Actualiza tu perfil y los detalles de tu restaurante.</p>
                </a>

            </div>

            {{-- Sección de Estado (Opcional) --}}
            <div class="mt-10 p-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Información Rápida</h5>
                <p class="text-gray-700 dark:text-gray-400">Hola, **{{ Auth::user()->name }}**. Última actividad: {{ Auth::user()->updated_at->diffForHumans() }}.</p>
                {{-- Aquí puedes añadir más detalles, como estado de suscripción si aplica --}}
            </div>

        </div>
    </div>
</x-app-layout>
