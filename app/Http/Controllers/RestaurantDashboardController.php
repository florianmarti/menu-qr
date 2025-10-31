<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantDashboardController extends Controller
{
    /**
     * Muestra el dashboard del restaurante con datos dinámicos.
     */
    public function index()
    {
        // 1. Obtener el restaurante del usuario (método seguro)
        $user = User::find(Auth::id());
        $restaurant = $user->restaurant;

        // Si no hay restaurante (aunque no debería pasar), redirigir
        if (!$restaurant) {
            return redirect('/')->with('error', 'Restaurante no encontrado.');
        }

        $restaurantId = $restaurant->id;

        // 2. Obtener las "Stats Cards" (Tarjetas de estadísticas)
        // Usamos whereHas para contar a través de las relaciones

        // Contar menús activos
        $menuCount = $restaurant->menus()->where('is_active', true)->count();

        // Contar todas las categorías del restaurante
        $categoryCount = Category::whereHas('menu', function ($query) use ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        })->count();

        // Contar todos los platos del restaurante
        $itemCount = MenuItem::whereHas('category.menu', function ($query) use ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        })->count();

        // Contar todos los menús (para la tarjeta de QR, ya que cada menú tiene un QR)
        $qrCount = $restaurant->menus()->count();


        // 3. Obtener la tabla de "Menús Recientes"
        // Cargamos los menús más nuevos, y contamos sus categorías
        $recentMenus = $restaurant->menus()
                            ->withCount('categories') // Esto crea una variable 'categories_count'
                            ->latest() // Ordena por 'created_at' descendente
                            ->take(5)    // Limita a los 5 más nuevos
                            ->get();


        // 4. Obtener "Actividad Reciente"
        // NOTA: Aún no hemos implementado un registro de actividad (Activity Log).
        // Esto es una funcionalidad más avanzada (escalado).
        // Por ahora, enviaremos una lista vacía.
        $recentActivity = [];


        // 5. Enviar todos los datos a la vista
        return view('restaurant.dashboard', [
            'menuCount' => $menuCount,
            'categoryCount' => $categoryCount,
            'itemCount' => $itemCount,
            'qrCount' => $qrCount,
            'recentMenus' => $recentMenus,
            'recentActivity' => $recentActivity,
        ]);
    }
}
