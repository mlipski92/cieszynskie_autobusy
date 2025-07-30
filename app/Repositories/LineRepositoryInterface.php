<?php

namespace App\Repositories;

use App\DTO\LineData;

interface LineRepositoryInterface {
    public function create(LineData $data);
    public function update(LineData $data, int $id);
    public function findById($id);
    public function getAll();
    public function delete($id);
}