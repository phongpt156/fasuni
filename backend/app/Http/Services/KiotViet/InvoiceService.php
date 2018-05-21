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
        $response = $this->httpClient->get('invoices?pageSize=100&includePayment=true&includeOrderDelivery=true');

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response->data;
    }
}
