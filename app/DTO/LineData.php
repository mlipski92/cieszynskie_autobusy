<?php

namespace App\DTO;

class LineData {

    public function __construct(
        public string $name,
        public string $trans,
        public string $direction
    ) {}

    public function toArray(): array{
        return [
            'name' => $this->name,
            'trans' => $this->trans,
            'direction' => $this->direction
        ];
    }
}