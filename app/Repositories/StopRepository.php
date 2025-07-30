<?php

namespace App\Repositories;

use App\DTO\LineData;
use App\Models\Stop;

class StopRepository implements StopRepositoryInterface {
    public function create(LineData $data) {
        return Stop::create($data);
    }
    public function update(LineData $data, int $id) {
        return Stop::findOrFail($id)->update($data);
    }
    public function findById($id) {
        return Stop::findOrFail($id);
    }
    public function getAll() {
        return Stop::all();
    }
    public function delete($id) {
        return Stop::findOrFail($id)->delete();
    }
    public function getStopsByIds($ids) {
        return Stop::whereIn('id', $ids)->get();
    }

}