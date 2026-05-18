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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dueno_id')->constrained('duenos')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('especie')->nullable();
            $table->string('raza')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_sangre')->nullable();
            $table->string('comportamiento')->nullable();
            $table->boolean('es_adoptado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
