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
        $this->token = '2c1816316e65dbfcb0c34a25f3d6fe5589aef65d';
        $this->code = 'MSYS_TEST_BILLER';
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
