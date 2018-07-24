<?php

namespace App\Http\Services\KiotViet;

use App\Exceptions\HttpClient\RequestException;
use App\Http\HttpClient\HttpClient;

class KiotVietService
{
    private const NAME = 'KiotViet';
    private const RETAILER = 'fasuni';
    private const API_BASE = 'https://public.kiotapi.com';
    private const TOKEN_URI = 'https://id.kiotviet.vn/connect/token';
    private $clientId;
    private $clientSecret;
    private $httpClient;
    private $accessTokenHttpClient;
    private $accesstoken;

    public function __construct()
    {
        $this->clientId = env('KIOTVIET_CLIENT_ID');
        $this->clientSecret = env('KIOTVIET_CLIENT_SECRET');

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
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret
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
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Can\'t get access token: ' . $e->getMessage());
            die('Cant\'t get access token: ' . $e->getMessage());
        }
    }

    public function getLocations()
    {
        $options = [
            'base_uri' => 'https://fasuni.kiotviet.vn/api/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('KIOTVIET_AUTHORIZATION_BEARER')
            ]
        ];

        $client = new HttpClient($options);

        try {
            $response = $client->get('locations');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Can\'t get locations: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getWards()
    {
        $options = [
            'base_uri' => 'https://fasuni.kiotviet.vn/api/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('KIOTVIET_AUTHORIZATION_BEARER')
            ]
        ];

        $client = new HttpClient($options);

        try {
            $response = $client->get('wards');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Can\'t get wards: ' . $e->getMessage());
            throw $e;
        }
    }
}
