<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CoinGateService
{
    protected $client;
    protected $apiKey;
    protected $environment;

    public function __construct()
    {
        $this->environment = config('coingate.environment') == 'sandbox' ? 'sandbox' : 'live';
        $this->client = new Client([
            'base_uri' => $this->getApiBaseUri(),
            'timeout' => 30,
            'verify' => $this->environment  == 'sandbox' ? false : true,
        ]);
        $this->apiKey = config('coingate.api_key');

    }

    // Lấy base URL tùy thuộc vào môi trường
    private function getApiBaseUri(): string
    {
        return $this->environment === 'sandbox'
            ? 'https://api-sandbox.coingate.com/v2/'
            : 'https://api.coingate.com/v2/';
    }

    // Tạo đơn hàng mới
    public function createOrder(array $params)
    {
        try {
            $response = $this->client->post('orders', [
                'json' => $params,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        } catch (RequestException $e) {
            // Xử lý lỗi
            $errorMessage = $e->getMessage();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $errorMessage .= ': ' . $response->getBody()->getContents();
            }
            throw new \Exception("Error creating order: " . $errorMessage);
        }
    }
}