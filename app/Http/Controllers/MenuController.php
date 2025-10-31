<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Menu;
use App\Models\User; // <<< ¡IMPORTANTE! AÑADIR ESTA LÍNEA
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
        $this->middleware('auth')->except('show');
    }

    /**
     * Muestra la lista de menús.
     */
    public function index()
    {
        // >>>>>>>>>>>>>> INICIO DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // En lugar de Auth::user() (que puede estar obsoleto),
        // recargamos el usuario desde la BD para asegurar los datos frescos.
        $user = User::find(Auth::id());
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        if (!$user) {
            Log::error('MenuController@index: Auth::user() es null.');
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
        }

        $restaurant = $user->restaurant; // Ahora usamos la relación cargada

        // Si el restaurante sigue siendo null (p.ej. error de BD)
        if (!$restaurant) {
            Log::warning('Redirigiendo a dashboard porque no se encontró restaurante para User ID: ' . $user->id);
            return redirect()->route('dashboard')->with('error', 'No se encontró un restaurante asociado a tu cuenta.');
        }

        // Obtiene todos los menús de ese restaurante
        $menus = $restaurant->menus()->get();

        return view('restaurant.menus.index', compact('menus'));
    }

    /**
     * Muestra la página de gestión general de Códigos QR.
     */
    public function indexQRCodes()
    {
        // >>>>>>>>>>>>>> CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // Aplicamos el mismo parche de seguridad
        $user = User::find(Auth::id());
        $restaurant = $user->restaurant;
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        if (!$restaurant) {
            return redirect()->route('dashboard')->with('error', 'No se encontró un restaurante asociado.');
        }

        $menus = $restaurant->menus()->get();
        return view('restaurant.qr.index', compact('menus'));
    }

    public function showQrCode(Menu $menu)
    {
        // >>>>>>>>>>>>>> CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // Recargamos el usuario para la comprobación de seguridad
        $user = User::find(Auth::id());
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        if ($menu->restaurant_id !== $user->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        $publicUrl = route('public.menu.show', $menu->id);
        $qrCodeSvg = QrCode::size(300)->generate($publicUrl);

        return view('restaurant.menus.qr_code', compact('menu', 'qrCodeSvg', 'publicUrl'));
    }

    public function create()
    {
        // >>>>>>>>>>>>>> CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // Aplicamos el parche aquí también
        $user = User::find(Auth::id());
        $restaurant = $user->restaurant;
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        if (!$restaurant) {
            return redirect()->route('dashboard')->with('error', 'Error al encontrar tu restaurante.');
        }

        return view('restaurant.menus.create', compact('restaurant'));
    }

    public function store(Request $request)
    {
        // 1. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // >>>>>>>>>>>>>> INICIO DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // 2. Obtener el restaurante del usuario (Método seguro)
        // Recargamos el usuario fresco desde la BD
        $user = User::find(Auth::id());
        $restaurant = $user->restaurant;

        // Verificación de seguridad por si acaso
        if (!$restaurant) {
            Log::error('MenuController@store: ¡Intento de guardar sin restaurante! User ID: ' . $user->id);
            return redirect()->route('dashboard')->with('error', 'Error al guardar el menú. No se encontró tu restaurante.');
        }
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        // 3. Crear el nuevo menú y vincularlo al restaurante
        $menu = $restaurant->menus()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        // 4. Redirigir y mostrar mensaje de éxito
        return redirect()->route('menus.index')->with('success', 'Menú "' . $menu->name . '" creado con éxito.');
    }

    public function edit(Menu $menu)
    {
        // 1. Verificar la propiedad:
        // (Aplicamos el parche aquí también)
        $user = User::find(Auth::id());
        if ($menu->restaurant_id !== $user->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado. Este menú no te pertenece.');
        }

        return view('restaurant.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage (Actualiza el menú).
     */
    public function update(Request $request, Menu $menu)
    {
        // (Aplicamos el parche aquí también)
        $user = User::find(Auth::id());
        if ($menu->restaurant_id !== $user->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        // 2. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // 3. Actualizar el menú
        $menu->update($validated);

        // 4. Redirigir y mostrar mensaje de éxito
        return redirect()->route('menus.index')->with('success', 'Menú "' . $menu->name . '" actualizado con éxito.');
    }

    public function destroy(Menu $menu)
    {
        // (Aplicamos el parche aquí también)
        $user = User::find(Auth::id());
        if ($menu->restaurant_id !== $user->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        $menuName = $menu->name;
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menú "' . $menuName . '" eliminado con éxito.');
    }

    public function show(Menu $menu)
    {
        // Esta es la vista PÚBLICA (no requiere autenticación)
        $menu->load([
            'categories' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('order')
                      ->whereHas('items', function ($itemQuery) {
                          $itemQuery->where('is_available', true);
                      })
                      ->with(['items' => function ($itemQuery) {
                          $itemQuery->where('is_available', true)
                                    ->orderBy('order');
                      }]);
            }
        ]);

        $menu->load('restaurant');
        return view('public.menu.show', compact('menu'));
    }
}
