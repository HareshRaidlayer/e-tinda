<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FacebookService
{
    protected $client;
    protected $pageAccessToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://graph.facebook.com/v14.0/',
        ]);

        $this->pageAccessToken = config('services.facebook.EAAc0Nde8PN8BO4EyV5Ss6tZA7ic3iAiJ1NeWG7ZCvUHloxyxZCoqZCyTLELvtgMFvJ1vpbZCUZCueCnwDy1Oelt0GnDZC1aFcaUoJ26Auom1mJpebf7MdJOOF7nkvIYbFeW1UprnPbTP8KLgMjTi2AVM6qNaJwyZAuTcQZAPiCPmeo1WVW0LNNvvCd8aXZBhlj8ZCmhZAZCzdZAZA46FZAmr3dWWJHXuLyTFjZASOrl7mfHklYwkAKrrHtkB2YUoq');
    }

    public function postProduct($message, $link, $imageUrl)
    {
        try {
            $response = $this->client->post('https://graph.facebook.com/me/feed', [
                'form_params' => [
                    'message' => $message,
                    'link' => $link,
                    'picture' => $imageUrl,
                    'access_token' => $this->pageAccessToken,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
            return ['error' => $responseBody];
        }
    }
}
