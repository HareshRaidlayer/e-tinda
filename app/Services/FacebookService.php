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
            'app_id' => '1651679405677029',
            'app_secret' => 'a693c8f3331bf0c52e53c0d4a2fa5fc4',
            'default_graph_version' => 'v12.0',
        ]);
    }

    public function addProduct($catalogId, $productData)
    {
        try {
            $response = $this->fb->post(
                "/{$catalogId}/products",
                $productData, 'EAAXeMZARCGeUBOy9mk2IbxBs2DVDNnlAqdKXW1qwshiyoQSscZBokZC4nb8Lwqqcp5QjHwJNPMrhpQrQS0BEpA9AH86PTEoXZAzHehk9Y85llrQrYvVkPFH4je8R2P0YI4D5dZAM0kxMTJIAvP2vE0qqoiJE391hxulJbDkzrRKELcZC092hsg69X3');

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
