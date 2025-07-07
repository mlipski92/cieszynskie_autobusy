<?php

use App\Models\Line;
use App\Models\LineStopRelation;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('stops', function (Request $request) {
    return response()->json(Stop::all());
});

Route::get('/stopsbyselectedstop/{id}', function (Request $request, $id) {
    $lineIds = Line::whereHas('lineStopRelations', function($query) use ($id) {
        $query->where('id_stop', $id);
    })->pluck('id')->toArray();
    $checkRelations = LineStopRelation::whereIn('id_line', $lineIds)->get();
    $stopIds = $checkRelations->pluck('id_stop')->unique()->toArray();
    $getStops = Stop::whereIn('id', $stopIds)->get();
    return $getStops;
});

Route::get('/getline/{idbegin}/{idend}', function (Request $request, $idbegin, $idend) {
    $getLine = LineStopRelation::whereIn('id_stop', [$idbegin, $idend])->get();
    $lineIds = $getLine->pluck('id_line');
    $sameLine = $lineIds->duplicates();
    $getMainLine = Line::where('id', $sameLine->first())->get();


    $linesStops = LineStopRelation::where('id_line', $sameLine->first())
        ->leftJoin('stops', 'line_stop_relations.id_stop', '=', 'stops.id')
        ->orderBy('line_stop_relations.order')
        ->get([
            'line_stop_relations.*',
            'stops.name as stop_name'
        ]);
    $beginStop = $linesStops->firstWhere('id_stop', $idbegin);
    $endStop = $linesStops->firstWhere('id_stop', $idend);
    $totalStopCost = 0;
 
    
    foreach($linesStops as $lineStop) {
        if ($lineStop->order >= $beginStop->order && $lineStop->order <= $endStop->order) {
            $totalStopCost += $lineStop->stopcost;
        }
    } 

    return [
        'timeFrom' => $beginStop->time,
        'timeTo' => $endStop->time,
        'locationFrom' => $beginStop->stop_name,
        'locationTo' => $endStop->stop_name,
        'totalCost' => $totalStopCost,
        'lineName' => $getMainLine->first()->name
    ];
});