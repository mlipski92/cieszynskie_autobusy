<?php

namespace App\Http\Controllers;

use App\DTO\TransactionData;
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
        return view('buyticket', [
            'timeFrom' => $request->query('odjazd'),
            'timeTo' => $request->query('przyjazd'),
            'locationFrom' => $request->query('z'),
            'locationTo' => $request->query('do'),
            'totalCost' => $request->query('koszt'),
            'lineName' => $request->query('linia'),
        ]);
    }
    public function successPage() {
        return view('success');
    }
    public function checkout(TpayService $tpayService, Request $request): RedirectResponse|string
    {
        $transactionData = new TransactionData(
            amount: $request->totalCost,
            description: 'Relacja '.$request->locationFrom.' - '.$request->locationTo,
            groupId: 150,
            payerName: $request->name,
            payerEmail: $request->email,
            successUrl: config('app.url').'/success',
            errorUrl: config('app.url').'/error',
            notificationUrl: config('app.url').'/checkstatus',
        );
        $paymentUrl = $tpayService->createTransaction($transactionData->toArray());

        if (!$paymentUrl) {
            return 'Błąd podczas tworzenia transakcji.';
        }

        $this->orderRepository->createOrder([
            "name" => $request->name,
            "line" => $request->lineName,
            "relation" => $request->locationFrom.' - '.$request->locationTo,
            "cost" => $request->totalCost,
            "externalid" => 'vvv'
        ]);

        return redirect()->away($paymentUrl['transactionPaymentUrl']);
    }
}