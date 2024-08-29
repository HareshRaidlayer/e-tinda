<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;


class MultipayController extends Controller
{
    protected $multiPayService;

    public function __construct(PaymentService $multiPayService)
    {
        $this->multiPayService = $multiPayService;
    }

    public function initializePayment(Request $request)
    {
        $data = [
            'amount' => $request->amount,
            'txnid' => $request->txnid,
            'callback_url' => $request->callback_url,
            'digest' => sha1($request->amount . $request->txnid . '8c5d9f8a3b2f1c4e5a6d7b8f9c0e1f2a3b4c5d6e7f8g9h0i'),
        ];

        $response = $this->multiPayService->initializeTransaction($data);
        return response()->json($response);
    }

    public function handleCallback(Request $request)
    {
        // Extract information from the callback request
        $transactionId = $request->input('txnid');
        $status = $request->input('status');
        $amount = $request->input('amount');
        // Handle the response (e.g., update the transaction status in the database)
        if ($status === 'S') {
            // Payment successful
        } elseif ($status === 'F') {
            // Payment failed
        } else {
            // Handle other statuses
        }
        // Respond with an acknowledgment
        return response()->json(['message' => 'Callback received'], 200);
    }
}
