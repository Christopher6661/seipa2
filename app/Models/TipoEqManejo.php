<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEqManejo extends Model
{
    use HasFactory;
    protected $table = 'tipo_equipo_manejo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_eqmanejo'
    ];
    public $timestamps = true;
}
