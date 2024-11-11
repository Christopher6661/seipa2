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
        'especies_prod_id',
        'etnia_id',
        'cuenta_siscaptura',
        'motivo_no_cuenta'
    ];
    public $timestamps = true;

    public function localidad(){
        return $this->belongsTo(localidad::class, 'localidad_id', 'id');
    }

    public function municipio(){
        return $this->belongsTo(municipio::class, 'municipio_id', 'id');
    }

    public function distrito(){
        return $this->belongsTo(distrito::class, 'distrito_id', 'id');
    }

    public function region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }

    public function especie_producen(){
        return $this->belongsTo(especie::class, 'especies_prod_id', 'id');
    }

    public function etnia(){
        return $this->belongsTo(etnia::class, 'etnia_id', 'id');
    }
}
