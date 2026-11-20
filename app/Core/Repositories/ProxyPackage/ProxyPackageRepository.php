<?php

namespace App\Core\Repositories\ProxyPackage;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Repositories\EloquentRepository;
use App\Core\Repositories\Proxy\ProxyRepositoryInterface;
use App\Models\Order;
use App\Models\Proxy;
use App\Models\ProxyPackage;
use App\Models\ProxyVariation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProxyPackageRepository extends EloquentRepository implements ProxyPackageRepositoryInterface
{
    public function getModel(){
        return ProxyPackage::class;
    }
}
