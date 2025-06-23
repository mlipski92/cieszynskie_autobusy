<?php

namespace App\Repositories;

interface StopRepositoryInterface {
    public function create(array $data);
    public function update(array $data, int $id);
    public function findById($id);
    public function getAll();
    public function delete($id);
}