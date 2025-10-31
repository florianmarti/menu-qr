<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant; // <<< Asegúrate que esta línea exista
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <<< Asegúrate que esta línea exista
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str; // <<< Asegúrate que esta línea exista

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {

            $user = DB::transaction(function () use ($request) {

                // 1. Crear el Restaurante PRIMERO
                $restaurant = Restaurant::create([
                    'name' => $request->name,
                    'slug' => 'temp-' . Str::uuid(), // Slug temporal único
                    'description' => 'Bienvenido a tu restaurante. Puedes editar esta descripción más tarde.',
                ]);

                // 2. Crear el Usuario, vinculándolo INMEDIATAMENTE
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                    'restaurant_id' => $restaurant->id, // ¡Vinculado en la creación!
                ]);

                // 3. Actualizar el slug del Restaurante con el ID de usuario
                $restaurant->slug = Str::slug($request->name) . '-' . $user->id;
                $restaurant->save();

                return $user; // Devolver el usuario recién creado
            });

        } catch (\Exception $e) {
            // (En un escenario real, aquí registrarías el error con Log::error($e))
            return redirect()->back()
                ->with('error', 'Hubo un problema al crear tu cuenta y restaurante. Por favor, intenta de nuevo.')
                ->withInput();
        }

        // Refrescar el objeto $user para asegurar que la sesión obtenga la relación
        $user->refresh();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
