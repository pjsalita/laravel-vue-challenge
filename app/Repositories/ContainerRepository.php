<?php

namespace App\Repositories;

use App\Containers\AbstractContainer;
use App\Containers\CoffeeContainer;
use App\Containers\WaterContainer;
use App\Enums\Container as EnumsContainer;
use App\Models\Container;

class ContainerRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Container::class);
    }

    public function getContainer(EnumsContainer $type): AbstractContainer
    {
        $container = $this->find($type->value, 'type');

        return match ($type) {
            EnumsContainer::WATER => new WaterContainer($container['capacity'], $container['current']),
            EnumsContainer::COFFEE => new CoffeeContainer($container['capacity'], $container['current']),
        };
    }
}
