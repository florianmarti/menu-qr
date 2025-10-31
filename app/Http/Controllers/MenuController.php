<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    // Aseguramos que el usuario esté autenticado antes de cualquier acción.
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (Muestra la lista de menús).
     */
    public function index()
    {
        $user = Auth::user();

        // --- INICIO DEBUG ---
        if (!$user) {
            Log::error('MenuController@index: Auth::user() es null.');
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.'); // Redirigir a login si no hay usuario
        }

        Log::info('Usuario autenticado:', ['id' => $user->id, 'name' => $user->name, 'restaurant_id' => $user->restaurant_id]);

        // Intenta cargar la relación explícitamente
        $restaurant = $user->restaurant()->first();
        // Alternativa: Cargar la relación en el objeto usuario
        // $user->load('restaurant');
        // $restaurant = $user->restaurant;

        Log::info('Restaurante encontrado:', $restaurant ? $restaurant->toArray() : ['result' => 'null']);

        // Detener ejecución y mostrar el restaurante (o null)
       // dd('Usuario:', $user->toArray(), 'Restaurante:', $restaurant);
        // --- FIN DEBUG ---


        // Si el usuario no tiene un restaurante asociado...
        if (!$restaurant) {
            // Este es el bloque que te está redirigiendo
            Log::warning('Redirigiendo a dashboard porque no se encontró restaurante para User ID: ' . $user->id);
            return redirect()->route('dashboard')->with('error', 'No se encontró un restaurante asociado a tu cuenta.'); // Mensaje más específico
        }

        // Obtiene todos los menús de ese restaurante
        $menus = $restaurant->menus()->get();

        return view('restaurant.menus.index', compact('menus'));
    }
    public function indexQRCodes()
    {
        $restaurant = Auth::user()->restaurant;

        // Si el usuario no tiene un restaurante (aunque el middleware 'auth' ya debería cubrir esto)
        if (!$restaurant) {
            return redirect()->route('dashboard')->with('error', 'No se encontró un restaurante asociado.');
        }

        // Obtiene todos los menús de ese restaurante
        $menus = $restaurant->menus()->get();

        // Retorna la vista que antes era estática, ahora con datos
        return view('restaurant.qr.index', compact('menus'));
    }
    public function showQrCode(Menu $menu)
    {
        // 1. Verificar la propiedad (seguridad)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        // 2. Generar la URL pública para el menú
        // *** IMPORTANTE: Aún no hemos creado esta ruta pública ***
        // Por ahora, usaremos una URL de ejemplo. La cambiaremos después.
        // Asumimos que tendrás una ruta como 'public.menu.show' que recibe el slug del restaurante y el ID/slug del menú.
        // Por ejemplo: http://tuapp.com/menu/nombre-restaurante/menu-principal
        // Reemplaza 'NOMBRE_RUTA_PUBLICA' y los parámetros según tu implementación final.
        //$publicUrl = route('public.menu.show', ['restaurant_slug' => $menu->restaurant->slug, 'menu_slug' => $menu->slug]);
        $publicUrl = route('public.menu.show', $menu->id); // Usamos la ruta show por ahora como placeholder

        // 3. Generar el código QR como SVG
        // Usamos ->size() para el tamaño en píxeles y ->generate() para obtener el string SVG
        $qrCodeSvg = QrCode::size(300)->generate($publicUrl);

        // 4. Pasar los datos a la vista
        return view('restaurant.menus.qr_code', compact('menu', 'qrCodeSvg', 'publicUrl'));
    }
    public function create()
    {
        // Obtenemos el restaurante (la verificación de que existe ya se hizo en el index)
        $restaurant = Auth::user()->restaurant;

        // Necesitamos pasar el restaurante a la vista para el formulario si fuera necesario,
        // pero por ahora solo retornamos la vista del formulario.
        return view('restaurant.menus.create', compact('restaurant'));
    }
    public function store(Request $request)
    {
        // 1. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // 2. Obtener el restaurante del usuario autenticado
        $restaurant = Auth::user()->restaurant;

        // 3. Crear el nuevo menú y vincularlo al restaurante
        $menu = $restaurant->menus()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            // 'is_active', 'template', etc. pueden usar valores por defecto
        ]);

        // 4. Redirigir y mostrar mensaje de éxito
        return redirect()->route('menus.index')->with('success', 'Menú "' . $menu->name . '" creado con éxito.');
    }
    public function edit(Menu $menu)
    {
        // 1. Verificar la propiedad: Aseguramos que el menú pertenezca al restaurante del usuario.
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado. Este menú no te pertenece.');
        }

        return view('restaurant.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage (Actualiza el menú).
     */
    public function update(Request $request, Menu $menu)
    {
        // 1. Verificar la propiedad (seguridad)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        // 2. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            // Aquí puedes añadir validación para otros campos si los implementas (is_active, template, etc.)
        ]);

        // 3. Actualizar el menú
        $menu->update($validated);

        // 4. Redirigir y mostrar mensaje de éxito
        return redirect()->route('menus.index')->with('success', 'Menú "' . $menu->name . '" actualizado con éxito.');
    }
    public function destroy(Menu $menu)
    {
        // 1. Verificar la propiedad (seguridad)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        $menuName = $menu->name;

        // 2. Eliminar el menú.
        // Gracias a 'onDelete('cascade')' en las migraciones,
        // todas las Categorías y MenuItems asociados también serán eliminados automáticamente.
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menú "' . $menuName . '" eliminado con éxito.');
    }
    public function show(Menu $menu)
    {
        // Esta es una vista PÚBLICA de ejemplo, la usaremos para el QR
        // Asegúrate de que esta ruta NO requiera autenticación si quieres que sea pública

        // Cargar las categorías y sus items para mostrar el menú
        $menu->load('categories.items');

        return view('public.menu.show', compact('menu')); // Necesitarás crear esta vista
    }
}
