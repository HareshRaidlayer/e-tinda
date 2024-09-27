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
use App\Models\CharchBranch;
use App\Models\Country;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Auth;



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
        $churches = Church::where('added_by', 'admin')->where('parent_church_id',NULL)->get();
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

    // Save the main church
    $church = new Church();
    $church->name = $request->name;
    $church->added_by = $request->added_by;
    $church->description = $request->description;
    $church->status = $request->status;
    $church->thumbnail_img = $request->thumbnail_img;
    $church->address = $request->address;
    $church->email = $request->email;
    $church->phone_number = $request->phone_number;
    $church->country = $request->country;

    $church->save();

    // Save the branches if available
    if ($request->has('branch_name') && !empty($request->branch_name)) {
        $branchNames = $request->branch_name; // Correct variable
        foreach ($branchNames as $key => $value) {
            $churchBranch = new Church();
            $churchBranch->parent_church_id = $church->id;
            $churchBranch->name = $value;
            $churchBranch->added_by = 'admin';
            $churchBranch->status = $request->branch_status[$key] ?? 0; // default to 0 if not provided
            $churchBranch->address = $request->branch_address[$key] ?? '';
            $churchBranch->email = $request->branch_email[$key] ?? '';
            $churchBranch->phone_number = $request->branch_phone_number[$key] ?? '';
            $churchBranch->country = $request->branch_country[$key] ?? '';

            $churchBranch->save();
        }
    }

    // Flash success message and redirect back
    flash(translate('Church has been saved successfully'))->success();
    return redirect()->back();
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
        // print_r($countrys);exit;
        $churchBranch = Church::where("parent_church_id",$church->id)->get();

        return view('backend.church.edit', compact('church', 'countrys', 'churchBranch'));
    }

    public function update(Request $request, $id)
{
    // Validate input

    // Update the main church
    $church = Church::findOrFail($id);
    $church->name = $request->name;
    $church->added_by = $request->added_by;
    $church->description = $request->description;
    $church->status = $request->status;
    $church->thumbnail_img = $request->thumbnail_img;
    $church->address = $request->address;
    $church->email = $request->email;
    $church->phone_number = $request->phone_number;
    $church->save();

    // Update or create branches
    $branchIds = $request->branch_id;
    // print_r($branchIds);exit;
    $branchNames = $request->branch_name;

    if (!empty($branchNames)) {
        foreach ($branchNames as $key => $name) {
            if (isset($branchIds[$key]) && !empty($branchIds[$key])) {
                // Update existing branch
                $churchBranch = Church::findOrFail($branchIds[$key]);
                $churchBranch->name = $name;
                $churchBranch->added_by = 'admin';
                $churchBranch->status = $request->branch_status[$key] ?? 0; // Default status to 0
                $churchBranch->address = $request->branch_address[$key] ?? '';
                $churchBranch->email = $request->branch_email[$key] ?? '';
                $churchBranch->phone_number = $request->branch_phone_number[$key] ?? '';
                $churchBranch->country = $request->branch_country[$key] ?? '';
                $churchBranch->save();
            } else {

                // Create a new branch
                $churchBranch = new Church();
                $churchBranch->parent_church_id = $church->id;
                $churchBranch->name = $name;
                $churchBranch->added_by = 'admin';
                $churchBranch->status = $request->branch_status[$key] ?? 0; // Default status to 0
                $churchBranch->address = $request->branch_address[$key] ?? '';
                $churchBranch->email = $request->branch_email[$key] ?? '';
                $churchBranch->phone_number = $request->branch_phone_number[$key] ?? '';
                $churchBranch->country = $request->branch_country[$key] ?? '';
                $churchBranch->save();
            }


        }
    }

    // Optionally delete branches that are not present in the update request
//     $existingBranchIds = Church::where('parent_church_id', $church->id)->pluck('id')->toArray();
//     $newBranchIds = array_filter($branchIds);
//     $branchesToDelete = array_diff($existingBranchIds, $newBranchIds);
// print_r($branchesToDelete);exit;
    // Church::whereIn('id', $branchesToDelete)->delete();

    // Flash success message
    flash(translate('Church has been updated successfully'))->success();

    // Clear views and cache
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
        $churches = Church::where('parent_church_id', NULL)->get();
        return view('frontend.church_list', compact('churches'));
    }

    public function single_page(Request $request)
    {
        $church_id = $request->id;
        $singleChurche = Church::where('id', $church_id)->where('status' , 1)->get();
        $churches = Church::where('added_by', 'admin')
            ->where('id', '!=', $church_id)
            ->get();
        $churchBranches = Church::where('parent_church_id', $church_id)->where('status' , 1)->get();
        return view('frontend.church_single', compact('singleChurche', 'churches', 'churchBranches'));
    }



    public function donationCreate(Request $request, $churchId)
    {

        $church = Church::findOrFail($churchId);
        $church_id= $church->id;
        if(!empty($request->church_branch)){
            $church_id = $request->church_branch;
        }
        $amount = $request->amount;

        $sender = Auth::user();
        // print_r($sender['id']);exit;

        if ($sender->balance < $amount) {
            flash(translate('You do not have enough balance to complete this transfer. Your current balance is ₱') . number_format($sender->balance, 2))->error();
            return redirect()->back()->withInput();
        }
        DB::beginTransaction();

        try {
            $sender->balance -= $amount;
            $sender->save();
            Donation::create([
                'church_id' =>$church_id,
                'amount' => $amount,
                'payment_option' => "Wallet",
                'user_id' => $sender['id'],
                'status' => 'paid',
                'is_donatated' => 0
            ]);

            DB::commit();

            flash(translate('Money transferred successfully to  ') .  $church->name . '. Your new balance is ₱' . number_format($sender->balance, 2))->success();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            flash(translate('Failed to transfer money. Please try again.'))->error();
            return redirect()->back()->withInput();
        }

    }

    public function donationList(Request $request)
    {
        $donation_status = 0;
        $sort_search = null;

        // Start building the query with necessary joins and select
        $donations = Donation::join('churches', 'donations.church_id', '=', 'churches.id')
            ->select('donations.*', 'churches.name as church_name');

        // Apply the donation status filter if provided
        if ($request->has('donation_status') && $request->donation_status != null) {
            $donations = $donations->where('donations.is_donatated', $request->donation_status);
            $donation_status = $request->donation_status;
        }else{
            $donations = $donations->where('donations.is_donatated',0);
        }

        // Apply the user ID filter if provided
        if ($request->has('user_id') && $request->user_id != null) {
            $donations = $donations->where('donations.user_id', $request->user_id);
        }

        // Apply the search filter if provided
        if ($request->search != null) {
            $sort_search = $request->search;
            $donations = $donations->where(function($query) use ($sort_search) {
                $query->where('churches.name', 'like', '%' . $sort_search . '%')
                    ->orWhereHas('stocks', function ($q) use ($sort_search) {
                        $q->where('sku', 'like', '%' . $sort_search . '%');
                    });
            });
        }

        // Execute the query to get the results
        $donations = $donations->get();

        $churches = Church::where('status', 1)->get();

        return view('backend.church.donationList', compact('donations', 'donation_status', 'sort_search', 'churches'));
    }



}
