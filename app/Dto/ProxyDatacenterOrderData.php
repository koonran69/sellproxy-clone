<?php

namespace App\Dto;

class ProxyDatacenterOrderData
{
    public int    $unit;
    public int    $quantity;
    public string $protocol;
    public string $location;
    public string $provider;
    public string $user;
    public string $password;

    public function __construct(array $payload)
    {
        $this->unit         = (int) $payload['unit'];
        $this->quantity     = (int) $payload['quantity'];
        $this->protocol     = $payload['protocol'];
        $this->location     = $payload['location'];
        $this->provider     = $payload['provider'];
        $this->user         = $payload['user'];
        $this->password     = $payload['password'];
    }
}
