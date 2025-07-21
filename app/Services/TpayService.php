<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TpayService
{
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.tpay.client_id');
        $this->clientSecret = config('services.tpay.client_secret');
    }

    public function getAccessToken(): ?string
    {
        $auth = base64_encode("{$this->clientId}:{$this->clientSecret}");

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://api.tpay.com/oauth/auth', [
            'grant_type' => 'client_credentials',
        ]);

        return $response->json()['access_token'] ?? null;
    }

    public function createTransaction(array $transactionData): ?string
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api.tpay.com/transactions', $transactionData);

        $json = $response->json();
        dd($json);

        return $json ?? null;
    }
}
