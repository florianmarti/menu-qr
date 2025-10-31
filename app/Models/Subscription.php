<?php
// app/Models/Subscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * (Corregido para coincidir con tu base de datos actual)
     */
    protected $fillable = [
        'user_id',
        'plan_name',
        'status',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Una suscripción pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si la suscripción está activa (no ha terminado).
     */
    public function isActive()
    {
        // >>>>>>>>>>>>>> INICIO DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<
        // Comprueba si el estado es 'active' Y la fecha de expiración es futura (o nula)
        // (Cambiado de $this.status a $this->status)
        return $this->status === 'active' &&
               (is_null($this->expires_at) || $this->expires_at->isFuture());
        // >>>>>>>>>>>>>> FIN DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<<<
    }
}
