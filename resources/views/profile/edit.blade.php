<x-dashboard-layout>

    <x-slot name="header">
        {{ __('Configuración') }}
    </x-slot>

    <x-slot name="subtitle">
        {{ __('Administra los detalles de tu cuenta y restaurante.') }}
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{--
          Solo mostramos la tarjeta de "Branding" si la variable $restaurant
          no es nula (es decir, si el usuario es un cliente).
        --}}
        @if ($restaurant)
            <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Branding del Restaurante') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Sube tu logo y elige tus colores de marca para el menú público.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.branding.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="logo" :value="__('Logo del Restaurante')" />

                            <div class="mt-2 mb-2">
                                {{-- Esta es la línea 38. Ahora está protegida por el @if($restaurant) --}}
                                @if ($restaurant->logo_path)
                                    {{-- Usamos Storage::url() para obtener la URL pública --}}
                                    <img src="{{ Storage::url($restaurant->logo_path) }}" alt="Logo Actual" class="w-32 h-32 object-contain rounded-md border border-gray-300 dark:border-gray-600">
                                @else
                                    <div class="flex items-center justify-center w-32 h-32 bg-gray-100 rounded-md border border-gray-300 text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </div>

                            <input id="logo" name="logo" type="file"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-300
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          dark:file:bg-blue-900 dark:file:text-blue-300
                                          hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
                                   aria-describedby="logo_help" />

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="logo_help">
                                {{ __('Aceptado: JPG, PNG, SVG. Tamaño máx: 2MB.') }}
                            </p>
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        <div>
                            <x-input-label for="theme_color" :value="__('Color de Marca')" />
                            <div class="flex items-center gap-3 mt-1">
                                <input id="theme_color" name="theme_color" type="color"
                                       class="w-12 h-10 p-1 border border-gray-300 rounded-md dark:border-gray-600"
                                       value="{{ old('theme_color', $restaurant->theme_color ?? '#3b82f6') }}" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Elige el color principal de tu menú (ej. títulos).') }}
                                </span>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('theme_color')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Branding') }}</x-primary-button>

                            @if (session('status') === 'branding-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Guardado.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        @endif
        <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-dashboard-layout>
