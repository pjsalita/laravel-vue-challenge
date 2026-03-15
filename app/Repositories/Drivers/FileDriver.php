<?php

namespace App\Repositories\Drivers;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Storage;

class FileDriver implements RepositoryInterface
{
    protected $key;

    protected $path;

    public function __construct($model)
    {
        $this->key = strtolower(class_basename($model));
        $this->path = "repositories/{$this->key}.json";
    }

    protected function read(): array
    {
        if (! Storage::exists($this->path)) {
            return [];
        }

        $content = Storage::get($this->path);

        return json_decode($content, true) ?? [];
    }

    protected function write(array $data): void
    {
        Storage::put($this->path, json_encode($data));
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
        $items = array_map(fn ($item) => $item[$key] === $id ? array_merge($item, $data) : $item, $items);
        $this->write($items);

        return collect($items)->firstWhere($key, $id);
    }

    public function delete($id, string $key = 'id'): mixed
    {
        $items = $this->read();
        $items = array_filter($items, fn ($item) => $item[$key] !== $id);
        $this->write(array_values($items));

        return true;
    }
}
