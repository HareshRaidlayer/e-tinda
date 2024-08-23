<?php

namespace App\Http\Controllers;

use App\Services\FacebookService;
use App\Models\Product;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    protected $facebookCatalogService;

    public function __construct(FacebookService $facebookCatalogService)
    {
        $this->facebookCatalogService = $facebookCatalogService;
    }

    public function addProductToFacebookCatalog($productId)
    {
        // Fetch product data from your database
        // $product = Product::find($productId);

        // if (!$product) {
        //     return response()->json(['error' => 'Product not found'], 404);
        // }

        // Prepare product data for Facebook
        $productData = [
            'retailer_id' => 12,
            'name' => "Nike Men Running Shoe Revolution",
            'description' => "Nike Men Running Shoe Revolution df dflkgnj mfg ",
            'availability' => 'in stock',
            'condition' => 'new',
            'price' => 434,
            'link' => 'https://ecommerce.conscor.com/product/nike-men-running-shoe-revolution-7-lt-iron-oretotal-orange-thunder-blue-fb2207-009-6uk',
            'image_url' => 'https://ecommerce.conscor.com/public/uploads/all/sFUbKlYjoB6pskTYgZb2hBDfucclz8KanGDypKEd.png',
            'brand' => "puma",
            'visibility' => 'published',
        ];

        // Add product to Facebook catalog
        $response = $this->facebookCatalogService->addProduct('1512156563007554', $productData);

        return response()->json($response);
    }
}
