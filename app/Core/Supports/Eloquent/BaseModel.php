<?php

namespace App\Core\Supports\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
   /**getQueryBuilder
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll()
    {
        return self::all();
    }

    public static function findByOrFail(array $filter, array $relations = [])
    {
        $query = self::applyFilters($filter);

        if (count($relations) > 0)
        {
            $query = $query->with($relations);
        }

        return $query->firstOrFail();
    }

    public static function findBy(array $filter, array $relations = []): self|null
    {
        $query = self::applyFilters($filter);

        if (count($relations) > 0)
        {
            $query = $query->with($relations);
        }

        return $query->first();
    }

    public static function getBy(array $filter = [], array $relations = [], int $limit = 0, array $sort = ['id', 'desc']): Collection
    {
        $query = self::makeQuery($filter, $relations, $limit, $sort);

        return $query->get();
    }

    public static function makeQuery(array $filter = [], array $relations = [], int $limit = 0, array $sort = ['id', 'desc']): Builder
    {
        $query = self::applyFilters($filter);

        if (count($relations) > 0)
        {
            $query = $query->with($relations);
        }

        if ($limit > 0)
        {
            $query = $query->limit($limit);
        }

        return $query->orderBy(...$sort);
    }

    protected static function applyFilters(array $filter): Builder
    {
        $query = self::query();
        foreach ($filter as $field => $value) {

            if (is_array($value))
            {
                [$field, $condition, $val] = $value;

                $query = match (strtoupper($condition)) {
                    'IN' => $query->whereIn($field, $val),
                    'NOT_IN' => $query->whereNotIn($field, $val),
                    'RELATION' => $query->whereRelation($field, ...$val),
                    'BETWEEN' => $query->whereBetween($field, $val),
                    'HAS' => $query->whereHas($field, $val),
                    default => $query->where($field, $condition, $val)
                };
            } else {
                $query = $query->where($field, $value);
            }
        }

        return $query;
    }

    public static function authorize(self $objectModel, $action = 'view', $guard = 'web')
    {
        if (auth()->guard($guard)->user()->can($action, $objectModel))
        {
            return true;
        }

        abort(403, 'Forbidden');
        // throw new HttpException(401, 'UNAUTHORIZED');
    }
}
