<?php

namespace App\Models\Secciones\Hogar;

use App\Models\Hogar\Hogar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoresProtectores extends Model
{
    use HasFactory;

    protected $table = 'factores_protectores';

    protected $fillable = [
        'hogar_id',
        'tipo_familia',
        'duermen_ninos_ninas_adultos',
        'problemas_alcohol',
        'consume_tranquilizantes',
        'relaciones_cordiales_respetuosas',
        'lavar_manos_antes_comer',
        'lavar_manos_antes_preparar_alimentos',
        'fumigar_vivienda',
        'secretaria_fumigado',
        'acido_borico_cucarachas',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function hogar()
    {
        return $this->belongsTo(Hogar::class, 'hogar_id');
    }

    public function eliminar()
    {
        FactoresProtectores::where('hogar_id', '=', $this->hogar_id)->delete();
    }
}
