<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class EmployeeService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        try {
            $response = $this->httpClient->get('users?pageSize=100&orderBy=createdDate&orderDirection=Asc&includeRemoveIds=true');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->data;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get employees: ' . $e->getMessage());
            die('Cant\'t get employees ' . $e->getMessage());
        }
    }
}
