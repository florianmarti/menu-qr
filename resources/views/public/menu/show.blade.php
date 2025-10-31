<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $menu->name }} - {{ $menu->restaurant->name ?? 'Restaurante' }}</title>

    {{-- Usando CDN de Tailwind para simplicidad --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal" x-data="{ showModal: false, modalImage: '' }">
    <div class="container mx-auto p-4 md:p-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-center mb-2">{{ $menu->restaurant->name ?? 'Nuestro Menú' }}</h1>
            <h2 class="text-xl text-gray-700 text-center mb-6">{{ $menu->name }}</h2>

            @if ($menu->description)
                <p class="text-gray-600 text-center mb-6">{{ $menu->description }}</p>
            @endif

            @forelse ($menu->categories as $category)
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold border-b-2 border-gray-300 pb-2 mb-4">{{ $category->name }}</h3>
                    @if ($category->description)
                        <p class="text-gray-500 italic mb-3">{{ $category->description }}</p>
                    @endif

                    @if ($category->items->isEmpty())
                        <p class="text-gray-500">No hay platos en esta categoría.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($category->items as $item)
                                {{-- Solo mostrar platos disponibles --}}
                                @if ($item->is_available)
                                    <li class="flex items-start space-x-4">
                                        {{-- Columna de la Imagen (si existe Y si está habilitada) --}}
                                        @if ($item->image && $item->show_image)
                                            <div class="flex-shrink-0">

                                                <a href="{{ Storage::url($item->image) }}"
                                                    @click.prevent="showModal = true; modalImage = '{{ Storage::url($item->image) }}'"
                                                    title="Ver imagen de {{ $item->name }} en tamaño completo">
                                                    <img src="{{ Storage::url($item->image) }}"
                                                        alt="{{ $item->name }}"
                                                        class="w-16 h-16 object-cover rounded-md shadow-sm hover:opacity-80 transition duration-150 cursor-pointer">
                                                </a>
                                            </div>
                                        @else
                                            {{-- Placeholder o nada si la imagen no se debe mostrar --}}
                                            <div class="flex-shrink-0 w-16 h-16"></div> {{-- Espacio vacío para alinear --}}
                                        @endif

                                        {{-- Columna de Texto (Nombre y Descripción) --}}
                                        <div class="flex-grow">
                                            <h4 class="font-semibold text-lg">{{ $item->name }}</h4>
                                            @if ($item->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                                            @endif
                                        </div>

                                        {{-- Columna de Precio --}}
                                        <div class="flex-shrink-0">
                                            <span
                                                class="text-lg font-medium text-gray-800">${{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </li>
                                @endif {{-- Fin del if is_available --}}
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500">Este menú no tiene categorías definidas aún.</p>
            @endforelse
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
