<?php

namespace App\DTO;

class StopLineRelationData {
    public function __construct(
        public int $id_stop,
        public int $id_line,
        public int $stopcost,
        public string $time,
        public int $order
    ) {}

    public function toArray() {
        return [
            'id_stop' => $this->id_stop,
            'id_line' => $this->id_line,
            'stopcost' => $this->stopcost,
            'time' => $this->time,
            'order' => $this->order
        ];
    }
}
