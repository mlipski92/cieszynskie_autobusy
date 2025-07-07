<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['name', 'trans', 'direction'];

    public function lineStopRelations()
    {
        return $this->hasMany(LineStopRelation::class, 'id_line');
    }

}


