<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referrals extends Model
{
    use HasFactory;
    protected $table = 'referrals';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'fecha',
        'nota',
        'forma_pago',
        'almacen',
        'vendedor',
        'cliente',
        'productos',
        'total',
        'estatus',
        'tipo_de_precio',
        'isar',
        'reparto',
        'vendedor_reparto',
    ];
}
