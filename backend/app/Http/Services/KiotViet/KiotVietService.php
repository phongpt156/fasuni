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
            \Log::debug('Can\'t get access token: ' . $e->getMessage());
            die('Cant\'t get access token: ' . $e->getMessage());
        }
    }

    public function getLocations()
    {
        $options = [
            'base_uri' => 'https://fasuni.kiotviet.vn/api/',
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJSU0EtT0FFUCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJraWQiOiJ3WGEifQ.nWhgCqHuIGKfu2AQhtZ3CFV5C3Bpnx4wQ1UAeqAMsrKdGrKMywIUHDFiprIS1XJT9VgFaMJZDxEvOJxTK85UiEHxQHhlrHJIosIhWmJjhx-rtLPiiZ94SpmVA9RiKvPj3FjMdVuVO-cG_h62Xb_rU0sTDF87HLzhSAjz3-twxhXoj97GhR14hX8fff9XK909xWWy8DRruFOtoN0-gz4nuWPglO35c5Xn65d7iU1rJRS7KFrSA-LMbw7q8iKkkUj4Cc0VLB4e-FX2VgbqIzNyFGNGL-za5b-3TdlYChgWfeKhvSuxn26inq3dB7N5TmTms0_Mi9j7g0_SS0YshqgIjA.piqXNxKlUZrDSBMNLLJQJA.pMjsplSKShQPHde2vLFCnZyNFyvHUgBJhM8FNaoDWwN7CUNonssKnhM-VXa69xp9gFeicv7J4UiY5U9383T7fPT6Yd6lg1wHcPkkMCwvFcsiZcMgMTyztgZupXOBY78YJ9rkvZwj4VZfbJkRL53YB_ZceMRYhhCgVGPHS9ZWB5q6OD-mE8ADs_YXbTDFIE_ahK1GlQXnfEj62JNEO7tqJgeJN4EB_muGn-iMxs2cZFCknWWSrTAvxL_lYOz_iQeH3FSvcR8Epb5VxA405FEhnS9QXECAxJR1GMm7TV1m5bkA2NSwMafGLJYuP2J_biKOWQUaKXtm7CPWIoiXd9Z3VnilFiUzxmB6TOuyD8BSam9tP24eD_IzmLfx4A1R_tGrQxZIyHZKKBuv5VJIPWVq7ZbM0RUPPRc6lmCZzUsvFY9QZcmsm9X7NUlqaKjHCdKSsoRMC-7O42PKQ-kVAduVN3eeeaW_W1FgGV3DkhgopqQ0WZSaIotWZhy6MN40h0cz.OP5XZ1E0UCjtUQURiWcjtl_d0wab1Z_POCPcO0DhZ1Y'
            ]
        ];

        $client = new HttpClient($options);

        try {
            $response = $client->get('locations');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get locations: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getWards()
    {
        $options = [
            'base_uri' => 'https://fasuni.kiotviet.vn/api/',
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJSU0EtT0FFUCIsImVuYyI6IkExMjhDQkMtSFMyNTYiLCJraWQiOiJ3WGEifQ.nWhgCqHuIGKfu2AQhtZ3CFV5C3Bpnx4wQ1UAeqAMsrKdGrKMywIUHDFiprIS1XJT9VgFaMJZDxEvOJxTK85UiEHxQHhlrHJIosIhWmJjhx-rtLPiiZ94SpmVA9RiKvPj3FjMdVuVO-cG_h62Xb_rU0sTDF87HLzhSAjz3-twxhXoj97GhR14hX8fff9XK909xWWy8DRruFOtoN0-gz4nuWPglO35c5Xn65d7iU1rJRS7KFrSA-LMbw7q8iKkkUj4Cc0VLB4e-FX2VgbqIzNyFGNGL-za5b-3TdlYChgWfeKhvSuxn26inq3dB7N5TmTms0_Mi9j7g0_SS0YshqgIjA.piqXNxKlUZrDSBMNLLJQJA.pMjsplSKShQPHde2vLFCnZyNFyvHUgBJhM8FNaoDWwN7CUNonssKnhM-VXa69xp9gFeicv7J4UiY5U9383T7fPT6Yd6lg1wHcPkkMCwvFcsiZcMgMTyztgZupXOBY78YJ9rkvZwj4VZfbJkRL53YB_ZceMRYhhCgVGPHS9ZWB5q6OD-mE8ADs_YXbTDFIE_ahK1GlQXnfEj62JNEO7tqJgeJN4EB_muGn-iMxs2cZFCknWWSrTAvxL_lYOz_iQeH3FSvcR8Epb5VxA405FEhnS9QXECAxJR1GMm7TV1m5bkA2NSwMafGLJYuP2J_biKOWQUaKXtm7CPWIoiXd9Z3VnilFiUzxmB6TOuyD8BSam9tP24eD_IzmLfx4A1R_tGrQxZIyHZKKBuv5VJIPWVq7ZbM0RUPPRc6lmCZzUsvFY9QZcmsm9X7NUlqaKjHCdKSsoRMC-7O42PKQ-kVAduVN3eeeaW_W1FgGV3DkhgopqQ0WZSaIotWZhy6MN40h0cz.OP5XZ1E0UCjtUQURiWcjtl_d0wab1Z_POCPcO0DhZ1Y'
            ]
        ];

        $client = new HttpClient($options);

        try {
            $response = $client->get('wards');

            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            return $response;
        } catch (RequestException $e) {
            \Log::debug('Can\'t get wards: ' . $e->getMessage());
            throw $e;
        }
    }
}
