<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class CustomerService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll($page = 1)
    {
        $perPage = 100;
        $current = ($page - 1) * $perPage;

        try {
            $response = $this->httpClient->get('customers?pageSize=' . $perPage . '&includeRemoveIds=true&orderBy=createdDate&orderDirection=Asc&currentItem=' . $current);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error('Cannot get customers: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get customers: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            }

            response()->json(['error' => 'Cannot get customers: ' . $e->getMessage()], 500)->send();
            die;
        }
    }

    public function getOne($id)
    {
        $response = $this->httpClient->get('customers/' . $id);

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }
}
