<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_cubierta extends Model
{
    use HasFactory;
    protected $table = 'tipo_cubierta';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_cubierta'
    ];
    public $timestamps = true;
}
