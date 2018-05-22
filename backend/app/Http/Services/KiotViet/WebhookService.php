<?php

namespace App\Http\Services\KiotViet;

use App\Http\HttpClient\HttpClient;
use App\Exceptions\HttpClient\RequestException;

class WebhookService
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function register()
    {
        $options = [
            'json' => [
                'Webhook' => [
                    'Type' => 'customer',
                    'Url' => 'http://154ca4ae.ngrok.io/api/admin/webhook/callback',
                    'IsActive' => true
                ]
            ]
        ];
        $response = $this->httpClient->post('webhooks', $options);

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $response->data;
    }
}
