<?php

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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            // --- ASEGÚRATE DE QUE ESTAS LÍNEAS ESTÉN PRESENTES ---
            $table->string('name');
            $table->string('slug')->unique(); // Asegura que sea único
            $table->text('description')->nullable();
            // --- FIN DE LAS LÍNEAS IMPORTANTES ---

            // Puedes añadir aquí otras columnas de tu modelo si las necesitas ya
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            // $table->string('logo')->nullable();
            // $table->string('cover_image')->nullable();
            // $table->string('phone')->nullable();
            // $table->text('address')->nullable();
            // $table->json('business_hours')->nullable();
            // $table->json('theme_settings')->nullable();
            // $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
