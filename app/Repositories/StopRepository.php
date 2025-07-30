<?php

namespace App\Repositories;

use App\DTO\StopData;
use App\Models\Stop;

class StopRepository implements StopRepositoryInterface {
    public function create(StopData $data) {
        return Stop::create($data->toArray());
    }
    public function update(StopData $data, int $id) {
        return Stop::findOrFail($id)->update($data->toArray());
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