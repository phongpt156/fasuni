<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Intervention\Image\ImageManager as Image;
use App\Jobs\CompressImage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $path = config('path.images') . $request->file->getClientOriginalName();
        (new Image)->make($request->file)->save($path);

        Queue::push(new CompressImage($path, $path));

        return response()->json(['url' => $request->file->getClientOriginalName()], 200);
    }
}
