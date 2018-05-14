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
        try {
            $response = $this->httpClient->get('products?pageSize=100&includeRemoveIds=true&includeInventory=true');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->data;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get products: ' . $e->getMessage());
            die('Cant\'t get products ' . $e->getMessage());
        }
    }

    public function getOne($id)
    {
        try {
            $response = $this->httpClient->get('products/' . $id);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get products: ' . $e->getMessage());
            die('Cant\'t get products ' . $e->getMessage());
        }
    }
}
