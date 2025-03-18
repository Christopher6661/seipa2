<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_ubifisica_AF extends Model
{
    use HasFactory;
    protected $table = 'registro_ubfisica_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombres',
        'RNPA',
        'domicilio',
        'codigo_postal',
        'telefono',
        'region_id ',
        'distr_id',
        'muni_id',
        'local_id',
        'inicio_operacion',
        'fin_operacion',
        'coordenadas_map',
        'fuente_agua'
    ];
    public $timestamps = true;

    public function Region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }
    
    public function Distrito(){
        return $this->belongsTo(distrito::class, 'distr_id', 'id');
    }

    public function Municipio(){
        return $this->belongsTo(municipio::class, 'muni_id', 'id');
    }

    public function Localidad(){
        return $this->belongsTo(localidad::class, 'local_id', 'id');
    }
}
