<?php

namespace App\Factory;

use App\DTO\TransactionData;
use Illuminate\Http\Request;

class TransactionDataFactory
{
    public static function fromRequest(Request $request): TransactionData
    {
        return new TransactionData(
            amount: $request->totalCost,
            description: 'Relacja '.$request->locationFrom.' - '.$request->locationTo,
            groupId: 150,
            payerName: $request->name,
            payerEmail: $request->email,
            successUrl: config('app.url') . '/success',
            errorUrl: config('app.url') . '/error',
            notificationUrl: config('app.url') . 'order/checkstatus',
        );
    }
}
