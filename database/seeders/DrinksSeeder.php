<?php

namespace Database\Seeders;

use App\Models\Drink;
use Illuminate\Database\Seeder;

class DrinksSeeder extends Seeder
{
    public function run(): void
    {
        $items = config('coffee-machine.default_drinks');

        foreach ($items as $item) {
            Drink::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
