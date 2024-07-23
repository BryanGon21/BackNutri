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
        Schema::create('info_alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer('cantidad')->nullable();
            $table->double('calorias')->nullable();
            $table->double('proteinas')->nullable();
            $table->double('carbohidratos')->nullable();
            $table->double('grasas')->nullable();
            $table->boolean('habilitado')->nullable();
            
            $table->unsignedBigInteger('unidad_id');
            $table->foreign('unidad_id')->references('id')
            ->on('unidads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_alimentos');
    }
};
