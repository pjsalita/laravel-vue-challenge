<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();

    public function find(string $slug);

    public function create(array $data);

    public function update(string $slug, array $data);

    public function delete(string $slug);
}
