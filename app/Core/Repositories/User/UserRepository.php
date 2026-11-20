<?php

namespace App\Core\Repositories\User;
use App\Core\Repositories\EloquentRepository;
use App\Core\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{

    public function getModel(){
        return User::class;
    }

    public function searchSelect(string $keyword = '', int $limit = 10): array
    {
        $Users = $this->model->select('id', 'name', 'phone', 'email')
        ->whereAny($this->model->getFillable(), 'like', "%$keyword%")
        ->limit($limit)
        ->get()
        ->map(function($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return $Users->toArray();
    }

}