
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
