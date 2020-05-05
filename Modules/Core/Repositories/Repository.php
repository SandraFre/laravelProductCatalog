<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\RepositoryContract;
use RuntimeException;

abstract class Repository implements RepositoryContract
{

    const DEFAULT_PER_PAGE = 15;
    const DEFAULT_ATTRIBUTE_FIELD = 'id';

    abstract public function model(): string;

    public function all(array $columns = ['*']): Collection
    {
        return $this->makeQuery()->get($columns);
    }

    public function find(int $id): ?Model
    {
        return $this->makeQuery()->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->makeQuery()->findOrFail($id);
    }

    public function pluck(string $column, ?string $key = null): Collection
    {
        return $this->makeQuery()->pluck($column, $key);
    }

    public function with(array $with = []): Builder
    {
        return $this->makeQuery()->with($with);
    }

    public function create(array $data): Model
    {
        return $this->makeQuery()->create($data);
    }

    public function paginate(int $perPage = self::DEFAULT_PER_PAGE, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->makeQuery()->paginate($perPage, $columns);
    }

    public function update(array $data, $attributeValue, string $attributeField = self::DEFAULT_ATTRIBUTE_FIELD): int
    {
        Arr::forget($data, [
            '_token',
            '_method',
        ]);

        return $this->makeQuery()->where($attributeField, '=', $attributeValue)
            ->update($data);
    }

    public function delete(int $id)
    {
        return $this->makeQuery()->where('id', '=', $id)
            ->delete();
    }

    final protected function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new RuntimeException('Class' . $this->model() . 'must be an instance of Illuminate\\Database\\Eloquent\\Model');
        }

        return $model;
    }

    final public function makeQuery(): Builder
    {
        return $this->makeModel()->newQuery();
    }
}
