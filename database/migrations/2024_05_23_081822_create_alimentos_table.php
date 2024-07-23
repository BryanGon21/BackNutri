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
        // Schema::create('alimentos', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('fecha')->nullable();
        //     $table->string('tipo_comida')->nullable();
        //     $table->text('descripcion')->nullable();
        //     // $table->date('fecha_inicio')->nullable();
        //     // $table->date('fecha_fin')->nullable();
        //     $table->double('cantidad')->nullable();
        //     // $table->boolean('habilitado')->nullable();
            
        //     $table->unsignedBigInteger('comida_id');
        //     $table->foreign('comida_id')->references('id')
        //     ->on('comidas')->onDelete('cascade');
        //     $table->unsignedBigInteger('info_id');
        //     $table->foreign('info_id')->references('id')
        //     ->on('info_alimentos')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
