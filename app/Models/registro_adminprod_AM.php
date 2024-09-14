<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_adminprod_AM extends Model
{
    use HasFactory;
    protected $table = 'registro_adminprod_am';
    protected $primaryKey = 'id';
    protected $fillable = [
        'num_familias',
        'num_mujeres',
        'num_hombres',
        'total_integrantes',
        'tipo_tenencia_ua'
    ];
    public $timestamps = true;
}
