<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeleketService
{
    protected $merchantUuid;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->merchantUuid = config('payment.heleket.merchant_uuid');
        $this->apiKey = config('payment.heleket.api_key');
        $this->apiUrl = config('payment.heleket.api_url');
    }

    /**
     * Tạo hóa đơn thanh toán trên Heleket
     *
     * @param float|string $amount Số tiền thanh toán
     * @param string $orderId Mã đơn hàng của hệ thống
     * @param string $currency Loại tiền tệ (mặc định USD)
     * @param string|null $toCurrency Loại tiền điện tử đích (ví dụ USDT, BTC)
     * @param string|null $network Mạng lưới (ví dụ tron, bsc)
     * @param array $urls Mảng chứa các URL (url_callback, url_success, url_return)
     * @return array|bool
     */
    public function createInvoice($amount, $orderId, $currency = 'USD', $toCurrency = null, $network = null, $urls = [])
    {
        if (empty($this->merchantUuid) || empty($this->apiKey)) {
            return [
                'state'   => 1,
                'message' => 'Chưa cấu hình thanh toán tiền điện tử (Heleket)',
            ];
        }

        $data = [
            'amount'   => (string) $amount,
            'currency' => $currency,
            'order_id' => (string) $orderId,
        ];

        if ($toCurrency) {
            $data['to_currency'] = $toCurrency;
        }

        if ($network) {
            $data['network'] = $network;
        }

        foreach (['url_callback', 'url_success', 'url_return'] as $urlKey) {
            if (isset($urls[$urlKey])) {
                $data[$urlKey] = $urls[$urlKey];
            }
        }

        $sign = $this->generateSignature($data);

        try {
            $response = Http::withHeaders([
                'merchant'     => $this->merchantUuid,
                'sign'         => $sign,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $data);

            if ($response->successful()) {
                return $response->json();
            }

            $body = $response->json();
            $apiMessage = isset($body['message']) ? $body['message'] : ('Heleket API lỗi (HTTP ' . $response->status() . ')');

            Log::error('Heleket API Error', [
                'status'   => $response->status(),
                'response' => $response->body(),
                'data'     => $data
            ]);

            return [
                'state'   => (int) ($body['state'] ?? 1),
                'message' => $apiMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Heleket Exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return [
                'state'   => 1,
                'message' => 'Lỗi kết nối: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Tạo chữ ký MD5 theo quy tắc của Heleket
     */
    protected function generateSignature(array $data)
    {
        $jsonStr = json_encode($data);
        return md5(base64_encode($jsonStr) . $this->apiKey);
    }

    /**
     * Xác minh chữ ký từ webhook
     */
    public function verifyWebhookSignature(array $data)
    {
        if (!isset($data['sign'])) {
            return false;
        }

        $receivedSign = $data['sign'];
        unset($data['sign']);

        $jsonStr = json_encode($data);
        $calculatedSign = md5(base64_encode($jsonStr) . $this->apiKey);

        return hash_equals($calculatedSign, $receivedSign);
    }
}
