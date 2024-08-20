<?php

namespace App\Http\Controllers;

use App\Models\Church;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Carbon\Carbon;
use App\Models\Category;


class ChurchController extends Controller
{
    // admin
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
        return view('backend.church.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail_img' => 'required',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $church = new Church;
        $church->name = $request->name;
        $church->added_by = $request->added_by;
        $church->description = $request->description;
        $church->status = $request->status;
        $church->thumbnail_img = $request->thumbnail_img;
        $church->save();

        flash(translate('Church has been inserted successfully'))->success();



        return redirect()->route('church.index');
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
        return view('backend.church.edit', compact('church'));
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

        $church = Church::findOrFail($id);
        $church->name = $request->name;
        $church->added_by = 'admin';
        $church->description = $request->description;
        $church->status = $request->status;
        $church->thumbnail_img = $request->thumbnail_img;
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
}
