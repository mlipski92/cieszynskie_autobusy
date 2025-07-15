<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stop;
use App\Repositories\LineRepository;
use App\Repositories\LineStopRelationRepository;
use App\Repositories\StopRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StopController extends Controller
{
    private $stopRepository;
    private $lineRepository;
    private $lineStopRelationRepository;
    public function __construct(StopRepository $stopRepository, LineRepository $lineRepository, LineStopRelationRepository $lineStopRelationRepository)
    {
        $this->stopRepository = $stopRepository;
        $this->lineRepository = $lineRepository;
        $this->lineStopRelationRepository = $lineStopRelationRepository;
    }
    public function getAllStops(Request $request) {
        return response()->json($this->stopRepository->getAll());
    }

    public function getStopsBySelectedStop($id) {
        $lineIds = $this->lineRepository->getLineIds($id);
        $checkRelations = $this->lineStopRelationRepository->checkRelationsByLineIds($lineIds);
        $getStops = $this->stopRepository->getStopsByIds($checkRelations);
        return $getStops;
    }
}
