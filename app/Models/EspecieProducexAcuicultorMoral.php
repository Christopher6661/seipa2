<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecieProducexAcuicultorMoral extends Model
{
    use HasFactory;
    protected $table = 'especieproduce_x_am';
    protected $fillable = [
        'acuicultormoral_id',
        'especie_prod_id'
    ];

    public function datosgeneralesam()
    {
        return $this->belongsTo(datosgenerales_AF::class, 'acuicultormoral_id', 'id');
    }

    public function especieproducen()
    {
        return $this->belongsTo(especie::class, 'especie_prod_id', 'id');
    }
}
