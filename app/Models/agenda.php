<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agenda extends Model
{
    use HasFactory;
    protected $table = 'agenda_clientes';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_cliente',
        'horario',
        'paquete',
        'sesiones_totales',
        'sesiones_usadas',
        'fecha_inicio',
        'fecha_fin',
        'fecha_sesion',
        'estatus'
    ];

    protected $guarded = [];
}
