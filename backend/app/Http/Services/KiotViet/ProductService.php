<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class ProductService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        $response = $this->httpClient->get('products?pageSize=100&includeRemoveIds=true&includeInventory=true');

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response->data;
    }

    public function getOne($id)
    {
        $response = $this->httpClient->get('products/' . $id);

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }
}
