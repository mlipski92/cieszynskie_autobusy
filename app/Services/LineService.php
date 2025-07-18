<?php

namespace App\Services;

use App\Repositories\LineStopRelationRepository;

class LineService {
    protected $lineStopRelationRepository;
    protected $filterLineStopRelationService;
    public function __construct(LineStopRelationRepository $lineStopRelationRepository, FilterLineStopRelationService $filterLineStopRelationService) {
        $this->lineStopRelationRepository = $lineStopRelationRepository;
        $this->filterLineStopRelationService = $filterLineStopRelationService;
    }
    public function getLineDetails($beginId, $endId) {
            $stops = $this->lineStopRelationRepository->getStopsWithIds($beginId, $endId);
            $groups = $stops->groupBy('id_line');
            $results = $this->filterLineStopRelationService->filterLineStopRelations($beginId, $endId, $groups);

            $finalStops = $results[0];

            $finalIdLine = $finalStops[0]['id_line'];
            $finalStart = $finalStops[0];
            $finalEnd =$finalStops[1];
  
            $linesStops = $this->lineStopRelationRepository->getLineStops($finalIdLine);

            return [
                'lineStops' => $linesStops,
                'beginStop' => $finalStart,
                'endStop' => $finalEnd
            ];


    }
}