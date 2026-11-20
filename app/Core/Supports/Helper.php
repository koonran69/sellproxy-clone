<?php

use App\Core\Facades\Utilities;
use App\Models\Setting;
use Illuminate\Support\Str;

if (! function_exists('uniqid_real')) {
    function uniqid_real($lenght = 13)
    {
        return (string) Str::ulid();
//        // uniqid gives 13 chars, but you could adjust it to your needs.
//        if (function_exists("random_bytes")) {
//            $bytes = random_bytes(ceil($lenght / 2));
//        } elseif (function_exists("openssl_random_pseudo_bytes")) {
//            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
//        } else {
//            throw new \Exception("no cryptographically secure random function available");
//        }
//        return Str::upper(substr(bin2hex($bytes), 0, $lenght));
    }
}

if (! function_exists('format_price')) {
    function format_price($price, $positionCurrent = '')
    {
        if ($positionCurrent == '') {
            $positionCurrent = config('core.format.position_currency');
        }
        return $positionCurrent == 'left' ? config('core.currency') . number_format($price) : number_format($price) . config('core.currency');
    }
}

if (!function_exists('convert_vnd_to_usd')) {
    function convert_vnd_to_usd($amount, $exchangeRate = null)
    {
        if ($exchangeRate === null) {
            $exchangeRate = Setting::getValue('crypto_exchange_rate');
            if (empty($exchangeRate)) {
                $exchangeRate = 22000;
            }
        }
        $usd = $amount / $exchangeRate;
        return number_format($usd, 2, '.', ',') . '$';
    }
}

if (!function_exists('convert_vnd_to_usd_non_format')) {
    function convert_vnd_to_usd_non_format($amount, $exchangeRate = null)
    {
        if ($exchangeRate === null) {
            $exchangeRate = Setting::getValue('crypto_exchange_rate');
            if (empty($exchangeRate)) {
                $exchangeRate = 22000;
            }
        }
        return round($amount / $exchangeRate, 2);
    }
}


if (! function_exists('format_timestamp')) {
    function format_timestamp($timestamp, $format = null)
    {
        if ($timestamp) {
            $format = $format ?: config('core.format.datetime');
            return date($format, (int) $timestamp);
        }
        return null;
    }
}

if (! function_exists('format_date')) {
    function format_date($date, $format = null)
    {
        if ($date) {
            $format = $format ?: config('core.format.date');
            return date($format, strtotime($date));
        }
        return null;
    }
}

if (! function_exists('format_datetime')) {
    function format_datetime($datetime, $format = null)
    {
        if ($datetime) {
            $format = $format ?: config('core.format.datetime');
            return date($format, strtotime($datetime));
        }
        return null;
    }
}

if (! function_exists('utilities')) {
    function utilities(): Utilities
    {
        return app('utilities');
    }
}

if (! function_exists('generate_text_depth_tree')) {
    /**
     * Tạo text theo độ sâu.
     *
     * @param integer $depth
     */
    function generate_text_depth_tree($depth, $word = '-')
    {
        $text = '';
        if ($depth > 0) {
            for ($i = 0; $i < $depth; $i++) {
                $text .= $word;
            }
        }
        return $text;
    }
}
