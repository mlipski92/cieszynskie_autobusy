<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    protected $fillable = ['name', 'positionx', 'positiony', 'direction'];
}
