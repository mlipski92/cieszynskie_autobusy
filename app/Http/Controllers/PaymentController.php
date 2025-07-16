<?php

namespace App\Http\Controllers;

use App\DTO\TransactionData;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createTransaction(TpayService $tpayService): RedirectResponse|string
    {
        $transactionData = new TransactionData(
            amount: 0.1,
            description: 'Test transaction',
            groupId: 150,
            payerName: 'Jan Nowak',
            payerEmail: 'jan.nowak@example.com',
            successUrl: 'https://zenitx.pl',
            errorUrl: 'https://zenitx.pl',
            notificationUrl: 'https://zenitx.pl',
        );
        $paymentUrl = $tpayService->createTransaction($transactionData->toArray());

        if (!$paymentUrl) {
            return 'Błąd podczas tworzenia transakcji.';
        }
        return redirect()->away($paymentUrl);
    }
}
