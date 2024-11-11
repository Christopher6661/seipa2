<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class especie extends Model
{
    use HasFactory;
    protected $table = 'especies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_especie'
    ];
    public $timestamps = true;
}
