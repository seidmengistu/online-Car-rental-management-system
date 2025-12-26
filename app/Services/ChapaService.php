<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChapaService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.chapa.base_url', 'https://api.chapa.co'), '/');
    }

    /**
     * Start a Chapa checkout session.
     */
    public function initialize(array $payload): array
    {
        $response = Http::withToken(config('services.chapa.secret_key'))
            ->acceptJson()
            ->post($this->baseUrl . '/v1/transaction/initialize', $payload);

        $json = $response->json();

        return [
            'ok' => $response->ok()
                && ($json['status'] ?? null) === 'success'
                && !empty($json['data']['checkout_url']),
            'checkout_url' => $json['data']['checkout_url'] ?? null,
            'raw' => $json,
            'message' => $json['message'] ?? $response->reason(),
        ];
    }

    /**
     * Verify a completed Chapa payment by reference.
     */
    public function verify(string $txRef): array
    {
        $response = Http::withToken(config('services.chapa.secret_key'))
            ->acceptJson()
            ->get($this->baseUrl . '/v1/transaction/verify/' . $txRef);

        $json = $response->json();

        return [
            'ok' => $response->ok()
                && ($json['status'] ?? null) === 'success'
                && ($json['data']['status'] ?? null) === 'success',
            'status' => $json['data']['status'] ?? null,
            'raw' => $json,
            'message' => $json['message'] ?? $response->reason(),
        ];
    }

    /**
     * Generate a unique transaction reference with a friendly prefix.
     */
    public function makeTxRef(string $prefix, int|string $id): string
    {
        return $prefix . '-' . $id . '-' . Str::upper(Str::random(10));
    }
}


