<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
// use Intervention\Image\Image;
use Image;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::orderBy('created_at', 'desc')->paginate(8);

        return response()->json([
            'success' => true,
            'photos' => $photos 
        ]);
    }
    public function download($filename)
    {
        $file= public_path() . "/images/" . $filename;

        $headers = array(
        'Content-Type: application/image',
        );

        return Response::download($file, $filename, $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = '';
        $data = [];
        $imageFolder = 'images';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data = exif_read_data($image);
            $imageName = time() . '.' . $image->extension();  
            $image->move(public_path($imageFolder), $imageName);
            
        } else {
            $url = $request->url;
            $image = @file_get_contents($url);
            if (!$image) {
                return response()->json([
                    'success' => false,
                    'error' => 'Image not found from the url'
                ]);
            }

            $data = exif_read_data($url);
            $imageName = time() . '.' . pathinfo($url)['extension'];
            file_put_contents(public_path($imageFolder . '/' . $imageName), $image);
        }

        $imageUrl = config('app.url') . '/' . $imageFolder. '/' . $imageName;

        $exifs = [];
        $camera = [];
        $copyrights = [];

        //TODO: refactor
        foreach ($data as $key => $item) {
            if (strpos($key, 'Undefined') !== false) {
                
            } else {
                if (in_array($key, Photo::EXCEPT_KEYS)) {
                    continue;
                }
                if (in_array($key, Photo::CAMERA_KEYS)) {
                    $camera[$key] = $item;
                    continue;
                }
                if (in_array($key, Photo::COPYRIGHT_KEYS)) {
                    $copyrights[$key] = $item;
                    continue;
                }
                $exifs[$key] = $item;
            }
            
        }

        $photo = Photo::create([
            'url' => $imageUrl,
            'camera' => json_encode($camera),
            'copyrights' => json_encode($copyrights),
            'exifs' => json_encode($exifs),
        ]);
        

        Log::info("message", ['data' => $data]);
        return response()->json([
            'success' => true,
            'photo' => $photo 
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
