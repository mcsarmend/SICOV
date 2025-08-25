<?php

namespace App\Models;

use Doctrine\DBAL\Event\SchemaAlterTableRemoveColumnEventArgs;
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
        'telefono',
        'gimnasio',
        'alberca',
        'observaciones',
        'paquete_alberca',
        'horario_alberca',
        'tipo',
        'idusuario',
        'fecha_creacion',
        'idseguro'
    ];

    protected $guarded = [];
}
