<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (Muestra la lista de categorías para un menú).
     */
    public function index(Menu $menu)
    {
        // 1. Verificar la propiedad: Asegura que el Menú pertenezca al usuario/restaurante
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado: Menú no encontrado.');
        }

        // 2. Obtener categorías a través de la relación
        $categories = $menu->categories()->orderBy('order')->get();

        // 3. Pasar tanto el menú como las categorías a la vista
        return view('restaurant.categories.index', compact('menu', 'categories'));
    }
    public function create(Menu $menu)
    {
        // 1. Verificar la propiedad (esto ya asegura que el usuario sea dueño del menú)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado: Menú no encontrado.');
        }

        // Retornamos la vista, pasando el objeto $menu
        return view('restaurant.categories.create', compact('menu'));
    }
    public function store(Request $request, Menu $menu)
    {
        // 1. Verificar la propiedad (seguridad)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        // 2. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // 3. Crear la nueva categoría y vincularla al menú
        // Usamos $menu->categories()->create() para asegurar la FK 'menu_id'
        $category = $menu->categories()->create($validated);

        // 4. Redirigir de vuelta a la lista de categorías de ese menú
        return redirect()->route('categories.index', $menu)->with('success', 'Categoría "' . $category->name . '" creada con éxito.');
    }
    public function edit(Menu $menu, Category $category)
    {
        // 1. Verificar la propiedad: Que el menú pertenezca al usuario/restaurante
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado.');
        }

        // 2. Verificar la relación: Que la categoría pertenezca al menú
        if ($category->menu_id !== $menu->id) {
            return redirect()->route('categories.index', $menu)->with('error', 'Categoría no pertenece a este menú.');
        }

        return view('restaurant.categories.edit', compact('menu', 'category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Menu $menu, Category $category)
    {
        // 1. Verificar propiedad y relación
        if ($menu->restaurant_id !== Auth::user()->restaurant->id || $category->menu_id !== $menu->id) {
            return redirect()->route('categories.index', $menu)->with('error', 'Acceso denegado o categoría incorrecta.');
        }

        // 2. Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // 3. Actualizar la categoría
        $category->update($validated);

        // 4. Redirigir y mostrar mensaje de éxito
        return redirect()->route('categories.index', $menu)->with('success', 'Categoría "' . $category->name . '" actualizada con éxito.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Menu $menu, Category $category)
    {
        // 1. Verificar propiedad y relación
        if ($menu->restaurant_id !== Auth::user()->restaurant->id || $category->menu_id !== $menu->id) {
            return redirect()->route('categories.index', $menu)->with('error', 'Acceso denegado o categoría incorrecta.');
        }

        $categoryName = $category->name;

        // 2. Eliminar la categoría.
        // Gracias a 'onDelete('cascade')' en las migraciones de menu_items,
        // todos los platos asociados se eliminarán automáticamente.
        $category->delete();

        return redirect()->route('categories.index', $menu)->with('success', 'Categoría "' . $categoryName . '" eliminada con éxito.');
    }
    // ... (otros métodos create, store, etc. se implementarán a continuación) ...
}
