<?php

namespace App\Containers;

class CoffeeContainer extends AbstractContainer
{
    public function __construct(float $capacityGrams, float $initialGrams)
    {
        parent::__construct('Coffee', 'g', $capacityGrams, $initialGrams);
    }
}
