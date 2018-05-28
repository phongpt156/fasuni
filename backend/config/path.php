<?php

$storage = app()->basePath() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR;
$images = $storage . 'app' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

return [
    'storage' => $storage,
    'images' => $images
];