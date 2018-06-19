<?php

namespace App\Utility;

use Tinify;
use Intervention\Image\ImageManager as Image;
use Illuminate\Support\Facades\File;

class ImageUtility
{
    public static function compress($source, $destination)
    {
        $apiKey = env('TINYPNG_API_KEY');

        Tinify\setKey($apiKey);
        Tinify\fromFile($source)->toFile($destination);
    }

    public static function resize($source, $destination)
    {
        $fileName = File::name($source) . '.' . File::extension($source);

        $smPath = $destination . 'sm' . DIRECTORY_SEPARATOR . $fileName;
        $mdPath = $destination . 'md' . DIRECTORY_SEPARATOR . $fileName;
        $lgPath = $destination . 'lg' . DIRECTORY_SEPARATOR . $fileName;
        $thumbnailPath = $destination . 'thumbnail' . DIRECTORY_SEPARATOR . $fileName;

        $image = new Image;

        // save sm image
        $image->make($source)->resize(320, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($smPath);

        // save md image
        $image->make($source)->resize(640, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($mdPath);

        // save lg image
        $image->make($source)->resize(1024, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($lgPath);

        // save thumbnail image
        $image->make($source)->resize(75, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailPath);
    }

    public static function isTooBig($file)
    {
        return (new Image)->make($file)->width() > 1200;
    }

    public static function save($file, $path)
    {
        $image = new Image;

        if (self::isTooBig($file)) {
            $image->make($file)->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);
        } else {
            $image->make($file)->save();
        }
    }
}
