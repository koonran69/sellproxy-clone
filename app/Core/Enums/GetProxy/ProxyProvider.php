<?php

namespace App\Core\Enums\GetProxy;

use App\Core\Supports\Enum;

enum ProxyProvider: int
{
    use Enum;

    case Abc = 1;
    case NineTwoTwo = 2;
    case Pia = 3;

    public function logo(): string
    {
        return match ($this) {
            self::Abc => asset('public/assets/images/get-proxies/abc-proxy.png'),
            self::NineTwoTwo => asset('public/assets/images/get-proxies/922-proxy.png'),
            self::Pia => asset('public/assets/images/get-proxies/pia-proxy.png'),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::Abc => 'abcproxy',
            self::NineTwoTwo => 'nicetwotwoproxy',
            self::Pia => 'piaproxy',
        };
    }

    public static function fromSlug(string $slug): ?self
    {
        return match ($slug) {
            'abcproxy' => self::Abc,
            'nicetwotwoproxy' => self::NineTwoTwo,
            'piaproxy' => self::Pia,
            default    => null,
        };
    }

    public function metadata(): array
    {
        return [
            'label'     => $this->description(),
            'slug'      => $this->slug(),
            'logo_tab'  => $this->logo(),
            'logo_card' => $this->logo(),
        ];
    }

    public static function all(): array
    {
        $array = [];
        foreach (self::cases() as $item) {
            $array[$item->value] = $item->metadata();
        }
        return $array;
    }

    public function getSessionTokenKey(): string
    {
        return "{$this->value}_proxy_token";
    }

    public function getSessionKey(): string
    {
        return "{$this->value}_proxy_key";
    }

    public function getSessionCredentialsKey(): string
    {
        return "{$this->value}_proxy_credentials";
    }
}
