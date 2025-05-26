<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productwarehouse extends Model
{
    use HasFactory;
    protected $table = 'product_warehouse';

	public $timestamps = false;

	protected $fillable = [
		'idproducto	',
		'idwarehouse',
		'existencias',
	];

	protected $guarded =[];
}
