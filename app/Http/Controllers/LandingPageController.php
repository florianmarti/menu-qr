<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail; // Importamos el Mailable
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; // Para registrar errores

class LandingPageController extends Controller
{
    /**
     * Maneja la solicitud del formulario de contacto.
     */
    public function handleContactForm(Request $request): RedirectResponse
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10', // La validación sigue activa
        ]);

        try {

            // >>>>>>>>>>>>>> INICIO DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<

            // Volvemos a usar el Mailable profesional (HTML)
            // (Hemos eliminado el Mail::raw de depuración)

            Mail::to(config('mail.from.address'))->send(
                new ContactFormMail(
                    $validated['name'],
                    $validated['email'],
                    $validated['message']
                )
            );

            // >>>>>>>>>>>>>> FIN DE CÓDIGO CORREGIDO <<<<<<<<<<<<<<<<<<

        } catch (\Exception $e) {
            // 3. Manejar error
            Log::error('Error al enviar email de contacto (ContactFormMail): ' . $e->getMessage());

            // Redirigir de vuelta con un error
            return redirect('/#contacto')
                ->with('error', 'Hubo un problema al enviar tu mensaje. Por favor, intenta más tarde.');
        }

        // 4. Redirigir de vuelta con éxito
        return redirect('/#contacto')
            ->with('success', '¡Mensaje enviado con éxito! Te responderemos pronto.'); // Mensaje de éxito normal
    }
}
