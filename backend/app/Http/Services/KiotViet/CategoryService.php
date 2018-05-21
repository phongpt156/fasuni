<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class CategoryService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        $response = $this->httpClient->get('categories?pageSize=100&hierachicalData=true&orderBy=createdDate&orderDirection=asc');

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response->data;
    }
}
