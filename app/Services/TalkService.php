<?php

namespace App\Services;

use App\Interfaces\DidInterfaces\TalkInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class TalkService implements TalkInterface
{

    private $apiKey;

    function __construct()
    {
        $this->apiKey = env('D_ID_API_KEY', 'bWlndWVsanBweEBnbWFpbC5jb20:XdCRyTbi5PC9Z0rMef5GA');
    }

    public function createTalk(String $title, String $content, String $imageUrl, array $emotions)
    {
        $body = [
            "script" => [
                "type" => "text",
                "input" => $content,
                "provider" => [
                    "type" => "microsoft",
                    "voice_id" => "es-BO-MarceloNeural",
                    "voice_config" => [
                        "style" => "Cheerful"
                    ]
                ]
            ],
            "name" => $title,
            "source_url" => $imageUrl,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
        ])->post('https://api.d-id.com/talks/', $body);

        $respuestaApi = json_decode($response);

        return $respuestaApi;
    }

    public function getTalks()
    {
    }

    public function getTalk(String $id)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.d-id.com/talks/' . $id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
            ],
        ]);

        return $response->getBody();
    }

    public function deleteTalk(String $id)
    {
    }

    public function getVoices()
    {
        $client = new Client();
        // $response = $client->get('https://api.d-id.com/tts/voices', [
        //     'headers' => [
        //         'accept' => 'application/json',
        //         'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
        //     ],
        // ]);
        $response = $client->request('GET', 'https://api.d-id.com/tts/voices', [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
            ],
        ]);
        return $response->getBody();
    }
}
