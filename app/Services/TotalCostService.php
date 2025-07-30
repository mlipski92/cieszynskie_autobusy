<?php

namespace App\Services;

class TotalCostService {
    public function calculateTotalCost($lineDetails) {
        $totalStopCost = 0;
        foreach($lineDetails['lineStops'] as $lineStop) {
            if (
                $lineStop->order >= $lineDetails['beginStop']->order &&
                $lineStop->order <= $lineDetails['endStop']->order
            ) {
                $totalStopCost += $lineStop->stopcost;
            }
        }

        return $totalStopCost;
    }
}