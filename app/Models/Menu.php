<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'name', 'description', 'is_active',
        'template', 'custom_settings'
    ];

    protected $casts = [
        'custom_settings' => 'array'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items()
    {
        return $this->hasManyThrough(MenuItem::class, Category::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function activeItems()
    {
        // Esta función no es correcta aquí, ya que los items se relacionan con las categorías.
        // La dejaremos temporalmente, pero la relación más limpia es de Category a MenuItem.
        return $this->items()->where('is_available', true)->orderBy('order');
    }

    // Función de utilidad para obtener categorías asociadas a este menú
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
