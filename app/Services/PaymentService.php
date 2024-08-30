<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $baseUrl;
    protected $token;
    protected $code;

    public function __construct()
    {
        $this->token = env('MULTIPAY_TOKEN');
        $this->code = env('MULTIPAY_CODE');
    }

    // Initialize a new transaction
    public function initializeTransaction($data)
    {
        $url = 'https://pgi-ws-staging.multipay.ph/api/v1/transactions/generate';
        $response = Http::withHeaders([
            'X-MultiPay-Token' => $this->token,
            'X-MultiPay-Code' => $this->code,
        ])->post($url, $data);

        return $response->json();
    }

    public function searchTransaction($refno)
    {
        $url = "https://pgi-ws-staging.multipay.ph/api/v1/transactions/$refno";
        $response = Http::withHeaders([
            'X-MultiPay-Token' => $this->token,
            'X-MultiPay-Code' => $this->code,
        ])->get($url);

        return $response->json();
    }

    public function voidTransaction($refno)
    {
        $url = "https://pgi-ws-staging.multipay.ph/api/v1/transactions/$refno/void";
        $response = Http::withHeaders([
            'X-MultiPay-Token' => $this->token,
            'X-MultiPay-Code' => $this->code,
        ])->post($url);

        return $response->json();
    }
}
