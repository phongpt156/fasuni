<?php

namespace App\Utility;

use Tinify;
use Intervention\Image\ImageManager as Image;

class ImageUtility
{
    private const API_KEY = 'HKMS4B7gBoTfa4ASZlylTuDRs1SjX5XN';

    public static function compress($source, $destination)
    {
        Tinify\setKey(self::API_KEY);
        Tinify\fromFile($source)->toFile($destination);
    }

    public static function resize($imagePath, $destination)
    {
        $source = config('path.images') . $imagePath;

        $smPath = $destination . 'sm' . DIRECTORY_SEPARATOR . $imagePath;
        $mdPath = $destination . 'md' . DIRECTORY_SEPARATOR . $imagePath;
        $lgPath = $destination . 'lg' . DIRECTORY_SEPARATOR . $imagePath;
        $thumbnailPath = $destination . 'thumbnail' . DIRECTORY_SEPARATOR . $imagePath;

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
}
