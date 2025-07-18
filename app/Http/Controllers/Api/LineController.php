<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\LineRepository;
use App\Repositories\LineStopRelationRepository;
use App\Services\CalculateTotalCost;
use App\Services\LineService;
use App\Services\TotalCostService;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    protected $lineRepository;
    protected $lineStopRelationRepository;
    protected $totalCostService;
    protected $lineService;
    public function __construct(LineRepository $lineRepository, LineStopRelationRepository $lineStopRelationRepository, TotalCostService $totalCostService, LineService $lineService) {
        
        $this->lineRepository = $lineRepository;
        $this->lineStopRelationRepository = $lineStopRelationRepository;
        $this->totalCostService = $totalCostService;
        $this->lineService = $lineService;
    }

    public function getLineDetails($idBegin, $idEnd) {
        $lineDetails = $this->lineService->getLineDetails($idBegin, $idEnd);
        $totalStopCost = $this->totalCostService->calculateTotalCost($lineDetails);



        if ($totalStopCost === 0 || $totalStopCost === "0") {
            return [];
        }

        return [
            'timeFrom' => $lineDetails['beginStop']->time,
            'timeTo' => $lineDetails['endStop']->time,
            'locationFrom' => $this->lineStopRelationRepository->getStopName($lineDetails['beginStop']['id_stop']),
            'locationTo' => $this->lineStopRelationRepository->getStopName($lineDetails['endStop']['id_stop']),
            'totalCost' => $totalStopCost,
            'lineName' => $this->lineStopRelationRepository->getLineName($lineDetails['beginStop']['id_line'])
        ];

    }

}
