<?php

namespace App\DTO;

class TicketPreviewData
{
    public function __construct(
        public readonly string $timeFrom,
        public readonly string $timeTo,
        public readonly string $locationFrom,
        public readonly string $locationTo,
        public readonly float $totalCost,
        public readonly string $lineName,
    ) {}

    public function toArray(): array
    {
        return [
            'timeFrom' => $this->timeFrom,
            'timeTo' => $this->timeTo,
            'locationFrom' => $this->locationFrom,
            'locationTo' => $this->locationTo,
            'totalCost' => $this->totalCost,
            'lineName' => $this->lineName,
        ];
    }
}
