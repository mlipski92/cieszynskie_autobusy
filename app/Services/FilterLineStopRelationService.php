<?php

namespace App\Services;

class FilterLineStopRelationService {
    public function filterLineStopRelations($beginId, $endId, $groups) {
        return $groups->filter(function ($items) use ($beginId, $endId) {
            if ($items->count() !== 2) {
                return false; 
            }
            $begin = $items->firstWhere('id_stop', $beginId);
            $end = $items->firstWhere('id_stop', $endId);
            if (!$begin || !$end) {
                return false; 
            }
            return $begin->order < $end->order;
        })->values();
    }
}