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
        // Schema::create('comidas', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('fecha')->nullable();
        //     $table->string('tipo_comida')->nullable();
        //     $table->text('descripcion')->nullable();
        //     // $table->date('fecha_inicio')->nullable();
        //     // $table->date('fecha_fin')->nullable();
        //     $table->double('calorias')->nullable();
        //     $table->double('proteinas')->nullable();
        //     $table->double('carbohidratos')->nullable();
        //     $table->double('grasas')->nullable();
        //     // $table->boolean('habilitado')->nullable();
            
        //     $table->unsignedBigInteger('plan_dieta_id');
        //     $table->foreign('plan_dieta_id')->references('id')
        //     ->on('plan_dietas')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comidas');
    }
};
