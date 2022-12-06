<?php

namespace Database\Seeders;

use App\Models\Seccion;
use Illuminate\Database\Seeder;

class SeccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //* Secciones del hogar
        Seccion::create(['ref_seccion' => 'factores_protectores']);
        Seccion::create(['ref_seccion' => 'habitos_consumo']);

        //* secciones del integrante
    }
}
