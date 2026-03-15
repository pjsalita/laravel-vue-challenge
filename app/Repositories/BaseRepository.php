<?php

namespace App\Repositories;

class BaseRepository
{
    protected $repository;

    public function __construct($model)
    {
        $driver = config('coffee-machine.storage');

        $this->repository = RepositoryManager::make($model, $driver);
    }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function find($id, string $key = 'id'): mixed
    {
        return $this->repository->find($id, $key);
    }

    public function create(array $data): mixed
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data, string $key = 'id'): mixed
    {
        return $this->repository->update($id, $data, $key);
    }

    public function delete($id, string $key = 'id'): mixed
    {
        return $this->repository->delete($id, $key);
    }
}
