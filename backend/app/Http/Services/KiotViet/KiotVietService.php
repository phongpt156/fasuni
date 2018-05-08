<?php

namespace App\Http\Services\KiotViet;

use App\Exceptions\HttpClient\RequestException;
use App\Http\HttpClient\HttpClient;

class KiotVietService
{
    private const NAME = 'KiotViet';
    private const RETAILER = 'abcdefghijkl';
    private const API_BASE = 'https://public.kiotapi.com';
    private const TOKEN_URI = 'https://id.kiotviet.vn/connect/token';
    private const CLIENT_ID = '56cf0157-1f94-4e49-9505-45647a50eeb9';
    private const CLIENT_SECRET = '3DB23B827F5F3104667FEBB72A2C79D7BCBA53C8';
    private $httpClient;
    private $accessTokenHttpClient;
    private $accesstoken;

    public function __construct()
    {
        $this->accessTokenHttpClient = $this->getAccessTokenHttpClient();
        $this->accessToken = $this->getAccessToken();

        $this->httpClient = $this->getHttpClient();
    }

    public function __get($name)
    {
        $name = ucfirst($name);
        $serviceName = '\App\Http\Services\KiotViet\\' . $name;

        $service = new $serviceName($this->httpClient);

        return $service;
    }

    public function getHttpClient()
    {
        $options = [
            'base_uri' => self::API_BASE,
            'headers' => [
                'Retailer' => self::RETAILER,
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ];

        $client = new HttpClient($options);

        return $client;
    }

    public function getAccessTokenHttpClient()
    {
        $options = [
            'base_uri' => self::TOKEN_URI,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENT_SECRET
            ]
        ];

        $client = new HttpClient($options);

        return $client;
    }

    public function getAccessToken()
    {
        try {
            $response = $this->accessTokenHttpClient->post('token');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response->access_token;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get access token: ' . $e->getMessage());
            die('Cant\'t get access token: ' . $e->getMessage());
        }
    }
}
