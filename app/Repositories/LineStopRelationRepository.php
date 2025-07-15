<?php

namespace App\Repositories;

use App\Models\LineStopRelation;
use App\Models\Stop;


class LineStopRelationRepository implements LineStopRelationRepositoryInterface {
    public function updateRelationOrder($stopId, $order) {
        return LineStopRelation::where('id', $stopId)
            ->update(['order' => $order]);
    }
    public function createStopLineRelation($data) {
        return LineStopRelation::create($data);
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
    public function checkDuplicatedStopInLine($idBegin, $idEnd) {
        return LineStopRelation::whereIn('id_stop', [$idBegin, $idEnd])->pluck('id_line')->duplicates()->first();
    }
    public function getStopLineRelationById($id, $idBegin, $idEnd) {
        $linesStops = LineStopRelation::where('id_line', $id)
            ->leftJoin('stops', 'line_stop_relations.id_stop', '=', 'stops.id')
            ->orderBy('line_stop_relations.order')
            ->get([
                'line_stop_relations.*',
                'stops.name as stop_name'
            ]);
        $beginStop = $linesStops->firstWhere('id_stop', $idBegin);
        $endStop = $linesStops->firstWhere('id_stop', $idEnd);
        return [
            'lineStops' => $linesStops,
            'beginStop' => $beginStop,
            'endStop' => $endStop
        ];
    }

}