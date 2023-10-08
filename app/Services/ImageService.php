<?php

namespace App\Services;

use App\Interfaces\DidInterfaces\ImageInterface;
use App\Models\Image;
use GuzzleHttp\Client;

class ImageService implements ImageInterface
{

    private $apiKey;
    private const URL = 'https://api.d-id.com/images';

    function __construct()
    {
        $this->apiKey = env('D_ID_API_KEY', 'bWlndWVsanBweEBnbWFpbC5jb20:XdCRyTbi5PC9Z0rMef5GA');
    }

    public function uploadImage(String $path)
    {
        $client = new Client();
        $response = $client->request('POST', self::URL, [
            'multipart' => [
                [
                    'name' => 'image',
                    'filename' => 'perfil.jpg',
                    'contents' => fopen($path, 'r'),
                    'headers' => [
                        'Content-Type' => 'image/jpeg'
                    ]
                ]
            ],
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $this->apiKey,
            ],
        ]);
        return $response->getBody();
    }

    public function deleteImage(String $id)
    {
    }
}
