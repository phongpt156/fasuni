<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class BranchService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll($page = 1)
    {
        $perPage = 100;
        $current = ($page - 1) * $perPage + 1;

        try {
            $response = $this->httpClient->get('branches?pageSize=' . $perPage . '&includeRemoveIds=true&orderBy=createdDate&orderDirection=asc&currentItem=' . $current);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error('Cannot get branches: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get branches: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            } else {
                response()->json(['error' => 'Cannot get branches: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }
}
