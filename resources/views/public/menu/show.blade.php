<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $menu->name }} - {{ $menu->restaurant->name ?? 'Restaurante' }}</title>

    {{-- Usando CDN de Tailwind para simplicidad --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        $brandColor = $menu->restaurant->theme_color ?? '#3b82f6';
    @endphp
    <style>
        :root {
            /* Definimos la variable CSS con el color de la BD */
            --brand-color: {{ $brandColor }};
        }

        /* Clases personalizadas que usan la variable */
        .brand-text { color: var(--brand-color); }
        .brand-border { border-color: var(--brand-color); }
        .brand-bg { background-color: var(--brand-color); }
    </style>

</head>

<body class="bg-gray-50 font-sans leading-normal tracking-normal" x-data="{ showModal: false, modalImage: '' }">

    <div class="container mx-auto p-4 md:p-8 max-w-3xl">

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">

            <div class="p-6 md:p-8 text-center border-b border-gray-200">

                {{-- Logo del Restaurante (si existe) --}}
                @if ($menu->restaurant->logo_path)
                <div class="flex justify-center mb-6">
                    <img src="{{ Storage::url($menu->restaurant->logo_path) }}"
                         alt="Logo de {{ $menu->restaurant->name }}"
                         class="h-28 w-auto object-contain">
                </div>
                @endif

                {{-- Título (Nombre del Restaurante con color de marca) --}}
                <h1 class="text-4xl font-extrabold mb-2 brand-text">
                    {{ $menu->restaurant->name ?? 'Nuestro Menú' }}
                </h1>

                {{-- Subtítulo (Nombre del Menú) --}}
                <h2 class="text-2xl text-gray-700 mb-4">{{ $menu->name }}</h2>

                @if ($menu->description)
                    <p class="text-gray-600 max-w-lg mx-auto">{{ $menu->description }}</p>
                @endif
            </div>

            <div class="p-6 md:p-8">
                @forelse ($menu->categories as $category)
                    <div class="mb-8">

                        {{-- Título de la Categoría (con color de marca) --}}
                        <h3 class="text-3xl font-bold pb-3 mb-6 brand-text border-b-4 brand-border">
                            {{ $category->name }}
                        </h3>

                        @if ($category->description)
                            <p class="text-gray-500 italic mb-6">{{ $category->description }}</p>
                        @endif

                        @if ($category->items->isEmpty())
                            <p class="text-gray-500">No hay platos en esta categoría.</p>
                        @else
                            {{--
                              PASO 5: Nuevo diseño de lista de platos
                              (con imágenes más grandes y mejor espaciado)
                            --}}
                            <ul class="divide-y divide-gray-200">
                                @foreach ($category->items as $item)
                                    @if ($item->is_available)
                                        <li class="flex flex-col md:flex-row items-start md:items-center py-6 space-y-4 md:space-y-0 md:space-x-6">

                                            {{-- Imagen del Plato --}}
                                            @if ($item->image && $item->show_image)
                                                <div class="flex-shrink-0 w-full md:w-32">
                                                    <a href="{{ Storage::url($item->image) }}"
                                                        @click.prevent="showModal = true; modalImage = '{{ Storage::url($item->image) }}'"
                                                        title="Ver imagen de {{ $item->name }} en tamaño completo">
                                                        <img src="{{ Storage::url($item->image) }}"
                                                            alt="{{ $item->name }}"
                                                            class="w-full h-40 md:w-32 md:h-32 object-cover rounded-lg shadow-md hover:opacity-80 transition duration-150 cursor-pointer">
                                                    </a>
                                                </div>
                                            @endif

                                            {{-- Información del Plato --}}
                                            <div class="flex-grow">
                                                <h4 class="text-xl font-bold text-gray-900">{{ $item->name }}</h4>
                                                @if ($item->description)
                                                    <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                                                @endif
                                            </div>

                                            {{-- Precio del Plato (con color de marca) --}}
                                            <div class="flex-shrink-0">
                                                <span class="text-2xl font-semibold brand-text">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500">Este menú no tiene categorías definidas aún.</p>
                @endforelse
            </div>
        </div>
    </div>


    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-75" @click="showModal = false"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-3xl max-h-full overflow-auto">
            <button @click="showModal = false"
                class="fixed top-6 right-6 z-50 text-white opacity-70 hover:opacity-100 transition">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <img :src="modalImage" alt="Vista ampliada" class="rounded-lg">
        </div>
    </div>
</body>
</html>
