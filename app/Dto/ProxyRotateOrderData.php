<?php

namespace App\Dto;

class ProxyRotateOrderData
{
    public int    $unit;
    public int    $quantity;
    public string $user;
    public string $password;
    public int $interval;
    public int $auto;
    public string $typeUnit;
    public ?string $productId;

    public function __construct(array $payload)
    {
        $this->unit         = (int) $payload['unit'];
        $this->quantity     = (int) $payload['quantity'];
        $this->user         = $payload['user'];
        $this->password     = $payload['password'];
        $this->auto     = $payload['auto'];
        $this->interval     = $this->auto ? ($payload['interval'] >= 1 ? $payload['interval'] : 30) : 0;
        $this->typeUnit     = $payload['typeUnit'];
        $this->productId    = $payload['product_id'] ?? null;
    }
}
