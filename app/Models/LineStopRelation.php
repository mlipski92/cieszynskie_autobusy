<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineStopRelation extends Model
{
    protected $fillable = ['id_stop', 'id_line', 'time', 'order'];
    protected $table = 'line_stop_relations';

    public function stop()
    {
        return $this->belongsTo(Stop::class, 'id_stop');
    }
}
