<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// ELIMINADAS: use Laravel\Cashier\Billable;
use App\Models\Restaurant; // Dejamos tus relaciones
use App\Models\Subscription; // Dejamos tus relaciones


/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * * DOCBLOCK SIMPLIFICADO
 * ------------------------------------
 * @property-read \App\Models\Restaurant $restaurant
 * @property-read \App\Models\Subscription $subscription
 * // ELIMINADOS: MÉTODOS DE CASHIER
 * // Métodos de Eloquent/Relación:
 * @method \Illuminate\Database\Eloquent\Relations\HasOne subscription()
 * @method \Illuminate\Database\Eloquent\Relations\HasOne restaurant()
 * ------------------------------------
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // ELIMINADO: Billable
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'restaurant_id',
    ];

    // ... (resto del código del modelo es correcto) ...

    /**
     * Obtiene el restaurante asociado con el usuario.
     */
    public function isAdmin(): bool
    {
        // Compara el valor de la columna 'role' con 'admin'
        return $this->role === 'admin';
    }

    /**
     * Verifica si el usuario tiene el rol de cliente/restaurante.
     * @return bool
     */
    public function isCustomer(): bool
    {
        // Compara el valor de la columna 'role' con 'customer'
        return $this->role === 'customer';
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    /**
     * Obtiene la suscripción personalizada del usuario.
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Verifica si el usuario tiene una suscripción activa (personalizada).
     *
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->isActive();
    }
}
