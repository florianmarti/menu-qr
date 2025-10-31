<?php
// routes/web.php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantDashboardController;
use Illuminate\Support\Facades\Auth;

// ... (rutas welcome, public.menu.show, dashboard sin cambios) ...
Route::get('/', function () {
    return view('welcome');
});
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('public.menu.show');
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('restaurant.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ===============================================
// RUTAS PROTEGIDAS Y FUNCIONALES (AUTH)
// ===============================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Panel de ADMINISTRADOR
    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    // >>>>>>>>>>>>>> INICIO DE CORRECCIÓN DE BUG <<<<<<<<<<<<<<<<
    // 2. Panel de RESTAURANTE (Cliente)
    // TENÍAS ESTA RUTA DUPLICADA. La ruta 'Route::view' de abajo
    // estaba bloqueando al controlador 'RestaurantDashboardController'.
    // He eliminado la siguiente línea:
    // Route::view('/restaurant/dashboard', 'restaurant.dashboard')
    //    ->name('restaurant.dashboard');
    //
    // Esta es la única línea que debe existir para esta ruta:
    Route::get('/restaurant/dashboard', [RestaurantDashboardController::class, 'index'])
        ->name('restaurant.dashboard');
    // >>>>>>>>>>>>>> FIN DE CORRECCIÓN DE BUG <<<<<<<<<<<<<<<<<<

    // 3. Rutas de GESTIÓN DE RECURSOS (Menús)
    Route::resource('menus', MenuController::class)->names([
        'index' => 'menus.index',
        'create' => 'menus.create',
        'store' => 'menus.store',
        'show' => 'menus.show',
        'edit' => 'menus.edit',
        'update' => 'menus.update',
        'destroy' => 'menus.destroy',
    ]);
    Route::get('menus/{menu}/qr', [MenuController::class, 'showQrCode'])->name('menus.qr');

    // 4. Rutas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // >>>>>>>>>>>>>> INICIO DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<
    // Nueva ruta para actualizar el Branding (logo y color)
    Route::patch('/profile/branding', [ProfileController::class, 'updateBranding'])
         ->name('profile.branding.update');
    // >>>>>>>>>>>>>> FIN DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<<<

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

    // ... (RUTAS CRUD ANIDADAS DE ITEMS)
    Route::resource('menus.categories.items', MenuItemController::class)->names([
        'index' => 'items.index',
        'create' => 'items.create',
        'store' => 'items.store',
        'show' => 'items.show',
        'edit' => 'items.edit',
        'update' => 'items.update',
        'destroy' => 'items.destroy',
    ]);
});

require __DIR__ . '/auth.php';
