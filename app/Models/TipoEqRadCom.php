<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEqRadCom extends Model
{
    use HasFactory;
    protected $table = 'tipo_equipo_radcom';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_radiocom'
    ];
    public $timestamps = true;
}
