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

    public function getAll($page = 1)
    {
        $perPage = 100;
        $current = ($page - 1) * $perPage;

        try {
            $response = $this->httpClient->get('categories?pageSize=' . $perPage . '&hierachicalData=true&orderBy=createdDate&orderDirection=asc&currentItem=' . $current);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error('Cannot get categories: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get categories: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500);
            } else {
                response()->json(['error' => 'Cannot get categories: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }

    public function getOne($id)
    {
        $response = $this->httpClient->get('categories/' . $id);

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }
}
