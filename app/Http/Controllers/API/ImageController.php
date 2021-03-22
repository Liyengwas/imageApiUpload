<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource as ImageResource;

class ImageController extends Controller
{
    protected $image;

    public function _construct(Image $image)
    {
        $this->image = $image;
    }

    public function index()
    {
        $images = ImageResource::collection(Image::all());

        return $images;
    }

    /**
     * Upload a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'fileName' => 'required|mimes:doc,docx,pdf,txt,csv,jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 401);
        }

        if ($file = $request->file('fileName')) {
            $path = $file->store('public/images');
            $title = $file->getClientOriginalName();

            //store your file into directory and db
            $save = new Image();
            $save->title = $file;
            $save->path = $path;
            $save->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file,
            ]);

        }

    }

    public function getAllImages(Request $request)
    {

        return $this->image->getImageStringAttribute($request->id);

    }

}
