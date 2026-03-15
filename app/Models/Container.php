<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $fillable = [
        'type',
        'name',
        'current',
        'capacity',
        'unit',
    ];

    protected function casts(): array
    {
        return [
            'current' => 'float',
            'capacity' => 'float',
        ];
    }
}
