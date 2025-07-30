<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class CheckStatusService {
    protected $request;
    protected $orderRepository;

    public function __construct(Request $request, OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
        $this->request = $request;
    }

    public function checkStatus() {
        $payload = $this->request->getContent();
        $signature = $this->request->header('tpay-signature');
        $apiKey = config('app.tpay_api_key') ?? env('TPAY_API_KEY');

        $computedSignature = hash_hmac('sha256', $payload, $apiKey);

        if ($signature !== $computedSignature) {
            return response('Invalid signature', 400);
        }

        $data = json_decode($payload, true);

        $title = $data['title'] ?? null;
        if (!$title) {
            return response('Missing title', 400);
        }

        $order = $this->orderRepository->getByTitle($title);

        if (!$order) {
            return response('Order not found', 404);
        }

        $status = $data['status'] ?? 'unknown';
        $this->orderRepository->updateOrderStatus($order->id, $status);


        return response('TRUE');
    }
}