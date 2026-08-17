<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificaciones', function (Blueprint $table) {
            $table->id();
            // Relaciones con tus otras tablas
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            
            // Fechas para el control de vencimiento
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificaciones');
    }
};