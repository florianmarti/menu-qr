<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;

class RolesAndRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear un Restaurante de Prueba (requerido por el usuario cliente)
        $restaurant = Restaurant::create([
            'name' => 'Ojete torcido',
            'slug' => 'el-rincon-de-prueba',
            'description' => 'Restaurante de prueba para el sistema QR.'
        ]);

        // 2. Crear Usuario ADMINISTRADOR
        User::create([
            'name' => 'Admin Global',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(), // Verificado automáticamente
        ]);

        // 3. Crear Usuario CLIENTE/RESTAURANTE
        User::create([
            'name' => 'Florian Restaurant',
            'email' => 'restaurant@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(), // Verificado automáticamente
            'restaurant_id' => $restaurant->id, // Vincula el cliente al restaurante
        ]);

        $this->command->info('Usuarios Admin y Cliente, y Restaurante creados exitosamente.');
    }
}
