<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $menu->name }} - {{ $menu->restaurant->name ?? 'Restaurante' }}</title>

    {{-- Usando CDN de Tailwind para simplicidad --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- AÑADIDO: Font Awesome para iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        $brandColor = $menu->restaurant->theme_color ?? '#3b82f6';
    @endphp
    <style>
        :root {
            --brand-color: {{ $brandColor }};
        }

        .brand-text { color: var(--brand-color); }
        .brand-border { border-color: var(--brand-color); }
        .brand-bg { background-color: var(--brand-color); }

        /* Animaciones y efectos mejorados */
        .menu-item-card {
            transition: all 0.3s ease;
        }

        .menu-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .price-tag {
            transition: all 0.3s ease;
        }

        .menu-item-card:hover .price-tag {
            transform: scale(1.05);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilo para que la categoría 'sticky' tenga fondo */
        .sticky-category {
            position: sticky;
            top: 0;
            /* Aplicamos el fondo del body para que tape el contenido al hacer scroll */
            background-color: #f9fafb; /* bg-gray-50 */
            z-index: 10;
            padding-top: 1rem;
            padding-bottom: 0.5rem;
            /* Corregimos el scroll-mt para que coincida con la barra sticky */
            scroll-margin-top: 100px;
        }

        /* Estilo para la barra de navegación sticky superior */
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid #e5e7eb; /* border-gray-200 */
        }

        /* Ocultar scrollbar */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Scroll suave */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans leading-normal tracking-normal"
      x-data="{
            showModal: false,
            modalImage: '',
            activeCategory: null,
            scrollToCategory(categoryId) {
                const el = document.getElementById(categoryId);
                if (el) {
                    // Calculamos el offset por la barra sticky
                    const offset = 100; // Ajusta este valor si la altura de tu barra cambia
                    const bodyRect = document.body.getBoundingClientRect().top;
                    const elementRect = el.getBoundingClientRect().top;
                    const elementPosition = elementRect - bodyRect;
                    const offsetPosition = elementPosition - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    this.activeCategory = categoryId;
                }
            }
       }"
      x-init="
            // Observador para cambiar categoría activa al hacer scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        activeCategory = entry.target.id;
                    }
                });
            }, {
                threshold: 0.5,
                rootMargin: '-100px 0px -50% 0px' // Ajuste para que se active en el medio
            });

            // Observar todas las categorías
            $nextTick(() => {
                document.querySelectorAll('[data-category]').forEach(category => {
                    observer.observe(category);
                });
            });
      ">

    {{-- Navegación rápida entre categorías --}}
    <div class="sticky-nav">
        <div class="container mx-auto px-4 py-3">
            <div class="flex overflow-x-auto space-x-4 py-2 hide-scrollbar">
                @foreach ($menu->categories as $category)
                    <button
                        @click="scrollToCategory('category-{{ $category->id }}')"
                        :class="activeCategory === 'category-{{ $category->id }}'
                                ? 'brand-bg text-white'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-300 flex items-center space-x-2">
                        {{-- Icono de ejemplo (puedes personalizarlo si añades iconos a categorías) --}}
                        <i class="fas fa-utensils text-xs"></i>
                        <span>{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4 md:p-8 max-w-4xl">

        {{-- Header del menú --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 fade-in">
            <div class="p-8 text-center relative">
                {{-- Efecto de fondo decorativo --}}
                <div class="absolute inset-0 opacity-5 brand-bg"></div>

                @if ($menu->restaurant->logo_path)
                <div class="flex justify-center mb-6 relative z-10">
                    <img src="{{ Storage::url($menu->restaurant->logo_path) }}"
                         alt="Logo de {{ $menu->restaurant->name }}"
                         class="h-32 w-auto object-contain drop-shadow-lg">
                </div>
                @endif

                {{-- Título principal --}}
                <h1 class="text-5xl font-black mb-3 brand-text relative z-10 tracking-tight">
                    {{ $menu->restaurant->name ?? 'Nuestro Menú' }}
                </h1>

                {{-- Subtítulo --}}
                <h2 class="text-2xl text-gray-600 mb-6 font-medium relative z-10">{{ $menu->name }}</h2>

                @if ($menu->description)
                    <p class="text-gray-500 max-w-2xl mx-auto text-lg relative z-10 leading-relaxed">
                        {{ $menu->description }}
                    </p>
                @endif

                {{-- Elemento decorativo --}}
                <div class="mt-6 relative z-10">
                    <div class="w-24 h-1 brand-bg rounded-full mx-auto"></div>
                </div>
            </div>
        </div>

        {{-- Contenido del menú --}}
        <div class="space-y-12">
            @forelse ($menu->categories as $category)
                <div id="category-{{ $category->id }}"
                     data-category="category-{{ $category->id }}"
                     class="fade-in">

                    {{-- Header de categoría --}}
                    <div class="sticky-category">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-3 h-10 brand-bg rounded-full"></div>
                                <h3 class="text-4xl font-black brand-text tracking-tight">
                                    {{ $category->name }}
                                </h3>
                            </div>
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $category->items->where('is_available', true)->count() }} platos
                            </span>
                        </div>

                        @if ($category->description)
                            <p class="text-gray-600 text-lg mb-8 max-w-3xl leading-relaxed pl-7">
                                {{-- Icono de info --}}
                                <i class="fas fa-info-circle brand-text mr-2 text-sm"></i>
                                {{ $category->description }}
                            </p>
                        @endif
                    </div>

                    {{-- Grid de platos --}}
                    @if ($category->items->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-utensils text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 text-lg">No hay platos en esta categoría.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($category->items as $item)
                                @if ($item->is_available)
                                    <div class="menu-item-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:border-gray-200">

                                        {{-- Imagen del plato --}}
                                        @if ($item->image && $item->show_image)
                                            <div class="relative overflow-hidden">
                                                <a href="{{ Storage::url($item->image) }}"
                                                   @click.prevent="showModal = true; modalImage = '{{ Storage::url($item->image) }}'"
                                                   title="Ampliar imagen de {{ $item->name }}"
                                                   class="block cursor-pointer group">
                                                   <img src="{{ Storage::url($item->image) }}"
                                                        alt="{{ $item->name }}"
                                                        class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                                                   <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                                       <div class="bg-white bg-opacity-90 rounded-full p-3 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                                           <i class="fas fa-expand brand-text text-lg"></i>
                                                       </div>
                                                   </div>
                                                </a>
                                            </div>
                                        @endif

                                        {{-- Contenido del plato --}}
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="text-xl font-bold text-gray-900 pr-4">{{ $item->name }}</h4>
                                                <div class="price-tag bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2 rounded-full border border-gray-200 min-w-20 text-center">
                                                    <span class="text-lg font-black brand-text">${{ number_format($item->price, 2) }}</span>
                                                </div>
                                            </div>

                                            @if ($item->description)
                                                <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
                                            @endif

                                            {{-- Badges adicionales --}}
                                            <div class="mt-4 flex flex-wrap gap-2">

                                                {{-- @if($item->is_featured) ... @endif --}}

                                                @if($item->allergens && count(json_decode($item->allergens, true) ?? []) > 0)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i> Alérgenos
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16">
                    <i class="fas fa-clipboard-list text-gray-300 text-8xl mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-500 mb-4">Menú en preparación</h3>
                    <p class="text-gray-400 max-w-md mx-auto">Estamos trabajando en nuestro menú. ¡Vuelve pronto para descubrir nuestras deliciosas opciones!</p>
                </div>
            @endforelse
        </div>

        {{-- Footer del menú --}}
        <div class="mt-16 text-center text-gray-500 py-8 border-t border-gray-200">
            <p class="flex items-center justify-center space-x-2">
                <i class="fas fa-qrcode"></i>
                <span>Menú digital - {{ $menu->restaurant->name ?? 'Restaurante' }} • {{ date('Y') }}</span>
            </p>
        </div>
    </div>

    {{--
      Este es el contenedor del modal.
      Sigue usando 'fixed' para cubrir la pantalla.
    --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">

        <div class="fixed inset-0 bg-black bg-opacity-80 z-40" @click="showModal = false"></div>

        <div class="relative z-50 bg-white rounded-2xl shadow-2xl max-w-4xl max-h-full overflow-auto transform">
            <img :src="modalImage" alt="Vista ampliada" class="rounded-2xl w-full h-auto">
        </div>

        <button @click="showModal = false"
            class="fixed top-4 right-4 z-50 text-white opacity-70 hover:opacity-100 transition hover:scale-110">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>
    </body>
</html>
