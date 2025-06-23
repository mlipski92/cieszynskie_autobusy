<?php

namespace App\Repositories;

use App\Models\Stop;

class StopRepository implements StopRepositoryInterface {
    public function create(array $data) {
        Stop::create($data);
    }
    public function update(array $data, int $id) {
        Stop::findOrFail($id)->update($data);
    }
    public function findById($id) {
        return Stop::findOrFail($id);
    }
    public function getAll() {
        return Stop::all();
    }
    public function delete($id) {
        Stop::findOrFail($id)->delete();
    }
}