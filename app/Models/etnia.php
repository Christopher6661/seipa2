<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etnia extends Model
{
    use HasFactory;
    protected $table = 'etnias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_etnia'
    ];
    public $timestamps = true;
}
