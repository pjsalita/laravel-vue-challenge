<?php

namespace App\Repositories;

use App\Repositories\Drivers\CacheDriver;
use App\Repositories\Drivers\DatabaseDriver;
use App\Repositories\Drivers\FileDriver;
use App\Repositories\Drivers\RedisDriver;

class RepositoryManager
{
    public static function make($model, $driver = 'database')
    {
        return match ($driver) {
            'database' => new DatabaseDriver($model),
            'file' => new FileDriver($model),
            'cache' => new CacheDriver($model),
            'redis' => new RedisDriver($model),
            default => new DatabaseDriver($model),
        };
    }
}
