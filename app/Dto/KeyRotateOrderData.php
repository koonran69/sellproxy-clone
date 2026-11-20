<?php

namespace App\Dto;

class KeyRotateOrderData
{
    public int    $unit;
    public int    $quantity;
    public string $typeUnit;
    public string $user;
    public string $password;

    public function __construct(array $payload)
    {
        $this->unit         = (int) $payload['unit'];
        $this->quantity     = (int) $payload['quantity'];
        $this->typeUnit     = $payload['typeUnit'];
        $this->user         = $payload['user'];
        $this->password     = $payload['password'];
    }
}
