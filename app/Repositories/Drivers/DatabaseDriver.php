<?php

namespace App\Repositories\Drivers;

use App\Repositories\Contracts\RepositoryInterface;

class DatabaseDriver implements RepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = new $model;
    }

    public function all(): array
    {
        return $this->model->all()->toArray();
    }

    public function find($id, string $key = 'id'): mixed
    {
        return $this->model->where($key, $id)->first()->toArray();
    }

    public function create(array $data)
    {
        return $this->model->create($data)->toArray();
    }

    public function update($id, array $data, string $key = 'id'): void
    {
        $this->model->where($key, $id)->update($data);
    }

    public function delete($id, string $key = 'id'): void
    {
        $this->model->where($key, $id)->delete();
    }
}
