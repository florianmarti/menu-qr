{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Forzamos el modo oscuro en el layout de invitado
            // para que coincida con nuestro diseño de fondo oscuro.
            document.documentElement.classList.add('dark');
        </script>
        </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">

            {{-- Logo de la App --}}
            <div>
                <a href="/" class="flex items-center gap-3 text-gray-800 dark:text-white">
                    <i class="fas fa-utensils text-4xl text-blue-500 dark:text-blue-400"></i>
                    <span class="text-3xl font-semibold">{{ config('app.name', 'Menusito') }}</span>
                </a>
            </div>

            {{--
              La tarjeta ahora SÍ usará los estilos 'dark:' de Breeze
              porque el <html> tiene la clase 'dark'.
            --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
