<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule; 
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            // Pasamos el restaurante a la vista para el formulario de branding
            'restaurant' => $request->user()->restaurant,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // >>>>>>>>>>>>>> INICIO DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<
    /**
     * Actualiza el branding (logo y color) del restaurante.
     */
    public function updateBranding(Request $request): RedirectResponse
    {
        // 1. Obtener el restaurante (método seguro)
        $user = User::find(Auth::id());
        $restaurant = $user->restaurant;

        if (!$restaurant) {
            return Redirect::route('profile.edit')->with('error', 'Restaurante no encontrado.');
        }

        // 2. Validar los datos
        $validated = $request->validate([
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg', // Restricción de tipo de archivo
                'max:2048', // Restricción de tamaño (2MB)
            ],
            'theme_color' => [
                'nullable',
                'string',
                'regex:/^#[a-fA-F0-9]{6}$/', // Restricción de formato (Hexadecimal #RRGGBB)
            ],
        ]);

        // 3. Manejar la subida del logo
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($restaurant->logo_path) {
                Storage::disk('public')->delete($restaurant->logo_path);
            }

            // Guardar el nuevo logo en 'storage/app/public/logos'
            $path = $request->file('logo')->store('logos', 'public');
            $restaurant->logo_path = $path;
        }

        // 4. Guardar el color
        if ($request->filled('theme_color')) {
            $restaurant->theme_color = $request->theme_color;
        }

        $restaurant->save();

        return Redirect::route('profile.edit')->with('status', 'branding-updated');
    }
    // >>>>>>>>>>>>>> FIN DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<<<

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
