<?php
// database/migrations/xxxx_create_subscriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            // Vincula la suscripción a un usuario (dueño del restaurante)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('plan_name'); // Ej: "Básico", "Pro"
            $table->string('status'); // Ej: "active", "cancelled", "expired"
            $table->timestamp('expires_at')->nullable(); // Fecha de vencimiento

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
