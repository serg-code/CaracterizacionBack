<?php

namespace App\Dev\Encuesta;

use App\Dev\Puntaje;
use App\Http\Controllers\Validador\Hogar\ValidarFactoresProtectores;
use App\Http\Controllers\Validador\Hogar\ValidarHabitosConsumo;
use App\Http\Controllers\Validador\Hogar\ValidarVivienda;
use App\Interfaces\ValidacionEncuesta;
use App\Models\Hogar\Hogar;

class SeccionesHogar
{
    public int $puntaje;
    protected array $errores;

    public function __construct(
        protected Hogar $hogar,
        protected $secciones,
    )
    {
        $this->puntaje = 0;
        $this->errores = [];
    }

    public function recorrer()
    {
        foreach ($this->secciones as $seccion)
        {
            $puntajeControl = new Puntaje($seccion['respuestas']);
            $this->puntaje += $puntajeControl->getPuntaje();
            $this->errores = array_merge($this->errores, $puntajeControl->getErrores());

            if (empty($seccion['ref_seccion']) && empty($seccion['respuestas']))
            {
                return null;
            }

            //agregar id del hogar
            $seccion['respuestas']['hogar_id'] = $this->hogar->id;
            $respuesta = Secciones::seleccionarSeccion(
                $seccion['ref_seccion'],
                $seccion['respuestas']
            );

            try
            {

                if (!empty($respuesta))
                {
                    $this->guardarRespuesta($respuesta);
                }
            }
            catch (\Throwable $th)
            {
                dd($th);
            }
        }
    }

    protected function guardarRespuesta($respuesta)
    {
        $respuesta->eliminar();
        $respuesta->save();
    }

    public function obtenerPuntaje()
    {
        return $this->puntaje;
    }

    public function getErrores(): array
    {
        return $this->errores;
    }

    public function obtenerValidador(Hogar $hogar, array $seccion): ?ValidacionEncuesta
    {
        return match ($seccion)
        {
            'factores_protectores' => new ValidarFactoresProtectores($hogar, $seccion),
            'habitos_consumo' => new ValidarHabitosConsumo($hogar, $seccion),
            'vivienda' => new ValidarVivienda($hogar, $seccion),
            'animales' => null,
            'mortalidad' => null,
            'seguridad_alimentaria' => null,
            default => null,
        };
    }

    public static function getPreguntasSeccion(string $seccion): array
    {
        return match ($seccion)
        {
            'factores_protectores' => SeccionesHogar::preguntasFactoresProtectores(),
            'habitos_consumo' => SeccionesHogar::preguntasHabitosConsumo(),
            'vivienda' => SeccionesHogar::preguntasVivienda(),
            'animales' => SeccionesHogar::preguntasAnimales(),
            'mortalidad' => SeccionesHogar::preguntasMortalidad(),
            'seguridad_alimentaria' => SeccionesHogar::preguntasSeguridadAlimentaria(),
            default => [],
        };
    }

    public static function preguntasFactoresProtectores(): array
    {
        return [
            'tipo_familia' => null,
            'duermen_ninos_ninas_adultos' => null,
            'problemas_alcohol' => null,
            'consume_tranquilizantes' => null,
            'relaciones_cordiales_respetuosas' => null,
            'lavar_manos_antes_comer' => null,
            'lavar_manos_antes_preparar_alimentos' => null,
            'fumigar_vivienda' => null,
            'secretaria_fumigado' => null,
            'acido_borico_cucarachas' => null,
        ];
    }

    public static function preguntasHabitosConsumo(): array
    {
        return [
            'consumo_huevos_crudos' => null,
            'alimentos_perecederos' => null,
            'hierve_leche' => null,
            'lavar_frutas_verduras' => null,
            'alimentos_crudos_separados_cocidos' => null,
        ];
    }

    public static function preguntasVivienda(): array
    {
        return [
            'encuesta_sisben' => null,
            'ficha_sisben' => null,
            'puntaje_sisben' => null,
            'nivel_sisben' => null,
            'tipos_vivienda' => null,
            'tipos_tenecia' => null,
            'servicios_sanitarios' => null,
            'tipos_alumbrado' => null,
            'dormitorios' => null,
            'humo_vivienda' => null,
            'fuentes_agua' => null,
            'tratamiento_agua' => null,
            'tipos_tratamiento_agua' => null,
            'tipos_disposicion_basura' => null,
            'reciclan' => null,
            'iluminacion_adecuada' => null,
            'ventilacion_adecuada' => null,
            'roedores' => null,
            'reservorios_agua' => null,
            'anjeos' => null,
            'tipos_insectos_vectores' => null,
            'conservacion_alimentos' => null,
            'actividad_productiva' => null,
            'ciuu' => null,
            'tipos_material_piso' => null,
            'tipos_material_techo' => null,
            'tipos_material_paredes' => null,

        ];
    }

    public static function preguntasAnimales(): array
    {
        return [
            'gatos' => null,
            'gatos_cuantos' => null,
            'gatos_vacunados' => null,
            'perros' => null,
            'perros_cuantos' => null,
            'perros_vacunados' => null,
            'equinos' => null,
            'equinos_cuantos' => null,
            'equinos_vacunados' => null,
            'aves' => null,
            'porcinos' => null,
            'porcinos_cuantos' => null,
            'porcinos_vacunados' => null,
            'animales_no_rabia' => null,
            'animales_si_rabia' => null,
        ];
    }

    public static function preguntasMortalidad(): array
    {
        return [
            'fallecido_familiar' => null,
            'sexo_fallecido' => null,
            'edad_fallecido' => null,
            'causa_muerte' => null,
            'fecha_muerte' => null,
        ];
    }

    public static function preguntasSeguridadAlimentaria(): array
    {
        return [
            'falto_dinero' => null,
            'animales_silvestres' => null,
            'consume_cerdo_res_pollo' => null,
            'consume_huevos' => null,
            'consume_frijol_lentejas' => null,
            'consume_lacteos' => null,
            'consume_harinas' => null,
            'consume_verduras' => null,
            'consume_frutas_frescas' => null,
            'consume_enlatados' => null,
            'consume_platano_yuca' => null,
            'consume_gaseosas' => null,

        ];
    }

    public static function obtenerSecciones(): array
    {
        return [
            'factores_protectores',
            'habitos_consumo',
            'vivienda',
            'animales',
            'mortalidad',
            'seguridad_alimentaria',
        ];
    }
}
