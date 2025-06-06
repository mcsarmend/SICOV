<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idcliente',
        'monto',
        'concepto',
        'fecha_pago',
        'metodo_pago',
        'idusuario',
        'observaciones',
        'mes_correspondiente'
    ];

    protected $guarded = [];
}
