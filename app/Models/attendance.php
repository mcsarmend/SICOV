<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
   use HasFactory;
    protected $table = 'attendance';

    protected $primary_key = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'check_in',
        'check_out',
        'package_type',
        'classes_remaining',
    ];

    protected $guarded = [];
}
