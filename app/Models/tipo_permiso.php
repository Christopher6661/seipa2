<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_permiso extends Model
{
    use HasFactory;
    protected $table = 'tipo_permisos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_permiso'
    ];
    public $timestamps = true;
}
