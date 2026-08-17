<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            // Relacionamos el turno con la colaboradora (usuaria)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('titulo'); // Ej: "Turno Mañana", "Día Libre"
            $table->dateTime('inicio');
            $table->dateTime('fin');
            
            // Usamos un string o enum para identificar qué color o trato darle en el frontend
            $table->enum('tipo', ['trabajo', 'libre', 'no_disponible'])->default('trabajo');
            
            $table->text('notas')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};

