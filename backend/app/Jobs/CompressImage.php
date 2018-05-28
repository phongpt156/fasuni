<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Tinify;

class CompressImage extends Job
{
    private const API_KEY = 'HKMS4B7gBoTfa4ASZlylTuDRs1SjX5XN';
    private $source;
    private $destination;

    public function __construct($source, $destination)
    {
        $this->source = $source;
        $this->destination = $destination;
    }

    public function handle()
    {
        Tinify\setKey(self::API_KEY);
        Tinify\fromFile($this->source)->toFile($this->destination);
    }
}