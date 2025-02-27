<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\SellerPackageController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;
use Session;


class MultisysController extends Controller
{
    public function pay(Request $request)
    {

        if (Session::has('payment_type')) {
            $paymentType = Session::get('payment_type');
            $paymentData = Session::get('payment_data');

            if ($paymentType == 'wallet_payment') {
                $amount = intval($paymentData['amount']);
                $callbackUrl = route('payment.callback'); // Callback URL
            } else {
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                $amount = round($combined_order->grand_total);
                $callbackUrl = route('order_confirmed'); // Callback URL

            }
            $txnid = uniqid(); // Generate a unique transaction ID
            $token = config('payment.multipay_token'); // Token for the API
            $data = $amount . $txnid . $token;
            $digest = sha1($data); // Generate the digest
dd($token);

            try {
                // Send POST request to the API
                $response = Http::withHeaders([
                    'X-MultiPay-Token' => $token,
                    'X-MultiPay-Code' => config('payment.multipay_code'),
                ])->post('https://pgi-ws-staging.multipay.ph/api/v1/transactions/generate', [
                    'amount' => $amount,
                    'txnid' => $txnid,
                    'callback_url' => $callbackUrl,
                    'digest' => $digest,
                ]);
                $data1 = $response->json();
                dd($data1);
                $paymentUrl = $data1['data']['url'];
                return redirect($paymentUrl);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
