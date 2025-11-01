<?php
// routes/web.php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantDashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\LandingPageController;


Route::post('/contact', [LandingPageController::class, 'handleContactForm'])->name('contact.submit');
// ===============================================
// RUTA CENTRAL DEL DASHBOARD (PUNTO DE REDIRECCIÓN)
// ===============================================
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

    // -------------------------------------------------------------------
    // GRUPO DE RUTAS DE ADMINISTRADOR (Súper Admin)
    // -------------------------------------------------------------------
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de Restaurantes
        Route::resource('restaurants', AdminRestaurantController::class)->only([
            'index'
        ]);

        // Gestión de Usuarios
        Route::resource('users', AdminUserController::class)->only([
            'index'
        ]);

        // >>>>>>>>>>>>>> INICIO DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<
        // Gestión de Suscripciones
        Route::resource('subscriptions', AdminSubscriptionController::class)->only([
            'index' // Por ahora, solo la lista
        ]);
        // >>>>>>>>>>>>>> FIN DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<<<

    }); // <-- Fin del grupo Admin

    // -------------------------------------------------------------------
    // GRUPO DE RUTAS DE CLIENTE (Dueño de Restaurante)
    // -------------------------------------------------------------------

    // Dashboard
    Route::get('/restaurant/dashboard', [RestaurantDashboardController::class, 'index'])
        ->name('restaurant.dashboard');

    // Gestión de Menús (Recurso)
    Route::resource('menus', MenuController::class)->names([
        'index' => 'menus.index',
        'create' => 'menus.create',
        'store' => 'menus.store',
        'show' => 'menus.show',
        'edit' => 'menus.edit',
        'update' => 'menus.update',
        'destroy' => 'menus.destroy',
    ]);
    // Rutas anidadas de Categorías
    Route::resource('menus.categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);
    // Rutas anidadas de Platos
    Route::resource('menus.categories.items', MenuItemController::class)->names([
        'index' => 'items.index',
        'create' => 'items.create',
        'store' => 'items.store',
        'show' => 'items.show',
        'edit' => 'items.edit',
        'update' => 'items.update',
        'destroy' => 'items.destroy',
    ]);

    // Gestión de QR
    Route::get('menus/{menu}/qr', [MenuController::class, 'showQrCode'])->name('menus.qr');
    Route::get('/restaurant/qrcodes', [MenuController::class, 'indexQRCodes'])->name('restaurant.qr.index');

    // Perfil (común para ambos roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/branding', [ProfileController::class, 'updateBranding'])
         ->name('profile.branding.update');

}); // <-- Fin del grupo Auth

require __DIR__ . '/auth.php';
