<?php

namespace App\Factory;

use App\DTO\StopLineRelationData;

class LineStopRelationFactory {
    public function fromArray($id_stop, $id_line, $time, $stopcost, $order) : StopLineRelationData {
        return new StopLineRelationData(
            id_stop: $id_stop,
            id_line: $id_line,
            time: $time,
            stopcost: $stopcost,
            order: $order
        );
    }
}