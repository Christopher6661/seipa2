<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecieProducexAcuicultorFisico extends Model
{
    use HasFactory;
    protected $table = 'especieproduce_x_af';
    protected $fillable = [
        'acuicultorfisico_id',
        'especie_prod_id'
    ];

    public function datosgeneralesaf()
    {
        return $this->belongsTo(datosgenerales_AF::class, 'acuicultorfisico_id', 'id');
    }

    public function especieproducen()
    {
        return $this->belongsTo(especie::class, 'especie_prod_id', 'id');
    }
}
