<?php

namespace App\Repositories;
use App\Models\Order;

class OrderRepository {
    public function getAll() {
        return Order::all();
    }
}