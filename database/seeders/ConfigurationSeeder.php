<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create([
            'name' => 'administrador',
            'display_name' => 'administrador',
        ]);
        \App\Models\Role::create([
            'name' => 'medico',
            'display_name' => 'medico',
        ]);
        \App\Models\Role::create([
            'name' => 'paciente',
            'display_name' => 'paciente',
        ]);

        $faker = Faker::create();
        $nombre = $faker->name();
        $apellido = $faker->lastname();
        // $nombre = 'Mauricio';
        // $apellido = 'Roldan Herbas';


        \App\Models\User::factory()->create([
            'nombres' => $nombre,
            'apellidos' => $apellido,
            'nombre_completo' => $nombre . ' ' . $apellido,
            'username' => 'admin',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'habilitado' => true,
            'password' => bcrypt('admin23V'), // password
            'rol_id' => 1,
        ]);
    }
}
