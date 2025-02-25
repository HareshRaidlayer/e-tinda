<?php

namespace App\Http\Controllers\Seller;

use AizPackages\CombinationGenerate\Services\CombinationService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ServiceTranslation;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;
use App\Models\User;
use Artisan;
use Auth;
use DB;
use App\Models\Order;

class ServiceController extends Controller
{

    public function serviceOrders(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->where('seller_id', Auth::user()->id)
            ->where('is_service', 1)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }
        return view('seller.service.services.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    public function index(Request $request)
    {
        $search = null;
        $products = Service::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%' . $search . '%');
        }
        $products = $products->paginate(10);
        return view('seller.service.services.index', compact('products', 'search'));
    }

    public function create(Request $request)
    {
        $serviceCategory = ServiceCategory::where('status', 1)->get();
        return view('seller.service.services.create', compact('serviceCategory'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'thumbnail_img' => 'required',
            'photos' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
        ]);
        $uid = Auth::user()->id;
        $service = new Service;
        $service->name = $request->name;
        $service->added_by = $request->added_by;
        $service->user_id = $uid;
        $service->category_id = $request->category;
        $service->video = $request->video_link;
        // $service->tags = $request->tags;
        $service->thumbnail_img = $request->thumbnail_img;
        $service->photos = $request->photos;
        $service->description = $request->description;
        $service->price = $request->price;

        $service->status = $request->status;
        $service->discount = $request->discount;
        $service->discount_type = $request->discount_type;
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        $service->discount_start_date = $discount_start_date;
        $service->discount_end_date = $discount_end_date;

        $slug = Str::slug($request->name);
        $same_slug_count = Service::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;
        $service->slug = $slug;

        $service->warranty = $request->warranty;
        $service->save();
        return redirect()->route('seller.service');
    }




    public function edit(Request $request, $id)
    {
        $product = Service::findOrFail($id);
        $serviceCategory = ServiceCategory::where('status', 1)->get();

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('seller.service.services.edit', compact('product', 'categories', 'tags', 'serviceCategory', 'lang'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'thumbnail_img' => 'required',
            'photos' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::find($request->id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $service->name = $request->name;
        }

        $service->added_by = $request->added_by;
        $service->category_id = $request->category;
        $service->video = $request->video_link;
        // $service->tags = $request->tags;
        $service->thumbnail_img = $request->thumbnail_img;
        $service->photos = $request->photos;
        $service->description = $request->description;
        $service->price = $request->price;

        $service->status = $request->status;
        $service->discount = $request->discount;
        $service->discount_type = $request->discount_type;
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        $service->discount_start_date = $discount_start_date;
        $service->discount_end_date = $discount_end_date;

        $slug = Str::slug($request->name);
        $same_slug_count = Service::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;
        $service->slug = $slug;

        $service->warranty = $request->warranty;
        $request->merge(['service_id' => $service->id]);
        $service->save();
        ServiceTranslation::updateOrCreate(
            $request->only([
                'lang', 'service_id'
            ]),
            $request->only([
                'name','description'
            ])
        );
        return redirect()->route('seller.service');
    }

    public function updateFeatured(Request $request)
    {
        $product = Service::findOrFail($request->id);
        $product->status = $request->status;
        if ($product->save()) {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function destroy($id)
    {
        $product = Service::findOrFail($id);

        if (Auth::user()->id != $product->user_id) {
            flash(translate('This product is not yours.'))->warning();
            return back();
        }

        if (Service::destroy($id)) {

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}
