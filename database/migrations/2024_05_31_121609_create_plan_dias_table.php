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
        Schema::create('plan_dias', function (Blueprint $table) {
            $table->id();
            $table->string('dia')->nullable();
            $table->double('calorias_totales')->nullable();
            $table->double('carbohidratos_totales')->nullable();
            $table->double('grasas_totales')->nullable();
            
            $table->unsignedBigInteger('plan_paciente_id');
            $table->foreign('plan_paciente_id')->references('id')
            ->on('plan_pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_dias');
    }
};
