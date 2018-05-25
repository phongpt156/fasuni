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
        $webhooks = [
            [
                'type' => 'customer.update',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/customer/update?noecho'
            ],
            [
                'type' => 'customer.delete',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/customer/destroy?noecho'
            ],
            [
                'type' => 'product.update',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/product/update?noecho'
            ],
            [
                'type' => 'product.delete',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/product/destroy?noecho'
            ],
            [
                'type' => 'stock.update',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/inventory/update?noecho'
            ],
            [
                'type' => 'order.update',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/order/update?noecho'
            ],
            [
                'type' => 'invoice.update',
                'url' => 'http://505308fa.ngrok.io/api/admin/kiotviet/webhook/invoice/update?noecho'
            ]
        ];

        foreach ($webhooks as $webhook) {
            $options = [
                'json' => [
                    'Webhook' => [
                        'Type' => $webhook['type'],
                        'Url' => $webhook['url'],
                        'IsActive' => true
                    ]
                ]
            ];
            $response = $this->httpClient->post('webhooks', $options);

            $response = $response->getBody()->getContents();
            \Log::error($response);
            $response = json_decode($response);
        }
        
        // $response = $this->httpClient->get('webhooks');
        // $response = $response->getBody()->getContents();
        // \Log::error($response);

        // return $response->data;
    }
}
