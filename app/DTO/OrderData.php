<?php
namespace App\DTO;

class OrderData
{
    public function __construct(
        public readonly string $name,
        public readonly string $line,
        public readonly string $relation,
        public readonly float $cost,
        public readonly string $externalId,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'line' => $this->line,
            'relation' => $this->relation,
            'cost' => $this->cost,
            'externalid' => $this->externalId,
        ];
    }
}
