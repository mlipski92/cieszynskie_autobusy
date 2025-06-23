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
    public function update(array $data)
    {
        return Trans::update($data);
    }
    public function findById($id)
    {
        return Trans::findOrFail($id);
    }
}