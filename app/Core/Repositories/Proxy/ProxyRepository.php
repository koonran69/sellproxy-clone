<?php

namespace App\Core\Repositories\Proxy;
use App\Core\Enums\ProxyStatus;
use App\Core\Repositories\EloquentRepository;
use App\Models\Attribute;
use App\Models\Proxy;
use App\Models\ProxyVariation;
use Illuminate\Support\Facades\DB;

class ProxyRepository extends EloquentRepository implements ProxyRepositoryInterface
{

    public function getModel()
    {
        return Proxy::class;
    }

    public function searchSelect(string $keyword = '', int $limit = 10): array
    {
        $users = $this->model->select('id', 'name', 'sub_title')
            ->whereAny($this->model->getFillable(), 'like', "%$keyword%")
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            });

        return $users->toArray();
    }

    public function getByColumnsWithRelationsLimit(array $data, array $relations = [], $limit = 10)
    {
        $this->getByQueryBuilder([], $relations);

        foreach ($data as $key => $value) {
            if ($key == 'name') {
                $this->instance = $this->instance->where($key, 'like', "%{$value}%");
            } else {
                $this->instance = $this->instance->where($key, $value);
            }
        }

        $this->instance = $this->instance->limit($limit)->get();
        return $this->instance;
    }

    public function getListProxyMinPrice($fillter, $sort) {
        $proxies = $this->model->with([
            'minVariation:id,proxy_id,price,price_promotion,duration,variation_id',
            'minVariation.variation:id,name,attr_id',
        ])->where('status', ProxyStatus::Available)->whereHas('minVariation');

        if($fillter['cate_id'] != 'all') {
            $proxies->where('category_id', $fillter['cate_id']);
        }

        switch ($sort) {
            case 'latest':
                $proxies->orderBy('created_at', 'desc');
                break;
            case 'priceLow':
                $proxies->orderBy('price_promotion', 'asc');
                break;
            case 'priceHigh':
                $proxies->orderBy('price_promotion', 'desc');
                break;
            case 'az':
                $proxies->orderBy('name_main', 'asc');
                break;
            case 'za':
                $proxies->orderBy('name_main', 'desc');
                break;
            case '09':
//                $proxies->orderByRaw('name_main REGEXP "^[0-9]" DESC')
//                    ->orderBy('name_main', 'asc');
                $proxies->orderByRaw('name_main COLLATE utf8mb4_bin ASC');
                break;
            default:
                $proxies->orderBy('name_main', 'asc');
                break;
        }

        $proxies = $proxies->get();

        return $proxies;
    }

    public function getProxyBySlug($slug) {
        $proxy = $this->model->with(['proxyVariations.variation.attribute'])
            ->where('proxies.slug', $slug)
            ->where("status", ProxyStatus::Available)
            ->first();

        if ($proxy) {
            $proxy->setRelation(
                'proxyVariations',
                $proxy->proxyVariations
                    ->sortBy(fn ($item) => $item->variation?->position ?? PHP_INT_MAX)
                    ->values()
            );
        }


        return $proxy;
    }

    public function getListProxyHomePage($fillter) {
        $proxies = $this->model->select('proxies.*')->with([
            'proxyVariations.variation',
        ]);
        $proxies->where('status', ProxyStatus::Available);

        if($fillter['cate_id'] != 'all') {
            $proxies->where('category_id', $fillter['cate_id']);
        }

        if($fillter['type_id'] != 'all') {
            $proxies->where('type_id', $fillter['type_id']);
        }

        if($fillter['keyword'] != 'all') {
            $proxies->where('name','like', '%' . $fillter['keyword'] . '%');
        }

        $proxies = $proxies->orderByRaw('name_main COLLATE utf8mb4_bin ASC')->get();

        return $proxies;
    }


}
