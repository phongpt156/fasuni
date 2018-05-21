<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class OrderService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        $response = $this->httpClient->get('orders?includePayment=true&orderBy=createdDate&orderDirection=Asc');

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response->data;
    }
}
