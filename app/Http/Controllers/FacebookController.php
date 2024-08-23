<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    protected $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v12.0',
        ]);
    }

    public function postProduct(Request $request)
    {
        $data = [
            'message' => $request->input('message'),
            'link' => $request->input('link'),
        ];

        try {
            $response = $this->fb->post('/me/feed', $data, env('FACEBOOK_ACCESS_TOKEN'));
            return response()->json($response->getDecodedBody());
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            return response()->json(['error' => 'Graph returned an error: ' . $e->getMessage()], 500);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json(['error' => 'Facebook SDK returned an error: ' . $e->getMessage()], 500);
        }
    }

    public function addProductToFacebookCatalog(Request $request)
{
    // Sample product data
    $data = [
        'retailer_id' => 12,
        'name' => "Nike Men Running Shoe Revolution",
        'description' => "Nike Men Running Shoe Revolution df dflkgnj mfg",
        'availability' => 'in stock',
        'condition' => 'new',
        'price' => 434,
        'link' => 'https://ecommerce.conscor.com/product/nike-men-running-shoe-revolution-7-lt-iron-oretotal-orange-thunder-blue-fb2207-009-6uk',
        'image_url' => 'https://ecommerce.conscor.com/public/uploads/all/sFUbKlYjoB6pskTYgZb2hBDfucclz8KanGDypKEd.png',
        'brand' => "puma",
        'visibility' => 'published',
    ];

    // Debugging: Log the data being sent
    \Log::info('Data being sent to Facebook:', $data);

    // Define the endpoint URL
    $url = '/catalogs/1441381003081396/products'; // Ensure this is correct

    // Access token from environment variables
    $accessToken = env('FACEBOOK_ACCESS_TOKEN');

    try {
        // Make the POST request
        $response = $this->fb->post($url, $data, $accessToken);
        $decodedBody = $response->getDecodedBody();

        // Debugging: Log the response body
        \Log::info('Response from Facebook:', $decodedBody);

        // Check if expected keys exist
        if (isset($decodedBody['id'])) {
            return response()->json($decodedBody);
        } else {
            \Log::warning('Expected key "id" does not exist in the response.');
            return response()->json(['error' => 'Unexpected response format.'], 500);
        }
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        \Log::error('Graph returned an error: ' . $e->getMessage());
        return response()->json(['error' => 'Graph returned an error: ' . $e->getMessage()], 500);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        \Log::error('Facebook SDK returned an error: ' . $e->getMessage());
        return response()->json(['error' => 'Facebook SDK returned an error: ' . $e->getMessage()], 500);
    }
}
}
