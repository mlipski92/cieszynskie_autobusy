<?php

namespace App\Repositories;

use App\Models\Trans;
use App\Repositories\TransRepositoryInterface;

class TransRepository implements TransRepositoryInterface
{
    public function create(array $data)
    {
        return Trans::create($data);
    }
    public function update(array $data, int $id)
    {
        return Trans::findOrFail($id)->update($data);
    }
    public function findById($id)
    {
        return Trans::findOrFail($id);
    }
    public function getAll() {
        return Trans::all();
    }
    public function delete($id) {
        return Trans::findOrFail($id)->delete();
    }
}