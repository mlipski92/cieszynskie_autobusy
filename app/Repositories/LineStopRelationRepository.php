<?php

namespace App\Repositories;

use App\Models\Line;
use App\Models\LineStopRelation;
use App\Models\Stop;
use App\Services\FilterLineStopRelationService;

class LineStopRelationRepository implements LineStopRelationRepositoryInterface {
    private $filterLineStopRelationService;
    public function __construct(FilterLineStopRelationService $filterLineStopRelationService) {
        $this->filterLineStopRelationService = $filterLineStopRelationService;
    }
    public function updateRelationOrder($stopId, $order) {
        return LineStopRelation::where('id', $stopId)
            ->update(['order' => $order]);
    }
    public function createStopLineRelation($data) {
        return LineStopRelation::create($data->toArray());
    }
    public function removeStopLineRelation($stopId, $lineId) {
        return LineStopRelation::where('id_line', $lineId)
            ->where('id_stop', $stopId)
            ->delete();
    }
    public function getAssignedStops($lineId) {
        return LineStopRelation::where('id_line', $lineId)
            ->pluck('id_stop')
            ->toArray();
    }
    public function getAvailableStopList($usersValue, $assignedStops) {
        return Stop::where('name', 'like', '%' . $usersValue . '%')
            ->whereNotIn('id', $assignedStops)
            ->orderBy('name')
            ->limit(10)
            ->get();
    }
    public function getStopRelations(int $lineId) {
        return LineStopRelation::with('stop')
            ->where('id_line', $lineId)
            ->orderBy('order')
            ->get();
    }
    public function checkRelationsByLineIds($ids) {
        return LineStopRelation::whereIn('id_line', $ids)->pluck('id_stop')->unique()->toArray();
    }

    public function getLineStops($lineId) {
        return LineStopRelation::where('id_line', $lineId)
            ->leftJoin('stops', 'line_stop_relations.id_stop', '=', 'stops.id')
            ->orderBy('line_stop_relations.order')
            ->get([
                'line_stop_relations.*',
                'stops.name as stop_name'
            ]);
    }

    public function getStopName($id) {
        return Stop::where('id', $id)->first()->name;
    }

    public function getLineName($id) {
        return Line::where('id', $id)->first()->name;
    }

    public function getStopsWithIds($beginId, $endId) {
        return LineStopRelation::whereIn('id_stop', [$beginId, $endId])->get();
    }

}