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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            // $table->decimal('presion_arterial')->nullable();
            $table->double('glucosa_ayunas')->nullable();
            $table->double('colesterol_total')->nullable();
            $table->double('colesterol_hdl')->nullable();
            $table->double('colesterol_ldl')->nullable();
            $table->double('trigliceridos')->nullable();
            $table->double('hemoglobina')->nullable();
            $table->date('fecha_registro')->nullable();

            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')
            ->on('pacientes')->onDelete('cascade');
            $table->unsignedBigInteger('cita_id');
            $table->foreign('cita_id')->references('id')
            ->on('citas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
