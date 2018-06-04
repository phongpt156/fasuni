<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Intervention\Image\ImageManager as Image;
use App\Utility\ImageUtility;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        ini_set('max_execution_time', 0);

        if ($request->has('file')) {
            $path = storage_path('app/images/' . $request->file->getClientOriginalName());

            File::put($path, File::get($request->file));
            ImageUtility::compress($path, $path);

            return response()->json(['url' => $request->file->getClientOriginalName()], 200);
        }

        return response()->json(['error' => 'File not found!'], 500);
    }

    public function delete($url)
    {
        $path = storage_path('app/images/' . $url);
        $path = urldecode($path);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
