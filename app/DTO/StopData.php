<?php

namespace App\DTO;

class StopData {
    public function __construct(
        public string $name,
        public int $positionx,
        public int $positiony,
        public string $direction,
    ) {}

    public function toArray() {
        return [
            'name' => $this->name,
            'positionx' => $this->positionx,
            'positiony' => $this->positiony,
            'direction' => $this->direction,
        ];
    }
}
