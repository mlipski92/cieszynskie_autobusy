<?php

namespace App\Repositories;

interface LineStopRelationRepositoryInterface {
    public function updateRelationOrder($stopId, $order);
    public function createStopLineRelation($data);
    public function removeStopLineRelation($stopId, $lineId);
    public function getAssignedStops($lineId);
    public function getAvailableStopList($usersValue, $assignedStops);
    public function getStopRelations(int $lineId);
}