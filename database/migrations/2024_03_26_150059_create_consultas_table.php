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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->string('motivo')->nullable();
            $table->text('expectativas')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('observacion')->nullable();
            $table->boolean('activo');
            
            $table->bigInteger('cita_id')->unsigned();
            $table->foreign('cita_id')->references('id')
            ->on('citas')->onDelete('cascade');
            $table->bigInteger('paciente_id')->unsigned();
            $table->foreign('paciente_id')->references('id')
            ->on('pacientes')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        // Schema::create('datos', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('fecha');
        //     $table->double('tamanio',10,2)->nullable();
        //     $table->double('peso',10,2)->nullable();
            
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
