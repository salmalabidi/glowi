<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlouciService
{
    protected string $baseUrl;
    protected string $publicKey;
    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.flouci.base_url'), '/');
        $this->publicKey = config('services.flouci.public_key');
        $this->secretKey = config('services.flouci.secret_key');
    }

    protected function authHeader(): string
    {
        return 'Bearer ' . $this->publicKey . ':' . $this->secretKey;
    }

    public function generatePayment(array $payload): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authHeader(),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/api/v2/generate_payment', $payload);

        $response->throw();

        return $response->json();
    }

    public function verifyPayment(string $paymentId): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authHeader(),
        ])->get($this->baseUrl . '/api/v2/verify_payment/' . $paymentId);

        $response->throw();

        return $response->json();
    }
}