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
        $token = env('MULTIPAY_TOKEN');
        $data = [
            'amount' => $request->amount,
            'txnid' => $request->txnid,
            'callback_url' => $request->callback_url,
            'digest' => sha1($request->amount . $request->txnid . $token),
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
