<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        <aside
            class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 h-full text-white transition-transform duration-300 transform bg-gray-800 dark:bg-gray-900 shadow-lg lg:translate-x-0"
            :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}"
            @click.away="sidebarOpen = false"
        >
            <div class="flex items-center justify-center h-20 gap-3 px-6 border-b border-gray-700">
                <i class="text-2xl fas fa-utensils text-blue-400"></i>
                <span class="text-xl font-semibold">{{ Auth::user()->restaurant->name ?? 'Mi Restaurante' }}</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('restaurant.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
                   :class="{'bg-blue-600 text-white': {{ request()->routeIs('restaurant.dashboard') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('restaurant.dashboard') ? 'true' : 'false' }}}">
                    <i class="w-5 text-center fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('menus.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
                   :class="{'bg-blue-600 text-white': {{ request()->routeIs('menus.*') || request()->routeIs('categories.*') || request()->routeIs('items.*') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('menus.*') ? 'true' : 'false' }}}">
                    <i class="w-5 text-center fas fa-book"></i>
                    <span>Gestión de Menús</span>
                </a>

                <a href="{{ route('restaurant.qr.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
                   :class="{'bg-blue-600 text-white': {{ request()->routeIs('restaurant.qr.index') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('restaurant.qr.index') ? 'true' : 'false' }}}">
                    <i class="w-5 text-center fas fa-qrcode"></i>
                    <span>Códigos QR</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-gray-300 rounded-lg opacity-50 cursor-not-allowed hover:bg-gray-700 hover:text-white group">
                    <i class="w-5 text-center fas fa-chart-bar"></i>
                    <span>Estadísticas (Pronto)</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
                   :class="{'bg-blue-600 text-white': {{ request()->routeIs('profile.edit') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('profile.edit') ? 'true' : 'false' }}}">
                    <i class="w-5 text-center fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full gap-3 px-4 py-2.5 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white group">
                        <i class="w-5 text-center fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex flex-col flex-1 lg:ml-64">

            <header class="sticky top-0 z-20 flex items-center justify-between h-20 px-6 bg-white dark:bg-gray-800 shadow-md">
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-700 dark:text-gray-300 lg:hidden">
                    <i class="text-2xl fas fa-bars"></i>
                </button>

                <div class="hidden md:block">
                    </div>

                <div class="flex items-center gap-4">
                    <span class="hidden font-medium text-gray-700 dark:text-gray-200 md:block">{{ Auth::user()->name }}</span>
                    <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-blue-500 rounded-full">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (isset($header))
                    <div class="flex flex-col items-start justify-between gap-4 mb-6 md:flex-row md:items-center">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $header }}
                            </h1>
                            @if(isset($subtitle))
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </div>
                        @if (isset($actions))
                            <div class="flex-shrink-0">
                                {{ $actions }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="space-y-6">
                    {{ $slot }}
                </div>
            </main>

            <footer class="p-6 mt-8 text-center text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 shadow-inner-top">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.
            </footer>
        </div>
    </div>
</body>
</html>
