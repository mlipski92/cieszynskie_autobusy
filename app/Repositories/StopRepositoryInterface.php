<?php

namespace App\Repositories;

use App\DTO\LineData;

interface StopRepositoryInterface {
    public function create(LineData $data);
    public function update(LineData $data, int $id);
    public function findById($id);
    public function getAll();
    public function delete($id);
}