<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_offline_wallet_recharges'])->only('offline_recharge_request');
    }

    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.user.wallet.index', compact('wallets'));
    }

    public function recharge(Request $request)
    {
        $data['amount'] = $request->amount;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'wallet_payment');
        $request->session()->put('payment_data', $data);

        $decorator = __NAMESPACE__ . '\\Payment\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $request->payment_option))) . "Controller";

        if (class_exists($decorator)) {
            return (new $decorator)->pay($request);
        }
    }

    public function wallet_payment_done($payment_data, $payment_details)
    {
        $user = Auth::user();
        $user->balance = $user->balance + $payment_data['amount'];
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $payment_data['amount'];
        $wallet->payment_method = $payment_data['payment_method'];
        $wallet->payment_details = $payment_details;
        $wallet->save();

        Session::forget('payment_data');
        Session::forget('payment_type');

        flash(translate('Recharge completed'))->success();
        return redirect()->route('wallet.index');
    }

    public function transfer_wallet(Request $request)
    {
        $request->validate([
            'userEmail' => 'required|email',
            'amount' => 'required|numeric|min:1',
        ]);

        $recipient = User::where('email', $request->userEmail)->first();

        if (!$recipient) {
            flash(translate('User does not exist in the database.'))->error();
            return redirect()->back()->withInput();
        }

        $sender = Auth::user();

        if ($sender->balance < $request->amount) {
            flash(translate('You do not have enough balance to complete this transfer. Your current balance is ₱') . number_format($sender->balance, 2))->error();
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try {
            $sender->balance -= $request->amount;
            $sender->save();

            $recipient->balance += $request->amount;
            $recipient->save();

            DB::commit();

            flash(translate('Money transferred successfully to  ') .  $recipient->email . '. Your new balance is ₱' . number_format($sender->balance, 2))->success();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            flash(translate('Failed to transfer money. Please try again.'))->error();
            return redirect()->back()->withInput();
        }
    }

    public function offline_recharge(Request $request)
    {
        $wallet = new Wallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->amount = $request->amount;
        $wallet->payment_method = $request->payment_option;
        $wallet->payment_details = $request->trx_id;
        $wallet->approval = 0;
        $wallet->offline_payment = 1;
        $wallet->reciept = $request->photo;
        $wallet->save();
        flash(translate('Offline Recharge has been done. Please wait for response.'))->success();
        return redirect()->route('wallet.index');
    }

    public function offline_recharge_request(Request $request)
    {
        $wallets = Wallet::where('offline_payment', 1);
        $type = null;
        if ($request->type != null) {
            $wallets = $wallets->where('approval', $request->type);
            $type = $request->type;
        }
        $wallets = $wallets->orderBy('id', 'desc')->paginate(10);
        return view('manual_payment_methods.wallet_request', compact('wallets', 'type'));
    }

    public function updateApproved(Request $request)
    {
        $wallet = Wallet::findOrFail($request->id);
        $wallet->approval = $request->status;
        if ($request->status == 1) {
            $user = $wallet->user;
            $user->balance = $user->balance + $wallet->amount;
            $user->save();
        } else {
            $user = $wallet->user;
            $user->balance = $user->balance - $wallet->amount;
            $user->save();
        }
        if ($wallet->save()) {
            return 1;
        }
        return 0;
    }

    public function handleCallback(Request $request)
    {
        $payment_data = Session::get('payment_data');
        $user = Auth::user();
            $user->balance = $user->balance + $payment_data['amount'];
            $user->save();

            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->amount = $payment_data['amount'];
            $wallet->payment_method = $payment_data['payment_method'];
            $wallet->payment_details = 'wallet_payment';
            $wallet->save();

            Session::forget('payment_data');
            Session::forget('payment_type');

            flash(translate('Recharge completed'))->success();
            return redirect()->route('wallet.index');
    }
    public function handleCallbackValute(Request $request)
    {

        if($request->status != 'S'){
            flash(translate('Payment failed'))->error();
            return redirect()->route('home');
        }else{
            $payment_data = Session::get('payment_data');
            $user = Auth::user();
            $user->balance = $user->balance + $payment_data['amount'];
            $user->save();
            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->amount = $payment_data['amount'];
            $wallet->payment_method = $payment_data['payment_method'];
            $wallet->payment_details = 'wallet_payment';
            $wallet->save();

            Session::forget('payment_data');
            Session::forget('payment_type');

            flash(translate('Recharge completed'))->success();
            return redirect()->route('wallet.index');
        }

    }

}
