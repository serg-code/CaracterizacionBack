<?php

namespace App\Models\Secciones\Integrantes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesSaludPublica extends Model
{
    use HasFactory;
    protected $table = 'enfermedades_salud_publica';

    protected $fillable = [
        'id_integrante',
        'tuberculosis',
        'lepra',
        'chagas',
        'sifilis',
        'dengue',
        'malaria',
        'leishmaniasis',
        'brucelosis',
        'sika_chicungunya',
        'varicela',
        'intoxicacion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'ref_campo');
    }

    public static function guardarsalud_publica(array $datossalud_publica)
    {
        $pregunta = new EnfermedadesSaludPublica($datossalud_publica);
        $pregunta->save();
    }

    public function eliminar()
    {
        EnfermedadesSaludPublica::where('id_integrante', '=', $this->id_integrante)->delete();
    }
}
