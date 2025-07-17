<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\LineRepository;
use App\Repositories\LineStopRelationRepository;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    protected $lineRepository;
    protected $lineStopRelationRepository;
    public function __construct(LineRepository $lineRepository, LineStopRelationRepository $lineStopRelationRepository) {
        
        $this->lineRepository = $lineRepository;
        $this->lineStopRelationRepository = $lineStopRelationRepository;
    }

    public function getLineDetails($idBegin, $idEnd) {
        $getLinesIdWithoutDuplication = $this->lineStopRelationRepository->checkDuplicatedStopInLine($idBegin, $idEnd);
        $getLineInfoById = $this->lineRepository->getLineInfoById($getLinesIdWithoutDuplication);
        $getLineStops = $this->lineStopRelationRepository->getStopLineRelationById($getLinesIdWithoutDuplication, $idBegin, $idEnd);
        $totalStopCost = 0;

        foreach($getLineStops['lineStops'] as $lineStop) {
            if (
                $lineStop->order >= $getLineStops['beginStop']->order &&
                $lineStop->order <= $getLineStops['endStop']->order
            ) {
                $totalStopCost += $lineStop->stopcost;
            }
        }

        if ($totalStopCost === 0 || $totalStopCost === "0") {
            return [];
        }

        // Log::info();

        return [
            'timeFrom' => $getLineStops['beginStop']->time,
            'timeTo' => $getLineStops['endStop']->time,
            'locationFrom' => $getLineStops['beginStop']->name,
            'locationTo' => $getLineStops['endStop']->name,
            'totalCost' => $totalStopCost,
            'lineName' => $getLineInfoById->name
        ];

    }

}
