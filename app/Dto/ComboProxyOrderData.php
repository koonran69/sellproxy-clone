<?php

namespace App\Dto;

class ComboProxyOrderData
{
    public string    $id;
    public int    $unit;
    public string $type_unit;
    public int    $quantity;
    public string $protocol;
    public ?string $location;
    public ?string $provider;
    public string $user;
    public string $password;
    public string $paymentMethod;

    public function __construct(array $payload)
    {
        $this->id            = $payload['id'] ?? null;
        $this->unit          = (int) ($payload['unit'] ?? 1);
        $this->type_unit     = $payload['type_unit'] ?? null;
        $this->quantity      = (int) ($payload['quantity'] ?? 1);
        $this->protocol      = $payload['protocol'] ?? 'HTTP';
        $this->location      = $payload['location'] ?? null;
        $this->provider      = $payload['provider'] ?? null;
        $this->user          = $payload['user'] ?? 'random';
        $this->password      = $payload['password'] ?? 'random';
        $this->paymentMethod = $payload['payment_method'] ?? 'WALLET';
    }
}
