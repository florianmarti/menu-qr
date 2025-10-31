<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Coincide con tu archivo .sql
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_path',    
        'theme_color',
    ];

    /**
     * The attributes that should be cast.
     * (Columnas que no existen en tu BD actual han sido comentadas)
     */
    protected $casts = [
        // 'business_hours' => 'array',
        // 'theme_settings' => 'array'
    ];

    /**
     * Un restaurante le pertenece a un usuario (a través de la tabla 'users').
     * Tu base de datos tiene 'restaurant_id' en la tabla 'users',
     * por lo tanto, un Restaurante "tiene un" Usuario.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Un restaurante tiene muchos menús.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Obtiene el menú activo para este restaurante.
     * (CORREGIDO: 'publicF' cambiado a 'public')
     */
    public function activeMenu()
    {
        return $this->menus()->where('is_active', true)->first();
    }
}
