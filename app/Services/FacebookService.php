<?php
namespace App\Services;

use Facebook\Facebook;
use Illuminate\Support\Facades\Log; // Import Log
use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => '2027730694323423',
            'app_secret' => '2d159a33db20b57dff7c712d70d12373',
            'default_graph_version' => 'v12.0',
        ]);
    }

    public function addProduct($catalogId, $productData)
    {
        try {
            $response = $this->fb->post(
                "/{$catalogId}/products",$productData, 'EAAc0Nde8PN8BO4EyV5Ss6tZA7ic3iAiJ1NeWG7ZCvUHloxyxZCoqZCyTLELvtgMFvJ1vpbZCUZCueCnwDy1Oelt0GnDZC1aFcaUoJ26Auom1mJpebf7MdJOOF7nkvIYbFeW1UprnPbTP8KLgMjTi2AVM6qNaJwyZAuTcQZAPiCPmeo1WVW0LNNvvCd8aXZBhlj8ZCmhZAZCzdZAZA46FZAmr3dWWJHXuLyTFjZASOrl7mfHklYwkAKrrHtkB2YUoq');

            return $response->getGraphNode()->asArray();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // Handle Graph API errors
            return ['error' => $e->getMessage()];
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK errors
            return ['error' => $e->getMessage()];
        }
    }

}
?>
