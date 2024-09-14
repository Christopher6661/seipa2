<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class municipio extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_municipio'
    ];
    public $timestamps = true;
}
