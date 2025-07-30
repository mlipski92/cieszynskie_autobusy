<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CheckStatusService;

class PaymentController extends Controller
{
    protected CheckStatusService $checkStatusService;
    public function __construct(CheckStatusService $checkStatusService)
    {
        $this->checkStatusService = $checkStatusService;
    }
    public function checkstatus()
    {
        return $this->checkStatusService->checkStatus();
    }
}
