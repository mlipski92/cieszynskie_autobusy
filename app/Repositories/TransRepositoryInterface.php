<?php

namespace App\Repositories;

interface TransRepositoryInterface
{
    public function create(array $data);
    public function update(array $data);
    public function findById($id);
    public function getAll();
    public function delete($id);
}
