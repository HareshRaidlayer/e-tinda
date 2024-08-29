<?php

namespace App\Http\Controllers;

use App\Services\FacebookService;
use App\Models\Product; // Ensure you have this model
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function addProductToFacebookCatalog(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $message = $product->name . ' is now available!';
        $link = url('/products/' . $product->id);

        $imageUrl = 'http://127.0.0.1:8000/uploads/all/25wZYKOd2h6wHGg8Jd5OiAi478jktEHqx06n9HM6.jpg'; // Ensure this URL is publicly accessible

        $result = $this->facebookService->postProduct($message, $link, $imageUrl);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', 'Failed to post product to Facebook: ' . $result['error']['message']);
        }

        return redirect()->back()->with('success', 'Product posted to Facebook successfully.');
    }
}
