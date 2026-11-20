<?php

namespace App\Dto;

class ProxyStaticOrderData
{
    public string $provider;
    public int    $days;
    public int    $quantity;
    public string $protocolType;
    public ?string $location;
    public string $user;
    public string $password;
    public ?string $productId;

    public function __construct(array $payload)
    {
        $this->provider     = strtoupper($payload['provider']);
        $this->days         = (int) $payload['days'];
        $this->quantity     = (int) $payload['quantity'];
        $this->protocolType = strtolower($payload['protocolType']);
        $this->location     = $payload['location'] ?? null;
        $this->user         = $payload['user'];
        $this->password     = $payload['password'];
        $this->productId    = $payload['product_id'] ?? null;
    }
}