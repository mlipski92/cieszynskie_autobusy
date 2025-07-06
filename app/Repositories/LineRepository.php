<?php

namespace App\Repositories;

use App\Models\Line;
use App\Models\Trans;

class LineRepository implements StopRepositoryInterface {
    public function create(array $data) {
        return Line::create($data);
    }
    public function update(array $data, int $id) {
        return Line::findOrFail($id)->update($data);
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
}