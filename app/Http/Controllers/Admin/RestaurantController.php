<?php
// app/Http/Controllers/Admin/RestaurantController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Muestra una lista de todos los restaurantes.
     */
    public function index()
    {
        // Obtenemos todos los restaurantes, cargando la relación 'user' (dueño)
        $restaurants = Restaurant::with('user')->latest()->paginate(20);

        return view('admin.restaurants.index', compact('restaurants'));
    }

    // (Aquí irán 'create', 'store', 'edit', 'update', 'destroy' en el futuro)
}
