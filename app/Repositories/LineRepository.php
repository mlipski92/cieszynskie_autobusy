<?php

namespace App\Repositories;

use App\DTO\LineData;
use App\Models\Line;
use App\Models\Trans;

class LineRepository implements LineRepositoryInterface {
    public function create(LineData $data) {
        return Line::create($data->toArray());
    }
    public function update(LineData $data, int $id) {
        return Line::findOrFail($id)->update($data->toArray());
    }
    public function findById($id) {
        return Line::findOrFail($id);
    }
    public function getAll() {
        return Line::all();
    }
    public function delete($id) {
        return Line::findOrFail($id)->delete();
    }
    public function getAllTrans() {
        return Trans::all();
    }
    public function getLineIds($id) {
        return Line::whereHas('lineStopRelations', function($query) use ($id) {
            $query->where('id_stop', $id);
        })->pluck('id')->toArray();
    }
    public function getLineInfoById($id, $extended = null) {
        return Line::where('id', $id)->first();
    }


}