<?php

namespace App\Http\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use App\Exceptions\HttpClient\RequestException;

class HttpClient
{
    private $client;

    public function __construct($options = [])
    {
        $this->client = new Client($options);
    }

    public function get($url, $options = [])
    {
        try {
            $response = $this->client->get($url, $options);

            return $response;
        } catch (GuzzleRequestException $e) {
            throw new RequestException($e->getMessage());
        }
    }

    public function post($url, $options = [])
    {
        try {
            $response = $this->client->post($url, $options);

            return $response;
        } catch (GuzzleRequestException $e) {
            throw new RequestException($e->getMessage());
        }
    }
}
