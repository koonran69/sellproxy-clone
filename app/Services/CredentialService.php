<?php

namespace App\Services;

use Illuminate\Support\Str;

class CredentialService
{
    public function makeUsername(string $provider, int $len = 12): string
    {
        $len = max(6, $len);
        $prefix = Str::lower(substr(preg_replace('/[^a-zA-Z]/', '', $provider), 0, 3)) ?: 'usr';

        $suffix = Str::lower(Str::random(max(4, $len - (strlen($prefix) + 8))));
        return $prefix . '_' . now()->format('ymd') . '_' . $suffix;
    }

    public function makePassword(?int $len = null): string
    {
        $min = (int) config('proxy_static.password_min_len', 9);
        $len = max($min, (int) ($len ?: config('proxy_static.password_default_len', 12)));

        $sets = [
            'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'lower' => 'abcdefghijklmnopqrstuvwxyz',
            'digit' => '0123456789',
            'spec'  => '@#$%!?-_=+',
        ];

        $pwd = [];
        foreach ($sets as $s) {
            $pwd[] = $s[random_int(0, strlen($s) - 1)];
        }

        $all = implode('', $sets);
        for ($i = count($pwd); $i < $len; $i++) {
            $pwd[] = $all[random_int(0, strlen($all) - 1)];
        }

        for ($i = 0; $i < $len; $i++) {
            $j = random_int(0, $len - 1);
            [$pwd[$i], $pwd[$j]] = [$pwd[$j], $pwd[$i]];
        }
        return implode('', $pwd);
    }
}