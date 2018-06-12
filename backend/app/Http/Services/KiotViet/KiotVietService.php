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
    private const CLIENT_ID = '2a38df33-fa36-4b56-8c0e-db1b6b26531a';
    private const CLIENT_SECRET = '67499F21DE0A6695804056E6ED49E8BD49253EB1';
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
            \Log::error($e->getFile() . ' ' . $e->getLine() . ' error: Can\'t get access token: ' . $e->getMessage());
            die('Cant\'t get access token: ' . $e->getMessage());
        }
    }

    public function getLocations()
    {
        $options = [
            'base_uri' => 'https://fasuni.kiotviet.vn/api/',
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJSU0EtT0FFUCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJraWQiOiJ3WGEifQ.H_btuvpFupa_mP7DsqsIKf4YA7CBtmq0TcW0TjGrDi-uFKWCaytWmY9-wqqNUudpsGoJYRFk2A2XnWbvge4OXQZ5VCZ149Jd1my-1-fN-tffMa8j_9rvam2Kao7IDJz64vFejr_zhPpQzUgFFykZBAc6Xo_jjGubYaO2S804-sJLZ1JlemRBrnUUxt7e5Dj7-yXadZ_ynEjkB6dRFF6OMJcAQOMOxaDbsdyKD_24TyaUzb6U9SQyu1XMb5C75X8V10sSw4DkOk8_fJM4oyuRyJwSc267oStVRVinNukHynaVULVLAjvWdGkrV7Ho1h2fppdcgB9ShcaL7A_Y-dat9w.verDN2IpxK-J5mgvol8vrA.GVCb3BCuvDU4uAl8hQtDBdhi07JvZ3Fa18yExDEEh-DTu98SStrL3E17EtUZE-nVQOjQikg_ExyeqTwUab2pHQ7qlSFwLz57jteDyU3v3lk2lwY4TsUz5jgdCjRB7z9dLLboDCpnI2bfM3KNxldS91P8snZUCQIpraLxLD6IOPSPtcRwRSJwQ21xz0MuFj_oc9T6ZYWPHwYV8CvrtzJQQ4yMOUZgak5SLknCRW65d3Ck13cTKVCG0N3cUFKnjUsDDOAM8IdnhJFkP5qXe1CVhA_Ss5oCTPjHClQtNC6_tT9LB-uA1n_Lq3fySrairlWN626XfHS2pyRD-eeJ_NvJ3TF4fp3Gs1XEz-S99obx4Nk1W_xqPv01VWzQini1bMlNWdvVrfp9SP2WcaQKfmZF8Hf5lFVIudcsZul4gtp0tvHL38tVOHt2GwOHkaTFL-fuqmmIfC8CEJwHDZhaEiKERGF5RLh8TIRBrqz8c1Goad3v_yLEacspZlf2LzPUq8Ulg54NYMcqhMQiCGib7qNiWA.v910y_Nn4RoCaAuAj1sV6ScuZsfzA1X0Y13VwoeICOw'
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
                'Authorization' => 'Bearer eyJhbGciOiJSU0EtT0FFUCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJraWQiOiJ3WGEifQ.H_btuvpFupa_mP7DsqsIKf4YA7CBtmq0TcW0TjGrDi-uFKWCaytWmY9-wqqNUudpsGoJYRFk2A2XnWbvge4OXQZ5VCZ149Jd1my-1-fN-tffMa8j_9rvam2Kao7IDJz64vFejr_zhPpQzUgFFykZBAc6Xo_jjGubYaO2S804-sJLZ1JlemRBrnUUxt7e5Dj7-yXadZ_ynEjkB6dRFF6OMJcAQOMOxaDbsdyKD_24TyaUzb6U9SQyu1XMb5C75X8V10sSw4DkOk8_fJM4oyuRyJwSc267oStVRVinNukHynaVULVLAjvWdGkrV7Ho1h2fppdcgB9ShcaL7A_Y-dat9w.verDN2IpxK-J5mgvol8vrA.GVCb3BCuvDU4uAl8hQtDBdhi07JvZ3Fa18yExDEEh-DTu98SStrL3E17EtUZE-nVQOjQikg_ExyeqTwUab2pHQ7qlSFwLz57jteDyU3v3lk2lwY4TsUz5jgdCjRB7z9dLLboDCpnI2bfM3KNxldS91P8snZUCQIpraLxLD6IOPSPtcRwRSJwQ21xz0MuFj_oc9T6ZYWPHwYV8CvrtzJQQ4yMOUZgak5SLknCRW65d3Ck13cTKVCG0N3cUFKnjUsDDOAM8IdnhJFkP5qXe1CVhA_Ss5oCTPjHClQtNC6_tT9LB-uA1n_Lq3fySrairlWN626XfHS2pyRD-eeJ_NvJ3TF4fp3Gs1XEz-S99obx4Nk1W_xqPv01VWzQini1bMlNWdvVrfp9SP2WcaQKfmZF8Hf5lFVIudcsZul4gtp0tvHL38tVOHt2GwOHkaTFL-fuqmmIfC8CEJwHDZhaEiKERGF5RLh8TIRBrqz8c1Goad3v_yLEacspZlf2LzPUq8Ulg54NYMcqhMQiCGib7qNiWA.v910y_Nn4RoCaAuAj1sV6ScuZsfzA1X0Y13VwoeICOw'
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
