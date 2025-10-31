<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Platos de la Categoría: ') . $category->name }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $menu->name }}</p> {{-- Added dark mode text color --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Display Success/Error Messages --}}
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Volver a la lista de categorías --}}
                    <a href="{{ route('categories.index', $menu) }}" class="text-sm text-indigo-600 hover:text-indigo-800 mb-4 block dark:text-indigo-400 dark:hover:text-indigo-300">
                        &larr; Volver a Categorías
                    </a>

                    <div class="mb-4 flex justify-between items-center">
                        {{-- Enlace para crear un nuevo plato --}}
                        <a href="{{ route('items.create', [$menu, $category]) }}"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-1"></i> Añadir Nuevo Plato
                        </a>
                    </div>

                    @if($items->isEmpty())
                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-center text-gray-500 dark:text-gray-400">
                            <p>Esta categoría aún no tiene platos. ¡Añade el primero!</p>
                        </div>
                    @else
                        {{-- 💥 Tabla de Platos 💥 --}}
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        {{-- >>>>>>>>>> NUEVA COLUMNA DE IMAGEN <<<<<<<<<< --}}
                                        <th scope="col" class="py-3 px-6">Imagen</th>
                                        {{-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
                                        <th scope="col" class="py-3 px-6">Nombre</th>
                                        <th scope="col" class="py-3 px-6">Descripción</th>
                                        <th scope="col" class="py-3 px-6">Precio</th>
                                        <th scope="col" class="py-3 px-6">Disponible</th>
                                        <th scope="col" class="py-3 px-6">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            {{-- >>>>>>>>>>>> CELDA PARA LA IMAGEN <<<<<<<<<<<< --}}
                                            <td class="py-4 px-6">
                                                @if($item->image)
                                                    {{-- Usamos Storage::url() para obtener la URL pública --}}
                                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="h-12 w-12 object-cover rounded shadow">
                                                @else
                                                    {{-- Placeholder si no hay imagen --}}
                                                    <div class="h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                {{ $item->name }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ Str::limit($item->description, 50, '...') }}
                                            </td>
                                            <td class="py-4 px-6">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($item->is_available)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Sí
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        No
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 flex items-center space-x-3">
                                                {{-- Botón Editar --}}
                                                <a href="{{ route('items.edit', ['menu' => $menu, 'category' => $category, 'item' => $item]) }}"
                                                   class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>

                                                {{-- Formulario para Eliminar --}}
                                                <form action="{{ route('items.destroy', ['menu' => $menu, 'category' => $category, 'item' => $item]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar el plato {{ $item->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Mostrar paginación si la hubiera --}}
                        {{-- {{ $items->links() }} --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
