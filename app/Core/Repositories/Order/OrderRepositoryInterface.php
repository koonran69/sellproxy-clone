<?php

namespace App\Core\Repositories\Order;

use App\Core\Repositories\EloquentRepositoryInterface;

interface OrderRepositoryInterface extends EloquentRepositoryInterface
{
    public function createOrder($data);
}