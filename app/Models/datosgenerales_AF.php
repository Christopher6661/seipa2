<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosgenerales_AF extends Model
{
    use HasFactory;
    protected $table = 'datos_generales_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombres',
        'apellido_pa',
        'apellido_ma',
        'RFC',
        'CURP',
        'telefono',
        'email',
        'domicilio',
        'localidad_id', 
        'municipio_id',
        'distrito_id',
        'region_id',
        'grupo_sanguineo',
        'etnia_id',
        'especies_producen',
        'cuenta_siscaptura',
        'motivo_no_cuenta'
    ];
    public $timestamps = true;

    public function Localidad(){
        return $this->belongsTo(localidad::class, 'localidad_id', 'id');
    }

    public function Municipio(){
        return $this->belongsTo(municipio::class, 'municipio_id', 'id');
    }

    public function Distrito(){
        return $this->belongsTo(distrito::class, 'distrito_id', 'id');
    }

    public function Region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }

    public function Etnia(){
        return $this->belongsTo(etnia::class, 'etnia_id', 'id');
    }
}
