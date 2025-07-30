<?php

namespace App\Factory;

use App\DTO\TicketPreviewData;
use App\Repositories\LineStopRelationRepository;

class TicketPreviewDataFactory
{
    public function __construct(
        protected LineStopRelationRepository $lineStopRelationRepository
    ) {}

    public function fromLineDetails(array $lineDetails, float $totalStopCost): TicketPreviewData
    {
        return new TicketPreviewData(
            timeFrom: $lineDetails['beginStop']->time,
            timeTo: $lineDetails['endStop']->time,
            locationFrom: $this->lineStopRelationRepository->getStopName($lineDetails['beginStop']['id_stop']),
            locationTo: $this->lineStopRelationRepository->getStopName($lineDetails['endStop']['id_stop']),
            totalCost: $totalStopCost,
            lineName: $this->lineStopRelationRepository->getLineName($lineDetails['beginStop']['id_line']),
        );
    }
}
