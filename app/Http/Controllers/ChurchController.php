<?php

namespace App\Http\Controllers;

use App\Models\Church;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Carbon\Carbon;
use App\Models\Category;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Account;
use Stripe\Charge;
use Stripe\Transfer;
use App\Models\Donation;
use Session;
use Stripe\StripeClient;
use Stripe\AccountLink;
use Razorpay\Api\Api;
use App\Models\Currency;
use App\Models\Country;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



class ChurchController extends Controller
{
    private $api;
    // admin
    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }
    public function index()
    {
        $type = 'In House';
        $churches = Church::where('added_by', 'admin')->get();
        return view('backend.church.index', compact('churches', 'type'));
    }


    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        $countrys = Country::all();


        return view('backend.church.create', compact('categories', 'countrys'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail_img' => 'required',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'bank_account_number' => 'required|string',
            'bank_routing_number' => 'required|string',
            'email' => 'required|email',
            'bank_ifsc' => 'required',
            'phone_number' => 'required',
            'country' => 'required',

        ]);

        $curencyCode = Currency::findOrFail(get_setting('system_default_currency'))->code;

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));


        $church = new Church;
        $church->name = $request->name;
        $church->added_by = $request->added_by;
        $church->description = $request->description;
        $church->status = $request->status;
        $church->thumbnail_img = $request->thumbnail_img;
        $church->address = $request->address;
        $church->email = $request->email;
        $church->phone_number = $request->phone_number;

        $church->bank_name = $request->bank_name;
        $church->bank_account_number = $request->bank_account_number;
        $church->bank_routing_number = $request->bank_routing_number;
        $church->bank_ifsc = $request->bank_ifsc;

        $stripe = new StripeClient(env('STRIPE_SECRET'));


        try {

            $contactRazer = $api->contact->create([
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->phone_number,
                'type' => 'customer',
            ]);
            // Save Razorpay contact ID
            $church->razorpay_contact_id = $contactRazer->id;

            // Create Razorpay fund account (bank account)
            $fundAccount = $api->fundAccount->create([
                'contact_id' => $contactRazer->id,
                'account_type' => 'bank_account',
                'bank_account' => [
                    'name' => $church->name,
                    'ifsc' => $request->bank_ifsc,
                    'account_number' => $request->bank_account_number,
                ],
            ]);
            $church->razorpay_fund_account_id = $fundAccount->id;


            // Create a Stripe Express account for the church
            $account = $stripe->accounts->create([
                'type' => 'express',
                'country' => $request->country,
                'email' => $request->email,
            ]);

            // Save the Stripe account ID to the Church model
            $church->stripe_account_id = $account->id;

            // Create and link the bank account to the Stripe account
            $bankAccount = $stripe->accounts->createExternalAccount(
                $church->stripe_account_id,
                [
                    'external_account' => [
                        'object' => 'bank_account',
                        'country' => $request->country,
                        'currency' => "$curencyCode",
                        'account_holder_name' => $church->name,
                        'account_holder_type' => 'company',
                        'routing_number' => $request->bank_routing_number,
                        'account_number' => $request->bank_account_number,
                    ],
                ]
            );

            // Save the bank account ID if needed
            $church->stripe_bank_account_id = $bankAccount->id;

            // Save the church data to the database
            $church->save();

            // Create the account link for onboarding
            $accountLink = $stripe->accountLinks->create([
                'account' => $church->stripe_account_id,
                'refresh_url' => route('church.stripe.refresh', ['churchId' => $church->id]),
                'return_url' => route('church.dashboard', ['churchId' => $church->id]),
                'type' => 'account_onboarding',
            ]);

            // Redirect to the onboarding URL
            return redirect($accountLink->url);
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
            return redirect()->back();
        }
    }

    public function updatePublished(Request $request)
    {
        $church = Church::findOrFail($request->id);

        $church->status = $request->status;

        if ($church->added_by == 'seller' && addon_is_activated('seller_subscription') && $request->status == 1) {
            $shop = $church->user->shop;

            if (
                $shop->package_invalid_at == null ||
                Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) < 0 ||
                $shop->church_upload_limit <= $shop->user->products()->where('status', 1)->count()
            ) {
                return 0;
            }
        }

        $church->save();

        // Clear view and cache
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return 1;
    }

    public function edit($id)
    {
        $church = Church::findOrFail($id);
        $countrys = Country::all();
        return view('backend.church.edit', compact('church', 'countrys'));
    }

    public function update(Request $request, $id)
    {
        // echo 1234;exit;
        $request->validate([
            'name' => 'required|string|max:255',
            'added_by' => 'required|string|max:255',
            'thumbnail_img' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $church = Church::findOrFail($id);
        $church->name = $request->name;
        $church->added_by = 'admin';
        $church->description = $request->description;
        $church->status = $request->status;
        $church->thumbnail_img = $request->thumbnail_img;
        $church->address = $request->address;
        $church->email = $request->email;

        $church->bank_account_number = $request->bank_account_number;
        $church->bank_routing_number = $request->bank_routing_number;


        // $account = Account::create([
        //     'type' => 'custom',
        //     'country' => 'PH',
        //     'email' =>  $request->email,
        //     'business_type' => 'non_profit',
        //     'external_account' => [
        //         'object' => 'bank_account',
        //         'country' => 'PH',
        //         'currency' => 'PHP',
        //         'routing_number' => $request->bank_routing_number,
        //         'account_number' => $request->bank_account_number,
        //         'account_holder_name' => $request->name,
        //         'account_holder_type' => 'company',
        //     ],
        // ]);

        $church->stripe_account_id = 'acct_1234567890abcdef';


        $church->save();

        flash(translate('Church has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('church.index');
    }

    public function destroy($id)
    {
        $church = Church::findOrFail($id);
        $church->delete();

        flash(translate('Church has been deleted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('church.index');
    }

    public function onboard($churchId)
    {
        // Fetch the specific church by ID
        $church = Church::find($churchId);

        // Check if the church exists
        if (!$church) {
            return redirect()->route('church.dashboard')->with('error', 'Church not found.');
        }

        // Check if the Stripe account exists
        if (!$church->stripe_account_id) {
            return redirect()->route('church.dashboard')->with('error', 'Stripe account not found. Please contact support.');
        }

        // Initialize Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create an account link for onboarding
            $accountLink = AccountLink::create([
                'account' => $church->stripe_account_id,
                'refresh_url' => route('church.stripe.refresh', ['churchId' => $churchId]), // Redirect here if onboarding needs to be refreshed
                'return_url' => route('church.dashboard', ['churchId' => $churchId]), // Redirect here after onboarding is complete
                'type' => 'account_onboarding',
            ]);

            // Redirect to the onboarding URL
            return redirect($accountLink->url);
        } catch (\Exception $e) {
            // Handle errors, like if the account already completed onboarding
            return redirect()->route('church.dashboard', ['churchId' => $churchId])->with('error', 'There was an error with the onboarding process: ' . $e->getMessage());
        }
    }

    public function dashboard($churchId)
    {
        // Load church details
        $church = Church::find($churchId);

        if (!$church) {
            return redirect()->route('church.index')->with('error', 'Church not found.');
        }

        // Load the dashboard view with church data
        return redirect()->route('church.index')->with('success', 'Church created.');
    }


    // frontend

    public function home()
    {
        $churches = Church::where('added_by', 'admin')->get();
        return view('frontend.church_list', compact('churches'));
    }

    public function single_page(Request $request)
    {
        $church_id = $request->id;
        $singleChurche = Church::where('id', $church_id)->get();
        $churches = Church::where('added_by', 'admin')
            ->where('id', '!=', $church_id) // Exclude the single church
            ->get();
        return view('frontend.church_single', compact('singleChurche', 'churches'));
    }

    //     public function donationCreate(Request $request, Church $church)
    // {
    //     // Validate the donation amount
    //     $request->validate([
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     $amount = $request->amount * 100; // Stripe handles amounts in cents

    //     // Initialize the Stripe client
    //     $stripe = new StripeClient('sk_test_51PqrYGDPvIfzbOLbLTjrdbq8upw8GUKpdUgpEsn2ES5O48SM8E04HRqvCivxW1xxmEFPOWKS5ZcyKJVHwZpWIr5N00DVM63O02');

    //     try {
    //         // Create a PaymentIntent with transfer_data to the church's Stripe account
    //         $paymentIntent = $stripe->paymentIntents->create([
    //             'amount' => $amount,
    //             'currency' => 'usd',
    //             'payment_method_types' => ['card'],
    //             'transfer_data' => [
    //                 'destination' => $church->stripe_account_id,
    //             ],
    //         ]);

    //         // Provide the client_secret to the front-end to complete the payment
    //         return view('frontend.payment.stripe_donation', [
    //             'clientSecret' => $paymentIntent->client_secret,
    //             'amount' => $amount / 100,
    //             'church' => $church,
    //         ]);

    //     } catch (\Exception $e) {
    //         // Handle errors (e.g., Stripe API errors)
    //         return back()->withErrors(['error' => 'There was an error processing your donation: ' . $e->getMessage()]);
    //     }


    // }


    public function donationCreate(Request $request, $churchId)
    {

        $request->validate([
            'payment_option' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $church = Church::findOrFail($churchId);
        $amount = $request->input('amount'); // Convert amount to cents for Stripe
        $paymentOption = $request->payment_option;

        if ($request->input('payment_option') === 'stripe') {
            return $this->handleStripePayment($church, $amount, $request);
        } else if ($request->input('payment_option') === 'razorpay') {
            return $this->handleRazorpayPayment($church, $amount, $request);
        } else if ($request->input('payment_option') === 'biller') {
            return $this->handleBillerPayment($amount, $church, $request);
        }


        return redirect()->back()->with('error', 'Invalid payment method');
    }



    private function handleStripePayment(Church $church, $amount, Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $curencyCode = Currency::findOrFail(get_setting('system_default_currency'))->code;
        // Create PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => "$curencyCode",
            'payment_method_types' => ['card'],
            'transfer_data' => [
                'destination' => $church->stripe_account_id,
            ],
        ]);

        // Save donation details
        $this->saveDonation($request, 'stripe', $paymentIntent->id);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }


    private function handleBillerPayment($amount, $churchId, $request)
    {
        $txnid = uniqid(); // Generate a unique transaction ID
        $token = "2c1816316e65dbfcb0c34a25f3d6fe5589aef65d"; // Token for the API
        $data = $amount . $txnid . $token;
        $digest = sha1($data); // Generate the digest
        $callbackUrl = "http://ecommerce.conscor.com/"; // Callback URL

        try {
            // Send POST request to the API
            $response = Http::withHeaders([
                'X-MultiPay-Token' => $token,
                'X-MultiPay-Code' => 'MSYS_TEST_BILLER',
            ])->post('https://pgi-ws-staging.multipay.ph/api/v1/transactions/generate', [
                'amount' => $amount,
                'txnid' => $txnid,
                'callback_url' => $callbackUrl,
                'digest' => $digest,
                'church_id' => $churchId,
            ]);
            $data = $response->json();
            $paymentUrl = $data['data']['url'];
            $this->saveDonation($request, 'biller', $churchId, $paymentUrl);
            // return redirect($paymentUrl);
            return response()->json([
                'status' => 1,
                'redirectUrl' => $paymentUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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


    // private function handleRazorpayPayment(Church $church, $amount, Request $request)
    // {
    //     $api = new Api('rzp_test_rvO5evJIDBL6io', 'cWmQnzn1RDZPZYiCOllqKRiJ');

    //     // Create a Razorpay payment request
    //     $order = $api->order->create([
    //         'amount' => $amount,
    //         'currency' => 'INR',
    //         'payment_capture' => 1,
    //     ]);

    //     // Save donation details
    //     $this->saveDonation($request, 'razorpay', $order->id);

    //     return response()->json([
    //         'orderId' => $order->id,
    //         'amount' => $amount,
    //     ]);
    // }

    private function handleRazorpayPayment(Church $church, $amount, Request $request)
    {
        // Initialize Razorpay API client
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $currencyCode = Currency::findOrFail(get_setting('system_default_currency'))->code;

        try {
            // Create a payout to the church's bank account
            $payout = $api->payout->create([
                'fund_account_id' => $church->razorpay_fund_account_id,
                'amount' => $amount * 100, // Amount in paise (Razorpay requires paise)
                'currency' => $currencyCode,
                'mode' => 'IMPS',
                'purpose' => 'payout',
                'queue_if_low_balance' => true,
                'reference_id' => 'txn_' . uniqid(),
                'narration' => 'Donation to Church',
            ]);

            // Save donation details
            \Log::info('Payout created: ', ['payoutId' => $payout->id]);
            $this->saveDonation($request, 'razorpay', $payout->id);

            // Poll for payout status
            $status = $this->pollPayoutStatus($payout->id);

            return response()->json([
                'status' => $status == 'processed' ? 'success' : 'pending',
                'message' => $status == 'processed' ? 'Payout successful' : 'Payout is being processed',
                'payoutId' => $payout->id,
                'amount' => $amount,
                'currency' => $currencyCode,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error processing payout: ', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function pollPayoutStatus($payoutId)
    {
        // Poll the status of the payout after a brief delay
        sleep(5); // Wait for 5 seconds (adjust as necessary)
        try {
            $payoutStatus = $this->api->payout->fetch($payoutId);
            return $payoutStatus->status;
        } catch (\Exception $e) {
            return 'error';
        }
    }



    private function saveDonation(Request $request, $paymentOption, $paymentId)
    {
        Donation::create([
            'church_id' => $request->input('church_id'),
            'amount' => $request->input('amount'),
            'payment_option' => $paymentOption,
            'payment_id' => $paymentId,
            'status' => 'pending', // Set status based on actual payment result
        ]);
    }




    // public function handleStripeWebhook(Request $request)
    // {
    //     $stripe = new StripeClient('sk_test_51PqrYGDPvIfzbOLbLTjrdbq8upw8GUKpdUgpEsn2ES5O48SM8E04HRqvCivxW1xxmEFPOWKS5ZcyKJVHwZpWIr5N00DVM63O02');

    //     $event = $request->input('type');
    //     $data = $request->input('data');

    //     if ($event === 'payment_intent.succeeded') {
    //         $paymentIntentId = $data['object']['id'];
    //         $churchId = $data['object']['metadata']['church_id'];

    //         $church = Church::find($churchId);

    //         if ($church) {
    //             try {
    //                 $this->transferFunds($paymentIntentId, $church);
    //             } catch (\Exception $e) {
    //                 return response()->json(['error' => $e->getMessage()], 500);
    //             }
    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }

    // private function transferFunds($paymentIntentId, Church $church)
    // {
    //     $stripe = new StripeClient('sk_test_51PqrYGDPvIfzbOLbLTjrdbq8upw8GUKpdUgpEsn2ES5O48SM8E04HRqvCivxW1xxmEFPOWKS5ZcyKJVHwZpWIr5N00DVM63O02');

    //     try {
    //         $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

    //         $stripe->transfers->create([
    //             'amount' => $paymentIntent->amount,
    //             'currency' => 'usd',
    //             'destination' => $church->stripe_account_id,
    //             'transfer_group' => $paymentIntent->id,
    //         ]);
    //     } catch (\Exception $e) {
    //         throw new \Exception('Error creating transfer: ' . $e->getMessage());
    //     }
    // }


    public function handleRazorpayWebhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Razorpay Webhook Received:', $payload);

        // Handle payout processed event
        if ($payload['event'] == 'payout.processed') {
            $payoutId = $payload['payload']['payout']['entity']['id'];
            // Update the donation record in your database
            Donation::where('payout_id', $payoutId)->update(['status' => 'processed']);
            return response()->json(['status' => 'success'], 200);
        }

        // Handle payout failed event
        if ($payload['event'] == 'payout.failed') {
            $payoutId = $payload['payload']['payout']['entity']['id'];
            // Update the donation record in your database
            Donation::where('payout_id', $payoutId)->update(['status' => 'failed']);
            return response()->json(['status' => 'success'], 200);
        }

        // Add more event handling as necessary

        return response()->json(['status' => 'unhandled event'], 200);
    }
}
