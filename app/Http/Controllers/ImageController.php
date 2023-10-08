<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    private $imageService;

    function __construct()
    {
        $this->imageService = new ImageService;
    }

    public function index()
    {
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $response = $this->imageService->uploadImage($request->file('image')->getPathname());
            // dd($response);
            $response = json_decode($response); 
           
            if ($response) {
                
                $path = Storage::disk('public')->put('avatars', $request->image);
                // dd($path);
                $image = new Image();
                $image->name = $request->name;
                $image->description = $request->description;
                $image->image_id = $response->id;
                $image->image_uri = $response->url;
                $image->image_path = $path;
                $image->save();
            }

            return redirect()->back()->with('message', 'Se agrego una imagen correctamente');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ocurrio un error: ' . $th->getMessage());
        }
    }
}
