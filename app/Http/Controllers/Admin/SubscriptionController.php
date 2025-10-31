<?php
// app/Http/Controllers/Admin/SubscriptionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Muestra una lista de todas las suscripciones.
     */
    public function index()
    {
        // Cargamos todas las suscripciones, incluyendo la info del usuario y su restaurante
        $subscriptions = Subscription::with('user.restaurant')
                                ->latest()
                                ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}
