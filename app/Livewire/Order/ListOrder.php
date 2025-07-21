<?php

namespace App\Livewire\Order;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ListOrder extends Component
{
    public function boot(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }
    public function render()
    {
        $orders = $this->orderRepository->getAll();
        return view('livewire.order.list-order', ['orderList' => $orders]);
    }

    public function checkstatus() {
        Log::info(1231231);
    }
}
