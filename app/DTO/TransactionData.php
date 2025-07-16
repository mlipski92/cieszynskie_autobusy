<?php

namespace App\DTO;

class TransactionData
{
    public function __construct(
        public float $amount,
        public string $description,
        public int $groupId,
        public string $payerName,
        public string $payerEmail,
        public string $successUrl,
        public string $errorUrl,
        public string $notificationUrl,
    ) {}

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'description' => $this->description,
            'groupId' => $this->groupId,
            'payer' => [
                'email' => $this->payerEmail,
                'name' => $this->payerName,
            ],
            'callbacks' => [
                'notification' => [
                    'url' => $this->notificationUrl,
                ],
                'payerUrls' => [
                    'success' => $this->successUrl,
                    'error' => $this->errorUrl,
                ],
            ],
        ];
    }
}
