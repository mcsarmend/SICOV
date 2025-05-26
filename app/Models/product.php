<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'product';

	protected $primary_key = 'id';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'nombre',
		'marca',
		'categoria',
        'price'
	];

	protected $guarded =[];
}
