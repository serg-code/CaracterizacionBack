<?php

namespace Database\Seeders\Preguntas;

use App\Models\Pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaludMentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pregunta::create(["ref_campo" => "depresion", "ref_seccion" => "salud_mental", "descripcion" => "Intento de suicidio", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "intento_suicidio", "ref_seccion" => "salud_mental", "descripcion" => "Intento de suicidio", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "trastorno_afectivo", "ref_seccion" => "salud_mental", "descripcion" => "Trastorno afectivo", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "esquizofrenia", "ref_seccion" => "salud_mental", "descripcion" => "Esquizofrenia", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "bulimia", "ref_seccion" => "salud_mental", "descripcion" => "Bulímia", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "anorexia", "ref_seccion" => "salud_mental", "descripcion" => "Anorexía", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "tratamiento", "ref_seccion" => "salud_mental", "descripcion" => "¿Esta en tratamiento?", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "diagnostico", "ref_seccion" => "salud_mental", "descripcion" => "Diagnóstico de salud mental", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_fisica", "ref_seccion" => "salud_mental", "descripcion" => "Violencia física", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_psicologica", "ref_seccion" => "salud_mental", "descripcion" => "Violencia Psicologíca", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_sexual", "ref_seccion" => "salud_mental", "descripcion" => "Violencia sexual", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_institucional", "ref_seccion" => "salud_mental", "descripcion" => "Violencia institucional", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_social", "ref_seccion" => "salud_mental", "descripcion" => "Violencia social", "tipo" => "seleccion"]);
        Pregunta::create(["ref_campo" => "violencia_gestacion", "ref_seccion" => "salud_mental", "descripcion" => "Violencia en la gestacion", "tipo" => "seleccion"]);
    }
}
