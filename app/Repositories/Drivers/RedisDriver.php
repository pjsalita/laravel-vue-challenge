<?php

namespace App\Repositories\Drivers;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisDriver implements RepositoryInterface
{
    protected $key;

    public function __construct($model)
    {
        $this->key = strtolower(class_basename($model));
    }

    protected function read(): array
    {
        $value = Redis::get($this->key);

        return $value ? (json_decode($value, true) ?? []) : [];
    }

    protected function write(array $data): void
    {
        Redis::set($this->key, json_encode($data));
    }

    public function all(): array
    {
        return $this->read();
    }

    public function find($id, string $key = 'id'): mixed
    {
        return collect($this->read())->firstWhere($key, $id);
    }

    public function create(array $data): array
    {
        $items = $this->read();
        $items[] = $data;
        $this->write($items);

        return $data;
    }

    public function update($id, array $data, string $key = 'id'): mixed
    {
        $items = $this->read();
        $items = array_map(fn ($item) => ($item[$key] ?? $item[$key]) == $id ? array_merge($item, $data) : $item, $items);
        $this->write($items);

        return collect($items)->firstWhere($key, $id);
    }

    public function delete($id, string $key = 'id'): mixed
    {
        $items = $this->read();
        $items = array_values(array_filter($items, fn ($item) => ($item[$key] ?? $item[$key]) !== $id));
        $this->write($items);

        return true;
    }
}
