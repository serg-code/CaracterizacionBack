<?php

namespace App\Dev\Encuesta;

use App\Dev\Notificacion;
use App\Models\Hogar\Hogar;
use App\Models\Pregunta;
use App\Models\Secciones\Hogar\FactoresProtectores;
use App\Models\Secciones\Hogar\HabitosConsumo;

class SeccionesHogar
{

    public function __construct(
        protected Hogar $hogar,
        protected $secciones = [],
        public int $puntaje = 0,
        protected array $errores = [],
    )
    {
    }

    public function recorrer()
    {
        foreach ($this->secciones as $seccion)
        {
            //agregar id del hogar
            $seccion['respuestas']['hogar_id'] = $this->hogar->id;
            if (!empty($seccion['ref_seccion']) && !empty($seccion['respuestas']))
            {
                $respuesta = $this->seleccionarSeccion(
                    $seccion['ref_seccion'],
                    $seccion['respuestas']
                );

                $this->calcularPuntaje($respuesta);

                $this->guardarRespuesta($respuesta);
            }
        }
    }

    public function seleccionarSeccion(?string $seccion = '', ?array $datosGuardar = [])
    {
        return match ($seccion)
        {
            'habitos_consumo' => new HabitosConsumo($datosGuardar),
            'factores_protectores' => new FactoresProtectores($datosGuardar),
            default => null,
        };
    }

    protected function guardarRespuesta($respuesta)
    {
        $respuesta->eliminar();
        $respuesta->save();
    }

    public function buscarRespuestaOpcion($respuesta, $opcionesPregunta = []): Notificacion
    {
        $estado = new Notificacion();

        if (empty($opcionesPregunta))
        {
            return new Notificacion('encontrado', ['respuesta' => $opcionesPregunta]);
        }

        foreach ($opcionesPregunta as $opcion)
        {
            if ($opcion->valor == $respuesta)
            {
                return new Notificacion(
                    'encontrado',
                    [
                        'puntaje' => $opcion->valor,
                        'respuesta' => $opcion->pregunta_opcion
                    ]
                );
            }
        }

        return $estado;
    }

    protected function calcularPuntaje($respuesta)
    {
        //validar que sea una seccion valida
        if (empty($respuesta))
        {
            return null;
        }

        $respuestasSeccion = $respuesta->attributesToArray();
        unset($respuestasSeccion['hogar_id']);
        foreach ($respuestasSeccion as $clavePregunta => $respuesta)
        {
            $pregunta = Pregunta::ObtenerPregunta($clavePregunta);

            if (empty($pregunta))
            {
                array_push($this->errores, "$pregunta no es una pregunta valida");
                return null;
            }

            $opcionesPregunta = $pregunta->opciones;
            $resultado = $this->buscarRespuestaOpcion($respuesta, $opcionesPregunta);

            if ($resultado->estado === 'error')
            {
                array_push(
                    $this->errores,
                    "$respuesta no es una respuesta valida para $pregunta"
                );
            }

            if ($resultado->estado === 'encontrado')
            {
                $this->puntaje += $resultado->datos['puntaje'] ?? 0;
            }
        }
    }

    public function obtenerPuntaje()
    {
        return $this->puntaje;
    }
}
