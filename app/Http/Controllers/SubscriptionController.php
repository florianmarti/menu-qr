<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\User;
use App\Models\Subscription; // Asegúrate de importar tu modelo personalizado

class SubscriptionController extends Controller
{
    /**
     * Muestra la lista de planes de suscripción.
     */
    public function index()
    {
        // Obtener los planes definidos en config/subscription.php
        $plans = config('subscription.types');

        $user = auth()->user();

        // Cargar la suscripción activa si existe
        $currentSubscription = $user->subscription()->first();

        return view('subscription.index', compact('plans', 'user', 'currentSubscription'));
    }

    /**
     * Inicia el proceso de suscripción (Stripe Checkout).
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan' => 'required|string|in:basic,professional,enterprise',
        ]);

        $user = auth()->user();
        $planType = $request->plan;
        $planDetails = config("subscription.types.{$planType}");

        if (!$planDetails) {
            return back()->with('error', 'El plan seleccionado no es válido.');
        }

        // Si el usuario ya tiene una suscripción, lo redirigimos para que la gestione
        if ($user->hasActiveSubscription()) {
            return back()->with('warning', 'Ya tienes una suscripción activa. Utiliza el portal de facturación para cambiar o cancelar tu plan.');
        }

        $stripePriceId = $planDetails['stripe_price_id'];

        // Crear una nueva suscripción con Cashier
        return $user->newSubscription($planType, $stripePriceId)
                    ->allowPromotionCodes()
                    // Usamos checkout() para dirigir al usuario a la página de pago de Stripe
                    ->checkout([
                        'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url' => route('subscription.cancel'),
                    ]);
    }

    /**
     * Maneja la redirección después de un pago exitoso y vincula la suscripción.
     */
    public function success(Request $request)
    {
        // Este paso es crucial. Una vez que Stripe notifique el pago (via webhook o aquí),
        // Cashier registra la suscripción en la base de datos.

        // En entornos reales, la confirmación final de la base de datos se maneja
        // con los Webhooks de Stripe. Por ahora, nos aseguraremos de que la sesión
        // de Stripe se haya completado.

        $user = auth()->user();

        // 1. Obtener la sesión de Stripe
        try {
            $checkoutSession = $user->stripe()->checkout->sessions->retrieve($request->query('session_id'));
        } catch (\Exception $e) {
            // Manejar error si la sesión no es válida o falta
            return redirect()->route('dashboard')->with('error', 'Error al verificar el pago.');
        }

        // 2. Usar los datos de la sesión para actualizar el modelo Subscription personalizado
        // Nota: Laravel Cashier ya habrá creado o actualizado la suscripción base

        // Simplemente redirigimos y confiamos en que el webhook (que configuraremos más tarde)
        // o la magia de Cashier ya lo manejó, o que la próxima carga del usuario
        // lo sincronizará.

        return view('subscription.success')->with('message', '¡Suscripción exitosa! Disfruta de las funciones de tu plan.');
    }

    /**
     * Maneja la redirección si el usuario cancela el checkout.
     */
    public function cancel()
    {
        return redirect()->route('subscription.index')->with('warning', 'La compra fue cancelada. Puedes reintentar la suscripción.');
    }

    /**
     * Redirige al portal de facturación de Stripe para gestionar la suscripción.
     */
    public function billingPortal()
    {
        // Esto redirige al usuario al portal de clientes de Stripe.
        // Asegúrate de que tu modelo User use el trait Billable.
        return auth()->user()->redirectToBillingPortal(route('subscription.index'));
    }
}
