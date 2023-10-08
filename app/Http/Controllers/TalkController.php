<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Talk;
use App\Services\TalkService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use RuntimeException;

class TalkController extends Controller
{

    private const URL = 'https://api.d-id.com/talks/';

    private $talkService;

    function __construct()
    {
        $this->talkService = new TalkService;
    }

    public function index()
    {
       
            // $inputVideoPath = storage_path('app/public/videos/p6fe5hcOk3gRNeR1.mp4');
            // // dd($inputVideoPath);
            // // Ruta donde se guardará el video convertido
            // $outputVideoPath = storage_path('app/public/videos/salida.mp4');

            // // Inicializa la instancia de FFMpeg
            // $ffmpeg = FFMpeg::create([
            //     'ffmpeg.binaries' => 'D:\Programas\ffmpeg-master-latest-win64-gpl\bin\ffmpeg.exe',
            //     'ffprobe.binaries' => 'D:\Programas\ffmpeg-master-latest-win64-gpl\bin\ffprobe.exe',
            //     'ffplay.binaries' => 'D:\Programas\ffmpeg-master-latest-win64-gpl\bin\ffplay.exe',
            // ]);

            // // Abre el video de entrada
            // $video = $ffmpeg->open($inputVideoPath);

            // // Define el formato de salida (X264)
            // $format = new X264();
            // $format->setVideoCodec('libx264');
            // $format->setAudioCodec('aac');
            // $format->setAdditionalParameters(['-crf', '23', '-strict', 'experimental', '-y']);
            // // Codifica y guarda el video convertido
            // $video->save($format, $outputVideoPath);

            // return "Conversión completada. Puedes descargar el video convertido desde /videos/output.mp4";
        
        $talks = Talk::all();
        return view('talk.index', compact('talks'));
    }

    public function apilist()
    {
        $apiKey = 'bWlndWVsanBweEBnbWFpbC5jb20:fz0KoxeLqdcCDp3BcVxI5';
        $client = new Client();

        try {
            $response = $client->get(TalkController::URL, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                ],
            ]);
            $data = json_decode($response->getBody()->getContents());
            $data = $data->talks;
            // $data = $response->getBody()->getContents();
            // dd($data);
            return view('welcome', compact('data'));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return "Ocurrio un error";
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            return "Ocurrio un error";
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return "Ocurrio un error";
        }
        return "Ocurrio un error";
    }

    public function makevideo(Request $request)
    {
        // dd($request->imagen_path);

        // $apiKey = 'cGVkcm8yMmVucmlxdUBnbWFpbC5jb20:dUpX_IRXKN6_0ZSPmKCkO';
        $apiKey = 'bWlndWVsanBweEBnbWFpbC5jb20:XdCRyTbi5PC9Z0rMef5GA';
        $client = new Client();
        $response = $client->request('POST', 'https://api.d-id.com/images', [
            'multipart' => [
                [
                    'name' => 'image',
                    'filename' => 'perfil.jpg',
                    'contents' => fopen($request->file('imagen_path')->getPathname(), 'r'),
                    'headers' => [
                        'Content-Type' => 'image/jpeg'
                    ]
                ]
            ],
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $apiKey,
            ],
        ]);

        dd($response->getBody());

        $body = [
            "script" => [
                "type" => "text",
                "input" => $request->content,
                "provider" => [
                    "type" => "microsoft",
                    "voice_id" => "es-BO-MarceloNeural",
                    "voice_config" => [
                        "style" => "Cheerful"
                    ]
                ]
            ],
            "name" => $request->title,
            "source_url" => json_decode($response->getBody())->url,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':')
        ])->post(TalkController::URL, $body);

        $respuestaApi = $response->json();

        dd($respuestaApi);

        return json_decode($respuestaApi);

        // return redirect()->back()->with('response', $respuestaApi);


        // $url = 'https://d-id-talks-prod.s3.us-west-2.amazonaws.com/google-oauth2%7C108744935008221043714/tlk_gLiN29AGsk4gk6QNKwfwT/1691131022247.mp4?AWSAccessKeyId=AKIA5CUMPJBIK65W6FGA&Expires=1691217428&Signature=fsaob9Q1lfNjF2hneFhf47vJO44%3D&X-Amzn-Trace-Id=Root%3D1-64cc9c94-17b15a0052d6991275c35b90%3BParent%3D9bc62f888ae81e75%3BSampled%3D1%3BLineage%3D6b931dd4%3A0'; // Reemplaza por la URL real del video a descargar
        // $nombreArchivo = round(microtime(true)) . '_' . Str::random(8) . '.mp4';

        // $rutaDestino = 'public/videos/' . $nombreArchivo;

        // $ch = curl_init($url);
        // $fp = fopen(storage_path('app/' . $rutaDestino), 'wb');
        // curl_setopt($ch, CURLOPT_FILE, $fp);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_exec($ch);
        // curl_close($ch);
        // fclose($fp);

        // return response()->download(storage_path('app/' . $rutaDestino), $nombreArchivo);
    }

    public function create()
    {
        $images = Image::all();
        $voices = json_decode($this->talkService->getVoices());
        usort($voices, function ($a, $b) {
            return strcmp($a->language, $b->language);
        });
        return view('talk.create', compact('images', 'voices'));
    }

    public function store(Request $request)
    {
        dd($request);
        try {
            $request->validate([
                'name' => 'required',
                'content' => 'required',
                'imageUrl' => 'required',
                'id_image' => 'required',
            ]);
            // return $request->id_image;
            $response = $this->talkService->createTalk($request->name, $request->content, $request->imageUrl, []);
            // dd($response);

            if ($response) {
                $talk = new Talk();
                $talk->name = $request->name;
                $talk->content = $request->content;
                $talk->talk_id = $response->id;

                $talk->image_id = $request->id_image;
                $talk->save();
            }

            return redirect()->back()->with('message', 'Se agrego una imagen correctamente');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }

    public function show(Talk $talk)
    {
        try {
            if ($talk->talk_path) {
                return response()->json(['path' => $talk->talk_path], 201);
            }
            
            $response = $this->talkService->getTalk($talk->talk_id);

            $response = json_decode($response);
            
            if ($response->status == 'done') {

                $url = '' . $response->result_url;
                $nombreArchivo = round(microtime(true)) . '_' . Str::random(8) . '.mp4';

                $rutaDestino = 'public/videos/' . $nombreArchivo;
                $video_path = 'videos/' . $nombreArchivo;
                $talk->talk_path = $video_path;
                $talk->update();
                // dd($talk);

                $ch = curl_init($url);
                $fp = fopen(storage_path('app/' . $rutaDestino), 'wb');
                if ($ch && $fp) {
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);

                    if (curl_exec($ch) === false) {
                        echo 'Error durante la descarga: ' . curl_error($ch);
                    } else {
                        echo 'Descarga exitosa!';

                        // Imprimir la ruta del archivo descargado
                        echo 'Ruta del archivo descargado: ' . $rutaDestino;
                    }
                    curl_close($ch);
                    fclose($fp);
                } else {
                    echo 'No se pudieron abrir los recursos necesarios.';
                }
                // return response()->download(storage_path('app/' . $rutaDestino), $nombreArchivo);

                return response()->json(['path' => $video_path], 201);
            } else {
                return response()->json(['error' => 'Aun no esta listo'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocurrio un error intentalo de nuevo'], 501);
        }
    }
}
