<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController; // << 1. Importar MenuController
use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===============================================
// RUTA CENTRAL DEL DASHBOARD (PUNTO DE REDIRECCIÓN)
// ===============================================
Route::get('/', function () {
    return view('welcome');
});
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('public.menu.show');
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Utilizamos los métodos isAdmin() e isCustomer() que definimos en User.php
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Por defecto, redirigimos a los clientes/restaurantes
    return redirect()->route('restaurant.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ===============================================
// RUTAS PROTEGIDAS Y FUNCIONALES (AUTH)
// ===============================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Panel de ADMINISTRADOR
    // Esta ruta ya está protegida por el grupo superior y solo es accesible si /dashboard redirigió aquí.
    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    // 2. Panel de RESTAURANTE (Cliente)
    // Esta ruta ya está protegida por el grupo superior y solo es accesible si /dashboard redirigió aquí.
    Route::view('/restaurant/dashboard', 'restaurant.dashboard')
        ->name('restaurant.dashboard');

    // 3. Rutas de GESTIÓN DE RECURSOS (Menús, Categorías, Ítems)
    // Usaremos un prefijo de URI para mayor claridad, pero las rutas siguen siendo /menus, /menus/create, etc.
    // La lógica de verificar el rol 'customer' debe estar en el controlador (MenuController).

    Route::resource('menus', MenuController::class)->names([
        'index' => 'menus.index',
        'create' => 'menus.create',
        'store' => 'menus.store',
        'show' => 'menus.show',
        'edit' => 'menus.edit',
        'update' => 'menus.update',
        'destroy' => 'menus.destroy',
    ]);
    // Ruta para mostrar el Código QR de un Menú específico
    Route::get('menus/{menu}/qr', [MenuController::class, 'showQrCode'])->name('menus.qr');

    // 4. Rutas de Perfil (Breeze por defecto)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/restaurant/qrcodes', [MenuController::class, 'indexQRCodes'])->name('restaurant.qr.index');
    // ... (RUTAS CRUD ANIDADAS DE CATEGORÍAS)
    Route::resource('menus.categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    // >>>>>>>>>>>>>>>>>>>>>> INICIO DE CÓDIGO AÑADIDO <<<<<<<<<<<<<<<<<<<<<<<<
    // CRUD ANIDADO de ITEMS (Platos)
    // URL: /menus/{menu}/categories/{category}/items
    Route::resource('menus.categories.items', MenuItemController::class)->names([
        'index' => 'items.index',
        'create' => 'items.create',
        'store' => 'items.store',
        'show' => 'items.show',
        'edit' => 'items.edit',
        'update' => 'items.update',
        'destroy' => 'items.destroy',
    ]);
    // >>>>>>>>>>>>>>>>>>>>>> FIN DE CÓDIGO AÑADIDO <<<<<<<<<<<<<<<<<<<<<<<<<<
});

require __DIR__ . '/auth.php';
