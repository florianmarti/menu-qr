<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios (clientes).
     */
    public function index()
    {
        // Obtenemos todos los usuarios que son 'customer'
        // y cargamos su relación 'restaurant'
        $users = User::where('role', 'customer')
                        ->with('restaurant')
                        ->latest()
                        ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    // (Aquí irán 'create', 'store', 'edit', 'update', 'destroy' en el futuro)
}
