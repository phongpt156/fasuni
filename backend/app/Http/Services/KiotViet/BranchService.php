<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;

class BranchService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
            $response = $this->httpClient->get('branches?pageSize=100&includeRemoveIds=true&orderBy=createdDate&orderDirection=asc');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->data;
    }
}
