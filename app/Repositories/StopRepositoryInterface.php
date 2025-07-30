<?php

namespace App\Repositories;

use App\DTO\LineData;
use App\DTO\StopData;

interface StopRepositoryInterface {
    public function create(StopData $data);
    public function update(StopData $data, int $id);
    public function findById($id);
    public function getAll();
    public function delete($id);
}