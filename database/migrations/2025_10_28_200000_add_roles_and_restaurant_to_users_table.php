<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Aseguramos que la columna 'role' se añada si no existía (no causará conflicto si ya existe)
        // Pero para estar 100% seguros tras el migrate:fresh, la añadimos.
        // Si el fresh no las crea, aquí deben ir.

        // 1. Añade la columna 'role' (asumiendo que migrate:fresh la borró)
        $table->string('role')->default('customer')->after('email');

        // 2. Añade la columna 'restaurant_id' (si migrate:fresh la borró)
        $table->foreignId('restaurant_id')->nullable()->constrained()->onDelete('set null');
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->dropColumn('role');
            $table->dropColumn('restaurant_id');
        });
    }
};
