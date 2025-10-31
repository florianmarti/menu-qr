<?php
// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el dashboard principal del administrador.
     */
    public function index()
    {
        // Cargamos estadísticas para las tarjetas
        // Contamos solo clientes (dueños de restaurantes)
        $userCount = User::where('role', 'customer')->count();
        $restaurantCount = Restaurant::count();
        $menuCount = Menu::count();

        // (Placeholder para futuras estadísticas)
        $subscriptionCount = 0;

        // Cargamos listas para las tablas
        $recentRestaurants = Restaurant::with('user') // Carga al dueño
                                ->latest()
                                ->take(5)
                                ->get();

        $recentUsers = User::where('role', 'customer')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', [
            'userCount' => $userCount,
            'restaurantCount' => $restaurantCount,
            'menuCount' => $menuCount,
            'subscriptionCount' => $subscriptionCount,
            'recentRestaurants' => $recentRestaurants,
            'recentUsers' => $recentUsers,
        ]);
    }
}
