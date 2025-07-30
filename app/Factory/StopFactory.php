<?php

namespace App\Factory;

use App\DTO\StopData;


class    StopFactory {
    public function fromArray($name, $positionx, $positiony, $direction):StopData {
        return new StopData(
            name:$name,
            positionx:$positionx,
            positiony:$positiony,
            direction:$direction
        );
    }
}
