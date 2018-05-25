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

    public function deleteAll()
    {
        try {
            $response = $this->httpClient->get('webhooks');
            $response = json_decode($response->getBody()->getContents());

            $webhooks = $response->data;

            foreach ($webhooks as $webhook) {
                try {
                    $this->httpClient->delete('webhooks/' . $webhook->id);
                } catch (RequestException $e) {
                    \Log::error(['error' => 'Cannot delete webhook: ' . $e->getMessage()]);
                    if (is_object(json_decode($e->getMessage()))) {
                        response()->json(['error' => 'Cannot delete webhook: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
                    } else {
                        response()->json(['error' => 'Cannot delete webhook: ' . $e->getMessage()], 500)->send();
                    }

                    die;
                }
            }
        } catch (RequestException $e) {
            \Log::error(['error' => 'Cannot get webhooks: ' . $e->getMessage()]);
            if (is_object(json_decode($e->getMessage()))) {
                response()->json(['error' => 'Cannot get webhooks: ' . json_decode($e->getMessage())->ResponseStatus->Message], 500)->send();
            } else {
                response()->json(['error' => 'Cannot get webhooks: ' . $e->getMessage()], 500)->send();
            }

            die;
        }
    }
}
