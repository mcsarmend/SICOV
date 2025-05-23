<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    use HasFactory;
    protected $table = 'clients';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre',
        'sucursal',
        'telefono',
        'precio',
        'sucursal'
    ];

    protected $guarded = [];
}
