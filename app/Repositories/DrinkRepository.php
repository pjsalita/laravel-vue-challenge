<?php

namespace App\Repositories;

use App\Models\Drink;

class DrinkRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Drink::class);
    }

    public function getActive(): array
    {
        return collect($this->all())->where('active', true)->values()->all();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->find($slug, 'slug');
    }
}
