<?php

namespace App\Http\Controllers;

use App\DTO\BuyTicketData;
use App\Factory\OrderDataFactory;
use App\Factory\TransactionDataFactory;
use App\Http\Controllers\Controller;
use App\Services\TpayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;

class FrontController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }
    public function buyTicket(Request $request) {
        $ticketData = BuyTicketData::fromRequest($request);
        return view('buyticket', $ticketData->toArray());
    }
    public function successPage() {
        return view('success');
    }
    public function checkout(TpayService $tpayService, Request $request): RedirectResponse|string
    {
        $transactionData = TransactionDataFactory::fromRequest($request);
        $paymentUrl = $tpayService->createTransaction($transactionData->toArray());

        if (!$paymentUrl) {
            return 'Błąd podczas tworzenia transakcji.';
        }

        $orderData = OrderDataFactory::fromRequest($request);
        $this->orderRepository->createOrder($orderData);

        return redirect()->away($paymentUrl['transactionPaymentUrl']);
    }
    
}