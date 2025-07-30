<?php

namespace App\DTO;

use Illuminate\Http\Request;

class BuyTicketData {
        public function __construct(
        public readonly string $timeFrom,
        public readonly string $timeTo,
        public readonly string $locationFrom,
        public readonly string $locationTo,
        public readonly float $totalCost,
        public readonly string $lineName,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            timeFrom: $request->query('odjazd'),
            timeTo: $request->query('przyjazd'),
            locationFrom: $request->query('z'),
            locationTo: $request->query('do'),
            totalCost: (float) $request->query('koszt'),
            lineName: $request->query('linia'),
        );
    }

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