<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preregistration extends Model
{
    use HasFactory;
    protected $table = 'preregistration';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre',
        'telefono',
        'gimnasio',
        'alberca',
        'observaciones',
        'paquete_alberca',
        'horario_alberca',
        'idusuario',
    ];

    protected $guarded = [];
}
