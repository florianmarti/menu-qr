<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [

        'menu_id', 'name', 'description', 'order', 'is_active'
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function activeItems()
    {
        return $this->items()->where('is_available', true)->orderBy('order');
    }
}
