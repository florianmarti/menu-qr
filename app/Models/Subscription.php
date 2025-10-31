<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'restaurant_id', 'type', 'stripe_subscription_id',
        'stripe_customer_id', 'trial_ends_at', 'ends_at', 'features'
    ];

    protected $casts = [
        'features' => 'array',
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Verifica si la suscripción está activa (no ha terminado).
     */
    public function isActive()
    {
        return is_null($this->ends_at) || $this->ends_at->isFuture();
    }

    public function isOnTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function getFeatures()
    {
        // Usa la configuración de suscripción para obtener las características
        return $this->features ?? config("subscription.types.{$this->type}.features", []);
    }
}
