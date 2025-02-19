<?php

namespace App\Models;

use App\Models\Hogar\Hogar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'codigo_dane';
    protected $keyType = 'string';

    protected $fillable = [
        'codigo_dane',
        'nombre',
        'cod_dpto',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function GuardarMunicipio(array $municipioDatos = [])
    {
        $municipio = new Municipio($municipioDatos);
        $municipio->save();
    }

    //relacion de n:1
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'cod_dpto');
    }

    public function BarrioVereda()
    {
        return $this->hasMany(BarrioVereda::class, 'id_municipio');
    }

    public function hogares()
    {
        return $this->hasMany(Hogar::class, 'cod_mun');
    }
}
