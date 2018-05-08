<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;

class CategoryService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        try {
            $response = $this->httpClient->get('categories?pageSize=100&hierachicalData=true');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->data;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get categories: ' . $e->getMessage());
            die('Cant\'t get categories ' . $e->getMessage());
        }
    }
}
