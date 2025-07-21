<?php

namespace App\Repositories;
use App\Models\Order;

class OrderRepository {
    public function getAll() {
        return Order::all();
    }
    public function createOrder(array $data) {
        return Order::create($data);
    }
    public function updateOrderStatus($id, $newStatus) {
        return Order::findOrFail($id)->update(['status' => $newStatus]);
    }
    public function getByTitle(string $externalid)
    {
        return Order::where('externalid', $externalid)->first();
    }

}