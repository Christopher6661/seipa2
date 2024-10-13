<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosgenerales_AM extends Model
{
    use HasFactory;
    protected $table = 'datos_generales_am';
    protected $primaryKey = 'id';
    protected $fillable = [
        'razon_social',
        'RFC',
        'CURP',
        'telefono',
        'domicilio',
        'region_id',
        'distrito_id',
        'muni_id',
        'local_id',        
        'email',
        'especies_producen',
        'etnia_id',
        'socios',
        'cuenta_siscuarente',
        'motivo_no_cuenta'
    ];
    public $timestamps = true;

    public function Region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }

    public function Distrito(){
        return $this->belongsTo(distrito::class, 'distrito_id', 'id');
    }

    public function Municipio(){
        return $this->belongsTo(municipio::class, 'muni_id', 'id');
    }

    public function Localidad(){
        return $this->belongsTo(localidad::class, 'local_id', 'id');
    }

    public function Etnia(){
        return $this->belongsTo(etnia::class, 'etnia_id', 'id');
    }
}
