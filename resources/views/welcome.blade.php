{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Menusito') }} - Menús Digitales QR</title> {{-- NOMBRE CAMBIADO --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
        <div class="flex flex-col min-h-screen">

            <header class="sticky top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm shadow-sm">
                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <a href="/" class="flex items-center gap-3">
                            <i class="fas fa-utensils text-3xl text-blue-500"></i>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ config('app.name', 'Menusito') }}</span>
                        </a>
                        <div class="flex items-center gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                                        Iniciar Sesión
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                                            Registrarse
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-grow">
                <section class="py-24 sm:py-32 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                        <h1 class="text-4xl sm:text-6xl font-black text-gray-900 dark:text-white leading-tight">
                            Olvídate de los menús de papel para siempre
                        </h1>
                        <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                            Con {{ config('app.name') }}, actualiza tu menú en segundos, ahorra en impresión y ofrece una experiencia móvil perfecta a tus clientes.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-white bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-transform duration-200 hover:scale-105">
                                Probar Gratis 14 Días
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="#puntos-dolor" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="fas fa-play-circle"></i>
                                Ver Demo
                            </a>
                        </div>
                        <div class="mt-16 max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="aspect-video bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <i class="fas fa-mobile-alt text-6xl text-blue-500 mb-4"></i>
                                    <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Simulación de menú digital en dispositivo móvil</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="puntos-dolor" class="py-24 bg-white dark:bg-gray-900">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                                ¿Te sientes identificado con estos problemas?
                            </h2>
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                                Los menús de papel y PDFs están llenos de inconvenientes que afectan tu negocio
                            </p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                            <div>
                                <h3 class="text-2xl font-bold text-red-500 mb-8 flex items-center gap-2">
                                    <i class="fas fa-times-circle"></i>
                                    El problema con los menús tradicionales
                                </h3>
                                <div class="space-y-6">
                                    <div class="p-6 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-money-bill-wave text-red-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Costo de Reimpresión</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">"Tuve que reimprimir 100 menús solo por cambiar el precio de la cerveza. ¡Un gasto innecesario cada vez que hay una actualización!"</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-clock text-red-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Menús Desactualizados</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">"Se nos acabó el salmón, pero el menú de papel sigue ofreciéndolo. Esto enfada a los clientes y genera malas experiencias."</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-mobile text-red-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Mala Experiencia Móvil</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">"Nuestro menú es un PDF. Los clientes tienen que hacer zoom y mover la pantalla. Es horrible y poco profesional."</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-paint-brush text-red-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Falta de Branding</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">"Usamos un generador de QR gratuito y nuestro menú se ve genérico y feo, no parece de nuestro restaurante."</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-2xl font-bold text-green-500 mb-8 flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    La solución con {{ config('app.name') }}
                                </h3>
                                <div class="space-y-6">
                                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-sync-alt text-green-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Actualización Instantánea</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">Cambia precios o marca un plato como "No Disponible" en tu panel y se refleja al instante en todos los menús.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-piggy-bank text-green-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Ahorro de Dinero</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">Nunca más pagues por reimprimir menús. Un solo código QR que siempre muestra tu menú actualizado.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-star text-green-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Branding Profesional</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">Sube tu logo y elige tus colores de marca. El menú es 100% tuyo y refleja la identidad de tu negocio.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-bolt text-green-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Experiencia Móvil Perfecta</h4>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">Menús diseñados específicamente para verse increíbles en cualquier teléfono, sin necesidad de zoom.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="py-24 bg-gray-50 dark:bg-gray-800">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                                Lo que dicen nuestros clientes
                            </h2>
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                                Descubre cómo {{ config('app.name') }} está transformando negocios gastronómicos
                            </p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 flex flex-col">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">María G.</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Dueña de "Sabor Capital"</p>
                                    </div>
                                </div>
                                <div class="flex mb-4">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 italic flex-grow">
                                    "Poder marcar platos como 'agotados' en tiempo real nos ha salvado de muchas quejas. Los clientes ven la carta actualizada siempre. Increíble."
                                </p>
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-utensils mr-2"></i>
                                        <span>Restaurante</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 flex flex-col">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-green-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Carlos R.</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Fundador de "Nómada Cocina"</p>
                                    </div>
                                </div>
                                <div class="flex mb-4">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 italic flex-grow">
                                    "Para mi dark kitchen, la velocidad lo es todo. Actualizo mis 3 marcas desde un solo panel en segundos. Ya no dependo de apps de delivery para mostrar mi menú."
                                </p>
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-industry mr-2"></i>
                                        <span>Dark Kitchen</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 flex flex-col">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-purple-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Lucía F.</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Propietaria de "Café Rito"</p>
                                    </div>
                                </div>
                                <div class="flex mb-4">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 italic flex-grow">
                                    "Finalmente pude poner mi propio logo y colores. Se ve súper profesional y me ahorré miles en diseño e impresión. Mis clientes aman la experiencia."
                                </p>
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-coffee mr-2"></i>
                                        <span>Cafetería</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="contacto" class="py-24 bg-white dark:bg-gray-900">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                                ¿Tienes Preguntas?
                            </h2>
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                                Estamos aquí para ayudarte. Envíanos un mensaje.
                            </p>
                        </div>

                        <div class="max-w-2xl mx-auto bg-gray-50 dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">

                            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                                @csrf

                                @if (session('success'))
                                    <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg text-red-700 dark:text-red-300">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                    <input type="text" name="name" id="name" autocomplete="name"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                           placeholder="Tu nombre completo" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" autocomplete="email"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                           placeholder="tu@correo.com" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tu Mensaje</label>
                                    <textarea id="message" name="message" rows="4"
                                              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('message') border-red-500 @enderror"
                                              placeholder="¿En qué podemos ayudarte?">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-2 px-8 py-3 text-base font-semibold text-white bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-transform duration-200 hover:scale-105">
                                        Enviar Mensaje
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="py-20 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 text-white">
                    <div class="container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
                        <h2 class="text-3xl sm:text-4xl font-bold mb-6">
                            ¿Listo para transformar tu menú?
                        </h2>
                        <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-10">
                            Únete a cientos de restaurantes, cafeterías y dark kitchens que ya están usando {{ config('app.name') }}.
                        </section>
                    </div>
                </section>
            </main>

            <footer class="bg-gray-800 dark:bg-gray-900 border-t border-gray-700">
                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Menusito') }}. Todos los derechos reservados.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
