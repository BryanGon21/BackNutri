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
        Schema::create('informacions', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->decimal('peso')->nullable();
            $table->decimal('altura')->nullable();
            $table->decimal('imc')->nullable();
            $table->text('nivel_actividad')->nullable();
            $table->decimal('circunferencia_cintura')->nullable();
            $table->decimal('circunferencia_caderas')->nullable();
            $table->decimal('presion_arterial')->nullable();
            $table->text('alergias_alimentarias')->nullable();
            $table->text('restricciones_dietéticas')->nullable();
            $table->text('preferencias_alimenticias')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->text('observacion')->nullable();

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
        Schema::dropIfExists('informacions');
    }
};
