<?php

namespace Database\Seeders;

use App\Models\Container;
use Illuminate\Database\Seeder;

class ContainersSeeder extends Seeder
{
    public function run(): void
    {
        $items = config('coffee-machine.default_containers');

        foreach ($items as $item) {
            Container::updateOrCreate(
                ['type' => $item['type']],
                $item
            );
        }
    }
}
