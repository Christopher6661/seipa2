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
        'oficregis_id',
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
        'especies_prod_id',
        'etnia_id',
        'socios',
        'cuenta_siscuarente',
        'motivo_no_cuenta'
    ];
    public $timestamps = true;

    public function Oficina(){
        return $this->belongsTo(oficina::class, 'oficregis_id', 'id');
    }

    public function region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }

    public function distrito(){
        return $this->belongsTo(distrito::class, 'distrito_id', 'id');
    }

    public function municipio(){
        return $this->belongsTo(municipio::class, 'muni_id', 'id');
    }

    public function localidad(){
        return $this->belongsTo(localidad::class, 'local_id', 'id');
    }

    public function especie_producen(){
        return $this->belongsToMany(especie::class, 'especies_prod_id', 'id');
    }

    public function especies(){
        return $this->belongsToMany(especie::class, 'especieproduce_x_am', 'acuicultormoral_id', 'especie_prod_id');
    }

    public function etnia(){
        return $this->belongsTo(etnia::class, 'etnia_id', 'id');
    }
}
