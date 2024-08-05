<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Artisan;
use App\Models\Category;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function admin_service(Request $request)
    {
        $services = Service::all();
        return view('backend.services.index', compact('services'));
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
        return view('backend.services.edit', compact('product', 'categories', 'tags', 'serviceCategory', 'lang'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'earn_point' => 'required',
        ]);
        $service = Service::find($request->id);
        $service->status = $request->status;
        $service->earn_point = $request->earn_point;

        $service->save();
        return redirect()->route('service.admin');
    }
}
