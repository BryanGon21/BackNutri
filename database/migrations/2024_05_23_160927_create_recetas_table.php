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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->double('calorias')->nullable();
            $table->double('proteinas')->nullable();
            $table->double('carbohidratos')->nullable();
            $table->double('grasas')->nullable();
            $table->string('ingredientes')->nullable();
            $table->string('instrucciones')->nullable();
            $table->boolean('habilitado')->nullable();
            
            $table->unsignedBigInteger('tipo_comida_id');
            $table->foreign('tipo_comida_id')->references('id')
            ->on('tipo_comidas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
