{{-- resources/views/layouts/partials/_admin-nav.blade.php --}}

<a href="{{ route('admin.dashboard') }}"
   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
   :class="{'bg-blue-600 text-white': {{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}}">
    <i class="w-5 text-center fas fa-home"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('admin.restaurants.index') }}"
   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
   :class="{'bg-blue-600 text-white': {{ request()->routeIs('admin.restaurants.*') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('admin.restaurants.*') ? 'true' : 'false' }}}">
    <i class="w-5 text-center fas fa-store"></i>
    <span>Restaurantes</span>
</a>

<a href="{{ route('admin.users.index') }}"
   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
   :class="{'bg-blue-600 text-white': {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}}">
    <i class="w-5 text-center fas fa-users"></i>
    <span>Usuarios</span>
</a>

<a href="{{ route('admin.subscriptions.index') }}" {{-- <<< ENLACE AÑADIDO --}}
   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group" {{-- <<< CLASES MODIFICADAS --}}
   :class="{'bg-blue-600 text-white': {{ request()->routeIs('admin.subscriptions.*') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('admin.subscriptions.*') ? 'true' : 'false' }}}">
    <i class="w-5 text-center fas fa-credit-card"></i>
    <span>Suscripciones</span>
</a>
<a href="{{ route('profile.edit') }}"
   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200 group"
   :class="{'bg-blue-600 text-white': {{ request()->routeIs('profile.edit') ? 'true' : 'false' }}, 'text-gray-300 hover:bg-gray-700 hover:text-white': !{{ request()->routeIs('profile.edit') ? 'true' : 'false' }}}">
    <i class="w-5 text-center fas fa-cog"></i>
    <span>Configuración</span>
</a>
