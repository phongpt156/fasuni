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

    public function getAll($page = 1)
    {
        $perPage = 100;
        $current = ($page - 1) * $perPage;

        try {
            $response = $this->httpClient->get('users?pageSize=' . $perPage . '&orderBy=createdDate&orderDirection=Asc&includeRemoveIds=true&currentItem=' . $current);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot get employees: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get employees: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            } else {
                response()->json(['error' => 'Cannot get employees: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }
}
