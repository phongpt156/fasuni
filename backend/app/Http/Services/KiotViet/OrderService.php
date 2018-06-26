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

    public function getAll($page = 1)
    {
        $perPage = 100;
        $current = ($page - 1) * $perPage;

        try {
            $response = $this->httpClient->get('orders?pageSize=' . $perPage . '&includePayment=true&orderBy=createdDate&orderDirection=Asc&currentItem=' . $current);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot get orders: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get orders: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            } else {
                response()->json(['error' => 'Cannot get orders: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }

    public function create($payload)
    {
        try {
            $response = $this->httpClient->post('orders', [
                'json' => $payload
            ]);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            $message = $e->getMessage();

            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot create order: ' . $message);
            if (is_object(json_decode($message))) {
                if (isset($message->ResponseStatus)) {
                    response()->json(['error' => 'Cannot create order: ' . json_decode($message)->ResponseStatus->Message], 500)->send();
                } else {
                    response()->json(['error' => 'Cannot create order: ' . json_decode($message)->responseStatus->message], 500)->send();
                }
            } else {
                response()->json(['error' => 'Cannot create order: ' . $message], 500)->send();
            }

            die;
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->httpClient->delete('orders/' . $id);

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            $message = $e->getMessage();

            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Cannot delete order: ' . $message);
            if (is_object(json_decode($message))) {
                if (isset($message->ResponseStatus)) {
                    response()->json(['error' => 'Cannot delete order: ' . json_decode($message)->ResponseStatus->Message], 500)->send();
                } else {
                    response()->json(['error' => 'Cannot delete order: ' . json_decode($message)->responseStatus->message], 500)->send();
                }
            } else {
                response()->json(['error' => 'Cannot delete order: ' . $message], 500)->send();
            }

            die;
        } 
    }
}
