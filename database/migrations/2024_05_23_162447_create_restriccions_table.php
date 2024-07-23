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
        Schema::create('restriccions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();

            $table->unsignedBigInteger('receta_id');
            $table->foreign('receta_id')->references('id')
            ->on('recetas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restriccions');
    }
};
