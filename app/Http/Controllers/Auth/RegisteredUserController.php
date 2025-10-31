<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant; // Importar el modelo Restaurant
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Para la transacción
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str; // Para generar el slug

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

        // >>>>>>>>>>>>>> INICIO DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<
        // Usamos una transacción para asegurar que ambas creaciones
        // se completen exitosamente.
        try {

            $user = DB::transaction(function () use ($request) {

                // 1. Crear el Restaurante PRIMERO (con un slug temporal)
                $restaurant = Restaurant::create([
                    'name' => $request->name,
                    'slug' => 'temp-' . Str::uuid(), // Slug temporal único
                    'description' => 'Bienvenido a tu restaurante. Puedes editar esta descripción más tarde.',
                ]);

                // 2. Crear el Usuario, pasando el ID del restaurante INMEDIATAMENTE
                // (Esto es posible porque 'restaurant_id' está en $fillable en User.php)
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                    'restaurant_id' => $restaurant->id, // ¡Vinculado en la creación!
                ]);

                // 3. Actualizar el slug del Restaurante con el ID de usuario
                // para que sea permanente y descriptivo.
                $restaurant->slug = Str::slug($request->name) . '-' . $user->id;
                $restaurant->save();

                return $user; // Devolver el usuario recién creado
            });

        } catch (\Exception $e) {
            // Manejar un posible error durante la transacción
            // (En un escenario real, aquí registrarías el error con Log::error($e))
            return redirect()->back()
                ->with('error', 'Hubo un problema al crear tu cuenta y restaurante. Por favor, intenta de nuevo.')
                ->withInput();
        }
        $user->refresh();
        // >>>>>>>>>>>>>> FIN DE CÓDIGO MODIFICADO <<<<<<<<<<<<<<<<<<

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
