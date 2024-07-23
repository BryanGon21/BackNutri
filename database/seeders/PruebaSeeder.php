<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'desayuno',
            'almuerzo',
            'cena',
        ];
        foreach ($categorias as $value) {
            \App\Models\TipoComida::create([
                'nombre' => $value,
                'habilitado' => true,
            ]);
        }
        // \App\Models\Unidad::create([
        //     'nombre' => 'gramo',
        //     'sigla' => 'g',
        //     'habilitado' => true,
        // ]);
        // \App\Models\Unidad::create([
        //     'nombre' => 'miligramo',
        //     'sigla' => 'mg',
        //     'habilitado' => true,
        // ]);
        // \App\Models\Unidad::create([
        //     'nombre' => 'mililitro',
        //     'sigla' => 'ml',
        //     'habilitado' => true,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Pan blanco',
        //     'cantidad' => 100,
        //     'calorias' => 265,
        //     'proteinas' => 9,
        //     'carbohidratos' => 49,
        //     'grasas' => 3.2,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Arroz cocido',
        //     'cantidad' => 100,
        //     'calorias' => 130,
        //     'proteinas' => 2.7,
        //     'carbohidratos' => 28,
        //     'grasas' => 0.3,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Pollo (pechuga, cocido)',
        //     'cantidad' => 100,
        //     'calorias' => 165,
        //     'proteinas' => 31,
        //     'carbohidratos' => 0,
        //     'grasas' => 3.6,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Manzana',
        //     'cantidad' => 100,
        //     'calorias' => 52,
        //     'proteinas' => 0.3,
        //     'carbohidratos' => 14,
        //     'grasas' => 0.2,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Leche (entera)',
        //     'cantidad' => 100,
        //     'calorias' => 61,
        //     'proteinas' => 3.2,
        //     'carbohidratos' => 4.8,
        //     'grasas' => 3.3,
        //     'habilitado' => true,
        //     'unidad_id' => 3,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Huevo (entero, cocido)',
        //     'cantidad' => 100,
        //     'calorias' => 155,
        //     'proteinas' => 13,
        //     'carbohidratos' => 1.1,
        //     'grasas' => 11,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Zanahoria',
        //     'cantidad' => 100,
        //     'calorias' => 41,
        //     'proteinas' => 0.9,
        //     'carbohidratos' => 10,
        //     'grasas' => 0.2,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Queso cheddar',
        //     'cantidad' => 100,
        //     'calorias' => 402,
        //     'proteinas' => 25,
        //     'carbohidratos' => 1.3,
        //     'grasas' => 33,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
        
        // \App\Models\InfoAlimento::create([
        //     'nombre' => 'Yogur natural',
        //     'cantidad' => 100,
        //     'calorias' => 61,
        //     'proteinas' => 3.5,
        //     'carbohidratos' => 4.7,
        //     'grasas' => 3.3,
        //     'habilitado' => true,
        //     'unidad_id' => 1,
        // ]);
    }
}
