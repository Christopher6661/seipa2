<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEqSeg extends Model
{
    use HasFactory;
    protected $table = 'tipo_equipo_seg';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_eqseguridad'
    ];
    public $timestamps = true;
}
