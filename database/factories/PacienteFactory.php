<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres' => fake()->name(),
            'apellidos' => fake()->lastname(),
            'fecha_nacimiento' => fake()->date(),
            'celular' => rand(1000000000, 9999999999),
            'direccion' => 'Bolivia',
            'email' => fake()->unique()->safeEmail(),
            'genero' => 'Masculino',
        ];
    }
}
