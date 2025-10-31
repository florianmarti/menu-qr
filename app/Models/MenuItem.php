<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id', // 'menu_id' no está en la tabla menu_items, se obtiene a través de la categoría
        'name',
        'description',
        'price',
        'image',
        'is_available', // Campo para disponibilidad
        'show_image',   // ¡CORRECCIÓN! Añadido aquí
        'is_featured',  // (Lo tenías en fillable, asegúrate que esté en tu migración si lo usarás)
        'allergens',
        'order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'allergens' => 'array',
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'show_image' => 'boolean', // Esto ya estaba correcto
    ];

    /**
     * Obtiene el menú al que pertenece este ítem, a través de su categoría.
     */
    public function menu()
    {
       // Esta relación es inteligente: va de Item -> Category -> Menu
       return $this->category->menu();
    }

    /**
     * Obtiene la categoría a la que pertenece este ítem.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
