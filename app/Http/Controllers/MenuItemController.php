<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuItem; // Necesario para la gestión de platos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    public function __construct()
    {
        // Aseguramos que el usuario esté autenticado para todas las acciones.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (Muestra la lista de platos para una categoría).
     */
    public function index(Menu $menu, Category $category)
    {
        // 1. Verificar la propiedad del Menú (Seguridad en el nivel superior)
        if ($menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('menus.index')->with('error', 'Acceso denegado: Menú no encontrado.');
        }

        // 2. Verificar la relación del Menú y la Categoría
        if ($category->menu_id !== $menu->id) {
            return redirect()->route('categories.index', $menu)->with('error', 'Categoría no pertenece a este menú.');
        }

        // 3. Obtener los platos a través de la relación de la categoría
        // El método items() debe estar definido en el modelo Category
        $items = $category->items()->orderBy('order')->get();

        // 4. Pasar los objetos necesarios a la vista
        return view('restaurant.items.index', compact('menu', 'category', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Menu $menu, Category $category)
    {
        // Verificar propiedad/relación
        if ($menu->restaurant_id !== Auth::user()->restaurant->id || $category->menu_id !== $menu->id) {
            abort(403, 'Acción no autorizada.');
        }
        return view('restaurant.items.create', compact('menu', 'category'));
    }
    /**
     * Store a newly created resource in storage. (CORREGIDO)
     */
    public function store(Request $request, Menu $menu, Category $category)
    {
        // 1. Re-validación de seguridad
        if ($menu->restaurant_id !== Auth::user()->restaurant->id || $category->menu_id !== $menu->id) {
            return redirect()->route('menus.index')->with('error', 'Error de seguridad al guardar el plato.');
        }

        // 2. Validación
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // No validamos booleanos aquí, los manejamos manualmente
        ]);

        // 3. Manejo de la subida de imagen (Ruta 'item_images')
        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = Str::uuid() . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('item_images', $imageName, 'public'); // Ruta consistente
        }

        // 4. Creación del nuevo plato con datos validados y booleanos explícitos
        $item = new MenuItem($validatedData); // Rellenar con los datos validados
        $item->category_id = $category->id;
        $item->image = $imagePath;
        $item->is_available = $request->has('is_available'); // Asignar booleano
        $item->show_image = $request->has('show_image');     // Asignar booleano
        $item->save(); // Guardar el nuevo item

        // 5. Redirección
        return redirect()
            ->route('items.index', ['menu' => $menu, 'category' => $category])
            ->with('success', '¡El plato "' . $item->name . '" ha sido añadido exitosamente!');
    }

    // El método show (para ver un solo plato) a menudo se omite o es simple.
    public function show(Menu $menu, Category $category, MenuItem $item)
    {
        // Verificar relaciones
        if ($item->category_id !== $category->id || $category->menu_id !== $menu->id) {
            abort(404);
        }
        // Puedes crear una vista específica si lo necesitas
        return view('restaurant.items.show', compact('menu', 'category', 'item')); // Asegúrate de tener esta vista si la usas
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Menu $menu, Category $category, MenuItem $item)
    {
        // Verificar relaciones y propiedad
        if ($item->category_id !== $category->id || $category->menu_id !== $menu->id || $menu->restaurant_id !== Auth::user()->restaurant->id) {
            return redirect()->route('items.index', [$menu, $category])->with('error', 'Plato no encontrado o acceso denegado.');
        }
        return view('restaurant.items.edit', compact('menu', 'category', 'item'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Menu $menu, Category $category, MenuItem $item)
    {
        // 1. Re-validación de seguridad
        if ($item->category_id !== $category->id || $category->menu_id !== $menu->id || $menu->restaurant_id !== Auth::user()->restaurant->id) {
             return redirect()->route('menus.index')->with('error', 'Error de seguridad al actualizar el plato.');
        }

        // 2. Validación (solo campos que pueden cambiar)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ---- DEBUGGING ----
        Log::info('Datos recibidos en update:', $request->all());
        Log::info('Valor de show_image recibido (has): ' . ($request->has('show_image') ? 'true' : 'false'));
        Log::info('Valor actual de show_image en el modelo: ' . ($item->show_image ? 'true' : 'false'));
        // -------------------

        // 3. Actualizar campos directamente en el modelo
        $item->fill($validatedData); // Rellena los campos validados

        // 4. Manejo explícito de los checkboxes
        $item->is_available = $request->has('is_available');
        $item->show_image = $request->has('show_image'); // <-- Asignación directa

        // 5. Manejo de la subida de imagen (si se sube una nueva)
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Eliminar imagen anterior si existe
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // Guardar la nueva imagen (Ruta 'item_images')
            $imageName = Str::uuid() . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('item_images', $imageName, 'public');
            $item->image = $imagePath; // Actualizar la ruta de la imagen
        }

        // 6. Guardar los cambios en la base de datos
        $item->save();

        // ---- DEBUGGING ----
        Log::info('Datos del item después de guardar:', $item->toArray());
        // -------------------

        // 7. Redirección
        return redirect()
            ->route('items.index', ['menu' => $menu, 'category' => $category])
            ->with('success', '¡El plato "' . $item->name . '" ha sido actualizado exitosamente!');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Menu $menu, Category $category, MenuItem $item)
    {
        // 1. Re-validación de seguridad
        if ($item->category_id !== $category->id || $category->menu_id !== $menu->id || $menu->restaurant_id !== Auth::user()->restaurant->id) {
             return redirect()->route('menus.index')->with('error', 'Error de seguridad al intentar eliminar el plato.');
        }

        $itemName = $item->name;

        // 2. Eliminar la imagen asociada (si existe)
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        // 3. Eliminar el plato de la base de datos
        $item->delete();

        // 4. Redirección
        return redirect()
            ->route('items.index', ['menu' => $menu, 'category' => $category])
            ->with('success', '¡El plato "' . $itemName . '" ha sido eliminado!');
    }
}
