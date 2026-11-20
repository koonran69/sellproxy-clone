<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class VietQRService
{
    private $client;
    private $userName;
    private $password;
    private $apiEndPoint;
    private $bankAccount;
    private $bankCode;
    private $userBankName;

    const URL_API = 'https://api.vietqr.io/v2';

    const X_CLIENT_ID = '45a17de9-e71e-4531-a586-cbc766ef93f2';

    const X_API_KEY = '362bb4ec-878c-49a0-bcfb-090862f8cc69';

    public function __construct()
    {
        $this->client = new Client(['verify' => false,]);
        $this->username = config('payment.viet_qr.username');
        $this->password = config('payment.viet_qr.password');
        $this->apiEndPoint = config('payment.viet_qr.api_endpoint');
        $this->bankAccount = config('payment.viet_qr.bank_account');
        $this->bankCode = config('payment.viet_qr.bank_code');
        $this->userBankName = config('payment.viet_qr.user_bank_name');
    }

    public function generateQrcode($bank_account_no, $bank_account_name, $bank_account_id, $amount, $desc)
    {
        $data = [
            'accountNo' => $bank_account_no,
            'accountName' => $bank_account_name,
            'amount' => $amount,
            'acqId' => $bank_account_id,
            'addInfo' => $desc,
            'format' => 'text',
            "template" => "compact"
        ];

        $response = Http::withHeaders([
            'X-Client-Id' => self::X_CLIENT_ID,
            'X-Api-Key' => self::X_API_KEY,
        ])->post(self::URL_API . '/generate', $data);

        if($response->ok())
        {
            return $response->json();
        }

        return false;
    }

    public function generateToken()
    {
        try {
            $response = $this->client->request('POST', $this->apiEndPoint.'/token_generate', [
                'auth' => [$this->username, $this->password],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateQrCodeWithTransactionSync(string $token, int $totalPrice, string $orderCode, $content="")
    {
        try {
            $response = $this->client->request('POST', $this->apiEndPoint.'/qr/generate-customer',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                    "json" => [
                        'amount' => $totalPrice,
                        'content' => $content,
                        'bankAccount' => $this->bankAccount,
                        'bankCode' => $this->bankCode,
                        'userBankName' => $this->userBankName,
                        'transType' => "C",
                        'orderId' => $orderCode,
                        'qrType' => "0",
                    ]
                ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
