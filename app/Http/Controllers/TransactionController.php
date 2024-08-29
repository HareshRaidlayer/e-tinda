<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function initializeTransaction(Request $request)
    {
        // Fetch environment variables
        $token = '2c1816316e65dbfcb0c34a25f3d6fe5589aef65d';
        $code = 'MSYS_TEST_BILLER';
        $env = 'staging'; // Default to 'staging' if not set

        // Validate request parameters
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'txnid' => 'required|string',
            'callback_url' => 'required|url',
            'digest' => 'required|string',
            'name' => 'nullable|string',
            'mobile' => 'nullable|string',
            'expires_at' => 'nullable|date_format:Y-m-d H:i:s',
            'description' => 'nullable|json'
        ]);

        // Compute the digest if not provided (for verification purposes)
        if (!isset($validatedData['digest'])) {
            $validatedData['digest'] = sha1($validatedData['amount'] . $validatedData['txnid'] . $token);
        }

        // Set up the data payload
        $data = [
            'amount' => $validatedData['amount'],
            'txnid' => $validatedData['txnid'],
            'callback_url' => $validatedData['callback_url'],
            'digest' => $validatedData['digest'],
            'name' => $validatedData['name'],
            'mobile' => $validatedData['mobile'],
            'expires_at' => $validatedData['expires_at'],
            'description' => $validatedData['description'],
        ];

        // Determine the API URL based on environment
        $apiUrl = $env === 'production'
            ? 'https://pgi-ws.multipay.ph/api/v1/transactions/generate'
            : 'https://pgi-ws-staging.multipay.ph/api/v1/transactions/generate';

        // Send the request to the external API
        $response = Http::withHeaders([
            'X-MultiPay-Token' => $token,
            'X-MultiPay-Code' => $code,
        ])->post($apiUrl, $data);

        // Return the response
        return $response->json();
    }

    public function searchTransaction($refno)
    {
        $refno = 1;

        $token = env('MULTIPAY_TOKEN');
        $code = env('MULTIPAY_CODE');
        $env = env('MULTIPAY_ENV', 'staging'); // Default to 'staging' if not set

        // Determine the API URL based on environment
        $apiUrl = $env === 'production'
            ? 'https://pgi-ws.multipay.ph/api/v1/transactions/' . $refno
            : 'https://pgi-ws-staging.multipay.ph/api/v1/transactions/' . $refno;

        // Send the GET request to the external API
        $response = Http::withHeaders([
            'X-MultiPay-Token' => $token,
            'X-MultiPay-Code' => $code,
        ])->get($apiUrl);

        // Return the response
        return $response->json();
    }
}
