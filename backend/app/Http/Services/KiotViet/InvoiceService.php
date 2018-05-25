<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class InvoiceService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll()
    {
        try {
            $response = $this->httpClient->get('invoices?pageSize=100&includePayment=true&includeOrderDelivery=true');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->data;
        } catch (RequestException $e) {
            \Log::error('Cannot get invoices: ' . $e->getMessage());
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get invoices: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            } else {
                response()->json(['error' => 'Cannot get invoices: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }
}
