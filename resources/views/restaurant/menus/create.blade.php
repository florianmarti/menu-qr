<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Crear Nuevo Menú') }}
    </x-slot>

    <x-slot name="subtitle">
        Completa los detalles básicos de tu nuevo menú.
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('menus.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i>
            Volver a Menús
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <form action="{{ route('menus.store') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">
                    <div>
                        {{--
                          Usamos <label> estándar en lugar de <x-input-label>
                          para un estilo más limpio y directo con Tailwind.
                        --}}
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre del Menú
                        </label>
                        {{--
                          Usamos <input> estándar en lugar de <x-text-input>
                          y aplicamos las clases de Tailwind directamente.
                        --}}
                        <input type="text" name="name" id="name"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ej: Menú Principal"
                               value="{{ old('name') }}"
                               required
                               autofocus>
                        {{-- Mantenemos el componente de error de Breeze --}}
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción (Opcional)
                        </label>
                        {{--
                          Tu <textarea> original ya era casi perfecta, solo ajustamos
                          las clases para que coincida 100% con el <input>.
                        --}}
                        <textarea name="description" id="description" rows="4"
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Ej: Nuestro menú completo para cenas y ocasiones especiales.">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-lg">
                    {{--
                      Reemplazamos <x-primary-button> por un <button> estándar
                      con las clases de nuestro nuevo diseño.
                    --}}
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                        <i class="fas fa-save"></i>
                        Guardar Menú
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
