<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineStopRelation extends Model
{
    protected $fillable = ['id_stop', 'id_line', 'time', 'order'];
}
