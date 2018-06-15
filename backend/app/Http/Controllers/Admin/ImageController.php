<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Intervention\Image\ImageManager as Image;
use App\Utility\ImageUtility;
use App\Utility\FileUtility;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        ini_set('max_execution_time', 0);

        if ($request->has('file')) {
            $formatFileName = FileUtility::getFormatFileName($request->file);
            $path = config('path.image.collection') . $formatFileName;

            File::put($path, File::get($request->file));
            ImageUtility::compress($path, $path);

            return response()->json(['url' => $formatFileName], 200);
        }

        return response()->json(['error' => 'File not found!'], 500);
    }

    public function uploadCollection(Request $request)
    {
        ini_set('max_execution_time', 0);

        if ($request->has('file')) {
            $formatFileName = FileUtility::getFormatFileName($request->file);
            $path = config('path.image.collection') . $formatFileName;

            File::put($path, File::get($request->file));
            ImageUtility::compress($path, $path);

            return response()->json(['url' => $formatFileName], 200);
        }

        return response()->json(['error' => 'File not found!'], 500);
    }

    public function uploadLookbook(Request $request)
    {
        ini_set('max_execution_time', 0);

        if ($request->has('file')) {
            $formatFileName = FileUtility::getFormatFileName($request->file);
            $path = config('path.image.lookbook') . $formatFileName;

            File::put($path, File::get($request->file));
            ImageUtility::compress($path, $path);

            return response()->json(['url' => $formatFileName], 200);
        }

        return response()->json(['error' => 'File not found!'], 500);
    }

    public function delete($url)
    {
        $path = config('path.image.base') . $url;
        $path = urldecode($path);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
