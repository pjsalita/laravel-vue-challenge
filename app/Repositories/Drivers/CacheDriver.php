<?php

namespace App\Repositories\Drivers;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CacheDriver implements RepositoryInterface
{
    protected $key;

    public function __construct($model)
    {
        $this->key = strtolower(class_basename($model));
    }

    public function all(): array
    {
        return Cache::get($this->key, []);
    }

    public function find($id, string $key = 'id'): mixed
    {
        return collect(Cache::get($this->key, []))->firstWhere($key, $id);
    }

    public function create(array $data): array
    {
        $items = Cache::get($this->key, []);
        $items[] = $data;

        Cache::put($this->key, $items);

        return $data;
    }

    public function update($id, array $data, string $key = 'id'): mixed
    {
        $items = Cache::get($this->key, []);
        $items = array_map(fn ($item) => $item[$key] === $id ? array_merge($item, $data) : $item, $items);

        return Cache::put($this->key, $items);
    }

    public function delete($id, string $key = 'id'): mixed
    {
        $items = Cache::get($this->key, []);
        $items = array_filter($items, fn ($item) => $item[$key] !== $id);

        return Cache::put($this->key, $items);
    }
}
