<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class distrito extends Model
{
    use HasFactory;
    protected $table = 'distritos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_distrito'
    ];
    public $timestamps = true;
}
