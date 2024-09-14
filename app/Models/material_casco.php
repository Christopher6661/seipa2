<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material_casco extends Model
{
    use HasFactory;
    protected $table = 'material_casco';
    protected $primaryKey = 'id';
    protected $fillable = [
        'material'
    ];
    public $timestamps = true;
}
