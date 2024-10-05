<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\City;
use App\Models\State;
use Auth;
use Artisan;

class HotelController extends Controller
{
    public function index(Request $request)
    {

        $search = null;
        $hotels = Hotel::where('user_id', Auth::user()->id)->where('added_by', 'seller')->orderBy('id', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $hotels = $hotels->where('name', 'like', '%' . $search . '%');
        }
        $hotels = $hotels->paginate(10);
        return view('backend.hotels.index', compact('hotels','search'));
    }


    public function create()
    {
        return view('backend.hotels.create');
    }

    public function store(Request $request)
    {
        // Step 1: Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'image' => 'required|string',

        ]);

        // Step 2: Save Hotel
        $hotel = new Hotel();
        $hotel->user_id = Auth::user()->id;
        $hotel->name = $request->input('name');
        $hotel->description = $request->input('description');
        $hotel->address = $request->input('address');
        $hotel->city = $request->input('city');
        $hotel->state = $request->input('state');
        $hotel->country = $request->input('country');
        $hotel->image = $request->input('image');
        $hotel->added_by = $request->input('added_by');
        $hotel->is_approved = 0;
        $hotel->save();

        // Step 3: Save Rooms
        if ($request->has('rooms')) {
            foreach ($request->input('rooms') as $roomData) {
                $room = new Room();
                $room->hotel_id = $hotel->id;  // Reference the saved hotel's ID
                $room->room_number = $roomData['room_number'];
                $room->capacity = $roomData['capacity'];
                $room->price = $roomData['price'];
                $room->images = $roomData['images'];
                $room->save();
            }
        }

        // Step 4: Redirect or return a response
        flash(translate('Hotel Add successfully'))->success();
        return redirect()->route('seller.hotels');
    }


    public function edit(Hotel $hotel ,$id)
    {
        $hotel = Hotel::find($id);
        $states = State::where('status', 1)->where('country_id', $hotel->country)->get();

        $cities = City::where('status', 1)->where('state_id', $hotel->state)->get();

        return view('backend.hotels.update', compact('hotel','states','cities'));
    }

    public function update(Request $request, $id)
{
    // Step 1: Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'country' => 'required|string|max:255',

    ]);

    // Step 2: Find the existing hotel by ID
    $hotel = Hotel::findOrFail($id);

    // Step 3: Update Hotel
    $hotel->name = $request->input('name');
    $hotel->description = $request->input('description');
    $hotel->address = $request->input('address');
    $hotel->city = $request->input('city');
    $hotel->state = $request->input('state');
    $hotel->country = $request->input('country');
    if ($request->has('image')) {
        $hotel->image = $request->input('image');
    }
    $hotel->save();

    // Step 4: Handle Rooms
    $existingRoomIds = collect($request->input('rooms.*.id'))->filter(); // Get IDs of rooms in the form

    // Delete rooms that are not in the request (those removed by the user)
    Room::where('hotel_id', $hotel->id)
        ->whereNotIn('id', $existingRoomIds)
        ->delete();

    // Update or add rooms
    foreach ($request->input('rooms') as $roomData) {
        if (isset($roomData['id'])) {
            // Update existing room
            $room = Room::findOrFail($roomData['id']);
        } else {
            // Create new room
            $room = new Room();
            $room->hotel_id = $hotel->id;
        }

        $room->room_number = $roomData['room_number'];
        $room->capacity = $roomData['capacity'];
        $room->price = $roomData['price'];
        if (isset($roomData['images'])) {
            $room->images = $roomData['images'];
        }
        $room->save();
    }

    // Step 5: Redirect or return a response
    flash(translate('Hotel update successfully'))->success();
    return redirect()->route('seller.hotels');
}

    public function destroy(Hotel $hotel, $id)
    {
        $hotel = Hotel::findOrFail($id);

        // Delete all associated rooms manually
        $hotel->rooms()->delete();

        // Delete the hotel itself
        $hotel->delete();
        flash(translate('Hotel delete successfully'))->success();
        return redirect()->back();
    }


    public function AdminIndex(Request $request)
    {
        $search = null;
        $hotels = Hotel::orderBy('id', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $hotels = $hotels->where('name', 'like', '%' . $search . '%');
        }
        $hotels = $hotels->paginate(10);
        return view('backend.hotels.admin_index', compact('hotels','search'));
    }

    public function adminHotelsView(Request $request ,$id)
    {

        $hotel = Hotel::find($id);
        $states = State::where('status', 1)->where('country_id', $hotel->country)->get();
        $cities = City::where('status', 1)->where('state_id', $hotel->state)->get();
        return view('backend.hotels.admin_view', compact('hotel','states','cities'));
    }

    public function updatePublished(Request $request)
    {
        $hotels = Hotel::findOrFail($request->id);

        $hotels->is_approved = $request->status;

        $hotels->save();

        // Clear view and cache
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return 1;
    }

    public function adminHotelsDestroy(Hotel $hotel, $id)
    {
        $hotel = Hotel::findOrFail($id);

        // Delete all associated rooms manually
        $hotel->rooms()->delete();

        // Delete the hotel itself
        $hotel->delete();
        flash(translate('Hotel delete successfully'))->success();
        return redirect()->back();
    }

}
