<?php

namespace App\Repositories;

use App\Models\LineStopRelation;
use App\Models\Stop;
use Illuminate\Support\Facades\Log;


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
    // public function getFirstLine() {
    //     $linesWithStops = LineStopRelation::whereIn('id_stop', [2, 4])
    //     ->get()
    //     ->groupBy('id_line')
    //     ->filter(function ($group) {
    //         $stops = $group->pluck('id_stop')->unique();
    //         return $stops->contains(2) && $stops->contains(4);
    //     });

    //     $linesWithStops->each(function ($stops, $lineId) {
    //         echo "Linia $lineId:\n";
    //         $stops->each(function ($stop) {
    //             echo "- stop_id: {$stop->id_stop}, order: {$stop->order}, time: {$stop->time}\n";
    //         });
    //         echo "\n";
    //     });
    // }
    public function checkDuplicatedStopInLine($idBegin, $idEnd) {
        return LineStopRelation::whereIn('id_stop', [$idBegin, $idEnd])->pluck('id_line')->duplicates()->first();
    }
    public function getStopLineRelationById($id, $idBegin, $idEnd) {
        $matchingLines = LineStopRelation::whereIn('id_stop', [$idBegin, $idEnd])
        ->leftJoin('stops', 'line_stop_relations.id_stop', '=', 'stops.id')
        ->get()
        ->groupBy('id_line')
        ->filter(function ($group) use ($idBegin, $idEnd) {
            $stopBegin = $group->firstWhere('id_stop', $idBegin);
            $stopEnd = $group->firstWhere('id_stop', $idEnd);
            return $stopBegin && $stopEnd && $stopBegin->order < $stopEnd->order;
        });


    $linesStops = LineStopRelation::where('id_line', $id)
    ->leftJoin('stops', 'line_stop_relations.id_stop', '=', 'stops.id')
    ->orderBy('line_stop_relations.order')
    ->get([
        'line_stop_relations.*',
        'stops.name as stop_name'
    ]);

    return [
    'lineStops' => $linesStops,
    'beginStop' => $matchingLines->first()[0],
    'endStop' => $matchingLines->first()[1]
    ];

    }

}