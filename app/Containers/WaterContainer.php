<?php

namespace App\Containers;

class WaterContainer extends AbstractContainer
{
    public function __construct(float $capacityLiters, float $initialLiters)
    {
        parent::__construct('Water', 'L', $capacityLiters, $initialLiters);
    }

    public function convertToUnit(float $amount, string $unit): float
    {
        return match (strtolower($unit)) {
            'ml', 'mL' => round($amount / 1000, 3),
            default => $amount,
        };
    }
}
