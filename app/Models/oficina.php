<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class oficina extends Model
{
    use HasFactory;
    protected $table = 'oficinas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_oficina',
        'ubicacion',
        'telefono',
        'email'
    ];
    public $timestamps = true;
}
