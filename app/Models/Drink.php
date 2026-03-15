<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'water',
        'water_unit',
        'coffee',
        'coffee_unit',
        'active',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'water' => 'float',
            'coffee' => 'float',
            'active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
