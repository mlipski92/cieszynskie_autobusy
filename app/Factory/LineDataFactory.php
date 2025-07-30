<?php

namespace App\Factory;

use App\DTO\LineData;

class LineDataFactory {
    public function fromArray(string $name, string $trans, string $direction): LineData {
        return new LineData(
            name: $name,
            trans: $trans,
            direction: $direction
        );
    }
}