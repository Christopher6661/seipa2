<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arte_pesca extends Model
{
    use HasFactory;
    protected $table = 'arte_pesca';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_artpesca'
    ];
    public $timestamps = true;
}
