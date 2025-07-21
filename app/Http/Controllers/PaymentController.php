<?php

namespace App\Http\Controllers;

use App\DTO\TransactionData;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Services\TpayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected OrderRepository $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function checkstatus(Request $request)
    {
        // Krok 1: Pobierz payload
        $payload = $request->getContent();
        $signature = $request->header('tpay-signature');

        Log::info('Tpay webhook payload:', [$payload]);

        // Krok 2: Zweryfikuj podpis
        $apiKey = config('app.tpay_api_key') ?? env('TPAY_API_KEY');

        $computedSignature = hash_hmac('sha256', $payload, $apiKey);

        if ($signature !== $computedSignature) {
            Log::warning('Tpay signature mismatch', [
                'expected' => $computedSignature,
                'received' => $signature
            ]);
            return response('Invalid signature', 400);
        }

        // Krok 3: Dekoduj JSON
        $data = json_decode($payload, true);

        // Krok 4: Znajdź zamówienie po 'title' (np. TR-XYZ)
        $title = $data['title'] ?? null;
        if (!$title) {
            return response('Missing title', 400);
        }

        $order = $this->orderRepository->getByTitle($title);

        if (!$order) {
            return response('Order not found', 404);
        }

        // Krok 5: Zaktualizuj status zamówienia
        $status = $data['status'] ?? 'unknown';
        $this->orderRepository->updateOrderStatus($order->id, $status);

        Log::info('Tpay status updated for order', [
            'title' => $title,
            'status' => $status
        ]);

        // Krok 6: Odpowiedź "TRUE"
        return response('TRUE');
    }
}
