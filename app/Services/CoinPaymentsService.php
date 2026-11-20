<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoinPaymentsService
{
    protected $cps;

    public function __construct()
    {
        $this->cps = new \CoinpaymentsAPI(env('COINPAYMENTS_PRIVATE_KEY'), env('COINPAYMENTS_PUBLIC_KEY'), 'json');
    }

    /**
     * Tạo giao dịch thanh toán
     */
    public function createTransaction($amount, $currency, $email, $invoice)
    {
        // Log::info('CoinPayments CreateComplexTransaction Parameters', [
        //     'amount' => $amount,
        //     'amount_currency' => 'USD',
        //     'receive_currency' => $currency,
        //     'buyer_email' => $email,
        //     'invoice' => $invoice
        // ]);
        // $response = $this->cps->CreateSimpleTransaction($amount, $currency, $email);
        $response = $this->cps->CreateComplexTransaction($amount, "USD", $currency, $email, "", "", "", "", $invoice, "", "https://sellsocks247.com/coinpayments/ipn");
        // Log::info('CoinPayments API Response', [
        //     'full_response' => $response
        // ]);
        return $response;
    }

    public function convertVndToCrypto($vnd, $coin)
    {
        try {
            $amount_usd = convert_vnd_to_usd_non_format($vnd);
            $rates = $this->getRates();
            $usd_to_btc  = $rates['result']["USD"]['rate_btc']; // USD -> BTC
            $btc_to_coin = (string)$rates['result'][$coin]['rate_btc']; // BTC -> Coin (ETH)
            $amount_btc = bcmul($amount_usd, $usd_to_btc, 18);
            $amount_coin = bcdiv($amount_btc, $btc_to_coin, 18);
            return $amount_coin;
        } catch (\Exception $exception) {
            Log::error("exception", [$exception->getMessage()]);
            return false;
        }
    }

    public function getRates()
    {
        $key = "gate-list";
        $rates = Cache::get($key);
        if (!$rates) {
            $rates = $this->cps->GetRates();
            Cache::put($key, $rates, 3600);
        }
        return $rates;
    }
}
