<?php

namespace App\Core\Repositories\Proxy;

use App\Core\Repositories\EloquentRepositoryInterface;
use App\Models\Proxy;

interface ProxyRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchSelect(string $keyword = '', int $limit = 10);

    public function getByColumnsWithRelationsLimit(array $data, array $relations = [], $limit = 10);

    public function getListProxyMinPrice($fillter, $sort);

    public function getProxyBySlug($slug);

    public function getListProxyHomePage($fillter);
}