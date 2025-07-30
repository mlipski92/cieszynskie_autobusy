<?php
namespace App\Factory;

use App\DTO\OrderData;
use Illuminate\Http\Request;

class OrderDataFactory
{
    public static function fromRequest(Request $request): OrderData
    {
        return new OrderData(
            name: $request->name,
            line: $request->lineName,
            relation: $request->locationFrom . ' - ' . $request->locationTo,
            cost: (float) $request->totalCost,
            externalId: 'vvv',
        );
    }
}
