<?php

namespace App\Http\Controllers;

use App\Models\ClubPoint;
use App\Http\Resources\V2\ClubpointCollection;
use App\Models\BusinessSetting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubPointController extends Controller
{
    public function configure_index(Request $request)
    {
        $clubPoint = BusinessSetting::where("type", "club_point_convert_rate")->first();
        return view('backend.clubPoint.index', compact('clubPoint'));
    }

    public function userpoint_index(Request $request)
    {
        $userID = $request->user()->id;
        $myClubPoint = User::where("id", $userID)->first();
        $clubPoint = BusinessSetting::where("type", "club_point_convert_rate")->first();
        return view('frontend.user.myClubPoints.index', compact('myClubPoint', 'clubPoint'));
    }
    public function update_product_point(Request $request)
    {
        $clubPointUpdate = BusinessSetting::find($request->id);
        $clubPointUpdate->value = $request->value;
        $clubPointUpdate->update();
        flash(translate('Club Point has been updated successfully!'))->success();
        return redirect()->route('club_points.configs');
    }
    public function get_list()
    {
        $club_points = ClubPoint::where('user_id', auth()->user()->id)->latest()->paginate(10);

        return new ClubpointCollection($club_points);
    }

    public function convert_into_wallet()
    {

        $userPoints =  Auth::user()->earn_point;
        if ($userPoints != 0) {

            $clubPoint = BusinessSetting::where("type", "club_point_convert_rate")->first();

            $conversionRate = $clubPoint->value;
            $pointsToConvert = $userPoints;

            if ($pointsToConvert >= $conversionRate) {
                $money = floor($pointsToConvert / $conversionRate); // Calculate money
                $remainingPoints = $pointsToConvert % $conversionRate; // Calculate remaining points

                $user = User::find(Auth::user()->id);
                $user->earn_point = $remainingPoints;
                $user->balance += $money;
                $user->update();

                $wallet = new Wallet;
                $wallet->user_id = auth()->user()->id;
                $wallet->amount = $money;
                $wallet->payment_method = 'Club Point Convert';
                $wallet->payment_details = 'Club Point Convert';
                $wallet->save();

                flash(translate('Club Point has been Converted!'))->success();
                return redirect()->back();
            } else {
                flash(translate('Not enough points to convert!'))->error();
                return redirect()->back();
            }
        }
        return redirect()->back();
    }
}
