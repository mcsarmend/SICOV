<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
        use HasFactory;
    protected $table = 'address';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'direccion',
        'latitud',
        'longitud',
        'idcliente',
    ];

    protected $guarded = [];
}
