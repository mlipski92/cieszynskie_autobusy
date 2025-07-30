<?php

namespace App\Repositories;
use App\DTO\OrderData;
use App\Models\Order;

class OrderRepository {
    public function getAll() {
        return Order::all();
    }
    public function createOrder(OrderData $data) {
        return Order::create($data->toArray());
    }
    public function updateOrderStatus($id, $newStatus) {
        return Order::findOrFail($id)->update(['status' => $newStatus]);
    }
    public function getByTitle(string $externalid)
    {
        return Order::where('externalid', $externalid)->first();
    }

}