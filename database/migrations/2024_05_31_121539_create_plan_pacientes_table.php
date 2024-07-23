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
        Schema::create('plan_pacientes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('edad')->nullable();
            $table->decimal('peso')->nullable();
            $table->decimal('altura')->nullable();
            $table->text('nivel_actividad')->nullable();
            $table->decimal('circunferencia_cintura')->nullable();
            $table->decimal('circunferencia_caderas')->nullable();
            $table->double('glucosa_ayunas')->nullable();
            $table->double('colesterol_total')->nullable();
            $table->double('colesterol_hdl')->nullable();
            $table->double('colesterol_ldl')->nullable();
            $table->double('trigliceridos')->nullable();
            $table->double('hemoglobina')->nullable();
            $table->integer('dias')->nullable();
            // $table->double('calorias')->nullable();
            // $table->double('proteinas')->nullable();
            // $table->double('carbohidratos')->nullable();
            // $table->double('grasas')->nullable();
            // $table->boolean('habilitado')->nullable();
            
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')
            ->on('pacientes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_pacientes');
    }
};
